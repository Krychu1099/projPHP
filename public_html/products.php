<?php
    include_once 'header.php';
?>

    <div class="sekcja-produkty">
        <?php
        require_once '../includes/db.php';
        require_once '../includes/functions.php';
        
        if (!empty($search)) {
            $searchProducts = searchProducts($conn, $search);
            // jeżeli użytkownik szuka produktów to przypisuję to co szuka do zmiennej
        } else {
            $searchProducts = '';
            $products = showProducts($conn);
            // jeżeli nie to przypisuję tej zmiennej pustą wartość i pokazuję wszystkie produkty
        }
        if (!empty($searchProducts)) : ?>
            <h1 class="tytul">Produkty</h1>
            <div class="row">
            <?php foreach ($searchProducts as $i => $product) : ?>
                <div class="col-4">
                    <a href="product.php?prod_id=<?php echo $product['productId'] ?>">
                        <img src="<?php echo $product['productImage'] ?>" alt="Nie ma fotki byczq">
                    </a>
                        <h4><?php echo $product['productName'] ?></h4>
                        <p><?php echo $product['productPrice'] ?> zł</p>
                        <br>
                        <!--<input type="button" name="kup" id="kup" value="Kup teraz"> <br><br>-->
                        <a href="product.php?prod_id=<?php echo $product['productId'] ?>"><input type="button" name="inf" id="inf" value="Szczegóły"></a>
                </div>
            <?php endforeach;  ?>
            </div>
        <?php 
            elseif (!empty($products)) : 
        ?>
            <h1 class="tytul">Produkty</h1>
            <div class="row">
            <?php foreach ($products as $i => $product) : ?>
                <div class="col-4">
                    <a href="product.php?prod_id=<?php echo $product['productId'] ?>">
                        <img src="<?php echo $product['productImage'] ?>" alt="Nie ma fotki byczq">
                    </a>
                        <h4><?php echo $product['productName'] ?></h4>
                        <p><?php echo $product['productPrice'] ?> zł</p>
                        <br>
                        <!--<input type="button" name="kup" id="kup" value="Kup teraz"> <br><br>-->
                        <a href="product.php?prod_id=<?php echo $product['productId'] ?>"><input type="button" name="inf" id="inf" value="Szczegóły"></a>
                </div>
            <?php endforeach;  ?>
            </div>
        <?php else :
        ?>
        <p>Brak produktów</p>
        <?php endif; ?>

    </div>

<?php
    include_once 'footer.php';
?>