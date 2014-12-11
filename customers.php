<?php
ob_start();
session_start();
include('head.php');
require('database.php');
require('varDeclare.php');
$database = new database('localhost','root','','dvd_shop');

if(isset($_SESSION['yes']) && $_SESSION['yes']=="updated")
{
        echo '<script language="javascript">';
        echo 'alert("Customer has been updated.")';
        echo '</script>';
        session_unset();
}else if(isset($_SESSION['yes']) &&$_SESSION['yes']=="added")
{
        echo '<script language="javascript">';
        echo 'alert("customer has been added")';
        echo '</script>';
        session_unset();
}

?>

<!--ALL CUSTOMERS BUTTON-->
<form method="post" class="search">
    <input type="submit" name="all" value="ALL CUSTOMERS">
</form>
<form method="post" class="search">
    <select name="filter">
        <option value="name">Name</option>
        <option value="surname">Surname</option>
        <option value="contact_number">Contact Number</option>
        <option value="email">Email</option>
        <option value="sa_id_number">SA ID NUMBER</option>
        <option value="address">Address</option>
    </select>
    <input type="text" name="search">
    <input type="submit" value="search" name="filter_user">
</form> 

<!--TABLE-->
 <table class="hover_table1">
    <tr>
        <th></th>
        <th>ID</th>
        <th>Name</th>
        <th>Surname</th>
        <th>Contact Number</th>
        <th>Email</th>
        <th>SA ID Number</th>
        <th>Address</th>
    </tr>
<?php 
    if(isset($_POST['filter_user']))
    {
        $user_input=$_POST['search'];
        $filter =  $_POST['filter'];
        $search="SELECT * FROM customer WHERE $filter like '$user_input'";
    }else
    {
        $search="SELECT * FROM customer";
    }

    $database->set_search($search);
    $parameters = $database -> search();
    $array = $database ->fetch($parameters); 
    foreach($array as $row){ ?>
<tr>
    <td class="edit_delete">
        <form method="post" action="individualOrder.php">
            <input type="hidden" name="customer_id" value="<?php echo $row['id']; ?>">
            <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
            <input type='submit' name="view" value="Order" class="edit">
        </form>
    </td>

    <form method="post">
        <td><?php echo $row['id']; ?></td>
        <td  class="customers"><input type="text" name="name" value="<?php echo $row['name']; ?>" ></td>
        <td  class="customers"><input type="text" name="surname" value="<?php echo $row['surname']; ?>"></td>
         <td  class="customers"><input type="text" name="contact_number" value="<?php echo $row['contact_number']; ?>"></td>
        <td  class="customers"><input type="text" name="email" value="<?php echo $row['email']; ?>"></td>
        <td  class="customers"><input type="text" name="sa_id_number" value="<?php echo $row['sa_id_number']; ?>"></td>
        <td  class="customers"><input type="text" name="address" value="<?php echo $row['address']; ?>"></td>
        <td>
            <input type='hidden' name="id" value="<?php echo $row['id'];?>">
            <input type='submit' value="update" name="update" class="edit">
        </td>
    </form>

        <!-- DELETE BUTTON -->
    <td class="edit_delete">
        <form method="post">
            <input type='hidden' name="id" value="<?php echo $row['id'];?>">
            <input type='submit' name="delete" value="delete" class="delete">
        </form>
    </td>

</tr>
<?php };  ?>
</table>

<!--ADD CUSTOMER BUTTON-->
<form method="post">
    <input type="submit" name="add" value="Add Customer" class="add_customer">
</form>
<?php 

//delete
if(isset($_POST['delete']))
{
    $id = $_POST['id'];
    echo $id;
    $database ->update("DELETE FROM customer WHERE id = '$id'");
    header("Location: customers.php");
}
//update
// WORKING ON RELOADING PAGE AFTER JAVASCRIPT ALERT.....NOT WORKING
if(isset($_POST['update']))
{
    $id = $_POST['id'];
    $database ->update("UPDATE customer SET name='$name',surname='$surname',email='$email',address='$address',sa_id_number='$sa_id_number',contact_number='$contact_number' 
            WHERE id='$id'");

    if ($name ==""||$surname==""||$contact_number==""||$email==""||$sa_id_number==""||$address=="")
    {
        echo '<script language="javascript">';
        echo 'alert("Fill in all fields")';
        echo '</script>';
    }else
    {
        echo '<script language="javascript">';
        echo 'if (confirm("Customer Has Been Updated") == true) {window.location= "customers.php"}';
        echo '</script>';   
    }
}
//addcustomer
if(isset($_POST['add']))
{
    $database ->update("INSERT INTO customer (name,surname,contact_number,email,sa_id_number,address)
    VALUES('','', '', '', '', '')");
    header("Location: customers.php");
}

?>

