<?php

	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';
	require 'includes/functions.php';

	if(!isLoggedIn()){
		header('Location:'.BASE_URL."login.php");
    	exit();
	}

	if(!isset($_POST) || empty($_POST)){

		header('Location:'.BASE_URL."admin.php");
    	exit();	
	}

	if(isset($_POST['company_id'])) $company_id = $db->real_escape_string($_POST['company_id']);
	if(isset($_POST['user_id'])) $user_id = $db->real_escape_string($_POST['user_id']);
	if(isset($_POST['user_name'])) $user_name = $db->real_escape_string($_POST['user_name']);
	if(isset($_POST['new_pwd'])) $new_pwd = $db->real_escape_string($_POST['new_pwd']);
	if(isset($_POST['c_new_pwd'])) $c_new_pwd = $db->real_escape_string($_POST['c_new_pwd']);
	

	if($new_pwd != $c_new_pwd){
		setMsg("Please confirm password !",1);
		header('Location:'.BASE_URL."admin.php");
    	exit();
	}

	if(updateUser($db,$user_id,$company_id,$user_name,$new_pwd)){
		setMsg("User updated !");
		header('Location:'.BASE_URL."admin.php");
    	exit();
	}

	setMsg("Fail to update !",1);
	header('Location:'.BASE_URL."admin.php");
	exit();
?>