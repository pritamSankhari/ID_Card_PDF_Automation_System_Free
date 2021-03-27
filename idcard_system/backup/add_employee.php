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


	if($result = $db->query("SELECT * FROM company WHERE id = ".$_SESSION['user']['company_id'])){
		if($result->num_rows>0){
			$company = $result->fetch_assoc();
		}
		else{
			echo "<h2>ACCESS DENIED !</h2>";
			exit();		
		}
	}

	$fields = getDataTableFieldList($db,$company['data_table']);

	if(!is_array($fields)){
		
		setMsg("Failed to get Table Fields !!!",1);
		header('Location:'.BASE_URL."show_all_records.php");
    	exit();			
	}
?>
<?php require 'includes/header_admin.php';?>
	<section class="main">
		<form class="add-employee-form" method="post" action="do_add_employee.php" enctype="multipart/form-data">
			<h3 style="text-align: center;font-variant-caps: small-caps;">Add Employee Form</h3>
			<?php if(isset($fields['name'])):?>
				<div class="form-group">
					<label>Name:</label>
					<input class="form-control" type="text" name="name" placeholder="Name" required="">
				</div>
			<?php endif;?>

			<?php if(isset($fields['mobile'])):?>
				<div class="form-group">
					<label>Mobile No:</label>
					<input class="form-control" type="text" name="mobile" placeholder="Mobile No." required>
				</div>
			<?php endif;?>

			<?php if(isset($fields['emergency'])):?>
				<div class="fom-group">
					<label>Emergency Contact No:</label>
					<input class="form-control" type="text" name="emc" placeholder="Emergency Contact No." required>
				</div>
			<?php endif;?>

			<?php if(isset($fields['address'])):?>
				<div class="fom-group">
					<label>Address:</label>
					<textarea class="form-control" name="address" required></textarea>
				</div>
			<?php endif;?>

			<?php if(isset($fields['email'])):?>
				<div class="fom-group">
					<label>Email:</label>
					<input class="form-control" type="email" name="email" placeholder="Email" required>
				</div>
			<?php endif;?>

			<?php if(isset($fields['image'])):?>
				<div class="fom-group">
					<label>Photo:</label>
					<input class="form-control" type="file" name="image" required>
				</div>
			<?php endif;?>

			<?php if(isset($fields['date_of_birth'])):?>
				<div class="fom-group">
					<label>Date of Birth:</label>
					<input class="form-control" type="date" name="dob" placeholder="Date of Birth" required>
				</div>
			<?php endif;?>

			<?php if(isset($fields['blood_group'])):?>
				<div class="fom-group">
					<label>Blood Group:</label>
					<input class="form-control" type="text" name="blood_group" placeholder="Blood Group" required>
				</div>
			<?php endif;?>

			<?php if(isset($fields['emp_id'])):?>
				<div class="fom-group">
					<label>Employee ID:</label>
					<input class="form-control" type="text" name="emp_id" placeholder="Employee ID" required>
				</div>
			<?php endif;?>

			<?php if(isset($fields['department'])):?>
				<div class="fom-group">
					<label>Department:</label>
					<input class="form-control" type="text" name="dept" placeholder="Department" required>
				</div>
			<?php endif;?>

			<?php if(isset($fields['designation'])):?>
				<div class="fom-group">
					<label>Designation:</label>
					<input class="form-control" type="text" name="desig" placeholder="Designation" required>
				</div>
			<?php endif;?>

			<?php if(isset($fields['date_of_issue'])):?>
				<div class="fom-group">
					<label>Date of Issue:</label>
					<input class="form-control" type="date" name="doi" placeholder="Date of Issue" required>
				</div>
			<?php endif;?>

			<?php if(isset($fields['date_of_expiry'])):?>
				<div class="fom-group">
					<label>Date of Expiry</label>
					<input class="form-control" type="date" name="doe" required>
				</div>
			<?php endif;?>

			<?php if(isset($fields['sign'])):?>
				<div class="fom-group">
					<label>Signature:</label>
					<input class="form-control" type="file" name="sign" required>
				</div>
			<?php endif;?>
			<input type="submit" class="btn btn-success" name="add" value="Add">
		</form>
	</section>
<?php require 'includes/footer_admin.php';?>