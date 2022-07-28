<?php
session_start();
require_once('connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="index.js"></script>
</head>

<body>
    <nav class="logInNav">
        <div class="logInnavMain">
            <div class="navLogo">
                <p>Sole<span> Supremacy</span></p>
            </div>
        </div>
    </nav>
    <section class="logInBody">
        <div class="Test">
            <form id="logInForm" action="login.php" method="POST">
                <div class="logInBodyContainer">
                    <h2>Sign in to your Account</h2>
                    <div class="logInInner">
                        <label for="username">Username*</label>
                        <input type="text" name="username" id="username">
                        <label for="passwordLabel">Password*</label>
                        <input type="password" name="pwd" id="passwordLabel">
                    </div>
                    <button name="signin" class="logInBTN" type="submit">Sign in</button>
                    <div class="registerLine">
                        <p>Don't have an Account Yet?</p>
                        <button type="button" id="registerButton">register</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="test2">
            <form action="register.php" id="registerForm" method="POST">
                <div class="registerContainer">
                    <div class="twoCol">
                        <div class="col">
                            <label for="rFName">First Name</label>
                            <input type="text" name="FName" id="FName">
                        </div>
                        <div class="col">
                            <label for="rLName">Last Name</label>
                            <input type="text" name="LName" id="LName">
                        </div>
                    </div>
                    <div class="row">
                        <label for="username">username</label>
                        <input type="text" name="username" id="username">
                    </div>
                    <div class="row">
                        <label for="email">email</label>
                        <input type="email" name="email" id="email">
                    </div>
                    <div class="row">
                        <label for="password">password</label>
                        <input type="password" name="pwd" id="pwd">
                    </div>
                    <div class="twoCol">
                        <div class="col">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" id="phone">
                        </div>
                        <div class="col">
                            <label for="zip">Zip</label>
                            <input type="text" name="zip" id="zip">
                        </div>
                    </div>
                    <button name="register" class="logInBTN" type="submit">Register</button>
                </div>
            </form>

        </div>

    </section>
    <?php require_once("footer.php")?>
</body>

</html>