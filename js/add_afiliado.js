$(document).ready(function() {

  //function for changing city options when changin this.state
  $("#state").on("change", function(){

    //grab state id and gets list of cities
    var dataObj = {
      state: $("#state option:selected").attr('value')
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
        $("#city").empty().append(
          "<option value='z'>No Cities</option>"
          );
      } else {
        $("#city").empty();
        $("#city").append("<option value='z'>Select City</option>");
        for (var i = 0; i < data.cities.length; i++) {
          //ignores city 0, no city
          if (data.cities[i][0] != 0) {
            $("#city").append(
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


  //function for subbmiting the form
  $("#submitButton").click(function(event) {
    //prevent de button to submit ormallly
    event.preventDefault();

    //check to if the city was input manually
    var tempCity = $("input[name='other']").val().toLowerCase()
    var manualCity = true;
    if (tempCity == "") {
      tempCity = $("#city option:selected").attr('value');
      manualCity = false;
    }

    //creates object to be pass to ajax
    var dataObj = {
      company_name: $("input[name='nombre_company']").val().toLowerCase(),
      state: $("#state option:selected").attr('value'),
      city: tempCity,
      manualCity: manualCity,
      job_title: $("input[name='puesto']").val().toLowerCase(),
      name: $("input[name='nombre']").val().toLowerCase(),
      name2: $("input[name='apellido1']").val().toLowerCase(),
      name3: $("input[name='apellido2']").val().toLowerCase(),
      phone: phoneCleaner($("input[name='phone']").val()),
      email: $("input[name='email']").val(),
      pw: $("input[name='password']").val(),
      pw2: $("input[name='password2']").val()
    };

    //Validation
    if (dataObj.company_name == "") {
      sendError("Company Name missing!");
    } else if (dataObj.state == "z") {
      sendError("Select a State!");
    }else if (dataObj.city == "z") {
      sendError("Select a City!");
    }else if (dataObj.name == "") {
      sendError("Name missing!");
    }else if (dataObj.name2 == "") {
      sendError("Last Name missing!");
    } else if (dataObj.name3 == "") {
      sendError("Second Last Name missing!");
    } else if (dataObj.job_title == "") {
      sendError("Job Title missing!");
    } else if (dataObj.phone == "") {
      sendError("Phone missing!");
    } else if (Number.isNaN(parsedPhone = parseInt(dataObj.phone))) {
      sendError("Phone can only contain letters");
    }else if (dataObj.email == "") {
      sendError("Email missing!");
    } else if (isValidEmailAddress(dataObj.email) == false) {
      sendError("Invalid email format!");
    } else if (dataObj.pw == "") {
      sendError("Password missing!");
    } else if (dataObj.pw.length < 1) {
      sendError("Password must be 8 characters or more!");
    }else if (dataObj.pw != dataObj.pw2) {
      sendError("Passwords did not match!");
    } else {
      //si la validacion JS no falla corre AJAX
      $.ajax({
        url: 'int/add_afiliado.int.php',
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
