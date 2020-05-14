<?php
//-----codigo essencial para que la pagina ------//
require_once 'includes/header.inc.php';
Page::ForceLogin();
$user = DBX::GetUSERbyID($_SESSION['user_id']);
$product_categories = DBX::GetProductCategories();
$precios = DBX::GetPrecios();
$reservations = DBX::GetAllGiftCard();
$states = DBX::GetStates();
$users = DBX::GetUSERS();
$affiliados = DBX::GetAllAffi();

//-----codigo essencial para que la pagina ------//
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>ADMIN Panel</title>
    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="styles.css">
    <!-- font Awsome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet" crossorigin="anonymous">
  </head>
  <body>
    <?php require_once 'includes/tempNavbar.inc.php'; ?>
    <!-- IMPORTANT!!!!!!!!!! -->
    <!-- HEADER -------------------------------------------->
    <div class="jumbotron jumbotron-fluid text-right jumbo-admin">
      <div class="container">
        <h1 class="display-4 text-capitalize">Welcome <?php echo $user['nombre']?><button type="button" class="btn btn-link btn-sm align-top" data-toggle='modal' data-target='#admin_profile'><i class="fas fa-pencil-alt"></i></button></h1>
        <p class="lead">What would you like to do today?</p>
      </div>
    </div>

    <!-- Modal Aadmin Profile-->
    <div class='modal fade' id='admin_profile' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
      <div class='modal-dialog' role='document'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title'>Profile Information</h5>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>
          <div class='modal-body'>
            <form class='text-left' action='' method='post' enctype='multipart/form-data'>
              <label for='name'>Name</label>
              <input type='text' class='form-control text-capitalize' id='name' value='<?php echo $user['nombre']; ?>'>
              <div class="row">
                <div class="col">
                  <label for='last_name1'>Last Name</label>
                  <input type='text' class='form-control text-capitalize' id='last_name1' value='<?php echo $user['apellido1']; ?>'>
                </div>
                <div class="col">
                  <label for='last_name2'>Last Name 2</label>
                  <input type='text' class='form-control text-capitalize' id='last_name2' value='<?php echo $user['apellido2']; ?>'>
                </div>
              </div>
              <label for='email'>Email</label>
              <input type='text' class='form-control text-lowercase' id='email' value='<?php echo $user['email']; ?>'>
              <label for='phone'>Phone</label>
              <input type='text' class='form-control text-capitalize bot' id='phone' value='<?php echo $user['telefono']; ?>'>
              <div id='errorMessageAdminPro' class='alert alert-danger hidden text-center' role='alert'></div>

              <div class='text-right'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button class='btn btn-info' data-dismiss='modal' type='button' data-toggle='modal' data-target='#admin_change_password'>Change Password</button>
                <button class='btn btn-primary' id='submitAdminProfile' type='submit'>Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Change Password-->
    <div class='modal fade' id='admin_change_password' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
      <div class='modal-dialog' role='document'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title'>Change Passwoord</h5>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>
          <div class='modal-body'>
            <form class='text-left' action='' method='post'>

              <label for='old_password'>Current Password</label>
              <input type='password' class='form-control text-capitalize' id='admin_password' value=''>
              <label for='new_password'>New Password</label>
              <input type='password' class='form-control text-capitalize' id='new_admin_password' value=''>
              <label for='confirmed_password'>Confirm New Password</label>
              <input type='password' class='form-control text-capitalize bot' id='confirmed__admin_password' value=''>
              <div id='errorMessageaffipass' class='alert alert-danger hidden text-center' role='alert'></div>


              <div class='text-right'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button class='btn btn-primary' id='submitAdminPassword' type='submit'>Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Collapse Menu bar-->
    <p class="text-right admin_sub_nav_bar navbar-dark bg-dark">
      <button class="btn btn-info btn-sm" id="res_btn" type="button" data-toggle="collapse" data-target="#reservations" aria-expanded="false" aria-controls="collapseExample">
        Reservations
      </button>
      <button class="btn btn-info btn-sm" id="user_btn" type="button" data-toggle="collapse" data-target="#user_tab" aria-expanded="false" aria-controls="collapseExample">
        Users
      </button>
      <button class="btn btn-info btn-sm" id="affi_btn" type="button" data-toggle="collapse" data-target="#affi_tab" aria-expanded="false" aria-controls="collapseExample">
        Afiliados
      </button>
      <button class="btn btn-info btn-sm" id="products_btn" type="button" data-toggle="collapse" data-target="#product_tab" aria-expanded="false" aria-controls="collapseExample">
        Productos
      </button>
    </p>

    <!-- Collapse CONTENIDO---------------------------------->
    <!-- Reservaciones-->
    <div class="collapse show" id="reservations">
      <!-- Menu de filtros------------------->
      <div class="text-right bg-dark admin_sub_nav_bar">
        <button type="button" class="btn btn-info btn-sm filter_bar_btn"><i class="fas fa-search"></i></button>
        <button type="button" class="btn btn-info btn-sm filter_bar_btn"><i class="fas fa-filter"></i></button>
        <button type="button" class="btn btn-info btn-sm filter_bar_btn"><i class="fas fa-ban"></i></button>
      </div>
      <?php
        //print_r(DBX::GetPrecios());
        //-----codigo essencial para que la pagina ------//
        //-----LAS FUNCIONES ESTAN AL FUNDO y SON NECESARIAS ------//
        /*-----------------------------------------------------
        !!!!!!!!!!!!!!!!!!IMPORTANT!!!!!
        To make this work I use accordion, the header use cols and row,
        and inside there is a card with the full info.
        I had to generate a unique ID for the accordians to work
        --------------------------------------------*/
        if (!$reservations) {
          echo "
          <div class='jumbotron jumbotron-fluid'>
            <div class='container'>
              <h1 class='display-4'>There are no reservations!</h1>
          </div>
          ";
        } else {
          foreach ($reservations as $reservation) {
            //print_r($product);
            if ($reservation[9] == 0) {
              $giftable = "<p><span class='badge badge-pill badge-info'>No</span></p>";
            } else {
              $giftable = "<p><span class='badge badge-pill badge-info'>Yes</span></p>";
            }


            echo "

              <div class='accordion' id='accordion'>
                <div class='card text-white text-capitalize bg-dark'>
                  <div class='card-header' id='headingOne'>
                    <div class='row'>
                      <div class='col-3'>
                        <p class='text-uppercase'>".$reservation[1]."</p>
                      </div>
                      <div class='col-4'>
                      <p class='text-capitalize'>".$reservation[4]." ".$reservation[5]." ".$reservation[6]."</p>
                      </div>
                      <div class='col-2'>
                      <p>$".price_grabber($reservation[2]).".00 USD</p>
                      </div>
                      <div class='col-1'>
                        <span class='badge badge-info'>".state_grabber($reservation[18])."</span>
                      </div>
                      <div class='col-1'>
                        <p>".res_status_switcher($reservation[15])."</p>
                      </div>
                      <div class='col-1 text-left'>
                        <button class='btn btn-info btn-sm' type='button' data-toggle='collapse' data-target='#collapse".$reservation[0]."' aria-expanded='true' aria-controls='collapseOne'>
                          <i class='fas fa-bars'></i>
                        </button>
                      </div>
                    </div>
                  </div>


                  <div id='collapse".$reservation[0]."' class='collapse' aria-labelledby='headingOne' data-parent='#accordion'>
                    <div class='row'>

                      <!-- Reservation Main Body -------------------------------------->
                      <div class='col-8'>
                        <form class='admin_cont'>
                          <div class='row'>
                            <div class='col-4'></div>
                            <div class='col-3'>
                              <label for='res_number'>Recorded Date</label>
                              <small id='res_number' class='form-text text-light'>".$reservation[3]."</small>
                            </div>
                            <div class='col-2'>
                              <label for='es_gift'>Gift Purchase</label>
                              ".$giftable."
                            </div>
                            <div class='col-3'>
                              <label for='res_number'>Redeemed Date</label>
                              <small id='res_number' class='form-text text-light'>".$reservation[16]."</small>
                            </div>
                          </div>

                          <!-- Buyer Info -------------------------------------->
                          <small id='res_number' class='form-text text-light text-left'>Buyer Info</small>
                          <div class='card bg-dark'>
                            <div class='card-body'>
                              <div class='row'>
                                <div class='col-6 '>
                                  <label for='user_name".$reservation[0]."'>Name</label>
                                  <input type='text' class='form-control text-capitalize text-center' id='user_name".$reservation[0]."' name='user_name".$reservation[0]."' value='".$reservation[4]."'>
                                </div>
                                <div class='col-3'>
                                  <label for='user_lastName".$reservation[0]."'>Last Name</label>
                                  <input type='text' class='form-control text-capitalize text-center' id='user_lastName".$reservation[0]."' name='user_lastName".$reservation[0]."' value='".$reservation[5]."'>
                                </div>
                                <div class='col-3'>
                                <label for='user_lastName2".$reservation[0]."'>Last Name2</label>
                                <input type='text' class='form-control text-capitalize text-center' id='user_lastName2".$reservation[0]."' name='user_lastName2".$reservation[0]."' value='".$reservation[6]."'>
                                </div>
                              </div>

                              <div class='row'>
                                <div class='col-4'>
                                  <label for='user_phone".$reservation[0]."'>Phone</label>
                                  <input type='text' class='form-control text-center' id='user_phone".$reservation[0]."' name='user_phone".$reservation[0]."' value='".$reservation[7]."'>
                                </div>
                                <div class='col-8'>
                                  <label for='user_email".$reservation[0]."'>Email</label>
                                  <input type='text' class='form-control text-center' id='user_email".$reservation[0]."' name='user_email".$reservation[0]."' value='".$reservation[8]."'>
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- Recipient Info -------------------------------------->
                          <small id='res_number' class='form-text text-light text-left'>Recipient Info</small>
                          <div class='card bg-dark'>
                            <div class='card-body'>
                              <div class='row form-group'>
                                <div class='col-6 '>
                                  <label for='gift_name".$reservation[0]."'>Name</label>
                                  <input type='text' class='form-control text-capitalize text-center' id='gift_name".$reservation[0]."' name='gift_name".$reservation[0]."' value='".$reservation[10]."'>
                                </div>
                                <div class='col-3'>
                                  <label for='gift_lastName".$reservation[0]."'>Recipient Last Name</label>
                                  <input type='text' class='form-control text-capitalize text-center' id='gift_lastName".$reservation[0]."' name='gift_lastName".$reservation[0]."' value='".$reservation[11]."'>
                                </div>
                                <div class='col-3'>
                                <label for='gift_lastName2".$reservation[0]."'>Recipient Last Name2</label>
                                <input type='text' class='form-control text-capitalize text-center' id='gift_lastName2".$reservation[0]."' name='gift_lastName2".$reservation[0]."' value='".$reservation[12]."'>
                                </div>
                              </div>

                              <div class='row form-group'>
                                <div class='col'>
                                  <label for='gift_email".$reservation[0]."'>Recipient Email</label>
                                  <input type='text' class='form-control text-center' id='gift_email".$reservation[0]."' name='gift_email".$reservation[0]."' value='".$reservation[13]."'>
                                </div>
                              </div>

                              <div class='row form-group'>
                                <div class='col'>
                                <label for='gift_note".$reservation[0]."'>Gift Note</label>
                                <textarea class='form-control' id='gift_note".$reservation[0]."' rows='3'>".$reservation[14]."</textarea>
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- Giftcard Status -------------------------------------->
                          <small id='res_number' class='form-text text-light text-left'>Giftcard Info</small>

                          <div class='card bg-dark'>
                            <div class='card-body'>
                              <div class='row form-group'>
                                <div class='col-4'>
                                  <label for='state".$reservation[0]."'>Estado</label>
                                  <select class='form-control' id='state".$reservation[0]."'>";
                                  foreach ($states as $state) {
                                      if ($state[0] == $reservation[18]) {
                                        echo "<option value='".$state[0]."' selected>".ucfirst($state[1])."</option>";
                                      }else {
                                        echo "<option value='".$state[0]."'>".ucfirst($state[1])."</option>";
                                      }
                                  }
                            echo "</select>
                                </div>
                                <div class='col-4'>
                                  <label for='is_gift".$reservation[0]."'>Gift Purchase</label>
                                  <select class='form-control' id='is_gift".$reservation[0]."'>";
                                  if ($reservation[9] == 0) {
                                    echo "
                                      <option value='0' selected>No</option>
                                      <option value='1'>Yes</option>
                                    ";
                                  } else {
                                    echo "
                                      <option value='0'>No</option>
                                      <option value='1' selected>Yes</option>
                                    ";
                                  }
                            echo "</select>
                                </div>
                                <div class='col-4'>
                                  <label for='status".$reservation[0]."'>Status</label>
                                  <select class='form-control' id='status".$reservation[0]."'>";
                                  res_status_selector_switcher($reservation[15]);
                            echo "</select>
                                </div>
                              </div>

                              <div class='row form-group'>
                                <div class='col-8'>
                                  <label for='redeemed_product".$reservation[0]."'>Producto</label>
                                  <select class='form-control' id='redeemed_product".$reservation[0]."'>
                                    <option value='z'>Not Redeemed</option>";
                                    $temp_product_list = DBX::GetProductsByStateID($reservation[18]);
                                    foreach ($temp_product_list as $product) {
                                      if ($reservation[17] == $product[0]) {
                                        echo "<option value='".$product[0]."' selected>".ucfirst($product[3])."</option>";
                                      }else {
                                        echo "<option value='".$product[0]."'>".ucfirst($product[3])."</option>";
                                      }
                                    }
                            echo "</select>
                                </div>
                                <div class='col-4'>
                                  <label for='price".$reservation[0]."'>Price</label>
                                  <select class='form-control' id='price".$reservation[0]."'>";
                                    foreach ($precios as $precio) {
                                      if ($precio[0] == $reservation[2]) {
                                        echo "<option value='".$precio[0]."' selected>$".$precio[1].".00 USD</option>";
                                      } else {
                                        echo "<option value='".$precio[0]."'>$".$precio[1].".00 USD</option>";
                                      }

                                    }
                             echo"</select>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div id='errorMessage".$reservation[0]."' class='alert alert-danger hidden text-center' role='alert'></div>

                          <div class='text-right'>
                            <button type='button' class='btn btn-info add_follow_up_modal' id='fu".$reservation[0]."' data-toggle='modal' data-target='#admin_followUp'>Add Follow-Up</button>
                            <button type='submit' class='btn btn-primary modify_giftcard' id='".$reservation[0]."' >Save</button>
                          </div>
                        </form>
                      </div>

                      <!-- Columna Seguimiento -------------------------------------->
                      <div class='col-4 bg-dark overflow-auto'>
                        <br>";
                        $folloUps = DBX::GetFollowUpsByGiftcardID($reservation[0]);
                        if ($folloUps > 0) {
                          foreach ($folloUps as $folloUp) {
                            $temp_style = fu_type_switcher($folloUp[5]);
                            $temp_user = DBX::GetUSERbyID($_SESSION['user_id']);
                            echo "
                            <div class='row'>
                              <div class='card ".$temp_style." follow_up_test'>
                                <div class='card-header text-left'>
                                  <small>".ucfirst($temp_user['nombre'])." ".ucfirst($temp_user['apellido1'])." / ".$folloUp[3]."</small>
                                </div>
                                <div class='card-body'>
                                  <small class='card-text'>".$folloUp[4]."</small>
                                </div>
                              </div>
                            </div>
                            ";
                          }
                        }else {
                          echo "No follow ups";
                        }

                 echo "</div>
                    </div>
                  </div>
                </div>
              </div>
            ";
          }
        }
      ?>
    </div>

    <!-- Users Tab -->
    <div class="collapse" id="user_tab">
      <table class='table table-hover table-dark'>
        <tbody>
          <?php
            $affi_name = "---";
            foreach ($users as $user) {
              foreach ($affiliados as $affiliado) {
                if ($affiliado[1] == $user[0]) {
                  $affi_name = $affiliado[3];
                }
              }


              echo "
                  <tr>
                    <th scope='row' class='text-capitalize'>".$user[1]." ".$user[2]." ".$user[3]."</th>
                    <td>".$user[4]."</td>
                    <td>".$user[6]."</td>
                    <td class='text-capitalize'>".$affi_name."</td>
                    <td>".access_level_switcher($user[7])."</td>
                    <td>
                      <button class='btn btn-info btn-sm' type='button' data-toggle='modal' data-target='#user".$user[0]."'>
                        <i class='fas fa-pencil-alt'></i>
                      </button>
                    </td>
                  </tr>

                  <!-- Modal User Profile-->
                  <div class='modal fade' id='user".$user[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog' role='document'>
                      <div class='modal-content'>
                        <div class='modal-header'>
                          <h5 class='modal-title'>User Information</h5>
                          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                          </button>
                        </div>
                        <div class='modal-body'>
                          <form class='text-left' action='' method='post'>
                            <label for='name'>Name</label>
                            <input type='text' class='form-control text-capitalize' id='name".$user[0]."' value='".$user[1]."'>
                            <div class='row'>
                              <div class='col'>
                                <label for='last_name1'>Last Name</label>
                                <input type='text' class='form-control text-capitalize' id='last_name1".$user[0]."' value='".$user[2]."'>
                              </div>
                              <div class='col'>
                                <label for='last_name2'>Last Name 2</label>
                                <input type='text' class='form-control text-capitalize' id='last_name2".$user[0]."' value='".$user[3]."'>
                              </div>
                            </div>
                            <label for='email'>Email</label>
                            <input type='text' class='form-control text-lowercase' id='email".$user[0]."' value='".$user[4]."'>
                            <div class='row'>
                              <div class='col'>
                                <label for='phone'>Phone</label>
                                <input type='text' class='form-control text-capitalize bot' id='phone".$user[0]."' value='".$user[6]."'>
                              </div>
                              <div class='col'>
                                <label for='access_level'>Access Level</label>
                                <select class='form-control' id='access_level".$user[0]."'>";
                                  access_level_modal_switcher($user[7]);
                          echo "</select>
                              </div>
                            </div>
                            <div class='row'>
                              <div class='col'>
                                <label for='password'>New Password</label>
                                <input type='password' class='form-control text-capitalize bot' id='password".$user[0]."' value=''>
                              </div>
                              <div class='col'>
                                <label for='confirmed_password'>Comfirmed Password</label>
                                <input type='password' class='form-control text-capitalize' id='comfirmed_pw".$user[0]."' value=''>
                              </div>
                            </div>

                            <div id='errorMessageAdminPro' class='alert alert-danger hidden text-center' role='alert'></div>

                            <div class='text-right'>
                              <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                              <button class='btn btn-primary' id='submitUserProfile".$user[0]."' type='submit'>Save</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
              ";
            }
          ?>
        </tbody>
      </table>
    </div>

    <!-- AFFILIADPS TAB -->
    <div class="collapse" id="affi_tab">
      <div class="card card-body">
        AFILIADOSSSSSS
      </div>
    </div>

    <!-- PRODUCTOS TAB -->
    <div class="collapse" id="product_tab">
      <div class="card card-body">
        PRODUCTOSSSSSSSSSSSSSS
      </div>
    </div>

    <!-- division para desarrollo borrar -->
    <div id="notice" class="alert alert-warning" role="alert">
      <?php
      if (isset($_GET['message'])) {
        // code...
      }else {
        echo "No se encontro ni madres!";
      }

      //print_r($reservations);
      ?>
    </div>

    <!-- Modal Add Follow Up-->
    <div class='modal fade' id='admin_followUp' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
      <div class='modal-dialog' role='document'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title'>Add Follow Up</h5>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>
          <div class='modal-body'>
            <form class='text-left' action='' method='post'>

              <label for='fu_type'>Follow Up Type</label>
              <select class='form-control' id='fu_type'>
                <option value='0'>General</option>
                <option value='2'>Payment</option>
                <option value='3'>Cancelation</option>
                <option value='4'>Important</option>
              </select>
              <label for='follow_up'>Message</label>
              <textarea class='form-control bot' id='follow_up' rows='3'></textarea>
              <input class='hidden' type='text' id='giftcard_id' value=''>
              <div id='errorMessageFU' class='alert alert-danger hidden text-center' role='alert'></div>

              <div class='text-right'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button class='btn btn-primary' id='submitFU' type='submit'>Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- scripts essenciales para funcionamiento pagina  ---------
    <script src="js/add_image.js" charset="utf-8"></script>
    <script src="js/add_product.js" charset="utf-8"></script>
    <script src="js/modify_product.js" charset="utf-8"></script>----->
    <script src="js/admin_panel.js" charset="utf-8"></script>
    <script src="js/modify_admin_pw.js" charset="utf-8"></script>
    <script src="js/modify_giftcard.js" charset="utf-8"></script>
    <script src="js/add_followUp.js" charset="utf-8"></script>
    <script src="js/functions.js" charset="utf-8"></script>
    <!-- scripts essenciales para funcionamiento pagina  -------------->
  </body>
