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

	$company_id = $db->real_escape_string($_POST['company_id']);

	$users = getUsersByCompany($db,$company_id);

	echo json_encode($users);

?>