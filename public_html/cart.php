<?php
    // Koszyk wzorowany na https://codeshack.io/shopping-cart-system-php-mysql/
    include_once 'header.php';
?>

<?php
    require_once '../includes/db.php';
    require_once '../includes/functions.php';
    $orderSum = 0;

    // Usuwanie produktu z koszyka
    if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
        unset($_SESSION['cart'][$_GET['remove']]);
    }

    // Zmiana ilości produktów w koszyku
    if (isset($_POST['update']) && isset($_SESSION['cart'])) {
        foreach ($_POST as $k => $v) {
            if (strpos($k, 'quantity-') !== false && is_numeric($v)) {
                $id = str_replace('quantity-', '', $k);
                $quantity = (int)$v;
                if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                    $_SESSION['cart'][$id] = $quantity;
                }
            }
        }
        header("Location: cart.php");exit;
    }

    // Składanie zamówienia
    if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $cart = $_SESSION["cart"];
        $cart_str = serialize($cart);
        $userId = $_SESSION['userid'];
        $orderStatus = 'dodane';
        $orderPrice = $_POST['orderSum'];

        $sql = "INSERT INTO orders (userId, orderArr, orderStatus, orderPrice) values (?, ?, ?, ?)";

        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../register.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "issd", $userId, $cart_str, $orderStatus, $orderPrice);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        unset($_SESSION['cart']);
    }

    if (isset($_SESSION["cart"])) {
    $cartProducts = $_SESSION["cart"];
    }
?>

<form action="cart.php" method="post">
<table>
    <thead>
        <tr>
            <td class="col-2">Produkt</td>
            <td class="col-2">Cena</td>
            <td class="col-2">Ilość</td>
            <td class="col-2">Suma</td>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($_SESSION['cart'])) : ?>
        <tr>
            <td>Nie dodałeś żadnych produktów do koszyka</td>
        </tr>
        <?php else : ?>
            <?php 
                foreach ($cartProducts as $prod => $i) : 
                $product = showProduct($conn, $prod);
            ?>
                <tr>
                    <td>
                        <?php echo $product['productName'] ?> <br>
                        <a href="cart.php?remove=<?php echo $prod ?>">Usuń</a>
                    </td>
                    <td><?php echo $product['productPrice'] ?></td>
                    <td><input type="number" name="quantity-<?php echo $prod ?>" value="<?php echo $_SESSION['cart'][$prod] ?>" ></td>
                    <td>
                        <?php echo $product['productPrice'] * $_SESSION['cart'][$prod] ?>
                        <input type="hidden" name="orderPrice" value="<?php echo $product['productPrice'] * $_SESSION['cart'][$prod]; $orderSum = $orderSum + $product['productPrice'] * $_SESSION['cart'][$prod] ?>">
                        <input type="hidden" name="orderSum" value="<?php echo $orderSum ?>"><br><br>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table><br><br>
<div class="cartbtn">
    <input class="col" id="inf" type="submit" value="Aktualizuj" name="update">
    <input class="col" id="inf" type="submit" value="Złóż zamówienie" name="placeorder">
</div>
</form>
<?php
    include_once 'footer.php';
?>