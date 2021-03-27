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

    // Whether file is uploaded or not
    if(!is_uploaded_file($_FILES['myfile']['tmp_name'])){
    	
    	setMsg("File not uploaded !",1);
    	header('Location:'.BASE_URL."import_from_excel.php");
    	exit();
    }

    // Open uploaded CSV file with read-only mode
    $csvFile = fopen($_FILES['myfile']['tmp_name'], 'r');

    $cols = fgetcsv($csvFile);
    
    // Get first row
    $fields = array();
    
    for($i=0;$i<count($cols);$i++){
    
    	//Set actual columns or fields name
    	$fields[]=getFieldName($cols[$i]);
    }


    echo "<pre>";

    print_r($fields);
    
    $employees = array();
    // Get row from csv file
    while($line = fgetcsv($csvFile)){

    	$data = array();
    	for($i=0;$i<count($line);$i++){

    		// Set data correspong to its field
    		$data[ $fields[$i] ] = $line[ $i ]; 
    	}

    	// Add empolyee
    	$employees[]=$data;
    }

    print_r($employees);

    /*
    

    foreach($employees as $employee){

		$cols_in_string = "$table_name(";
		$cols = array();

		$values_in_string = "VALUES(";
		$values = array();

	    if(isset($employee['name'])){
			$name = $db->real_escape_string($employee['name']);
			$cols[]="name";
			$values[]="'$name'";
		}
		if(isset($employee['mobile'])){
			$mobile = $db->real_escape_string($employee['mobile']);
			$cols[]="mobile";
			$values[]=$mobile;
		}
		if(isset($employee['emergency'])){
			$emc = $db->real_escape_string($employee['emergency']);
			$cols[]="emergency";
			$values[]=$emc;
		}
		if(isset($employee['address'])){
			$address = $db->real_escape_string($employee['address']);
			$cols[]="address";
			$values[]="'$address'";
		}
		if(isset($employee['email'])){
			$email = $db->real_escape_string($employee['email']);
			$cols[]="email";
			$values[]="'$email'";
		}
		if(isset($employee['image'])){
			$filename = $db->real_escape_string($employee['image']);
			$cols[]="image";
			// $values[]="'emp_img/$table_name"."_$filename'";	
			$values[]="'emp_img/$filename'";	
		
			
		}
		if(isset($employee['date_of_birth'])){
			$dob = $db->real_escape_string($employee['date_of_birth']);
			$cols[]="date_of_birth";
			$values[]="'$dob'";	
		}

		if(isset($employee['blood_group'])){
			$blood = $db->real_escape_string($employee['blood_group']);
			$cols[]="blood_group";
			$values[]="'$blood'";	
		}

		if(isset($employee['emp_id'])){
			$emp_id = $db->real_escape_string($employee['emp_id']);
			$cols[]="emp_id";
			$values[]=$emp_id;
		}
		if(isset($employee['department'])){
			$dept = $db->real_escape_string($employee['department']);
			$cols[]="department";
			$values[]="'$dept'";
		}
		if(isset($employee['designation'])){
			$desig = $db->real_escape_string($employee['designation']);
			$cols[]="designation";
			$values[]="'$desig'";
		}
		if(isset($employee['date_of_issue'])){
			$doi = $db->real_escape_string($employee['date_of_issue']);
			$cols[]="date_of_issue";
			$values[]="'$doi'";
		}
		if(isset($employee['date_of_expiry'])){
			$doe = $db->real_escape_string($employee['date_of_expiry']);
			$cols[]="date_of_expiry";
			$values[]="'$doe'";
		}
		if(isset($employee['sign'])){
			
			$filename = $db->real_escape_string($employee['sign']);
			$cols[]="sign";
			// $values[]="'emp_sign/$table_name"."_$filename'";	
			$values[]="'emp_sign/$filename'";	
			
		}


		$cols_in_string.=implode(",", $cols).")";
		$values_in_string.=implode(",", $values).")";
		$sql = "INSERT INTO $cols_in_string $values_in_string";
		
		// echo "$sql<br>";
		
		
		if($db->query($sql)){

			$sql = "SELECT * FROM $table_name ORDER BY id DESC LIMIT 1 ";
			$result = $db->query($sql);

			$last_employee = $result->fetch_assoc();

			$sql = "INSERT INTO card_status(emp_data_id,company_id) VALUES(".$last_employee['id'].",".$_SESSION['user']['company_id'].")";
			echo $sql;
			if($db->query($sql)){
				setMsg("Imported successfully !");	
			}
			else{
				setMsg("Failed to add card status !",1);
				header('Location:'.BASE_URL."show_all_records.php");
				exit();
			}			
		}
		else{
			setMsg("Failed to import !",1);
		}
			
    }

    
	header('Location:'.BASE_URL."show_all_records.php");
	exit();	
	
	*/	

?>