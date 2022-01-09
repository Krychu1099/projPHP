<?php
    include_once 'header.php';
?>

    <section class="logform">
        <div class="logcontainer">
            <h1 class="logheading">Logowanie</h1>
            <form action="inc/login-inc.php" method="post">
            <div class="box">
                <p>Nazwa użytkownika</p>
                <div>
                    <input type="text" name='uid' id='email' placeholder='Wprowadz nazwę użytkownika'>
                </div>
            </div>
            <div class='box'>
                <p>Hasło</p>
                <div>
                    <input type="password" name='password' id='pass' placeholder="Wpisz hasło">
                </div>
            </div>
            <button class='btn btn-sm' type="submit" name="submit">Zaloguj</button>
            </form>
            <p class='logtext'>Nie masz jeszcze konta? <a href="register.php">Załóż konto</a><p>
            <?php
            // wyświetlenie błędów jeżeli takie wystąpiły
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p>Uzupełnij wszystkie pola</p>";
                } else if ($_GET["error"] == "wronglogin") {
                    echo "<p>Wpisz poprawny login</p>";
                } else if ($_GET["error"] == "wrongpwd") {
                    echo "<p>Wpisz poprawne hasło</p>";
                } 
            }
            ?>
        </div>
    </section>
    
<?php
    include_once 'footer.php';
?>