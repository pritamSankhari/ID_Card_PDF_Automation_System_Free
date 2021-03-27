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

	if(!$table_name = getMyCompanyDataTableName($db)){

		setMsg("No company has been selected !!!",1);
		header('Location:'.BASE_URL."admin.php");
    	exit();	
	}

	$fields = getDataTableFieldList($db,$table_name);

	if(!is_array($fields)){
		
		setMsg("Failed to get Table Fields !!!",1);
		header('Location:'.BASE_URL."show_all_records.php");
    	exit();			
	}
	
	$emp_id = $db->real_escape_string($_GET['emp_data_id']);

	if(!$employee = getEmployeeDataById($db,$table_name,$emp_id) ){

		setMsg("Can not get employee!!!",1);
		header('Location:'.BASE_URL."admin.php");
    	exit();	
	}
?>


<?php require 'includes/header_admin.php';?>
<section class="main">
	<form class="edit-employee-form" action="do_update_employee.php" method="post" enctype="multipart/form-data">

		<?php if(isset($fields['name'])):?>
				<div class="form-group">
					<label>Name:</label>
					<input class="form-control" type="text" name="name" placeholder="Name" value="<?= $employee['name']?>">
				</div>
			<?php endif;?>

			<?php if(isset($fields['mobile'])):?>
				<div class="form-group">
					<label>Mobile No:</label>
					<input class="form-control" type="text" name="mobile" placeholder="Mobile No." value="<?= $employee['mobile']?>">
				</div>
			<?php endif;?>

			<?php if(isset($fields['emergency'])):?>
				<div class="fom-group">
					<label>Emergency Contact No:</label>
					<input class="form-control" type="text" name="emergency" placeholder="Emergency Contact No." value="<?= $employee['emergency']?>">
				</div>
			<?php endif;?>

			<?php if(isset($fields['address'])):?>
				<div class="fom-group">
					<label>Address:</label>
					<textarea class="form-control" name="address"><?= $employee['address']?></textarea>
				</div>
			<?php endif;?>

			<?php if(isset($fields['email'])):?>
				<div class="fom-group">
					<label>Email:</label>
					<input class="form-control" type="email" name="email" placeholder="Email" <?= $employee['email']?>>
				</div>
			<?php endif;?>

			<?php if(isset($fields['image'])):?>
				<div class="fom-group">
					<label>Photo:</label>
					<input class="form-control" type="file" name="image">
				</div>
			<?php endif;?>

			<?php if(isset($fields['date_of_birth'])):?>
				<div class="fom-group">
					<label>Date of Birth:</label>
					<input class="form-control" type="text" name="date_of_birth" placeholder="Date of Birth" value="<?= $employee['date_of_birth']?>">
				</div>
			<?php endif;?>

			<?php if(isset($fields['blood_group'])):?>
				<div class="fom-group">
					<label>Blood Group:</label>
					<input class="form-control" type="text" name="blood_group" placeholder="Blood Group" value="<?= $employee['blood_group']?>">
				</div>
			<?php endif;?>

			<?php if(isset($fields['emp_id'])):?>
				<div class="fom-group">
					<label>Employee ID:</label>
					<input class="form-control" type="text" name="emp_id" placeholder="Employee ID" value="<?= $employee['emp_id']?>">
				</div>
			<?php endif;?>

			<?php if(isset($fields['department'])):?>
				<div class="fom-group">
					<label>Department:</label>
					<input class="form-control" type="text" name="department" placeholder="Department" value="<?= $employee['department']?>">
				</div>
			<?php endif;?>

			<?php if(isset($fields['designation'])):?>
				<div class="fom-group">
					<label>Designation:</label>
					<input class="form-control" type="text" name="designation" placeholder="Designation" value="<?= $employee['designation']?>">
				</div>
			<?php endif;?>

			<?php if(isset($fields['date_of_issue'])):?>
				<div class="fom-group">
					<label>Date of Issue:</label>
					<input class="form-control" type="text" name="date_of_issue" placeholder="Date of Issue" value="<?= $employee['date_of_issue']?>">
				</div>
			<?php endif;?>

			<?php if(isset($fields['date_of_expiry'])):?>
				<div class="fom-group">
					<label>Date of Expiry</label>
					<input class="form-control" type="text" name="date_of_expiry" value="<?= $employee['date_of_expiry']?>">
				</div>
			<?php endif;?>

			<?php if(isset($fields['sign'])):?>
				<div class="fom-group">
					<label>Signature:</label>
					<input class="form-control" type="file" name="sign">
				</div>
			<?php endif;?>
			<input type="hidden" name="emp_data_id" value="<?= $employee['id']?>">
			<input type="submit" class="btn btn-success form-control" name="save" value="SAVE">
	</form>
</section>
<?php require 'includes/footer_admin.php';?>