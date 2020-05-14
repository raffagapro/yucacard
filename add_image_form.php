<?php
//-----codigo essencial para que la pagina ------//
require_once 'includes/header.inc.php';
Page::ForceLogin();
$states = DBX::GetStates();
//-----codigo essencial para que la pagina ------//
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>ADD Image</title>
    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <?php require_once 'includes/tempNavbar.inc.php'; ?>
    <!-- IMPORTANT!!!!!!!!!! -->
    <!-- this tipe of input should not be passed thru a JS file but directly to php -->
    <form class="container-fluid form-signin" action="int/add_img.int.php" method="post" enctype="multipart/form-data">
      <img class="mb-4 main-icon" src="https://avatarfiles.alphacoders.com/200/200276.jpg" alt="">
      <h1 class="h3 mb-3 font-weight-normal">Add New Bat-image!</h1>

      <label for="exampleFormControlFile1">Select an image</label>
      <input type="file" class="form-control-file" name="img_file" id="image_file">

      <div id="errorMessage" class="alert alert-danger hidden" role="alert"></div>

      <button class="btn btn-lg btn-primary btn-block" id="submitButton" type="submit">Add Bat-image!</button>
      <p class="mt-5 mb-3 text-muted">&copy; The Bat-App 2017-2020</p>
    </form>

    <!-- division para desarrollo borrar -->
    <div id="notice" class="alert alert-warning" role="alert">
      <?php
      echo $_SESSION['user_id'];
      echo ", ".$_SESSION['access'];
      if (isset($_SESSION['aff_id'])) {
        echo ", ".$_SESSION['aff_id'];
      }
      ?>
    </div>



    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- scripts essenciales para funcionamiento pagina  -------------->
    <script src="js/add_image.js" charset="utf-8"></script>
    <script src="js/functions.js" charset="utf-8"></script>
    <!-- scripts essenciales para funcionamiento pagina  -------------->
  </body>
</html>
