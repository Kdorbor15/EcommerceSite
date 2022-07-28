<?php
session_start();
require_once('connection.php');
require_once('header.php');
$product_id = $_GET['view'];
$fetchProduct = mysqli_fetch_row(mysqli_query($conn,"SELECT product_name, product_price, product_img FROM product WHERE product_id = '$product_id'"))
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Merch</title>
</head>
<body>

    <!-- <section id="includeBottomNav"></section> -->

    <section class="merchBody2">
        <div class="merchInfo">
            <div class="merchPicture">
                <img src='<?php echo $fetchProduct[2]?>'alt="">
            </div>
            <div class="merchWritings">
                <form action="addToCart.php" method="get">
                <h1><?php echo $fetchProduct[0]?></h1>
                <p class="price">$<?php echo $fetchProduct[1]?></p>
                <div class="merchSizing">
                    <p>size</p>
                    <div class="option">
                            <select name="shoeSize" id="shoeSize">
                                <option value="#">Pick a Size</option>
                                <option value="6">6(US)</option>
                                <option value="6.5">6.5(US)</option>
                                <option value="7">7(US)</option>
                                <option value="7.5">7.5(US)</option>
                                <option value="8">8(US)</option>
                            </select>
                        <div class="quantityBox">
                                 <label for="quantity">QTY:</label>
                                 <input type="number" value="1" id="quantity" name="quantity" min="1" max="10">
                        </div>
                    </div>
                    <div class="merchFunction">
                        <button name='add' type='submit' class='merchPageBTN' value= '<?php echo $product_id ?>'>Add to Cart</button>
                    </div>
                </div>
               </form>
            </div>
        </div>
    </section>
    <?php require_once('footer.php') ?>
</body>
</html>