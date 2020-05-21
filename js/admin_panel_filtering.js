$(document).ready(function(){
  //initialization for sear date filter
  var picker = new Litepicker({
  	element: document.getElementById('litepicker'),
    format: 'YYYY-MM-DD',
  	numberOfMonths: 2,
  	numberOfColumns: 2,
    singleMode: false,
    onShow: () => {
    }
  });

  //functions for sorting result asc and desc
  $(".asc_sort_btn").click(function(event){
    event.preventDefault();
    var tempURL = $(location).attr("href");
    tempURL = tempURL.replace('&sort=desc','');
    tempURL = tempURL.replace('&sort=asc','');
    tempURL = tempURL.replace('?sort=desc','');
    tempURL = tempURL.replace('?sort=asc','');

    if (tempURL.includes('?')) {
      window.location = tempURL+'&sort=asc';
    } else {
      window.location = tempURL+'?sort=asc';
    }

  })

  $(".desc_sort_btn").click(function(event){
    event.preventDefault();
    var tempURL = $(location).attr("href");
    tempURL = tempURL.replace('&sort=desc','');
    tempURL = tempURL.replace('&sort=asc','');
    tempURL = tempURL.replace('?sort=desc','');
    tempURL = tempURL.replace('?sort=asc','');

    if (tempURL.includes('?')) {
      window.location = tempURL+'&sort=desc';
    } else {

      window.location = tempURL+'?sort=desc';
    }
  })

  $(".clear_filters_btn").click(function(event){
    event.preventDefault();
    var tempURL = $(location).attr("href");
    //substract Tab variable
    if (tempURL.includes('tab=')) {
      tempURL = tempURL.split("tab=");
      tempURL = tempURL[1].split("&");
      var tab = "tab="+tempURL[0];
      //console.log(tab);
      //clear http
      tempURL = $(location).attr("href");
      tempURL = tempURL.split("?");
      tempURL = tempURL[0];
      //add tab variable
      tempURL += "?"+tab;
      //console.log(tempURL);
    }else {
      //clear http
      tempURL = $(location).attr("href");
      tempURL = tempURL.split("?");
      tempURL = tempURL[0];
      console.log(tempURL);
    }
    //redirect
    window.location = tempURL;

  })

})
