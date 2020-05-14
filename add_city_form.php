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
    <title>ADD CITY</title>
    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <?php require_once 'includes/tempNavbar.inc.php'; ?>

    <form class="container-fluid form-signin" action="add_user.php" method="post">
      <img class="mb-4 main-icon" src="https://avatarfiles.alphacoders.com/200/200276.jpg" alt="">
      <h1 class="h3 mb-3 font-weight-normal">Add New Bat-city!</h1>

      <div class="container ">
        <div class="row">
          <div class="col">
            <!-- scripts essenciales para funcionamiento pagina  -------------->
            <select class="form-control" id="state">
              <option value='z'>Select State</option>
              <?php
                foreach ($states as $state) {
                    echo "<option value='".$state[0]."'>".ucfirst($state[1])."</option>";
                }
              ?>
            </select>
            <!-- scripts essenciales para funcionamiento pagina  -------------->
          </div>
          <div class="col">
            <button class="btn btn-lg btn-primary btn-block" id="citiesButton" type="submit">Bat-cities!</button>
          </div>
        </div>
      </div>

      <input type="text" class="form-control bot" placeholder="City" name="city" required autofocus>

      <div id="errorMessage" class="alert alert-danger hidden" role="alert"></div>

      <button class="btn btn-lg btn-primary btn-block" id="submitButton" type="submit">Add Bat-city!</button>
      <p class="mt-5 mb-3 text-muted">&copy; The Bat-App 2017-2020</p>
    </form>

    <table class="table table-dark">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Nombre</th>
        </tr>
      </thead>
      <!-- scripts essenciales para display de lista de ciudades  -------------->
      <tbody id="cityRowsCont">
      </tbody>
      <!-- scripts essenciales para display de lista de ciudades  -------------->
    </table>

    <!-- division para desarrollo borrar -->
    <div id="notice" class="alert alert-warning" role="alert">
      <?php
        $cosa = DBX::GetCityByName("merida", 31);
        if (!$cosa) {
          echo "no se encontro ni madres!";
        }else {
          print_r($cosa);

        }
      ?>
    </div>



    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- scripts essenciales para funcionamiento pagina  -------------->
    <script src="js/add_city.js" charset="utf-8"></script>
    <script src="js/display_cities.js" charset="utf-8"></script>
    <script src="js/functions.js" charset="utf-8"></script>
    <!-- scripts essenciales para funcionamiento pagina  -------------->
  </body>
</html>
