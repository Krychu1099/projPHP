<?php
    include_once 'header.php';
?>

<?php
    require_once '../includes/db.php';
    require_once '../includes/functions.php';
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: products-adm.php');
    exit;
}

$product = selectProduct($conn, $id);

$productName = $product["productName"];
$productDesc = $product["productDesc"];
$productPrice = $product["productPrice"];
$productImage = $product["productImage"];


?>

    <div>
    <h1>Edytuj produkt <?php echo $productName; ?></h1>
        <form action="inc/edit-inc.php" method="post" enctype="multipart/form-data">
            <input type="text" name="productName" value="<?php echo $productName; ?>"><br>
            <textarea name="productDesc"><?php echo $productDesc; ?></textarea><br>
            <input type="number" step=".01" name="productPrice" value="<?php echo $productPrice; ?>"><br>
            <input type="file" name="image"><br>
            <input type="hidden" name="productId" value="<?php echo $id ?>">
            <button type="submit" name="submitProduct">Zapisz produkt</button>
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