</html>

<?php
function type_switcher($id){
  switch ($id) {
    case 1:
      return "Hotel";
      break;

    case 2:
      return "Restaurante";
      break;

    case 3:
      return "Experiencia";
      break;

    default:
      // code...
      break;
  }
}

function type_switcher_modal($id){
  switch ($id) {
    case 1:
      echo "
        <option value='1' selected>Hotel</option>
        <option value='2'>Restaurante</option>
        <option value='3'>Experiencia</option>
      ";
      break;

    case 2:
      echo "
        <option value='1'>Hotel</option>
        <option value='2' selected>Restaurante</option>
        <option value='3'>Experiencia</option>
      ";
      break;

    case 3:
      echo "
        <option value='1'>Hotel</option>
        <option value='2'>Restaurante</option>
        <option value='3' selected>Experiencia</option>
      ";
      break;

    default:
      // code...
      break;
  }
}

function category_grabber($id){
  $product_categories = DBX::GetProductCategories();
  foreach ($product_categories as $category) {
    if ($category[0] == $id) {
      return ucfirst($category[1]);
    }
  }
}

function price_grabber($id){
  $precios = DBX::GetPrecios();
  foreach ($precios as $precio) {
    if ($precio[0] == $id) {
      return $precio[1];
    }
  }
}

