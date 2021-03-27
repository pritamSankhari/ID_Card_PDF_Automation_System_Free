<?php
	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';
	

	if(!isset($_POST['company_id'])||empty($_POST['company_id'])){
		header('Location:'.BASE_URL."admin.php");
    	exit();
	}

	if($_POST['password']!=$_POST['cpassword']){

		$_SESSION['msg']['text']="Please confirm password correclty";
		$_SESSION['msg']['err']=1;

		header('Location:'.BASE_URL."admin.php");
    	exit();
	}

	$company_id = $db->real_escape_string($_POST['company_id']);
	$name = $db->real_escape_string($_POST['name']);
	$contact = $db->real_escape_string($_POST['contact']);
	$password = md5($db->real_escape_string($_POST['password']));
	$role = $db->real_escape_string($_POST['role']);

	$sql = "INSERT INTO users(name,role,password,contact,created_by,company_id) VALUES('$name','$role','$password','$contact','".$_SESSION['user']['id']."','$company_id')";

	if($result = $db->query($sql)){

		$_SESSION['msg']['text']="User Added!";
		$_SESSION['msg']['err']=0;

		header('Location:'.BASE_URL."admin.php");
    	exit();

	}
	$_SESSION['msg']['text']="Failed to add user !";
	$_SESSION['msg']['err']=1;

	header('Location:'.BASE_URL."admin.php");
	exit();

?>