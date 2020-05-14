<?php
require_once '../includes/header.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //grabbing info from $_POST and filtering them

  $product_id = (int)$_POST['product_id'];
  $file = $_FILES['img_file'];
  $fileName = $file['name'];
  $fileTempLoc = $file['tmp_name'];
  $fileErrors = $file['error'];
  $fileSize = $file['size'];

  $fileExt = explode(".", $fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowedExts = array("jpg", "jpeg", "png");

  if (in_array($fileActualExt, $allowedExts)) {
    if ($fileErrors === 0) {
      if ($fileSize < 5000000) {
        //change to desire name file
        $fileNameNew = uniqid('', true). "." . $fileActualExt;
        //destination of the file in the server
        $fileDestination = "../images/" . $fileNameNew;
        move_uploaded_file($fileTempLoc, $fileDestination);
        //removed extra path so it works at root $access_level
        $fileDestination = substr($fileDestination, 3);
        DBX::AddImg($product_id, $fileDestination);
        //redirect to new page
        header("Location: ../dashboard.php?success");
      }else {
        echo "file too big!!";
      }
    }else {
      echo "errors uploading image!!";
    }
  }else {
    echo "error file type not allow!";
  }

} else {
  // if they didnt arrived to the page by the POST method it kills script
  exit('Invalid URL');
}

//$return['redirect'] = 'dashboard.php?message='.$len[33].'!&tab=mu'
?>
