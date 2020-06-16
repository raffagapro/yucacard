$(document).ready(function() {

  //function for closing other tabs
  $("#v-pills-products-tab").click(function(){
    window.location.replace("dashboard.php?tab=product");
  })

  //function for closing other tabs
  $("#v-pills-reservations-tab").click(function(){
    window.location.replace("dashboard.php?tab=res");
  })

  //function for closing other tabs
  $("#v-pills-addProduct-tab").click(function(){
    window.location.replace("dashboard.php?tab=addP");
  })
});
