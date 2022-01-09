<?php
    include_once 'header.php';
?>

    <div>
        <?php // zmiana wyświetlanej zawartości w zależności czy jest to admin, zalogowany użytkownik, czy gość ?>
        <?php if (isset($_SESSION["useruid"]) && $_SESSION["userid"] === 1) : ?>
            <h1>Tryb administacyjny</h1>
            <ul>
                <li><a href="products-adm.php">Zarządzaj produtami</a></li>
                <li><a href="zamowienia-adm.php">Zarządzaj zamówieniami</a></li>
            </ul>
        <?php else : ?>

            <section class="firstsection">
                <div class="box-main">
                    <div class="firstHalf">
                        <?php if (isset($_SESSION["useruid"]) && $_SESSION["userid"] !== 1) : ?>
                        <h1 class="text-main" id="main">
                            Witaj w naszym sklepie <?php echo $_SESSION["username"] ?>
                        </h1><br>
                        <?php else : ?>
                            <h1 class="text-main" id="main">Nazwa sklepu</h1><br>
                        <?php endif; ?>
                        
                        
                        <h2>Zajmujemy się sprzedażą najlepszego sprzętu na rynku. Niesustannie się rozwijamy i dbamy o zadowolenie naszych klientów! </h2>
                        <h2> Zobacz dlaczego warto nam zaufać!</h2>
        
                    </div>
                </div>
            </section>

            <section class="secondsection">
                <div class="row">
                    <div class="col-3">
                        <img src="images/foto9.jpg" alt=""><br><br>
                        <h3>Najlepszy sprzęt</h3><br>
                        <p>Na naszej stronie znajdziesz sprzęt najwyższej jakości, który spełni twoje wszylkie oczekiwania. 
                        Nie zwlekaj i zapoznaj się z naszą ofertą. Znajdź sprzęt idealny dla siebie! </p>
        
        
                    </div>
                    <div class="col-3">
                        <img src="images/computer2.jpg" alt=""><br><br>
                        <h3>Doskonałe wsparcie</h3><br>
                        <p>Masz watpiliwości co do zakupu? Potrzebujesz pomocy w wybraniu najlepszego dla Ciebie sprzętu?
                            Odwiedź zakładkę <a href="kontakt.html">Kontakt</a> i zadaj nam pytanie.  </p>
        
        
                    </div>
                    <div class="col-3">
                        <img src="images/s3.jpg" alt=""><br><br>
                        <h3>Właściwa cena</h3><br>
                        <p>W naszej ofercie posiadamy sprzęt na każdą kieszeń. 
                            Znajdź odpowiedni produkt dla siebie i ciesz się odpowiednią ceną bez dodatkowych kosztów. </p>
        
        
                    </div>
                </div>
            </section>

            <?php
                require_once '../includes/db.php';
                require_once '../includes/functions.php';
                $products = selectNewProducts($conn); 
                // pobranie najnowszych produktów i ich wyświetlenie
            ?>
            <?php if(!empty($products)) : ?>
            <div class="sekcja-produkty">
                <h1 class="tytul">NAJNOWSZE PRODUKTY</h1>
                <div class="row-prod">
                <?php foreach ($products as $i => $product) : ?>
                    <div class="col-4">
                        <a href="product.php?prod_id=<?php echo $product['productId'] ?>"><img src="<?php echo $product['productImage'] ?>"></a>
                        <h3><?php echo $product['productName'] ?></h4>
                            <p class="price"><?php echo $product['productPrice'] ?></p>
                            <br>
                            
                            <button class='inf' id="inf" ><a href="product.php?prod_id=<?php echo $product['productId'] ?>">Szczegóły</a></button><br><br>
                    </div>
                
                <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

<?php
    include_once 'footer.php';
?>