<?php
	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';

	if(!isLoggedIn()){
		header('Location:'.BASE_URL."login.php");
    	exit();
	}

	if($result = $db->query("SELECT * FROM company WHERE id = ".$_SESSION['user']['company_id'])){
		if($result->num_rows>0){
			$company = $result->fetch_assoc();
		}
		else{
			echo "<h2>ACCESS DENIED !</h2>";
			exit();		
		}
	}

	$sql = "SELECT * FROM cards WHERE company_id = ".$_SESSION['user']['company_id'];
	$cards=array();
	if($result=$db->query($sql)){
		if($result->num_rows>0){
			while($row = $result->fetch_assoc()){
				$cards[] = $row;
			}
		}
		else $cards = 0;
	}
	else $cards = 0;
?>
<?php require 'includes/header_admin.php';?>
<section class='main'>
	<?php require 'includes/msg.php';?>
	<form class="select-card-form" action="update_card_property.php" method="get">
		<h3>Select Card</h3>
		
		<?php if($cards):?>
		<div class="form-group">
			<select name="card_id" class="form-control">
		
			<?php foreach($cards as $card):?>
				<option value="<?= $card['id']?>">
					<?= $card['name']?>
				</option>
			<?php endforeach;?>
			</select>
		</div>
		<input type="submit" class="btn btn-primary" name="confirm" value="Confirm Card Size">
		<input type="submit" class="btn btn-success" name="edit" value="Edit Card">
		<?php else:?>
			<h5>No Cards added yet !</h5>
		<?php endif;?>
	</form>
	<h3 class="or">OR</h3>
	<form action="do_add_card.php" class="add-card-form" enctype="multipart/form-data" method="post">
		<h3>Add New Card</h3>
		<div class="form-group">
			<label>Company Name:</label>
			<input type="text" class="form-control" name="company_name" value="<?= $company['name']?>" readonly>
			<input type="hidden" class="form-control" name="company_id" value="<?= $_SESSION['user']['company_id']?>" readonly>
		</div>
		<div class="form-group">
			<label>Card Name:</label>
			<input type="text" class="form-control" name="card_name">
		</div>

		<div class="form-group">
			<label>Card Front Image:</label>
			<input type="file" class="form-control" name="front_file" required="">
		</div>
		<div class="form-group">
			<label>Card Back Image:</label>
			<input type="file" class="form-control" name="back_file">
		</div>
		<div class="form-group">
			<label>Card Orientation:</label>
			<select name="orientation" class="form-control">
				<option value="0">
					Potrait
				</option>
				<option value="1">
					Landscape
				</option>
			</select>
		</div>
		<input type="submit" class="btn btn-success" name="add" value="Add">
	</form>
	
</section>
<?php require 'includes/footer_admin.php';?>