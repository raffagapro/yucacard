<?php
if (isset($_GET['search_users'])) {
  $searchUSName = "";
  $searchUSMail = "";

  if (isset($_GET['search_usr_name'])) {
    $searchUSName = $_GET['search_usr_name'];
  }
  if (isset($_GET['search_usr_email'])) {
    $searchUSMail = $_GET['search_usr_email'];
  }

  if ($searchUSName != "") {
    $users = DBX::SearchUSERSByName($_GET['search_usr_name']);
    if (isset($_GET['sort'])) {
      if ($_GET['sort'] == 'asc') {
        $users = array_reverse($users);
      }
    }
  }elseif ($searchUSMail != "") {
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
