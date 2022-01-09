<?php

if (isset($_POST["submit"])) {
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["uid"];
    $password = $_POST["password"];
    $passwordRep = $_POST["password-rep"];

    require_once '../../includes/db.php';
    require_once '../../includes/functions.php';

    test_input($name);
    test_input($email);
    test_input($username);
    test_input($password);
    test_input($passwordRep);

    if (emptyInputSignup($name, $email, $username, $password, $passwordRep) !== false) {
        header("location: ../register.php?error=emptyinput");
        exit();
    }

    if (invalidUid($username) !== false) {
        header("location: ../register.php?error=invaliduid");
        exit();
    }

    if (invalidEmail($email) !== false) {
        header("location: ../register.php?error=invalidemail");
        exit();
    }

    if (pwdMatch($password, $passwordRep) !== false) {
        header("location: ../register.php?error=passwordsdontmatch");
        exit();
    }

    if (uidExists($conn, $username, $email) !== false) {
        header("location: ../register.php?error=usernametaken");
        exit();
    }

    createUser($conn, $name, $email, $username, $password);

} else {
    header("location: ../register.php");
}