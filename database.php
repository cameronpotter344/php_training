<?php

class database
{	
	public $filter = "SELECT * FROM customer";
	private $connect;
	private $data;
	function __construct($server, $username, $password, $db)
	{
		#global $connect;
		#$this->fetch("select * from customer");
		$this->connect = new mysqli($server, $username, $password,$db);
		if ($this->connect->connect_error)
			{
				die("Connection failed: ".$this->connect->connect_error);
			}else
			{
				 "connected sucessfully";
			}

	}
	function fetch($query)
	{
		#global $connect;
		$data = array();
		$run = mysqli_query($this->connect, $query);
		while($row = mysqli_fetch_array($run)){
			$data[]=$row;
		}
		return $data;
	}
	function fetch_one($query)
	{
		#global $connect;
		$run = mysqli_query($this->connect, $query);
		$data = mysqli_fetch_array($run);
		return $data;
	}
	function update($query)
	{
		#global $connect;
		mysqli_query($this->connect, $query);

	}

	function close_connection(){
		$this->connect->close_connection();
	}
	function search(){
		return $this->filter;
	}
	function set_search($update_search){
		$this->filter = $update_search;
	}

}
?>

