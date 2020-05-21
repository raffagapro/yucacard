<?php
require_once '../includes/header.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //return json format
  header('Content-Type: application/json');
  //array where we save data to be send back to ajax
  $return = [];

  //grabbing info from $_POST and filtering them
  $aff_id = (int)$_POST["affi"];
  $company_name = filter_var($_POST["company_name"], FILTER_SANITIZE_STRING);
  $contact_name = filter_var($_POST["contact_name"], FILTER_SANITIZE_STRING);
  $last_name1 = filter_var($_POST["last_name1"], FILTER_SANITIZE_STRING);
  $last_name2 = filter_var($_POST["last_name2"], FILTER_SANITIZE_STRING);
  $job_title = filter_var($_POST["job_title"], FILTER_SANITIZE_STRING);
  $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
  $phone = filter_var($_POST["phone"], FILTER_SANITIZE_NUMBER_INT);
  $new_pw = $_POST["new_pw"];
  $comfirmed_pw = $_POST["comfirmed_pw"];
  $status = (int)$_POST["status"];
  $state = (int)$_POST["state"];
  $city = (int)$_POST["city"];

  //passing info to DB
  $affi_OBJ = DBX::GetAffByID($aff_id);
  $affi_user = DBX::GetUSERbyID($affi_OBJ['user_id']);

  //add password matching
  if ($new_pw != $comfirmed_pw) {
    $return['error'] = "Passwords did not match!";
    //checks for invalid characters in the password
  } elseif (!preg_match("/^[a-zA-Z0-9\$!#%*]*$/", $new_pw)) {
    $return['error'] = "Passwords must be letters,numbers, and (!#$%*). Case sensitive!";
    //if all is good, prepare data to be send to DB
  } elseif ($city == "z") {
    $return['error'] = "You need to select a State with a valid City";
  }else {
    DBX::SetPasswordByID($affi_user['user_id'], $new_pw);
    DBX::SetAffiCityState($aff_id, $state, $city);
    DBX::SetAffiStatus($aff_id, $status);
    $affiModified = DBX::ModifyAffi(
      $affi_user['user_id'],
      $aff_id,
      $company_name,
      $job_title,
      $contact_name,
      $last_name1,
      $last_name2,
      $email,
      $phone
    );

    if (!$affiModified) {
      //checks to see if there was an errro
      $return['error'] = "Error 152DB no se creo el registro. Reportar al ADMIN!";
    } else {
      $return['redirect'] = 'admin_panel.php?tab=affi&message=success!';
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
