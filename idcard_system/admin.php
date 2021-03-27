<?php
	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';

	if(!isLoggedIn()){
		header('Location:'.BASE_URL."login.php");
    	exit();
	}
?>
<?php require 'includes/header_admin.php';?>
	<section class='main'>
		
		<?php require 'includes/msg.php';?>
		
		<div>
			<?php if(isset($_SESSION['msg'])):?>
				<?= $_SESSION['msg']['text']?>
			<?php endif;?>
		</div>
		<div class="secondary-nav">
			<a href="show_all_records.php" class="btn btn-success">Manage Records</a>
			<a href="permission.php?action=add_card" class="btn btn-primary"><span><i class="material-icons" style="font-size: 20px;color:white;margin: 0;position:relative;top:50%;transform:translateY(-50%);">add</i> Add new card layout</span></a>
		</div>
	</section>
<?php require 'includes/footer_admin.php';?>




