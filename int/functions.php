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

function city_grabber($state_id, $city_id){
  $cities = DBX::GetCitiesByStateID($state_id);
  foreach ($cities as $city) {
    if ($city[0] == $city_id) {
      return $city[1];
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

function status_selector_switcher($id){
  switch ($id) {
    case 0:
      echo "
        <option value=0 selected>Waiting Approval</option>
        <option value=1>Approved</option>
        <option value=2>Disabled</option>";
      break;

    case 1:
      echo "
        <option value=0>Waiting Approval</option>
        <option value=1 selected>Approved</option>
        <option value=2>Disabled</option>";
      break;

    case 2:
      echo "
        <option value=0>Waiting Approval</option>
        <option value=1>Approved</option>
        <option value=2 selected>Disabled</option>";
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
      return "<span class='badge badge-info'>Accepted</span>";
      break;

    case 3:
      return "<span class='badge badge-danger'>Cancelled</span>";
      break;

    case 4:
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
        <option value='2'>Accepted</option>
        <option value='3'>Cancelled</option>
        <option value='4'>Disputed</option>
      ";
      break;

    case 1:
      echo "
        <option value='0'>Paid</option>
        <option value='1' selected>Redeemed</option>
        <option value='2'>Accepted</option>
        <option value='3'>Cancelled</option>
        <option value='4'>Disputed</option>
      ";
      break;

    case 2:
      echo "
        <option value='0'>Paid</option>
        <option value='1'>Redeemed</option>
        <option value='2' selected>Accepted</option>
        <option value='3'>Cancelled</option>
        <option value='4'>Disputed</option>
      ";
      break;

    case 3:
      echo "
        <option value='0'>Paid</option>
        <option value='1'>Redeemed</option>
        <option value='2'>Accepted</option>
        <option value='3' selected>Cancelled</option>
        <option value='4'>Disputed</option>
      ";
      break;

    case 4:
      echo "
        <option value='0'>Paid</option>
        <option value='1'>Redeemed</option>
        <option value='2'>Accepted</option>
        <option value='3'>Cancelled</option>
        <option value='4' selected>Disputed</option>
      ";
      break;

    default:
      // code...
      break;
  }
}

function access_level_switcher($id){
  switch ($id) {
    case 0:
      echo "<span class='badge badge-info'>Admin</span>";
      break;

    case 1:
      echo "<span class='badge badge-success'>Affiliate</span>";
      break;

    case 2:
      echo "<span class='badge badge-danger'>Disabled</span>";
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

    case 2:
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

function followup_style_switcher($id){
  switch ($id) {
    case 0:
      echo "bg-info";
      break;

    case 1:
      echo "bg-secondary";
      break;

    case 2:
      echo "bg-success";
      break;

    case 3:
      echo "bg-danger";
      break;

    case 4:
      echo "bg-warning";
      break;
  }
}

 ?>
