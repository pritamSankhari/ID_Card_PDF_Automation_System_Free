<?php

	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';
	require 'includes/file_upload.php';
	require 'includes/functions.php';

	if(!isset($_POST['deleteall'])||empty($_POST['deleteall'])){
		header('Location:'.BASE_URL."admin.php");
    	exit();
	}

	$table = $db->real_escape_string($_POST['table_name']);

	// $emp_id = $db->real_escape_string($_POST['emp_data_id']);


	
	
	if(deleteAllEmployeeData($db,$table)){


		if(deleteAllEmployeeCardStatus($db)){

			setMsg("All Record(s) Have Been Deleted Successfully!");
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