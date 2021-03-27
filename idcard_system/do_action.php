<?php
	ob_start();
	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';
	require 'includes/functions.php';

	if(!isset($_POST['proceed'])||empty($_POST['proceed'])){
		header('Location:'.BASE_URL."admin.php");
    	exit();
	}

	// $user_name = $db->real_escape_string($_POST['user_name']);
	$password = md5($db->real_escape_string($_POST['password']));

	// if($user_name !="super_admin"){
	// 	setMsg("Invalid Username !",1);
	// 	header('Location:'.BASE_URL."admin.php");
	// 	exit();		
	// }
	
	
	if(isset($_POST['table_name'])) $table_name = $db->real_escape_string($_POST['table_name']);
	if(isset($_POST['emp_data_id'])) $emp_data_id = $db->real_escape_string($_POST['emp_data_id']);
	if(isset($_POST['action'])) $action = $db->real_escape_string($_POST['action']);

	$company = getMyCompany($db);

	$sql = "SELECT * FROM users WHERE role = 'super_admin' AND password = '$password'";

	if($result = $db->query($sql)){
		if($result->num_rows<1){

			setMsg("Wrong Password !",1);
			header('Location:'.BASE_URL."admin.php");
    		exit();
		}
	}
	else{
		setMsg("Invalid Username or Password !",1);
		header('Location:'.BASE_URL."admin.php");
		exit();
	}

	if(!$cards = getAllCards($db)){
		if(!is_array($cards)){
			setMsg("Failed to get cards !",1);
			header('Location:'.BASE_URL."admin.php");
	    	exit();	
		}
		
	}

	// print_r($_POST);
?>

