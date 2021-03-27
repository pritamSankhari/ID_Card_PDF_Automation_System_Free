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

	if(isset($_GET['edit']) && !empty($_GET['edit'])){
		header('Location:'.BASE_URL."edit-card-layout.php?card_id=".$_GET['card_id']);
    	exit();
	}

	$sql = "SELECT * FROM cards WHERE id = ".$_GET['card_id']." AND company_id = ".$_SESSION['user']['company_id'];
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
	else $width = $card['width'];

	if(isset($_GET['card_height'])){
		$height = $_GET['card_height'];
	}
	else $height = $card['height'];
?>

<?php require 'includes/header_admin.php';?>
<style type="text/css" id="page-preview">
.front-page-img,.back-page-img{
	
	height: <?= $height?>;
	width: <?= $width?>;

}
</style>

<script type="text/javascript">
	let base_url = location.origin + '/idcard_system/'
</script>

<section class='main'>
	<?php require 'includes/msg.php';?>
	<form class="card-size-form" action="do_update_card_property.php" method="post">

		<input type="hidden" name="card_id" value="<?= $card['id']?>">
		<div class="form-group">
			<label>Card Width</label>
			<input id="card_width" type="text" class="form-control" name="card_width" value="<?= $width ?>">	
		</div>
		<div class="form-group">
			<label>Card Height</label>
			<input id="card_height" type="text" class="form-control" name="card_height" value="<?= $height ?>">	
		</div>
		<div class="form-group">
			<input type="button" class="btn btn-primary btn-preview" name="" value="Preview">
			<input type="submit" class="btn btn-success btn-save" name="save" value="Save">
			<a href="admin.php" class="btn btn-danger">Back To Home</a>
			<!-- <input type="button" class="btn btn-danger btn-back" name="" value=""> -->
		</div>
	</form>

	<div id="preview" class="print">

	<div class="id-card-view" style="top: 100px;">
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
	</div>
</section>
<script type="text/javascript">

	let card_width = "<?= $width?>";
	let card_height = "<?= $height?>";
	let card_id = <?= $_GET['card_id'] ?>;

	$('#card_width').on('input',function(){
		
		$('.front-page-img,.back-page-img').css({
			width: $('#card_width').val()
		})
		card_width = $('#card_width').val()
	})
	$('#card_height').on('input',function(){
		
		$('.front-page-img,.back-page-img').css({
			height: $('#card_height').val()
		})
		card_height = $('#card_height').val()

	})

	$('.btn-preview').on('click',function(){
		
		window.location = base_url+'card-preview.php'+"?card_id="+card_id+"&card_width="+card_width+"&card_height="+card_height
		
	})
	
</script>
<?php require 'includes/footer_admin.php';?>