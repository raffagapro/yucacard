<?php
require_once '../includes/header.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //return json format
  header('Content-Type: application/json');
  //array where we save data to be send back to ajax
  $return = [];

  //grabbing info from $_POST and filtering them
  $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
  $last_name1 = filter_var($_POST["last_name1"], FILTER_SANITIZE_STRING);
  $last_name2 = filter_var($_POST["last_name2"], FILTER_SANITIZE_STRING);
  $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
  $phone = filter_var($_POST["phone"], FILTER_SANITIZE_NUMBER_INT);

  //searches add product
  $affiModified = DBX::ModifyUser(
    $_SESSION['user_id'],
    $name,
    $last_name1,
    $last_name2,
    $email,
    $phone
  );

  if (!$affiModified) {
    //checks to see if there was an errro
    $return['error'] = "Error 152DB no se creo el registro. Reportar al ADMIN!";
  } else {
    $return['redirect'] = 'admin_panel.php?message=success!';
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
