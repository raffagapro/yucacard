$(document).ready(function() {


  //function for subbmiting the form
  $(".modify_giftcard").click(function(event) {
    //prevent de button to submit ormallly
    event.preventDefault();

    //set up var to target correct modal error message
    var card_id = $(this).attr('id');
    var valid_gift_info = true;

    //creates object to be pass to ajax
    var dataObj = {
      giftcard_id: card_id,
      user_name: $('#user_name'+card_id).val().toLowerCase(),
      user_lastName: $('#user_lastName'+card_id).val().toLowerCase(),
      user_lastName2: $('#user_lastName2'+card_id).val().toLowerCase(),
      user_phone: $('#user_phone'+card_id).val(),
      user_email: $('#user_email'+card_id).val(),
      gift_name: $('#gift_name'+card_id).val().toLowerCase(),
      gift_lastName: $('#gift_lastName'+card_id).val().toLowerCase(),
      gift_lastName2: $('#gift_lastName2'+card_id).val().toLowerCase(),
      gift_email: $('#gift_email'+card_id).val(),
      gift_note: $('#gift_note'+card_id).val(),
      state_id: $('#state'+card_id).val(),
      is_gift: $('#is_gift'+card_id).val(),
      status: $('#status'+card_id).val(),
      redeemed_product: $('#redeemed_product'+card_id).val(),
      price: $('#price'+card_id).val()
    };

    console.log(dataObj);
    //Validation
    if (dataObj.user_name == "") {
      sendErrorModal("Buyer Name missing!", card_id);
    } else if (dataObj.user_lastName == "") {
      sendErrorModal("Buyer Last Name missing!", card_id);
    } else if (dataObj.user_lastName2 == "") {
      sendErrorModal("Buyer Last Name2 missing!", card_id);
    } else if (dataObj.user_phone == "") {
      sendErrorModal("Buyer Phone missing!", card_id);
    } else if (Number.isNaN(parseInt(dataObj.user_phone))) {
      sendErrorModal("Buyer Phone can only contain letters", card_id);
    } else if (dataObj.user_email == "") {
      sendErrorModal("Buyer Email missing!", card_id);
    } else if (isValidEmailAddress(dataObj.user_email) == false) {
      sendErrorModal("Invalid Buyer Email format!", card_id);
    } else {
      //checks to see if giftcard is a gift
      if (dataObj.is_gift == 1) {
        if (dataObj.gift_name == "") {
          sendErrorModal("Recipient Name missing!", card_id);
          valid_gift_info = false;
        } else if (dataObj.gift_lastName == "") {
          sendErrorModal("Recipient Last Name missing!", card_id);
          valid_gift_info = false;
        } else if (dataObj.gift_lastName2 == "") {
          sendErrorModal("Recipient Last Name2 missing!", card_id);
          valid_gift_info = false;
        } else if (dataObj.gift_email == "") {
          sendErrorModal("Recipient Email missing!", card_id);
          valid_gift_info = false;
        } else if (isValidEmailAddress(dataObj.gift_email) == false) {
          sendErrorModal("Invalid Recipient Email format!", card_id);
          valid_gift_info = false;
        }
      }
      //validates if there was any error with the gift info
      if (!valid_gift_info) {
        //leave it blank since error was already sent
      } else {
        //si la validacion JS no falla corre AJAX
        $.ajax({
          url: 'int/modify_giftcard.int.php',
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
    }
  });
});
