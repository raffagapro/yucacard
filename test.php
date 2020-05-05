<?php
  //Allow the config
  define('_CONFIG_', true);

  //Require the config
  require_once '../includes/header2.inc.php';

  //check to see if they arrived by the post method instead o just the URL
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $len = Lenguage::LenguageSwitcher();

    //return json format
    header('Content-Type: application/json');
    $return = [];

    //filtering values and grabbing them from POST
    //$email = Filter::String($_POST['email']);
    $userName = Filter::String($_POST['userName']);
    $password = $_POST['password'];

    //runs user find functions, and ask for user object array to be returned
    $user_found = User::Find($userName, true);

    //checks to see if there was a hit
    if ($user_found) {
      // user exist, checks to see if account has been autorized
      //stores the values from the array into vars
      $user_id = (int) $user_found['user_id'];

      $hashedPW = (string) $user_found['password'];

      //validates passwords
      if (password_verify($password, $hashedPW)) {
        //user is signed in
        $return['redirect'] = 'dashboard.php';

        //starts a session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_type'] = $user_found['usertype'];

        //chceks to see if user is a Guest
        if ($_SESSION['user_type'] == 5) {

        }
      }else {
        // password does not match
        $return['error'] = $len[161];
      }
    }else {
      // user doesnt exist
      $return['error'] = $len[162];
    }

    echo json_encode($return, JSON_PRETTY_PRINT);
  }else {
    // if they didnt arrived to the page by the POST method it kills script
    exit('Invalid URL');
  }
 ?>