<?php require 'includes/header_admin.php';?>
<section class="main">


	<?php if($action == "print_again"):?>
	<form class="select-card-form" action="do_print.php" method="post">
		<h3>Select Card Layout</h3>

		<?php if(!empty($cards)):?>
		<select class="form-control" name="card_id">
		
			<?php foreach($cards as $card):?>
		
				<option value="<?= $card['id']?>"><?= $card['name']?></option>
			<?php endforeach;?>	
		
		</select>

		<h5>Reason for printing duplicate card</h5>
		<input type="text" class="form-control" name="duplicate" required="" placeholder="Reason for print duplicate">

		<input type="hidden" name="table" value="<?= $table_name?>">
		<input type="hidden" name="emp_data_id" value="<?= $emp_data_id?>">
		<input type="submit" class="btn btn-primary form-control" name="print" value="Print">

		<?php else:?>
			<a class="btn btn-primary form-control" href="add_card.php">Add Card</a>
		<?php endif;?>	
		
	</form>
	<?php endif;?>

	<?php if($action == "add_employee"):?>
		<?php
			if($result = $db->query("SELECT * FROM company WHERE id = ".$_SESSION['user']['company_id'])){
				if($result->num_rows>0){
					$company = $result->fetch_assoc();
				}
				else{
					setMsg("Can Not Detect Company !!!",1);
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

	<?php endif;?>

	<?php if($action == "add_card"):?>
		<?php
		if($result = $db->query("SELECT * FROM company WHERE id = ".$_SESSION['user']['company_id'])){
			if($result->num_rows>0){
				$company = $result->fetch_assoc();
			}
			else{
				echo "<h2>ACCESS DENIED !</h2>";
				exit();		
			}
		}
		?>


		<form class="select-card-form" action="update_card_property.php" method="get">
			<h3>Select Card</h3>
			
			<?php if($cards):?>
			<div class="form-group">
				<select name="card_id" class="form-control">
			
				<?php foreach($cards as $card):?>
					<option value="<?= $card['id']?>">
						<?= $card['name']?>
					</option>
				<?php endforeach;?>
				</select>
			</div>
			<input type="submit" class="btn btn-primary" name="confirm" value="Confirm Card Size">
			<input type="submit" class="btn btn-success" name="edit" value="Edit Card">
			<?php else:?>
				<h5>No Cards added yet !</h5>
			<?php endif;?>
		</form>
		<h3 class="or">OR</h3>
		<form action="do_add_card.php" class="add-card-form" enctype="multipart/form-data" method="post">
			<h3>Add New Card</h3>
			<div class="form-group">
				<label>Company Name:</label>
				<input type="text" class="form-control" name="company_name" value="<?= $company['name']?>" readonly>
				<input type="hidden" class="form-control" name="company_id" value="<?= $_SESSION['user']['company_id']?>" readonly>
			</div>
			<div class="form-group">
				<label>Card Name:</label>
				<input type="text" class="form-control" name="card_name">
			</div>

			<div class="form-group">
				<label>Card Front Image:</label>
				<input type="file" class="form-control" name="front_file" required="">
			</div>
			<div class="form-group">
				<label>Card Back Image:</label>
				<input type="file" class="form-control" name="back_file">
			</div>
			<div class="form-group">
				<label>Card Orientation:</label>
				<select name="orientation" class="form-control">
					<option value="0">
						Potrait
					</option>
					<option value="1">
						Landscape
					</option>
				</select>
			</div>
			<input type="submit" class="btn btn-success" name="add" value="Add">
		</form>
	<?php endif;?>

	<?php if($action == 'delete'):?>
		<?php
			$employee = getEmployeeDataById($db,$table_name,$emp_data_id);
		?>

		<div class="employee-view">
			<table>
				<?php if(isset($employee['image'])):?>
				<tr>
					<td>
						<img src="<?= $employee['image']?>" style="width: 200px;height: 250px;">
					</td>
					<td>
						<table>
							<tr>
								<td>
									<?php if((int)$employee['printed']):?>
							
									<a class="btn btn-primary text-light" style="text-decoration: none;" href="permission.php?table=<?= $table_name?>&emp_data_id=<?= $employee['id']?>&action=print_again">
										Print Again
									</a>	

									<?php else:?>
									
									<a class="btn btn-primary text-light" style="text-decoration: none;" href="print.php?table=<?= $table_name?>&emp_data_id=<?= $employee['id']?>">
										Print
									</a>
									
									<?php endif;?>			
								</td>
							</tr>
							<tr>
								<td class="">
									<a class="btn btn-success text-light" style="text-decoration: none;" href="edit_employee.php?table=<?= $table_name?>&emp_data_id=<?= $employee['id']?>">Edit</a>
								</td>
							</tr>
						</table>
						
					</td>
				</tr>
				<?php endif;?>

				<?php if(isset($employee['name'])):?>
				<tr>
					<th>Name:</th>
					<td><?= $employee['name']?></td>
				</tr>
				<?php endif;?>

				<?php if(isset($employee['address'])):?>
				<tr>
					<th>address:</th>
					<td><?= $employee['address']?></td>
				</tr>
				<?php endif;?>

				<?php if(isset($employee['date_of_birth'])):?>
				<tr>
					<th>Date of Birth:</th>
					<td><?= $employee['date_of_birth']?></td>
				</tr>
				<?php endif;?>

				<?php if(isset($employee['mobile'])):?>
				<tr>
					<th>Mobile No:</th>
					<td><?= $employee['mobile']?></td>
				</tr>
				<?php endif;?>

				<?php if(isset($employee['emergency'])):?>
				<tr>
					<th>Emergency Contact No.:</th>
					<td><?= $employee['emergency']?></td>
				</tr>
				<?php endif;?>

				<?php if(isset($employee['blood_group'])):?>
				<tr>
					<th>Blood Group:</th>
					<td><?= $employee['blood_group']?></td>
				</tr>
				<?php endif;?>
				
				<?php if(isset($employee['date_of_issue'])):?>
				<tr>
					<th>Date of Issue:</th>
					<td><?= $employee['date_of_issue']?></td>
				</tr>
				<?php endif;?>

				<?php if(isset($employee['date_of_expiry'])):?>
				<tr>
					<th>Date of Expiry:</th>
					<td><?= $employee['date_of_expiry']?></td>
				</tr>
				<?php endif;?>

				<?php if(isset($employee['qr'])):?>
				<tr>	
					<td>
						<div style="display: flex;justify-content: center">
							<img src="<?= $employee['qr']?>" style="width:200px;">	
						</div>
					</td>
				</tr>	
				<?php endif;?>
			</table>
		</div>
		<form class="confirm-delete-form" action="do_delete.php" method="post" style="padding: 0;margin:0;">

			<h3>Confirm & Delete</h3>
			<input type="hidden" name="table_name" value="<?= $table_name?>">

			<input type="hidden" name="emp_data_id" value="<?= $emp_data_id ?>">
			
			<input type="hidden" name="company_id" value="<?= $_SESSION['user']['company_id']?>">

			<input class="btn btn-danger" type="submit" name="delete" value="Delete">
			<a class="btn btn-warning" href="admin.php">Cancel</a>
		</form>
	<?php endif;?>

	<?php if($action == 'delete_all'):?>
		<form class="confirm-delete-form" action="do_delete_all.php" method="post" style="padding: 0;margin:0;">

			<h3>Confirm & Delete</h3>
			<input type="hidden" name="table_name" value="<?= $table_name?>">

			<input class="btn btn-danger" type="submit" name="deleteall" value="Delete All">
			<a class="btn btn-warning" href="admin.php">Cancel</a>
		</form>
	<?php endif;?>

	<?php if($action == 'add_user'):?>
		
		<?php
			$companies = getAllCompanies($db);
		?>
		<?php if($companies):?>
		
		<form class="add-user-form" method="post" action="do_add_user.php">
			<h3 class="text-dark bg-success" style="padding: 10px;text-align: center;">Add User</h3>
			<div class="form-group">
				<h5>User Type:</h5>
				<input class="admin-radio" type="radio" name="role" value='admin' checked="" /><span>Admin</span>
				<input class="user-radio" type="radio" name="role" value='regular_user'/><span>User</span>
				<!-- <input class="printer-radio" type="radio" name="role" value='printer' /><span>Printer</span> -->
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
		<?php else:?>
			<h3>No Company has been registered!!!</h3>
		<?php endif;?>
	<?php endif;?>
</section>
<?php require 'includes/footer_admin.php';?>