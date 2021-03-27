<?php
	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';
	require 'includes/functions.php';
	require 'includes/fields.php';

	if(!isset($_POST) || empty($_POST)){
		header('Location:'.BASE_URL."admin.php");
    	exit();
	}

	$card_id = $db->real_escape_string($_POST['card_id']);
	$table = $db->real_escape_string($_POST['table']);
	$emp_id = $db->real_escape_string($_POST['emp_data_id']);



	if(!$employee = getEmployeeDataById($db,$table,$emp_id) ){

		setMsg("Can not get employee!!!",1);
		header('Location:'.BASE_URL."admin.php");
    	exit();	
	}

	if(!$card = getCardById($db,$card_id)){
		setMsg("Can not get card!!!",1);
		header('Location:'.BASE_URL."admin.php");
    	exit();	
	}

	if(empty($card['fields_styles'])){
		
		setMsg("Can not get card field layout!!!",1);
		header('Location:'.BASE_URL."admin.php");
    	exit();		
	}

	$show_field_label = $card['show_field_label'];

	updateEmployeeCardPrintStatus($db,$employee['id']);

	if(isset($_POST['duplicate']) && !empty($_POST['duplicate'])){

		$duplicate = $db->real_escape_string($_POST['duplicate']);
		
		updateEmployeeCardDuplicateStatus($db,$employee['id'],$duplicate);
	
	}

	// echo "<pre>";

	$fields = json_decode($card['fields_styles'],true);
	

	for($i=0;$i<count($fields);$i++){
		$fields[$i]['fieldValue'] = $employee[$fields[$i]['fieldName']];

		if($label = getFieldLabel($fields[$i]['fieldName'])){
			$fields[$i]['fieldLabel'] = $label;
		}
		else $fields[$i]['fieldLabel'] = '';
	}
	$fields = json_encode($fields);
	// print_r($fields);
	// exit();
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/idcard-view.css">
	<link rel="stylesheet" type="text/css" href="css/idcard-grid.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script type="text/javascript">
		let base_url = location.origin + '/idcard_system/'
	</script>

	<style type="text/css">		
		.front-page-img,.back-page-img{
			
			vertical-align: middle;
			width: 100%;
			/*height: 100%;*/
			/*width: <?= $card['width']?>;*/
			/*height: <?= $card['height']?>;*/

		}
		*{
			margin:0;
			padding: 0;
		}

		@media print{

			.card-size-form,nav{
				display: none;
			}
			@page{
				
				position:absolute;
				margin: 0;
				size:<?= $card['width']?> <?= $card['height']?>;
				color:white;
				/*font-size:8px;*/

			}	
		}
	</style>
</head>
<body>
	<div>
		<div class="id-card-view">
			<input type="hidden" id="card_id" name="card_id" value="2">
			<div class="id-card">
				<!-- FRONT PAGE -->
				<div class="front-page">
					<img class="front-page-img" src="<?= $card['front_file']?>">

				</div>	
				<!-- BACK PAGE -->
				<div class="back-page">
					<img class="back-page-img" src="<?=$card['back_file']?>">	
				</div>

			</div>	
		</div>
	</div>
	<script type="text/javascript">
		let show_field_label = "<?= $show_field_label?>"
		console.log(show_field_label)
		let data = JSON.parse('<?= $fields;?>');
		console.log(data)

		for(let i=0;i<data.length;i++){
			// let styles = ''
			let div;
			console.log(data[i])
			
			if(data[i].imageFlag == 0){

				if(show_field_label == 1){
					div = "<div class='card-fields-print field-"+i+"'>"+data[i].fieldLabel+" : "+data[i].fieldValue+"</div>"	
				}
				
				else div = "<div class='card-fields-print field-"+i+"'>"+data[i].fieldValue+"</div>"

				$('.front-page').append(div)

				$('.front-page .field-'+i).css({
					'position':'absolute',
					'width':data[i].width,
					'height': '6%'		
				})
			}

			if(data[i].imageFlag == 1){
				div = "<div class='card-fields-print field-"+i+"'><img src='"+data[i].fieldValue+"'></div>"	

				$('.front-page').append(div)

				$('.front-page .field-'+i).css({
					'position':'absolute',
					'padding':'3px'
					// 'width': '20%',
					// 'height': '6%'		
				})
				
				$('.front-page .field-'+i+' img').css({
					'width':data[i].imageWidth,
					'height':data[i].imageHeight,
					'position':'absolute'
				})

				
				
			
			}
			$('.front-page .field-'+i).css({

				'left':data[i].left,
				'top':data[i].top,	
				'position':'absolute',
				'textAlign':data[i].textAlign,
				'fontSize':data[i].fontSize,
				'color':data[i].fontColor
			})
				
			// console.log(div)
		}
		
		window.print()

		window.addEventListener('afterprint',function(){

			window.location = base_url+'admin.php'
		})
	</script>
</body>
</html>