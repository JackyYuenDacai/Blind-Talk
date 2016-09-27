<?php
	include 'web_const.php';
	include 'web_func.php';

	$aud0="<audio src='";	$aud1="'preload='auto' controls></audio>";
	$img0="<a href='"; $img1="'  data-lightbox='"; $img2="'><img style='width:auto;height:auto' alt='image with rounded corners' class='img-rounded carousel-inner' src='";$img3="' /></a>";
	$tok=$_POST['token'];
	$id=get_id_by_token($_POST['token']);
	if($id == null){
		echo "Negative Token Expired";
	}else{

	$lkey=$_POST['lkey'];
	$ldtime=$_POST['ldtime'];
	$encount=$_POST['count'];
	$fid=$_POST['fid'];
	if($fid==null)exit(0);

	if($ldtime=='0')$ldtime=null;

	$ldtime=str_replace("+"," ",$ldtime);
	$chquy=RecvChatQuery($tok,$fid,$ldtime,$encount);
	$ldtime=$chquy[0];
	setcookie("chat_cltime",$ldtime);
	$msgs=$chquy;
	//print_r($msgs);
	$alc=count($msgs);
	//echo $alc;echo "\n";
	for($t=1;$t<$alc;$t++){
		$ele=$msgs[$t];
		$ldtime=$ele[0][1];
		$lkey=$ele[0][5];
	//echo  $ele[0][4];
		if($ele[0][4]==0)
			echo "<div class='text-left' style='float:left; width:45%;margin-top:1%;margin-left:3%;margin-right:3%;font-size:23px;'>\n";
		else
			echo "<div class='text-right' style='float:right ;width:45%;margin-top:1%;margin-left:3%;margin-right:3%;font-size:23px;'>\n";

		for($i=0;$i<count($ele);$i++){
			//echo $i."  ".$ele[$i][2]."  ".$ele[$i][3];
			switch($ele[$i][2]){
				case 0:echo get_file($_POST['token'],$ele[$i][3]);break;
				case 1:echo $img0.get_file($_POST['token'],$ele[$i][3]).$img1.$ele[$i][5].$img2.get_file($_POST['token'],$ele[$i][3]).$img3;break;
				case 3:echo $aud0.get_file($_POST['token'],$ele[$i][3]).$aud1;break;
				case 2:
					echo "<div style='margin-left:3%;margin-right:3%;font-size:23px;'>\n";
					echo $ele[$i][3];
					echo "</div>\n";break;
				default:break;
			}
		}
		//print_r($ele);
		echo "</div>";
	}
	if($alc>=2){
		setcookie("chat_laskey",$lkey,time()+3600,'/');
		setcookie("chat_cltime",$ldtime,time()+3600,'/');
	}
	}
?>
