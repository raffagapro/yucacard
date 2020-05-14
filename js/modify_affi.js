$(document).ready(function() {


  //function for subbmiting the form
  $("#submitAff").click(function(event) {
    //prevent de button to submit ormallly
    event.preventDefault();

    //set up var to target correct modal error message
    var product = "affi";

    //creates object to be pass to ajax
    var dataObj = {
      company_name: $('#company_name').val(),
      contact_name: $('#contact_name').val(),
      last_name1: $('#last_name1').val(),
      last_name2: $('#last_name2').val(),
      job_title: $('#job_title').val(),
      email: $('#affi_email').val(),
      phone: $('#affi_phone').val(),
    };

    //console.log(dataObj);


    //Validation
    if (dataObj.company_name == "") {
      sendErrorModal("Company Name missing!", product);
    } else if (dataObj.contact_name == "") {
      sendErrorModal("Contact Name missing!", product);
    } else if (dataObj.last_name1 == "") {
      sendErrorModal("Last Name missing!", product);
    } else if (dataObj.last_name2 == "") {
      sendErrorModal("Last Name2 missing!", product);
    } else if (dataObj.job_title == "") {
      sendErrorModal("Job Title missing!", product);
    } else if (dataObj.email == "") {
      sendErrorModal("Email missing!", product);
    } else if (isValidEmailAddress(dataObj.email) == false) {
      sendErrorModal("Invalid email format!", product);
    } else if (dataObj.phone == "") {
      sendErrorModal("Phone missing!", product);
    } else if (Number.isNaN(parseInt(dataObj.phone))) {
      sendErrorModal("Phone can only contain letters", product);
    } else {

      //si la validacion JS no falla corre AJAX
      $.ajax({
        url: 'int/modify_affi.int.php',
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
