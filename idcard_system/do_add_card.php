<?php

	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';

	if(!isLoggedIn()){
		header('Location:'.BASE_URL."login.php");
    	exit();
	}

	if(!isset($_POST['company_id'])||empty($_POST['company_id'])){
		header('Location:'.BASE_URL."admin.php");
    	exit();
	}


	$company_id = $db->real_escape_string($_POST['company_id']);
	$card_name = $db->real_escape_string($_POST['card_name']);
	
	$front_file = $_FILES['front_file'];
	$back_file = $_FILES['back_file'];

	if(!$_FILES['front_file']['error']){

		$target_front_file = "card_img/".uniqid()."_".basename($front_file['name']);
		
		
		// pathinfo($filename, PATHINFO_EXTENSION);
		if(!move_uploaded_file($front_file['tmp_name'], $target_front_file)){
			
			$_SESSION['msg']['text']='Failed to upload card front image !';
			$_SESSION['msg']['err']=1;
			header('Location:'.BASE_URL."admin.php");
    		exit();

		}
	}

	if(!$_FILES['back_file']['error']){

		
		$target_back_file = "card_img/".uniqid()."_".basename($back_file['name']);
		
		
		if(!move_uploaded_file($back_file['tmp_name'], $target_back_file)){
			
			$_SESSION['msg']['text']='Failed to upload card back image !';
			$_SESSION['msg']['err']=1;
			header('Location:'.BASE_URL."admin.php");
    		exit();

		}
	}

	$sql = "INSERT INTO cards(company_id,name,front_file,back_file) VALUES($company_id,'$card_name','$target_front_file','$target_back_file')";

	if($db->query($sql)){

		$sql = "SELECT * FROM cards ORDER BY id DESC LIMIT 1 ";
		$result = $db->query($sql);

		$last_card = $result->fetch_assoc();

		if($_POST['orientation']){
			$width = "297px";
			$height = "192px";
		}
		else{
			$width = "192px";
			$height = "297px";	
		}
	
		// $_SESSION['msg']['text']='Card Added Successfully !';
		// $_SESSION['msg']['err']=0;
		header('Location:'.BASE_URL."update_card_property.php?card_id=".$last_card['id']."&card_width=$width&card_height=$height");
		exit();		
	}
	// print_r($_POST);
	// print_r($_FILES);
?>