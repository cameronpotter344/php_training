<?php
ob_start();
session_start();
include('head.php');
require('database.php');
require('varDeclare.php');
$database = new database('localhost','root','','dvd_shop');
?>


<form method="post" class="all_dvds">
    <input type="submit" name="all" value="ALL DVDS">
</form>
<form method="post" class="search">
    <select name="filter">
        <option value="name">Name</option>
        <option value="description">Surname</option>
        <option value="release_date">Contact Number</option>
        <option value="category">Email</option>
    </select>
    <input type="text" name="search">
    <input type="submit" value="search" name="filter_user">
</form> 

 <table class="hover_table">
    <tr>
        <th>Category</th>
        <th>Name</th>
        <th>Description</th>
        <th>Release Date</th>
    </tr>
<?php 
    if(isset($_POST['filter_user']))
    {
        $user_input=$_POST['search'];
        $filter =  $_POST['filter'];
        $search="SELECT * FROM dvd WHERE $filter = '$user_input'";
    }else
    {
        $search="SELECT dvd.id,dvd.title, dvd.description, dvd.release_date,dvd.category_id, category.category_name
        FROM dvd
        INNER JOIN category
        ON dvd.category_id=category.id";
    }

    $database->set_search($search);
    $parameters = $database -> search();
    $array = $database ->fetch($parameters); 
    foreach($array as $row){ ?>
<tr>
<form method="post">
    <td> 
        <select name="category_id">
            <option select="selected" value="<?php echo $row['category_id']?>"><?php echo $row['category_name']?></option>
            <option value="1">Documentry</option>
            <option value="2">Horror</option>
            <option value="3">Animation</option>
            <option value="4">Comedy</option>
            <option value="5">Action</option>
            <option value="6">Adventure</option>
        </select>
    </td>
    <td><input type="text" name="title" value="<?php echo $row['title']; ?>"></td>
    <td><input type="text" name="description" value="<?php echo $row['description']; ?>"></td>
    <td><input type="text" name="release_date" value="<?php echo $row['release_date']; ?>"></td>
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
<?php };  ?>
</table>
<form method="post">
    <input type="submit" name="add" value="Add DVD" class="add_customer">
</form>
<?php 

//delete
if(isset($_POST['delete']))
{
    $database ->update("DELETE FROM dvd WHERE id = '$id'");
    header("Location: dvd.php");
}
//update
if(isset($_POST['update']))
{
    $database ->update("UPDATE dvd SET title='$title',description='$description',release_date='$release_date', category_id='$category_id'
            WHERE id='$id'");
    if ($name ==""||$description==""||$release_date=="")
    {
        echo '<script language="javascript">';
        echo 'alert("Fill in all fields")';
        echo '</script>';}else{header("Location: dvd.php");
    }

}

//addcustomer
if(isset($_POST['add']))
{
    $database ->update("INSERT INTO dvd (title,description,release_date,category_id)
    VALUES('','', '','1')");
    header("Location: dvd.php");
}


?>

