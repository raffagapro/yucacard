<?php
  date_default_timezone_set('America/Merida');

  /*
  if (!defined('_CONFIG_')) {
      exit('You do not have a config file!');
  }*/

  //session always turn on
  if (!isset($_SESSION)) {
    session_start();
  }

  /*if (!isset($_SESSION['lenguage'])) {
    $_SESSION['lenguage'] = 0;
  }*/

  // Allow errors
	error_reporting(-1);
	ini_set('display_errors', 'On');

  //include files
  include_once "classes/DB.class.php";
  include_once "classes/Page.class.php";
  //include_once "classes/Admin.class.php";





?>
