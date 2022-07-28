
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>home</title>
</head>

<body>
    <?php
    session_start();
    require_once('connection.php');
    require_once('header.php');
    $sql = "SELECT product_img,product_name,product_price,product_id FROM product";
    $result = mysqli_query($conn,$sql);
    ?>
    <div id="banner" class="banner">
        <img src="images/banner2.jpeg" alt="">
    </div>
    <section class="merchBody">
        <h1>Best Seller</h1>
        <div class="merchBox">
            <?php
            if(mysqli_num_rows($result)> 0){
               while($row = mysqli_fetch_array($result)){
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
    <?php require_once("footer.php") ?>
    <script src="index.js"></script>
</body>

</html>