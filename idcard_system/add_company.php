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
		<form class="add-company-form" action="do_add_company.php" method="post">
			<h3 class="text-dark bg-success" style="padding: 10px;text-align: center;">Add Company</h3>

			
			<!-- 
			<div class="form-group">
				<label>Name:</label>
				<input type="text" class="form-control" name="company_name" placeholder="Name" required="">
			</div> -->
			<div>
				<h5>Field(s) required for the Card</h5>
			</div>
			<div class="form-group">

				<input type="checkbox" name="req_mobile" checked="" value="1" readonly>
				<label>Mobile No</label>
				<br>

				<input type="checkbox" name="req_name" value="1">
				<label>Name</label>
				<br>

				<input type="checkbox" name="req_emc" value="1">
				<label>Emergency Contact No</label>
				<br>

				<input type="checkbox" name="req_address" value="1">
				<label>Address</label>
				<br>

				<input type="checkbox" name="req_email" value="1">
				<label>Email</label>
				<br>

				<input type="checkbox" name="req_image" value="1">
				<label>Employee Image</label>
				<br>

				<input type="checkbox" name="req_dob" value="1">
				<label>Date of Birth</label>
				<br>

				<input type="checkbox" name="req_blood" value="1">
				<label>Blood Group</label>
				<br>

				<input type="checkbox" name="req_emp_id" value="1">
				<label>Employee Id</label>
				<br>

				<input type="checkbox" name="req_dept" value="1">
				<label>Department</label>
				<br>

				<input type="checkbox" name="req_desig" value="1">
				<label>Designation</label>
				<br>

				<input type="checkbox" name="req_doi" value="1">
				<label>Date of issue (Card)</label>
				<br>

				<input type="checkbox" name="req_doe" value="1">
				<label>Date of expiry (Card)</label>
				<br>

				<input type="checkbox" name="req_qr" value="1">
				<label>QR Code (Image)</label>
				<br>

				<input type="checkbox" name="req_sign" value="1">
				<label>Employee Signature (Image)</label>
				<br>
			</div>
			<div class="form-group">
				<label>Table Name:</label>
				<input type="text" class="form-control" name="table_name" placeholder="Table Name" required="">
			</div>
			
			<div class="form-group">
				<label>Company Name:</label>
				<input type="text" class="form-control" name="company_name" placeholder="Company Name" required="">
			</div>
			
			<input type="submit" class="btn btn-success form-control" name="add" value="Add">
		</form>
	</section>
<?php require 'includes/footer_admin.php';?>