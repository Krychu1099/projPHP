<?php
    include_once 'header.php';
?>

<?php if (isset($_SESSION["useruid"]) && $_SESSION["userid"] === 1) : 
    // sprawdzenie czy jest to admin, jeżeli tak to wpuszczam go na tą stronę
    
    require_once '../includes/db.php';
    require_once '../includes/functions.php';
    $products = showProducts($conn);

    if (!empty($products)) :
    // sprawdzam czy są jakieś produkty w bazie
?>

    <div>
        <h1>Zarządzaj produktami Szefie</h1>
        <ul>
            <li><a href="create.php"><button id="inf">Utwórz produkt</button></a></li><br><br>
        </ul>
    </div>
    <div>
    <table class="table" id="table">
        <thead>
            <tr>
            <th>#</th>
            <th class="col-2">Zdjęcie</th>
            <th class="col-2">Nazwa</th>
            <th class="col-2">Opis</th>
            <th class="col-2">Cena</th>
            <th class="col-2">Akcja</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $i => $product): ?>
            <tr>
                <th class="col-2"><?php echo $i + 1 ?></th>
                <td>
                <img class="minfoto" width="50px" src="<?php echo $product['productImage'] ?>" class="thumb-image">
                </td>
                <td><?php echo $product['productName'] ?></td>
                <td><?php echo $product['productDesc'] ?></td>
                <td><?php echo $product['productPrice'] ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $product['productId'] ?>"><button id="inf">Edit</button></a><br><br>
                    <form method="post" action="inc/delete-inc.php">
                    <input type="hidden" name="productId" value="<?php echo $product['productId'] ?>">
                    <button type="submit" name="deleteButton" id="inf">Delete</button><br><br>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
  </tbody>
</table>
            <?php else : ?>
                <div>
                    <h1>Zarządzaj produktami Szefie</h1>
                    <h2>Brak produktów</h2>
                    <ul>
                    <li><a href="create.php"><button id="inf">Utwórz produkt</button></a></li><br><br>
                    </ul>
                </div>
            <?php endif;  ?>
    </div>


<?php else : {
    header("location: products.php");
    exit();
} endif;
?>
  


<?php
    include_once 'footer.php';
?>