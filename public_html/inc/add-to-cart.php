<?php 

if (isset($_POST["addToCart"])) {

session_start();
require_once '../../includes/db.php';
require_once '../../includes/functions.php';

$prodId = (int)$_POST["prodId"];
$quantity = (int)$_POST["quantity"];

if (!is_numeric($_POST['quantity'])) {
    header("Location: ../product.php?prod_id=$prodId&error=notnumber");
    exit;
}

$product = showProduct($conn, $prodId);

if ($product && $quantity > 0) {
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        if (array_key_exists($prodId, $_SESSION['cart'])) {
            $_SESSION['cart'][$prodId] += $quantity;
        } else {
            $_SESSION['cart'][$prodId] = $quantity;
        }
    } else {
        $_SESSION['cart'] = array($prodId => $quantity);
    }
}

header("Location: ../product.php?prod_id=$prodId");
exit;

} else {
    header("Location: ../products.php");
    exit;
} 