<?php 

if (isset($_POST['deleteButton'])) :

require_once '../../includes/db.php';
require_once '../../includes/functions.php';

$id = $_POST["productId"];

if (!$id) {
    header('Location: index.php');
    exit;
}

deleteProduct($conn, $id);

else :
    header('Location: ../index.php');
    exit;

endif;