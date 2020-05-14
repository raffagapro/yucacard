<?php
require_once '../includes/header.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //return json format
  header('Content-Type: application/json');
  //array where we save data to be send back to ajax
  $return = [];

  //grabbing info from $_POST and filtering them
  include "add_user_insert.int.php";

  //add user to DB
  if (!$success) {
    //checks to see if there was already an error reported
    if ($return['error'] == '') {
      $return['error'] = "Error 152DB no se creo el registro. Reportar al ADMIN!";
    }
  } else {
    $return['redirect'] = 'add_user_form.php?message=success!';
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
