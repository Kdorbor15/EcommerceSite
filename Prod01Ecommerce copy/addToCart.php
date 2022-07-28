<?php
    session_start();
    require_once('connection.php');
        if(isset($_GET['add'])){
        $product_id = $_GET['add'];
        $user = $_SESSION['user'];
        $qty = $_GET['quantity'];
        $size = $_GET['shoeSize'];
        $checkSQL = mysqli_query($conn,"SELECT product_id,size FROM cart_item WHERE cart_id = 
                                 (SELECT cart_id FROM cart WHERE client_id =
                                 (SELECT client_id FROM client WHERE username = '$user')) AND product_id = '$product_id' AND size='$size'");
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
    header("location: home.php");
        }
?>