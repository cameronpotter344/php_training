<?php
ob_start();
session_start();
include('head.php');
require('database.php');
require('varDeclare.php');
$database = new database('localhost','root','','dvd_shop');

echo $_SESSION['customer_id'];
    if(empty($_POST['customer_id']))
        {
            $customer_id = $_SESSION['customer_id'];
        }else
        {
            $customer_id=$_POST['customer_id'];
        }

?>

<div id="test"></div>
<div class="top_nav">
    <!--BACK BUTTON-->
    <form action="customers.php" >
        <input type='submit' name="back" value="BACK" class="back">
    </form>

    <!--NEW ORDER -->
    <form method="post" action="placeOrder.php">
        <input type='hidden' name="customer_id" value="<?php echo $customer_id; ?>">
        <!--MIGHT NOT NEED <input type="hidden" name="name" value="<?php //echo $_POST['name']; ?>">-->
        <input type='submit' name="order" value="New Order" class="new_order" id="new_order">
    </form>
    <h1><?php $name_array = $database -> fetch_one("SELECT name FROM customer WHERE id = '$customer_id'");
$name=$name_array['name']; echo $name; ?></h1>
</div>
<!--TABLE-->
 <table class="hover_table">
    <tr>
        <th>First Name</th>
        <th>DVD Title</th>
        <th>Rent Date</th>
        <th>Due Date</th>
        <th>update</th>
        <th>delete</th>
        <th>add dvd</th>
    </tr>
<?php 
    $search="SELECT dvd_order.id, dvd_order.order_id, dvd_order.dvd_id, orders.customer_id, dvd.title, customer.name, orders.rent_date, orders.due_date
        FROM dvd_order  
        INNER JOIN orders
        ON dvd_order.order_id = orders.id
        INNER JOIN dvd
        ON dvd_order.dvd_id=dvd.id
        INNER JOIN customer
        ON orders.customer_id=customer.id
        WHERE orders.customer_id = $customer_id";

    $database->set_search($search);
    $parameters = $database -> search();
    $array = $database ->fetch($parameters); 
    foreach($array as $row){ 
?>

<tr>
    <form method="post">
        <td><input type="text" name="name" value="<?php echo $row['name']; ?>"></td>
        <td>
            <select name="dvd_id">
                <option value="<?php echo $row['dvd_id'] ?>"><?php echo $row['title']; ?></option>
                <?php 
                    $dvdarray = $database->fetch("SELECT * FROM dvd");
                    foreach($dvdarray as $dvd_row)
                    {
                        $dvd_options = '<option value="'.$dvd_row["id"].'">'.$dvd_row["title"].'</option>';
                        echo $dvd_options;
                    }
                    echo '</select>'; 
                ?>
        </td>
        <td><input type="text" name="release_date" value="<?php echo $row['rent_date']; ?>"></td>
        <td><input type="text" name="release_date" value="<?php echo $row['due_date']; ?>"></td>
        <td>
            <input type='hidden' name="id" value="<?php echo $row['id'];?>">
            <input type='hidden' name="customer_id" value="<?php echo $row['customer_id'];?>">
            <input type='hidden' name="name" value="<?php echo $row['name'];?>">
            <input type='submit' value="update" name="update" class="edit">
        </td>
    </form>
    <td class="edit_delete" >
        <form method="post" action="individualOrder.php">
            <input type='hidden' name="name" value="<?php echo $row['name'];?>">
            <input type='hidden' name="dvd_id" value="<?php echo $row['dvd_id'];?>">
            <input type='hidden' name="customer_id" value="<?php echo $row['customer_id'];?>">
            <input type='submit' name="delete" value="delete" class="delete">
        </form>
    </td>


<!-- ADD DVD BUTTON -->
    <td>
        <form method="post" action="order_add_dvd.php">
            <input type='hidden' name="order_id" value="<?php echo $row['order_id']; ?>">
            <input type='hidden' name="customer_id" value="<?php echo $row['customer_id']; ?>">
            <input type='hidden' name="name" value="<?php echo $row['name']; ?>">
            <input type='submit' name="add_dvd" value="Add DVD To Order" class="add_dvd">
        </form>
    </td>
</tr>
<?php }; ?>
</table>

<!-- CANCEL ORDER QUERY-->
<?php
    $search="SELECT dvd_order.order_id
        FROM dvd_order  
        INNER JOIN orders
        ON dvd_order.order_id = orders.id
        WHERE orders.customer_id = $customer_id";

    $database->set_search($search);
    $dvd_orders_id = $database -> search();
    $id_array = $database ->fetch($dvd_orders_id); 
    $order_id = $id_array[0]['order_id'];
?>

<!--CANCEL ORDER BUTTON -->
<form method="post" style="float:left">    
    <input type='hidden' name="customer_id" value="<?php echo $customer_id; ?>">
    <!--<input type="hidden" name="name" value="<?php //echo $_POST['name']; ?>">-->
    <input type="submit" name="cancel" value="Cancel Order" class="cancel" id="cancel">
</form>


<?php 

//Update Order
if(isset($_POST['update']))
{
    $_SESSION['customer_id']=$_POST['customer_id'];
    $dvd_id = $_POST['dvd_id'];
    $id = $_POST['id'];
    echo $id;
    echo '<br>';
    echo $dvd_id;
    $database ->update("UPDATE dvd_order SET dvd_id='$dvd_id' WHERE id='$id'");
        echo '<script language="javascript">';
        echo 'if (confirm("DVD choice Changed") == true) {window.location="individualOrder.php"}';
        echo '</script>';  
}

//delete single order
// Prevent Delete of all records
if(count($array)>1)
{
   if(isset($_POST['delete']) && ($_POST['delete']=='delete'))
    {
        $id = $_POST['customer_id'];
        $dvd_id = $_POST['dvd_id'];
        echo $id;
        $database ->update("DELETE FROM dvd_order WHERE dvd_id = '$dvd_id'");
        echo 
        '
            <script language="javascript">
            if (confirm("DVD removed from order.") == true) {window.location="individualOrder.php"};
            </script>
        ';  
    } 
};

//Cancel Order
if(isset($_POST['cancel']))
{
    function cancel_order()
    {
        $id = $_POST['id'];
        $database ->update("DELETE FROM dvd_order WHERE order_id = '$order_id'");
        $database ->update("DELETE FROM orders WHERE id = '$order_id'");
    }
    echo
    '
            <script language="javascript">
            if (confirm("Are you sure you want to cancel the order?") == true) 
                {
                    '.cancel_order().' 
                };
            </script>   
    ';
}

?>

<script type="text/javascript">
var x = (50*((<?php echo json_encode($array); ?>).length))+"px";
document.getElementById("cancel").style.height = x;

if( ((<?php echo json_encode($array); ?>).length) > 0)
{
    document.getElementById("new_order").style.visibility="hidden";
}
</script>