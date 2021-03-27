$('#layout-editor-settings').draggable()

let cardFields;
let gridsForView;

let gridFieldName;
let gridSettings;
let gridFontSize;
let gridFontColor;
let gridPositionX;
let gridPositionY;
let gridWidth;
let gridTextAlignLeft;
let gridTextAlignCenter;
let gridTextAlignRight;
let gridImage;
let gridImageWidth;
let gridImageHeight;

let gridReserved;
let gridReservedFontSize = [];
let gridUseThisBtn;

let fieldSampleInputs;


let fields = [];


class Field{
	constructor(id){
		this.fieldName;
		this.id = id;
		this.fontSize;
		this.fontColor;
		this.width;
		this.left;
		this.top;
		this.textAlgin;
		this.imageFlag = 0;
		this.imageWidth;
		this.imageHeight;
		this.reservedFlag = 0;
	}
}

gridsForView = $(".card-fields")
gridFieldName = $(".grid-field-name")
gridSettings = $(".grid-settings")
gridFontSize = $(".grid-font-size")
gridFontColor = $('.grid-font-color')
gridPositionX = $(".pos-x")
gridPositionY = $(".pos-y")
gridWidth = $(".grid-width")
gridTextAlignLeft = $(".text-align-left")
gridTextAlignCenter = $(".text-align-center")
gridTextAlignRight = $(".text-align-right")
gridImage = $(".grid-image")
gridImageWidth = $(".grid-image-width")
gridImageHeight = $(".grid-image-height")

fieldSampleInputs = $(".field-sample-input")
gridUseThisBtn = $(".grid-use-this-btn")

let hideOtherGridSettings = function(){
	for(let i=0;i<gridSettings.length;i++){
		gridSettings[i].style.display = "none"
	}
}

let showGridSettings = function(index){
	gridSettings[index].style.display = "flex"
}

// ----------------------------------
// FUNCTIONS FOR GRID DISPLAY
let showAllGrids = function(){
	for(let i=0;i<gridsForView.length;i++){
		gridsForView[i].style.display="block"
		gridsForView[i].style.border="1px solid lightgrey"
	}
}
let hideAllGrids = function(){
	for(let i=0;i<gridsForView.length;i++){
	
	gridsForView[i].style.display="none"
	gridsForView[i].style.border="none"
	}
	$('.grid-reserved').css({'display':'block'})

}

let hideOnlyUnusedGrids = function(){
	for(let i=0;i<gridsForView.length;i++){
	
	gridsForView[i].style.display="none"
	gridsForView[i].style.border="none"
	}
	$('.grid-reserved').css({'display':'block','border':'1px solid darkred'})
}

$('#grid_show_all').on('change',function(event){
	showAllGrids()
})
$('#grid_hide_only_unused').on('change',function(event){
	hideOnlyUnusedGrids()
	
})
$('#grid_hide_all').on('change',function(event){
	hideAllGrids()
	
})

// ----------------------------------



// REMOVE SELECTION FROM ALL GRID
let removeSelectionFromAllCardFields = function(cardFields){


	for(let i=0;i<cardFields.length;i++){
		cardFields[i].style.border = "1px solid lightgrey";
		$(".card-fields:hover").css({'border':'2px solid black'})
	}
}

// SELECT GRID
let selectGrid = function(cardField){

	cardField.style.border = "2px solid darkred";

}

let reserveGrid = function(index){

	
	gridsForView[index].classList.add('grid-reserved')
	fields[index].reservedFlag = 1

	if(fields[index].reservedFlag){
		gridUseThisBtn[index].value = "Do not use this grid"
		
	}
	else{
		gridUseThisBtn[index].value = "Use this grid"
	}

}

let freeGrid = function(index){
	

	gridsForView[index].classList.remove('grid-reserved')
	fields[index].reservedFlag = 0	

	if(fields[index].reservedFlag){
		gridUseThisBtn[index].value = "Do not use this grid"
		
	}
	else{
		gridUseThisBtn[index].value = "Use this grid"
	}
}

let initFieldObjects = function(){
	// ----------------------------------------------
	// INITIALIZE FIELD
	// CREATING FIELD OBJECT CORRESPONDING TO ITS GRID
	for(let i=0;i<gridsForView.length;i++){
		fields.push(new Field(i));
	}
	// ----------------------------------------------

	init()	
}

