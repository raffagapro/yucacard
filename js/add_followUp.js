$(document).ready(function() {

  //Function to pass giftcard id to the follow up
  $(".add_follow_up_modal").click(function(){
    var id = $(this).attr('id');
    id = id.substring(2, id.length);
    //console.log(id);
    $("#giftcard_id").val(id);
  })

  //function for subbmiting the form
  $("#submitFU").click(function(event) {
    //prevent de button to submit ormallly
    event.preventDefault();

    //set up var to target correct modal error message
    var card_id = $("#giftcard_id").val();
    var modal = 'FU';

    //creates object to be pass to ajax
    var dataObj = {
      giftcard_id: card_id,
      follow_up: $('#follow_up').val(),
      fu_type: $('#fu_type').val(),
    };

    //Validation
    if (dataObj.follow_up == "") {
      sendErrorModal("You need to enter a message!", modal);
    } else {

      $.ajax({
        url: 'int/add_followUp.int.php',
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
