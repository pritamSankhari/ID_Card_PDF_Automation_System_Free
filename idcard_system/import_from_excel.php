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

?>

<?php require('includes/header_admin.php');?>

<section class="main">
	
	<?php require('includes/msg.php');?>

	<form class="import-from-excel-form" action="do_import_from_excel.php" method="post" enctype="multipart/form-data" style="">
		<h3>Upload Excel File</h3>
		<input type="file" class="form-control" name="myfile">
		<input type="submit" class="btn btn-success" name="import" value="Import">
	</form>
</section>

<?php require('includes/footer_admin.php');?>