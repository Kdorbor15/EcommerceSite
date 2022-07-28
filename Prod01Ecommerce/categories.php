<?php
session_start();
require_once('connection.php');
require_once('header.php');

//SQL statement to display all of the products that are in the selected category.
if(isset($_GET['catBTN'])){
    $name = $_GET['catBTN'];
    $sql = mysqli_query($conn,"SELECT product_img,product_name,product_price,product_id FROM product WHERE category_name = '$name'") or die(mysqli_error($conn));
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
    <title><?php echo $name ?></title>
</head>

<body>
    <section class="merchBody">
        <h1><?php echo $name ?></h1>
        <div class="merchBox">
            <?php
            if(mysqli_num_rows($sql)> 0){
               while($row = mysqli_fetch_array($sql)){
                  echo "<form action='merch.php' method='get' class='merchForm'>";
                  echo "<div class='merch'>";
                  echo "<img src=" .$row["product_img"]. ">";
                  echo "<div class='merchContent'>";
                  echo "<p class='name'>".$row["product_name"]."</p>";
                  echo "<p class='price'>$".$row["product_price"]."</p>";
                  echo "</div>";
                  echo "<button type='submit' class='merchBTN' name='view' value =" . $row["product_id"] . ">view</button>";
                  echo "</div>";
                  echo "</form>";
            }
           }
            ?>
    </section>
    <script src="index.js"></script>
</body>

</html>