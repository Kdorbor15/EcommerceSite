<?php
    session_start();
    require_once('connection.php');
        if(isset($_GET['add'])){
        
        $product_id = $_GET['add']; // php variable for the product id
        $user = $_SESSION['user'];  // php variable for the user id
        $qty = $_GET['quantity'];  // php variable for the quantity
        $size = $_GET['shoeSize']; // php variable for the shoe size

        // SQL statement to check if the shoe is already in the cart
        $checkSQL = mysqli_query($conn,"SELECT product_id,size FROM cart_item WHERE cart_id = 
                                 (SELECT cart_id FROM cart WHERE client_id =
                                 (SELECT client_id FROM client WHERE username = '$user')) AND product_id = '$product_id' AND size='$size'");
                        

        // if the shoe is already in the cart, we update the quantity instead of duplicating the shoes if not we add the shoe to the cart.
        if(mysqli_num_rows($checkSQL) > 0){
            $prevQuantity = "SELECT quantity FROM cart_item WHERE cart_id = 
            (SELECT cart_id FROM cart WHERE client_id = 
            (SELECT client_id FROM client WHERE username = '$user')) AND product_id = '$product_id' AND size='$size'";
            $rez = mysqli_query($conn,$prevQuantity) or die(mysqli_error($conn));
            $r2 = mysqli_fetch_row($rez);
            echo $r2[0];
            $update = "UPDATE cart_item SET quantity = '$qty' + '$r2[0]' WHERE product_id = '$product_id' AND size = '$size'";
            $main = mysqli_query($conn,$update) or die(mysqli_error($conn));
        
        }else{
            $addToCart = "INSERT INTO cart_item (cart_id,product_id,quantity,size) VALUES 
                     ((SELECT cart_id FROM cart WHERE client_id = 
                     (SELECT client_id FROM client WHERE username ='$user')),$product_id,$qty,$size)";
            $result = mysqli_query($conn,$addToCart);

         }
         echo '<script>alert("Item Added to Cart!");
         window.location="home.php";</script>';
        }
?>