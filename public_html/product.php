<?php
    include_once 'header.php';
?>

<?php
    require_once '../includes/db.php';
    require_once '../includes/functions.php';
    // pobranie ID produktu z adresu
    $prodId = $_GET['prod_id'];
    // wyciągnięcie z bazy produktu o takim ID
    $productId = productsID($conn, $prodId);
    // sprawdzenie czy ten produkt istnieje w bazie - jeżeli nie istnieje $productID == null
    if (!empty($_GET['prod_id']) && $productId !== null):
    
    // wyświetlenie informacji o produkcie
    $product = showProduct($conn, $prodId);
?>
    <div class="product">
        <h1><?php echo $product["productName"] ?></h1>
        <img width="100px" src="<?php echo $product['productImage'] ?>" alt="Brak fotki">
        <p>Cena: <?php echo $product['productPrice'] ?></p>
        <form action="inc/add-to-cart.php" method="post">
            <input type="number" name="quantity" value="1" min="1">
            <input type="hidden" name="prodId" value="<?php echo $_GET["prod_id"] ?>">
            <button type="submit" name="addToCart">Dodaj do koszyka</button>
        </form>
        <p>
            <?php 
                if (isset($_GET['error']) && $_GET['error'] == 'notnumber') {
                    echo "Podana ilość produktu nie jest liczbą. Podaj poprawną wartość!";
                }
            ?>
        </p>
    </div>

<?php 
    else:
    header("location: products.php");
    exit();
    endif;
?>

<?php
    include_once 'footer.php';
?>