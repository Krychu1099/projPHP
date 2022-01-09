<?php 

// Funkcja sprawdzająca czy są jakieś puste pola w formularzu rejestracji
function emptyInputSignup($name, $email, $username, $password, $passwordRep) {
    $result = false;
    if (empty($name) || empty($email) || empty($username) || empty($password) || empty($passwordRep)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Funkcja sprawdzająca czy login zawiera tylko litery i cyfry
function invalidUid($username) {
    $result = false;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Funkcja sprawdza czy email jest prawidłowy
function invalidEmail($email) {
    $result = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Funkcja sprawdzająca czy hasło i powtórzone hasło są takie same
function pwdMatch($password, $passwordRep) {
    $result = false;
    if ($password !== $passwordRep) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Funkcja sprawdzająca czy taki użytkownik o takim loginie już istnieje
function uidExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE userUid = ? OR userEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {                                                    #usunąc tego maila
        header("location: ../register.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

// Funkcja tworząca użytkownika. Dodaje go do bazy, hashuje hasło
function createUser($conn, $name, $email, $username, $password) {
    $sql = "INSERT INTO users (userName, userEmail, userUid, userPwd) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../register.php?error=none");
    exit();
}

// Funkcja sprawdzająca czy pola formularza logowania nie są puste
function emptyInputLogin($username, $password) {
    $result = false;
    if (empty($username) || empty($password)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Funkcja do logowania. Jeżeli jest ok to tworzy sesję
function loginUser($conn, $username, $password) {
    $uidExists = uidExists($conn, $username, $username);

    if ($uidExists === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["userPwd"];
    $checkPwd = password_verify($password, $pwdHashed);
    if ($checkPwd === false) {
        header("location: ../login.php?error=wrongpwd");
        exit();
    } else if ($checkPwd === true) {
        session_start();
        $_SESSION["userid"] = $uidExists["userId"];
        $_SESSION["useruid"] = $uidExists["userUid"];
        $_SESSION["username"] = $uidExists["userName"];

        header("location: ../index.php");
        exit();
    }
}

// Funkcja sprawdza czy administrator dodając produkt uzupełnił wymagane pola
function emptyRequiredFields($productName, $productPrice) {
    $result = false;
    if (empty($productName) || empty($productPrice)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Funkcja tworząca nowy produkt. Zapisuje go do bazy.
function createProduct($conn, $productName, $productDesc, $productPrice, $image) {
    $sql = "INSERT INTO products (productName, productDesc, productPrice, productImage, create_date) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtfailed");
        exit();
    }
    $date = date('Y-m-d H:i:s');
    mysqli_stmt_bind_param($stmt, "ssdss", $productName, $productDesc, $productPrice, $image, $date);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../products-adm.php?error=none");
    exit();
}

// Funkcja do wyciągania danych o produktach z bazy danych (posortowane po ID produktu)
function showProducts($conn) {
    $sql = "SELECT * FROM products ORDER BY productId";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: products-adm.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_execute($stmt);

   // $result = mysqli_query($conn, $sql);
   // $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
   // return $rows;
    
    $resultData = mysqli_stmt_get_result($stmt);

    if ($rows = mysqli_fetch_all($resultData, MYSQLI_ASSOC)) {
        return $rows;
    } else {
        $result = false;
        return $result;
    }
    
    mysqli_stmt_close($stmt);
}

// Funkcja wyciągająca z bazy danych informacje o konkretnym produkcie (po ID)
function selectProduct($conn, $productId) {
    $sql = "SELECT * FROM products WHERE productId = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: products-adm.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $productId);
    mysqli_stmt_execute($stmt);

    //$result = mysqli_query($conn, $sql);
    //$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //return $rows;
    
    $resultData = mysqli_stmt_get_result($stmt);

    if ($rows = mysqli_fetch_array($resultData, MYSQLI_ASSOC)) {
        return $rows;
    } else {
        $result = false;
        return $result;
    }
    
    mysqli_stmt_close($stmt);
}

// Funkcja tworzy randomowy string
// Wzięta z ....                                                                            # Wstawić linka
function randomString($n)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $str .= $characters[$index];
    }

    return $str;
}

// Funkcja edytująca dane produktu w bazie danych
function editProduct($conn, $productName, $productDesc, $productPrice, $image, $id) {
    $sql = "UPDATE products SET productName = ?, productDesc = ?, productPrice = ?, productImage = ? where productId = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../edit.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssdsi", $productName, $productDesc, $productPrice, $image, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../products-adm.php?error=none");
    exit();
}

// Funkcja usuwająca produkt z bazy danych
function deleteProduct($conn, $id) {
    $sql = 'DELETE FROM products WHERE productId = ?;';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../products-adm.php?error=deleteError");
        exit();
    }
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../products-adm.php?error=none");
    exit();
}

// Funkcja pobiera samo ID produktu. Wykorzystana żeby sprawdzić, czy dany produkt o takim id istnieje w bazie
// ponieważ strona produktu jest generowana za pomocą $_GET i użytkownik może tam wpisać dowolny numer
// jeżeli taki produkt nie istnieje to dalej jest przekierowanie 
function productsID($conn, $param) {
    $sql = "SELECT productId FROM products WHERE productId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: products-adm.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $param);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_fetch($stmt);

   // $result = mysqli_query($conn, $sql);
   // $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
   // return $rows;
    
   // $resultData = mysqli_stmt_get_result($stmt);

    return $resultData;
    
    mysqli_stmt_close($stmt);
}

// Funkcja sprawdzająca czy użytkownik uzupełnił wszystkie pola w formularzu zmiany hasła
function emptyChangePwdFields($pwd, $newPwd, $repNewPwd) {
    $result = false;
    if (empty($pwd) || empty($newPwd) || empty($repNewPwd)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Funkcja sprawdzająca czy hasło podane w formularzu zmiany hasła jest poprawne
function checkPwd($conn, $username, $password) {
    $uidExists = uidExists($conn, $username, $username);
    $result = false;
    $pwdHashed = $uidExists["userPwd"];
    $checkPwd = password_verify($password, $pwdHashed);
    if ($checkPwd === false) {
        $result = true;
    } else if ($checkPwd === true) {
        $result = false;
    }
    return $result;
}

// Funkcja zmieniająca hasło w bazie danych
function changePwd ($conn, $username, $password) {
    $sql = "UPDATE users set userPwd = ? where userUid = ?;";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../edit-user.php?error=stmtfailed");
        exit();
    }
    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ss", $hashedPwd, $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../edit-user.php?error=pwdChange");
    exit();
}

// Funkcja sprawdza czy użytkownik ma dodany adres na swoim koncie
function checkAddress($conn, $user) {
    $sql = "SELECT userAddress, userPostalCode, userCity, userPhoneNum FROM users where userUid = ?";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../edit-user.php?error=stmtfailed");
        exit();
    }

    //$result = true;

    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        //$result = false;
        echo 'Błąd';
    }

    mysqli_stmt_close($stmt);
}

// Funkcja srawdza czy są uzupełnione wszystkie pola przy dodawaniu adresu
function emptyAddAddressField($adres, $kod, $miasto, $tel) {
    $result = false;
    if (empty($adres) || empty($kod) || empty($miasto) || empty($tel)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Funkcja sprawdza poprawność kodu pocztowego
function checkPostalCode($kod) {
    $result = false;
    if (!preg_match("/[0-9]{2}-[0-9]{3}/", $kod)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Funkcja sprawdza czy numer tel ma 9 cyfr
function checkPhone($tel) {
    $result = false;
    if (!preg_match("/[0-9]{9}/", $tel)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Funkcja dodająca dane adresowe do użytkownika
function addAddress($conn, $user, $adres, $kod, $miasto, $tel) {
    $sql = "UPDATE users set userAddress = ?, userPostalCode = ?, userCity = ?, userPhoneNum = ? where userUid = ?;";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../edit-user.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssis", $adres, $kod, $miasto, $tel, $user);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../edit-user.php?error=adresDodany");
    exit();
} 

// Funkcja pobiera dane o produkcie o konkretnym ID
function showProduct($conn, $prodId) {
    $sql = "SELECT * FROM products where productId = ?";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: products-adm.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $prodId);
    mysqli_stmt_execute($stmt);
    
    $resultData = mysqli_stmt_get_result($stmt);

    if ($rows = mysqli_fetch_assoc($resultData)) {
        return $rows;
    } else {
        $result = false;
        return $result;
    }
    
    mysqli_stmt_close($stmt);
}

// Funkcja wyciągająca zamówienia dla danego konta użytkownika
// Jeżeli jest to admin wyrzuca wszystkie zamówienia
function selectOrder($conn, $userId) {
    if ($userId === 1) {
        $sql = "SELECT * FROM orders";

        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: products-adm.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_execute($stmt);
        
        $resultData = mysqli_stmt_get_result($stmt);

        if ($rows = mysqli_fetch_all($resultData, MYSQLI_ASSOC)) {
            return $rows;
        } else {
            $result = false;
            return $result;
        }
        
        mysqli_stmt_close($stmt);
    } else {
        $sql = "SELECT * FROM orders where userId = ?";

        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: products-adm.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        
        $resultData = mysqli_stmt_get_result($stmt);

        if ($rows = mysqli_fetch_all($resultData, MYSQLI_ASSOC)) {
            return $rows;
        } else {
            $result = false;
            return $result;
        }
        
        mysqli_stmt_close($stmt);
    }
}

// Funkcja aktualizująca status zamówienia
function updateOrderStatus($conn, $status, $orderId) {
    $sql = "UPDATE orders set orderStatus = ? where orderId = ?;";
    
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: products-adm.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "si", $status, $orderId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Funkcja wyciąga konkretne zamówienie z bazy danych
function selectProductOrder ($conn, $arr, $userId) {
    for ($i = 0; $i < count($arr); $i++) {
        echo '<div style="border: 1px solid black;margin: 20px 5px;">';
        echo '<p>Numer zamówienia: <b>'.$arr[$i]['orderId'].'</b></p>';
        $unserialized = unserialize($arr[$i]['orderArr']);
        $prodId = array_keys($unserialized);
        //var_dump($unserialized);
        foreach ($prodId as $key) {
            $product = selectProduct($conn, $key);
            echo '<p>Nazwa produktu: <b>'.$product['productName'].'</b> ';
            echo 'Zakupiona ilosć: <b>'.$unserialized[$key].'</b></p>';
        }
        echo '<p>Wartość zamówienia: <b>' . $arr[$i]['orderPrice'] . '</b></p>';
        echo '<p>Status zamówienia: <b>'. $arr[$i]['orderStatus'] . '</b></p>';
        if ($userId === 1) {
            echo '<form action="" method="post">';
            echo '<label for="status">Wybierz status zamówienia: </label>';
            echo '<select name="status" id="status">';
                echo '<option value="dodane">Dodane</option>';
                echo '<option value="w realizacji">W realizacji</option>';
                echo '<option value="wyslane">Wysłane</option>';
                echo '<option value="zakonczone">Zakończone</option></select>';
            echo '<input type="hidden" name="orderId" value="' . $arr[$i]['orderId'] . '">';
            echo '<input type="hidden" name="orderStatus" value="' . $arr[$i]['orderStatus'] . '">';
            echo '<button type="submit" name="editStatus">Zmień</button></form>';

        }
        echo '</div>'; 
    }
    if (isset($_POST['editStatus'])) {
        updateOrderStatus($conn, $_POST['status'], $_POST['orderId']);
        header("Refresh:0");exit;
    }
}

// Funkcja szukająca w bazie produktów o pasującej nazwie
function searchProducts($conn, $search) {
    $sql = "SELECT * FROM products WHERE productName LIKE '%" . $search . "%';";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: products-adm.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    
    $resultData = mysqli_stmt_get_result($stmt);

    if ($rows = mysqli_fetch_all($resultData, MYSQLI_ASSOC)) {
        return $rows;
    } else {
        $result = false;
        return $result;
    }
    
    mysqli_stmt_close($stmt);
}

// Funkcja wyciąga z bazy produkty po dacie dodania
function selectNewProducts($conn) {
    $sql = "SELECT * FROM products ORDER BY create_date desc limit 3";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_execute($stmt);

   // $result = mysqli_query($conn, $sql);
   // $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
   // return $rows;
    
    $resultData = mysqli_stmt_get_result($stmt);

    if ($rows = mysqli_fetch_all($resultData, MYSQLI_ASSOC)) {
        return $rows;
    } else {
        $result = false;
        return $result;
    }
    
    mysqli_stmt_close($stmt);
}

// Funkcja do walidacji wprowadzanych danych przez użytkownika
// Wzięta z https://www.w3schools.com/php/php_form_validation.asp
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }