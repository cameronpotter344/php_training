<?php
ob_start();
session_start();
include('head.php');
require('database.php');
require('varDeclare.php');
$database = new database('localhost','root','','dvd_shop');
?>



 <table class="hover_table">
    <tr>
        <th>First Name</th>
        <th>DVD Title</th>
        <th>Rent Date</th>
        <th>Due Date</th>
    </tr>
<?php 
    $search="SELECT orders.id, dvd_order.dvd_id, orders.customer_id, dvd.title, customer.name, orders.rent_date, orders.due_date
        FROM dvd_order  
        INNER JOIN orders
        ON dvd_order.order_id = orders.id
        INNER JOIN dvd
        ON dvd_order.dvd_id=dvd.id
        INNER JOIN customer
        ON orders.customer_id=customer.id";

    $database->set_search($search);
    $parameters = $database -> search();
    $array = $database ->fetch($parameters); 
    foreach($array as $row){ ?>
<tr>
    <td><input type="text" name="name" value="<?php echo $row['name']; ?>"></td>
    <td><input type="text" name="release_date" value="<?php echo $row['title']; ?>"></td>
    <td><input type="text" name="release_date" value="<?php echo $row['rent_date']; ?>"></td>
    <td><input type="text" name="release_date" value="<?php echo $row['due_date']; ?>"></td>
    <td>
        <input type='hidden' name="id" value="<?php echo $row['id'];?>">
        <input type='submit' value="update" name="update" class="edit">
    </td>
</form>
    <td class="edit_delete">
        <form method="post">
            <input type='hidden' name="id" value="<?php echo $row['id'];?>">
            <input type='submit' name="delete" value="delete" class="delete">
        </form>
    </td>
</tr>


<?php };

//delete order
if(isset($_POST['delete']))
{
    $id = $_POST['id'];
    echo $id;
    $database ->update("DELETE FROM dvd_order WHERE order_id = '$id'");
    $database ->update("DELETE FROM orders WHERE id = '$id'");
    header("Location: order.php");
}

?>