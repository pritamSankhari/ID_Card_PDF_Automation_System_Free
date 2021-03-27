<?php

	print_r($_POST);
	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';
	require 'includes/file_upload.php';
	require 'includes/functions.php';

	if(!isset($_POST['delete'])||empty($_POST['delete'])){
		header('Location:'.BASE_URL."admin.php");
    	exit();
	}

	$table = $db->real_escape_string($_POST['table_name']);

	$emp_id = $db->real_escape_string($_POST['emp_data_id']);

	$company_id = $db->real_escape_string($_POST['company_id']);

	
	if(deleteEmployeeData($db,$table,$emp_id)){

		if(deleteEmployeeCardStatus($db,$emp_id)){

			setMsg("Record Deleted Successfully!");
			header('Location:'.BASE_URL."show_all_records.php");
    		exit();

		}

		setMsg("Failed to delete card status !",1);
		header('Location:'.BASE_URL."show_all_records.php");
    	exit();
	}

	setMsg("Failed to delete record !",1);
	header('Location:'.BASE_URL."show_all_records.php");
	exit();

?>