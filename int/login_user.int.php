<?php
require_once '../includes/header.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //return json format
  header('Content-Type: application/json');
  //array where we save data to be send back to ajax
  $return = [];

  //grabbing info from $_POST and filtering them
  $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
  $pw = $_POST["pw"];

  //checks to see if email already exists
  $userFound = DBX::GetUSERbyEmail($email);

  //heck to see if we got a match
  if ($userFound) {
    //check to see if password is correct
    if (password_verify($pw, $userFound["password"])) {
      //save uder id and access level to SESSION ETC
      $_SESSION['user_id'] = $userFound["user_id"];
      $_SESSION['access'] = $userFound["access_level"];
      //checks to see if there is an affilated ID
      $affFound = DBX::GetAffByUserID($_SESSION['user_id']);
      if ($affFound) {
        $_SESSION['aff_id'] = $affFound["affi_id"];
      }
      //redirect to dashboard or admin panel
      if ($_SESSION['access'] == 0) {
        $return['redirect'] = 'admin_panel.php';
      } else {
        $return['redirect'] = 'dashboard.php';
      }
    } else {
      $return['error'] = "Password incorrect!";
    }
  }else {
    $return['error'] = "Email not found!";
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
