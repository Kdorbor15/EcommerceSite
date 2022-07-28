<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
</head>
<body>
    <?php
     session_start();
       require_once('connection.php');
       $username = $_POST['username'];
       $pwd = $_POST['pwd'];
       $sql = "SELECT username, pwd FROM client WHERE username = '$username' AND pwd = '$pwd' ";
       $result = mysqli_query($conn,$sql);
       if(mysqli_num_rows($result) > 0)
       {  
           $_SESSION['user'] = "$username";
           header("Location: home.php");
       }else{
        echo "Invalid email / password";
        echo "<br>";
        echo "<a href = 'index.php'>Go Back</a>";
       }
    ?>
</body>
</html>