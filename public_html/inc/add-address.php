<?php

session_start();

if (isset($_POST['add-data']) && isset($_SESSION['useruid'])) {
    // sprawdzam czy działanie jest wywołane kliknięciem w przycisk i czy jest to zalogowany użytkownik

    
    require_once '../../includes/db.php';
    require_once '../../includes/functions.php';

    // przypisanie potrzebnych zmiennych
    $user = $_SESSION["useruid"];
    $adres = $_POST['adres'];
    $kod = $_POST['kod'];
    $miasto = $_POST['miasto'];
    $tel = intval($_POST['tel']);

    // przerzucenie zmiennych przez funckję walidacji
    test_input($adres);
    test_input($kod);
    test_input($miasto);
    test_input($tel);

    // sprawdzenie co zwracają funkcje, jeżeli są jakieś błędy to dodaje je w $_GET
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