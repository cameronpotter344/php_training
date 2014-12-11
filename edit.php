<?php
session_start();
include('head.php');
require('database.php');
require('varDeclare.php');
$id = $_POST['id'];
echo $id;
$database = new database('localhost','root','','dvd_shop');
$array = $database->fetch_one("SELECT * FROM customer WHERE id = $id");
?>
    <h1>Customer</h1>
<div id="form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="add_form" > 
    <div class="inner_form">
        Name: 
        <br>
        <input type="hidden" name="NEWid" value="<?php echo $_POST['id']?>">
        <input type="text" name="name"  value="<?php echo $array['name'];?>">
        <br><br>
        Surname: 
        <br>
        <input type="text" name="surname"  value="<?php echo $array['surname'];?>">
        <br><br>
        E-mail:
        <br>
        <input type="text" name="email"  value="<?php echo $array['email'];?>">
        <br><br>
        Address:
        <br>
        <input type="text" name="address" value="<?php echo $array['address'];?>">
        <br><br>
        SA ID Number:
        <br>
        <input type="text" name="sa_id_number"  value="<?php echo $array['sa_id_number'];?>">
        <br><br>
        Contact Number:
        <br>
        <input type="text" name="contact_number"  value="<?php echo $array['contact_number'];?>">
        <br><br>
            <input type='hidden' name="id" value="<?php echo $array['id'];?>">
            <input type='submit' name="submit" class="update">
           </form>
          </div>
    </form>
</div>

<?php 

//update Navicat database
if(isset($_POST['submit'])){
    if ($name ==""||$surname==""||$contact_number==""||$email==""||$sa_id_number==""||$address=="")
    {
        echo '<script language="javascript">';
        echo 'alert("Fill in all fields")';
        echo '</script>';
    }else
    {
    	$database ->update("UPDATE customer SET name='$name',surname='$surname',email='$email',address='$address',sa_id_number='$sa_id_number',contact_number='$contact_number' 
    		WHERE id='$id'");
        $_SESSION['yes']="updated";
        header("Location: customers.php");
    }
}
echo '<br /><a href="customers.php?' . SID . '"></a>';
?>