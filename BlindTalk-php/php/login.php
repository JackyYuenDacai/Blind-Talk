<?php
	include 'web_const.php';
	include 'web_func.php';
	//echo $_POST['id'];
	//echo $_POST['pwd'];
	//echo $_POST['des'];

	$conn=mysql_connect($mysql_server, $mysql_user,$mysql_pwd);
	$sqlstr= "call ver_login('" . $_POST['id']. "','". $_POST['pwd']."');";
	$result=mysql_db_query($mysql_db,$sqlstr, $conn);
	if( mysql_result($result,0,'res') == 0 ){
		echo "0";
	}else {
		$token=mysql_result($result,0,'token');
		echo "1";
		echo $token;
		//apc_add
	}
	mysql_free_result($result); 
	mysql_close($conn);  
?>
