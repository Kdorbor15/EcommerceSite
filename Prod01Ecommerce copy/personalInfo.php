<?php
session_start();
include_once('connection.php');
include_once('header.php');
include_once('bottomnav.php');
$user = $_SESSION['user'];
$fetchInfo = mysqli_fetch_array(mysqli_query($conn,"SELECT first_name,last_name,pwd,zip,email from client where username = '$user'"));
$fetchAddress = mysqli_query($conn,"SELECT address_id,address_line,city,zip,address_name,first_name,last_name,state,apt
                 FROM address WHERE client_id = (SELECT client_id FROM client WHERE username = '$user')") or die(mysqli_error($conn));
if(isset($_POST['updateInfo'])){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $editInfo = mysqli_query($conn,"UPDATE client SET first_name = '$firstname',last_name = '$lastname', email = '$email' WHERE username = '$user'") or die(mysqli_error($conn));
    echo "<meta http-equiv='refresh' content='0'>";
    
}
if(isset($_POST['changepwd'])){
    $currpass = $_POST['currPassword'];
    $newPass = $_POST['newPassword'];
    $confirmPass = $_POST['confirmPassword'];

    $actualPassword = mysqli_fetch_row(mysqli_query($conn,"SELECT pwd from client WHERE username = '$user'"));
    if($currpass == $actualPassword[0]){
        if($newPass == $confirmPass){
            $changepass = mysqli_query($conn,"UPDATE client SET pwd = '$newPass' WHERE username = '$user'");
            echo' <script>alert("password successfully changed");</script>';
        }else{
            echo '<script>alert("new password and confirm password does not match")</script>';
        }
    }else{
        echo '<script>alert("current password do not match")</script>';
    }
}
if(isset($_POST['addAddressBTN'])){
    $address_name = $_POST['addressName'];
    $firstname = $_POST['addressFname'];
    $lastname = $_POST['addressLname'];
    $address_line = $_POST['addressInput'];
    $apt = $_POST['apt'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    
    $addAddressSQL = mysqli_query($conn,"INSERT INTO address (client_id,address_line,city,zip,address_name,first_name,last_name,state,apt) 
                     VALUES ((SELECT client_id FROM client WHERE username = '$user'),'$address_line','$city','$zip','$address_name','$firstname','$lastname','$state','$apt')") or die(mysqli_error($conn));
    echo "<meta http-equiv='refresh' content='0'>";
}

if(isset($_POST['editAddressBTN'])){
   $address_id = $_POST['editAddressBTN'];

   $t1 = "SELECT address_id,address_name,first_name,last_name,address_line,apt,city,state,zip
   FROM address WHERE address_id = '$address_id' AND client_id = 
   (SELECT client_id FROM client WHERE username ='$user')";
   $t2 = mysqli_fetch_array(mysqli_query($conn,$t1));

}
if(isset($_POST['saveAddressBTN'])){
    $address_id = $_POST['saveAddressBTN'];
    $address_name = $_POST['editAddressName'];
    $first_name = $_POST['editAddressfname'];
    $last_name = $_POST['editAddressLname'];
    $address_line = $_POST['editAddressInput'];
    $apt = $_POST['editapt'];
    $city = $_POST['editcity'];
    $state = $_POST['editstate'];
    $zip = $_POST['editzip'];

    $editAddressSQL = mysqli_query($conn,"UPDATE client_address SET 
     address_name = '$address_name',first_name = '$first_name',last_name = '$last_name',address_line = '$address_line',
     apt = '$apt',city='$city',state='$state',zip='$zip' WHERE address_id = '$address_id'");
}
if(isset($_POST['removeAddressBTN'])){
    $address_id = $_POST['removeAddressBTN'];
    $removeSQL = mysqli_query($conn,"DELETE FROM address WHERE address_id ='$address_id'") or die(mysqli_error($conn));
    echo "<meta http-equiv='refresh' content='0'>";
}
$fetchPaymentSQL = mysqli_query($conn,"SELECT payment_id,first_name,last_name,card_number,exp_month,exp_year FROM payment WHERE client_id = (SELECT client_id FROM client WHERE username ='$user')") or die(mysqli_error($conn));
if(isset($_POST['addCardBTN'])){
  $first_name = $_POST['cardFName'];
  $last_name = $_POST['cardLName'];
  $card_number = $_POST['cardNumber'];
  $expMonth = $_POST['expMonth'];
  $expYear = $_POST['expYear'];
  $cvc = $_POST['cvc'];
  $addCardSQL = mysqli_query($conn,"INSERT INTO payment (client_id,card_number,exp_month,exp_year,cvc,first_name,last_name) VALUES ((SELECT client_id FROM client WHERE username = '$user')
                ,'$card_number','$expMonth','$expYear','$cvc','$first_name','$last_name')") or die(mysqli_error($conn));
                echo "<meta http-equiv='refresh' content='0'>";
}
if(isset($_POST['removeCardBTN'])){
    $payment_id = $_POST['removeCardBTN'];
    $removeCardSQL = mysqli_query($conn,"DELETE FROM payment WHERE payment_id = '$payment_id'") or die(mysqli_error($conn));
    echo "<meta http-equiv='refresh' content='0'>";
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
    <title>Personal Info</title>
</head>
<body>
    
    <section class="personalInfoBody">
        <h3>Personal Info</h3>
        <div class="userRow">
            <div id="defaultInfo">
                <div class=defaultInfoInner>
                    <div class="userFieldBox">
                        <span>Name</span>
                        <span><?php echo $fetchInfo['first_name']." ".$fetchInfo['last_name']?></span>
                    </div>
                    <div class="userFieldBox">
                        <span>Email</span>
                        <span><?php echo $fetchInfo['email']?></span>
                    </div>
                    <div class="userFieldBox">
                        <span>Password</span>
                        <?php $censored = str_replace($fetchInfo['pwd'],"*******",$fetchInfo['pwd']) ?>
                        <span><?php echo $censored?></span>
                    </div>
                    <div class="userFieldBox">
                        <span>Zip</span>
                        <span><?php echo $fetchInfo['zip'] ?></span>
                    </div>
                    <div class="editUserInfo">
                        <button class="editUserInfoBTN"  type="button" id="showEditField">edit</button>
                    </div>
                    <div class="editUserInfo">
                        <button class="editUserInfoBTN" type="button" id="showPasswordField">Change Password</button>
                    </div>
                </div>
            </div >
            <div id="editInfo">
                <form id="editInfoInner" action="personalInfo.php" method = "post">
                    <div class="editPersonalInfo">
                        <div class="nameFields">
                            <div class="nameContainer">
                                <label for="fname">First Name</label>
                                <input type="text" name="firstname" id="fname" value = <?php echo $fetchInfo['first_name'] ?>>
                            </div>
                            <div class="nameContainer">
                                <label for="lname">Last Name</label>
                                <input type="text" name="lastname" id="lname" value = <?php echo $fetchInfo['last_name'] ?>>
                            </div>
                        </div>
                        <div class="emailField">
                            <div class="emailContainer">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" value = <?php echo $fetchInfo['email'] ?>>
                            </div>
                        </div>
                        <div class="infoFunctionField">
                            <div class="containers">
                                <button id="reloadInfo" type="submit" name="updateInfo">Update</button>
                            </div>
                            <div class="containers">
                                <button type="button" id="showDefaultField">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="changePasswordDiv">
                <form action="personalInfo.php" id="changePass" method="post">
                    <div class="changePasswordContainer">
                        <div class="passwordField">
                            <div class="passwordContainer">
                                <label for="currPassword">Current Password*</label>
                                <input type="password" name="currPassword" id="currPassword">
                            </div>
                        </div>
                        <div class="passwordField">
                            <div class="passwordContainer">
                                <label for="newPassword">New Password*</label>
                                <input type="password" name="newPassword" id="newPassword">
                            </div>
                        </div>
                        <div class="passwordField">
                            <div class="passwordContainer">
                                <label for="confirmPassword">Confirm New Password*</label>
                                <input type="password" name="confirmPassword" id="confirmPassword">
                            </div>
                        </div>
                        <div class="infoFunctionField">
                            <div class="containers">
                                <button type="submit" name="changepwd">Update</button>
                            </div>
                            <div class="containers">
                                <button type="button" id="passToDefault">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="addressHeader">
            <h3>Addresses</h3>
            <button id="defaultToAddAddress" type="button">Add Address</button>
        </div>
           <div class="addressRow">
                 <div id="defaultAddressDiv">
                    <div class="addressBoxMain">
                     <?php
                            if(mysqli_num_rows($fetchAddress) ==  0){
                                echo"<h1 class='noRez'>No Addresses Added</h1>";
                            }else{
                            while($row = mysqli_fetch_array($fetchAddress)){
                            echo"<div class='addressDetails'>";
                            echo"<p class='addressName'>".$row['address_name']."</p>";
                            echo"<p class='addressUserName'>".$row['first_name']. " " .$row['last_name']."</p>";
                            echo"<p class='addressStreet'>".$row['address_line']. " " .$row['apt']."</p>";
                            echo"<p class='addressCity'>".$row['city']. "," .$row['state']. ", " .$row['zip']."</p>";
                            echo"<form id='' action='personalInfo.php' method='post'>";
                            echo"<button class='editAddressBTN' type='submit' name='editAddressBTN' value=".$row["address_id"].">Edit</button>";
                        echo"<button class='editAddressBTN' type='submit' name='removeAddressBTN' value=".$row["address_id"].">Remove</button>";
                        echo"</form>";
                        echo"</div>";
                            }
                        }
                        ?>
                    </div>
                </div>
                <div id="addAddressDiv">
                    <form id="addAddress" action="personalInfo.php" method="post">
                        <div class="addAddressContainer">
                            <div class="addressNameField">
                                <div class="addressNameContainer">
                                    <label for="addressName">Address Name*</label>
                                    <input type="text" name="addressName" id="addressName">
                                </div>
                            </div>
                            <div class="addressUserNameFields">
                                <div class="addressUserNameContainer">
                                    <label for="addressfname">First Name</label>
                                    <input type="text" name="addressFname" id="addressfname">
                                </div>
                                <div class="addressUserNameContainer">
                                    <label for="addlname">Last Name</label>
                                    <input type="text" name="addressLname" id="addlname">
                                </div>
                            </div>
                            <div class="addressInputField">
                                <div class="adddressInputContainer">
                                    <label for="addressInput">Address</label>
                                    <input type="text" name="addressInput" id="addressInput">
                                </div>
                            </div>
                            <div class="cityAPTField">
                                <div class="cityContainer">
                                    <label for="apt">Apt/Suite</label>
                                    <input type="text" name="apt" id="apt">
                                </div>
                                <div class="cityContainer">
                                    <label for="city">City</label>
                                    <input type="text" name="city" id="city">
                                </div>
                            </div>
                            <div class="stateZipField">
                                <div class="stateContainer">
                                    <label for="state">State</label>
                                    <input type="text" name="state" id="state">
                                </div>
                            </div>
                            <div class="stateContainer">
                                <label for="zip">ZIP Code</label>
                                <input type="text" name="zip" id="zip" >
                            </div>
                        </div>
                        <div class="infoFunctionField">
                            <div class="containers">
                                <button type="submit" name="addAddressBTN">Save Address</button>
                            </div>
                            <div class="containers">
                                <button type="button" id="addAddressToDefault">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="editAddressDiv">
                    <form id="editAddress" action="personalInfo.php" method="post">
                        <div class="addAddressContainer">
                            <div class="addressNameField">
                                <div class="addressNameContainer">
                                    <label for="addressName">Address Name*</label>
                                    <input type="text" name="addressName" id="editAddressName" value= <?php  echo($t2["address_name"])?>>
                                </div>
                            </div>
                            <div class="addressUserNameFields">
                                <div class="addressUserNameContainer">
                                    <label for="addressfname">First Name</label>
                                    <input type="text" name="addressfname" id="editAddressfname" value = <?php echo($t2['first_name'])?>>
                                </div>
                                <div class="addressUserNameContainer">
                                <label for="lname">Last Name</label>
                                <input type="text" name="addressLname" id="editAddressLname" value = <?php echo $t2['last_name']?>>
                                </div>
                            </div>
                            <div class="addressInputField">
                                <div class="adddressInputContainer">
                                    <label for="addressInput">Address</label>
                                    <input type="text" name="addressInput" id="editAddressInput" value ="<?php echo$t2['address_line']?>">
                                </div>
                            </div>
                            <div class="cityAPTField">
                                <div class="cityContainer">
                                    <label for="apt">Apt/Suite</label>
                                    <input type="text" name="apt" id="editapt" value= <?php echo $t2['apt']?>>
                                </div>
                                <div class="cityContainer">
                                    <label for="city">City</label>
                                    <input type="text" name="city" id="editcity" value= <?php echo $t2['city']?>>
                                </div> 
                            </div>
                            <div class="stateZipField">
                                <div class="stateContainer">
                                    <label for="state">State</label>
                                    <input type="text" name="state" id="editstate" value= <?php echo $t2["state"]?>>
                                </div>
                                <div class="stateContainer">
                                    <label for="zip">ZIP Code</label>
                                    <input type="text" name="zip" id="editzip" value= <?php echo $t2['zip']?>>
                                </div>
                            </div>
                            <div class="infoFunctionField">
                                <div class="containers">
                                    <button type="submit" name="saveAddressBTN" value= <?php echo $t2['address_id']?>>Save Address</button>
                                </div>
                                <div class="containers">
                                    <button type="button" id="editAddressToDefault">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <div class="addressHeader">
            <h3>Payment Methods</h3>
            <button type="button" name="" id="defaultToPayment">Add Card</button>
        </div>
        <div class="paymentRow">
              <div id="defaultPayment">
                    <div class="paymentBoxMain">
                        <div class="inner">
                            <?php
                            if(mysqli_num_rows($fetchPaymentSQL) ==  0){
                                echo"<h1 class='noRez'>No Payment Methods Added</h1>";
                            }else{
                            while($p2=mysqli_fetch_array($fetchPaymentSQL)){
                            echo"<div class='paymentDetails'>";
                            echo"<p class='addressUserName'>".$p2['first_name']." ".$p2['last_name']."</p>";
                            $censoredValue = substr_replace($p2['card_number'],"xxxxxxxxxxxx",0,12);
                            echo"<p class='addressCity'>".$censoredValue."</p>";
                            echo"<p class='addressCity'>Exp: " .$p2['exp_month']."/".$p2['exp_year']."</p>";
                            echo"<form action='personalInfo.php' method='post'>";
                            echo"<button type='submit' class='rcBTN' name='removeCardBTN' value=".$p2["payment_id"].">Remove</button>";
                             echo"</form>";
                            echo"</div>";
                            }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div id="addPayment">
                 <form action="personalInfo.php" id="addCard" method="post" >
                        <div class="addCardContainer">
                            <div class="cardUserNameField">
                                <div class="cardUserNameContainer">
                                    <label for="cardFName">First Name</label>
                                    <input type="text" name="cardFName" id="cardFName">
                                </div>
                                <div class="cardUserNameContainer">
                                    <label for="cardLname">Last Name</label>
                                    <input type="text" name="cardLName" id="cardLName">
                                </div>
                            </div>
                            <div class="cardNumberField">
                                <div class="cardNumberContainer">
                                    <label for="cardNumber">Card Number</label>
                                    <input type="text" name="cardNumber" id="cardNumber">
                                </div>
                            </div>
                            <div class="cardInfoField">
                                <div class="cardInfoContainer">
                                    <label for="cvc">cvc</label>
                                    <input type="text" name="cvc" id="cvc">
                                </div>
                                <div class="cardInfoContainer">
                                    <label for="expirationMonth">Expiration Month</label>
                                    <input type="text" name="expMonth" id="expirationMonth">
                                </div>
                                <div class="cardInfoContainer">
                                    <label for="expirationYear">Expiration Year</label>
                                    <input type="text" name="expYear" id="expirationYear">
                                </div>
                            </div>
                            <div class="infoFunctionField">
                                <div class="containers">
                                    <button type="submit" name="addCardBTN">Add Card</button>
                                </div>
                                <div class="containers">
                                    <button id="paymentToDefault">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </section>
    <script src="index.js"></script>
</body>

</html>