<?php
require_once '../includes/header.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //grabbing info from $_POST and filtering them
  $follow_body = filter_var($_POST["follow_up"], FILTER_SANITIZE_STRING);
  $fu_type = (int)$_POST["fu_type"];
  $giftcard_id = (int)$_POST["giftcard_id"];

  DBX::AddFollowUp($giftcard_id, $_SESSION['user_id'], $follow_body, $fu_type);
  $return['redirect'] = 'admin_panel.php?message=success!';
  
  echo json_encode($return, JSON_PRETTY_PRINT);
  exit;

} else {
  // if they didnt arrived to the page by the POST method it kills script
  exit('Invalid URL');
}

//$return['redirect'] = 'dashboard.php?message='.$len[33].'!&tab=mu'
?>
