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

	if(isset($_GET['table'])) $table_name = $db->real_escape_string($_GET['table']);
	
	if(isset($_GET['emp_data_id'])) $emp_data_id = $db->real_escape_string($_GET['emp_data_id']);
	
	if(isset($_GET['action'])) $action = $db->real_escape_string($_GET['action']);
?>
<?php require 'includes/header_admin.php';?>
<section class="main">
	<?php require 'includes/msg.php';?>

	<form class="user-permission-form" action="do_action.php" method="post">
		<h3>Need Software Administrator Password</h3>
		<!-- <label>User Name:</label>
		<input type="text" class="form-control" name="user_name" placeholder="User Name" required=""> -->
		<label>Password:</label>
		<input type="password" class="form-control" name="password" placeholder="Password" required="">

		<?php if(isset($table_name)):?>
		<input type="hidden" name="table_name" value="<?= $table_name?>">
		<?php endif;?>
		
		<?php if(isset($emp_data_id)):?>
		<input type="hidden" name="emp_data_id" value="<?= $emp_data_id?>">
		<?php endif;?>

		<?php if(isset($action)):?>
		<input type="hidden" name="action" value="<?= $action?>">
		<?php endif;?>

		<input type="submit" class="btn btn-primary" name="proceed" value="Proceed">
	</form>

</section>
<?php require 'includes/footer_admin.php';?>