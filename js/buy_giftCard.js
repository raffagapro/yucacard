$(document).ready(function() {

  //function for subbmiting the form
  $("#submit_buy_gift_btn").click(function(event) {
    //prevent de button to submit ormallly
    event.preventDefault();

    //creates object to be pass to ajax
    var dataObj = {
      buyer_name: $("input[name='nombre_buyer']").val().toLowerCase(),
      buyer_name2: $("input[name='apellido1_buyer']").val().toLowerCase(),
      buyer_name3: $("input[name='apellido2_buyer']").val().toLowerCase(),
      buyer_phone: phoneCleaner($("input[name='phone_buyer']").val()),
      buyer_email: $("input[name='email_buyer']").val(),
      price: $("#product_price option:selected").attr('value'),
      gift_name: $("input[name='nombre_gift']").val().toLowerCase(),
      gift_name2: $("input[name='apellido1_gift']").val().toLowerCase(),
      gift_name3: $("input[name='apellido2_gift']").val().toLowerCase(),
      gift_email: $("input[name='email_gift']").val(),
      gift_note: $("#gift_note").val()
    };

    //Validation
    //for gift info validation purpuses
    var gift_info = true;

    if (dataObj.buyer_name == "") {
      sendError("Name missing!");
    } else if (dataObj.buyer_name2 == "") {
      sendError("Last Name missing!");
    } else if (dataObj.buyer_name3 == "") {
      sendError("Second Last Name missing!");
    } else if (dataObj.buyer_phone == "") {
      sendError("Phone missing!");
    } else if (Number.isNaN(parsedPhone = parseInt(dataObj.buyer_phone))) {
      sendError("Phone can only contain letters");
    }else if (dataObj.buyer_email == "") {
      sendError("Email missing!");
    } else if (isValidEmailAddress(dataObj.buyer_email) == false) {
      sendError("Invalid email format!");
    } else if (dataObj.price == "z") {
      sendError("You need to select a price!");
    } else {
      //checks to see if giftCard is a gift
      if (dataObj.gift_name != "") {
        if (dataObj.gift_name2 == "") {
          sendError("Recipient Last Name missing!");
          gift_info = false;
        } else if (dataObj.gift_name3 == "") {
          sendError("Recipient Last Name2 missing!");
          gift_info = false;
        } else if (dataObj.gift_email == "") {
          sendError("Recipient Email missing!");
          gift_info = false;
        } else if (isValidEmailAddress(dataObj.gift_email) == false) {
          sendError("Invalid Recipient email format!");
          gift_info = false;
        }
      }
      //checks to see if there was any errors with gift user info
      if (!gift_info) {
        //leave empty erro was already passed in validation
      } else {
        //si la validacion JS no falla corre AJAX
        $.ajax({
          url: 'int/buy_giftCard.int.php',
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
