<?php
ob_start();
session_start();
include('head.php');
require('database.php');
require('varDeclare.php');
$database = new database('localhost','root','','dvd_shop');
$customer_id=$_POST['customer_id'];
$name_array = $database -> fetch_one("SELECT name FROM customer WHERE id = '$customer_id'");
$name=$name_array['name'];

//ADD CUSTOMER FORM
echo '<form method="post">';
echo '<br>';

echo $name;

echo '<br>';

echo 'First DVD';
echo '<br>';
echo '<select name="dvd_id">';
echo '<option value="empty"></option>';
$dvdarray = $database->fetch("SELECT * FROM dvd");
foreach($dvdarray as $dvd_row){
	$dvd_options = '<option value="'.$dvd_row["id"].'">'.$dvd_row["title"].'</option>';
	echo $dvd_options;
}
echo '</select>';
echo '<br>';

echo 'Second DVD';
echo '<br>';
echo '<select name="dvd_id2">';
echo '<option value="empty"></option>';
$dvdarray = $database->fetch("SELECT * FROM dvd");
foreach($dvdarray as $dvd_row){
	$dvd_options = '<option value="'.$dvd_row["id"].'">'.$dvd_row["title"].'</option>';
	echo $dvd_options;
}
echo '</select>';
echo '<br>';
echo 'Third DVD';
echo '<br>';
echo '<select name="dvd_id3">';
echo '<option value="empty"></option>';
$dvdarray = $database->fetch("SELECT * FROM dvd");
foreach($dvdarray as $dvd_row){
	$dvd_options = '<option value="'.$dvd_row["id"].'">'.$dvd_row["title"].'</option>';
	echo $dvd_options;
}
echo '</select>';


echo '<input type="hidden" name="customer_id" value="'.$_POST["customer_id"].'">';
//echo '<input type="hidden" name="name" value="'.$_POST["name"].'">';
echo '<br> <input type="submit" name="submit" value="Order" class="edit"  style="float:left">';
echo '</form>';

//ADD ORDER
if(isset($_POST['submit']))
{
	$customer_id = $_POST['customer_id'];
	$dvd_id = $_POST['dvd_id'];
	$dvd_id2 = $_POST['dvd_id2'];
	$dvd_id3 = $_POST['dvd_id3'];
	$_SESSION['customer_id']=$_POST['customer_id'];

	if($dvd_id!="empty")
	{
		$database->update
		(
			"INSERT INTO orders (customer_id, rent_date, due_date) 
			VALUES ($customer_id, NOW(), NOW() + INTERVAL 1 DAY);"
		);
		echo '<script language="javascript">';
        echo 'if (confirm("Order Has Been Made") == true) {window.location="individualOrder.php"}';
        echo '</script>'; 
		if($dvd_id2=="empty" && $dvd_id3=="empty")
		{
			$database->update
			(	
				"INSERT INTO dvd_order (order_id, dvd_id)  
				VALUES (LAST_INSERT_ID(), $dvd_id)"
			);
		}else if($dvd_id3=="empty")
		{
			$database->update
			(	
				"INSERT INTO dvd_order (order_id, dvd_id)  
				VALUES (LAST_INSERT_ID(), $dvd_id), (LAST_INSERT_ID(), $dvd_id2)"
			);
		}else 
		{
			$database->update
			(	
				"INSERT INTO dvd_order (order_id, dvd_id)  
				VALUES (LAST_INSERT_ID(), $dvd_id), (LAST_INSERT_ID(), $dvd_id2), (LAST_INSERT_ID(), $dvd_id3)"
			);
		}
	}
}
?>
<!--BACK BUTTON -->
<form method="post" action="individualOrder.php">
    <input type="hidden" name="customer_id" value="<?php echo $_POST['customer_id']; ?>">
  <!-- <input type="hidden" name="name" value="<?php //echo $_POST['name']; ?>"> -->
    <input type='submit' name="back" value="BACK" class="delete">
</form>