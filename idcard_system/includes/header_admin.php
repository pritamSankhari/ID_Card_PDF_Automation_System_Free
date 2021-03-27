<!-- HEADER -->
<!DOCTYPE html>
<html>
<head>
	<title></title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/idcard-view.css">
	<link rel="stylesheet" type="text/css" href="css/idcard-grid.css">


	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<!-- BOOTSTRAP -->
	<!-- Latest compiled and minified CSS -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

	
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>

	<style type="text/css">
		
		.btn-nav-menu{
			cursor: pointer;
			font-size: 45px;

		}
		.btn-nav-menu:hover{
			color:darkgreen;
		}
		.btn-nav-menu-on{
			transition: 1s;

		}
		.btn-nav-menu-off{
			display: none;
			transition: 1s;
		}
		nav{
			position: absolute;
			width: 100%;

		}
		.system-navbar{
			padding: 10px;
			
			width: 100%;
			
		}

		.sliding-bar{
			position: absolute;
			left: -250px;
			z-index: 10;
		}
		.sliding-bar .list-group a:hover{
			text-decoration: none;
		}
		.sliding-bar .list-group{
			position: relative;
			width: 250px;
			/*left:-250px;*/
		}
		/*nav{
			position: absolute;
			z-index: 50;
		}*/
		
		
		.main{
			transition: 1s;
			position: relative;
			/*background-color: lightgrey;*/
			width: 100%;
			height: 1000px;
			/*top: 200px;*/
		}

		.secondary-nav{
			padding-top: 40px;
			padding-bottom: 40px;
			width: 420px;
			background-color: lightgrey;
			display: flex;
			justify-content: center;
			
			position: absolute;
			left: 50%;
			top: 200px;
			transform: translateX(-50%);
			box-shadow: 1px 1px 15px 5px grey;
		}
		.secondary-nav *{
			margin: 10px;
		}
		.select-card-form{
			background-color: lightgrey;
			font-variant-caps: small-caps;
			padding: 20px;
			width: 450px;
			position: absolute;
			top: 150px;
			left: 50%;
			transform: translate(-50%,-50%);
			box-shadow: 1px 1px 15px 5px grey;
		}
		.select-card-form *{
			margin: 5px;
		}
		.or{
			width: 450px;
			position: absolute;
			top: 50px;
			left: 50%;
			transform: translate(-50%,220px);
			text-align: center;
		}
		.add-card-form{
			background-color: lightgrey;
			font-variant-caps: small-caps;
			padding: 20px;
			width: 450px;
			position: absolute;
			top: 50px;
			left: 50%;
			transform: translate(-50%,300px);
			box-shadow: 1px 1px 15px 5px grey;
		}
		.card-size-form{
			background-color: lightgrey;
			padding: 20px;
			width: 450px;
			position: relative;
			top: 150px;
			left: 50%;
			transform: translate(-50%,-50%);
			box-shadow: 1px 1px 15px 5px grey;
			/*border:1px solid black;*/
		}

		.add-employee-form{
			background-color: lightgrey;
			font-variant-caps: small-caps;
			padding: 20px;
			width: 450px;
			position: relative;
			top: 100px;
			left: 50%;
			transform: translate(-50%,0);
			box-shadow: 1px 1px 15px 5px grey;
			/*border:1px solid black;*/
		}
		.import-from-excel-form{
			width: 400px;
			position: absolute;
			left: 50%;
			top: 20%;
			box-shadow: 1px 1px 15px 5px grey;
			transform: translate(-50%,0);
			padding: 20px;
		}
		.import-from-excel-form *{
			margin: 10px;
		}

		.add-user-form{
			transition: 1s;
			width: 500px;
			padding: 20px;
			background-color: white;
			font-variant-caps: small-caps;
			position: absolute;
			left: 50%;
			top:40px;
			transform: translate(-50%,0px);
			box-shadow: 1px 1px 15px 5px grey;
		}
		.add-user-form input[type=radio],.add-user-form h5{
			margin: 10px;

		}

		.add-company-form{
			width: 500px;
			padding: 20px;
			background-color: white;
			position: absolute;
			font-variant-caps: small-caps;
			margin: 20px;
			left: 50%;
			top:40px;
			transform: translate(-50%,0px);
			box-shadow: 1px 1px 15px 5px grey;
		}
		.add-company-form input[type=checkbox],form h5{
			margin: 10px;
		}
		.add-company-form input[type="checkbox"][readonly] {
		  pointer-events: none;
		}
		.add-company-form input,form label{
			/*margin:10px;*/
		}
		

		.edit-employee-form{
			width: 500px;
			padding: 20px;
			background-color: white;
			position: absolute;
			margin: 20px;
			left: 50%;
			top:40px;
			transform: translate(-50%,0px);
			box-shadow: 1px 1px 15px 5px grey;	
		}

		.employee-data{

		}

		.employee-data td,th{
			/*padding: 5px;*/
			margin-top:2px; 
			text-align: center;

		}

		.employee-data tr{
			margin: 0;
			padding: 0;
			/*margin-top: 10px;*/
		}

		.employee-data tr:nth-child(even){
			background-color: lightgrey;
		}

		.employee-data tr:nth-child(odd){
			background-color: white;
		}
		.employee-data tr:hover{
			cursor: pointer;
			background-color: darkgrey;
		}


		.user-permission-form{
			width: 600px;
			padding: 20px;
			background-color: white;
			position: absolute;
			font-variant-caps: small-caps;
			margin: 20px;
			left: 50%;
			top:40px;
			transform: translate(-50%,0px);
			box-shadow: 1px 1px 15px 5px grey;	
		}
		.user-permission-form *{
			margin: 10px;
		}
		.search-results{
			display: flex;
			flex-wrap: wrap;
		}
		.search-result-employee{
			background-color: lightgrey;
			width: 100%;
			padding: 10px;
			margin: 5px;
			border:2px solid darkgrey;
			border-radius: 2px;
		}
		.search-result-employee:hover{
			text-decoration: none;
			background-color: white;
			
		}

		.search-result-employee img{
			width: 50px;
			height: 70px;
		}

		.search-result-employee .result-name{
			padding-left: 30px;
		}
		.employee-view{
			width: 600px;
			padding: 20px;
			background-color: white;
			position: absolute;
			font-variant-caps: small-caps;
			margin: 20px;
			left: 50%;
			top:40px;
			transform: translate(-50%,0px);
			box-shadow: 1px 1px 15px 5px grey;
		}
		.employee-view table{
			margin: 20px;
		}
		.employee-view td{
			padding: 5px;
		}

		.confirm-delete-form{
			width: 600px;
			padding: 20px;
			background-color: white;
			position: relative;
			font-variant-caps: small-caps;
			margin: 20px;
			left: 50%;
			/*top:40px;*/
			transform: translate(-50%,0px);
			box-shadow: 1px 1px 15px 5px grey;
		}
		.confirm-delete-form *{
			margin: 20px;
		}

		.change-password-form{
			width: 600px;
			padding: 20px;
			background-color: white;
			position: relative;
			font-variant-caps: small-caps;
			margin: 20px;
			left: 50%;
			top:40px;
			transform: translate(-50%,0px);
			box-shadow: 1px 1px 15px 5px grey;
		}
		.change-password-form *{
			margin: 5px;
		}


		#layout-editor-settings{
			/*z-index: 10;*/
			font-family: tahoma;
			border: 2px solid darkgrey;
			background-color: lightgrey;
			padding: 20px;
			position: absolute;
			/*UPDATE BELOW LINE*/
			top: 10px;
			width: 450px;
			height: 300px;
			overflow-y:scroll; 
			display: block;
			/*justify-content: center;*/
			/*flex-wrap: wrap;*/
			border-radius: 5px;
			opacity: .9;
		}

		.grid-settings{
			display: none;
			flex-wrap: wrap;

		}
		#layout-editor-settings input[type=button]{
			margin: 10px;
		}
		#layout-editor-settings label{
			font-size: 14px;
			padding: 5px;
		}

	</style>
