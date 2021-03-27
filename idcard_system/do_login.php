<?php
	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';

	if(!isset($_POST['login'])||empty($_POST['login'])){
		header('Location:'.BASE_URL."admin.php");
    	exit();
	}

	$user_name = $db->real_escape_string($_POST['user_name']);
	$password = md5($db->real_escape_string($_POST['password']));
	$company_id = $db->real_escape_string($_POST['company_id']);

	echo md5($_POST['password']);

	if($result = $db->query("SELECT * FROM users WHERE name = '$user_name' AND password = '$password' AND company_id = $company_id")){
		
		// IF USER EXISTS
		if($result->num_rows>0){

			$row = $result->fetch_assoc();

			if($result = $db->query("SELECT * FROM company WHERE id=".$row['company_id'])){
				// IF COMPANY EXISTS
				if($result->num_rows>0){

					$company = $result->fetch_assoc();
					$_SESSION['user']['company_name']=$company['name'];
				}
				else{
					$_SESSION['msg']['text']="Company does not exist!";
					$_SESSION['msg']['err']=1;
					header('Location:'.BASE_URL."login.php");
		    		exit();	
				}
			}
			else{
				$_SESSION['msg']['text']="Query Error!";
				$_SESSION['msg']['err']=1;
				header('Location:'.BASE_URL."login.php");
	    		exit();	
			}


			// LOGGED IN SEUCCESSFULLY
			$_SESSION['user']['id']=$row['id'];
			$_SESSION['user']['company_id']=$row['company_id'];
			$_SESSION['user']['name']=$row['name'];
			$_SESSION['user']['role']=$row['role'];
			
			$_SESSION['msg']['text']="Logged in Successfully!";
			$_SESSION['msg']['err']=0;
			header('Location:'.BASE_URL."admin.php");
    		exit();
		}
		else{
			$_SESSION['msg']['text']="Failed to login! Type Username , password or company correctly!";
			$_SESSION['msg']['err']=1;
			header('Location:'.BASE_URL."login.php");
    		exit();
		}
	}
	$_SESSION['msg']['text']="Failed to login!";
	$_SESSION['msg']['err']=1;
	header('Location:'.BASE_URL."login.php");
	exit();
?>