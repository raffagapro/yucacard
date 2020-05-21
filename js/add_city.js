$(document).ready(function() {

  //function for subbmiting the form
  $("#add_city_submit_btn").click(function(event) {
    //prevent de button to submit ormallly
    event.preventDefault();

    //creates object to be pass to ajax
    var dataObj = {
      state: $("#state option:selected").attr('value'),
      city: $("input[name='city']").val().toLowerCase(),
    };

    //Validation
    if (dataObj.city == "") {
      sendError("New City missing!");
    } else {
      //si la validacion JS no falla corre AJAX
      $.ajax({
        url: 'int/add_city.int.php',
        type: 'POST',
        dataType: 'json',
        data: dataObj,
        async: true
      })
      .done(function(data) {
        //checks to see if there was a VALIDATION error
        if (data.error != undefined) {
          sendError(data.error);
        }else {
          $("#errorMessage").empty().addClass('hidden');
          window.location = data.redirect;
        }
        console.log("success");
      })
      .fail(function(e) {
        console.log("error");
        console.log(e.responseText);
      })
      .always(function(data) {
        console.log(dataObj);
        console.log(data);
      });
    }

  });
});
