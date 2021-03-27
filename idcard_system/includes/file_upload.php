<?php



if(!defined('EMP_PHOTO_DIR')) define('EMP_PHOTO_DIR','emp_img/');
if(!defined('EMP_SIGN_DIR')) define('EMP_SIGN_DIR','emp_sign/');

	function uploadEmployeePhoto($file,$table_name){

		error_reporting(E_ALL);
		$source = $file['tmp_name'];
		$target = EMP_PHOTO_DIR.$table_name."_".$file['name'];
		if(move_uploaded_file($source, $target)){
			return $target;
		}
		else return 0;
	}

	function uploadEmployeeSignature($file,$table_name){

		$source = $file['tmp_name'];
		$target = EMP_SIGN_DIR.$table_name."_".uniqid()."_".$file['name'];



		switch($file['type']){

			case 'image/jpeg':
				$ext = 'jpeg';
				header('Content-type:image/jpeg');
				$img = imagecreatefromjpeg($file['tmp_name']);
				break;

			case 'image/png':
				$ext = 'png';
				header('Content-type:image/png');
				$img = imagecreatefrompng($file['tmp_name']);
				break;	
			default:
				$ext = ''	;
		}
		
		// GET NEW SIZES
		list($width,$height) = getimagesize($file['tmp_name']);
		$newwidth = 30*10; 
		$newheight = 30*3;

		// LOAD
		$dest = imagecreatetruecolor($newwidth, $newheight);

		// RESIZE
		imagecopyresized($dest, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

		switch($ext){
			
			case 'jpeg':
				imagejpeg($dest,$target);
				break;

			case 'png':
				imagepng($dest,$target);
				break;

			default:
				$target = 0	;

		}

		return $target;
		// if(move_uploaded_file($source, $target)){
		// 	return $target;
		// }
		// else return 0;
	}


?>