function state_grabber($id){
  $states = DBX::GetStates();
  foreach ($states as $state) {
    if ($state[0] == $id) {
      return $state[1];
    }
  }
}

function status_switcher($id){
  switch ($id) {
    case 0:
      return "<span class='badge badge-warning'>Waiting Approval</span>";
      break;

    case 1:
      return "<span class='badge badge-success'>Approved</span>";
      break;

    case 2:
      return "<span class='badge badge-danger'>Disabled</span>";
      break;

    default:
      // code...
      break;
  }
}

function res_status_switcher($id){
  switch ($id) {
    case 0:
      return "<span class='badge badge-success'>Paid</span>";
      break;

    case 1:
      return "<span class='badge badge-primary'>Redeemed</span>";
      break;

    case 2:
      return "<span class='badge badge-danger'>Cancelled</span>";
      break;

    case 3:
      return "<span class='badge badge-warning'>Disputed</span>";
      break;

    default:
      // code...
      break;
  }
}

function res_status_selector_switcher($id){
  switch ($id) {
    case 0:
      echo "
        <option value='0' selected>Paid</option>
        <option value='1'>Redeemed</option>
        <option value='2'>Cancelled</option>
        <option value='3'>Disputed</option>
      ";
      break;

    case 1:
      echo "
        <option value='0'>Paid</option>
        <option value='1' selected>Redeemed</option>
        <option value='2'>Cancelled</option>
        <option value='3'>Disputed</option>
      ";
      break;

    case 2:
      echo "
        <option value='0'>Paid</option>
        <option value='1'>Redeemed</option>
        <option value='2' selected>Cancelled</option>
        <option value='3'>Disputed</option>
      ";
      break;

    case 3:
      echo "
        <option value='0'>Paid</option>
        <option value='1'>Redeemed</option>
        <option value='2'>Cancelled</option>
        <option value='3' selected>Disputed</option>
      ";
      break;

    default:
      // code...
      break;
  }
}

