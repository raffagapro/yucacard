<?php
  class Page{
    //force user to login
    static function ForceLogin(){
      if (isset($_SESSION['user_id'])) {
        // The user is allowed
      }else {
        // The user gets redirect to LOGIN PAGE!!
        header("Location: login_user_form.php");
        exit;
      }

      /*if ($_SESSION['lock'] == true && $_SERVER['PHP_SELF'] != "/ecuisine/checkDisplay.php") {
        // code...
        header("Location: includes/logout.inc.php");
        exit;
      }*/
    }

    //force user to dashboard
    static function ForceDashboard(){
      if (isset($_SESSION['user_id'])) {
        // The user is allowed get redirect to DASHBOARD
        header("Location: add_user_form.php");
        exit;
      }
    }

  }
?>
