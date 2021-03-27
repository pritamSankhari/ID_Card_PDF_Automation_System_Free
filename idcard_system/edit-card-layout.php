<?php
	session_start();
	require 'config/url.php';
	require 'config/db.php';
	require 'includes/user_auth.php';

	if(!isLoggedIn()){
		header('Location:'.BASE_URL."login.php");
    	exit();
	}

	if(!isset($_GET['card_id'])||empty($_GET['card_id'])){
		header('Location:'.BASE_URL."add_card.php");
    	exit();
	}

	$sql = "SELECT *  FROM company WHERE id = ".$_SESSION['user']['company_id'];
	if($res = $db->query($sql)){
		if($res->num_rows>0){

			$company = $res->fetch_assoc();
		}
		else{
			$_SESSION['msg']['text']='Company Not Selected !';
			$_SESSION['msg']['err']=1;
			header('Location:'.BASE_URL."admin.php");
    		exit();
		}
	}

	$sql = "show columns from ".$company['data_table'];
	if($res = $db->query($sql)){
		if($res->num_rows>0){

			$field_names = array();
			while($row = $res->fetch_assoc()){
				$field_names[] = $row;	
				// echo "<script>alert('oops')</script>";
			}
			
		}
	}



	$sql = "SELECT * FROM cards WHERE id = ".$_GET['card_id'];
	if($res = $db->query($sql)){
		if($res->num_rows>0){

			$card = $res->fetch_assoc();
		}
		else{
			$_SESSION['msg']['text']='Card does not exist!';
			$_SESSION['msg']['err']=1;
			header('Location:'.BASE_URL."add_card.php");
    		exit();
		}
	}

	$fields_styles = $card['fields_styles'];
	$fields = json_decode($fields_styles,true);
	// echo "<pre>";
	// print_r($fields);

?>
<?php require 'includes/header_admin.php';?>

<style type="text/css" id="page-preview">
.front-page-img,.back-page-img{
	
	height: <?= $card['height']?>;
	width: <?= $card['width']?>;

}

