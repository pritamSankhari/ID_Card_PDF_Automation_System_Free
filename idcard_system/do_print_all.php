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

	$employees = getEmployeeDataWithNoIssue($db,$table);

	if(!is_array($employees)){

		setMsg("Can not get employee!!!",1);
		header('Location:'.BASE_URL."admin.php");
    	exit();	
	}

	if(empty($employees)){
		setMsg("Already printed!!!",1);
		header('Location:'.BASE_URL."show_all_records.php");
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

	foreach($employees as $employee){
		updateEmployeeCardPrintStatus($db,$employee['id']);
	}
	
	$fields_styles = $card['fields_styles'];
	$fields = json_decode($fields_styles,true);


	$show_field_label = $card['show_field_label'];

	$data = array();

	for($j=0;$j<count($employees);$j++){
		
		for($i=0;$i<count($fields);$i++){
			
			$field_name = $fields[$i]['fieldName'] ;
			$field_label = getFieldLabel($field_name);
			
			$data[$j][$field_name] = $employees[$j][$field_name];

			$data[$j][]=$field_label;
			// $data[$j]['fieldLabel'] = $field_label;
			// echo $data[$j]['fieldLabel'];

		}
	}

	// echo "<pre>";
	// print_r($data);
	

	// echo "<pre>";
	// print_r($data);

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
		<?php $i=0;?>
		<?php foreach($data as $employee):?>
			
		<div class="id-card-view">
			<input type="hidden" id="card_id" name="card_id" value="2">
			<div class="id-card">
				<!-- FRONT PAGE -->
				<div class="front-page">
					<img class="front-page-img" src="<?= $card['front_file']?>">
					
					<?php for($j=0;$j<count($fields);$j++):?>
						<?php if($fields[$j]['imageFlag']):?>
							
							<div class="card-fields-print field-<?=$j?>">
								<img src="<?= $employee[$fields[$j]['fieldName']]?>">
							</div>	

						<?php else:?>	

							<?php if((int)$show_field_label):?>

							<div class="card-fields-print field-<?= $j?>"><?= $employee[$j]." : ".$employee[$fields[$j]['fieldName']]?></div>
							<?php else:?>

							<div class="card-fields-print field-<?= $j?>"><?= $employee[$fields[$j]['fieldName']]?></div>

							<?php endif;?>

						<?php endif;?>

					<?php endfor;?>	
				</div>	
				<!-- BACK PAGE -->
				<div class="back-page">
					<img class="back-page-img" src="<?=$card['back_file']?>">	
				</div>

			</div>	
		</div>
		<?php $i++;?>
		<?php endforeach;?>
	</div>
	<script type="text/javascript">
		let employees = JSON.parse('<?= json_encode($data)?>');
		let fields_styles = JSON.parse('<?= $fields_styles?>');
		
		// console.log(fields_styles)


		for(let i=0;i<fields_styles.length;i++){

			// console.log(fields_styles[i])
			if(fields_styles[i].imageFlag == 0){
				
				$('.front-page .field-'+i).css({
					'position':'absolute',
					'width':fields_styles[i].width,
					'height': '6%'		
				})
			}

			if(fields_styles[i].imageFlag == 1){
				
				
				$('.front-page .field-'+i+' img').css({
					'width':fields_styles[i].imageWidth,
					'height':fields_styles[i].imageHeight,
					'position':'absolute',
					
				})
				$('.front-page .field-'+i).css({
					'padding':'3px'
				})
			}

			$('.front-page .field-'+i).css({

				'left':fields_styles[i].left,
				'top':fields_styles[i].top,	
				// 'position':'absolute',
				'textAlign':fields_styles[i].textAlign,
				'fontSize':fields_styles[i].fontSize,
				'color':fields_styles[i].fontColor
			})

			console.log(i)
		}

		window.print()

		window.addEventListener('afterprint',function(){

			window.location = base_url+'admin.php'
		})
	</script>
</body>
</html>
