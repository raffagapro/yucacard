$(document).ready(function() {

  //function for subbmiting the form
  $("#submitAddBnt").click(function(event) {
    //prevent de button to submit ormallly
    event.preventDefault();

    //creates object to be pass to ajax
    var dataObj = {
      product_name: $("input[name='product_name']").val().toLowerCase(),
      product_type: $("#product_type option:selected").attr('value'),
      product_price: $("#product_price option:selected").attr('value'),
      product_category: $("#product_category option:selected").attr('value'),
      address1: $("input[name='address1']").val().toLowerCase(),
      address2: $("input[name='address2']").val().toLowerCase(),
      lat: $("input[name='lat']").val(),
      lon: $("input[name='lon']").val(),
      email_reservations: $("input[name='email_reservations']").val(),
      phone_reservations: phoneCleaner($("input[name='phone_reservations']").val()),
      product_desc: $("#product_desc").val()
    };

    //Validation
    if (dataObj.product_name == "") {
      sendError("Product Name missing!");
    } else if (dataObj.product_type == "z") {
      sendError("Select Product Type!");
    }else if (dataObj.product_category == "z") {
      sendError("Select a Category!");
    }else if (dataObj.product_price == "z") {
      sendError("Select a Price!");
    } else if (dataObj.address1 == "") {
      sendError("Address missing!");
    } else if (dataObj.lat == "") {
      sendError("Latitud missing!");
    } else if (dataObj.lon == "") {
      sendError("Longitute missing!");
    } else if (dataObj.email_reservations == "") {
      sendError("Email missing!");
    } else if (isValidEmailAddress(dataObj.email_reservations) == false) {
      sendError("Invalid email format!");
    } else if (dataObj.phone_reservations == "") {
      sendError("Phone missing!");
    } else if (Number.isNaN(parsedPhone = parseInt(dataObj.phone_reservations))) {
      sendError("Phone can only contain letters");
    } else if (dataObj.product_desc == "") {
      sendError("Description missing!");
    } else {

      //si la validacion JS no falla corre AJAX
      $.ajax({
        url: 'int/add_product.int.php',
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



  });

  //function for formating phone as they type
  //NEED REFINING number 3 gets delete with number 4 to avoid being stuck with ()
  //when you delete last number () remains until you delete one moretime
  $("input[name='phone_reservations']").on("keyup", function(event){
    var tempPhone = $("input[name='phone_reservations']").val();

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
    $("input[name='phone_reservations']").val(tempPhone);
  })

  $("#add_new_product_tab_jumper").click(function(event) {
    $("#v-pills-addProduct-tab").click();
  });

});
