<?php
    session_start();
    // sprawdzenie czy użytkownik szuka produktu z użyciem szukajki
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
    } else {
        $search = '';
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>PHP</title>
</head>
<body>
    <nav class="navbar background">
        <ul class="nav-list">
            <div class="logo">
                <img src="images/logo.png">
            </div>
            <li><a href="index.php">Strona główna</a></li>
            <li><a href="products.php">Produkty</a></li>

            <?php // zmiana menu w zależności od tego czy jest to admin, zalogowany użytkownik czy gość ?>
            <?php if (isset($_SESSION["useruid"]) && $_SESSION["userid"] === 1) : ?>
            <li><a href="products-adm.php">Zarządzaj produktami</a></li>
            <li><a href="zamowienia-adm.php">Zarządzaj zamówieniami</a></li>
            <li><a href="logout.php">Wyloguj się</a></li>

            <?php elseif (isset($_SESSION["useruid"]) && $_SESSION["userid"] !== 1) : ?>

            <li><a href="cart.php">Koszyk</a></li>
            <li><a href="edit-user.php">Twoje konto</a></li>
            <li><a href="logout.php">Wyloguj się</a></li>

            <?php else : ?>

            <li><a href="register.php">Zarejestruj się</a></li>
            <li><a href="login.php">Zaloguj się</a></li>

            <?php endif; ?>
        </ul>

        <div class="rightNav">
            <form action="inc/search.php" method="get">
                <input type="text" name="search" id="search" placeholder="Szukaj produktów" value="<?php echo $search ?>">
                <button class="btn btn-sm" type="submit">Szukaj</button>
            </form>
        </div>
    </nav>