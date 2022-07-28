<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
</head>
<body>
    <section class="header">
        <div class="headerTitle">
            <p>Shop now and get free shipping</p>
        </div>
        <nav class="topNav" id="topNav">
            <i onclick="showNav()"id="mobileNav" class="bi bi-list"></i>
            <div class="navLogo">
                <a href="home.php"><p>Sole<span> Supremacy</span></p></a>
            </div>
            <div  id="navLinks">
                <form action="categories.php" method="get">
                    <button type="button" onclick="document.location='home.php'">Shop All</button>
                    <button type="submit" name="catBTN" value="Nike">Nike</button>
                    <button type="submit" name="catBTN" value="Adidas">Adidas</button>
                </form>
            </div>
            <div class="navIcons">
                <a href="account.php"><i id="personIcon" class="bi bi-person"></i></a>
                <a href="cart.php"><i id="cartIcon" class="bi bi-cart"></i></a>
                <a href="logout.php"><i id="cartIcon" class="bi bi-box-arrow-left"></i></a>
            </div>
        </nav>
    </section>
    <script src="index.js"></script>
</body>
</html>