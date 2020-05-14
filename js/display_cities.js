$(document).ready(function() {

  //function for subbmiting the form
  $("#citiesButton").click(function(event) {
    //prevent de button to submit ormallly
    event.preventDefault();

    //creates object to be pass to ajax
    var dataObj = {
      state: $("#state option:selected").attr('value'),
    };

    //si la validacion JS no falla corre AJAX
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
        $("#cityRowsCont").empty().append(
          "<tr><th scope='row'>No</th><th>Cities</th></tr>"
          );
      } else {
        $("#cityRowsCont").empty();
        for (var i = 0; i < data.cities.length; i++) {
          //ignores city 0, no city
          if (data.cities[i][0] != 0) {
            $("#cityRowsCont").append(
              "<tr><th scope='row'>"+ data.cities[i][0] +"</th><th class='text-capitalize'>"+ data.cities[i][1] +"</th></tr>"
            );
          }
        }
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
  });
});
