<?php
	

	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';
	require 'includes/functions.php';


	if(!isset($_POST['c_auth']) || empty($_POST['c_auth'])){
		echo "<h3>ACCESS DENIED</h3>";
		exit();
	}

	if($_POST['c_auth'] != "45602" || $_POST['c_auth'] != 45602){
		echo "<h3>ACCESS DENIED</h3>";
		exit();	
	}

	if($result = $db->query("SELECT * FROM company")){
		if($result->num_rows>0){
			$companies = array();
			while($row = $result->fetch_assoc()){
				$companies[]=$row;
			}
		}
		else{
			echo "false";
			exit();		
		}
	}

	echo json_encode($companies);
	// echo "Hello";
?>