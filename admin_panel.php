<?php
//-----codigo essencial para que la pagina ------//
require_once 'includes/header.inc.php';
include 'int/functions.php';
Page::ForceLogin();
$user = DBX::GetUSERbyID($_SESSION['user_id']);
$product_categories = DBX::GetProductCategories();
$states = DBX::GetStates();
$affiliados = DBX::GetAllAffi();
$prices = DBX::GetPrecios();


// filtering includes
include 'includes/admin_panel_res_filtering.inc.php';
include 'includes/admin_panel_user_filtering.inc.php';



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
      <button class="btn btn-info btn-sm" id="res_btn" type="button" data-toggle="collapse" data-target="#reservations">
        Reservations
      </button>
      <button class="btn btn-info btn-sm" id="user_btn" type="button" data-toggle="collapse" data-target="#user_tab">
        Users
      </button>
      <button class="btn btn-info btn-sm" id="affi_btn" type="button" data-toggle="collapse" data-target="#affi_tab">
        Affiliates
      </button>
    </p>

    <!-- Collapse CONTENIDO---------------------------------->
    <?php
      //we capture de "active" style of the collpase, and base on the arguent passed in GET it will activate the correct tab
      $res_collapse = "collapse show";
      $user_collapse = "collapse";
      $affi_collapse = "collapse";
      $product_collapse = "collapse";
      //if a tab was passed to get, passes the variables thru a swticher
      if (isset($_GET['tab'])) {
        switch ($_GET['tab']) {
          case 'res':
            $res_collapse = "collapse show";
            $user_collapse = "collapse";
            $affi_collapse = "collapse";
            $product_collapse = "collapse";
            break;

          case 'user':
            $res_collapse = "collapse";
            $user_collapse = "collapse show";
            $affi_collapse = "collapse";
            $product_collapse = "collapse";
            break;

          case 'affi':
            $res_collapse = "collapse";
            $user_collapse = "collapse";
            $affi_collapse = "collapse show";
            $product_collapse = "collapse";
            break;

          case 'product':
            $res_collapse = "collapse";
            $user_collapse = "collapse";
            $affi_collapse = "collapse";
            $product_collapse = "collapse show";
            break;
        }
      }
    ?>
    <!-- RESERVATIONS TAB------------------------------------------------------------------------------------------------->
    <div class="<?php echo $res_collapse; ?>" id="reservations">
      <!-- Menu de filtros------------------->
      <div class="text-right bg-dark admin_sub_nav_bar">
        <button type="button" class="btn btn-info btn-sm filter_bar_btn" data-toggle="modal" data-target="#search_reservation_modal"><i class="fas fa-search"></i></button>
        <a href="admin_panel.php" class="btn btn-info btn-sm filter_bar_link asc_sort_btn" role="button"><i class="fas fa-sort-amount-up-alt"></i></a>
        <a href="admin_panel.php" class="btn btn-info btn-sm filter_bar_link desc_sort_btn" role="button"><i class="fas fa-sort-amount-down"></i></a>
        <a href="" class="btn btn-info btn-sm filter_bar_link clear_filters_btn" role="button"><i class="fas fa-ban"></i></a>
      </div>

      <!-- Modal SEARCH NAME-->
      <div class='modal fade' id='search_reservation_modal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
        <div class='modal-dialog' role='document'>
          <div class='modal-content'>
            <div class='modal-header'>
              <h5 class='modal-title'>Search Reservations</h5>
              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>
            <div class='modal-body'>
              <form class='text-center' action='admin_panel.php' method='GET'>

                <label for='search_name'>Name</label>
                <input type='text' class='form-control text-capitalize' name='search_name' value=''>
                <label for='search_reservation_number'>Reservation Number</label>
                <input type='text' class='form-control text-capitalize' name='search_reservation_number' value=''>
                <label for='search_email'>Email</label>
                <input type='email' class='form-control' name='search_email' value=''>
                <label for='search_date'>Creation Date</label>
                <input class='form-control bot' id='litepicker' name='litepicker'>
                <input type="hidden" name="search" value="on">
                <input type="hidden" name="tab" value="res">
                <div id='errorMessageSearch' class='alert alert-danger hidden text-center' role='alert'></div>


                <div class='text-right'>
                  <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                  <button class='btn btn-primary' id='submitSearchRes' type='submit'>Search</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabla de Reservaciones------------------->
      <table class="table table-hover table-dark">
        <tbody>

          <?php
          //iterates thru reservations
          if (!isset($reservations) || !$reservations) {
            echo "
              <div class='jumbotron jumbotron-fluid bg-secondary text-light'>
                <div class='container'>
                  <h1 class='display-4'>There are no reservations!</h1>
              </div>
            ";
          } else {
            foreach ($reservations as $reservation) {?>
            <tr>
              <th>
                <!---TABLE ROW-------------->
                <div class="row">
                  <div class="col-3">
                    <p class="text-uppercase"><?php echo $reservation[1]; ?></p>
                  </div>
                  <div class="col-3">
                  <p class="text-capitalize"><?php echo $reservation[4]." ".$reservation[5]." ".$reservation[6]; ?></p>
                  </div>
                  <div class="col-2">
                    <p>$<?php echo price_grabber($reservation[2]); ?>.00 USD</p>
                  </div>
                  <div class="col-1">
                    <span class="badge badge-info text-capitalize"><?php echo state_grabber($reservation[18]); ?></span>
                  </div>
                  <div class="col-2">
                    <?php echo res_status_switcher($reservation[15]); ?>
                  </div>
                  <div class="col-1 text-left">
                    <button class="btn btn-info btn-sm" type="button" data-toggle="collapse" data-target="#reservation_collapse<?php echo $reservation[0]; ?>">
                      <i class="fas fa-bars"></i>
                    </button>
                  </div>
                </div>

                <!---HEADER-------------->
                <div class="collapse" id="reservation_collapse<?php echo $reservation[0]; ?>">
                <div class="row">
                  <!---Reservation Main Body-------------->
                  <div class="col-8">
                    <form class="admin_cont" id="reservation_info<?php echo $reservation[0]; ?>">
                      <div class="row">
                        <div class="col-4"></div>
                        <div class="col-3">
                          <label for="creation_date">Recorded Date</label>
                          <small id="rcreation_date" class="form-text text-light"><?php echo $reservation[3]; ?></small>
                        </div>
                        <div class="col-2">
                          <label for="es_gift">Gift Purchase</label>
                          <p><span class="badge badge-info" id="es_gift">
                            <?php
                              if ($reservation[9] == 0) {
                                echo "No";
                              }else {
                                echo "Yes";
                              }
                             ?>
                          </span></p>
                        </div>
                        <div class="col-3">
                          <label for="res_number">Redeemed Date</label>
                          <small id="res_number" class="form-text text-light"><?php echo $reservation[16]; ?></small>
                        </div>
                      </div>

                      <!---Buyer Info -------------------------------------->
                      <small id="res_number" class="form-text text-light text-left">Buyer Info</small>
                      <div class="card bg-dark">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-6 ">
                              <label for="user_name">Name</label>
                              <input type="text" class="form-control text-capitalize text-center" name="user_name" value="<?php echo $reservation[4]; ?>">
                            </div>
                            <div class="col-3">
                              <label for="user_lastName">Last Name</label>
                              <input type="text" class="form-control text-capitalize text-center" name="user_lastName" value="<?php echo $reservation[5]; ?>">
                            </div>
                            <div class="col-3">
                            <label for="user_lastName2">Last Name2</label>
                            <input type="text" class="form-control text-capitalize text-center" name="user_lastName2" value="<?php echo $reservation[6]; ?>">
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-4">
                              <label for="user_phone">Phone</label>
                              <input type="text" class="form-control text-center" name="user_phone" value="<?php echo $reservation[7]; ?>">
                            </div>
                            <div class="col-8">
                              <label for="user_email">Email</label>
                              <input type="text" class="form-control text-center" name="user_email" value="<?php echo $reservation[8]; ?>">
                            </div>
                          </div>
                        </div>
                      </div>

                      <!---Recipient Info -------------------------------------->
                      <small id="res_number" class="form-text text-light text-left">Recipient Info</small>
                      <div class="card bg-dark">
                        <div class="card-body">
                          <div class="row form-group">
                            <div class="col-6 ">
                              <label for="gift_name">Name</label>
                              <input type="text" class="form-control text-capitalize text-center" name="gift_name" value="<?php echo $reservation[10]; ?>">
                            </div>
                            <div class="col-3">
                              <label for="gift_lastName">Recipient Last Name</label>
                              <input type="text" class="form-control text-capitalize text-center" name="gift_lastName" value="<?php echo $reservation[11]; ?>">
                            </div>
                            <div class="col-3">
                            <label for="gift_lastName2">Recipient Last Name2</label>
                            <input type="text" class="form-control text-capitalize text-center" name="gift_lastName2" value="<?php echo $reservation[12]; ?>">
                            </div>
                          </div>

                          <div class="row form-group">
                            <div class="col">
                              <label for="gift_email">Recipient Email</label>
                              <input type="text" class="form-control text-center" name="gift_email" value="<?php echo $reservation[13]; ?>">
                            </div>
                          </div>

                          <div class="row form-group">
                            <div class="col">
                            <label for="gift_note">Gift Note</label>
                            <textarea class="form-control" id="gift_note<?php echo $reservation[0];?>" rows="3"><?php echo $reservation[14]; ?></textarea>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!---Giftcard Status -------------------------------------->
                      <small id="res_number" class="form-text text-light text-left">Giftcard Info</small>

                      <div class="card bg-dark">
                        <div class="card-body">
                          <div class="row form-group">
                            <div class="col-4">
                              <label for="state">Estado</label>
                              <select class="form-control text-capitalize" id="state<?php echo $reservation[0];?>">
                                <?php
                                //creating option list with states
                                foreach ($states as $state) {
                                  if ($state[0] == $reservation[18]) {
                                    echo '<option value="'.$state[0].'" selected>'.$state[1].'</option>';
                                  } else {
                                    echo '<option value="'.$state[0].'">'.$state[1].'</option>';
                                  }
                                }
                                ?>
                              </select>
                            </div>
                            <div class="col-4">
                              <label for="is_gift">Gift Purchase</label>
                              <select class="form-control" id="is_gift<?php echo $reservation[0];?>">
                                <?php
                                  //creating optios for the yes/no is gift selector
                                  if ($reservation[9] == 0) {
                                    echo '
                                    <option value="0" selected>No</option>
                                    <option value="1">Yes</option>';
                                  }else {
                                    echo '
                                    <option value="0">No</option>
                                    <option value="1" selected>Yes</option>';
                                  }
                                ?>
                              </select>
                            </div>
                            <div class="col-4">
                              <label for="status">Status</label>
                              <select class="form-control" id="status<?php echo $reservation[0];?>">
                                <?php
                                  //creating option for the status selector
                                  res_status_selector_switcher($reservation[15]);
                                ?>
                              </select>
                            </div>
                          </div>

                          <div class="row form-group">
                            <div class="col-8">
                              <label for="redeemed_product">Producto</label>
                              <select class="form-control text-capitalize" id="redeemed_product<?php echo $reservation[0];?>">
                                <option value="z">Not Redeemed</option>
                                <?php
                                  //creating product options base on the state id of the reservation
                                  $tempProducts = DBX::GetProductsByStateID($reservation[18]);
                                  foreach ($tempProducts as $tempProduct) {
                                    if ($tempProduct[0] == $reservation[17]) {
                                      echo '<option value="'.$tempProduct[0].'" selected>'.$tempProduct[3].'</option>';
                                    } else {
                                      echo '<option value="'.$tempProduct[0].'">'.$tempProduct[3].'</option>';
                                    }
                                  }
                                ?>
                              </select>
                            </div>
                            <div class="col-4">
                              <label for="price">Price</label>
                              <select class="form-control" id="price<?php echo $reservation[0];?>">;
                                <?php
                                  //Creating select options for the $prices
                                  foreach ($prices as $price) {
                                    if ($price[0] == $reservation[2]) {
                                      echo '<option value="'.$price[0].'" selected>$'.$price[1].'.00 USD</option>';
                                    } else {
                                      echo '<option value="'.$price[0].'">$'.$price[1].'.00 USD</option>';
                                    }

                                  }
                                ?>

                              </select>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div id="errorMessage" class="alert alert-danger hidden text-center" role="alert"></div>

                      <div class="text-right">
                        <button type="button" class="btn btn-info add_follow_up_modal q_fix" id="fu<?php echo $reservation[0]; ?>" data-toggle="modal" data-target="#admin_followUp">Add Follow-Up</button>
                        <button type="submit" class="btn btn-success modify_giftcard q_fix" id="<?php echo $reservation[0]; ?>">Save</button>
                      </div>
                    </form>
                  </div>

                  <!---Columna Seguimiento -------------------------------------->
                  <div class="col-4 bg-dark overflow-auto">
                    <br>

                    <?php
                    //itarates thru the follow ups associated to the reservation
                    $followUps = DBX::GetFollowUpsByGiftcardID($reservation[0]);
                    if (!$followUps) {
                      echo '<h3 class="text-center">No follow ups</h3>';
                    } else {

                    foreach ($followUps as $followUp) { ?>

                      <div class="row">
                        <div class="card <?php followup_style_switcher($followUp[5]); ?> follow_up_test">
                          <div class="card-header text-left">
                            <small>
                              <?php
                              foreach ($users as $user) {
                                if ($user[0] == $followUp[2]) {
                                  echo $user[1].' '.$user[2].' '.$user[3].' - '.$followUp[3];
                                }
                              }
                              ?>
                            </small>
                          </div>
                          <div class="card-body">
                            <small class="card-text text-capitalize"><?php echo $followUp[4]; ?></small>
                          </div>
                        </div>
                      </div>
                    <?php }} ?>

                  </div>
                </div>
              </div>
             </th>
            </tr>

          <?php }} ?>

        </tbody>
      </table>
    </div>

    <!-- USERS TAB -------------------------------------------------------------------------->
    <div class="<?php echo $user_collapse; ?>" id="user_tab">
      <!-- Menu de filtros------------------->
      <div class="text-right bg-dark admin_sub_nav_bar">
        <button type="button" class="btn btn-info btn-sm filter_bar_btn" data-toggle="modal" data-target="#search_user_modal"><i class="fas fa-search"></i></button>
        <a href="admin_panel.php" class="btn btn-info btn-sm filter_bar_link asc_sort_btn" role="button"><i class="fas fa-sort-amount-up-alt"></i></a>
        <a href="admin_panel.php" class="btn btn-info btn-sm filter_bar_link desc_sort_btn" role="button"><i class="fas fa-sort-amount-down"></i></a>
        <!-- Need to add functionality to refrech in the correct open tab------------>
        <a href="" class="btn btn-info btn-sm filter_bar_link clear_filters_btn" role="button"><i class="fas fa-ban"></i></a>
      </div>

      <!-- Modal SEARCH NAME-->
      <div class='modal fade' id='search_user_modal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
        <div class='modal-dialog' role='document'>
          <div class='modal-content'>
            <div class='modal-header'>
              <h5 class='modal-title'>Search User</h5>
              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>
            <div class='modal-body'>
              <form class='text-center' action='admin_panel.php' method='GET'>

                <label for='search_name'>Name</label>
                <input type='text' class='form-control text-capitalize' name='search_usr_name' value=''>
                <label for='search_email'>Email</label>
                <input type='email' class='form-control bot' name='search_usr_email' value=''>
                <!-- ACTIVATES SEARCH filtering for USERS Panel-->
                <input type="hidden" name="search_users" value="on">
                <!-- SENDS the correct TAB to get-->
                <input type="hidden" name="tab" value="user">
                <div id='errorMessageSearch' class='alert alert-danger hidden text-center' role='alert'></div>


                <div class='text-right'>
                  <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                  <button class='btn btn-primary' id='submitSearchRes' type='submit'>Search</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabla de USERS    ------------------------------------------->
      <table class='table table-hover table-dark'>
        <tbody>
          <?php
          //OPENING of a foreach to loop thru all the users -----------------------------------------------------
            $affi_name = "---";
            foreach ($users as $user) {
              foreach ($affiliados as $affiliado) {
                if ($affiliado[1] == $user[0]) {
                  $affi_name = $affiliado[3];
                }
              }
          ?>

          <tr>
            <th scope='row' class='text-capitalize'><?php echo $user[1]." ".$user[2]." ".$user[3]; ?></th>
            <td><?php echo $user[4]; ?></td>
            <td><?php echo $user[6]; ?></td>
            <td class='text-capitalize'><?php echo $affi_name; ?></td>
            <td><?php access_level_switcher($user[7]); ?></td>
            <td>
              <button class='btn btn-info btn-sm' type='button' data-toggle='modal' data-target='#user<?php echo $user[0]; ?>'>
                <i class='fas fa-pencil-alt'></i>
              </button>
            </td>
          </tr>

          <!-- Modal User Profile-->
          <div class='modal fade' id='user<?php echo $user[0]; ?>' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
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
                    <input type='text' class='form-control text-capitalize' id='user_name<?php echo $user[0]; ?>' value='<?php echo $user[1]; ?>'>
                    <div class='row'>
                      <div class='col'>
                        <label for='last_name1'>Last Name</label>
                        <input type='text' class='form-control text-capitalize' id='user_last_name1<?php echo $user[0]; ?>' value='<?php echo $user[2]; ?>'>
                      </div>
                      <div class='col'>
                        <label for='last_name2'>Last Name 2</label>
                        <input type='text' class='form-control text-capitalize' id='user_last_name2<?php echo $user[0]; ?>' value='<?php echo $user[3]; ?>'>
                      </div>
                    </div>
                    <label for='email'>Email</label>
                    <input type='text' class='form-control text-lowercase' id='user_email<?php echo $user[0]; ?>' value='<?php echo $user[4]; ?>'>
                    <div class='row'>
                      <div class='col'>
                        <label for='phone'>Phone</label>
                        <input type='text' class='form-control text-capitalize bot' id='user_phone<?php echo $user[0]; ?>' value='<?php echo $user[6]; ?>'>
                      </div>
                      <div class='col'>
                        <label for='access_level'>Access Level</label>
                        <select class='form-control' id='user_access_level<?php echo $user[0]; ?>'>
                          <?php access_level_modal_switcher($user[7]); ?>
                        </select>
                      </div>
                    </div>
                    <div class='row'>
                      <div class='col'>
                        <label for='password'>New Password</label>
                        <input type='password' class='form-control text-capitalize' id='user_password<?php echo $user[0]; ?>' value=''>
                      </div>
                      <div class='col'>
                        <label for='confirmed_password'>Comfirmed Password</label>
                        <input type='password' class='form-control text-capitalize' id='user_comfirmed_pw<?php echo $user[0]; ?>' value=''>
                      </div>
                    </div>

                    <div id='errorMessageUserMod<?php echo $user[0]; ?>' class='alert alert-danger hidden text-center' role='alert'></div>

                    <div class='text-right'>
                      <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                      <button class='btn btn-primary submitUserProfile' id='usr<?php echo $user[0]; ?>' type='submit'>Save</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <?php
            }
            //CLOING of a foreach to loop thru all the users -----------------------------------------------------
          ?>
        </tbody>
      </table>
    </div>

    <!-- AFFILIADPS TAB ----------------------------------------------------------->
    <div class="<?php echo $affi_collapse; ?>" id="affi_tab">
      <!-- Menu de filtros------------------->
      <div class="text-right bg-dark admin_sub_nav_bar">
        <button type="button" class="btn btn-info btn-sm filter_bar_btn" data-toggle="modal" data-target="#search_affi_modal"><i class="fas fa-search"></i></button>
        <a href="admin_panel.php" class="btn btn-info btn-sm filter_bar_link asc_sort_btn" role="button"><i class="fas fa-sort-amount-up-alt"></i></a>
        <a href="admin_panel.php" class="btn btn-info btn-sm filter_bar_link desc_sort_btn" role="button"><i class="fas fa-sort-amount-down"></i></a>
        <a href="" class="btn btn-info btn-sm filter_bar_link clear_filters_btn" role="button"><i class="fas fa-ban"></i></a>
      </div>

      <!-- Modal SEARCH NAME-->
      <div class='modal fade' id='search_affi_modal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
        <div class='modal-dialog' role='document'>
          <div class='modal-content'>
            <div class='modal-header'>
              <h5 class='modal-title'>Search Affiliados</h5>
              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>
            <div class='modal-body'>
              <form class='text-center' action='admin_panel.php' method='GET'>

                <label for='search_name'>Name</label>
                <input type='text' class='form-control text-capitalize' name='search_name' value=''>
                <label for='search_reservation_number'>Reservation Number</label>
                <input type='text' class='form-control text-capitalize' name='search_reservation_number' value=''>
                <label for='search_email'>Email</label>
                <input type='email' class='form-control' name='search_email' value=''>
                <input type="hidden" name="search" value="on">
                <input type="hidden" name="tab" value="res">
                <div id='errorMessageSearch' class='alert alert-danger hidden text-center' role='alert'></div>


                <div class='text-right'>
                  <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                  <button class='btn btn-primary' id='submitSearchAffi' type='submit'>Search</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabla de Afiliados------------------->
      <table class="table table-hover table-dark">
        <tbody>

          <?php
          //iterates thru reservations
          if (!isset($affiliados) || !$affiliados) {
            echo "
              <div class='jumbotron jumbotron-fluid bg-secondary text-light'>
                <div class='container'>
                  <h1 class='display-4'>There are no affiliates!</h1>
              </div>
            ";
          } else {
            foreach ($affiliados as $affiliado) {?>
            <tr>
              <th>
                <!---TABLE ROW-------------->
                <div class="row">
                  <div class="col-4">
                    <p class="text-uppercase"><?php echo $affiliado[3]; ?></p>
                  </div>
                  <div class="col-2">
                    <small class="text-uppercase">
                      <?php
                        $tempUserAffi = DBX::GetUSERbyID($affiliado[1]);
                        echo $tempUserAffi['nombre']." ".$tempUserAffi['apellido1']." ".$tempUserAffi['apellido2'];
                      ?>
                    </small>
                  </div>
                  <div class="col-1">
                    <small class="text-uppercase"><?php echo $affiliado[2]; ?></small>
                  </div>
                  <div class="col-1">
                    <span class="badge badge-info text-capitalize"><?php echo state_grabber($affiliado[4]); ?></span>
                  </div>
                  <div class="col-1">
                    <?php
                      //handles what to do if the city was added manualy by the affiliate
                      if ($affiliado[5] == 0) {
                        echo '<span class="badge badge-danger text-capitalize">NIDB';
                      }else {
                        echo '<span class="badge badge-secondary text-capitalize">'.city_grabber($affiliado[4], $affiliado[5]);
                      }
                    ?>
                    </span>
                  </div>
                  <div class="col-1">
                    <?php echo status_switcher($affiliado[6]); ?>
                  </div>
                  <div class="col-2">
                    <button class="btn btn-info btn-sm q_fix_margin_left" type="button" data-toggle="collapse" data-target="#affi_collapse<?php echo $affiliado[0]; ?>">
                      <i class="fas fa-bars"></i>
                    </button><button class="btn btn-info btn-sm q_fix_margin_left" type="button" data-toggle="modal" data-target="#modifying_affi_modal<?php echo $affiliado[0]; ?>">
                      <i class="fas fa-pencil-alt"></i>
                    </button>
                  </div>
                </div>

                <!---HEADER-------------->
                <div class="collapse" id="affi_collapse<?php echo $affiliado[0]; ?>">
                  <?php
                  $products = DBX::GetProductsByAffID($affiliado[0]);
                    if (!$products) {
                      echo "
                      <div class='jumbotron jumbotron-fluid'>
                        <div class='container'>
                          <h1 class='display-4'>There are no products!</h1>
                        </div>
                      </div>
                      ";
                    } else {
                      foreach ($products as $product) {
                        //print_r($product);
                        $temp_product_type = type_switcher($product[2]);
                        $temp_product_category = category_grabber($product[12]);
                        $temp_product_price = price_grabber($product[13]);
                        $temp_product_status = status_switcher($product[14]);
                        $temp_images = DBX::GetImagesByProductID($product[0]);
                        if ($product[10] == "") {
                          $temp_logo = "images/no-image-available-icon.jpg";
                        } else {
                          $temp_logo = $product[10];
                        }?>

                        <div class='accordion' id='accordion<?php echo $product[0]; ?>'>
                          <div class='card text-white text-capitalize bg-secondary'>
                            <div class='card-header' id='headingOne'>
                              <div class='row'>
                                <div class='col-2'>
                                  <p><?php echo $product[3]; ?></p>
                                </div>
                                <div class='col-2'>
                                  <p><?php echo $temp_product_type; ?></p>
                                </div>
                                <div class='col-2'>
                                  <p><?php echo $temp_product_category; ?></p>
                                </div>
                                <div class='col-2'>
                                  <p>$<?php echo $temp_product_price; ?>.00 USD</p>
                                </div>
                                <div class='col-2'>
                                  <p><?php echo $temp_product_status; ?></p>
                                </div>
                                <div class='col-2'>
                                  <button class='btn btn-link btn-info text-light' type='button' data-toggle='collapse' data-target='#collapse<?php echo $product[0]; ?>' aria-expanded='true' aria-controls='collapseOne'>
                                    <i class='fas fa-bars'></i>
                                  </button>
                                  <button class='btn btn-link btn-info text-light' type='button'>
                                    <i class='far fa-eye'></i>
                                  </button>
                                </div>
                              </div>
                            </div>

                            <div id='collapse<?php echo $product[0]; ?>' class='collapse' aria-labelledby='headingOne' data-parent='#accordion<?php echo $product[0]; ?>'>
                              <div class='card-body text-dark bg-light'>
                                <div class='card'>
                                  <div class='row no-gutters'>
                                    <div class='col-md-4'>
                                      <img src='<?php echo $temp_logo ; ?>' class='card-img' alt='...'>
                                    </div>
                                    <div class='col-md-8'>
                                      <div class='card-header text-right'>
                                        <button type='button' class='btn btn-secondary btn-sm' data-toggle='modal' data-target='#modalLogo<?php echo $product[0]; ?>'>Logo</button>
                                        <button type='button' class='btn btn-secondary btn-sm' data-toggle='modal' data-target='#modalImg<?php echo $product[0]; ?>'>Images</button>
                                        <button type='button' class='btn btn-secondary btn-sm' data-toggle='modal' data-target='#settings<?php echo $product[0]; ?>'><i class='fas fa-cog'></i></button>
                                      </div>
                                      <div class='card-body text-left'>
                                        <p class='card-text'><?php echo $product[11]; ?></p>
                                        <p class='card-text'><?php echo $product[4]." ".$product[5]." - Lat: ".$product[6]." Lon: ".$product[7]; ?></p>
                                        <p class='card-text text-lowercase'><?php echo $product[8]." - ".$product[9]; ?></p>

                                        <!-- Images-->
                                        <div class='row justify-content-md-center'>
                                        <!--code for handling the carousel images-->
                                        <?php
                                        $temp_imgs = DBX::GetImagesByProductID($product[0]);
                                        if ($temp_imgs) {
                                          foreach ($temp_imgs as $image) {
                                            echo "
                                            <div class='col-3'>
                                              <a class='' href='#' data-target='#indv_img".$product[0]."' data-toggle='modal'>
                                                <img src='".$image[1]."' alt='' class='image_slider'>
                                              </a>

                                              <!-- Modal SINGLE IMAGE--------------------------------------------------->
                                              <div class='modal fade' id='indv_img".$product[0]."' data-backdrop='static' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabel' aria-hidden='true'>
                                                <div class='modal-dialog' role='document'>
                                                  <div class='modal-content'>
                                                    <form action='int/delete_img.int.php' method='post'>
                                                      <div class='modal-body'>
                                                        <img src='".$image[1]."' alt='' class='image_single_modal'>
                                                        <input class='hidden' type='text' name='image_id' value='".$image[0]."'>
                                                      </div>
                                                      <div class='modal-footer'>
                                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                                        <button type='submit' class='btn btn-danger'>Delete Image</button>
                                                      </div>
                                                    </form>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>";
                                          }
                                        }else {
                                          echo "<img src='images/no-image-available-icon.jpg' alt='' class='image_slider'>";
                                        }?>
                                       </div>

                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <!-- Modal Logo--------------------------------------->
                                <div class='modal fade' id='modalLogo<?php echo $product[0]; ?>' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                  <div class='modal-dialog' role='document'>
                                    <div class='modal-content'>
                                      <div class='modal-header'>
                                        <h5 class='modal-title'>Select Logo Image</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                          <span aria-hidden='true'>&times;</span>
                                        </button>
                                      </div>
                                      <div class='modal-body'>
                                        <form class='text-left' action='int/add_logo.int.php' method='post' enctype='multipart/form-data'>
                                          <label form='exampleFormControlFile1'>( PNG only, and 5mb max.)</label>
                                          <input type='file' class='' name='img_file' id='logo_file<?php echo $product[0]; ?>' required>
                                          <input class='hidden' type='text' name='product_id' value='<?php echo $product[0]; ?>'>
                                          <div class='text-right'>
                                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                            <button class='btn btn-primary' id='submitButton<?php echo $product[0]; ?>' type='submit'>Add Bat-logo!</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <!-- Modal Images------------------------------------------->
                                <div class='modal fade' id='modalImg<?php echo $product[0]; ?>' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                  <div class='modal-dialog' role='document'>
                                    <div class='modal-content'>
                                      <div class='modal-header'>
                                        <h5 class='modal-title'>Select Image</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                          <span aria-hidden='true'>&times;</span>
                                        </button>
                                      </div>
                                      <div class='modal-body'>
                                        <form class='text-left' action='int/add_img.int.php' method='post' enctype='multipart/form-data'>
                                          <label form='exampleFormControlFile1' class='text-capitalize'>(Allowed extensions: PNG, JPG, JPEG and 5mb max.)</label>
                                          <input type='file' class='' name='img_file' id='image_file<?php echo $product[0]; ?>' required>
                                          <input class='hidden' type='text' name='product_id' value='<?php echo $product[0]; ?>'>
                                          <div class='text-right'>
                                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                            <button class='btn btn-primary' id='submitImg<?php echo $product[0]; ?>' type='submit'>Add Bat-Img!</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <!-- Modal Product Settings--------------------------------------------------->
                                <div class='modal fade' id='settings<?php echo $product[0]; ?>' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                  <div class='modal-dialog' role='document'>
                                    <div class='modal-content'>
                                      <div class='modal-header'>
                                        <h5 class='modal-title'>Product Settings</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                          <span aria-hidden='true'>&times;</span>
                                        </button>
                                      </div>
                                      <div class='modal-body'>
                                        <form class='text-left product_settings<?php echo $product[0]; ?>' action='' method='post'>
                                          <label for='product_name'>Name</label>
                                          <input type='text' class='form-control text-capitalize' id='product_name<?php echo $product[0]; ?>' value='<?php echo $product[3]; ?>'>
                                           <div class='row'>
                                            <div class='col'>
                                             <label for='product_type'>Type</label>
                                             <select class='form-control' id='product_type<?php echo $product[0]; ?>'>
                                              <?php type_switcher_modal($product[2]);  ?>
                                            </select>
                                            </div>
                                            <div class='col'>
                                              <label for='product_category'>Category</label>
                                              <select class='form-control' id='product_category<?php echo $product[0]; ?>'>
                                                <?php
                                                 foreach ($product_categories as $category) {
                                                   if ($product[12] == $category[0]) {
                                                     echo "<option value='".$category[0]."' selected>".ucfirst($category[1])."</option>";
                                                   }else {
                                                     echo "<option value='".$category[0]."'>".ucfirst($category[1])."</option>";
                                                   }
                                                 }
                                                ?>
                                              </select>
                                            </div>
                                          </div>
                                          <label for='product_address1'>Address</label>
                                          <input type='text' class='form-control text-capitalize' id='product_address1<?php echo $product[0]; ?>' name='product_address1<?php echo $product[0]; ?>' value='<?php echo $product[4]; ?>'>
                                          <label for='product_address2'>Address Cont.</label>
                                          <input type='text' class='form-control text-capitalize' id='product_address2<?php echo $product[0]; ?>' name='product_address2<?php echo $product[0]; ?>' value='<?php echo $product[5]; ?>'>
                                          <div class='row'>
                                           <div class='col'>
                                             <label for='lat'>Latitud</label>
                                             <input type='text' class='form-control text-capitalize' id='lat<?php echo $product[0]; ?>' name='lat<?php echo $product[0]; ?>' value='<?php echo $product[6]; ?>'>
                                           </div>
                                           <div class='col'>
                                             <label for='lon'>Longitude</label>
                                             <input type='text' class='form-control text-capitalize' id='lon<?php echo $product[0]; ?>' name='lon<?php echo $product[0]; ?>' value='<?php echo $product[7]; ?>'>
                                           </div>
                                         </div>
                                         <label for='product_email'>Reservations Email</label>
                                         <input type='text' class='form-control text-lowercase' id='email_reservations<?php echo $product[0]; ?>' name='email_reservations<?php echo $product[0]; ?>' value='<?php echo $product[8]; ?>'>
                                         <div class='row'>
                                          <div class='col'>
                                            <label for='phone'>Reservation Phone</label>
                                            <input type='text' class='form-control text-capitalize' id='phone_reservations<?php echo $product[0]; ?>' name='phone_reservations<?php echo $product[0]; ?>' value='<?php echo $product[9]; ?>'>
                                          </div>
                                          <div class='col'>
                                            <label for='product_status'>Status</label>
                                            <select class='form-control' id='product_status<?php echo $product[0]; ?>'>
                                              <?php
                                              if ($product[14] == 0) {
                                                echo "
                                                  <option value='0' selected>Waiting Approval</option>
                                                  <option value='1'>Enable</option>
                                                  <option value='2'>Disable</option>";
                                              }elseif ($product[14] == 1) {
                                                echo "
                                                  <option value='0'>Waiting Approval</option>
                                                  <option value='1' selected>Enable</option>
                                                  <option value='2'>Disable</option>";
                                              }else {
                                                echo "
                                                  <option value='0'>Waiting Approval</option>
                                                  <option value='1'>Enable</option>
                                                  <option value='2' selected>Disable</option>";
                                              }?>
                                            </select>
                                          </div>
                                        </div>
                                        <label for='product_description'>Description</label>
                                        <textarea class='form-control bot' id='product_description<?php echo $product[0]; ?>' rows='3'><?php echo $product[11]; ?></textarea>
                                        <div id='errorMessage<?php echo $product[0]; ?>' class='alert alert-danger hidden text-center' role='alert'></div>

                                        <input class='hidden' type='text' name='product_id' value='<?php echo $product[0]; ?>'>
                                        <div class='text-right'>
                                          <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                          <button class='btn btn-primary product_mod_btn' id='<?php echo $product[0]; ?>' type='submit'>Save</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>
                      </div>
                 <?php
                      }
                    }
                    ?>
                </div>
              </th>
            </tr>

            <!-- Modal Affiliate Profile-------------------------------------------------->
            <div class='modal fade' id='modifying_affi_modal<?php echo $affiliado[0]; ?>' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
              <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <h5 class='modal-title'>Affiliate Information</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                      <span aria-hidden='true'>&times;</span>
                    </button>
                  </div>
                  <div class='modal-body text-left'>
                    <form action='' method='POST'>
                      <label for='company_name<?php echo $affiliado[0]; ?>'>Company Name</label>
                      <input type='text' class='form-control text-capitalize bot' id='company_name<?php echo $affiliado[0]; ?>' value='<?php echo $affiliado[3]; ?>'>
                      <label for='contact_name<?php echo $affiliado[0]; ?>'>Contact Name</label>
                      <input type='text' class='form-control text-capitalize bot' id='contact_name<?php echo $affiliado[0]; ?>' value='<?php echo $tempUserAffi['nombre']; ?>'>
                      <div class="row bot">
                        <div class="col">
                          <label for='affi_last_name1<?php echo $affiliado[0]; ?>'>Last Name</label>
                          <input type='text' class='form-control text-capitalize' id='affi_last_name1<?php echo $affiliado[0]; ?>' value='<?php echo $tempUserAffi['apellido1']; ?>'>
                        </div>
                        <div class="col">
                          <label for='affi_last_name2<?php echo $affiliado[0]; ?>'>Last Name 2</label>
                          <input type='text' class='form-control text-capitalize' id='affi_last_name2<?php echo $affiliado[0]; ?>' value='<?php echo $tempUserAffi['apellido2']; ?>'>
                        </div>
                      </div>
                      <label for='affi_email<?php echo $affiliado[0]; ?>'>Email</label>
                      <input type='email' class='form-control text-lowercase bot' id='affi_email<?php echo $affiliado[0]; ?>' value='<?php echo $tempUserAffi['email']; ?>'>
                      <div class="row bot">
                        <div class="col">
                          <label for='affi_phone<?php echo $affiliado[0]; ?>'>Phone</label>
                          <input type='text' class='form-control text-capitalize bot' id='affi_phone<?php echo $affiliado[0]; ?>' value='<?php echo $tempUserAffi['telefono']; ?>'>
                        </div>
                        <div class="col">
                          <label for='job_title<?php echo $affiliado[0]; ?>'>Job Tiltle</label>
                          <input type='text' class='form-control text-capitalize' id='job_title<?php echo $affiliado[0]; ?>' value='<?php echo $affiliado[2]; ?>'>
                        </div>
                      </div>
                      <div class="row bot">
                        <div class="col">
                          <label for='affi_state'>State</label>
                          <select class='form-control text-capitalize affi_statez' id='affi_state<?php echo $affiliado[0]; ?>'>
                            <?php
                            foreach ($states as $state) {
                              if ($state[0] == $affiliado[4]) {
                                echo '<option value="'.$state[0].'" selected>'.$state[1].'</option>';
                              } else {
                                echo '<option value="'.$state[0].'">'.$state[1].'</option>';
                              }
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col">
                          <label for='affi_city'>City</label>
                          <select class='form-control text-capitalize' id='affi_city<?php echo $affiliado[0]; ?>'>
                            <?php
                              //if the city was added manuelly display what was added manually and assigns value "z"
                              if ($affiliado[5] == 0) {
                                echo '<option value="z" selected>'.$affiliado[7].'(NIDB)</option>';
                              } else {
                                $cities = DBX::GetCitiesByStateID($affiliado[4]);
                                foreach ($cities as $city) {
                                  if ($city[0] == $affiliado[5]) {
                                    echo '<option value="'.$city[0].'" selected>'.$city[1].'</option>';
                                  } else {
                                    echo '<option value="'.$city[0].'">'.$city[1].'</option>';
                                  }
                                }
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="row bot">
                        <div class="col">
                          <label for='affi_new_pw<?php echo $affiliado[0]; ?>'>New Password</label>
                          <input type='password' class='form-control text-capitalize' id='affi_new_pw<?php echo $affiliado[0]; ?>' value=''>
                        </div>
                        <div class="col">
                          <label for='affi_confirm_pw<?php echo $affiliado[0]; ?>'>Confirm Password</label>
                          <input type='password' class='form-control text-capitalize' id='affi_confirm_pw<?php echo $affiliado[0]; ?>' value=''>
                        </div>
                      </div>
                      <label for='affi_status'>Status</label>
                      <select class='form-control bot' id='affi_status<?php echo $affiliado[0]; ?>'>
                        <?php status_selector_switcher($affiliado[6]); ?>
                      </select>

                      <div id='errorMessageaffi<?php echo $affiliado[0]; ?>' class='alert alert-danger hidden text-center' role='alert'></div>

                      <div class='text-right'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button class='btn btn-info' data-dismiss='modal' type='button' data-toggle='modal' data-target='#add_city_modal'>Add City</button>
                        <button class='btn btn-primary submitAffAdmin' id='admAfii<?php echo $affiliado[0]; ?>' type='submit'>Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          <?php }} ?>

        </tbody>
      </table>
    </div>

    <!-- Modal Add City Profile-------------------------------------------------->
    <div class='modal fade' id='add_city_modal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
      <div class='modal-dialog' role='document'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title'>Add City</h5>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>
          <div class='modal-body text-left'>
            <form action='' method='POST'>

              <select class="form-control bot" id="state">
                <option value='z'>Select State</option>
                <?php
                  foreach ($states as $state) {
                      echo "<option value='".$state[0]."'>".ucfirst($state[1])."</option>";
                  }
                ?>
              </select>
              <input type="text" class="form-control bot" placeholder="City" name="city" required autofocus>

              <div id='errorMessage' class='alert alert-danger hidden text-center' role='alert'></div>

              <div class='text-right'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button class='btn btn-primary' id='add_city_submit_btn' type='submit'>Save</button>
              </div>
            </form>
          </div>
        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/js/main.js"></script>
    <!-- scripts essenciales para funcionamiento pagina  ---------->
    <script src="js/add_image.js" charset="utf-8"></script>
    <script src="js/add_product.js" charset="utf-8"></script>
    <script src="js/modify_product.js" charset="utf-8"></script>
    <script src="js/admin_panel.js" charset="utf-8"></script>
    <script src="js/modify_admin_pw.js" charset="utf-8"></script>
    <script src="js/add_followUp.js" charset="utf-8"></script>
    <script src="js/admin_panel_filtering.js" charset="utf-8"></script>
    <script src="js/modify_giftcard.js" charset="utf-8"></script>
    <script src="js/modify_user.js" charset="utf-8"></script>
    <script src="js/add_city.js" charset="utf-8"></script>
    <script src="js/modify_affi_admin_panel.js" charset="utf-8"></script>
    <script src="js/functions.js" charset="utf-8"></script>
    <!-- scripts essenciales para funcionamiento pagina  -------------->
  </body>
</html>
