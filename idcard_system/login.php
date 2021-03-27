<?php
	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';

	if(isLoggedIn()){
		header('Location:'.BASE_URL."admin.php");
    	exit();
	}

	if($result = $db->query("SELECT * FROM company")){
		if($result->num_rows>0){
			$companies = array();
			while($row = $result->fetch_assoc()){
				$companies[]=$row;
			}
		}
		else{
			echo "<h2>Sorry ! No company is registered yet ! Contact with Administraror</h2>";
			exit();		
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>ID Card System Login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style type="text/css">
		form{
			width: 600px;
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%,-50%);
			background-color: lightgrey;
			padding: 30px;
			box-shadow: 1px 1px 15px 5px grey;
		}
		form>h3{
			text-align: center;
			/*background-color: mediumaquamarine;*/
			padding: 20px;
		}
		form>input[type=submit]{
			margin-top: 20px; 
		}
	</style>
</head>
<body>
	<div class="container">


		<?php require 'includes/msg.php';?>
		

		<form action="do_login.php" method="post">
			<h3 class="bg-success text-dark" style="font-variant-caps: small-caps;">ID Card System Login</h3>

			<div>
				<h5 class="text-dark" style="text-align: center;margin-top:20px;">Select Company</h5>
				<br>
				<select name="company_id" class="form-control">
					<?php foreach($companies as $company):?>
						<option value="<?= $company['id']?>"><?= $company['name']?></option>
					<?php endforeach;?>
				</select>
			</div>

			<label class="text-dark">User Name: </label>
			<input type="text" class="form-control" name="user_name" placeholder="User Name">
			<label class="text-dark">Password: </label>
			<input type="password" class="form-control" name="password" placeholder="Password">
			<input type="submit" class="btn btn-success" name="login" value="Log In">
		</form>
	</div>

</body>
</html>