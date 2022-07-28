
    <?php
        require_once('connection.php');
       $first_name = $_POST['FName'];
       $last_name = $_POST['LName'];
       $username = $_POST['username'];
       $pwd = $_POST['pwd'];
       $phone = $_POST['phone'];
       $email = $_POST['email'];
       $zip = $_POST['zip'];
      $sql = "SELECT client_id FROM client where username = '$username'";
      $result = mysqli_query($conn,$sql);
     if(mysqli_num_rows($result) > 0){
        echo "<script>alert('This Username Already Exist please choose a different one');
        window.location='index.php';</script>";
     }else{
        $sql = "INSERT INTO client (first_name,last_name,username,pwd,phone,email,zip) VALUES ('$first_name','$last_name','$username','$pwd','$phone','$email','$zip')";
        echo "<br>";
        $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
        if($result){
            echo "<script>alert('Account Created! Redirecting to Log In page');
            window.location='index.php';</script>";
            $cart = "INSERT INTO cart (client_id) VALUES ((SELECT client_id FROM client WHERE username = '$username'))";
            $result = mysqli_query($conn,$cart);
        }else{
            echo "<br>Error: unable to post </br>";
        }

    }
    mysqli_close();
    ?>