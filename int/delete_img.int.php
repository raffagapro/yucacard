<?php
require_once '../includes/header.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //grabbing info from $_POST and filtering them

  $image_id = (int)$_POST['image_id'];
  //grab the image object
  $img = DBX::GetImageByID($image_id);
  //deletes de file
  unlink("../".$img['ubicacion']);
  //deletes DB record
  DBX::DeleteImg($image_id);
  header("Location: ../dashboard.php?success");

} else {
  // if they didnt arrived to the page by the POST method it kills script
  exit('Invalid URL');
}

//$return['redirect'] = 'dashboard.php?message='.$len[33].'!&tab=mu'
?>
