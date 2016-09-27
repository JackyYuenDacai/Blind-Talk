<?php
	include 'web_const.php';
	include 'web_func.php';
	$id=get_id_by_token($_POST['token']);
	if($id == null){
		echo "Negative Token Expired";
	}else{
 
		switch($_POST['sub-type']){
			case "entry":
				entrySave($_POST['token'],$id,$_POST['showto'],$_POST['content']);
				break;
			case "share":
				break;
			default:
                        	echo "Negative Error REQ";
                        	break;
		}
 
	}
?>
