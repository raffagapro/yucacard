<?php
if (isset($_GET['search_users'])) {
  $searchUSName = "";
  $searchUSMail = "";

  if (isset($_GET['search_usr_name'])) {
    $searchName = $_GET['search_usr_name'];
  }
  if (isset($_GET['search_usr_email'])) {
    $searchMail = $_GET['search_usr_email'];
  }

  if ($searchName != "") {
    $users = DBX::SearchUSERSByName($_GET['search_usr_name']);
    if (isset($_GET['sort'])) {
      if ($_GET['sort'] == 'asc') {
        $users = array_reverse($users);
      }
    }
  }elseif ($searchMail != "") {
    $users = DBX::SearchUSERSByEmail($_GET['search_usr_email']);
    if (isset($_GET['sort'])) {
      if ($_GET['sort'] == 'asc') {
        $users = array_reverse($users);
      }
    }
  }else {
    $users = DBX::GetUSERS();
    if (isset($_GET['sort'])) {
      if ($_GET['sort'] == 'asc') {
        $users = array_reverse($users);
      }
    }
  }
} else {
  $users = DBX::GetUSERS();
  if (isset($_GET['sort'])) {
    if ($_GET['sort'] == 'asc') {
      $users = array_reverse($users);
    }
  }
}

 ?>
