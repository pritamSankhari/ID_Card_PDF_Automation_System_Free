<?php
	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';

	if(!isLoggedIn()){
		header('Location:'.BASE_URL."login.php");
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
<?php require 'includes/header_admin.php';?>
	<section class='main'>
		<form class="add-user-form" method="post" action="do_add_user.php">
			<h3 class="text-dark bg-success" style="padding: 10px;text-align: center;">Add User</h3>
			<div class="form-group">
				<h5>User Type:</h5>
				<input class="admin-radio" type="radio" name="role" value='admin' checked="" /><span>Admin</span>
				<input class="user-radio" type="radio" name="role" value='regular_user'/><span>User</span>
				<input class="printer-radio" type="radio" name="role" value='printer' /><span>Printer</span>
			</div>
		
			<div class="form-group">
				<h5 class="text-dark" style="text-align: center;margin-top:20px;">Select Company</h5>
				<br>

				<select id="company_id" name="company_id" class="form-control">
					<?php foreach($companies as $company):?>
						<option value="<?= $company['id']?>"><?= $company['name']?></option>
					<?php endforeach;?>
				</select>
			</div>
			<div class="form-group">
				<label>Name:</label>
				<input id="name" type="text" class="form-control" name="name" placeholder="Name" required/>
			</div>
			<div class="form-group">
				<label>Contact No:</label>
				<input type="text" class="form-control" name="contact" placeholder="Contact No."/>
			</div>
			<div class="form-group">
				<label>Password:</label>
				<input type="password" class="form-control" name="password" placeholder="Password" required/>
			</div>
			<div class="form-group">
				<label>Confirm Password:</label>
				<input type="password" class="form-control" name="cpassword" placeholder="Confirm Password" required/>
			</div>

			<input type="hidden" name="created_by" value="<?= $_SESSION['user']['id']?>"/>

			<input type="submit" class="btn btn-success form-control" name="add" value="Add"/>
		</form>
	</section>
<?php require 'includes/footer_admin.php';?>