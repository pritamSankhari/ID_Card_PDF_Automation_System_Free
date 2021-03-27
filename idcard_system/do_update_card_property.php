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
		header('Location:'.BASE_URL."add_card.php");
    	exit();
	}

	$card_id = $db->real_escape_string($_POST['card_id']);
	$width = $db->real_escape_string($_POST['card_width']);
	$height = $db->real_escape_string($_POST['card_height']);

	$sql = "SELECT * FROM cards WHERE id = $card_id ";
	$result = $db->query($sql);
	if($result->num_rows<1){
		// header('Location:'.BASE_URL."add_card.php");
    	exit();	
	}


	

	$sql="UPDATE cards SET width = '$width' , height = '$height' WHERE id = ".$card_id;

	if($db->query($sql)){

		// $sql = "SELECT * FROM cards WHERE id = $card_id ";
		// $result = $db->query($sql);

		// $card = $result->fetch_assoc();

		$_SESSION['msg']['text']='Card Size has been updated !';
		$_SESSION['msg']['err']=0;
		header('Location:'.BASE_URL."layout_editor.php?card_id=".$card_id."&card_width=$width&card_height=$height");
		exit();	
	}

	$_SESSION['msg']['text']='Failed to update card size !';
	$_SESSION['msg']['err']=1;
	header('Location:'.BASE_URL."add_card.php");
	exit();	
	
	

?>