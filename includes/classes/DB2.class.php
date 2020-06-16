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

    static function GetUSERbyID($id){
      $link = openlink();

      $query = "SELECT * FROM users WHERE user_id = ?";
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
          return false;
        } else {
          return $resultArray;
        }

      }
      closeLink($stmt, $link);
    }

    static function GetUSERS(){
      $link = openlink();

      $query = "SELECT * FROM users";
      $stmt = mysqli_stmt_init($link);
      mysqli_stmt_prepare($stmt, $query);
      mysqli_stmt_execute($stmt);
      //grabing single result
      $result = $stmt->get_result(); // get the mysqli result
      $resultArray = $result->fetch_all();
      if (empty($resultArray)) {
        return false;
      } else {
        return $resultArray;
      }

      closeLink($stmt, $link);
    }

    static function SearchUSERSByName($name){
      $link = openlink();

      $query = "SELECT * FROM users ";
      $names = explode(" ", $name);
      if (count($names) == 1) {
        $name0 = $names[0];
        $query .= "WHERE nombre  = ? OR apellido1 = ? OR apellido2 = ? ORDER BY nombre DESC";
        $stmt = mysqli_stmt_init($link);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "sss", $name0, $name0, $name0);
      }elseif (count($names) == 2) {
        $name0 = $names[0];
        $name1 = $names[1];
        $query .= "WHERE nombre  = ? AND apellido1 = ? ORDER BY nombre DESC";
        $stmt = mysqli_stmt_init($link);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $name0, $name1);
      }elseif (count($names) == 3) {
        $name0 = $names[0];
        $name1 = $names[1];
        $name2 = $names[2];
        $query .= "WHERE nombre  = ? AND apellido1 = ? AND apellido2 = ? ORDER BY nombre DESC";
        $stmt = mysqli_stmt_init($link);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "sss", $name0, $name1, $name2);
      }

      mysqli_stmt_execute($stmt);
      //grabing single result
      $result = $stmt->get_result(); // get the mysqli result
      $resultArray = $result->fetch_All();
      if (empty($resultArray)) {
        return false;
      } else {
        return $resultArray;
      }
      closeLink($stmt, $link);
    }

    static function SearchUSERSByEmail($email){
      $link = openlink();

      $query = "SELECT * FROM users WHERE email = ? ORDER BY email DESC";
      $stmt = mysqli_stmt_init($link);
      mysqli_stmt_prepare($stmt, $query);
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      //grabing single result
      $result = $stmt->get_result(); // get the mysqli result
      $resultArray = $result->fetch_All();
      if (empty($resultArray)) {
        return false;
      } else {
        return $resultArray;
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

    static function SetUserPassword($user_id, $pw){
      $link = openlink();

      $hashed_pw = password_hash($pw, PASSWORD_DEFAULT);

      //run modifying user table
      $query = "UPDATE users SET password = ? where user_id = ? LIMIT 1";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      } else {
        mysqli_stmt_bind_param($stmt, "si", $hashed_pw, $user_id);
        mysqli_stmt_execute($stmt);

        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        return true;
      }

      closeLink($stmt, $link);
    }

    static function ModifyUser(
      $user_id,
      $name,
      $last_name1,
      $last_name2,
      $email,
      $phone
    ){
      $link = openlink();

      //run modifying user table
      $query = "UPDATE users SET nombre = ?, apellido1 = ?, apellido2 = ?, email = ?, telefono = ?  where user_id = ? LIMIT 1";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      } else {
        mysqli_stmt_bind_param($stmt, "sssssi", $name, $last_name1, $last_name2, $email, $phone, $user_id);
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

    static function GetCitiesByStateID($stateID){
      $link = openlink();

      $query = "SELECT * FROM ciudades WHERE estado = ?";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "s", $stateID);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        $resultArray = $result->fetch_all();
        if (empty($resultArray)) {
          return false;
        } else {
          return $resultArray;
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

    static function AddAffil($user_id, $job_title, $company_name, $state_id, $city_id, $otro){
      $link = openlink();

      //checks to see if the city ID was passed
      if ($otro) {
        $query = "INSERT INTO afiliados (user_id, puesto_admin, nombre_empresa, estado, ciudad, otro) VALUES (?, ?, ?, ?, ?, ?)";
      }else {
        $query = "INSERT INTO afiliados (user_id, puesto_admin, nombre_empresa, estado, ciudad) VALUES (?, ?, ?, ?, ?)";
      }
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        //checks to see if the city ID was passed
        if ($otro) {
          //change to 0 when implementing live server
          $stupidaCiudad = 0;
          mysqli_stmt_bind_param($stmt, "issiis", $user_id, $job_title, $company_name, $state_id, $stupidaCiudad, $city_id);
        }else {
          mysqli_stmt_bind_param($stmt, "issii", $user_id, $job_title, $company_name, $state_id, $city_id);
        }
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        return true;
      }

      closeLink($stmt, $link);
    }

    static function ModifyAffi(
      $user_id,
      $aff_id,
      $company_name,
      $job_title,
      $contact_name,
      $last_name1,
      $last_name2,
      $email,
      $phone
    ){
      $link = openlink();

      $query = "UPDATE afiliados SET puesto_admin = ?, nombre_empresa = ? where affi_id = ? LIMIT 1";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "ssi", $job_title, $company_name, $aff_id);
        mysqli_stmt_execute($stmt);

        //run modifying user table
        $query = "UPDATE users SET nombre = ?, apellido1 = ?, apellido2 = ?, email = ?, telefono = ?  where user_id = ? LIMIT 1";
        $stmt = mysqli_stmt_init($link);
        if (!mysqli_stmt_prepare($stmt, $query)) {
          //return false if there was an error
          return false;
        } else {
          mysqli_stmt_bind_param($stmt, "sssssi", $contact_name, $last_name1, $last_name2, $email, $phone, $user_id);
          mysqli_stmt_execute($stmt);

          //grabing single result
          $result = $stmt->get_result(); // get the mysqli result
          return true;
        }
      }
      closeLink($stmt, $link);
    }

    static function SetAffiStatus($aff_id, $status_id){
      $link = openlink();

      $query = "UPDATE afiliados SET aprovado = ? where affi_id = ? LIMIT 1";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "ii", $status_id, $aff_id);
        mysqli_stmt_execute($stmt);
      }
      closeLink($stmt, $link);
    }

    static function SetAffiCityState($aff_id, $state_id, $city_id){
      $link = openlink();

      $query = "UPDATE afiliados SET estado = ?, ciudad = ? where affi_id = ? LIMIT 1";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "iii", $state_id, $city_id, $aff_id);
        mysqli_stmt_execute($stmt);
      }
      closeLink($stmt, $link);
    }

    static function SearchAffisByContactName($name){
      //grabs all the users found by the string NAME
      $users = self::SearchUSERSByName($name);
      //creates an empty array to hold found affiliates
      $affi_array = [];
      //creates empty array to keep track of each affi ID, so we dont repeat affiliates
      $affi_ids = [];
      if ($users) {
        //iterates thru all the users
        foreach ($users as $user) {
          //grabs the affiliate asociated to the user
          $temp_affi = self::GetAffByUserID($user[0]);
          if ($temp_affi != false) {
            $temp_affi = self::arrayTranslator($temp_affi);
            //if the ID array has any results
            if (count($affi_ids)>0) {
              //creates a variable lock to indicated if there is a match
              $lock = false;
              //iterates thru all IDs in the ID array
              foreach ($affi_ids as $affi_id) {
                //if the ID in the array matches with the ID of the affiliate associate to the user
                if ($affi_id == $temp_affi[0]) {
                  //set the lock to true preventing the affiliate from being added again to the Affiliate Array
                  $lock = true;
                }
              }
              // if the lock has not been turned on, it pushed the affiliate to the Affi array
              if (!$lock) {
                array_push($affi_array, $temp_affi);
                array_push($affi_ids, $temp_affi[0]);
              }
            }else {
              //if the ID array is empty
              array_push($affi_array, $temp_affi);
              array_push($affi_ids, $temp_affi[0]);
            }
          }
        }
      }
      return $affi_array;
      //closeLink($stmt, $link);
    }

    static function SearchAffisByProductName($product_name){
      //grabs all the products found by the string NAME
      $products = self::GetProductsByName($product_name);
      //creates an empty array to hold found affiliates
      $affi_array = [];
      //creates empty array to keep track of each affi ID, so we dont repeat affiliates
      $affi_ids = [];
      if ($products) {
        //iterates thru all the users
        foreach ($products as $product) {
          //grabs the affiliate asociated to the user
          $temp_affi = self::GetAffByID($product[1]);
          if ($temp_affi != false) {
            $temp_affi = self::arrayTranslator($temp_affi);
            //if the ID array has any results
            if (count($affi_ids)>0) {
              //creates a variable lock to indicated if there is a match
              $lock = false;
              //iterates thru all IDs in the ID array
              foreach ($affi_ids as $affi_id) {
                //if the ID in the array matches with the ID of the affiliate associate to the user
                if ($affi_id == $temp_affi[0]) {
                  //set the lock to true preventing the affiliate from being added again to the Affiliate Array
                  $lock = true;
                }
              }
              // if the lock has not been turned on, it pushed the affiliate to the Affi array
              if (!$lock) {
                array_push($affi_array, $temp_affi);
                array_push($affi_ids, $temp_affi[0]);
              }
            }else {
              //if the ID array is empty
              array_push($affi_array, $temp_affi);
              array_push($affi_ids, $temp_affi[0]);
            }
          }
        }
      }
      return $affi_array;
      //closeLink($stmt, $link);
    }

    static function SearchAffisByCompanyName($company_name){
      $link = openlink();

      $company_name = "%".$company_name."%";

      $query = "SELECT * FROM afiliados WHERE nombre_empresa LIKE ? ORDER BY nombre_empresa DESC";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "s", $company_name);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        $resultArray = $result->fetch_All();
        if (empty($resultArray)) {
          return false;
        } else {
          return $resultArray;
        }
      }
      closeLink($stmt, $link);
    }

    static function arrayTranslator($arrayIndex){
      $tempArray = [];
      foreach ($arrayIndex as $key => $array) {
        array_push($tempArray, $array);
      }
      return $tempArray;
    }

    static function SetAccessByID($user_id, $access_level){
      $link = openlink();

      $query = "UPDATE users SET access_level = ? WHERE user_id = ? LIMIT 1";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "ii", $access_level, $user_id);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        return true;

      }
      closeLink($stmt, $link);
    }

    static function SetPasswordByID($user_id, $password){
      $link = openlink();

      $query = "UPDATE users SET password = ? WHERE user_id = ? LIMIT 1";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "si", $password, $user_id);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        return true;

      }
      closeLink($stmt, $link);
    }

    static function GetAffByUserID($user_id){
      $link = openlink();

      $query = "SELECT * FROM afiliados WHERE user_id = ? LIMIT 1";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
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

    static function GetAffByProductID($user_id){
      $link = openlink();

      $query = "SELECT * FROM afiliados WHERE user_id = ? LIMIT 1";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
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

    static function GetAffByID($affi_id){
      $link = openlink();

      $query = "SELECT * FROM afiliados WHERE affi_id = ? LIMIT 1";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "i", $affi_id);
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

    static function GetAffaByStateID($state_id){
      $link = openlink();

      $query = "SELECT * FROM afiliados WHERE estado  = ?";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "i", $state_id);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        $resultArray = $result->fetch_All();
        if (empty($resultArray)) {
          return false;
        } else {
          return $resultArray;
        }

      }
      closeLink($stmt, $link);
    }

    static function GetAffaByCityID($city_id){
      $link = openlink();

      $query = "SELECT * FROM afiliados WHERE ciudad   = ?";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "i", $city_id);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        $resultArray = $result->fetch_All();
        if (empty($resultArray)) {
          return false;
        } else {
          return $resultArray;
        }

      }
      closeLink($stmt, $link);
    }

    static function GetAllAffi(){
      $link = openlink();

      $query = "SELECT * FROM afiliados";
      $stmt = mysqli_stmt_init($link);
      mysqli_stmt_prepare($stmt, $query);
      mysqli_stmt_execute($stmt);
      //grabing single result
      $result = $stmt->get_result(); // get the mysqli result
      $resultArray = $result->fetch_all();
      if (empty($resultArray)) {
        return false;
      } else {
        return $resultArray;
      }

      closeLink($stmt, $link);
    }

    static function AddImg($product_id, $img_loc){
      $link = openlink();

      $query = "INSERT INTO imagenes (ubicacion, producto) VALUES (?, ?)";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "si", $img_loc, $product_id);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        return true;
      }
      closeLink($stmt, $link);
    }

    static function DeleteImg($image_id){
      $link = openlink();

      $query = "DELETE FROM imagenes WHERE idimagenes = ? LIMIT 1";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "i", $image_id);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        return true;
      }
      closeLink($stmt, $link);
    }

    static function SetLogo($product_id, $logo_loc){
      $link = openlink();

      $query = "UPDATE productos SET logo = ? where producto_id = ? LIMIT 1";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "si", $logo_loc, $product_id);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        return true;
      }
      closeLink($stmt, $link);
    }

    static function GetProductCategories(){
      $link = openlink();

      $query = "SELECT * FROM hotel_categoria";
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

    static function GetPrecios(){
      $link = openlink();

      $query = "SELECT * FROM precios";
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
          return falso;
        } else {
          return $resultArray;
        }

      }
      closeLink($stmt, $link);
    }

    static function AddProducto(
      $afil_id, $product_type,
      $company_name,
      $address1,
      $address2,
      $lat,
      $lon,
      $email_reservations,
      $phone_reservations,
      $product_desc,
      $product_category,
      $product_price,
      $state,
      $city
    ){
      $link = openlink();

      $query = "INSERT INTO productos (
        afiliado_id,
        tipo,
        nombre_comercial,
        direccion,
        direccion2,
        latitud,
        longitude,
        email_reservacion,
        telefono_reservacion,
        descrip,
        categoria,
        precio,
        state,
        city
      ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param(
          $stmt,
          "iissssssisiiii",
          $afil_id,
          $product_type,
          $company_name,
          $address1,
          $address2,
          $lat,
          $lon,
          $email_reservations,
          $phone_reservations,
          $product_desc,
          $product_category,
          $product_price,
          $state,
          $city34
        );
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        return true;
      }
      closeLink($stmt, $link);
    }

    static function ModifyProducto(
      $product_id,
      $product_name,
      $product_type,
      $product_category,
      $address1,
      $address2,
      $lat,
      $lon,
      $email_reservations,
      $phone_reservations,
      $product_status,
      $product_desc
    ){
      $link = openlink();

      $query = "UPDATE productos
                  SET nombre_comercial = ?,
                      tipo = ?,
                      categoria = ?,
                      direccion = ?,
                      direccion2 = ?,
                      latitud = ?,
                      longitude = ?,
                      email_reservacion = ?,
                      telefono_reservacion = ?,
                      aprovado = ?,
                      descrip = ?
                  where producto_id = ? LIMIT 1";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "siissssssisi", $product_name, $product_type, $product_category, $address1, $address2, $lat, $lon, $email_reservations, $phone_reservations, $product_status, $product_desc, $product_id);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        return true;
      }
      closeLink($stmt, $link);
    }

    static function GetProductsByAffID($aff_id){
      $link = openlink();

      $query = "SELECT * FROM productos WHERE afiliado_id = ?";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "i", $aff_id);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        $resultArray = $result->fetch_all();
        if (empty($resultArray)) {
          return false;
        } else {
          return $resultArray;
        }

      }
      closeLink($stmt, $link);
    }

    static function GetProductsByName($product_name){
      $link = openlink();

      $product_name = "%".$product_name."%";

      $query = "SELECT * FROM productos WHERE nombre_comercial LIKE ?";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "s", $product_name);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        $resultArray = $result->fetch_all();
        if (empty($resultArray)) {
          return false;
        } else {
          return $resultArray;
        }

      }
      closeLink($stmt, $link);
    }

    static function GetProductsByStateID($id){
      $link = openlink();

      $query = "SELECT * FROM productos WHERE state = ?";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        $resultArray = $result->fetch_all();
        if (empty($resultArray)) {
          return false;
        } else {
          return $resultArray;
        }

      }
      closeLink($stmt, $link);
    }

    static function GetProductByNameAndCityID($product_name, $city_id){
      $link = openlink();

      $query = "SELECT * FROM productos WHERE nombre_comercial = ? AND city = ?";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "si", $product_name, $city_id);
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

    static function GetImagesByProductID($product_id){
      $link = openlink();

      $query = "SELECT * FROM imagenes WHERE producto = ?";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "i", $product_id);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        $resultArray = $result->fetch_all();
        if (empty($resultArray)) {
          return false;
        } else {
          return $resultArray;
        }

      }
      closeLink($stmt, $link);
    }

    static function GetImageByID($image_id){
      $link = openlink();

      $query = "SELECT * FROM imagenes WHERE idimagenes = ? LIMIT 1";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "i", $image_id);
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

    static function AddGiftCard(
      $price,
      $name,
      $name2,
      $name3,
      $phone,
      $email,
      $isGift,
      $gift_name,
      $gift_name2,
      $gift_name3,
      $gift_email,
      $gift_note,
      $state
    ){
      $temp_date = date("Y-m-d H:i:s");
      $link = openlink();

      $query = "INSERT INTO giftcard (
        precio,
        fecha_creacion,
        nombre_comp,
        apellido1_comp,
        apellido2_comp,
        telefono_comp,
        email_comp,
        es_gift,
        nombre_gift,
        apellido1_gift,
        apellido2_gift,
        email_gift,
        gift_note,
        estado
      ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param(
          $stmt,
          "issssssisssssi",
          $price,
          $temp_date,
          $name,
          $name2,
          $name3,
          $phone,
          $email,
          $isGift,
          $gift_name,
          $gift_name2,
          $gift_name3,
          $gift_email,
          $gift_note,
          $state
        );
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        //return the id of the item last created
        return mysqli_insert_id($link);
      }
      closeLink($stmt, $link);
    }

    static function GetGiftCardByID($giftCard_id){
      $link = openlink();

      $query = "SELECT * FROM giftcard WHERE card_id = ? LIMIT 1";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "i", $giftCard_id);
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

    static function GetAllGiftCard(){
      $link = openlink();

      $query = "SELECT * FROM giftcard ORDER BY fecha_creacion DESC";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        $resultArray = $result->fetch_all();
        if (empty($resultArray)) {
          return false;
        } else {
          return $resultArray;
        }

      }
      closeLink($stmt, $link);
    }

    static function GetAllGiftCardsByProductID($affi_id){
      $link = openlink();

      $query = "SELECT * FROM giftcard WHERE producto = ? ORDER BY fecha_creacion DESC";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "i", $affi_id);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        $resultArray = $result->fetch_all();
        if (empty($resultArray)) {
          return false;
        } else {
          return $resultArray;
        }

      }
      closeLink($stmt, $link);
    }

    static function SearchGiftCardsByName($name){
      $link = openlink();

      $query = "SELECT * FROM giftcard ";
      $names = explode(" ", $name);
      if (count($names) == 1) {
        $name0 = $names[0];
        $query .= "WHERE nombre_comp  = ? OR apellido1_comp = ? OR apellido2_comp = ? OR nombre_gift = ? OR apellido1_gift = ? OR apellido2_gift = ? ORDER BY nombre_comp DESC";
        $stmt = mysqli_stmt_init($link);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ssssss", $name0, $name0, $name0, $name0, $name0, $name0);
      }elseif (count($names) == 2) {
        $name0 = $names[0];
        $name1 = $names[1];
        $query .= "WHERE nombre_comp  = ? AND apellido1_comp = ? OR nombre_gift = ? AND apellido1_gift = ? ORDER BY nombre_comp DESC";
        $stmt = mysqli_stmt_init($link);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $name0, $name1, $name0, $name1);
      }elseif (count($names) == 3) {
        $name0 = $names[0];
        $name1 = $names[1];
        $name2 = $names[2];
        $query .= "WHERE nombre_comp  = ? AND apellido1_comp = ? AND apellido2_comp = ? OR nombre_gift = ? AND apellido1_gift = ? AND apellido2_gift = ? ORDER BY nombre_comp DESC";
        $stmt = mysqli_stmt_init($link);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ssssss", $name0, $name1, $name2, $name0, $name1, $name2);
      }

      mysqli_stmt_execute($stmt);
      //grabing single result
      $result = $stmt->get_result(); // get the mysqli result
      $resultArray = $result->fetch_All();
      if (empty($resultArray)) {
        return false;
      } else {
        return $resultArray;
      }
      closeLink($stmt, $link);
    }

    static function SearchGiftCardsByResNum($res_num){
      $link = openlink();

      $query = "SELECT * FROM giftcard WHERE codigo  = ? ORDER BY codigo DESC";
      $stmt = mysqli_stmt_init($link);
      mysqli_stmt_prepare($stmt, $query);
      mysqli_stmt_bind_param($stmt, "s", $res_num);
      mysqli_stmt_execute($stmt);
      //grabing single result
      $result = $stmt->get_result(); // get the mysqli result
      $resultArray = $result->fetch_All();
      if (empty($resultArray)) {
        return false;
      } else {
        return $resultArray;
      }
      closeLink($stmt, $link);
    }

    static function SearchGiftCardsByEmail($email){
      $link = openlink();

      $query = "SELECT * FROM giftcard WHERE email_comp = ? OR email_gift = ? ORDER BY email_comp DESC";
      $stmt = mysqli_stmt_init($link);
      mysqli_stmt_prepare($stmt, $query);
      mysqli_stmt_bind_param($stmt, "ss", $email, $email);
      mysqli_stmt_execute($stmt);
      //grabing single result
      $result = $stmt->get_result(); // get the mysqli result
      $resultArray = $result->fetch_All();
      if (empty($resultArray)) {
        return false;
      } else {
        return $resultArray;
      }
      closeLink($stmt, $link);
    }

    static function SearchGiftCardsByRecDate($rec_date){
      $link = openlink();

      $dates = explode(" - ", $rec_date);
      $start = $dates[0];
      $end = $dates[1];
      //need to add this code to include the end date, since the format includes time and was ignoring end day of the query
      $end = str_replace('-', '/', $end);
      $end = date('Y-m-d',strtotime($end . "+1 days"));

      $query = "SELECT * FROM giftcard WHERE fecha_creacion BETWEEN ? AND ?";
      $stmt = mysqli_stmt_init($link);
      mysqli_stmt_prepare($stmt, $query);
      mysqli_stmt_bind_param($stmt, "ss", $start, $end);
      mysqli_stmt_execute($stmt);
      //grabing single result
      $result = $stmt->get_result(); // get the mysqli result
      $resultArray = $result->fetch_All();
      if (empty($resultArray)) {
        return false;
      } else {
        return $resultArray;
      }
      closeLink($stmt, $link);
    }

    static function SetGiftCardReservationNumber($giftCard_id, $reservation_num){
      $link = openlink();

      $query = "UPDATE giftcard SET codigo = ? where card_id = ? LIMIT 1";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "si", $reservation_num, $giftCard_id);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        return true;
      }
      closeLink($stmt, $link);
    }

    static function ModifyGiftcard(
      $price,
      $user_name,
      $user_lastName,
      $user_lastName2,
      $user_phone,
      $user_email,
      $is_gift,
      $gift_name,
      $gift_lastName,
      $gift_lastName2,
      $gift_email,
      $gift_note,
      $status,
      $state_id,
      $giftcard_id
    ){
      $link = openlink();

      $query = "UPDATE giftcard
                  SET precio = ?,
                      nombre_comp = ?,
                      apellido1_comp = ?,
                      apellido2_comp = ?,
                      telefono_comp = ?,
                      email_comp = ?,
                      es_gift = ?,
                      nombre_gift = ?,
                      apellido1_gift = ?,
                      apellido2_gift = ?,
                      email_gift = ?,
                      gift_note = ?,
                      es_redimed = ?,
                      estado = ?
                  where card_id = ? LIMIT 1";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param(
          $stmt,
          "isssssisssssiii",
          $price,
          $user_name,
          $user_lastName,
          $user_lastName2,
          $user_phone,
          $user_email,
          $is_gift,
          $gift_name,
          $gift_lastName,
          $gift_lastName2,
          $gift_email,
          $gift_note,
          $status,
          $state_id,
          $giftcard_id
        );
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        return true;
      }
      closeLink($stmt, $link);
    }

    static function SetGiftcardReedemedDate($giftcard_id, $reed_date){
      $link = openlink();

      $query = "UPDATE giftcard
                  SET fecha_redimed = ?
                  where card_id = ? LIMIT 1";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "si", $reed_date, $giftcard_id);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        return true;
      }
      closeLink($stmt, $link);
    }

    static function SetGiftcardReedemedProduct($giftcard_id, $product_id){
      $link = openlink();

      $query = "UPDATE giftcard
                  SET producto = ?
                  where card_id = ? LIMIT 1";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "ii", $product_id, $giftcard_id);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        return true;
      }
      closeLink($stmt, $link);
    }

    static function AddFollowUp($giftCard_id, $user_id, $body, $type){
      $link = openlink();

      $tempDate = date("Y-m-d H:i:s");

      $query = "INSERT INTO seguimiento (giftcard_id, user_id, fecha, body, type) VALUES (?, ?, ?, ?, ?)";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "iissi", $giftCard_id, $user_id, $tempDate, $body, $type);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        return true;
      }
      closeLink($stmt, $link);
    }

    static function GetFollowUpsByGiftcardID($giftcard_id){
      $link = openlink();

      $query = "SELECT * FROM seguimiento WHERE giftcard_id = ?";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $query)) {
        //return false if there was an error
        return false;
      }else {
        mysqli_stmt_bind_param($stmt, "i", $giftcard_id);
        mysqli_stmt_execute($stmt);
        //grabing single result
        $result = $stmt->get_result(); // get the mysqli result
        $resultArray = $result->fetch_all();
        $resultArray = array_reverse($resultArray);
        if (empty($resultArray)) {
          return false;
        } else {
          return $resultArray;
        }

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
