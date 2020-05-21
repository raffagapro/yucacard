$(document).ready(function() {
  //function for subbmiting ADMIN info the form
  $("#submitAdminProfile").click(function(event) {
    //prevent de button to submit ormallly
    event.preventDefault();

    //set up var to target correct modal error message
    var product = "AdminPro";

    //creates object to be pass to ajax
    var dataObj = {
      name: $('#name').val().toLowerCase(),
      last_name1: $('#last_name1').val().toLowerCase(),
      last_name2: $('#last_name2').val().toLowerCase(),
      email: $('#email').val(),
      phone: $('#phone').val(),
    };

    //console.log(dataObj);

    //Validation
    if (dataObj.name == "") {
      sendErrorModal("Name missing!", product);
    } else if (dataObj.last_name1 == "") {
      sendErrorModal("Last Name missing!", product);
    } else if (dataObj.last_name2 == "") {
      sendErrorModal("Last Name2 missing!", product);
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
        url: 'int/modify_admin_info.int.php',
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

  //funcion for changin the city when the state is changed
  $(".affi_statez").on("change", function(){

    var affi_id = $(this).attr('id');
    affi_id = affi_id.replace("affi_state", "");

    //grab state id and gets list of cities
    var dataObj = {
      state: $("#affi_state"+affi_id+" option:selected").attr('value')
    };

    //corre AJAX
    $.ajax({
      url: 'int/get_cities.int.php',
      type: 'POST',
      dataType: 'json',
      data: dataObj,
      async: true
    })
    .done(function(data) {
      //checks to see if there was a VALIDATION error
      if (!data.cities) {
        $("#affi_city"+affi_id).empty().append(
          "<option value='z'>No Cities</option>"
          );
      } else {
        $("#affi_city"+affi_id).empty();
        $("#affi_city"+affi_id).append("<option value='z'>Select City</option>");
        for (var i = 0; i < data.cities.length; i++) {
          //ignores city 0, no city
          if (data.cities[i][0] != 0) {
            $("#affi_city"+affi_id).append(
              "<option value='"+ data.cities[i][0] +"' class='text-capitalize'>"+ data.cities[i][1] + "</option>"
            );
          }
        }
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
  });

  //function for closing other tabs
  $("#res_btn").click(function(){
    $("#user_tab").removeClass('show');
    $("#affi_tab").removeClass('show');
    $("#product_tab").removeClass('show');
  })

  //function for closing other tabs
  $("#user_btn").click(function(){
    $("#reservations").removeClass('show');
    $("#affi_tab").removeClass('show');
    $("#product_tab").removeClass('show');
  })

  //function for closing other tabs
  $("#affi_btn").click(function(){
    $("#reservations").removeClass('show');
    $("#user_tab").removeClass('show');
    $("#product_tab").removeClass('show');
  })
});
