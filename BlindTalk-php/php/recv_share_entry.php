<?php
	include 'web_const.php';
	include 'web_func.php';
	$aud0="<audio src='";	$aud1="' preload='auto' controls></audio>";
	$img0="<a href='"; $img1="'  data-lightbox='"; $img2="'><img  alt='image with rounded corners' class='carousel-inner img-rounded ' src='";$img3="' /></a>";
	$tok=$_POST['token'];
	$id=get_id_by_token($_POST['token']);
	if($id == null){
		echo "Negative Token Expired";
	}else{
	$towho=$_POST['towho'];
	$lkey=$_POST['lkey'];
	$ldtime=$_POST['ldtime'];
	$encount=$_POST['count'];
	//$ldtime=$_COOKIE['share_sltime'];
	//$
	//echo print_r($_POST);
	//echo print_r($_COOKIE);
	
	if($ldtime=='0')$ldtime=null;
	$ldtime=str_replace("+"," ",$ldtime);
	//echo $ldtime.$lkey;
	$enlist=RecvEntryQuery($tok,$towho,$lkey,$ldtime,$encount);
	$ldtime=$enlist[0];
	//print_r($enlist);
	$msgs=$enlist;
	//$lkey=$enlist[1][1][5];
	 
	//setcookie("share_laskey",$lkey);
	//setcookie("share_sltime",$ldtime);
	$alc=count($msgs);
	for($t=1;$t<$alc;$t++){
		$ele=$msgs[$t];
		//print_r($ele);
		//if($ele[0][4]==0)
		//	echo "<div class='text-left'>\n";
		//else
		//	echo "<div class='text-right'>\n";
		$ldtime=$ele[1][1];
	$lkey=$ele[1][5];
		echo "<div class='panel panel-default'>";
		echo "<div class='panel-heading container-fluid'>";
		echo "<h3 class='panel-title'><div class='text-left'>\n";
		echo $ele[1][4];echo "</div><div class='text-right'>\n";echo $ldtime;
		echo"</div></h3></div><div class='panel-body'>";
		for($i=0;$i<count($ele);$i++){
			//echo $i."  ".$ele[$i][2]."  ".$ele[$i][3];
			switch($ele[$i+1][2]){
				case 0:echo get_file($_POST['token'],$ele[$i+1][3]);break;
				case 1:echo $img0.get_file($_POST['token'],$ele[$i+1][3]).$img1.$ele[$i+1][5].$img2.get_file($_POST['token'],$ele[$i+1][3]).$img3;break;
				case 3:echo $aud0.get_file($_POST['token'],$ele[$i+1][3]).$aud1;break;
				case 2:
					echo "<div style='margin-left:3%;margin-right:3%;font-size:23px;'>\n";
					echo $ele[$i+1][3];
					echo "</div>\n";break;

				default:break;
			}
		}
	
		echo "</div></div>";
	}
	if($alc>=2){
		setcookie("share_laskey",$lkey,time()+3600,'/');
		setcookie("share_sltime",$ldtime,time()+3600,'/');
	}
	}
?>
