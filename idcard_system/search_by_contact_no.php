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

	$mobile = $db->real_escape_string($_POST['mobile']);

	$company = getMyCompany($db);

	// echo "true";
	// print_r($company);
	$employees = 0;

	$sql = "SELECT * FROM ".$company['data_table']." WHERE mobile LIKE '%$mobile%'";
	if($res = $db->query($sql)){
		
		if($res->num_rows>0){
			
			$employees = array();
			
			while($row = $res->fetch_assoc()){

				$employees[] = $row;
			}	
		}	
	}
	// echo "$sql";
	// print_r($employees);
	echo json_encode($employees);

?>