<?php 

if (isset($_POST["submitProduct"])) {
        $productName = $_POST["productName"];
        $productDesc = $_POST["productDesc"];
        $productPrice = $_POST["productPrice"];
        $id = $_POST["productId"];

        require_once '../../includes/db.php';
        require_once '../../includes/functions.php';
        

        if (emptyRequiredFields($productName, $productPrice)) {
            header("location: ../edit.php?error=emptyinput");
            exit();
        }

        if (!is_dir('../images')) {
            mkdir('../images');
        }

    if (empty($_GET["error"])) {

        if ($_FILES['image']['error'] === 4) {
            $product = selectProduct($conn, $id);
            $image = $_FILES['image'] ?? null;
            $imagePath = $product["productImage"];

            editProduct($conn, $productName, $productDesc, $productPrice, $imagePath, $id);
        } else {
            $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
            $detectedType = exif_imagetype($_FILES['image']['tmp_name']);
            $error = !in_array($detectedType, $allowedTypes);

            if ($error === false) {
                $product = selectProduct($conn, $id);
                $image = $_FILES['image'] ?? null;
                $imagePath = $product["productImage"];

                if ($image && $image['tmp_name']) {

                    if ($product['productImage']) {
                        unlink('/storage/ssd2/168/18245168/public_html/'.$product['productImage']);
                    }


                    if ($image && $image['tmp_name']) {
                    $imagePath = 'images/'.randomString(8).'/'.$image['name'];
                    mkdir(dirname('../'.$imagePath));
                    move_uploaded_file($image['tmp_name'], '../'.$imagePath);
                    }
                }

                editProduct($conn, $productName, $productDesc, $productPrice, $imagePath, $id);
            } else {
                header("Location: ../edit.php?id=$id&error=wrongfiletype");
                exit;
            }
        }
    }
} else {
    header('Location: ../index.php');
    exit;
}