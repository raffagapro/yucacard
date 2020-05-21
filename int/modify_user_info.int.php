<?php
require_once '../includes/header.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //return json format
  header('Content-Type: application/json');
  //array where we save data to be send back to ajax
  $return = [];

  $userID = (int)$_POST['userID'];
  $access_level = (int)$_POST['access_level'];

  //grabbing info from $_POST and filtering them
  $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
  $last_name1 = filter_var($_POST["name2"], FILTER_SANITIZE_STRING);
  $last_name2 = filter_var($_POST["name3"], FILTER_SANITIZE_STRING);
  $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
  $phone = filter_var($_POST["phone"], FILTER_SANITIZE_NUMBER_INT);
  $new_pw = $_POST['pw'];
  $confirm_pw = $_POST['pw2'];

  //changes access level
  DBX::SetAccessByID($userID, $access_level);
  //changes password
  if ($new_pw != "") {
    if (strlen($new_pw) < 8) {
      $return['error'] = "Password must be 8 characters or more!";
    } elseif ($new_pw != $confirm_pw) {
      $return['error'] = "New Password does not match!";
    }elseif (!preg_match("/^[a-zA-Z0-9\$!#%*]*$/", $new_pw)) {
      $return['error'] = "Passwords must be letters,numbers, and (!#$%*). Case sensitive!";
    }else {
      //Hashed Password
      $hashed_pw = password_hash($new_pw, PASSWORD_DEFAULT);
      // save new password to the DB
      $passwordSaved = DBX::SetPasswordByID($userID, $hashed_pw);
    }
  }
  $UserModified = DBX::ModifyUser(
    $userID,
    $name,
    $last_name1,
    $last_name2,
    $email,
    $phone
  );

  if (!$UserModified) {
    //checks to see if there was an errro
    $return['error'] = "Error 152DB no se creo el registro. Reportar al ADMIN!";
  } else {
    $return['redirect'] = 'admin_panel.php?tab=user&message=success!';
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