</head>
<body>
	<nav class="sticky-top">
		<div class="system-navbar bg-success">
			<span><i class="material-icons btn-nav-menu btn-nav-menu-on">menu</i><i class="material-icons btn-nav-menu btn-nav-menu-off">chevron_left</i>
			</span>
			
			<span class="company-name text-dark" style="float: right;font-size:21px;font-weight: 700;">
				<div>
					<?= $_SESSION['user']['company_name']?>
				</div>	
				<div>
					Logged In as <?= $_SESSION['user']['name']?>
				</div>
			</span>
			<span class="search-box text-dark" style="float: right;padding: 10px;position: relative;right: 30px;">
				<form>
					<input type="text" id="search_input" class="form-control" name="" placeholder="Search By Contact no.">
				</form>
			</span>
				
			
		</div>
	</nav>
	<nav class="sliding-bar" style="width: 250px;position: fixed">
		<div class="list-group ">
			<a class="list-group-item list-group-item-success list-group-item-action" href="admin.php">Home</a>
			
			<a class="list-group-item list-group-item-success list-group-item-action" href="permission.php?action=add_employee">Add Employee</a>
			
			<?php if($_SESSION['user']['role']=='super_admin'):?>
			<a class="list-group-item list-group-item-success list-group-item-action" href="permission.php?action=add_user">Add User</a>
			<?php endif;?>

			<?php if($_SESSION['user']['role']=='super_admin'):?>
			<a class="list-group-item list-group-item-success list-group-item-action" href="edit_user.php">Edit User</a>
			<?php endif;?>
			
			<?php if($_SESSION['user']['role']=='super_admin'):?>
			<a class="list-group-item list-group-item-success list-group-item-action" href="add_company.php">Add Company</a>
			<?php endif;?>

			<a class="list-group-item list-group-item-success list-group-item-action" href="show_all_records.php">Manage All Records</a>
			
			<a class="list-group-item list-group-item-success list-group-item-action" href="import_from_excel.php">Import From Excel file</a>

			<?php if($_SESSION['user']['role']=='super_admin'):?>
			<a class="list-group-item list-group-item-warning list-group-item-action" href="super_change_password.php">Change Password</a>
			<?php endif;?>
			
			<a class="list-group-item list-group-item-warning list-group-item-action" href="do_logout.php">Log Out</a>
		</div>
	</nav>
	<div class="container-fluid">

		<section class="search-results">
			
		</section>

		
<!-- HEADER -->