let init = function(){
	for(let i=0;i<gridsForView.length;i++){
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
		fields[i].imageWidth = gridImageWidth[i].value + "px"
		// ----------------------------------------------

		// ----------------------------------------------
		// INITIALIZE FIELD IMAGE HEIGHT
		fields[i].imageHeight = gridImageHeight[i].value + "px"
		// ----------------------------------------------

		// ----------------------------------------------
		// INITIALIZE GRID USE
		gridUseThisBtn[i].value = "Use this grid"
		// ----------------------------------------------


		// EVENTS
		// ##############################################

		gridFieldName[i].addEventListener('change',function(){

			fields[i].fieldName = gridFieldName[i].value 

			reserveGrid(i)
		})
		// ----------------------------------------------
		// INITIALIZE GRID SELECTION FUNCTIONALITY
		gridsForView[i].addEventListener('click',function(event){
			
			removeSelectionFromAllCardFields(gridsForView)
			selectGrid(gridsForView[i])

			
			$("#grid_name").html(event.target.classList[1])

			
			hideOtherGridSettings()
			showGridSettings(i)
		})
		// ----------------------------------------------

		// ----------------------------------------------
		// INITIALIZE FIELD FONT COLOR INPUT FUNCTIONALITY
		gridFontColor[i].addEventListener('input',function(event){
			// FOR LAYOUT VIEW
			// ----------------------------------------------
			gridsForView[i].style.color = gridFontColor[i].value
			// ----------------------------------------------

			fields[i].fontColor = gridFontColor[i].value
		})
		// ----------------------------------------------
		
		// ----------------------------------------------
		// INITIALIZE FIELD FONT SIZE INPUT FUNCTIONALITY
		gridFontSize[i].addEventListener('change',function(event){
			// FOR LAYOUT VIEW
			// ----------------------------------------------
			gridsForView[i].style.fontSize = 'calc('+$("#points").val()+'*'+gridFontSize[i].value+')'
			// ----------------------------------------------

			fields[i].fontSize = gridFontSize[i].value
		})
		// ----------------------------------------------

		// ----------------------------------------------
		// INITIALIZE FIELD VALUE INPUT FUNCTIONALITY
		fieldSampleInputs[i].addEventListener('input',function(event){
			
			gridsForView[i].textContent = fieldSampleInputs[i].value

			if(gridsForView[i].textContent!=""){
				
				// ----------------------------------------------					
				// FOR LAYOUT VIEW RATIO
				gridsForView[i].style.fontSize = 'calc('+$("#points").val()+'*'+gridFontSize[i].value+')'
				// ----------------------------------------------
				
				// fields[i].fontSize = gridFontSize[i]

				// RESERVE GRID
				reserveGrid(i)
			}
		})
		// ----------------------------------------------

		// ----------------------------------------------
		// INITIALIZE FIELD POSITION X INPUT FUNCTIONALITY
		gridPositionX[i].addEventListener('input',function(){
			gridsForView[i].style.left = gridPositionX[i].value+'%'
			
			fields[i].left = gridPositionX[i].value+'%'

			// RESERVE GRID
			reserveGrid(i)
			
		})
		// ----------------------------------------------

		// ----------------------------------------------
		// INITIALIZE FIELD POSITION Y INPUT FUNCTIONALITY
		gridPositionY[i].addEventListener('input',function(){
			
			gridsForView[i].style.top = gridPositionY[i].value+'%'

			fields[i].top = gridPositionY[i].value+'%'

			// RESERVE GRID
			reserveGrid(i)
		})
		// ----------------------------------------------

		// ----------------------------------------------
		// INITIALIZE FIELD WIDTH INPUT FUNCTIONALITY
		gridWidth[i].addEventListener('change',function(event){
			gridsForView[i].style.width = gridWidth[i].value

			fields[i].width = gridWidth[i].value

			reserveGrid(i)
		})	
		// ----------------------------------------------

		// ----------------------------------------------
		// INITIALIZE FIELD TEXT ALIGN INPUT FUNCTIONALITY
		gridTextAlignLeft[i].addEventListener('input',function(event){
			gridsForView[i].style.textAlign = gridTextAlignLeft[i].value

			fields[i].textAlign = gridsForView[i].style.textAlign
		})	
		gridTextAlignCenter[i].addEventListener('input',function(event){
			gridsForView[i].style.textAlign = gridTextAlignCenter[i].value

			fields[i].textAlign = gridsForView[i].style.textAlign
		})	
		gridTextAlignRight[i].addEventListener('input',function(event){
			gridsForView[i].style.textAlign = gridTextAlignRight[i].value

			fields[i].textAlign = gridsForView[i].style.textAlign
		})
		// ----------------------------------------------

		// ----------------------------------------------
		// INITIALIZE FIELD IMAGE INPUT FUNCTIONALITY
		gridImage[i].addEventListener('change',function(){
			if(gridImage[i].value!='none'){
				gridsForView[i].innerHTML = "<img src='"+gridImage[i].value+"'>"
				fields[i].imageFlag = 1
				fields[i].imageWidth = gridsForView[i].children[0].style.width = gridImageWidth[i].value+"px"
				fields[i].imageHeight = gridsForView[i].children[0].style.height = gridImageHeight[i].value+"px"

				reserveGrid(i)
			}
			else{
				fields[i].imageFlag = 0 
				gridsForView[i].innerHTML = ""

				freeGrid(i)
			}
		})
		// ----------------------------------------------

		// ----------------------------------------------
		// INITIALIZE FIELD IMAGE WIDTH AND HEIGHT INPUT FUNCTIONALITY
		gridImageWidth[i].addEventListener('change',function(){

			// FOR LAYOUT VIEW
			// ----------------------------------------------
			gridsForView[i].children[0].style.width = 'calc('+$("#points").val()+'*'+gridImageWidth[i].value+')'
			// ----------------------------------------------

			fields[i].imageWidth = gridImageWidth[i].value + "px"

			reserveGrid(i)
			
		})
		gridImageHeight[i].addEventListener('change',function(){
			
			fields[i].imageHeight = gridsForView[i].children[0].style.height = gridImageHeight[i].value + "px"

			reserveGrid(i)
			
		})
		// ----------------------------------------------	

		// ----------------------------------------------
		// INITIALIZE GRID USE THIS BUTTON FUNCTIONALITY
		gridUseThisBtn[i].addEventListener('click',function(){

			if(fields[i].reservedFlag){
				gridUseThisBtn[i].value = "Use this grid"
				fields[i].reservedFlag = 0
				freeGrid(i)
			}
			else{
				gridUseThisBtn[i].value = "Do not use this grid"
				fields[i].reservedFlag = 1
				reserveGrid(i)
			}
			
		})
		// ----------------------------------------------

	}	
}



