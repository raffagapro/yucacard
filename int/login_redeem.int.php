<?php
require_once '../includes/header.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //return json format
  header('Content-Type: application/json');
  //array where we save data to be send back to ajax
  $return = [];

  //grabbing info from $_POST and filtering them
  $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
  $cardCode = $_POST["cardCode"];

  //checks to see if email already exists
  $query = "SELECT * FROM giftcard WHERE codigo = ? AND email_comp = ? OR email_gift = ? LIMIT 1";
  $stmt = mysqli_stmt_init($link);
  if (!mysqli_stmt_prepare($stmt, $query)) {
    $return['error'] = "Error 152DB no se creo el registro. Reportar al ADMIN!";
  }else {
    mysqli_stmt_bind_param($stmt, "sss", $cardCode, $email, $email);
    mysqli_stmt_execute($stmt);
    //grabing single result
    $result = $stmt->get_result(); // get the mysqli result
    $resultArray = $result->fetch_assoc();
  }

  //heck to see if we got a match
  if ($resultArray > 0) {
    //redirect to reedeem page
    $return['redirect'] = 'dashboard.php';
  }else {
    $return['error'] = "Gift Card not found or incorrect email!";
  }

  //close conection
  closeLink($stmt, $link);
  //information gets send back to ajax
  echo json_encode($return, JSON_PRETTY_PRINT);
  exit;
} else {
  // if they didnt arrived to the page by the POST method it kills script
  exit('Invalid URL');
}


//$return['redirect'] = 'dashboard.php?message='.$len[33].'!&tab=mu'
?>
