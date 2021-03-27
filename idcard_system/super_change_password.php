<?php
	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';
	require 'includes/functions.php';

	if(!isLoggedIn() ||  !isset($_SESSION['user']['role'])){
		header('Location:'.BASE_URL."login.php");
    	exit();
	}

	if($_SESSION['user']['role'] != 'super_admin'){
		header('Location:'.BASE_URL."admin.php");
    	exit();	
	}
?>


<?php require 'includes/header_admin.php';?>
<section class="main">
	
	<?php require 'includes/msg.php';?>

	<form class="change-password-form" action="do_super_change_password.php" method="post">
		<h3>Change Password</h3>
		<input type="hidden" name="user_id" value="<?= $_SESSION['user']['id']?>">

		<label>Old Password:</label>
		<input class="form-control" type="password" name="old_pwd" placeholder="Old Password" required="">
		
		<label>New Password:</label>
		<input class="form-control" type="password" name="new_pwd" placeholder="New Password" required="">
		
		<label>Confirm New Password:</label>
		<input class="form-control"  type="password" name="c_new_pwd" placeholder="Confirm New Password" required="">
		
		<input class="btn btn-success" type="submit" name="change" value="Change">
	</form>
</section>
<?php require 'includes/footer_admin.php';?>