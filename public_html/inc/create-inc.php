<?php 

if (isset($_POST["submitProduct"])) {
    $productName = $_POST["productName"];
    $productDesc = $_POST["productDesc"];
    $productPrice = $_POST["productPrice"];

    require_once '../../includes/db.php';
    require_once '../../includes/functions.php';

    if (emptyRequiredFields($productName, $productPrice)) {
        header("location: ../create.php?error=emptyinput");
        exit();
    }

    if (!is_dir('../images')) {
        mkdir('../images');
    }

    if (empty($_GET["error"])) {
        if ($_FILES['image']['error'] === 4) {
            $imagePath = '';
            createProduct($conn, $productName, $productDesc, $productPrice, $imagePath);
        } else {
            // poniższe 3 linijki kodu wzięte z https://stackoverflow.com/questions/6755192/how-to-check-uploaded-file-type-in-php
            $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
            $detectedType = exif_imagetype($_FILES['image']['tmp_name']);
            $error = !in_array($detectedType, $allowedTypes);


            if ($error === false) {

            $image = $_FILES['image'] ?? null;
            $imagePath = '';
            if ($image && $image['tmp_name']) {
                $imagePath = 'images/'.randomString(8).'/'.$image['name'];
                mkdir(dirname('../'.$imagePath));
                move_uploaded_file($image['tmp_name'], '../'.$imagePath);
            }

            createProduct($conn, $productName, $productDesc, $productPrice, $imagePath);
            } else {
                header("Location: ../create.php?error=wrongfiletype");
                exit;
            }
        }
    }

    
} else {
    header('Location: ../index.php');
    exit();
}