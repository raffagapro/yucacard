<?php
require_once '../includes/header.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //return json format
  header('Content-Type: application/json');
  //array where we save data to be send back to ajax
  $return = [];

  //grabbing info from $_POST and filtering them
  $city = filter_var($_POST["city"], FILTER_SANITIZE_STRING);
  //extra  sanitacioin
  $city = cleanString($city);
  $stateID = (int)$_POST["state"];

  //searches DB for state
  $cityFound = DBX::GetCityByName($city, $stateID);

  if ($cityFound) {
    //checks to see if there was an errro
    $return['error'] = ucfirst($city)." is already in the DB!";
  } else {
    DBX::AddCity($stateID, $city);
    $return['redirect'] = 'add_city_form.php?message=success!';
  }

  //information gets send back to ajax
  echo json_encode($return, JSON_PRETTY_PRINT);
  exit;
} else {
  // if they didnt arrived to the page by the POST method it kills script
  exit('Invalid URL');
}

function cleanString ($string){
  //cleans all strange characters, but letter includinng accents
  $string = preg_replace("/[^\w\s]+/u", "", $string);
  //removes numbers
  $string = preg_replace("/\d+/u", "", $string);
  return $string;
}
//$return['redirect'] = 'dashboard.php?message='.$len[33].'!&tab=mu'
?>
