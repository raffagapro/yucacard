<?php
require_once '../includes/header.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //return json format
  header('Content-Type: application/json');
  //array where we save data to be send back to ajax
  $return = [];

  //grabbing info from $_POST and filtering them
  $product_type = (int)$_POST["product_type"];
  $product_name = filter_var($_POST["product_name"], FILTER_SANITIZE_STRING);
  $product_price = (int)$_POST["product_price"];
  $product_category = (int)$_POST["product_category"];
  $address1 = filter_var($_POST["address1"], FILTER_SANITIZE_STRING);
  $address2 = filter_var($_POST["address2"], FILTER_SANITIZE_STRING);
  $lat = filter_var($_POST["lat"], FILTER_SANITIZE_STRING);
  $lon = filter_var($_POST["lon"], FILTER_SANITIZE_STRING);
  $email_reservations = filter_var($_POST["email_reservations"], FILTER_SANITIZE_EMAIL);
  $phone_reservations = filter_var($_POST["phone_reservations"], FILTER_SANITIZE_NUMBER_INT);
  $product_desc = filter_var($_POST["product_desc"], FILTER_SANITIZE_STRING);

  //searches add product
  $affiObj = DBX::GetAffByUserID($_SESSION['user_id']);
  $existingProduct = DBX::GetProductByNameAndCityID($product_name, $affiObj['ciudad']);

  //cehcks to see if there is a prodcut with the same name in the city
  if ($existingProduct) {
    $return['error'] = "Product Name already in use!";
  } else {
    $productFound = DBX::AddProducto(
      $_SESSION['aff_id'],
      $product_type,
      $product_name,
      $address1,
      $address2,
      $lat,
      $lon,
      $email_reservations,
      $phone_reservations,
      $product_desc,
      $product_category,
      $product_price,
      $affiObj['estado'],
      $affiObj['ciudad']
    );

    if (!$productFound) {
      //checks to see if there was an errro
      $return['error'] = "Error 152DB no se creo el registro. Reportar al ADMIN!";
    } else {
      $return['redirect'] = 'dashboard.php?message=success!';
    }
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
