<?php
//-----codigo essencial para que la pagiona de log in ------//
require_once 'includes/header.inc.php';
Page::ForceDashboard();
//-----codigo essencial para la pagina de log in --------//
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>LOGIN USER</title>
    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>

    <form class="container-fluid form-signin" action="add_user.php" method="post">
      <img class="mb-4 main-icon" src="https://avatarfiles.alphacoders.com/200/200276.jpg" alt="">
      <h1 class="h3 mb-3 font-weight-normal">BAT-log me in!</h1>

      <input type="email" class="form-control top" placeholder="Email" name="email" required>
      <input type="password" class="form-control bot" placeholder="Choose a password" name="password" required>



      <div id="errorMessage" class="alert alert-danger hidden" role="alert"></div>

      <button class="btn btn-lg btn-primary btn-block" id="submitButton" type="submit">BAT-log Me In!</button>
      <p class="mt-5 mb-3 text-muted">&copy; Bat-App 2017-2020</p>
    </form>

    <div id="notice" class="alert alert-warning hidden" role="alert">
      <?php
        /*$fullName = ucfirst($row['nombre']) . " " . ucfirst($row['apellido1']) . " " . ucfirst($row['apellido2']);
        echo "Your name is " . $fullName;*/
      ?>
    </div>



    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- scripts essenciales para funcionamiento pagina  -------------->
    <script src="js/login_user.js" charset="utf-8"></script>
    <script src="js/functions.js" charset="utf-8"></script>
    <!-- scripts essenciales para funcionamiento pagina  -------------->

  </body>
</html>
