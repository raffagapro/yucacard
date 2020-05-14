<?php
require_once '../includes/header.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //return json format
  header('Content-Type: application/json');
  //array where we save data to be send back to ajax
  $return = [];

  //grabbing info from $_POST and filtering them
  $name = filter_var($_POST["buyer_name"], FILTER_SANITIZE_STRING);
  //extra  sanitacioin
  $name = cleanString($name);

  $name2 = filter_var($_POST["buyer_name2"], FILTER_SANITIZE_STRING);
  //extra  sanitacioin
  $name2 = cleanString($name2);

  $name3 = filter_var($_POST["buyer_name3"], FILTER_SANITIZE_STRING);
  //extra  sanitacioin
  $name3 = cleanString($name3);

  $phone = filter_var($_POST["buyer_phone"], FILTER_SANITIZE_NUMBER_INT);
  //clean all non numeric data from phone
  $phone = preg_replace('/\D/', '', $phone);

  $email = filter_var($_POST["buyer_email"], FILTER_SANITIZE_EMAIL);

  $price = (int)$_POST["price"];

  $gift_name = filter_var($_POST["gift_name"], FILTER_SANITIZE_STRING);
  //extra  sanitacioin
  $gift_name = cleanString($gift_name);

  $gift_name2 = filter_var($_POST["gift_name2"], FILTER_SANITIZE_STRING);
  //extra  sanitacioin
  $gift_name2 = cleanString($gift_name2);

  $gift_name3 = filter_var($_POST["gift_name3"], FILTER_SANITIZE_STRING);
  //extra  sanitacioin
  $gift_name3 = cleanString($gift_name3);

  $gift_email = filter_var($_POST["gift_email"], FILTER_SANITIZE_EMAIL);

  $gift_note = filter_var($_POST["gift_note"], FILTER_SANITIZE_STRING);

  //variable for gift user info validation
  $gift_info = true;

  $isGift = 0;


  if ($name == "") {
    $return['error'] = "Name missing!";
  } elseif ($name2 == "") {
    $return['error'] = "Last Name missing!";
  } elseif ($name3 == "") {
    $return['error'] = "Last Name2 missing!";
  } elseif (strlen($phone) < 10) {
    $return['error'] = "Phone can only contain letters!";
  } elseif ($email == "") {
    $return['error'] = "Email missing!";
  } elseif ($price == "z") {
    $return['error'] = "You need to select a price!";
  }else {
    //checks to see if giftcard is a gift
    if ($gift_name != "") {
      $isGift = 1;
      if ($gift_name2 == "") {
        $return['error'] = "Recipient Last Name missing!";
        $gift_info = false;
      } elseif ($gift_name3 == "") {
        $return['error'] = "Recipient Last Name2 missing!";
        $gift_info = false;
      } elseif ($gift_email == "") {
        $return['error'] = "Recipient Email missing!";
        $gift_info = false;
      }
    }
    if (!$gift_info) {
      // leave empty since error has already been passed
    }else {
      // add info to the database
      $giftCard_id = DBX::AddGiftCard(
        $price,
        $name,
        $name2,
        $name3,
        $phone,
        $email,
        $isGift,
        $gift_name,
        $gift_name2,
        $gift_name3,
        $gift_email,
        $gift_note,
        $_SESSION['state_id']
      );
      // generate random giftcard number
      // add it to the giftcard record
      giftcard_keygen($_SESSION['state_id'], $giftCard_id);

      //redirect to a success buy page
      $return['redirect'] = 'buy_giftCard_form.php?message=success!';

    }
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

function giftcard_keygen($state, $giftCard_id){
  $stateObj = DBX::GetStateByID($state);
  $year = date("Y");
  $giftCardObj = DBX::GetGiftCardByID($giftCard_id);
  $prefix = substr($stateObj['nombre'], 0 , 3) . $state . numbersToLetters(substr($year, 2, 5));
  $temp_UID = uniqid($prefix);
  $temp_ending = substr($giftCardObj['nombre_comp'], 0, 2) . substr($giftCardObj['apellido1_comp'], 0, 2) . $giftCardObj['card_id'];
  $final_res_num = $temp_UID . $temp_ending;
  DBX::SetGiftCardReservationNumber($giftCard_id, $final_res_num);
}

function numbersToLetters($num){
  $alphabetArray = [
    "a", 'b', 'c', 'd', 'e',
    'f', 'g', 'h', 'i', 'j',
    'k', 'l', 'm', 'n', 'o',
    'p', 'q', 'r', 's', 't',
    'u', 'v', 'w', 'x', 'y',
    'z'];
    $newstring = "";
    $num = (string)$num;

    for ($i=0; $i < strlen($num); $i++) {
      $tempNum = (int)$num[$i];
      $newstring = $newstring . $alphabetArray[$tempNum];
    }
    return $newstring;
}

function lettersToNumbers($string){
  $alphabetArray = [
    "a", 'b', 'c', 'd', 'e',
    'f', 'g', 'h', 'i', 'j',
    'k', 'l', 'm', 'n', 'o',
    'p', 'q', 'r', 's', 't',
    'u', 'v', 'w', 'x', 'y',
    'z'];
    $newstring = "";
    $string = (string)$string;

    for ($i=0; $i < strlen($string); $i++) {
      for ($x=0; $x < count($alphabetArray); $x++) {
        if ($string[$i] == $alphabetArray[$x]) {
          $tempNum = (string)$x;
          $newstring = $newstring . $tempNum;
        }
      }

    }
    return $newstring;
}
?>
