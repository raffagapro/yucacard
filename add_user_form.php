<?php
//-----codigo essencial para que la pagiona de log in ------//
require_once 'includes/header.inc.php';
Page::ForceLogin();
//ADDD SECURITY LEVEL RESTRICTION FOR ADMIN ONLY
//-----codigo essencial para que la pagiona de log in ------//
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>ADD USER</title>
    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <?php require_once 'includes/tempNavbar.inc.php'; ?>

    <form class="container-fluid form-signin" action="add_user.php" method="post">
      <img class="mb-4 main-icon" src="https://avatarfiles.alphacoders.com/200/200276.jpg" alt="">
      <h1 class="h3 mb-3 font-weight-normal">Add New Bat-user!</h1>

      <input type="text" class="form-control top" placeholder="First Name" name="nombre" required autofocus>
      <input type="text" class="form-control mid" placeholder="Last Name" name="apellido1" required>
      <input type="text" class="form-control mid" placeholder="2nd Last Name" name="apellido2" required>
      <input type="text" class="form-control mid" placeholder="Phone" name="phone" required>
      <input type="email" class="form-control bot" placeholder="Email" name="email" required>
      <input type="password" class="form-control top" placeholder="Choose a password" name="password" required>
      <input type="password" class="form-control bot" placeholder="Confirm password" name="password2" required>



      <div id="errorMessage" class="alert alert-danger hidden" role="alert"></div>

      <button class="btn btn-lg btn-primary btn-block" id="submitButton" type="submit">Sign Me Up!</button>
      <p class="mt-5 mb-3 text-muted">&copy; The Bat-App 2017-2020</p>
    </form>

    <!-- division para desarrollo borrar -->
    <div id="notice" class="alert alert-warning" role="alert">
      <?php
        $lol = DBX::GetUSERbyName("camila");
        //print_r($lol);
        if ($lol) {
          $fullName = ucfirst($lol['nombre']) . " " . ucfirst($lol['apellido1']) . " " . ucfirst($lol['apellido2']);
          echo "Your name is " . $fullName;
        } else {
          echo "no se encontro ni madres";
        }

      ?>
    </div>



    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- scripts essenciales para funcionamiento pagina  -------------->
    <script src="js/add_user.js" charset="utf-8"></script>
    <script src="js/functions.js" charset="utf-8"></script>
    <!-- scripts essenciales para funcionamiento pagina  -------------->
  </body>
</html>
