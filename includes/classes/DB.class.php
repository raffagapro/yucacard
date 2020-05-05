<?php
  class DBX{

    static function GetUSERbyEmail($email){
      $link = openlink();

      $query = "SELECT * FROM users WHERE email = ?";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        $resultArray = $result->fetch_assoc();
        if (empty($resultArray)) {
          return false;
        } else {
          return $resultArray;
        }

      }
      closeLink($stmt, $link);
    }

    static function GetUSERbyName($name){
      $link = openlink();

      $query = "SELECT * FROM users WHERE nombre = ?";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        $resultArray = $result->fetch_assoc();
        if (empty($resultArray)) {
          return false;
        } else {
          return $resultArray;
        }

      }
      closeLink($stmt, $link);
    }

    static function AddUSER($name, $name2, $name3, $email, $phone, $hashed_pw){
      $link = openlink();

      $query = "INSERT INTO users (nombre, apellido1, apellido2, email, telefono, password) VALUES (?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "ssssss", $name, $name2, $name3, $email, $phone, $hashed_pw);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        return true;
      }
      closeLink($stmt, $link);
    }

    static function GetStates(){
      $link = openlink();

      $query = "SELECT * FROM estados";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        //mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        $resultArray = $result->fetch_all();
        if (empty($resultArray)) {
          return "no se encontro ni madres!";
        } else {
          return $resultArray;
        }

      }
      closeLink($stmt, $link);
    }

    static function GetStateByID($id){
      $link = openlink();

      $query = "SELECT * FROM estados WHERE estado_id = ? LIMIT 1";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        $resultArray = $result->fetch_assoc();
        if (empty($resultArray)) {
          return "no se encontro ni madres!";
        } else {
          return $resultArray;
        }

      }
      closeLink($stmt, $link);
    }

    static function GetCityByName($city, $stateID){
      $link = openlink();

      //checks to see if search also with the state ID
      if (!$stateID) {
        $query = "SELECT * FROM ciudades WHERE nombre = ? LIMIT 1";
        $stmt = mysqli_stmt_init($link);
        if (!mysqli_stmt_prepare($stmt, $query)) {
          //return false if there was an error
          return false;
        }else {
          mysqli_stmt_bind_param($stmt, "s", $city);
          mysqli_stmt_execute($stmt);
          //grabing single result
          $result = $stmt->get_result(); // get the mysqli result
          $resultArray = $result->fetch_assoc();
          if (empty($resultArray)) {
            return false;
          } else {
            return $resultArray;
          }

        }
      } else {
        $query = "SELECT * FROM ciudades WHERE nombre = ? AND estado = ? LIMIT 1";
        $stmt = mysqli_stmt_init($link);
        if (!mysqli_stmt_prepare($stmt, $query)) {
          //return false if there was an error
          return false;
        }else {
          mysqli_stmt_bind_param($stmt, "si", $city, $stateID);
          mysqli_stmt_execute($stmt);
          //grabing single result
          $result = $stmt->get_result(); // get the mysqli result
          $resultArray = $result->fetch_assoc();
          if (empty($resultArray)) {
            return false;
          } else {
            return $resultArray;
          }

        }
      }


      closeLink($stmt, $link);
    }

    static function AddCity($state_id, $city){
      $link = openlink();

      $query = "INSERT INTO ciudades (nombre, estado) VALUES (?, ?)";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "si", $city, $state_id);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        return true;
      }
      closeLink($stmt, $link);
    }

  }


  //open link
  function openlink(){
    $link = mysqli_connect("localhost", "root", "", "levant_giftcard");
    if (mysqli_connect_error()) {
      die("Error connecting to DB");
    }
    return $link;
  }

  //closing link
  function closeLink($stmt, $link){
    mysqli_stmt_close($stmt);
    mysqli_close($link);
  }
  //date("Y-m-d H:i:s")
?>
