<?php
$host = "localhost";
$user = "root";
$password = "MyPasswordNew";
$database = "idcard_system";

$db = new mysqli($host,$user,$password,$database);
if($db->connect_error){
	exit('connection failed');
}
?>