let cardLayoutWidth = $('.front-page-img,.back-page-img').css("width")
let cardLayoutHeight = $('.front-page-img,.back-page-img').css("height")




// PRINT
$('#btn-save').on('click',function(){
	/*
	$('#layout-editor-settings').hide()
	$('#btn-print').hide()

	// $('.id-card').css({'padding':'0'})
	
	$('.front-page,.back-page').css({'display':'flex'})
	$('.front-page .front-page-img').css({
		
		'height':'100%'
	})
    $('.back-page .back-page-img').css({
    	
    	'height':'100%'
    })
    $('.front-page-img,.back-page-img').css({
		'width':cardLayoutWidth,
		'height':cardLayoutHeight
	})
	
	for(let i=0;i<gridsForView.length;i++){
		gridsForView[i].style.fontSize = fields[i].fontSize
	}
	*/

	// window.print()
	let finalFields = []

	for(let i=0;i<fields.length;i++){
		if(fields[i].reservedFlag){

			if(fields[i].fieldName =="none"){
				alert("Please select Field properly !")
				return;
			}
			finalFields.push(fields[i])
		}
	}
	console.log(finalFields)

	$.post(
		'do_save_layout.php',
		{
			'data':finalFields,
			'card_id':$('#card_id').val(),
			'data_table':$('#data_table').val()
		},
		function(data){
			
			window.location = location.origin + '/idcard_system/admin.php';
			// console.log(JSON.parse(data))
		}

	)	
})
// !PRINT

let resizeCardLayout = function(size){

}




// Resize Layout
$('#points').on('change',function(){
	
	$('.front-page-img,.back-page-img').css({
		'width':'calc('+cardLayoutWidth+'*'+$('#points').val()+')',
		'height':'calc('+cardLayoutHeight+'*'+$('#points').val()+')'
	})

	for(let i=0;i<gridsForView.length;i++){
		gridsForView[i].style.fontSize = 'calc('+fields[i].fontSize+'*'+$('#points').val()+')'

		if(fields[i].imageFlag){
			gridsForView[i].children[0].style.width = 'calc('+fields[i].imageWidth+'*'+$('#points').val()+')'
			gridsForView[i].children[0].style.height = 'calc('+fields[i].imageHeight+'*'+$('#points').val()+')'	
		}
		
	}
	
})

window.addEventListener('afterprint', (event) => {
  location.reload(true)
});

initFieldObjects()

// console.dir(fields)
