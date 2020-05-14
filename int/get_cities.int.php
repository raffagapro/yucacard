<?php
require_once '../includes/header.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //return json format
  header('Content-Type: application/json');
  //array where we save data to be send back to ajax
  $return = [];

  //grabbing info from $_POST and filtering them
  $stateID = (int)$_POST["state"];

  //searches DB for state
  $cities = DBX::GetCitiesByStateID($stateID);
  //$cities = array_reverse($cities);
  if (!$cities) {
    //if there are cities
    $return['cities'] = false;
  } else {
    $return['cities'] = $cities;
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
