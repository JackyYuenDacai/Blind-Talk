<?php
	include 'web_const.php';
	include 'web_func.php';
	$allowedExts = array("gif", "jpeg", "jpg", "png","mp3","acc");
	$temp = explode(".", $_FILES["file"]["name"]);
	$id=get_id_by_token($_COOKIE['token']);
	$extension = end($temp);     
	$fileret=md5($_FILES["file"]["name"] . random_str(10) ) . "." . $extension;
	if (in_array($extension, $allowedExts))
	{
		if ($_FILES["file"]["error"] > 0)
		{
			echo "{\"code\":0, \"message\":\"Negative Error!\"}"; 
		}
		else
		{

			if (file_exists("../data/user_data/" . base64_encode($id) . "/" . $fileret))
			{
				echo "{\"code\":0, \"message\":\"". "Negative File Existed".$_FILES["file"]["name"]."\"}";    
			}
			else
			{
				move_uploaded_file($_FILES["file"]["tmp_name"], "../data/user_data/" . base64_encode($id) . "/" .$fileret);
				$fpath="/data/user_data/" . base64_encode($id) . "/" .$fileret;
				switch($extension){
					case "txt":case"doc":case "bat":$ftype=2;break;
					case "jpeg":case "jpg":case "gif":case "png":$ftype=1;break;
					case "mp3":$ftype=3;break;
					default: $ftype=4;break;
				}
				$keycode=register_file($_COOKIE['token'],$fpath,$extension,$ftype);
				echo "{\"code\":1, \"type\":". $keycode[1].",\"key\":\"". $keycode[0]."\"}";  
			}
		}
	}
	else
	{
		echo "{\"code\":0, \"message\":\"Negative File Type Ilegal\"}";   
	}
?>

