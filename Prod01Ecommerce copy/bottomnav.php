<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Document</title>
</head>

<body onload="showLabel()">
    <section class="bottomNav">
        <p class="bottomNavHeader" id="bottomNavLabel">My Account</p>
        <div class="bottomNavLinks" id="bottomNavi">
            <ul>
                <li id="accountPG" class="bNavLink"><a href="account.php" class="bottomNavLink">My Account</a></li>
                <li id="infoPG" class="bNavLink"><a href="personalInfo.php" id="infoPG" class="bottomNavLink">Personal
                        Info</a></li>
                <li id="orderPG" class="bNavLink"><a href="orders.php" class="bottomNavLink">Orders</a></li>
            </ul>
        </div>
        <a href="javascript:void(0)" class="BNL" onclick="toggleBottomNav()">
            <i class="bi bi-chevron-down"></i>
        </a>
    </section>
    <script src="index.js"></script>
</body>

</html>