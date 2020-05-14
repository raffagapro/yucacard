$(document).ready(function() {


  //function for subbmiting the form
  $("#submitAdminPassword").click(function(event) {
    //prevent de button to submit ormallly
    event.preventDefault();

    //set up var to target correct modal error message
    var product = "affipass";

    //creates object to be pass to ajax
    var dataObj = {
      password: $('#admin_password').val(),
      new_password: $('#new_admin_password').val(),
      confirmed_password: $('#confirmed__admin_password').val(),
    };

    //console.log(dataObj);
    //Validation
    if (dataObj.password == "") {
      sendErrorModal("Current Password missing!", product);
    } else if (dataObj.new_password == "") {
      sendErrorModal("New Password missing!", product);
    } else if (dataObj.confirmed_password == "") {
      sendErrorModal("Confirm Password missing!", product);
    } else if (dataObj.new_password !== dataObj.confirmed_password) {
      sendErrorModal("New Password does not match!", product);
    }else {

      //si la validacion JS no falla corre AJAX
      $.ajax({
        url: 'int/modify_admin_pw.int.php',
        type: 'POST',
        dataType: 'json',
        data: dataObj,
        async: true
      })
      .done(function(data) {
        //checks to see if there was a VALIDATION error
        if (data.error != undefined) {
          sendErrorModal(data.error, product);
        }else {
          $("#errorMessage").empty().addClass('hidden');
          window.location = data.redirect;
        }
        //console.log("success");
      })
      .fail(function(e) {
        //console.log("error");
        //console.log(e.responseText);
      })
      .always(function(data) {
        //console.log(dataObj);
        //console.log(data);
      });
    }
  });
});
