<?php
	session_start();
	require 'includes/user_auth.php';
	require 'config/url.php';
	
	if(isLoggedIn()){
		unset($_SESSION['user']);
		$_SESSION['msg']['text']="Logged out succesfully!";
		$_SESSION['msg']['err']=0;
		header('Location:'.BASE_URL."login.php");
		exit();	
	}
	
	header('Location:'.BASE_URL."login.php");
	exit();	

?>