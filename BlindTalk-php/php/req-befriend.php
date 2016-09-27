<?php
	include 'web_const.php';
	include 'web_func.php';
	$id=get_id_by_token($_POST['token']);
	if(check_token($_POST['token'])==FALSE){
		echo "Negative Token Expired";
	}else{
  
				$fid=$_POST['fid'];
				UserBeFriend($tok,$fid);
		 
	}
?>
