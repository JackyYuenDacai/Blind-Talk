<?php
	$tok = "9d584597d1c7c0adaf7784c22ce1e7a3";
	include 'web_func.php';
	$ltime=NULL;
	$chquy=RecvChatQuery($tok,"Dacai",$ltime,3);
	$ltime=$chquy[0];
	setcookie("chat_cltime",$ltime);
	$msgs=$chquy;
	//print_r($msgs);
	for($t=count($msgs)-1;$t>=1;$t--){
		$ele=$msgs[$t];
		if($ele[0][4]==0)
			echo "<div class='text-left'>\n";
		else
			echo "<div class='text-right'>\n";
		for($i=0;$i<count($ele);$i++){
			//echo $i."  ".$ele[$i][2]."  ".$ele[$i][3];
			switch($ele[$i][2]){
				case 0:break;
				case 1:break;
				case 2:
					echo "<div>\n";
					echo $ele[$i][3];
					echo "</div>\n";break;
				default:break;
			}
		}
		//print_r($ele);
		echo "</div>";
	}
?>
