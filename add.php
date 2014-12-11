<?php 
session_start();
include('head.php');
require('database.php');
require('varDeclare.php'); 
$database = new database('localhost','root','','dvd_shop');
$error ="";
?>

<h1>Add New Customer</h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="add_form">
    <div class="inner_form"> 
    Name:<br><input type="text" name="name" value="<?php echo $name; ?>">
        <br><br>
    Surname: <br><input type="text" name="surname" value="<?php echo $surname; ?>" >
        <br><br>
    E-mail:<br> <input type="text" name="email" value="<?php echo $email; ?>">
        <br><br>
    Address: <br><input type="text" name="address" value="<?php echo $address; ?>" >
        <br><br>
    SA ID Number:<br> <input type="text" name="sa_id_number" value="<?php echo $sa_id_number; ?>">
        <br><br>
    Contact Number: <br><input type="text" name="contact_number" value="<?php echo $contact_number; ?>">
        <br><br>
        <input type="submit" name="submit" value="submit" class="update">
       	<input type="submit" name="cancel" value="cancel" class="cancel">
        </div>
</form>
 <span class="error"><?php echo $error;?></span>
<?php
//update Navicat database
if(isset($_POST['submit'])){
if ($name ==""||$surname==""||$contact_number==""||$email==""||$sa_id_number==""||$address==""){
	echo '<script language="javascript">';
    echo 'alert("Fill in all fields")';
    echo '</script>';
	}else{
        $database ->update("INSERT INTO customer (name,surname,contact_number,email,sa_id_number,address)
        VALUES('$name','$surname', '$contact_number', '$email', '$sa_id_number', '$address')");
  		header("Location: customers.php");
        $_SESSION['yes']="added";
	}
}

if(isset($_POST['cancel'])){
		header("Location: customers.php");
	}

$_SESSION['test']="working";
?>
</body>
</html>