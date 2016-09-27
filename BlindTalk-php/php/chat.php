<?php
	include 'web_const.php';
	include 'web_func.php';
	$id=get_id_by_token($_POST['token']);
	if($id == null){
		echo "Negative Token Expired";
	}else{
 
		switch($_POST['req-type']){
			case "send":
				//print_r($_POST['content']['adds_array']);
				chatSend($_POST['token'],$_POST['to'],$_POST['content']);
				break;
			default:
                        	echo "Negative Error REQ";
                        	break;
		}
 
	}
?>
