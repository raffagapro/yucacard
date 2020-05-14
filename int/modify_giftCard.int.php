<?php
require_once '../includes/header.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //return json format
  header('Content-Type: application/json');
  //array where we save data to be send back to ajax
  $return = [];

  $giftcard_id = (int)$_POST["giftcard_id"];

  //grabbing info from $_POST and filtering them
  $user_name = filter_var($_POST["user_name"], FILTER_SANITIZE_STRING);
  //extra  sanitacioin
  $user_name = cleanString($user_name);

  $user_lastName = filter_var($_POST["user_lastName"], FILTER_SANITIZE_STRING);
  //extra  sanitacioin
  $user_lastName = cleanString($user_lastName);

  $user_lastName2 = filter_var($_POST["user_lastName2"], FILTER_SANITIZE_STRING);
  //extra  sanitacioin
  $user_lastName2 = cleanString($user_lastName2);

  $user_phone = filter_var($_POST["user_phone"], FILTER_SANITIZE_NUMBER_INT);
  //clean all non numeric data from phone
  $user_phone = preg_replace('/\D/', '', $user_phone);

  $user_email = filter_var($_POST["user_email"], FILTER_SANITIZE_EMAIL);

  $gift_name = filter_var($_POST["gift_name"], FILTER_SANITIZE_STRING);
  //extra  sanitacioin
  $gift_name = cleanString($gift_name);

  $gift_lastName = filter_var($_POST["gift_lastName"], FILTER_SANITIZE_STRING);
  //extra  sanitacioin
  $gift_lastName = cleanString($gift_lastName);

  $gift_lastName2 = filter_var($_POST["gift_lastName2"], FILTER_SANITIZE_STRING);
  //extra  sanitacioin
  $gift_lastName2 = cleanString($gift_lastName2);

  $gift_email = filter_var($_POST["gift_email"], FILTER_SANITIZE_EMAIL);

  $gift_note = filter_var($_POST["gift_note"], FILTER_SANITIZE_STRING);

  $price = (int)$_POST["price"];

  $is_gift = (int)$_POST["is_gift"];

  $state_id = (int)$_POST["state_id"];

  $status = (int)$_POST["status"];

  $redeemed_product = (int)$_POST["redeemed_product"];


  //variable for gift user info validation
  $gift_info = true;


  if ($user_name == "") {
    $return['error'] = "Buyer Name missing!";
  } elseif ($user_lastName == "") {
    $return['error'] = "Buyer Last Name missing!";
  } elseif ($user_lastName2 == "") {
    $return['error'] = "Buyer Last Name2 missing!";
  } elseif (strlen($user_phone) < 10) {
    $return['error'] = "Buyer Phone can only contain letters!";
  } elseif ($user_email == "") {
    $return['error'] = "Email missing!";
  } else {
    //checks to see if giftcard is a gift
    if ($is_gift == 1) {
      if ($gift_name == "") {
        $return['error'] = "Recipient Name missing!";
        $gift_info = false;
      } elseif ($gift_lastName == "") {
        $return['error'] = "Recipient Last Name missing!";
        $gift_info = false;
      } elseif ($gift_lastName2 == "") {
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
      // grab previous giftcard info
      $previosInfo_obj = DBX::GetGiftCardByID($giftcard_id);
      $temp_fu_body = "INFO CHANGED: ";
      $fu_lock = false;
      // compare it with the new information
      //-------------------Check for changes and setting up for FOLLOW-UP-----------------
      if ($previosInfo_obj['precio'] != $price) {
        $temp_fu_body .= "Price: ".price_grabber($previosInfo_obj['precio']." ");
        $fu_lock = true;
      }

      if ($previosInfo_obj['nombre_comp'] != $user_name) {
        $temp_fu_body .= "BuyersnName: ".$previosInfo_obj['nombre_comp']." ";
        $fu_lock = true;
      }

      if ($previosInfo_obj['apellido1_comp'] != $user_lastName) {
        $temp_fu_body .= "Buyers LastName: ".$previosInfo_obj['apellido1_comp']." ";
        $fu_lock = true;
      }

      if ($previosInfo_obj['apellido2_comp'] != $user_lastName2) {
        $temp_fu_body .= "Buyers LastName2: ".$previosInfo_obj['apellido2_comp']." ";
        $fu_lock = true;
      }

      if ($previosInfo_obj['telefono_comp'] != $user_phone) {
        $temp_fu_body .= "Buyers Phone: ".$previosInfo_obj['telefono_comp']." ";
        $fu_lock = true;
      }

      if ($previosInfo_obj['email_comp'] != $user_email) {
        $temp_fu_body .= "Buyers Email: ".$previosInfo_obj['email_comp']." ";
        $fu_lock = true;
      }

      if ($previosInfo_obj['es_gift'] != $is_gift) {
        $temp_fu_body .= "is_gift: ".$previosInfo_obj['es_gift']." ";
        $fu_lock = true;
      }
       //if the giftcard is a gift record changes in the gift info
      if ($is_gift == 1) {
        if ($previosInfo_obj['nombre_gift'] != $gift_name) {
          $temp_fu_body .= "Name Gift: ".$previosInfo_obj['nombre_gift']." ";
          $fu_lock = true;
        }

        if ($previosInfo_obj['apellido1_gift'] != $gift_lastName) {
          $temp_fu_body .= "LName Gift: ".$previosInfo_obj['apellido1_gift']." ";
          $fu_lock = true;
        }

        if ($previosInfo_obj['apellido2_gift'] != $gift_lastName2) {
          $temp_fu_body .= "LName2 Gift: ".$previosInfo_obj['apellido2_gift']." ";
          $fu_lock = true;
        }

        if ($previosInfo_obj['email_gift'] != $gift_email) {
          $temp_fu_body .= "Email Gift: ".$previosInfo_obj['email_gift']." ";
          $fu_lock = true;
        }

        if ($previosInfo_obj['gift_note'] != $gift_note) {
          $temp_fu_body .= "Gift Note: ".$previosInfo_obj['gift_note']." ";
          $fu_lock = true;
        }
      }

      if ($previosInfo_obj['es_redimed'] != $status) {
        $temp_fu_body .= "Status: ".$previosInfo_obj['es_redimed']." ";
        $fu_lock = true;
      }

      if ($redeemed_product == 'z') {
        $redeemed_product = null;
      }

      if ($previosInfo_obj['producto'] != $redeemed_product) {
        $temp_fu_body .= "Product: ".$previosInfo_obj['producto']." ";
        $fu_lock = true;
      }

      if ($previosInfo_obj['estado'] != $state_id) {
        $temp_fu_body .= "State_ID: ".$previosInfo_obj['estado']." ";
        $fu_lock = true;
      }

      if ($fu_lock == true) {
        DBX::AddFollowUp($giftcard_id, $_SESSION['user_id'], $temp_fu_body, 0);
      }
      //-------------------Check for changes and setting up for FOLLOW-UP-----------------

      //push changes to the DB
      //checks to see if the status was change to reedemed
      if ($previosInfo_obj['es_redimed'] != 1 && $status == 1) {
        DBX::SetGiftcardReedemedDate($giftcard_id, date("Y-m-d H:i:s"));
      }
      //checks to see if there was a change on the product

      DBX::SetGiftcardReedemedProduct($giftcard_id, $redeemed_product);
      $mod_gc = DBX::ModifyGiftcard(
        $price,
        $user_name,
        $user_lastName,
        $user_lastName2,
        $user_phone,
        $user_email,
        $is_gift,
        $gift_name,
        $gift_lastName,
        $gift_lastName2,
        $gift_email,
        $gift_note,
        $status,
        $state_id,
        $giftcard_id
      );
      if (!$mod_gc) {
        $return['error'] = "Error 125DB contact admin!";
      } else {
        //redirect to a success buy page
        $return['redirect'] = 'admin_panel.php?message=success!';
      }

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

function price_grabber($price_id){
  $prices = DBX::GetPrecios();
  foreach ($prices as $price) {
    if ($price[0] == $price_id) {
      return "$".$price[1].".00 USD";
    }
  }

}
//$return['redirect'] = 'dashboard.php?message='.$len[33].'!&tab=mu'
?>
