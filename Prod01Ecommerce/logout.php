<?php
require('connection.php');
unset($_SESSION['user']);
echo '<script>alert("Logged Out");
                    window.location="index.php";</script>';
die();
?>