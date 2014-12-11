<?php
ob_start();
session_start();
include('head.php');
require('database.php');
require('varDeclare.php');
$database = new database('localhost','root','','dvd_shop');

//ADD DVD FORM
echo '<form method="post" action="order_add_dvd.php"> <select name="dvd_id" class="add_dvd">';
$dvd_array = $database->fetch("SELECT * FROM dvd");
foreach($dvd_array as $dvd_row)
{
	$dvd_options = '<option value="'.$dvd_row["id"].'">'.$dvd_row["title"].'</option>';
                    echo $dvd_options;
}
echo '</select>';
echo '<input type="hidden" name="customer_id" value="'.$_POST["customer_id"].'">';
echo '<input type="hidden" name="name" value="'.$_POST["name"].'">';
echo '<input type="hidden" name="order_id" value="'.$_POST["order_id"].'">';
echo '<input type="submit" name="add_dvd" class="add_dvd">';
echo '</form>';

//GO BACK TO ORDERS
echo '<form method="post" action="individualOrder.php">'; 
echo '<input type="hidden" name="customer_id" value="'.$_POST["customer_id"].'">';
echo '<input type="hidden" name="name" value="'.$_POST["name"].'">';
echo '<input type="hidden" name="order_id" value="'.$_POST["order_id"].'">';
echo '<input type="submit" name="test" value="BACK"  class="go_back">';
echo '</form>';

//Add DVD
if(isset($_POST['add_dvd']))
{
    $order_id = $_POST['order_id'];
    $dvd_id =$_POST['dvd_id'];
    echo $order_id;
    echo $dvd_id;
    $database ->update("INSERT INTO dvd_order (dvd_id, order_id)
        VALUES ( $dvd_id , $order_id)");
    if(!empty($dvd_id)){echo
    '
    		<script language="javascript">
    		confirm("DVD has been added.");
    		</script>
    ';}
}
?>