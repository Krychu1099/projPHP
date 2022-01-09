<?php
    include_once 'header.php';
?>

    <div>
        <h1>Dodaj produkt</h1>
        <form action="inc/create-inc.php" method="post" enctype="multipart/form-data">
            <input type="text" name="productName" placeholder="Nazwa produktu"><br>
            <textarea name="productDesc"></textarea><br>
            <input type="number" step=".01" name="productPrice" placeholder="Cena"><br>
            <input type="file" name="image"><br>
            <button type="submit" name="submitProduct">Dodaj produkt</button>
        </form>
        <p><?php 
            if (isset($_GET['error'])) {
                if($_GET['error'] === 'wrongfiletype') {
                    echo 'Proszę dodać plik graficzny!';
                }
            }
        ?></p>
    </div>

<?php
    include_once 'footer.php';
?>