function fu_type_switcher($id){
  switch ($id) {
    case 0:
      return "bg-info";
      break;

    case 1:
      return "bg-secondary";
      break;

    case 2:
      return "bg-success";
      break;

    case 3:
      return "bg-danger";
      break;

    case 4:
      return "bg-warning";
      break;

    default:
      // code...
      break;
  }
}

function access_level_switcher($id){
  switch ($id) {
    case 0:
      return "<span class='badge badge-info'>Admin</span>";
      break;

    case 1:
      return "<span class='badge badge-success'>Affiliate</span>";
      break;

    case 10:
      return "<span class='badge badge-danger'>Disabled</span>";
      break;

    default:
      // code...
      break;
  }
}

function access_level_modal_switcher($id){
  switch ($id) {
    case 0:
      echo "
        <option value='0' selected>Admin</option>
        <option value='1'>Affiliate</option>
        <option value='2'>Disabled</option>
      ";
      break;

    case 1:
      echo "
        <option value='0'>Admin</option>
        <option value='1' selected>Affiliate</option>
        <option value='2'>Disabled</option>
      ";
      break;

    case 10:
      echo "
        <option value='0'>Admin</option>
        <option value='1'>Affiliate</option>
        <option value='2' selected>Disabled</option>
      ";
      break;

    default:
      // code...
      break;
  }
}
?>
