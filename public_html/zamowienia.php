<?php
    include_once 'header.php';
?>

<?php
    require_once '../includes/db.php';
    require_once '../includes/functions.php';
    
    $sel = selectOrder($conn, $_SESSION['userid']);
    // przypisuję zmiennej $sel zamówienia danego użytkownika
    // jeżeli nie jest ona pusta to wyświetlam zamówienia

    if (!empty($sel)) {
        selectProductOrder($conn, $sel, $_SESSION['userid']);
    } else {
        // jeżeli jest pusta info o braku zamówień 
        echo '<p>Brak zamówień</p>';
    }
    

?>

<?php
    include_once 'footer.php';
?>