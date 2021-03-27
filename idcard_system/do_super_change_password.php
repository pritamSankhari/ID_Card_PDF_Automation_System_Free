<?php
	
	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';
	require 'includes/functions.php';

	if(!isLoggedIn() ||  !isset($_SESSION['user']['role'])){
		header('Location:'.BASE_URL."login.php");
    	exit();
	}

	if($_SESSION['user']['role'] != 'super_admin'){
		header('Location:'.BASE_URL."admin.php");
    	exit();	
	}

	if(!isset($_POST['change']) || empty($_POST['change'])){
		header('Location:'.BASE_URL."admin.php");
    	exit();		
	}

	$old_pwd = $db->real_escape_string($_POST['old_pwd']);
	$new_pwd = $db->real_escape_string($_POST['new_pwd']);
	$c_new_pwd = $db->real_escape_string($_POST['c_new_pwd']);
	
	if(md5($old_pwd) != getSuperAdminPassword($db)){

		setMsg("Please enter current password correctly",1);
		header('Location:'.BASE_URL."super_change_password.php");
    	exit();
	}
	
	if($new_pwd != $c_new_pwd){
		setMsg("Please confirm new password correctly",1);
		header('Location:'.BASE_URL."super_change_password.php");
    	exit();	
	}

	if(updateSuperAdminPassword($db,$new_pwd)){
		unset($_SESSION['user']);
		setMsg("Password has been changed!");
		header('Location:'.BASE_URL."admin.php");
    	exit();		
	}
?>