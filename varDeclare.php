<?php
$name = $surname = $email =$address = $sa_id_number=$contact_number="";
$nameErr=$surnameErr=$emailErr=$addressErr=$sa_id_numberErr=$contact_numberErr="";

/*
if($_SERVER["REQUEST_METHOD"]=="POST"){
  if(empty($_POST["name"])){
  }else{
    $name=test_input($_POST["name"]);
  }
  if(empty($_POST["surname"])){
  }else{
    $surname =test_input($_POST["surname"]);
  }
  if(empty($_POST["email"])){
  }else{
    $email=test_input($_POST["email"]);
  }
  if(empty($_POST["address"])){
  }else{
    $address=test_input($_POST["address"]);
  }
  if(empty($_POST["sa_id_number"])){
  }else{
    $sa_id_number=test_input($_POST["sa_id_number"]);
  }
  if(empty($_POST["contact_number"])){
  }else{
    $contact_number=test_input($_POST["contact_number"]);
  }
}
function test_input($data){
  $data=trim($data);
  $data=stripcslashes($data);
  $data=htmlspecialchars($data);
  return $data;}
  */
if(isset($_POST['id'])){ $id = $_POST['id']; }
if(isset($_POST['name'])){ $name = $_POST['name']; } 
if(isset($_POST['title'])){ $title = $_POST['title']; } 
if(isset($_POST['surname'])){ $surname = $_POST['surname']; } 
if(isset($_POST['email'])){ $email = $_POST['email']; }
if(isset($_POST['address'])){ $address = $_POST['address']; } 
if(isset($_POST['sa_id_number'])){ $sa_id_number = $_POST['sa_id_number']; } 
if(isset($_POST['contact_number'])){ $contact_number = $_POST['contact_number']; }
if(isset($_POST['description'])){ $description = $_POST['description']; } 
if(isset($_POST['release_date'])){ $release_date = $_POST['release_date']; } 
if(isset($_POST['category_name'])){ $category_name = $_POST['category_name']; }
if(isset($_POST['category_id'])){ $category_id = $_POST['category_id']; }
if(isset($_POST['dvd_id'])){ $dvd_id = $_POST['dvd_id']; }

?>