$(document).ready(function() {
  //function for subbmiting the form
  $(".submitAffAdmin").click(function(event) {
    //prevent de button to submit ormallly
    event.preventDefault();

    //grab affi id
    var affi_id = $(this).attr('id');
    affi_id = affi_id.replace("admAfii", "");

    //set up var to target correct modal error message
    var product = "affi"+affi_id;

    //creates object to be pass to ajax
    var dataObj = {
      affi: affi_id,
      company_name: $('#company_name'+affi_id).val().toLowerCase(),
      contact_name: $('#contact_name'+affi_id).val().toLowerCase(),
      last_name1: $('#affi_last_name1'+affi_id).val().toLowerCase(),
      last_name2: $('#affi_last_name2'+affi_id).val().toLowerCase(),
      email: $('#affi_email'+affi_id).val().toLowerCase(),
      phone: $('#affi_phone'+affi_id).val(),
      job_title: $('#job_title'+affi_id).val().toLowerCase(),
      state: $("#affi_state"+affi_id+" option:selected").attr('value'),
      city: $("#affi_city"+affi_id+" option:selected").attr('value'),
      new_pw: $('#affi_new_pw'+affi_id).val(),
      comfirmed_pw: $('#affi_confirm_pw'+affi_id).val(),
      status: $("#affi_status"+affi_id+" option:selected").attr('value')
    };

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
    } else if (dataObj.new_pw != dataObj.comfirmed_pw) {
      sendErrorModal("Passwords did not match!", product);
    } else if (dataObj.city == "z" ) {
      sendErrorModal("City needs to be added to DB!!", product);
    }else {

      //si la validacion JS no falla corre AJAX
      $.ajax({
        url: 'int/modify_affi_admin_panel.int.php',
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
        //console.log("always");
        //console.log(dataObj);
        //console.log(data);
      });
    }
  });
});
