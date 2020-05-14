$(document).ready(function() {


  //function for subbmiting the form
  $(".product_mod_btn").click(function(event) {
    //prevent de button to submit ormallly
    event.preventDefault();
    var product = $(this).attr('id');

    //creates object to be pass to ajax
    var dataObj = {
      product_id: product,
      product_name: $('#product_name'+product).val(),
      product_type: $("#product_type"+product+" option:selected").attr('value'),
      product_category: $("#product_category"+product+" option:selected").attr('value'),
      address1: $("input[name='product_address1"+product+"']").val().toLowerCase(),
      address2: $("input[name='product_address2"+product+"']").val().toLowerCase(),
      lat: $("input[name='lat"+product+"']").val(),
      lon: $("input[name='lon"+product+"']").val(),
      email_reservations: $("input[name='email_reservations"+product+"']").val(),
      phone_reservations: phoneCleaner($("input[name='phone_reservations"+product+"']").val()),
      product_status: $("#product_status"+product+" option:selected").attr('value'),
      product_desc: $("#product_description"+product).val()
    };

    //console.log(dataObj);


    //Validation
    if (dataObj.product_name == "") {
      sendErrorModal("Product Name missing!", product);
    } else if (dataObj.address1 == "") {
      sendErrorModal("Address missing!", product);
    } else if (dataObj.lat == "") {
      sendErrorModal("Latitud missing!", product);
    } else if (dataObj.lon == "") {
      sendErrorModal("Longitude missing!", product);
    } else if (dataObj.email_reservations == "") {
      sendErrorModal("Reservation Email missing!", product);
    } else if (isValidEmailAddress(dataObj.email_reservations) == false) {
      sendErrorModal("Invalid email format!", product);
    } else if (dataObj.phone_reservations == "") {
      sendErrorModal("Reservation Phone missing!", product);
    } else if (Number.isNaN(parseInt(dataObj.phone_reservations))) {
      sendErrorModal("Phone can only contain letters", product);
    } else if (dataObj.product_desc == "") {
      sendErrorModal("Product Description missing!", product);
    }else {

      //si la validacion JS no falla corre AJAX
      $.ajax({
        url: 'int/modify_product.int.php',
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
