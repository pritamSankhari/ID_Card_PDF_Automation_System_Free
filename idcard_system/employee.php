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

	if(!isset($_GET['emp_data_id']) || empty($_GET['emp_data_id'])){

		header('Location:'.BASE_URL."admin.php");
    	exit();		
	}

	$emp_data_id = $db->real_escape_string($_GET['emp_data_id']);

	$employee = getEmployeeDataById($db,$table_name,$emp_data_id);

	// print_r($employee);


?>

<?php require 'includes/header_admin.php';?>
<section class="main">
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
</section>
<?php require 'includes/footer_admin.php';?>