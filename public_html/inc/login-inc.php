<?php 

if (isset($_POST["submit"])) {
    $username = $_POST["uid"];
    $password = $_POST["password"];

    require_once '../../includes/db.php';
    require_once '../../includes/functions.php';

    test_input($username);
    test_input($password);

    if (emptyInputLogin($username, $password) !== false) {
        header("location: ../login.php?error=emptyinput");
        exit();
    }

    loginUser($conn, $username, $password);
} else {
    header("location: ../login.php");
        exit();
}