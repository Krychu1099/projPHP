<?php
    include_once 'header.php';
?>

    <div>

        <section class="rejform">
        <div class="rejcontainer">
            <h1 class="logheading">Rejestracja</h1>
            <form action="inc/signup-inc.php" method="post">
            <div class="box">
                <p>Podaj imię</p>
                <div>
                    <input type="text" name='name' id='imie' placeholder='Podaj swoje Imię'>
                </div>
            </div>
            <div class="box">
                <p>Wprowadź adres e-mail</p>
                <div>
                    <input type="email" name='email' id='email' placeholder='Wprowadz email'>
                </div>
            </div>
            <div class="box">
                <p>Wprowadź login</p>
                <div>
                    <input type="text" name='uid' id='login' placeholder='Wprowadz login'>
                </div>
            </div>
            <div class='box'>
                <p>Hasło</p>
                <div>
                    <input type="password" name='password' id='pass' placeholder="Wpisz hasło">
                </div>
            </div>
            <div class='box'>
                <p>Powtórz hasło</p>
                <div>
                    <input type="password" name='password-rep' id='pass1' placeholder="Wpisz ponownie hasło">
                </div>
            </div>
            <button class='btn btn-sm' type="submit" name="submit">Załóż konto</button>
            </form>
            <p class='logtext'>Masz już konto? <a href="login.php">Zaloguj się</a><p>
            <?php
            // wyświetlanie błędów jeżeli takie wystąpiły
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p>Uzupełnij wszystkie pola</p>";
                } else if ($_GET["error"] == "invaliduid") {
                    echo "<p>Wpisz poprawny login</p>";
                } else if ($_GET["error"] == "invalidemial") {
                    echo "<p>Wpisz poprawny email</p>";
                } else if ($_GET["error"] == "passwordsdontmatch") {
                    echo "<p>Hasła nie są takie same</p>";
                } else if ($_GET["error"] == "stmtfailed") {
                    echo "<p>Coś poszło nie tak, spróbuj jeszcze raz!</p>";
                } else if ($_GET["error"] == "usernametaken") {
                    echo "<p>Login jest zajęty</p>";
                } else if ($_GET["error"] == "none") {
                    echo "<p>Zarejestrowałeś się</p>";
                }
            }
            ?>
        </div>
        </section>


<?php
    include_once 'footer.php';
?>