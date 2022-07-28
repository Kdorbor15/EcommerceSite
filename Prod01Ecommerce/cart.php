<?php
session_start();
require_once('connection.php');
require_once('header.php');
require_once('bottomnav.php');
$user = $_SESSION['user']; // php variable for user

// updates the quantity for the shoes
if(isset($_GET['update'])){
    $item_id = $_GET['update'];  // php variable the stores the id for the shoe that is being updated
    $qty = $_GET['quantity'];   // current quantity of the shoe

    // sql statement updates the quantity
    $test = "UPDATE cart_item SET quantity = '$qty' WHERE cart_id = 
    (SELECT cart_id from cart WHERE client_id = 
    (SELECT client_id FROM client where username = '$user')) AND cart_item_id = '$item_id'";
    $testResult = mysqli_query($conn,$test) or die(mysqli_error($conn));
}

// removes the shoes from the cart
if(isset($_GET['remove'])){
    $item_id = $_GET['remove'];  // php variable the stores the id for the shoe that is to be removed

    // sql statement that removes the shoes from the cart
    $remove = "DELETE FROM cart_item WHERE cart_id = 
    (SELECT cart_id FROM cart WHERE client_id = 
    (SELECT client_id FROM client WHERE username = '$user')) AND cart_item_id = '$item_id'";
    $removeResult = mysqli_query($conn,$remove) or die(mysqli_error($conn));
}

// sql statement that displays information on all of the products that are in the cart
$sql = "SELECT product_img,product_name,product_price,size,quantity,product.product_id,cart_item.cart_item_id 
       FROM product INNER JOIN cart_item 
       ON product.product_id = cart_item.product_id 
       WHERE cart_item.cart_id = 
       (SELECT cart_id FROM cart WHERE 
       client_id = (SELECT client_id FROM client WHERE username = '$user'))";

//sql statement thats fetches the sum of how many items are in the cart.
$count = mysqli_fetch_row(mysqli_query($conn,"SELECT SUM(quantity) from cart_item WHERE cart_id = 
(SELECT cart_id from cart WHERE client_id = 
(SELECT client_id from client WHERE username = '$user'))"));

$result = mysqli_query($conn,$sql);
$subtotal = 0;

// if there are no items in the count the estimated shipping gets the value of 0, or the default value of 6;
if($count[0] == NULL){
      $estimatedShipping = 0;
}else{
    $estimatedShipping = 6;
}
$estimatedSalesTax = 0;
$total = 0;

$count[0] = $count[0] == null ? 0 : $count[0];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>

    <!-- <section id="includeBottomNav"></section>  -->
    <section class="cartBody">
        <div class="cartContainerHeader">
            <div class="cartHeader">
                <h3>My Bag:<span> <?php echo $count[0] ?> Items</span></h3>
            </div>
            <div class="continueShoppingContainer">
                <a href="home.php">Continue Shopping</a>
            </div>
        </div>
        <div class="mainContainer">
            <div class="cartContainer">
                <?php
            while ($row = mysqli_fetch_array($result)){
            echo"<div class='cartItems'>
                 <form action = 'cart.php' method = 'get'>
                   <div class='itemRow'>
                    <div class='itemImageContainer'>";
                       echo"<img src=".$row["product_img"].">
                    </div>
                    <div class='itemFields'>
                        <div class='itemFieldsTop'>
                            <div class='itemContent'>";
                               echo "<div class='itemName'>". $row["product_name"] ."</div>";
                               echo "<p class='size'><span class='sizeText'>Size:</span> ".$row['size']."</p>
                            </div>
                            <div class='itemPrice'>";
                               echo"<p>$".$row["product_price"]."</p>
                            </div>
                        </div>
                        <div class='itemFieldsBottom'>
                            <div class='itemQuantityContainer'>
                             <label for='quantity'>QTY:</label>
                             <input type='number'  placeholder='".$row["quantity"]."'id='inputQuant' name='quantity' min='1' max='10'>
                            </div>
                            <div class='itemOptions'>
                                <button type='submit' name='update' value=".$row['cart_item_id'].">update</button>
                            </div>
                            <div class='itemOptions'>
                            <button type='submit' name='remove' value=".$row["cart_item_id"].">remove</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>";
             $subtotal += ($row['quantity'] * $row['product_price']);
            }
            ?>
            </div>
            <?php $estimatedSalesTax = ($subtotal + $estimatedShipping) * .07; 
               $total = $subtotal + $estimatedSalesTax; ?>

            <div class="orderSummary">
                <p class="orderSummaryHeading">Order Summary</p>
                <div class="row">
                    <div class="col">Subtotal:</div>
                    <div class="col">$<?php echo $subtotal ?></div>
                </div>
                <div class="row">
                    <div class="col">Est* Shipping:</div>
                    <div class="col">$<?php echo $estimatedShipping ?></div>
                </div>
                <div class="row">
                    <div class="col">Est* Tax:</div>
                    <div class="col">$<?php echo $estimatedSalesTax ?></div>
                </div>
                <hr>
                <div class="row">
                    <div class="total">Total:</div>
                    <div class="col">$<?php echo $total ?></div>
                </div>
                <form action="checkoutMain.php">
                    <div class="row">
                        <button type='submit' class="checkoutBTN">Checkout</button>
                    </div>
                </form>
            </div>
            <div class="hiddenSummary">
                <div class="hiddenTotal">
                    <div>Estimated Total</div>
                    <div>$<?php echo $total ?></div>
                </div>
                <form action="checkoutMain.php">
                    <div class="hiddenButton">
                        <button type='submit' class="checkoutBTN">Checkout</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="index.js"></script>
</body>

</html>