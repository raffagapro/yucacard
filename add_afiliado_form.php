<?php
//-----codigo essencial para que la pagiona de log in ------//
require_once 'includes/header.inc.php';
//Page::ForceLogin();
$states = DBX::GetStates();
//-----codigo essencial para que la pagiona de log in ------//
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>ADD Afiliado</title>
    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <?php require_once 'includes/tempNavbar.inc.php'; ?>

    <form class="container-fluid form-signin" action="add_user.php" method="post">
      <img class="mb-4 main-icon" src="https://avatarfiles.alphacoders.com/200/200276.jpg" alt="">
      <h1 class="h3 mb-3 font-weight-normal">Add New Bat-affiliate!</h1>

      <div class="accordion" id="accordionExample">

        <!-- company Info -->
        <div class="card">
          <div class="card-header" id="headingOne">
            <h2 class="mb-0">
              <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Company Info
              </button>
            </h2>
          </div>

          <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
              <input type="text" class="form-control top" placeholder="Company Name" name="nombre_company" required>
              <div class="container ">
                <div class="row">
                  <div class="col">
                    <!-- scripts essenciales para funcionamiento display estados  -------------->
                    <select class="form-control text-capitalize mid" id="state">
                      <option value='z'>Select State</option>
                      <?php
                        foreach ($states as $state) {
                            echo "<option value='".$state[0]."'>".ucfirst($state[1])."</option>";
                        }
                      ?>
                    </select>
                    <!-- scripts essenciales para funcionamiento display estados  -------------->
                  </div>
                  <div class="col">
                    <!-- scripts essenciales para funcionamiento display ciudades  -------------->
                    <select class="form-control text-capitalize mid" id="city">
                      <option value='z'>Select City</option>
                    </select>
                    <!-- scripts essenciales para funcionamiento display ciudades  -------------->
                  </div>
                </div>
              </div>
              <input type="text" class="form-control top" placeholder="Name of city, if NOT on drop down menu..." name="other">
            </div>
          </div>
        </div>

        <!-- contact Info -->
        <div class="card">
          <div class="card-header" id="headingTwo">
            <h2 class="mb-0">
              <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Contact Info
              </button>
            </h2>
          </div>

          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
              <input type="text" class="form-control top" placeholder="First Name" name="nombre">
              <input type="text" class="form-control mid" placeholder="Last Name" name="apellido1" required>
              <input type="text" class="form-control mid" placeholder="2nd Last Name" name="apellido2" required>
              <input type="text" class="form-control mid" placeholder="Job Title" name="puesto" required>
              <input type="text" class="form-control mid" placeholder="Phone" name="phone" required>
              <input type="email" class="form-control bot" placeholder="Email" name="email" required>
              <input type="password" class="form-control top" placeholder="Choose a password" name="password" required>
              <input type="password" class="form-control bot" placeholder="Confirm password" name="password2" required>
            </div>
          </div>
        </div>

      </div>



      <div id="errorMessage" class="alert alert-danger hidden" role="alert"></div>

      <button class="btn btn-lg btn-primary btn-block" id="submitButton" type="submit">Bat-Affil Me Up!</button>
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
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- scripts essenciales para funcionamiento pagina  -------------->
    <script src="js/add_afiliado.js" charset="utf-8"></script>
    <script src="js/functions.js" charset="utf-8"></script>
    <!-- scripts essenciales para funcionamiento pagina  -------------->
  </body>
</html>
