<?php
ob_start();
session_start();
include('head.php');
require('database.php');
require('varDeclare.php');
$database = new database('localhost','root','','dvd_shop');

//CALCULATING OWED AMOUNT
$search = "SELECT rent_date FROM orders WHERE id = '164'";
$database->set_search($search);
$parameters = $database ->search();
$array =$database ->fetch_one($parameters);


$date = $array['rent_date'];
$today = date("Y-m-d H:i:s");

$date1=date_create($date);
$date2=date_create($today);
$diff=date_diff($date1,$date2);
$days = $diff->format("%a");
echo $days;

function owed()
{
	$days*count($array)*25;
}

?>
<table>
	<tr>
		<th> Name </th>
		<th> Surname </th>
		<th> DVDs </th>
		<th> Rent Date </th>
		<th> Amount Owed </th>
	</tr>
	<?php 
	    //$customer_id = $_POST['customer_id'];
	    //$name = $_POST['name'];
	    $search="SELECT dvd_order.id, dvd_order.order_id, dvd_order.dvd_id, orders.customer_id, dvd.title, customer.name,customer.surname , orders.rent_date, orders.due_date
	        FROM dvd_order  
	        INNER JOIN orders
	        ON dvd_order.order_id = orders.id
	        INNER JOIN dvd
	        ON dvd_order.dvd_id=dvd.id
	        INNER JOIN customer
	        ON orders.customer_id=customer.id
	        WHERE orders.customer_id = 117";

	    $database->set_search($search);
	    $parameters = $database -> search();
	    $array = $database ->fetch($parameters); 
	    foreach($array as $row){ 
	?>
	<tr>
		<td><?php echo $row['name']; ?></td>
		<td><?php echo $row['surname']; ?></td>
		<td><?php echo $row['title']; ?></td>
		<td><?php echo $row['rent_date']; ?></td>
		<td>R <!-- AMOUNT OWED --></td>
	</tr>
	<?php } ?>
</table>

