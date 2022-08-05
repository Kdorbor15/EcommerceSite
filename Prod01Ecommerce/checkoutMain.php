<?php
session_start();
require_once('connection.php');

$user = $_SESSION['user'];

// SQL statement to fetch the address information of the user
$fetchAddress = mysqli_query($conn,"SELECT address_line, address_id 
                                    FROM address WHERE client_id = 
                                    (SELECT client_id FROM client WHERE username='$user')");

//SQL statement to fetch the payment informations of the user
$fetchPayment = mysqli_query($conn,"SELECT card_number, payment_id 
                                    FROM payment WHERE client_id = 
                                    (SELECT client_id FROM client WHERE username='$user')");

// SQL statement to fetch all of the items in the cart.
$fetchCart = mysqli_query($conn,"SELECT product_img,product_name,product_price,size,quantity,product.product_id,cart_item.cart_item_id
                            FROM product INNER JOIN cart_item ON product.product_id = cart_item.product_id 
                            WHERE cart_item.cart_id = 
                           (SELECT cart_id FROM cart WHERE client_id = (SELECT client_id FROM client WHERE username = '$user'))");

//SQL statement to fetch the quantity and price of all of the products in the cart.
 $getTargets = mysqli_fetch_array(mysqli_query($conn,"SELECT SUM(quantity) 
                                               FROM product INNER JOIN cart_item
                                               ON product.product_id = cart_item.product_id WHERE cart_item.cart_id = 
                                              (SELECT cart_id FROM cart WHERE client_id = (SELECT client_id FROM client WHERE username = '$user'))"));
 $getTarget2 = mysqli_query($conn,"SELECT product_price,quantity 
                                  FROM product INNER JOIN cart_item ON product.product_id = cart_item.product_id 
                                  WHERE cart_item.cart_id = 
                                 (SELECT cart_id FROM cart WHERE client_id = (SELECT client_id FROM client WHERE username = '$user'))");

 // multiplies the price of each item with its quantity
while($tt = mysqli_fetch_array($getTarget2)){
    $subbie += ($tt['product_price'] * $tt['quantity']);
    // $subbie = 1;
}


// adds a new user input address
if(isset($_POST['AtoD'])){
    $first_name = $_POST['addressFname'];
    $last_name = $_POST['addressLname'];
    $address_line = $_POST['address_line'];
    $address_name = $_POST['address_name'];
    $apt = $_POST['apt'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];
    $state = $_POST['state'];
    
    $addAddressSql = mysqli_query($conn,"INSERT INTO address (client_id,address_line,city,zip,address_name,first_name,last_name,state,apt) 
                                         VALUES((
                                         SELECT client_id 
                                         FROM client 
                                         WHERE username='$user'),'$address_line','$city','$zip','$address_name','$first_name','$last_name','$state','$apt')") 
                                         or die(mysqli_error($conn));

     $address_id = mysqli_insert_id($conn);
     header("location: checkoutMain.php");
}

// adds a new user input payment method
if(isset($_POST['PtoD'])){
  $cardNumber = $_POST['cardNumber'];
  $first_name = $_POST['fName'];
  $last_name = $_POST['lName'];
  $expMonth = $_POST['expMonth'];
  $expYear = $_POST['expYear'];
  $cvc = $_POST['cvc'];

  $addPaymentSQL = mysqli_query($conn,"INSERT INTO payment (client_id,card_number,exp_month,exp_year,cvc,first_name,last_name) 
                                       VALUES((
                                       SELECT client_id 
                                       FROM client 
                                       WHERE username='$user'),'$cardNumber','$expMonth','$expYear','$cvc','$first_name','$last_name')") 
                                       or die(mysqli_error($conn));

   $payment_id = mysqli_insert_id($conn);
   header("location: checkoutMain.php");
}


// user completes the transaction
if(isset($_POST['complete'])){
    $address_id = $_POST['shippingaddress'];
    $payment_id = $_POST['paymentMethod'];
    $order_status = "Complete";
    $order_date = date("F d, Y");
    $quantity = $getTargets[0];
    $radVal = $_POST['rad'];
    $shippingPrice = 0;

    if($radVal == "5.00"){
     $shippingPrice = 5.00;
    }else if($radVal == "0.00")
       $shippingPrice = 0;
    else{
        $shippingPrice = 15.00;
    }
    $total = floatval(($subbie + $shippingPrice) * 1.07);
    

    // inserts the completed transaction in the users completed orders section
    $sql = mysqli_query($conn,"INSERT INTO orders (client_id,address_id,payment_id,status,order_date,quantity,total) 
                               VALUES((
                               SELECT client_id 
                               FROM client 
                               WHERE username='$user'),'$address_id','$payment_id','$order_status','$order_date','$quantity','$total')") 
                               or die(mysqli_error($conn));

    //removes all of the items from the cart after the transaction is completed.
    $removesql = mysqli_query($conn,"DELETE FROM cart_item 
                                     WHERE cart_id = (
                                     SELECT cart_id 
                                     FROM cart 
                                     WHERE client_id = (
                                     SELECT client_id FROM client WHERE username='$user'))");
    echo '<script>alert("Transaction Complete! Redirecting to Orders page");
                    window.location="orders.php";</script>';


}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Checkout</title>
</head>

<body onload="getShippingPrice()">
    <nav class="checkoutNav">
        <div class="backout">
            <a href="cart.php"><i class="bi bi-chevron-left"> Back</i></a>
        </div>
        <div class="navMain">
            <div class="navLogo">
                <p>Sole<span> Supremacy</span></p>
            </div>
        </div>
    </nav>

    <section class="checkoutBody">
        <form id="cForm" name="checkoutForm" action="checkoutMain.php" method="post">
            <div class="checkoutSteps">
                <div class="row">
                    <div class="infoStepBox">
                        <div class="stepHeading">
                            <h3 class="step">Step 1 - Shipping Info</h3>
                        </div>
                        <div id="defaultShippingInfo">
                            <div class="shippingInfo">
                                <label for="pickaddress" class="pickaddressLabel">Select from saved addresses</label>
                                <div class="selectContainer">
                                    <select name="shippingaddress" id="pickaddress">
                                        <?php
                                        while($r1 = mysqli_fetch_array($fetchAddress)){
                                            $selected = ($address_id == $r1['address_id'] ? "selected='selected'" : "");
                                            $r1s = "<option value='".$r1['address_id']."' ".$selected .">".$r1['address_line']."</option>";
                                            echo $r1s;
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="shippingInfoFunctions">
                                    <button type="button" id="DtoA" class="checkoutBTN">Add New Address</button>
                                </div>
                            </div>
                        </div>
                        <div class="addShippingInfo" id="addShippingInfo">
                            <div class="addShipmentInfoContainer">
                                <div class="addAddressContainer">
                                    <div class="addressUserNameFields">
                                        <div class="addressUserNameContainer">
                                            <label for="addressfname">First Name*</label>
                                            <input class="requiredInput" type="text" name="addressFname"
                                                id="addressfname">
                                        </div>
                                        <div class="addressUserNameContainer">
                                            <label for="lname">Last Name*</label>
                                            <input class="requiredInput" type="text" name="addressLname"
                                                id="addressLname">
                                        </div>
                                    </div>
                                    <div class="addressInputField">
                                        <div class="adddressInputContainer">
                                            <label for="addressInput">Address*</label>
                                            <input class="requireInput" type="text" name="address_line"
                                                id="address_line">
                                        </div>
                                    </div>
                                    <div class="addressInputField">
                                        <div class="adddressInputContainer">
                                            <label for="addressInput">Address Name*</label>
                                            <input class="requiredInput" type="text" name="address_name"
                                                id="address_name">
                                        </div>
                                    </div>
                                    <div class="cityAPTField">
                                        <div class="cityContainer">
                                            <label for="apt">Apt/Suite</label>
                                            <input type="text" name="apt" id="apt">
                                        </div>
                                        <div class="cityContainer">
                                            <label for="city">City*</label>
                                            <input class="requiredInput" type="text" name="city" id="city">
                                        </div>
                                    </div>
                                    <div class="stateZipField">
                                        <div class="stateContainer">
                                            <label for="state">State*</label>
                                            <input class="requiredInput" type="text" name="state" id="state">
                                        </div>
                                        <div class="stateContainer">
                                            <label for="zip">ZIP Code*</label>
                                            <input class="requiredInput" type="text" name="zip" id="zip">
                                        </div>
                                    </div>
                                </div>
                                <div class="shippingInfoFunctionsAdds">
                                    <button type="submit" name="AtoD" id="AtoD" class="functionsBTN">Save
                                        Address</button>
                                    <button type="button" class="functionsBTN" id="cancelAddy">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="infoStepBox">
                        <div class="stepHeading">
                            <h3 class="step">Step 2 - Shipping Method</h3>
                        </div>
                        <div class="methodForm">
                            <div id="shippingMethod">
                                <div class="methodContainers">
                                    <input class="rad" type="radio" name="rad" value="0.00" checked="checked">
                                    <label for="standard">Standard: Free (Delivers in 7 Business Days or
                                        Less)</label>
                                </div>
                                <div class="methodContainers">
                                    <input class="rad" type="radio" name="rad" value="5.00">
                                    <label for="express">Express: $5.00 (Delivers in 3 Business Days or
                                        Less)</label>
                                </div>
                                <div class="methodContainers">
                                    <input class="rad" type="radio" name="rad" value="15.00">
                                    <label for="overnight">Overnight: $15.00(Delivers in 1 Business Days or
                                        Less)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="infoStepBox">
                        <div class="stepHeading">
                            <h3 class="step">Step 3 - Payment Method</h3>
                        </div>
                        <div id="defaultPaymentInfo">
                            <div class="paymentInfo">
                                <label for="pickPayment" class="pickPaymentLabel">Select from saved payments</label>
                                <div class="selectContainer">
                                    <select name="paymentMethod" id="pickpayment">
                                        <?php
                                        while($r2 = mysqli_fetch_array($fetchPayment)){
                                            $selectedd = ($payment_id == $r2['payment_id'] ? "selected='selected'" : "");
                                            $censoredValue = substr_replace($r2['card_number'],"xxxxxxxxxxxx",0,12);
                                            $r2s = "<option value='".$r2['payment_id']."' ".$selectedd .">".$censoredValue."</option>";
                                            echo $r2s;
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="shippingInfoFunctions">
                                    <button type="button" id="DtoP" class="checkoutBTN">Add New Payment</button>
                                </div>
                            </div>
                        </div>
                        <div class="addPaymentInfo" id="addPaymentInfo">
                            <div class="addCardBox">
                                <div class="cardMaxBox">
                                    <input type="text" name="cardNumber" placeholder="Number">
                                </div>
                                <div class="cardNameBox">
                                    <div class="fNameBox">
                                        <input type="text" name="fName" placeholder="First Name">
                                    </div>
                                    <div class="lNameBox">
                                        <input type="text" name="lName" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="cardInfoBox">
                                    <div class="cardInfoBoxInner">
                                        <input type="text" name="expMonth" placeholder="Exp Month">
                                    </div>
                                    <div class="cardInfoBoxInner">
                                        <input type="text" name="expYear" placeholder="Exp Year">
                                    </div>
                                    <div class="cardInfoBoxInner">
                                        <input type="text" name="cvc" placeholder="CVC">
                                    </div>
                                </div>
                                <div class="shippingInfoFunctionsAdds">
                                    <button type="submit" name="PtoD" id="PtoD" class="functionsBTN">Save Card</button>
                                    <button type="button" class="functionsBTN" id="cancelPayment">Cancel</button>
                                </div>
                            </div>
                        </div>
                        <button name="complete" class="completeBTN">Complete Transaction</button>
                    </div>
                </div>
            </div>
            <div class="orderSummary" id="orderSummary">
                <div class="sumHeading">
                    <p class="orderSummaryHeading">Order Summary</p>
                    <button type="button" id="toggleOrderSummary"><i id="toggleDown"
                            class="bi bi-chevron-down"></i></button>
                </div>
                <div id="mobileSummary">
                    <div class="orderSummaryInner">
                        <div class="row">
                            <div class="col">Subtotal:</div>
                            <div class="col"><span>$</span><span id="k1"><?php echo$subbie ?></span></div>
                        </div>
                        <div class="row">
                            <div class="col">Shipping:</div>
                            <div class="col"><span>$</span><span id="k2">0</span></div>
                        </div>
                        <div class="row">
                            <div class="col">Tax:</div>
                            <div class="col"><span>$</span><span id="k3">0</span></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="total">Total:</div>
                            <div class="col"><span>$</span><span name="total" id="k4">0</span></div>
                        </div>

                    </div>
                    <div class="orderSummaryInner">
                        <div class="shoppingBagHeader">
                            <p>Shopping Bag</p>
                        </div>
                        <?php
                    while($row = mysqli_fetch_array($fetchCart)){
                        echo"<div class='row2'>";
                            echo"<div class='merchImg'>";
                                echo"<img src=".$row['product_img'].">";
                            echo"</div>
                            <div class='bagContent'>
                                <div class='bagName'>";
                                    echo"<p>".$row['product_name']."</p>";
                                    echo"<p>$".$row['product_price']."</p>
                                </div>
                                <div class='bagInfo'>";
                                    echo"<p>(US)  ".$row['size']."</p>";
                                    echo"<p>QTY:  ".$row['quantity']."</p>
                                </div>
                            </div>
                        </div>";
                    }
                    ?>
                    </div>
                </div>
            </div>
        </form>
    </section>
</body>
<script src="index.js"></script>
<script>
function resetMenu() {
    if (window.innerWidth > 900) {
        document.getElementById('mobileSummary').style.display = 'block';
    }
}
window.addEventListener('resize', resetMenu);
</script>

</html>