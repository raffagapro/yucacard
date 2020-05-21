<?php
class ADM{

  static function DisplayReservations(){
    echo '
      <!-- Menu de filtros------------------->
      <div class="text-right bg-dark admin_sub_nav_bar">
        <button type="button" class="btn btn-info btn-sm filter_bar_btn"><i class="fas fa-search"></i></button>
        <button type="button" class="btn btn-info btn-sm filter_bar_btn"><i class="fas fa-filter"></i></button>
        <button type="button" class="btn btn-info btn-sm filter_bar_btn"><i class="fas fa-ban"></i></button>
      </div>';
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
        echo '
        <div class="jumbotron jumbotron-fluid">
          <div class="container">
            <h1 class="display-4">There are no reservations!</h1>
        </div>
        ';
      } else {
        foreach ($reservations as $reservation) {
          //print_r($product);
          if ($reservation[9] == 0) {
            $giftable = "<p><span class="badge badge-pill badge-info">No</span></p>";
          } else {
            $giftable = "<p><span class="badge badge-pill badge-info">Yes</span></p>";
          }

          echo '
            <div class="accordion" id="accordion">
              <div class="card text-white text-capitalize bg-dark">
                <div class="card-header" id="headingOne">
                  <div class="row">
                    <div class="col-3">
                      <p class="text-uppercase">'.$reservation[1].'</p>
                    </div>
                    <div class="col-4">
                    <p class="text-capitalize">'.$reservation[4].' '.$reservation[5].' '.$reservation[6].'</p>
                    </div>
                    <div class="col-2">
                    <p>$".price_grabber($reservation[2]).".00 USD</p>
                    </div>
                    <div class="col-1">
                      <span class="badge badge-info">".state_grabber($reservation[18])."</span>
                    </div>
                    <div class="col-1">
                      <p>".res_status_switcher($reservation[15])."</p>
                    </div>
                    <div class="col-1 text-left">
                      <button class="btn btn-info btn-sm" type="button" data-toggle="collapse" data-target="#collapse".$reservation[0]."" aria-expanded="true" aria-controls="collapseOne">
                        <i class="fas fa-bars"></i>
                      </button>
                    </div>
                  </div>
                </div>


                <div id="collapse".$reservation[0]."" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                  <div class="row">

                    <!-- Reservation Main Body -------------------------------------->
                    <div class="col-8">
                      <form class="admin_cont">
                        <div class="row">
                          <div class="col-4"></div>
                          <div class="col-3">
                            <label for="res_number">Recorded Date</label>
                            <small id="res_number" class="form-text text-light">".$reservation[3]."</small>
                          </div>
                          <div class="col-2">
                            <label for="es_gift">Gift Purchase</label>
                            ".$giftable."
                          </div>
                          <div class="col-3">
                            <label for="res_number">Redeemed Date</label>
                            <small id="res_number" class="form-text text-light">".$reservation[16]."</small>
                          </div>
                        </div>

                        <!-- Buyer Info -------------------------------------->
                        <small id="res_number" class="form-text text-light text-left">Buyer Info</small>
                        <div class="card bg-dark">
                          <div class="card-body">
                            <div class="row">
                              <div class="col-6 ">
                                <label for="user_name".$reservation[0]."">Name</label>
                                <input type="text" class="form-control text-capitalize text-center" id="user_name".$reservation[0]."" name="user_name".$reservation[0]."" value="".$reservation[4]."">
                              </div>
                              <div class="col-3">
                                <label for="user_lastName".$reservation[0]."">Last Name</label>
                                <input type="text" class="form-control text-capitalize text-center" id="user_lastName".$reservation[0]."" name="user_lastName".$reservation[0]."" value="".$reservation[5]."">
                              </div>
                              <div class="col-3">
                              <label for="user_lastName2".$reservation[0]."">Last Name2</label>
                              <input type="text" class="form-control text-capitalize text-center" id="user_lastName2".$reservation[0]."" name="user_lastName2".$reservation[0]."" value="".$reservation[6]."">
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-4">
                                <label for="user_phone".$reservation[0]."">Phone</label>
                                <input type="text" class="form-control text-center" id="user_phone".$reservation[0]."" name="user_phone".$reservation[0]."" value="".$reservation[7]."">
                              </div>
                              <div class="col-8">
                                <label for="user_email".$reservation[0]."">Email</label>
                                <input type="text" class="form-control text-center" id="user_email".$reservation[0]."" name="user_email".$reservation[0]."" value="".$reservation[8]."">
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Recipient Info -------------------------------------->
                        <small id="res_number" class="form-text text-light text-left">Recipient Info</small>
                        <div class="card bg-dark">
                          <div class="card-body">
                            <div class="row form-group">
                              <div class="col-6 ">
                                <label for="gift_name".$reservation[0]."">Name</label>
                                <input type="text" class="form-control text-capitalize text-center" id="gift_name".$reservation[0]."" name="gift_name".$reservation[0]."" value="".$reservation[10]."">
                              </div>
                              <div class="col-3">
                                <label for="gift_lastName".$reservation[0]."">Recipient Last Name</label>
                                <input type="text" class="form-control text-capitalize text-center" id="gift_lastName".$reservation[0]."" name="gift_lastName".$reservation[0]."" value="".$reservation[11]."">
                              </div>
                              <div class="col-3">
                              <label for="gift_lastName2".$reservation[0]."">Recipient Last Name2</label>
                              <input type="text" class="form-control text-capitalize text-center" id="gift_lastName2".$reservation[0]."" name="gift_lastName2".$reservation[0]."" value="".$reservation[12]."">
                              </div>
                            </div>

                            <div class="row form-group">
                              <div class="col">
                                <label for="gift_email".$reservation[0]."">Recipient Email</label>
                                <input type="text" class="form-control text-center" id="gift_email".$reservation[0]."" name="gift_email".$reservation[0]."" value="".$reservation[13]."">
                              </div>
                            </div>

                            <div class="row form-group">
                              <div class="col">
                              <label for="gift_note".$reservation[0]."">Gift Note</label>
                              <textarea class="form-control" id="gift_note".$reservation[0]."" rows="3">".$reservation[14]."</textarea>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Giftcard Status -------------------------------------->
                        <small id="res_number" class="form-text text-light text-left">Giftcard Info</small>

                        <div class="card bg-dark">
                          <div class="card-body">
                            <div class="row form-group">
                              <div class="col-4">
                                <label for="state".$reservation[0]."">Estado</label>
                                <select class="form-control" id="state".$reservation[0]."">';
                                foreach ($states as $state) {
                                    if ($state[0] == $reservation[18]) {
                                      echo "<option value="".$state[0]."" selected>".ucfirst($state[1])."</option>";
                                    }else {
                                      echo "<option value="".$state[0]."">".ucfirst($state[1])."</option>";
                                    }
                                }
                          echo "</select>
                              </div>
                              <div class="col-4">
                                <label for="is_gift".$reservation[0]."">Gift Purchase</label>
                                <select class="form-control" id="is_gift".$reservation[0]."">";
                                if ($reservation[9] == 0) {
                                  echo "
                                    <option value="0" selected>No</option>
                                    <option value="1">Yes</option>
                                  ";
                                } else {
                                  echo "
                                    <option value="0">No</option>
                                    <option value="1" selected>Yes</option>
                                  ";
                                }
                          echo "</select>
                              </div>
                              <div class="col-4">
                                <label for="status".$reservation[0]."">Status</label>
                                <select class="form-control" id="status".$reservation[0]."">";
                                res_status_selector_switcher($reservation[15]);
                          echo "</select>
                              </div>
                            </div>

                            <div class="row form-group">
                              <div class="col-8">
                                <label for="redeemed_product".$reservation[0]."">Producto</label>
                                <select class="form-control" id="redeemed_product".$reservation[0]."">
                                  <option value="z">Not Redeemed</option>";
                                  $temp_product_list = DBX::GetProductsByStateID($reservation[18]);
                                  foreach ($temp_product_list as $product) {
                                    if ($reservation[17] == $product[0]) {
                                      echo "<option value="".$product[0]."" selected>".ucfirst($product[3])."</option>";
                                    }else {
                                      echo "<option value="".$product[0]."">".ucfirst($product[3])."</option>";
                                    }
                                  }
                          echo "</select>
                              </div>
                              <div class="col-4">
                                <label for="price".$reservation[0]."">Price</label>
                                <select class="form-control" id="price".$reservation[0]."">";
                                  foreach ($precios as $precio) {
                                    if ($precio[0] == $reservation[2]) {
                                      echo "<option value="".$precio[0]."" selected>$".$precio[1].".00 USD</option>";
                                    } else {
                                      echo "<option value="".$precio[0]."">$".$precio[1].".00 USD</option>";
                                    }

                                  }
                           echo"</select>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div id="errorMessage".$reservation[0]."" class="alert alert-danger hidden text-center" role="alert"></div>

                        <div class="text-right">
                          <button type="button" class="btn btn-info add_follow_up_modal" id="fu".$reservation[0]."" data-toggle="modal" data-target="#admin_followUp">Add Follow-Up</button>
                          <button type="submit" class="btn btn-primary modify_giftcard" id="".$reservation[0]."" >Save</button>
                        </div>
                      </form>
                    </div>

                    <!-- Columna Seguimiento -------------------------------------->
                    <div class="col-4 bg-dark overflow-auto">
                      <br>";
                      $folloUps = DBX::GetFollowUpsByGiftcardID($reservation[0]);
                      if ($folloUps > 0) {
                        foreach ($folloUps as $folloUp) {
                          $temp_style = fu_type_switcher($folloUp[5]);
                          $temp_user = DBX::GetUSERbyID($_SESSION["user_id"]);
                          echo "
                          <div class="row">
                            <div class="card ".$temp_style." follow_up_test">
                              <div class="card-header text-left">
                                <small>".ucfirst($temp_user["nombre"])." ".ucfirst($temp_user["apellido1"])." / ".$folloUp[3]."</small>
                              </div>
                              <div class="card-body">
                                <small class="card-text">".$folloUp[4]."</small>
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
    ';


  }
}
?>
