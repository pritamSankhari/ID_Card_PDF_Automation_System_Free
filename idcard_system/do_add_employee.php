<?php
	ini_set("error_reporting", E_ALL);
	error_reporting(E_ALL);
	
	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';
	require 'includes/file_upload.php';
	require 'includes/functions.php';

	if(!isset($_POST['add'])||empty($_POST['add'])){
		header('Location:'.BASE_URL."admin.php");
    	exit();
	}

	if(!$company = getMyCompany($db)){

		setMsg("No company has been selected !!!",1);
		header('Location:'.BASE_URL."admin.php");
    	exit();	
	}

	$table_name = $company['data_table'];

	$cols_in_string = "$table_name(";
	$cols = array();

	$values_in_string = "VALUES(";
	$values = array();

	
	if(isset($_POST['name'])){
		$name = $db->real_escape_string($_POST['name']);
		$cols[]="name";
		$values[]="'$name'";
	}
	if(isset($_POST['mobile'])){
		$mobile = $db->real_escape_string($_POST['mobile']);
		$cols[]="mobile";
		$values[]=$mobile;
	}
	if(isset($_POST['emc'])){
		$emc = $db->real_escape_string($_POST['emc']);
		$cols[]="emergency";
		$values[]=$emc;
	}
	if(isset($_POST['address'])){
		$address = $db->real_escape_string($_POST['address']);
		$cols[]="address";
		$values[]="'$address'";
	}
	if(isset($_POST['email'])){
		$email = $db->real_escape_string($_POST['email']);
		$cols[]="email";
		$values[]="'$email'";
	}
	if(isset($_FILES['image'])){
		// $image = $db->real_escape_string($_FILES['image']);
		if($filename = uploadEmployeePhoto($_FILES['image'],$table_name)){
			$cols[]="image";
			$values[]="'$filename'";	
		}

		else{
			setMsg("Failed to upload employee photo !",1);
			header('Location:'.BASE_URL."admin.php");
    		exit();
		}
		
	}
	if(isset($_POST['dob'])){
		$dob = $db->real_escape_string($_POST['dob']);
		$cols[]="date_of_birth";
		$values[]="'$dob'";	
	}

	if(isset($_POST['blood_group'])){
		$blood = $db->real_escape_string($_POST['blood_group']);
		$cols[]="blood_group";
		$values[]="'$blood'";	
	}

	if(isset($_POST['emp_id'])){
		$emp_id = $db->real_escape_string($_POST['emp_id']);
		$cols[]="emp_id";
		$values[]=$emp_id;
	}
	if(isset($_POST['dept'])){
		$dept = $db->real_escape_string($_POST['dept']);
		$cols[]="department";
		$values[]="'$dept'";
	}
	if(isset($_POST['desig'])){
		$desig = $db->real_escape_string($_POST['desig']);
		$cols[]="designation";
		$values[]="'$desig'";
	}
	if(isset($_POST['doi'])){
		$doi = $db->real_escape_string($_POST['doi']);
		$cols[]="date_of_issue";
		$values[]="'$doi'";
	}
	if(isset($_POST['doe'])){
		$doe = $db->real_escape_string($_POST['doe']);
		$cols[]="date_of_expiry";
		$values[]="'$doe'";
	}
	if(isset($_FILES['sign'])){
		
		if($filename = uploadEmployeeSignature($_FILES['sign'],$table_name)){
			$cols[]="sign";
			$values[]="'$filename'";	
		}
		else{
			setMsg("Failed to upload employee signature !",1);
			header('Location:'.BASE_URL."admin.php");
    		exit();
		}
		
	}


	$cols_in_string.=implode(",", $cols).")";
	$values_in_string.=implode(",", $values).")";
	$sql = "INSERT INTO $cols_in_string $values_in_string";
	// echo "$sql";
	
	
	if($db->query($sql)){

		$sql = "SELECT * FROM $table_name ORDER BY id DESC LIMIT 1 ";
		$result = $db->query($sql);

		$last_employee = $result->fetch_assoc();

		$sql = "INSERT INTO card_status(emp_data_id,company_id) VALUES(".$last_employee['id'].",".$_SESSION['user']['company_id'].")";
		echo $sql;
		if($db->query($sql)){
			setMsg("Employee added successfully !");
			header('Location:'.BASE_URL."show_all_records.php");
			exit();	
		}
		else echo "oops";

		
	}
	
	// echo "$data_query";
	setMsg("Failed to add Employee !",1);
	// header('Location:'.BASE_URL."admin.php");
	exit();
?>