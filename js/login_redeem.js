$(document).ready(function() {

  //function for subbmiting the form
  $("#submitButton").click(function(event) {
    //prevent de button to submit ormallly
    event.preventDefault();

    //creates object to be pass to ajax
    var dataObj = {
      cardCode: $("input[name='cardCode']").val(),
      email: $("input[name='email']").val()
    };

    //Validation
    if (dataObj.cardCode == "") {
      sendError("Gift Card Number missing!");
    } else if (dataObj.cardCode.length < 10) {
      sendError("Gift Card Number is 10 characters!");
    } else if (dataObj.email == "") {
      sendError("Email missing!");
    } else if (isValidEmailAddress(dataObj.email) == false) {
      sendError("Invalid email format!");
    } else {
      //si la validacion JS no falla corre AJAX
      $.ajax({
        url: 'int/login_reedem.int.php',
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
