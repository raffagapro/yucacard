<?php
if (isset($_GET['search'])) {
  $searchName = "";
  $searchResNum = "";
  $searchMail = "";
  $searchLitePicker = "";

  if (isset($_GET['search_name'])) {
    $searchName = $_GET['search_name'];
  }
  if (isset($_GET['search_reservation_number'])) {
    $searchResNum = $_GET['search_reservation_number'];
  }
  if (isset($_GET['search_email'])) {
    $searchMail = $_GET['search_email'];
  }
  if (isset($_GET['litepicker'])) {
    $searchLitePicker = $_GET['litepicker'];
  }

  if ($searchName != "") {
    $reservations = DBX::SearchGiftCardsByName($_GET['search_name']);
    if (isset($_GET['sort'])) {
      if ($_GET['sort'] == 'asc') {
        $reservations = array_reverse($reservations);
      }
    }
  }elseif ($searchResNum != "") {
    $reservations = DBX::SearchGiftCardsByResNum($_GET['search_reservation_number']);
    if (isset($_GET['sort'])) {
      if ($_GET['sort'] == 'asc') {
        $reservations = array_reverse($reservations);
      }
    }
  }elseif ($searchMail != "") {
    $reservations = DBX::SearchGiftCardsByEmail($_GET['search_email']);
    if (isset($_GET['sort'])) {
      if ($_GET['sort'] == 'asc') {
        $reservations = array_reverse($reservations);
      }
    }
  }elseif ($searchLitePicker != "") {
    $reservations = DBX::SearchGiftCardsByRecDate($_GET['litepicker']);
    if (isset($_GET['sort'])) {
      if ($_GET['sort'] == 'asc') {
        $reservations = array_reverse($reservations);
      }
    }
  }else {
    $reservations = DBX::GetAllGiftCard();
    if (isset($_GET['sort'])) {
      if ($_GET['sort'] == 'asc') {
        $reservations = array_reverse($reservations);
      }
    }
  }
} else {
  $reservations = DBX::GetAllGiftCard();
  if (isset($_GET['sort'])) {
    if ($_GET['sort'] == 'asc') {
      $reservations = array_reverse($reservations);
    }
  }
}

 ?>
