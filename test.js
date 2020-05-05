on("submit", "form.js-login", function(event){
  event.preventDefault();

  var _form = $(this);
  var _error = $(".js-error", _form);

  var dataObj = {
    //email: $("input[name='email']", _form).val(),
    userName: $("input[name='userName']", _form).val(),
    password: $("input[type='password']", _form).val()
  };

  if (dataObj.password.length < 8) {
    _error
      .text("Your password must be 8 characters or longer!")
      .show();
    return false;
  }

  //after validation
  _error.hide();

  //running ajax
  $.ajax({
    type: 'POST',
    url: 'ajax/login.php',
    data: dataObj,
    datatype: 'json',
    async: true,
  })
  .done(function ajaxDone(data){
    //whatever data is
    if (data.redirect !== undefined) {
      window.location = data.redirect;
    }else if (data.error !== undefined) {
      _error
        .text(data.error)
        .show();
    }
  })
  .fail(function ajaxFailed(e){
    console.log('fail');
  })
  .always(function ajaxAlwaysDoThis(data){
    //always do
    console.log(data);
  })

  return false;
})
