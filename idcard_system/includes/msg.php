<?php if(isset($_SESSION['msg'])):?>
	<?php if(!$_SESSION['msg']['err']):?>
		
		<div class="list-group-item list-group-item-success"><?=$_SESSION['msg']['text']?></div>
	
	<?php else:?>
		<div class="list-group-item list-group-item-danger"><?=$_SESSION['msg']['text']?></div>
	<?php endif;?>
<?php endif;?>
<?php unset($_SESSION['msg']);?>