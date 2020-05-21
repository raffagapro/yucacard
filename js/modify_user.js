$(document).ready(function() {

  //function for subbmiting the form
  $(".submitUserProfile").click(function(event) {
    //prevent de button to submit ormallly
    event.preventDefault();

    var user_id = $(this).attr('id');
    user_id = user_id.replace("usr", "");

    var product = "UserMod"+user_id;

    //creates object to be pass to ajax
    var dataObj = {
      userID: user_id,
      name: $("#user_name"+user_id).val().toLowerCase(),
      name2: $("#user_last_name1"+user_id).val().toLowerCase(),
      name3: $("#user_last_name2"+user_id).val().toLowerCase(),
      email: $("#user_email"+user_id).val(),
      phone: phoneCleaner($("#user_phone"+user_id).val()),
      access_level: $("#user_access_level"+user_id+" option:selected").attr('value'),
      pw: $("#user_password"+user_id).val(),
      pw2: $("#user_comfirmed_pw"+user_id).val()
    };

    //Validation
    if (dataObj.name == "") {
      sendErrorModal("Name missing!", product);
    } else if (dataObj.name2 == "") {
      sendErrorModal("Last Name missing!", product);
    } else if (dataObj.name3 == "") {
      sendErrorModal("Second Last Name missing!", product);
    } else if (dataObj.phone == "") {
      sendErrorModal("Phone missing!", product);
    } else if (Number.isNaN(parsedPhone = parseInt(dataObj.phone))) {
      sendErrorModal("Phone can only contain letters", product);
    }else if (dataObj.email == "") {
      sendErrorModal("Email missing!", product);
    } else if (isValidEmailAddress(dataObj.email) == false) {
      sendErrorModal("Invalid email format!", product);
    } else if (dataObj.pw != dataObj.pw2) {
      sendErrorModal("Passwords did not match!", product);
    } else {
      //si la validacion JS no falla corre AJAX
      $.ajax({
        url: 'int/modify_user_info.int.php',
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

  //function for formating phone as they type
  //NEED REFINING number 3 gets delete with number 4 to avoid being stuck with ()
  //when you delete last number () remains until you delete one moretime
  $("input[name='phone']").on("keyup", function(event){
    var tempPhone = $("input[name='phone']").val();

    //string cleaning
    tempPhone = phoneCleaner(tempPhone);

    if (tempPhone.length > 0) {
      //if statement needs revision to avoid being stuck with deleting ()
      if (event.code === "Backspace" && tempPhone.length <= 3) {
        tempPhone = tempPhone.slice(0, tempPhone.length - 1);
      }
      if (tempPhone.length > 3) {
        if (tempPhone.length > 6) {
          //if more than 10 digits, deletes last one
          if (tempPhone.length > 10) {
            tempPhone = tempPhone.slice(0, tempPhone.length - 1);
          }
          //format for more than 6 digist
          var tempNum = tempPhone.slice(0, 3);
          var tempNum2 = tempPhone.slice(3, 6);
          var tempNum3 = tempPhone.slice(6, tempPhone.length);
          tempPhone = "(" + tempNum + ")" + tempNum2 + "-" + tempNum3;
        } else {
          //formats for more than 3 digits and les than 6
          var tempNum = tempPhone.slice(0, 3);
          var tempNum2 = tempPhone.slice(3, tempPhone.length);
          tempPhone = "(" + tempNum + ")" + tempNum2;
        }
      } else {
        //format for 1 to 3 digits
        tempPhone = "(" + tempPhone + ")";
      }
    }
    //returned the formated number
    $("input[name='phone']").val(tempPhone);
  })

  function phoneCleaner(number){
    number = number.replace("(", "");
    number = number.replace(")", "");
    number = number.replace("-", "");
    return number;
  }
});
