<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/idcard-view.css">
	<link rel="stylesheet" type="text/css" href="css/idcard-grid.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<style type="text/css">
		#layout-editor-settings{
			font-family: tahoma;
			border: 2px solid darkgrey;
			background-color: lightgrey;
			padding: 20px;
			position: absolute;
			/*UPDATE BELOW LINE*/
			top: 10px;
			width: 450px;
			height: 300px;
			overflow-y:scroll; 
			display: block;
			/*justify-content: center;*/
			/*flex-wrap: wrap;*/
			border-radius: 5px;
			opacity: .9;
		}

		.grid-settings{
			display: none;
			flex-wrap: wrap;

		}
		#layout-editor-settings input[type=button]{
			margin: 10px;
		}
		#layout-editor-settings label{
			font-size: 14px;
			padding: 5px;
		}
		/*
		#layout-editor-settings *{
			padding: 5px;
		}
		#layout-editor-settings input,#layout-editor-settings select{
			
			border:0px solid;
			border-radius: 2px;
		}
		
		#layout-editor-settings input:focus,#layout-editor-settings select:focus{
			outline: 0;
			border:3px solid darkgrey;
			
		}

		
		#btn-save{
			font-family: verdana;
			border:none;
			border-radius: 2px;
			background-color: forestgreen;
			color: white;
			padding: 10px;
		}
		#btn-save:hover{
			background-color: green;
		}
		#btn-save:focus{
			outline: 0;
			border:3px solid darkgreen;
		}
		.grid-use-this-btn{
			background-color: darkslategrey;
			color: white;
		}
		.grid-use-this-btn:hover{
			background-color: black;
		}
		.grid-use-this-btn:focus{
			border:2px solid black;
		}*/

	</style>
	
</head>
<body>
	<div class="id-card-view">
		<input type="hidden" id="card_id" name="card_id" value="2">
		<div class="id-card">
			<!-- FRONT PAGE -->
			<div class="front-page">
				<img class="front-page-img" src="img/Press-card-tahelka-front.jpg">
				
				<?php for($i=0;$i<40;$i++):?>
					<div class="card-fields grid-<?= $i+1?>"></div>
				<?php endfor;?>	
			</div>	
			<!-- BACK PAGE -->
			<div class="back-page">
				<img class="back-page-img" src="img/Press-card-tahelka-back.jpg">
				<?php for($i=40;$i<80;$i++):?>
					<div class="card-fields grid-<?= $i+1?>"></div>
				<?php endfor;?>	
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
					<option value="name">name</option>
					<option value="mobile">mobile</option>
					<option value="department">department</option>
					<option value="designation">designation</option>
					<option value="image">image</option>
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
					<option value="8px">8px</option>
					<option value="10px">10px</option>
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
				<input type="number" class="pos-x form-control" name="pos_x" min="0" max="100" value="0">
			</div>
			<div>
				<label>Position Y-axis:</label>
				<br>
				<input class="pos-y form-control" type="number" name="pos_y" min="0" max="100" value="0">
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
					<option value="sample_img/user2.jpg">Employee Image</option>
					<option value="sample_img/sign.jpeg">Signature Image</option>
				</select>
			</div>
			<div style="width: 100%;"></div>
			<div>
				<label>Image Width:</label>
				<br>
				<input type="range" class="grid-image-width form-control" name="grid_image_width" min="20" max="200" value="40">
				<br>
				<label>Image Height:</label>
				<br>
				<input type="range" class="grid-image-height form-control" name="grid_image_height" min="20" max="800" value="100">
			</div>
			
			<br>
			
			<div style="width: 100%;">
				<input class="btn grid-use-this-btn btn-dark" type="button" name="grid_use">
			</div>
			
		</div>
		<?php endfor;?>
		<button id="btn-save" class="btn btn-success">
			Save This Layout
		</button>
	</div>
	
	<script type="text/javascript" src="js/layout-editor.js">
	</script>
</body>
</html>