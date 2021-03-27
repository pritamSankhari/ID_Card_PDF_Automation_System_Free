<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';
	require 'includes/functions.php';
	require 'includes/fields.php';
	require 'phpqrcode/qrlib.php';


	if(!isLoggedIn()){
		header('Location:'.BASE_URL."login.php");
    	exit();
	}

	if(!isset($_POST['import'])||empty($_POST['import'])){
		header('Location:'.BASE_URL."admin.php");
    	exit();	
	}

	if(!$table_name = getMyCompanyDataTableName($db)){

		setMsg("No company has been selected !!!",1);
		header('Location:'.BASE_URL."admin.php");
    	exit();	
	}

	if(empty($_FILES['myfile']['name'])){
    	setMsg("No input file has been selected !",1);
    	header('Location:'.BASE_URL."import_from_excel.php");
    	exit();
    }

    // Allowed mime types
    $csvMimes = array(
    	'text/x-comma-separated-values', 
    	'text/comma-separated-values', 
    	'application/octet-stream', 
    	'application/vnd.ms-excel', 
    	'application/x-csv', 
    	'text/x-csv', 
    	'text/csv', 
    	'application/csv', 
    	'application/excel', 
    	'application/vnd.msexcel', 
    	'text/plain' 
    );

     // Validate whether selected file is a CSV file
    if(!in_array($_FILES['myfile']['type'], $csvMimes)){
    	
    	setMsg("Invalid file type !",1);
    	header('Location:'.BASE_URL."import_from_excel.php");
    	exit();
    }

    // GET DATE
    // --------------------
    date_default_timezone_set("Asia/Kolkata");
	$d = getdate();
	$date_string = $d['mday']."_".$d['mon']."_".$d['year']."_".$d['hours']."_".$d['minutes']."_".$d['seconds'];
	// --------------------
	

	// print_r($_FILES);

    // Whether file is uploaded or not
    if(!is_uploaded_file($_FILES['myfile']['tmp_name'])){
    	
    	setMsg("File not uploaded !",1);
    	header('Location:'.BASE_URL."import_from_excel.php");
    	exit();
    }

    // Open uploaded CSV file with read-only mode
    $csvFile = fopen($_FILES['myfile']['tmp_name'], 'r');

    // Get first row
    $cols = fgetcsv($csvFile);
    
    
    $fields_in_excel = array();
    
    for($i=0;$i<count($cols);$i++){
    
    	//Set actual columns or fields name
    	$fields_in_excel[]=getFieldName($cols[$i]);
    }


    
    $employees = array();
    // Get row from csv file
    while($row = fgetcsv($csvFile)){

    	$data = array();

    	// for each coloumn in the row
    	for($i=0;$i<count($row);$i++){

    		// Set data correspong to its field
    		
    		if( $row[$i] != '')
    			$data[ $fields_in_excel[$i] ] = $db->real_escape_string( $row[ $i ] ); 
    		
    		else $data[ $fields_in_excel[$i] ] = '-';
    	}

    	// Add empolyee
    	$employees[]=$data;
    }

    //*********************
    // TAKING BACKUP
    //*********************
    move_uploaded_file($_FILES['myfile']['tmp_name'], __DIR__."/excel_data/".$date_string."_".$_FILES['myfile']['name']);


    $fields_in_table = getDataTableFieldList($db,$table_name);

	// fields_in_table is not an array 
    if(!is_array($fields_in_table)){
		
		setMsg("Failed to get Table Fields !!!",1);
		header('Location:'.BASE_URL."show_all_records.php");
    	exit();			
	}

	$employees_to_store = array();
	$data = array();

	foreach($employees as $employee){

		foreach($fields_in_table as $field){

			if(!isset($employee[$field])) continue;

			// SPECIAL CASE FOR IMAGE
			if($field == FIELD_IMAGE){

				$data[$field] = "'emp_img/".$employee[$field]."'";
				continue;
			}

			// SPECIAL CASE FOR SIGNATURE
			if($field == FIELD_SIGN){

				$data[$field] = "'emp_sign/".$employee[$field]."'";
				continue;
			}

			$data[$field] = "'".$employee[$field]."'";
		}
		
		$employees_to_store[] = $data;		
		// print_r($employee);
	}

	$employees = $employees_to_store;

	

	foreach($employees as $employee){
		

		if(!insertEmployeeData($db,$table_name,$employee)){

			// Failed to insert employee
			// print_r($employee);
			setMsg("Failed to Insert Employee Data !!!",1);
			header('Location:'.BASE_URL."show_all_records.php");
	    	exit();		
		}

		$last_employee = getLastEmployeeData($db,$table_name);

		if(!insertCardStatus($db,array('emp_data_id'=>$last_employee['id'],'company_id'=>$_SESSION['user']['company_id']))){
			
			setMsg("Failed to Add Card Status !!!",1);
			header('Location:'.BASE_URL."show_all_records.php");	
		}
		
		if(!in_array('qr', array_values($fields_in_table))){
			
			continue;
		} 

		// UPDATE QR CODE
		// --------------
		
		$qr = generateQRCode($table_name,$employee,$last_employee['id']);


		if(!updateEmployeeQRCode($db,$table_name,$qr,$last_employee['id'])){

			// Failed to update employee QR code
			setMsg("Failed to Update Employee QR Code !!!",1);
			header('Location:'.BASE_URL."show_all_records.php");
	    	exit();		
		}

		if(!updateCardStatus($db,$data = array('qr_generated'=>1),$last_employee['id'])){
			// Failed to update QR code status
			setMsg("Failed to Update QR Code Status !!!",1);
			header('Location:'.BASE_URL."show_all_records.php");
	    	exit();			
		}
		// --------------
	}

	setMsg("Imported Successfully !");
	header('Location:'.BASE_URL."show_all_records.php");
	exit();	

   
?>