<?php
	include 'web_const.php';
	include 'web_func.php';
	$tok=$_POST['token'];
	$id=get_id_by_token($_POST['token']);
	if(check_token($_POST['token'])==FALSE){
		echo "Negative Token Expired";
	}else{
 
		switch($_POST['req-type']){
			case "idc":
				$icpath=getuserIcon($id);
				$udes=getuserDesc($id);
				echo "Id=" . $id . "&Ico=" . $icpath . "&Des=" . $udes;
				break;
			case "notify":
				$usernot=getUserNot($_POST['token']);
				if($usernot[0]==1)echo "count=".$usernot[1]."&share=".$usernot[2]."&chat=".$usernot[3]."&other=".$usernot[4];
				break;
			case "add-friend":
				$fid=$_POST['fid'];
				UserBeFriend($tok,$fid);
				break;
			case "logoff":
				echo g_logoff($_POST['token']);
				break;
			default:
                        	echo "Negative Error REQ";
                        	break;
		}
 
	}
?>
