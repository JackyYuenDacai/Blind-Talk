<?php
	include '../php/web_func.php';

	$holdarr=getuserflist($_COOKIE['token']);
	if (isset($_COOKIE["chat_fId"]))
		$select = $_COOKIE['chat_fId'];
	else{
		$select = $holdarr[0][1];
		setcookie("chat_fId",$select);
	}
	setcookie("chat_fId",$select,'/');
	foreach($holdarr as $frd){
		echo  "<li style='border-radius: 6px;background-color:";
		if($frd[0]==0)echo "#666";
		else echo "#EEE";
		echo "'>";
		echo "<a class='text-center' style='font-size:20px;border-radius: 6px;' onclick=\"chat_f_selected('" .$frd[1]."')\" ><i class='icon-chevron-right'></i>".$frd[1]."</a></li>\n";
	}
?>
