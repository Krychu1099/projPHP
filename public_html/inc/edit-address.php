<?php

session_start();

if (isset($_POST['edit-data']) && isset($_SESSION['useruid'])) {

    require_once '../../includes/db.php';
    require_once '../../includes/functions.php';

    $user = $_SESSION["useruid"];
    $adres = $_POST['adres'];
    $kod = $_POST['kod'];
    $miasto = $_POST['miasto'];
    $tel = intval($_POST['tel']);

    test_input($adres);
    test_input($kod);
    test_input($miasto);
    test_input($tel);

    if (emptyAddAddressField($adres, $kod, $miasto, $tel) !== false) {
        header('Location: ../edit-user.php?error=emptyinput');
        exit;
    }

    if (checkPostalCode($kod) !== false) {
        header('Location: ../edit-user.php?error=wrongpostalcode');
        exit;
    }

    if (checkPhone($tel) !== false) {
        header('Location: ../edit-user.php?error=wrongtel');
        exit;
    }

    addAddress($conn, $user, $adres, $kod, $miasto, $tel);
}
else {
    header('Location: ../index.php');
    exit;
}