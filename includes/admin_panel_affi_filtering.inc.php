<?php
if (isset($_GET['search_affi'])) {
  //set the values to nothing si it doenst causes errors if there is no search
  $searchAffiName = "";
  $searchCOName = "";
  $searchProductName = "";
  $searchAffiState = "";
  $searchAffiCity = "";

  //checks to see if the values passed where empty, if not it assigned the passed search
  if (isset($_GET['search_contact_name'])) {
    $searchAffiName = $_GET['search_contact_name'];
  }
  if (isset($_GET['search_co_name'])) {
    $searchCOName = $_GET['search_co_name'];
  }
  if (isset($_GET['search_product_name'])) {
    $searchProductName = $_GET['search_product_name'];
  }
  if (isset($_GET['search_state'])) {
    $searchAffiState = $_GET['search_state'];
  }
  if (isset($_GET['search_city_selector'])) {
    $searchAffiCity = $_GET['search_city_selector'];
  }

  //chooses the right search function depending on the value input by the user
  if ($searchAffiName != "") {
    $affiliados = DBX::SearchAffisByContactName($_GET['search_contact_name']);
    if (isset($_GET['sort'])) {
      //adds functionality to the sorting buttons, by evaluating the values passing on get
      if ($_GET['sort'] == 'asc') {
        $affiliados = array_reverse($affiliados);
      }
    }
  }elseif ($searchCOName != "") {
    $affiliados = DBX::SearchAffisByCompanyName($_GET['search_co_name']);
    if (isset($_GET['sort'])) {
      if ($_GET['sort'] == 'asc') {
        $affiliados = array_reverse($affiliados);
      }
    }
  }elseif ($searchProductName != "") {
    $affiliados = DBX::SearchAffisByProductName($_GET['search_product_name']);
    if (isset($_GET['sort'])) {
      if ($_GET['sort'] == 'asc') {
        $affiliados = array_reverse($affiliados);
      }
    }
  }elseif ($searchAffiState != "") {
    $affiliados = DBX::GetAffaByStateID($_GET['search_state']);
    if (isset($_GET['sort'])) {
      if ($_GET['sort'] == 'asc') {
        $affiliados = array_reverse($affiliados);
      }
    }
  }elseif ($searchAffiCity != "") {
    $affiliados = DBX::GetAffaByCityID($_GET['search_city_selector']);
    if (isset($_GET['sort'])) {
      if ($_GET['sort'] == 'asc') {
        $affiliados = array_reverse($affiliados);
      }
    }
  }else {
    $affiliados = DBX::GetAllAffi();
    if (isset($_GET['sort'])) {
      if ($_GET['sort'] == 'asc') {
        $affiliados = array_reverse($affiliados);
      }
    }
  }
} else {
  $affiliados = DBX::GetAllAffi();
  if (isset($_GET['sort'])) {
    if ($_GET['sort'] == 'asc') {
      $affiliados = array_reverse($affiliados);
    }
  }
}
?>
