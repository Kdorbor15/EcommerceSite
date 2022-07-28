<?php
session_start();
include_once('connection.php');
include_once('header.php');
include_once('bottomnav.php');
$user = $_SESSION['user'];

// sql statement that fetches all of the completed transactions that the user has made.
$fetchOrders = mysqli_query($conn,"SELECT order_id,total,quantity,status,order_date,address_line,first_name,last_name,city,zip,apt,state FROM orders INNER JOIN address ON orders.address_id = address.address_id WHERE address.client_id = (SELECT client_id FROM client WHERE username='$user')");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Orders</title>
</head>

<body>
    <section class="myOrderBody">
        <div class="myOrderBodyHeader">
            <h3>My Orders</h3>
        </div>
        <?php
        if(mysqli_num_rows($fetchOrders) ==  0){
            echo"<h1 class='noRez'>No Recent Orders</h1>";
        }else{
        while($row = mysqli_fetch_array($fetchOrders)){
        echo"<div class='myOrderContainer'>";
            echo"<div class='orderPlaceHeading'>";
                echo"<span class='ordersPlacetitle'>Order Placed:</span>";
                echo"<span class='orderPlaceTime'> ".$row['order_date']."</span>
            </div>";
            echo"<div class='orderDetailContainer'>
                <div class='row'>
                    <div class='orderNumberDetails'>";
                        echo"<p class='title'>Order Number: </p>";
                        echo"<p class='orderNumber'> ".$row['order_id']."</p>
                    </div>
                    <div class='orderTotalDetails'>";
                        echo"<p class='title'>Order Total:</p>";
                        echo"<p class='secondLine'> $".$row['total']."</p>
                    </div>
                </div>
                <div class='row'>
                    <div class='orderNumberDetails'>";
                        echo"<p class='title'>Status:</p>";
                        echo"<p class='secondLine'> ".$row['status']."</p>
                    </div>
                    <div class='orderTotalDetails'>";
                        echo"<p class='title'>Items:</p>";
                        echo"<p class='secondLine'> ".$row['quantity']."</p>
                    </div>
                </div>
                <div class='row'>";
                    echo"<p class='title'>Shipping to:</p>";
                    echo"<p class='name'>".$row['first_name']." ".$row['last_name']."</p>";
                    echo"<p class='address'>".$row['address_line']." ".$row['apt']."</p>";
                    echo"<p class='addressSpec'>".$row[city].",".$row['state']." ".$row['zip']."</p>
                </div>
            </div>

        </div>";
        }
        }
        ?>
    </section>

</body>

</html>