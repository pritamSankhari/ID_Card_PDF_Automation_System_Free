<?php
	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';
	require 'includes/functions.php';

	if(!isLoggedIn() ||  !isset($_SESSION['user']['role'])){
		header('Location:'.BASE_URL."login.php");
    	exit();
	}

	if($_SESSION['user']['role'] != 'super_admin'){
		header('Location:'.BASE_URL."admin.php");
    	exit();	
	}
	
	$companies = getAllCompanies($db);
?>

<?php require 'includes/header_admin.php';?>
<section class="main">
	<?php require 'includes/msg.php';?>

	<?php if($companies):?>
	<form class="change-password-form" action="do_update_user.php" method="post">
		<h3>Edit</h3>
		<input type="hidden" name="user_id" value="<?= $_SESSION['user']['id']?>">

		<h5>Select Company</h5>
		<select id="company_id" name="company_id" class="form-control">
			<?php foreach($companies as $company):?>
				<option value="<?= $company['id']?>"><?= $company['name']?></option>
			<?php endforeach;?>
		</select>

		<h5>Select User</h5>
		<select id="user_id" name="user_id" class="form-control">
			
		</select>

		<label>User Name:</label>
		<input id="user_name" type="text" class="form-control" name="user_name" placeholder="User Name">

		<label>New Password:</label>
		<input class="form-control" type="password" name="new_pwd" placeholder="New Password" required="">
		
		<label>Confirm New Password:</label>
		<input class="form-control"  type="password" name="c_new_pwd" placeholder="Confirm New Password" required="">
		
		<input class="btn btn-success" type="submit" name="change" value="Change">
	</form>


	<script type="text/javascript">
		let companies = $('#company_id')
		let user_id;

		function setUsersOptions(users){
			if(users.length>0){
				let options = ""
				for(let i=0;i<users.length;i++){
					options += "<option value="+users[i].id+">"+users[i].name+"</option>"
				}
				$('#user_id').append(options)
			}
		}
		
		function setUserName(user){
			$("#user_name").val(user.name)
		}

		if(companies.length>0){
			$.post(
				'show_users.php',
				{
					'company_id':companies[0].value
				},
				function(data){
					let users = JSON.parse(data)
					setUsersOptions(users)			
					
					if(users.length>0){
						setUserName(users[0])
					}
				}
			)

		}

		$('#company_id').on('change',function(){
			$.post(
				'show_users.php',
				{
					'company_id':$('#company_id').val()
				},
				function(data){
					let users = JSON.parse(data)
					$('#user_id').html("")
					setUsersOptions(users)
					setUserName(users[0])			

				}
			)	
		})

		$('#user_id').on('change',function(e){
			$('#user_name').val(e.target.options[e.target.selectedIndex].textContent)
		})
	</script>

	<?php else:?>
		<h3>No Company has been registered!</h3>
	<?php endif;?>

</section>
<?php require 'includes/footer_admin.php';?>