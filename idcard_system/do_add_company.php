<?php
	
	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';
	

	if(!isset($_POST['company_name'])||empty($_POST['company_name'])){
		header('Location:'.BASE_URL."admin.php");
    	exit();
	}

	// print_r($_POST);
	$table_name = 'data_'.$db->real_escape_string($_POST['table_name']);
	$company_name = $db->real_escape_string($_POST['company_name']);

	// IF TABLE ALREADY EXISTS
	$sql = "SHOW TABLIES IN idcard_system LIKE '".$table_name."'";

	if($result = $db->query($sql)){

		if($result->num_rows>0){
			
			$_SESSION['msg']['text']='Table "'.$table_name.'"" already exists!';
			$_SESSION['msg']['err']=0;
			header('Location:'.BASE_URL."admin.php");
    		exit();
		}
	}

	$fields = "`id` bigint AUTO_INCREMENT NOT NULL PRIMARY KEY";

	if(isset($_POST['req_name'])){
		$fields.= ",`name` varchar(80)";
	}
	if(isset($_POST['req_mobile'])){
		$fields.=",`mobile` varchar(20)";
	}
	if(isset($_POST['req_emc'])){
		$fields .= ",`emergency` varchar(20)";
	}
	if(isset($_POST['req_address'])){
		$fields .= ",`address` varchar(200)";
	}
	if(isset($_POST['req_email'])){
		$fields .= ",`email` varchar(100)";
	}
	if(isset($_POST['req_image'])){
		$fields .= ",`image` varchar(400)";
	}
	if(isset($_POST['req_dob'])){
		$fields .= ",`date_of_birth` varchar(20)";
	}
	if(isset($_POST['req_blood'])){
		$fields .= ",`blood_group` varchar(20)";
	}
	if(isset($_POST['req_emp_id'])){
		$fields .= ",`emp_id` bigint";
	}
	if(isset($_POST['req_dept'])){
		$fields .= ",`department` varchar(100)";
	}
	if(isset($_POST['req_desig'])){
		$fields .= ",`designation` varchar(100)";
	}
	if(isset($_POST['req_doi'])){
		$fields .= ",`date_of_issue` varchar(20)";
	}
	if(isset($_POST['req_doe'])){
		$fields .= ",`date_of_expiry` varchar(100)";
	}
	if(isset($_POST['req_qr'])){
		$fields .= ",`qr` varchar(200)";
	}
	if(isset($_POST['req_sign'])){
		$fields .= ",`sign` varchar(100)";
	}

	// echo $fields;

	$sql = "INSERT INTO company(name,data_table) VALUES('$company_name','$table_name')";
	
	if($db->query($sql)){
		$sql = "CREATE TABLE IF NOT EXISTS `$table_name`($fields)";	
		
		if($db->query($sql)){

			$_SESSION['msg']['text']='Comapny Added!';
			$_SESSION['msg']['err']=0;
			header('Location:'.BASE_URL."admin.php");
    		exit();
		}
	
		$_SESSION['msg']['text']='Table not created!';
		$_SESSION['msg']['err']=1;
		header('Location:'.BASE_URL."admin.php");
		exit();
	}

	$_SESSION['msg']['text']='Failed to add company!';
	$_SESSION['msg']['err']=1;
	header('Location:'.BASE_URL."admin.php");
	exit();

?>