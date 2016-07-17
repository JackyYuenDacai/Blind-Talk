<?php
	include 'web_const.php';
	//echo $_POST['id'];
	//echo $_POST['pwd'];
	//echo $_POST['des'];

	$conn=mysql_connect($mysql_server, $mysql_user,$mysql_pwd);
	$sqlstr= "call user_sign('" . $_POST['id']. "','". $_POST['pwd']. "','" . $_POST['des']. "');";
	$result=mysql_db_query($mysql_db,$sqlstr, $conn);
	if( mysql_result($result,0,'res') == 0 ){
		echo "0";
	}else echo "1";
	mysql_free_result($result); 
	mysql_close($conn);  
?>
