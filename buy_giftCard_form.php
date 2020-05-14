<?php
//-----codigo essencial para que la pagiona de log in ------//
require_once 'includes/header.inc.php';
$precios = DBX::GetPrecios();

//change for each buy gift card state page
$_SESSION['state_id'] = 31;

//Page::ForceLogin();
//-----codigo essencial para que la pagiona de log in ------//
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>BUY GIFT CARD</title>
    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <?php require_once 'includes/tempNavbar.inc.php'; ?>

    <form class="container-fluid form-signin" action="add_user.php" method="post">
      <img class="mb-4 main-icon" src="https://avatarfiles.alphacoders.com/200/200276.jpg" alt="">
      <h1 class="h3 mb-3 font-weight-normal">The one and only: Bat-giftcard!</h1>

      <input type="text" class="form-control top" placeholder="First Name" name="nombre_buyer" required autofocus>
      <input type="text" class="form-control mid" placeholder="Last Name" name="apellido1_buyer" required>
      <input type="text" class="form-control mid" placeholder="2nd Last Name" name="apellido2_buyer" required>
      <input type="text" class="form-control mid" placeholder="Phone" name="phone_buyer" required>
      <input type="email" class="form-control mid" placeholder="Email" name="email_buyer" required>
      <select class="form-control text-capitalize bot" id="product_price">
        <option value='z'>Select Price</option>
        <?php
          foreach ($precios as $precio) {
              echo "<option value='".$precio[0]."'> $".ucfirst($precio[1]).".00 USD</option>";
          }
        ?>
      </select>

      <div class="accordion bot" id="buyer_accordion">
        <!-- contact Info -->
        <div class="card">
          <div class="card-header" id="headingTwo">
            <h2 class="mb-0">
              <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Would this be a gift?
              </button>
            </h2>
          </div>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#buyer_accordion">
            <div class="card-body">
              <input type="text" class="form-control top" placeholder="Recipient Name" name="nombre_gift">
              <input type="text" class="form-control mid" placeholder="Recipient Last Name" name="apellido1_gift">
              <input type="text" class="form-control mid" placeholder="Recipient Last Name2" name="apellido2_gift">
              <input type="email" class="form-control bot" placeholder="RecipientEmail" name="email_gift">
              <label for='product_description'>Gift Note:</label>
              <textarea class='form-control bot' id='gift_note' rows='3'></textarea>
            </div>
          </div>
        </div>
      </div>



      <div id="errorMessage" class="alert alert-danger hidden" role="alert"></div>

      <button class="btn btn-lg btn-primary btn-block" id="submit_buy_gift_btn" type="submit">Buy Bat-giftcard!</button>
      <p class="mt-5 mb-3 text-muted">&copy; The Bat-App 2017-2020</p>
    </form>

    <!-- division para desarrollo borrar -->
    <div id="notice" class="alert alert-warning" role="alert">
      <?php
      /*
        $fullName = ucfirst($resultArray['nombre']) . " " . ucfirst($resultArray['apellido1']) . " " . ucfirst($resultArray['apellido2']);
        echo "Your name is " . $fullName;
        */
      ?>
    </div>


    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- scripts essenciales para funcionamiento pagina  -------------->
    <script src="js/buy_giftCard.js" charset="utf-8"></script>
    <script src="js/functions.js" charset="utf-8"></script>
    <!-- scripts essenciales para funcionamiento pagina  -------------->
  </body>
</html>
