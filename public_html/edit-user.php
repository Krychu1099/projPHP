<?php
    include_once 'header.php';
    // Przypisanie nazwy użytkownika do zmiennej
    $user = $_SESSION["useruid"];
    // Sprawdzenie czy jest to zalogowany użytkownik
    if (isset($user)) :
?>

<?php
    require_once '../includes/db.php';
    require_once '../includes/functions.php';
?>
    <script>
        function myFunction() {
            var edit = document.getElementById("edit-address");
            edit.style.display = 'block';
        }
    </script>

    <div class="account-edit">
        <div class="header"><h1>Edytuj swoje dane</h1></div>
        <div class="change-pwd">
            <h2>Zmień hasło</h2>
            <form action="inc/edit-pwd.php" method="post">
                <label for="password">Podaj obecne hasło: </label>
                <input type="password" name="password" id="password">
                <label for="new-password">Podaj nowe hasło: </label>
                <input type="password" name="new-password" id="new-password">
                <label for="rep-new-password">Powtórz nowe hasło: </label>
                <input type="password" name="rep-new-password" id="rep-new-password">
                <button type="submit" name="changePassword">Zmień hasło</button>
            </form>
            <?php
            // wyświetlenie błędów jeżeli takie wystąpią
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p>Uzupełnij wszystkie pola</p>";
                } else if ($_GET["error"] == "passwordsdontmatch") {
                    echo "<p>Nowe hasła nie są takie same!</p>";
                } else if ($_GET["error"] == "wrongpwd") {
                    echo "<p>Złe hasło</p>";
                }
            }
            ?>
        </div>
        <div class="address">
            <?php 
                $adres = checkAddress($conn, $user); 
                // sprawdzenie czy ten użytkownik ma dodany adres
                if (!empty($adres['userAddress']) && !empty($adres['userPostalCode']) && !empty($adres['userCity']) && !empty($adres['userPhoneNum'])) :
                // jeżeli ma to wyświetla i pozwala edytować
            ?>
                <div id="show-address">
                    <h2>Twój adres to:</h2>
                    <p>Ulica: <?php echo $adres["userAddress"] ?></p>
                    <p>Kod pocztowy <?php echo $adres["userPostalCode"] ?></p>
                    <p>Miasto: <?php echo $adres["userCity"] ?></p>
                    <p>Numer telefonu: <?php echo $adres["userPhoneNum"] ?></p>
                    <button onclick="myFunction()">Zmień swoje dane</button>
                </div>

                <div id="edit-address">
                    <h3>Edytuj dane:</h3>
                    <form action="inc/edit-address.php" method="post">
                        <label for="adres">Adres: </label>
                        <input type="text" name="adres" id="adres" value="<?php echo $adres["userAddress"] ?>">
                        <label for="kod">Kod pocztowy: </label>
                        <input type="text" name="kod" id="kod" pattern="[0-9]{2}\-[0-9]{3}" maxlength="6" value="<?php echo $adres["userPostalCode"] ?>">
                        <label for="miasto">Miasto: </label>
                        <input type="text" name="miasto" id="miasto" value="<?php echo $adres["userCity"] ?>">
                        <label for="tel">Numer telefonu: </label>
                        <input type="tel" name="tel" id="tel" pattern="[0-9]{9}" value="<?php echo $adres["userPhoneNum"] ?>">
                        <button type="submit" name="edit-data">Zmień dane</button><br>
                    </form>
                </div>
            <?php  else : // jeżeli nie ma to pokazuje formularz dodania adresu ?>
                <h2>Nie masz dodanego adresu, dodaj go poniżej</h2>
                <form action="inc/add-address.php" method="post">
                    <label for="adres">Adres: </label>
                    <input type="text" name="adres" id="adres" placeholder="np. Warszawska 7/10">
                    <label for="kod">Kod pocztowy: </label>
                    <input type="text" name="kod" id="kod" placeholder="np. 61-720" pattern="[0-9]{2}\-[0-9]{3}" maxlength="6">
                    <label for="miasto">Miasto: </label>
                    <input type="text" name="miasto" id="miasto" placeholder="np. Poznań">
                    <label for="tel">Numer telefonu: </label>
                    <input type="tel" name="tel" id="tel" placeholder="np. 123456789" pattern="[0-9]{9}">
                    <button id="inf" type="submit" name="add-data">Dodaj dane adresowe</button>
                </form>
            <?php endif; ?>
        </div>
        <div>
            <h2>Zamówienia</h2>
            <p><a href="zamowienia.php">Kliknij tutaj, żeby przejść do swoich zamówień!</a></p>
        </div>
        
    </div>

<?php
    include_once 'footer.php';
    else :
        header('Location: index.php');
        exit;
    endif;
?>
