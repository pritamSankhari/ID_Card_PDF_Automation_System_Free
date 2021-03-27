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

	// $employees = getEmployeeData($db,$table_name);
	// if($employees){
	// 	echo "hi";
	// 	exit();
	// }
	if(!$employees = getEmployeeData($db,$table_name)){

		if(!is_array($employees)){
			setMsg("ERROR !!! Failed to get employee data !",1);
			header('Location:'.BASE_URL."admin.php");
	    	exit();	
		}

	}

	if(!$fields = getDataTableFieldList($db,$table_name)){

		if(!is_array($fields)){
			setMsg("ERROR !!! Failed to get fields !",1);
			header('Location:'.BASE_URL."admin.php");
	    	exit();		
    	}
	}
?>
<?php require 'includes/header_admin.php';?>
<section class="main">
	<?php require 'includes/msg.php';?>
	
	<div style="display: flex;width: 100%;">
		<a class="btn btn-primary" style="margin: 10px;" href="printall.php?table=<?= $table_name?>">Print All Card(s)</a>

		<a class="btn btn-dark" style="margin: 10px;" href="do_gen_all_qr.php">Generate All QR Codes</a>
		
		<a class="btn btn-success" style="margin: 10px;" href="import_from_excel.php">Import Data From Excel</a>

		<a class="btn btn-danger" style="margin: 10px;" href="permission.php?table=<?= $table_name?>&action=delete_all">Delete All</a>

		<!-- 
		<form action="do_delete_all.php" method="post" style="padding: 0;margin:10px;">

			<input type="hidden" name="table_name" value="<?= $table_name?>">

			<input class="btn btn-danger" type="submit" name="deleteall" value="Delete All Data">
		</form> -->
	</div>


	<div class="records employee-data">
		<?php if(!empty($employees)):?>
		<table style="width: 100%;font-size: 14px;" class="text-dark">
			<tr>
				<?php if(isset($fields['image'])):?>
					<th>Image</th>
				<?php endif;?>

				<?php if(isset($fields['name'])):?>
					<th>Name</th>
				<?php endif;?>

				<!-- <?php if(isset($fields['date_of_birth'])):?>
					<th>Date of Birth</th>
				<?php endif;?> -->

				<?php if(isset($fields['email'])):?>
					<th>Email</th>
				<?php endif;?>

				<?php if(isset($fields['mobile'])):?>
					<th>Mobile No.</th>
				<?php endif;?>

				<?php if(isset($fields['emergency'])):?>
					<th>Emergency Contact No.</th>
				<?php endif;?>

				<!-- <?php if(isset($fields['emp_id'])):?>
					<th>Emp_id</th>
				<?php endif;?> -->

				<!-- <?php if(isset($fields['department'])):?>
					<th>Department</th>
				<?php endif;?> -->

				<?php if(isset($fields['designation'])):?>
					<th>Designation</th>
				<?php endif;?>

				<?php if(isset($fields['date_of_issue'])):?>
					<th>Date of Issue</th>
				<?php endif;?>

				<?php if(isset($fields['date_of_expiry'])):?>
					<th>Date of Expiry</th>
				<?php endif;?>

				<th>Print</th>
			</tr>
			<?php foreach($employees as $employee):?>
				<tr>
					<?php if(isset($fields['image'])):?>
						<td>
							<img src="<?= $employee['image']?>" style="width: 80px;">	
						</td>
					<?php endif;?>

					<?php if(isset($fields['name'])):?>
						<td>
							<?= $employee['name']?>		
						</td>
					<?php endif;?>
					<!-- 
					<?php if(isset($fields['date_of_birth'])):?>
						<td>
							<?= $employee['date_of_birth']?>		
						</td>
					<?php endif;?> -->

					<?php if(isset($fields['email'])):?>
						<td>
							<?= $employee['email']?>		
						</td>
					<?php endif;?>

					<?php if(isset($fields['mobile'])):?>
						<td>
							<?= $employee['mobile']?>		
						</td>
					<?php endif;?>

					<?php if(isset($fields['emergency'])):?>
						<td>
							<?= $employee['emergency']?>		
						</td>
					<?php endif;?>

					<!-- <?php if(isset($fields['emp_id'])):?>
						<td>
							<?= $employee['emp_id']?>		
						</td>
					<?php endif;?> -->

					<!-- 
					<?php if(isset($fields['department'])):?>
						<td>
							<?= $employee['department']?>		
						</td>
					<?php endif;?> -->

					<?php if(isset($fields['designation'])):?>
						<td>
							<?= $employee['designation']?>		
						</td>
					<?php endif;?>

					<?php if(isset($fields['date_of_issue'])):?>
						<td>
							<?= $employee['date_of_issue']?>		
						</td>
					<?php endif;?>

					<?php if(isset($fields['date_of_expiry'])):?>
						<td>
							<?= $employee['date_of_expiry']?>		
						</td>
					<?php endif;?>
					
					<td class="">
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
					<td>
						<a class="btn btn-light" href="employee.php?emp_data_id=<?= $employee['id']?>">View Details</a>
					</td>
					<td class=""><a class="btn btn-success text-light" style="text-decoration: none;" href="edit_employee.php?table=<?= $table_name?>&emp_data_id=<?= $employee['id']?>">Edit</a></td>

					<td>
						<a class="btn btn-danger" href="permission.php?table=<?= $table_name?>&emp_data_id=<?= $employee['id']?>&action=delete">Delete</a>
						<!-- 
						<form action="do_delete.php" method="post" style="padding: 0;margin:0;">

							<input type="hidden" name="table_name" value="<?= $table_name?>">

							<input type="hidden" name="emp_data_id" value="<?= $employee['emp_data_id']?>">
							
							<input type="hidden" name="company_id" value="<?= $_SESSION['user']['company_id']?>">

							<input class="btn btn-danger" type="submit" name="delete" value="Delete">
						</form>
						 -->
					</td>

					<?php if(isset($fields['qr'])):?>
						<td>
							<img src="<?= $employee['qr']?>" style="width: 80px;">	
						</td>
					<?php endif;?>
				</tr>
			<?php endforeach;?>
		</table>
		<?php else:?>
			<h3>No record found</h3>
		<?php endif;?>
	</div>
</section>
<?php require 'includes/footer_admin.php';?>