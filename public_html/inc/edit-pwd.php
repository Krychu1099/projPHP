<?php
session_start();

if (isset($_POST['changePassword']) && isset($_SESSION['useruid'])) :

require_once '../../includes/db.php';
require_once '../../includes/functions.php';

$user = $_SESSION["useruid"];
$pwd = $_POST['password'];
$pwdNew = $_POST['new-password'];
$repNewPwd = $_POST['rep-new-password'];

test_input($pwd);
test_input($pwdNew);
test_input($repNewPwd);


if (emptyChangePwdFields($pwd, $pwdNew, $repNewPwd) !== false) {
    header('Location: ../edit-user.php?error=emptyinput');
    exit;
}

if (pwdMatch($pwdNew, $repNewPwd) !== false) {
    header("location: ../edit-user.php?error=passwordsdontmatch");
    exit;
}

if (checkPwd($conn, $user, $pwd) !== false) {
    header('Location: ../edit-user.php?error=wrongpwd');
    exit;
}

changePwd($conn, $user, $pwdNew);

else :
    header('Location: ../index.php');
    exit;
endif;