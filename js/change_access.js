$(document).ready(function() {

  //function for subbmiting the form
  $("#submitButton").click(function(event) {
    //prevent de button to submit ormallly
    event.preventDefault();

    //creates object to be pass to ajax
    var dataObj = {
      access_level: $("#access_level option:selected").attr('value'),
    };

    //Validation
    if (dataObj.access_level == "z") {
      sendError("Access Level not selected!");
    } else {
      //si la validacion JS no falla corre AJAX
      $.ajax({
        url: 'int/change_access.int.php',
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
