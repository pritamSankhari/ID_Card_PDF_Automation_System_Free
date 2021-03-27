<?php
	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';

	header('Location:'.BASE_URL."admin.php");
	exit();
?>