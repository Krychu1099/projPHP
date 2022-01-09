<?php 
if (isset($_GET['search'])) {

    $search = $_GET['search'];

    require_once '../../includes/db.php';
    require_once '../../includes/functions.php';

    test_input($search);

    header("Location: ../products.php?search=" . $_GET['search']);
    exit;


} else {
    header("Location: ../index.php");exit;
}