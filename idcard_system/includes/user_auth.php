<?php

/*
function isCompanySet(){
	if(isset($_SESSION['company'])&&!empty($_SESSION['company'])){
		return true;
	}
	return false;
}
*/


function isLoggedIn(){

	if(isset($_SESSION['user'])&&!empty($_SESSION['user'])){
		return true;
	}
	return false;
}

function setMsg($text,$error=0){
	$_SESSION['msg']['text']=$text;
	$_SESSION['msg']['err']=$error;
}

/*
function isSuperAdminLoggedIn(){

	if(isset($_SESSION['superadmin'])&&!empty($_SESSION['superadmin'])){
		return true;
	}
	return false;
}
*/

?>