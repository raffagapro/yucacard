<?php
require_once '../includes/header.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //return json format
  header('Content-Type: application/json');
  //array where we save data to be send back to ajax
  $return = [];

  //grabbing info from $_POST and filtering them
  $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
  //extra  sanitacioin
  $name = cleanString($name);

  $name2 = filter_var($_POST["name2"], FILTER_SANITIZE_STRING);
  //extra  sanitacioin
  $name2 = cleanString($name2);

  $name3 = filter_var($_POST["name3"], FILTER_SANITIZE_STRING);
  //extra  sanitacioin
  $name3 = cleanString($name3);

  $phone = filter_var($_POST["phone"], FILTER_SANITIZE_NUMBER_INT);
  //clean all non numeric data from phone
  $phone = preg_replace('/\D/', '', $phone);

  $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
  $pw = $_POST["pw"];
  $pw2 = $_POST["pw2"];

  //checks to see if email already exists
  $query = "SELECT * FROM users WHERE email = ?";
  $stmt = mysqli_stmt_init($link);
  if (!mysqli_stmt_prepare($stmt, $query)) {
    $return['error'] = "Error 152DB no se creo el registro. Reportar al ADMIN!";
  }else {
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    //grabing single result
    $result = $stmt->get_result(); // get the mysqli result
    $resultArray = $result->fetch_assoc();
  }

  if ($resultArray > 0) {
    //$return['error'] = $row = mysqli_fetch_array($result);
    $return['error'] = "Emails has been used already!";
    //checks to see if phone is less than 10 letters long
  } elseif (strlen($phone) < 10) {
    $return['error'] = "Phone can only contain letters!";
    //checks to see if PW is less than 8 letters long
  } elseif (strlen($pw) < 8) {
    $return['error'] = "Password must be 8 characters or more!";
    //metches passwords
  } elseif ($pw != $pw2) {
    $return['error'] = "Passwords did not match!";
    //checks for invalid characters in the password
  } elseif (!preg_match("/^[a-zA-Z0-9\$!#%*]*$/", $pw)) {
    $return['error'] = "Passwords must be letters,numbers, and (!#$%*). Case sensitive!";
    //if all is good, prepare data to be send to DB
  } else {
    //Hashed Password
    $hashed_pw = password_hash($pw, PASSWORD_DEFAULT);

    //prepare query to insert data
    $query = "INSERT INTO users (nombre, apellido1, apellido2, email, telefono, password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($link);
    //revisa si la coneccion esta correcta
    if (!mysqli_stmt_prepare($stmt, $query)) {
      $return['error'] = "Error 152DB no se creo el registro. Reportar al ADMIN!";
    } else {
      // se ligan los valores y se ejecuta el query
      mysqli_stmt_bind_param($stmt, "ssssss", $name, $name2, $name3, $email, $phone, $hashed_pw);
      mysqli_stmt_execute($stmt);
      $result = $stmt->get_result(); // get the mysqli result
      $return['redirect'] = 'add_user_form.php?message=success!';
    }


    //TESTING RETURNS
    //$return['error'] = mysqli_query($link, $query);
    //$return['error'] = "Life is good wise master!";
  }

  //close conection
  closeLink($stmt, $link);
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
