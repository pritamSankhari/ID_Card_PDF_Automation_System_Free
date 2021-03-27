<?php
	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';

	if(!isLoggedIn()){
		header('Location:'.BASE_URL."login.php");
    	exit();
	}

	if(!isset($_GET['card_id'])||empty($_GET['card_id'])){
		header('Location:'.BASE_URL."add_card.php");
    	exit();
	}

	$sql = "SELECT * FROM cards WHERE id = ".$_GET['card_id'];
	if($res = $db->query($sql)){
		if($res->num_rows>0){

			$card = $res->fetch_assoc();
		}
		else{
			$_SESSION['msg']['text']='Card does not exist!';
			$_SESSION['msg']['err']=1;
			header('Location:'.BASE_URL."add_card.php");
    		exit();
		}
	}

	if(isset($_GET['card_width'])){
		$width = $_GET['card_width'];
	}
	else $width = "2in";

	if(isset($_GET['card_height'])){
		$height = $_GET['card_height'];
	}
	else $height = "3in";
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/idcard-view.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript">
		let base_url = location.origin + '/idcard_system/'
	</script>
	<style type="text/css">		
		.front-page-img,.back-page-img{
			
			/*height: <?= $height?>;*/
			/*width: <?= $width?>;*/
			vertical-align: middle;
			width: 100%;

		}
		*{
			margin:0;
			padding: 0;
		}

		@media print{

			.card-size-form,nav{
				display: none;
			}
			@page{
				
				position:absolute;
				margin: 0;
				size:<?= $width?> <?= $height?>;
				/*size: 2in calc(3in + 2.67mm);*/
				color:white;
				font-size:8px;

			}	
		}
	</style>
	
</head>
<body onload="window.print()">

	<div class="id-card-view">
		<input type="hidden" id="card_id" name="card_id" value="2">
		<div class="id-card">
			<!-- FRONT PAGE -->
			<div class="front-page">
				<img class="front-page-img" src="<?= $card['front_file']?>">
			</div>	
			<!-- BACK PAGE -->
			<div class="back-page">
				<img class="back-page-img" src="<?=$card['back_file']?>">	
			</div>

		</div>	
	</div>

	<script type="text/javascript">
		$('.id-card').css({'padding':'0'})
		$('*').css({
			'margin':'0'
		})
		// $('.front-page,.back-page').css({'display':'flex'})
		 $('.front-page .front-page-img').css({'height':'100%'})
         $('.back-page .back-page-img').css({'height':'100%'})
	    
	    let card_width = "<?= $width?>";
		let card_height = "<?= $height?>";
		let card_id = <?= $_GET['card_id'] ?>;
		let url;
		url = base_url+'update_card_property.php' + "?card_id="+card_id+"&card_width="+card_width+"&card_height="+card_height;
		console.log(location)
			
		window.addEventListener('afterprint',function(){
			// location.reload(url)
			window.location = url 
			console.log(location)	
		})
		
		
	</script>

</body>
</html>