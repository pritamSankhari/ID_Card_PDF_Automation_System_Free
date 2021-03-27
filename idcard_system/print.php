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

	if(!isset($_GET['table'])||empty($_GET['table'])||!isset($_GET['emp_data_id'])){
		
		setMsg("Table is not selected !",1);
		header('Location:'.BASE_URL."admin.php");
    	exit();
	}

	// print_r($_GET);

	if(!$cards = getAllCards($db)){
		if(!is_array($cards)){
			setMsg("Failed to get cards !",1);
			header('Location:'.BASE_URL."admin.php");
	    	exit();	
		}
		
	}

?>
<?php require 'includes/header_admin.php';?>
<section class="main">
	<form class="select-card-form" action="do_print.php" method="post">
		<h3>Select Card Layout</h3>

		<?php if(!empty($cards)):?>
		<select class="form-control" name="card_id">
		
			<?php foreach($cards as $card):?>
		
				<option value="<?= $card['id']?>"><?= $card['name']?></option>
			<?php endforeach;?>	
		
		</select>

		<input type="hidden" name="table" value="<?= $_GET['table']?>">
		<input type="hidden" name="emp_data_id" value="<?= $_GET['emp_data_id']?>">
		<input type="submit" class="btn btn-primary form-control" name="print" value="Print">

		<?php else:?>
			<a class="btn btn-primary form-control" href="permission.php?action=add_card">Add Card</a>
		<?php endif;?>
		
		
	</form>
</section>
<?php require 'includes/footer_admin.php';?>