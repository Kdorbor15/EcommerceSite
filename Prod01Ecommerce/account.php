<?php
session_start();
include_once('connection.php');
include_once('header.php');
include_once('bottomnav.php');
$user = $_SESSION['user'];

// SQL Query to fetch information on the user's addresses
$fetchAddress = mysqli_query($conn,"SELECT address_id,address_line,city,zip,address_name,first_name,last_name,state,apt
                 FROM address 
                 WHERE client_id = 
                 (SELECT client_id 
                 FROM client 
                 WHERE username = '$user')") or die(mysqli_error($conn));

// SQL Query to fetch information on the user's orders
$fetchOrder = mysqli_query($conn,"SELECT order_id,total,order_date,quantity 
            FROM orders 
            WHERE client_id = 
            (SELECT client_id 
            FROM client 
            WHERE username='$user')") or die(mysqli_error($conn));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Account</title>
</head>

<body>
    <section id="includeHeader"></section>
    <section id="includeBottomNav"></section>
    <section class="accountBody">
        <div class="infoBox">
            <p class="infoHeading">Personal Info</p>
            <?php
            if(mysqli_num_rows($fetchAddress) < 1){
                echo "<h1 class='noRez'>No Addresses Added</h1>";
            }
            while($row = mysqli_fetch_array($fetchAddress)){
           echo"<div class='addressBox'>";
                echo"<p class='addressHeading'>".$row['address_name']."</p>";
                echo"<p class='addy'>".$row['first_name']." ".$row['last_name']."</p>";
                echo"<p class='addy'>".$row['address_line']."  ".$row['apt']."</p>";
                echo"<p class='addy'>".$row['city'].", ".$row['state']." ".$row['zip']."</p>
            </div>";
            }
            ?>
            <button onclick="document.location='personalInfo.php'" class="infoButton">Manage Personal Info</button>
        </div>
        <div class="ordersBox">
            <p class="ordersHeading">Recent Orders</p>
            <div class="ordersTable">
                <table class="ordersTableInner">
                    <?php
                    if(mysqli_num_rows($fetchOrder) < 1){
                        echo"<h1 class='noRez'>No Recent Orders</h1>";
                    }else{
                    echo"<tr>
                        <th>Order Number</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th>Quantity</th>
                    </tr>";
                    }
                    while($row2 = mysqli_fetch_array($fetchOrder)){
                        echo"<tr>";
                        echo"<td>".$row2['order_id']."</td>";
                        echo"<td>$".$row2['total']."</td>";
                        echo"<td>".$row2['order_date']."</td>";
                        echo"<td>".$row2['quantity']."</td>";
                        echo"</tr>";
                    }
                    ?>
                </table>

            </div>
        </div>
    </section>
    <script src="index.js"></script>
</body>

</html>