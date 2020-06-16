<?php
//-----codigo essencial para que la pagina ------//
require_once 'includes/header.inc.php';
include 'int/functions.php';
Page::ForceLogin();
$products = DBX::GetProductsByAffID($_SESSION['aff_id']);
$aff = DBX::GetAffByUserID($_SESSION['user_id']);
$user = DBX::GetUSERbyID($_SESSION['user_id']);
$product_categories = DBX::GetProductCategories();
$precios = DBX::GetPrecios();
$reservations = DBX::GetAllGiftCard();

//-----codigo essencial para que la pagina ------//
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>DASHBOARD</title>
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
    <div class="container-fluid cus_header">
      <div class="row">
        <img class="page_icon" src="https://avatarfiles.alphacoders.com/200/200276.jpg" alt="">
        <?php //print_r($user); ?>
        <div class="col text-capitalize text-left cus_title">
          <h1 class="h3 font-weight-normal"><?php echo $aff['nombre_empresa']; ?><button type="button" class="btn btn-link btn-sm align-top" data-toggle='modal' data-target='#affi_settings'><i class="fas fa-pencil-alt"></i></button></h1>
          <p><?php echo $user['nombre']." ".$user['apellido1']." ".$user['apellido2']." - <span class='text-lowercase'>".$user['email']."</span><br><span class='aff_name_status_badge align-top'>".status_switcher($aff['aprovado'])."</span>"; ?></p>
        </div>
      </div>
    </div>

    <!-- Modal Affiliado-->
    <div class='modal fade' id='affi_settings' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
      <div class='modal-dialog' role='document'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title'>Profile Information</h5>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>
          <div class='modal-body'>
            <form class='text-left' action='int/add_img.int.php' method='post' enctype='multipart/form-data'>

              <label for='company_name'>Company Name</label>
              <input type='text' class='form-control text-capitalize' id='company_name' value='<?php echo $aff['nombre_empresa']; ?>'>
              <label for='contact_name'>Contact Name</label>
              <input type='text' class='form-control text-capitalize' id='contact_name' value='<?php echo $user['nombre']; ?>'>
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
              <label for='job_title'>Job Tiltle</label>
              <input type='text' class='form-control text-capitalize' id='job_title' value='<?php echo $aff['puesto_admin']; ?>'>
              <label for='email'>Email</label>
              <input type='text' class='form-control text-lowercase' id='affi_email' value='<?php echo $user['email']; ?>'>
              <label for='phone'>Phone</label>
              <input type='text' class='form-control text-capitalize bot' id='affi_phone' value='<?php echo $user['telefono']; ?>'>
              <div id='errorMessageaffi' class='alert alert-danger hidden text-center' role='alert'></div>

              <div class='text-right'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button class='btn btn-info' data-dismiss='modal' type='button' data-toggle='modal' data-target='#affi_change_password'>Change Password</button>
                <button class='btn btn-primary' id='submitAff' type='submit'>Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Change Password-->
    <div class='modal fade' id='affi_change_password' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
      <div class='modal-dialog' role='document'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title'>Change Passwoord</h5>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>
          <div class='modal-body'>
            <form class='text-left' action='int/add_img.int.php' method='post' enctype='multipart/form-data'>

              <label for='old_password'>Current Password</label>
              <input type='password' class='form-control text-capitalize' id='old_password' value=''>
              <label for='new_password'>New Password</label>
              <input type='password' class='form-control text-capitalize' id='new_password' value=''>
              <label for='confirmed_password'>Confirm New Password</label>
              <input type='password' class='form-control text-capitalize bot' id='confirmed_password' value=''>
              <div id='errorMessageaffipass' class='alert alert-danger hidden text-center' role='alert'></div>


              <div class='text-right'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button class='btn btn-primary' id='submitAffPassword' type='submit'>Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="row ">
      <!-- VERTICAL NAV BAR -------------------------------------------->
      <div class="col-2 dash_main_body navbar-dark bg-dark">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
          <?php
            //we capture de "active" style of the collpase, and base on the arguent passed in GET it will activate the correct tab
            $product_collapse = "nav-link active";
            $res_collapse = "nav-link";
            $add_product_collapse = "nav-link";
            $product_collapse2 = "show active";
            $res_collapse2 = "";
            $add_product_collapse2 = "";
            //if a tab was passed to get, passes the variables thru a swticher
            if (isset($_GET['tab'])) {
              switch ($_GET['tab']) {

                case 'product':
                  $product_collapse = "nav-link active";
                  $res_collapse = "nav-link";
                  $add_product_collapse = "nav-link";
                  $product_collapse2 = "show active";
                  $res_collapse2 = "";
                  $add_product_collapse2 = "";
                  break;

                case 'res':
                  $product_collapse = "nav-link";
                  $res_collapse = "nav-link active";
                  $add_product_collapse = "nav-link";
                  $product_collapse2 = "";
                  $res_collapse2 = "show active";
                  $add_product_collapse2 = "";
                  break;

                case 'addP':
                  $product_collapse = "nav-link";
                  $res_collapse = "nav-link";
                  $add_product_collapse = "nav-link active";
                  $product_collapse2 = "";
                  $res_collapse2 = "";
                  $add_product_collapse2 = "show active";
                  break;
              }
            }
          ?>
          <a class="<?php echo $product_collapse; ?>" id="v-pills-products-tab" data-toggle="pill" href="#v-pills-products" role="tab" aria-controls="v-pills-products" aria-selected="true">Products</a>
          <a class="<?php echo $res_collapse; ?>" id="v-pills-reservations-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Reservations</a>
          <?php
          //checks to see if the Affiliate has been approved, and it gives them the ability to add products
          if ($aff['aprovado'] != 0) {
            echo '<a class="'.$add_product_collapse.'" id="v-pills-addProduct-tab" data-toggle="pill" href="#v-pills-add_new_product" role="tab" aria-controls="v-pills-messages" aria-selected="false">Add New Product</a>';
          }
          ?>
          <!--

          <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
          -------->
        </div>
      </div>

      <!-- MAIN BODY -------------------------------------------->
      <div class="col-10 dash_main_body">
        <div class="tab-content" id="v-pills-tabContent">

          <!-- PRODUCTS -------------------------------------------->
          <div class="tab-pane fade <?php echo $product_collapse2; ?>" id="v-pills-products" role="tabpanel" aria-labelledby="v-pills-products-tab">
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
              //limist the ability to add products if affiliate is not approved.
              if (!$products) {
                $preMessage = "";
                if ($aff['aprovado'] == 0) {
                  $preMessage = "<p class='lead'>You will be able to ADD PRODUCTS once you have been approved!</p>";
                }else {
                  $preMessage = "<p class='lead'>Would you like to add a product?</p>
                  <button type='button' class='btn btn-outline-primary' id='add_new_product_tab_jumper'>Add New Product!</button>";
                }
                echo "
                <div class='jumbotron jumbotron-fluid'>
                  <div class='container'>
                    <h1 class='display-4'>There are no products!</h1>
                    ".$preMessage."
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
                  }

                  echo "
                    <div class='accordion' id='accordion".$product[0]."'>
                      <div class='card text-white text-capitalize bg-dark'>
                        <div class='card-header' id='headingOne'>
                          <div class='row'>
                            <div class='col-2'>
                              <p>".$product[3]."</p>
                            </div>
                            <div class='col-2'>
                              <p>".$temp_product_type."</p>
                            </div>
                            <div class='col-2'>
                              <p>".$temp_product_category."</p>
                            </div>
                            <div class='col-2'>
                              <p>$".$temp_product_price.".00 USD</p>
                            </div>
                            <div class='col-2'>
                              <p>".$temp_product_status."</p>
                            </div>
                            <div class='col-2'>
                              <button class='btn btn-link' type='button' data-toggle='collapse' data-target='#collapse".$product[0]."' aria-expanded='true' aria-controls='collapseOne'>
                                <i class='fas fa-bars'></i>
                              </button>
                              <button class='btn btn-link' type='button'>
                                <i class='far fa-eye'></i>
                              </button>
                            </div>
                          </div>
                        </div>

                        <div id='collapse".$product[0]."' class='collapse' aria-labelledby='headingOne' data-parent='#accordion".$product[0]."'>
                          <div class='card-body text-dark bg-light'>
                            <div class='card'>
                              <div class='row no-gutters'>
                                <div class='col-md-4'>
                                  <img src='".$temp_logo."' class='card-img' alt='...'>
                                </div>
                                <div class='col-md-8'>
                                  <div class='card-header text-right'>
                                    <button type='button' class='btn btn-secondary btn-sm' data-toggle='modal' data-target='#modalLogo".$product[0]."'>Logo</button>
                                    <button type='button' class='btn btn-secondary btn-sm' data-toggle='modal' data-target='#modalImg".$product[0]."'>Images</button>
                                    <button type='button' class='btn btn-secondary btn-sm' data-toggle='modal' data-target='#settings".$product[0]."'><i class='fas fa-cog'></i></button>
                                  </div>
                                  <div class='card-body text-left'>
                                    <p class='card-text'>".$product[11]."</p>
                                    <p class='card-text'>".$product[4]." ".$product[5]." - Lat: ".$product[6]." Lon: ".$product[7]."</p>
                                    <p class='card-text text-lowercase'>".$product[8]." - ".$product[9]."</p>

                                    <!-- Images-->
                                    <div class='row justify-content-md-center'>";
                                    //code for handling the carousel images
                                    $temp_imgs = DBX::GetImagesByProductID($product[0]);
                                    //print_r($temp_imgs);
                                    if ($temp_imgs) {
                                      foreach ($temp_imgs as $image) {
                                        echo "
                                        <div class='col-3'>

                                          <a class='' href='#' data-target='#indv_img".$image[0]."' data-toggle='modal'>
                                            <img src='".$image[1]."' alt='' class='image_slider'>
                                          </a>

                                          <!-- Modal SINGLE IMAGE-->
                                          <div class='modal fade' id='indv_img".$image[0]."' data-backdrop='static' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabel' aria-hidden='true'>
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
                                    }

                                echo"</div>

                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Modal Logo-->
                            <div class='modal fade' id='modalLogo".$product[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
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
                                      <input type='file' class='' name='img_file' id='logo_file".$product[0]."' required>
                                      <input class='hidden' type='text' name='product_id' value='".$product[0]."'>
                                      <div class='text-right'>
                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                        <button class='btn btn-primary' id='submitButton".$product[0]."' type='submit'>Add Bat-logo!</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Modal Images-->
                            <div class='modal fade' id='modalImg".$product[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
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
                                      <input type='file' class='' name='img_file' id='image_file".$product[0]."' required>
                                      <input class='hidden' type='text' name='product_id' value='".$product[0]."'>
                                      <div class='text-right'>
                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                        <button class='btn btn-primary' id='submitImg".$product[0]."' type='submit'>Add Bat-Img!</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Modal Settings-->
                            <div class='modal fade' id='settings".$product[0]."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                              <div class='modal-dialog' role='document'>
                                <div class='modal-content'>
                                  <div class='modal-header'>
                                    <h5 class='modal-title'>Product Settings</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                    </button>
                                  </div>
                                  <div class='modal-body'>
                                    <form class='text-left product_settings".$product[0]."' action='' method='post'>
                                      <label for='product_name'>Name</label>
                                      <input type='text' class='form-control text-capitalize' id='product_name".$product[0]."' value='".$product[3]."'>
                                       <div class='row'>
                                        <div class='col'>
                                         <label for='product_type'>Type</label>
                                         <select class='form-control' id='product_type".$product[0]."'>";
                                          type_switcher_modal($product[2]);
                                    echo"</select>
                                        </div>
                                        <div class='col'>
                                         <label for='product_category'>Category</label>
                                         <select class='form-control' id='product_category".$product[0]."'>";
                                           foreach ($product_categories as $category) {
                                             if ($product[12] == $category[0]) {
                                               echo "<option value='".$category[0]."' selected>".ucfirst($category[1])."</option>";
                                             }else {
                                               echo "<option value='".$category[0]."'>".ucfirst($category[1])."</option>";
                                             }
                                           }
                                    echo"</select>
                                        </div>
                                      </div>
                                      <label for='product_address1'>Address</label>
                                      <input type='text' class='form-control text-capitalize' id='product_address1".$product[0]."' name='product_address1".$product[0]."' value='".$product[4]."'>
                                      <label for='product_address2'>Address Cont.</label>
                                      <input type='text' class='form-control text-capitalize' id='product_address2".$product[0]."' name='product_address2".$product[0]."' value='".$product[5]."'>
                                      <div class='row'>
                                       <div class='col'>
                                         <label for='lat'>Latitud</label>
                                         <input type='text' class='form-control text-capitalize' id='lat".$product[0]."' name='lat".$product[0]."' value='".$product[6]."'>
                                       </div>
                                       <div class='col'>
                                         <label for='lon'>Longitude</label>
                                         <input type='text' class='form-control text-capitalize' id='lon".$product[0]."' name='lon".$product[0]."' value='".$product[7]."'>
                                       </div>
                                     </div>
                                     <label for='product_email'>Reservations Email</label>
                                     <input type='text' class='form-control text-lowercase' id='email_reservations".$product[0]."' name='email_reservations".$product[0]."' value='".$product[8]."'>
                                     <div class='row'>
                                      <div class='col'>
                                        <label for='phone'>Reservation Phone</label>
                                        <input type='text' class='form-control text-capitalize' id='phone_reservations".$product[0]."' name='phone_reservations".$product[0]."' value='".$product[9]."'>
                                      </div>";
                                      if ($product[14] == 0) {
                                        echo "<div class='col hidden'>";
                                      }else {
                                        echo "<div class='col'>";
                                      }


                                  echo "<label for='product_status'>Status</label>
                                        <select class='form-control' id='product_status".$product[0]."'>";
                                          if ($product[14] == 1) {
                                            echo "
                                              <option value='1' selected>Enable</option>
                                              <option value='2'>Disable</option>
                                            ";
                                          }elseif ($product[14] == 0) {
                                            echo "<option value='0' selected>Waiting Approval</option>";
                                          }else {
                                            echo "
                                              <option value='1'>Enable</option>
                                              <option value='2' selected>Disable</option>
                                            ";
                                          }
                                    echo"</select>
                                        </div>
                                      </div>
                                      <label for='product_description'>Description</label>
                                      <textarea class='form-control bot' id='product_description".$product[0]."' rows='3'>".$product[11]."</textarea>
                                      <div id='errorMessage".$product[0]."' class='alert alert-danger hidden text-center' role='alert'></div>

                                      <input class='hidden' type='text' name='product_id' value='".$product[0]."'>
                                      <div class='text-right'>
                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                        <button class='btn btn-primary product_mod_btn' id='".$product[0]."' type='submit'>Save</button>
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
                  ";
                }
              }
            ?>

          </div>
          <!-- RESERVATIONS -------------------------------------------->
          <div class="tab-pane fade <?php echo $res_collapse2; ?>" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-reservations-tab">

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

                <!--ITerating portion of RESERVATIONS -------------------------------------------->
                <?php
                  //variable for keeping track if we find any reservations
                  $noRes = 0;
                  //checks if there all products of the Affiliate against all reservations
                  foreach ($products as $product) {
                    $noRes++;
                    foreach ($reservations as $reservation) {
                      if ($product[0] == $reservation[17]) {
                        //if there is even one reservation reset the var to 0
                        $noRes = 0;
                        //iterates thru reservations
                ?>

                <tr>
                  <th>
                    <!---TABLE ROW-------------->
                    <div class="row">
                      <!---RESERVATION NUMBER--------------------->
                      <div class="col-3">
                        <p class="text-uppercase"><?php echo $reservation[1]; ?></p>
                      </div>
                      <!---PRODUCT NAME--------------------->
                      <div class="col-2">
                      <p class="text-capitalize">
                        <?php
                          foreach ($products as $product) {
                            if ($product[0] == $reservation[17]) {
                              echo $product[3];
                            }
                          }
                        ?>
                      </p>
                      </div>
                      <!---PRICE--------------------->
                      <div class="col-2">
                        $<?php echo price_grabber($reservation[2]); ?>.00 USD
                      </div>
                      <!---CREATION DATE--------------------->
                      <div class="col-2">
                        <small id="creation_date" class="form-text text-light"><?php echo $reservation[3]; ?></small>
                      </div>
                      <!---RESERVATION STATUS--------------------->
                      <div class="col-1">
                        <?php
                        if ($reservation[15] == 1) {
                          echo "<span class='badge badge-warning'>Pending</span>";
                        }else {
                          echo res_status_switcher($reservation[15]);
                        }
                        ?>
                      </div>
                      <!---BTNS SECTION--------------------->
                      <div class="col-2">
                        <button class="btn btn-info btn-sm" type="button" data-toggle="collapse" data-target="#reservation_collapse<?php echo $reservation[0]; ?>">
                          <i class="fas fa-bars"></i>
                        </button>
                        <?php if ($reservation[15] == 1) {?>
                          <button class="btn btn-info btn-sm" type="button">
                            <i class="fas fa-check"></i>
                          </button>
                        <?php
                        }
                        ?>
                      </div>
                    </div>

                    <!---COLLAPSE-------------->
                    <div class="collapse" id="reservation_collapse<?php echo $reservation[0]; ?>">
                      <!---BUYERS INFO-------------->
                      <div class="row">
                        <div class="col-1 text-right"><small>Buyer´s Info</small></div>
                      </div>
                      <div class="row">
                        <div class="col-4 text-capitalize"><?php echo $reservation[4]." ".$reservation[5]." ".$reservation[6]; ?></div>
                        <div class="col-3"><?php echo $reservation[8]; ?></div>
                        <div class="col-3"><?php echo $reservation[7]; ?></div>
                      </div>
                      <br>

                      <!---BUYERS INFO-------------->
                      <?php
                      //if the reservation is a gift card dusplay gift recipient info
                        if ($reservation[9] == 1) {
                      ?>
                      <div class="card bg-info text-dark">
                        <div class=" card-body row">
                          <div class="col-1">
                            <p><span class="badge badge-dark" id="es_gift">Gift</span></p>
                          </div>
                          <div class="col-4 text-capitalize text-left"><small><?php echo $reservation[10]." ".$reservation[11]." ".$reservation[12]; ?></small></div>
                          <div class="col-3 text-left"><small><?php echo $reservation[13]; ?></small></div>
                          <div class="col-4 text-capitalize text-left"><small><?php echo $reservation[14]; ?></small></div>
                        </div>
                      </div>
                      <?php
                        }
                      ?>
                    </div>
                  </th>
                </tr>

                <?php
                      }
                    }
                    //if there was no reservations show jumbotron
                    if ($noRes == count($products)) {
                      echo "
                        <div class='jumbotron jumbotron-fluid bg-secondary text-light'>
                          <div class='container'>
                            <h1 class='display-4'>There are no reservations!</h1>
                        </div>";
                    }
                  }
                ?>
                <!--ITerating portion of RESERVATIONS -------------------------------------------->

              </tbody>
            </table>
          </div>
          <!-- ADD NEW PORODUCT -------------------------------------------->
          <div class="tab-pane fade <?php echo $add_product_collapse2; ?>" id="v-pills-add_new_product" role="tabpanel" aria-labelledby="v-pills-addProduct-tab">
            <div class="jumbotron jumbotron-fluid">
              <div class="container">
                <h1 class="display-4">Add New Product</h1>
              </div>
            </div>

            <form class="container-fluid dash-form" action="add_user.php" method="post">

                <!-- scripts essenciales para funcionamiento de modulos  -------------->
              <input type="text" class="form-control bot" placeholder="Product Name" name="product_name" required autofocus>
              <div class="row bot">
                <div class="col">
                  <select class="form-control text-capitalize" id="product_type">
                    <option value='z'>Select type</option>
                    <option value='1'>Hotel</option>
                    <option value='2'>Restaurant</option>
                    <option value='3'>Experience</option>
                  </select>
                </div>
                <div class="col">
                  <select class="form-control text-capitalize" id="product_category">
                    <option value='z'>Select Category</option>
                    <?php
                      foreach ($product_categories as $category) {
                          echo "<option value='".$category[0]."'>".ucfirst($category[1])."</option>";
                      }
                    ?>
                  </select>
                </div>
                <div class="col">
                  <select class="form-control text-capitalize" id="product_price">
                    <option value='z'>Select Price</option>
                    <?php
                      foreach ($precios as $precio) {
                          echo "<option value='".$precio[0]."'> $".ucfirst($precio[1]).".00 USD</option>";
                      }
                    ?>
                  </select>
                </div>
              </div>

              <input type="text" class="form-control top" placeholder="Address 1" name="address1" required>
              <input type="text" class="form-control bot" placeholder="Address 2 (optional)" name="address2">
              <div class="row bot">
                <div class="col">
                  <input type="text" class="form-control mid" placeholder="Latitud" name="lat" required>
                </div>
                <div class="col">
                  <input type="text" class="form-control mid" placeholder="Longitude" name="lon" required>
                </div>
              </div>
              <div class="row bot">
                <div class="col-8">
                  <input type="email" class="form-control mid" placeholder="Reservations Email" name="email_reservations" required>
                </div>
                <div class="col-4">
                  <input type="text" class="form-control bot" placeholder="Reservations Phone" name="phone_reservations" required>
                </div>
              </div>

              <textarea class="form-control bot" id="product_desc" rows="3" placeholder="Product Description"></textarea>


              <div id="errorMessage" class="alert alert-danger hidden" role="alert"></div>

              <button class="btn btn-lg btn-primary btn-block" id="submitAddBnt" type="submit">Add Bat-product!</button>
              <p class="mt-5 mb-3 text-muted">&copy; The Bat-App 2017-2020</p>
            </form>
          </div>
        </div>
      </div>
    </div>

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
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- scripts essenciales para funcionamiento pagina  -------------->
    <script src="js/add_image.js" charset="utf-8"></script>
    <script src="js/add_product.js" charset="utf-8"></script>
    <script src="js/modify_product.js" charset="utf-8"></script>
    <script src="js/modify_affi.js" charset="utf-8"></script>
    <script src="js/modify_affi_pw.js" charset="utf-8"></script>
    <script src="js/dashboard.js" charset="utf-8"></script>
    <script src="js/functions.js" charset="utf-8"></script>
    <!-- scripts essenciales para funcionamiento pagina  -------------->
  </body>
</html>
