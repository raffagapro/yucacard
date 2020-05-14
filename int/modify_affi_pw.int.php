<?php
require_once '../includes/header.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //return json format
  header('Content-Type: application/json');
  //array where we save data to be send back to ajax
  $return = [];

  //grabbing info from $_POST and filtering them
  $pw = $_POST["password"];
  $new_pw = $_POST["new_password"];
  $confirm_pw = $_POST["confirmed_password"];

  //grabs the user info
  $userFound = DBX::GetUSERbyID($_SESSION['user_id']);

  //checks to see if the password matches
  if (password_verify($pw, $userFound["password"])) {
    //check to see if PW is 8 or more
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
      $passwordSaved = DBX::SetPasswordByID($_SESSION['user_id'], $hashed_pw);

      if (!$passwordSaved) {
        //checks to see if there was an errro
        $return['error'] = "Error 152DB no se creo el registro. Reportar al ADMIN!";
      } else {
        $return['redirect'] = 'dashboard.php?message=success!';
      }
    }

  }else {
    $return['error'] = "Password incorrect!";
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
