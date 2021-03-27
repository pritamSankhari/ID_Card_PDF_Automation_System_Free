<?php
	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';
	require 'includes/file_upload.php';
	require 'includes/functions.php';

	if(!isset($_POST['save'])||empty($_POST['save'])){
		header('Location:'.BASE_URL."admin.php");
    	exit();
	}

	if(!$table_name = getMyCompanyDataTableName($db)){

		setMsg("No company has been selected !!!",1);
		header('Location:'.BASE_URL."admin.php");
    	exit();	
	}


	$fields = getDataTableFieldList($db,$table_name);

	if(!is_array($fields)){
		
		setMsg("Failed to get Table Fields !!!",1);
		header('Location:'.BASE_URL."show_all_records.php");
    	exit();			
	}


	$statements = array();

	if(isset($_FILES['image']) && !$_FILES['image']['error']){
		
		if($filename = uploadEmployeePhoto($_FILES['image'],$table_name)){
			$statements[] = "image = '".$filename."'"	;		
		}

		else{
			setMsg("Failed to upload employee photo !",1);
			header('Location:'.BASE_URL."admin.php");
    		exit();
		}
		
	}

	if(isset($_FILES['sign']) && !$_FILES['sign']['error']){
		
		if($filename = uploadEmployeeSignature($_FILES['sign'],$table_name)){
			
			$statements[] = "sign = '".$filename."'";
		}
		else{
			setMsg("Failed to upload employee signature !",1);
			header('Location:'.BASE_URL."admin.php");
    		exit();
		}
		
	}


	// Generating query
	foreach($fields as $field){
		if(!isset($_POST[$field])) continue;

		if($_POST[$field] !="" )
			$statements[] = $field." = '".$db->real_escape_string($_POST[$field])."'";

		else $statements[] = $field." = NULL";
	}

	$sql = "UPDATE $table_name SET ".implode(",", $statements)." WHERE id = ".$db->real_escape_string($_POST['emp_data_id']);

	
	if($db->query($sql)){
		setMsg("Data Updated Successfully !");
		header('Location:'.BASE_URL."show_all_records.php");
		exit();
	}

	setMsg("Failed to update !",1);
	header('Location:'.BASE_URL."show_all_records.php");
	exit();

?>