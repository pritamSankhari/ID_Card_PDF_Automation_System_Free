<?php
	
	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';

	if(!isLoggedIn()){
		header('Location:'.BASE_URL."login.php");
    	exit();
	}

	if(!isset($_POST['card_id'])||empty($_POST['card_id'])){
		header('Location:'.BASE_URL."admin.php");
		echo "false";
    	exit();
	}

	$card_id = $db->real_escape_string($_POST['card_id']);
	$data_table = $db->real_escape_string($_POST['data_table']);

	$show_field_label = (int)$_POST['show_field_label'];

	$sql="UPDATE cards SET fields_styles = '".json_encode($_POST['data'])."' , data_table = '$data_table',show_field_label = $show_field_label WHERE id = ".$card_id;


	if($db->query($sql)){

		$_SESSION['msg']['text']='Card Fields have been updated !';
		$_SESSION['msg']['err']=0;
		
		echo "true";	
	}
	else{
		$_SESSION['msg']['text']='Failed to update card fields !';
		$_SESSION['msg']['err']=1;
		echo "false";	
	} 


	// echo "<pre>";
	// print_r(json_decode(json_encode($_POST),true));
	// echo json_encode($_POST['data']);
	// echo $_POST['data_table'];
	// echo json_encode($_POST['card_id']);
	// echo "</pre>";
?>