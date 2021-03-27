<?php

	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';
	require 'includes/functions.php';
	require 'includes/fields.php';

	if(!isLoggedIn()){
		header('Location:'.BASE_URL."login.php");
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

	if(!isset($fields['qr'])){
		setMsg("You Can't generate QR codes !!!",1);
		header('Location:'.BASE_URL."show_all_records.php");
    	exit();			
	}

	$employees = getEmployeeData($db,$table_name);

	if(!is_array($employees)){
		setMsg("Failed to get Employee data !!!",1);
		header('Location:'.BASE_URL."show_all_records.php");
    	exit();				
	}

	if(empty($employees)){
		setMsg("No Employees !!!",1);
		header('Location:'.BASE_URL."show_all_records.php");
    	exit();			
	}

	require 'phpqrcode/qrlib.php';

	echo "<pre>";
	$keys = array_keys($fields);
	// print_r($keys);
	foreach($employees as $employee){

		$values=array();
		for($i=1;$i<count($keys);$i++){

			if($keys[$i] == FIELD_QR || $keys[$i] == FIELD_IMAGE || $keys[$i] == FIELD_SIGN || $keys[$i] == FIELD_DATE_OF_EXPIRY || $keys[$i] == FIELD_DATE_OF_BIRTH || $keys[$i] == FIELD_DEPARTMENT || $keys[$i] == FIELD_DESIGNATION) continue;
			$values[] = getFieldLabel($keys[$i])." : ".$employee[$keys[$i]];
		}

		$qrdata = implode("\n", $values);

		$filename = "qrcodes/$table_name"."_emp_".$employee['id'].".png";
		QRcode::png($qrdata,$filename);

		if(updateEmployeeQRCode($db,$table_name,$filename,$employee['id'])){

			if(updateCardStatus($db,array('qr_generated'=>1),$employee['id'])){
			
				setMsg("QR Codes have been generated !!!");
			}
		}
		
		// else{
		// 	setMsg("Failed to generate QR code !!!",1);
		// 	header('Location:'.BASE_URL."show_all_records.php");
	 //    	exit();			
  //   	}

	}

	header('Location:'.BASE_URL."show_all_records.php");
	exit();		

?>