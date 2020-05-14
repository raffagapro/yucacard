$(document).ready(function() {

  //function for subbmiting the form
  $("#submitButton").click(function(event) {
    //creates object to be pass to ajax
    var dataObj = {
      image: $('input[type=file]')[0].files[0]
    };

    //Validation
    if (dataObj.image == undefined) {
      sendError("No file selected!");
      //prevent de button to submit ormallly
      event.preventDefault();
    }


  });
});
