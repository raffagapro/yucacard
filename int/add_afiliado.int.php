<?php
require_once '../includes/header.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //return json format
  header('Content-Type: application/json');
  //array where we save data to be send back to ajax
  $return = [];

  //grabbing info from $_POST and filtering them
  include "add_user_insert.int.php";
  $stateID = (int)$_POST["state"];
  $company_name = filter_var($_POST["company_name"], FILTER_SANITIZE_STRING);
  //extra  sanitacioin
  $company_name = cleanString($company_name);
  //checks to see if the city was passed manually
  $job_title = filter_var($_POST["job_title"], FILTER_SANITIZE_STRING);
  //extra  sanitacioin
  $job_title = cleanString($job_title);
  //checks to see if the city was passed manually
  $city = (int)$_POST["city"];
  if ($_POST["manualCity"] == "true") {
    $city = filter_var($_POST["city"], FILTER_SANITIZE_STRING);
    //extra  sanitacioin
    $city = cleanString($city);
  }

  //add user to DB
  if (!$success) {
    //checks to see if there was already an error reported
    if ($return['error'] == '') {
      $return['error'] = "Error 152DB no se creo el registro. Reportar al ADMIN!";
    }
  //if the user was added success fully
  } else {
    //grabs recently added user
    $userFound = DBX::GetUSERbyEmail($email);
    //set access level to afiliado
    DBX::SetAccessByID($userFound["user_id"], 1);
    //checks to see if city was input manually
    if ($_POST["manualCity"] == "true") {
      $affFound = DBX::AddAffil($userFound["user_id"], $job_title, $company_name, $stateID, $city, true);
    } else {
      $affFound = DBX::AddAffil($userFound["user_id"], $job_title, $company_name, $stateID, $city, false);
    }

    //checks to see if affiliate was added succefully
    if (!$affFound) {
      $return['error'] = "Error 153DB no se creo el registro. Reportar al ADMIN!";
    } else {
      //save uder id and access level to SESSION ETC
      $_SESSION['user_id'] = $userFound["user_id"];
      $_SESSION['access'] = $userFound["access_level"];
      //grab the affilated ID
      $affFound = DBX::GetAffByUserID($_SESSION['user_id']);
      if ($affFound) {
        $_SESSION['aff_id'] = $affFound["affi_id"];
      }
      $return['redirect'] = 'add_product_form.php?message=success!';
    }
  }


  //information gets send back to ajax
  echo json_encode($return, JSON_PRETTY_PRINT);
  exit;
} else {
  // if they didnt arrived to the page by the POST method it kills script
  exit('Invalid URL');
}

//$return['redirect'] = 'dashboard.php?message='.$len[33].'!&tab=mu'
?>