</style>

	<section class='main'>
	<?php require 'includes/msg.php';?>
	<div class="id-card-view">
		<input type="hidden" id="card_id" name="card_id" value="<?= $card['id']?>">
		<input type="hidden" id="data_table" name="data_table" value="<?= $company['data_table']?>">

		<div class="id-card">
			<!-- FRONT PAGE -->
			<div class="front-page">
				<img class="front-page-img" src="<?= $card['front_file']?>">
				
				<?php for($i=0;$i<80;$i++):?>
					<div class="card-fields grid-<?= $i+1?>"></div>
				<?php endfor;?>	
			</div>	
			<!-- BACK PAGE -->
			<div class="back-page">
				<img class="back-page-img" src="<?=$card['back_file']?>">
				<!-- <?php for($i=40;$i<80;$i++):?>
					<div class="card-fields grid-<?= $i+1?>"></div>
					<?php endfor;?>	 -->
			</div>

		</div>	
	</div>
	
	<div id="layout-editor-settings">
		<div>
			<h2>Card Field Editor</h2>
		</div>
		<div>
			<label for="points"><h3>Resize Layout</h3></label>
			<input type="range" id="points" name="points" min="1" max="4" value="1">
		</div>
		
		<div>
			<input type="radio" id="grid_show_all" name="grid_display" value="show_all" checked>
			<label for="grid_show_all">Show all grids</label>
			<br>
			<input type="radio" id="grid_hide_only_unused" name="grid_display" value="hide_only">
			<label for="grid_hide_only_unused">Show Only Reserved Grid(s)</label>
			<br>
			<input type="radio" id="grid_hide_all" name="grid_display" value="hide_all">
			<label for="grid_hide_all">Hide all grids</label>
		</div>
		<div>
			<h3 id="grid_name" class="grid-name"></h3>
		</div>
		
		<?php for($i=0;$i<80;$i++):?>
		<div class="grid-settings">
			
			<div>
				<h3>Please select the field first</h3>
				<label>Field:</label>
				<br>
				<select class="grid-field-name form-control">
					<option value="none">none</option>
					<?php foreach($field_names as $field):?>
						<option value="<?= $field['Field']?>"><?= $field['Field']?></option>
					<?php endforeach;?>
				</select>
			</div>
			<div>
				<label for="field_sample_input">Field Value:</label>
				<br>
				<input class="field-sample-input form-control" type="text" name="field_value">
			</div>
			<div>
				<label>Font Size:</label>
				<br>
				<select class="grid-font-size form-control">
					<option value="6px">6px</option>
					<option value="7px">7px</option>
					<option value="8px">8px</option>
					<option value="9px">9px</option>
					<option value="10px">10px</option>
					<option value="11px">11px</option>
					<option value="12px">12px</option>
					<option value="14px">14px</option>
					<option value="16px">16px</option>
					<option value="18px">18px</option>
					<option value="20px">20px</option>
				</select>
			</div>
			<div>
				<label>Font Color:</label>
				<br>
				<input type="color" class="grid-font-color form-control" name="font_color" value="#2F4F4F">
			</div>
			<br>
			<div>
				<label>Position X-axis:</label>
				<br>
				<input type="number" class="pos-x form-control" name="pos_x" min="0" max="200" value="0">
			</div>
			<div>
				<label>Position Y-axis:</label>
				<br>
				<input class="pos-y form-control" type="number" name="pos_y" min="0" max="200" value="0">
			</div>
			<div>
				<label>Width:</label>
				<br>
				<select class="grid-width form-control">
					<option value="20%">20%</option>
					<option value="40%">40%</option>
					<option value="60%">60%</option>
					<option value="80%">80%</option>
					<option value="100%">100%</option>
				</select>
			</div>
			<br>
			<div style="width: 100%;">
				<label>Text Align:</label>
				
				<br>
				<input id="text_align_left" class="text-align-left" type="radio" name="text_align" value="left">
				<label for="text_align_left">Left</label>
				<br>

				<input id="text_align_center" class="text-align-center" type="radio" name="text_align" value="center">
				<label for="text_align_center">Center</label>
				<br>

				<input id="text_align_right" class="text-align-right" type="radio" name="text_align" value="right">
				<label for="text_align_right" text_align_left>Right</label>
				
			</div>
			<div>
				<label>Image Field:</label>
				<br>
				<select class="grid-image form-control">
					<option value="none">None</option>
					<!-- <option value="sample_img/user.png">Employee Image</option>
					<option value="sample_img/user1.jpg">Employee Image</option> -->
					<option value="sample_img/user3.jpg">Employee Image</option>
					<option value="sample_img/qr.png">QR Image</option>
					<option value="sample_img/sign.jpeg">Signature Image</option>
				</select>
			</div>
			<div style="width: 100%;"></div>
			<div>
				<label>Image Width:</label>
				<br>
				<input type="range" class="grid-image-width form-control" name="grid_image_width" min="1" max="100" value="20">
				<br>
				<label>Image Height:</label>
				<br>
				<input type="range" class="grid-image-height form-control" name="grid_image_height" min="1" max="150" value="30">
			</div>
			
			<br>
			
			<div style="width: 100%;">
				<input class="btn grid-use-this-btn btn-dark" type="button" name="grid_use">
			</div>
			
		</div>
		<?php endfor;?>
		

		<label>Show Field Label</label>
		<input type="radio" id="show_field_label_on" name="show_field_label" value="1">
		<label>ON</label>

		<input type="radio" id="show_field_label_off" name="show_field_label" value="0">
		<label>OFF</label>

		<button id="btn-save" class="btn btn-success">
			Save This Layout
		</button>
	</div>
	
	<script type="text/javascript" src="js/layout-editor.js">
	</script>
	<script type="text/javascript">
		
		let data = JSON.parse('<?= json_encode($fields);?>');
		console.log(data)
		for(let i=0;i<data.length;i++){
			// console.log(data[i])
			// $('.front-page .grid-'+data[i].id).text(data[i].fieldName)
		}

		for(let i=0;i<gridsForView.length;i++){
			
			for(let j=0;j<data.length;j++){

				if(i==data[j].id){
					console.log(data[j].id)
					// ----------------------------------------------
					// INITIALIZE FIELD NAME
					console.log(data[j].fieldName)

					fields[i].fieldName = gridFieldName[i].value = data[j].fieldName
					// console.log(gridFieldName[i].value)
					// gridFieldName[i].value="name"
					// console.log(fields[i].fieldName)
					// ----------------------------------------------

					// ----------------------------------------------
					// INITIALIZE FIELD FONT SIZE
					fields[i].fontSize = gridFontSize[i].value = data[j].fontSize
					// ----------------------------------------------

					// ----------------------------------------------
					// INITIALIZE FIELD FONT SIZE
					fields[i].fontColor = gridFontColor[i].value = data[j].fontColor
					// ----------------------------------------------

					// ----------------------------------------------
					// INITIALIZE FIELD WIDTH
					fields[i].width = gridWidth[i].value = data[j].width
					// ----------------------------------------------

					// ----------------------------------------------
					// INITIALIZE FIELD TEXT ALIGN
					// gridTextAlignCenter[i].checked = true
					fields[i].textAlign = data[j].textAlign
					// ----------------------------------------------
					
					// ----------------------------------------------
					// INITIALIZE FIELD POSITION
					let gridX = parseInt(data[j].left)
					let cardWidth = parseInt($('.front-page-img').css('width'))
					let gridY = parseInt(data[j].top)
					let cardHeight = 2*parseInt($('.front-page-img').css('height'))

					gridPositionX[i].value = parseInt(gridX/cardWidth*100)
					fields[i].left = gridPositionX[i].value + '%'
					
					gridPositionY[i].value = parseInt(gridY/cardHeight*100)
					fields[i].top = gridPositionY[i].value + '%'
					// ----------------------------------------------
					
					// ----------------------------------------------
					// INITIALIZE FIELD IMAGE WIDTH
					gridImageWidth[i].value = data[j].imageWidth
					fields[i].imageWidth = gridImageWidth[i].value + "mm"
					// ----------------------------------------------

					// ----------------------------------------------
					// INITIALIZE FIELD IMAGE HEIGHT
					gridImageHeight[i].value = data[j].imageHeight
					fields[i].imageHeight = gridImageHeight[i].value + "mm"
					// ----------------------------------------------

					// ----------------------------------------------
					// INITIALIZE GRID USE
					gridUseThisBtn[i].value = "Use this grid"
					// ----------------------------------------------
				}
				else{
					// ----------------------------------------------
					// INITIALIZE FIELD NAME
					fields[i].fieldName = gridFieldName[i].value = "none"
					// ----------------------------------------------

					// ----------------------------------------------
					// INITIALIZE FIELD FONT SIZE
					fields[i].fontSize = gridFontSize[i].value = '14px'
					// ----------------------------------------------

					// ----------------------------------------------
					// INITIALIZE FIELD FONT SIZE
					fields[i].fontColor = gridFontColor[i].value
					// ----------------------------------------------

					// ----------------------------------------------
					// INITIALIZE FIELD WIDTH
					fields[i].width = gridWidth[i].value = '20%'
					// ----------------------------------------------

					// ----------------------------------------------
					// INITIALIZE FIELD TEXT ALIGN
					gridTextAlignCenter[i].checked = true
					fields[i].textAlign ='center'
					// ----------------------------------------------
					
					// ----------------------------------------------
					// INITIALIZE FIELD POSITION
					let gridX = parseInt($('.grid-'+(i+1)).css('left'))
					let cardWidth = parseInt($('.front-page-img').css('width'))
					let gridY = parseInt($('.grid-'+(i+1)).css('top'))
					let cardHeight = 2*parseInt($('.front-page-img').css('height'))

					gridPositionX[i].value = parseInt(gridX/cardWidth*100)
					fields[i].left = gridPositionX[i].value + '%'
					
					gridPositionY[i].value = parseInt(gridY/cardHeight*100)
					fields[i].top = gridPositionY[i].value + '%'
					// ----------------------------------------------
					
					// ----------------------------------------------
					// INITIALIZE FIELD IMAGE WIDTH
					fields[i].imageWidth = gridImageWidth[i].value + "mm"
					// ----------------------------------------------

					// ----------------------------------------------
					// INITIALIZE FIELD IMAGE HEIGHT
					fields[i].imageHeight = gridImageHeight[i].value + "mm"
					// ----------------------------------------------

					// ----------------------------------------------
					// INITIALIZE GRID USE
					gridUseThisBtn[i].value = "Use this grid"
					// ----------------------------------------------
				}
			}	
		}


	</script>


	</section>
<?php require 'includes/footer_admin.php';?>