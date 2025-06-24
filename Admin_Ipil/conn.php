<?php 
	$name = "localhost";
	$username = "root";
	$password = "";
	$dbname = "bis";

	$conn = mysqli_connect($name, $username, $password, $dbname);
	if(!$conn){
    	die("Connection Failed!: " .mysqli_connect_error());
}
?>