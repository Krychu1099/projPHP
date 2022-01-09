<?php
    ob_start(); // tutaj był problem ze zmianą statusu zamówienia, znalezione w internecie. Na localhoscie działa bez tego
    include_once 'header.php';
?>

<?php if (isset($_SESSION["useruid"]) && $_SESSION["userid"] === 1) : 
    
    require_once '../includes/db.php';
    require_once '../includes/functions.php';

    $sel = selectOrder($conn, $_SESSION['userid']);

    if (!empty($sel)) {
        selectProductOrder($conn, $sel, $_SESSION['userid']);
    } else {
        echo '<p>Brak zamówień</p>';
    }

    
?>



<?php else : {
    header("location: zamowienia.php");
    exit();
} endif;
?>
  


<?php
    include_once 'footer.php';
?>