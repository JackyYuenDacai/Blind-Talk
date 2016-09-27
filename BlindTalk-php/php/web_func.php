<?php
function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[rand(0, $max)];
    }
    return $str;
}
function enlong_token($id,$tok){
	include 'web_const.php';
	$res=0;
	$conn=mysql_connect($mysql_server, $mysql_user,$mysql_pwd);
	$sqlstr= "call enlong_token('" . $id. "','". $tok."');";
	$result=mysql_db_query($mysql_db,$sqlstr, $conn);
	if( mysql_result($result,0,'res') == 0 ){
		$res=0;
	}else {
		$res=1;
	}
	mysql_free_result($result); 
	mysql_close($conn);  
	return $res;
}
function check_token($tok){
	if(enlong_token(get_id_by_token($tok),$tok)==0)return FALSE;
	else return TRUE;
}
function get_id_by_token($tok){
	include 'web_const.php';
	$conn=mysql_connect($mysql_server, $mysql_user,$mysql_pwd);
	$sqlstr= "call getIdByToken('" .$tok."');";
	//echo $sqlstr;
	$result=mysql_db_query($mysql_db,$sqlstr, $conn);
	$res=mysql_result($result,0,'res');
	//echo $res;
	//echo '</br>';
	if( $res== 0 ){
		$res='0';
	}else {
		$res=mysql_result($result,0,'id');
	}
	mysql_free_result($result); 
	mysql_close($conn);  
	return $res;
}
function getuserIcon($id){
	include 'web_const.php';
	$conn=mysql_connect($mysql_server, $mysql_user,$mysql_pwd);
	$sqlstr= "call get_user_icon('" . $id."');";
	//echo $sqlstr;
	$result=mysql_db_query($mysql_db,$sqlstr, $conn);
	$res=mysql_result($result,0,'res');
	
	//echo '</br>';
	if( $res== "0" ){
		$res='0';
	}else {
		$res=mysql_result($result,0,'res');
	}
	mysql_free_result($result); 
	mysql_close($conn);  
	return $res;
}
function getuserDesc($id){
	include 'web_const.php';
 
	$conn=mysql_connect($mysql_server, $mysql_user,$mysql_pwd);
	$sqlstr= "call get_user_des('" . $id."');";
	//echo $sqlstr;
	$result=mysql_db_query($mysql_db,$sqlstr, $conn);
	$res=mysql_result($result,0,'res');
	
	//echo '</br>';
	if( $res == "0" ){
		$res='0';
	}else {
		$res=mysql_result($result,0,'res');
	}
	mysql_free_result($result); 
	mysql_close($conn);  
	return $res;
}
function getuserflist($tok){
	include 'web_const.php';
	if(check_token($tok)){
		
		$id=get_id_by_token($tok);
		$conn=mysql_connect($mysql_server, $mysql_user,$mysql_pwd);
		$sqlstr= "call getFriendList('" .$id."',12);";
		
		//echo $sqlstr;
		$result=mysql_db_query($mysql_db,$sqlstr, $conn);
		 
 		
		//print_r($res);
		$reslist= array();
		while(1){
			$res=mysql_fetch_row($result);
			if($res==false)break;
			array_push($reslist,$res);
		}
		mysql_free_result($result); 
		mysql_close($conn);  
		return $reslist;
	}else{
	return array(0);
	}
}

function getUserNot($tok){
	include 'web_const.php';
	if(check_token($tok)){
		$id=get_id_by_token($tok);
		$conn=mysql_connect($mysql_server, $mysql_user,$mysql_pwd);
		$sqlstr= "call get_user_nots('" .$tok."');";
		
		//echo $sqlstr;
		$result=mysql_db_query($mysql_db,$sqlstr, $conn);
		$res=mysql_fetch_row($result);
		mysql_free_result($result); 
		mysql_close($conn);  
		return $res;
	}else{
		return array(0);
	}
}
function getUniTime(){
	include 'web_const.php';
	$conn=mysql_connect($mysql_server, $mysql_user,$mysql_pwd);
	$sqlstr= "call get_uni_code_time('" .rand()."');";
	$reslist= array();
	$result=mysql_db_query($mysql_db,$sqlstr, $conn);
	array_push($reslist,mysql_result($result,0,'unicode'));
	array_push($reslist,mysql_result($result,0,'time'));
	mysql_free_result($result); 
	mysql_close($conn);  
	return $reslist;
}
function chatSend($tok,$id,$content){
	include 'web_const.php';
	if(check_token($tok)){
		$uatime=getUniTime();
		 
		$conn=mysql_connect($mysql_server, $mysql_user,$mysql_pwd);
		foreach($content as $msg){
				$sqlstr= "call upl_chat_record('" .$tok."','".$id."',".$msg[0].",'".$msg[1]."','".$msg[2]."','".$uatime[1]."','".$uatime[0]."');";
				echo $sqlstr."</br>";
				mysql_db_query($mysql_db,$sqlstr, $conn);

		}
		mysql_close($conn);  
	}else{
	return false;
	}
}
//create procedure get_chat_record(token varchar(256),fId varchar(64),btime datetime)
function RecvChat($tok,$id,$time){
	include 'web_const.php';
	if(check_token($tok)){
		if ($time==NULL)
			$time=getUniTime()[1];
		
		$conn=mysql_connect($mysql_server, $mysql_user,$mysql_pwd);
		$sqlstr= "call get_chat_record('" .$tok."','".$id."','".$time."');";
		//echo $sqlstr;
		$result=mysql_db_query($mysql_db,$sqlstr, $conn);
		$reslist = array();
		while(1){
			$res=mysql_fetch_row($result);
			//echo print_r($res);
			if($res==false)break;
			array_push($reslist,$res);
		}
		//echo "count:".count($reslist)."\n";
		if(count($reslist)!=0){
			
			$time=$reslist[0][1]; 
			//print_r($reslist);
			//array_unshift($reslist,$reslist[0][1]);
			mysql_free_result($result); 
			mysql_close($conn);  
			//print_r($reslist);
			return $reslist;
		}else return false;
	}else{
		return false;
	}
}
function RecvChatQuery($tok,$id,$time,$hmany){
	if($time!=NULL)
		$time=str_replace("+"," ",$time);
	else $time=NULL;
	$msglist=array();
	for($i=0;$i<$hmany;$i++){
		$buf=RecvChat($tok,$id,$time);
		if($buf==false)break;
		$time=$buf[0][1];

		$buf=array_slice($buf,0);
		//print_r($buf);
		array_push($msglist,$buf);
		
 
		 
	}
	array_unshift($msglist,$time);
	//echo $time."@\n";
	//print_r($msglist);
	//echo "@\n";
	//print_r($msglist);
	return $msglist;
}

function g_logoff($tok){
	include 'web_const.php';
	if(check_token($tok)){
		$id=get_id_by_token($tok);
		$conn=mysql_connect($mysql_server, $mysql_user,$mysql_pwd);
		$sqlstr= "call user_logoff('" .$tok."');";
		//echo $sqlstr;
		$result=mysql_db_query($mysql_db,$sqlstr, $conn);
		mysql_close($conn);  
		return 1;
	}else{
		return 0;
	}
}
function register_file($tok,$fpath,$ext,$ftype){
	include 'web_const.php';
	if(check_token($tok)){
		$id=get_id_by_token($tok);
		$conn=mysql_connect($mysql_server, $mysql_user,$mysql_pwd);
		$sqlstr= "call register_user_addition('" .$tok."','".$id."','".$fpath."',".$ftype.");";
		//echo $sqlstr;
		$result=mysql_db_query($mysql_db,$sqlstr, $conn);
		$res=mysql_fetch_row($result);
		mysql_close($conn);  $res[1]=$ftype;
		return $res;
	}else{
		return 0;
	}
}
function get_file($tok,$fkey){
	include 'web_const.php';

	$id=get_id_by_token($tok);
	$conn=mysql_connect($mysql_server, $mysql_user,$mysql_pwd);
	$sqlstr= "call get_user_addition('" .$fkey."');";
	//echo $sqlstr;
	$result=mysql_db_query($mysql_db,$sqlstr, $conn);
	$res=mysql_fetch_row($result);
	mysql_close($conn);  
	return $res[0];

}
function entrySave($tok,$id,$entarg,$content){
	include 'web_const.php';
	if(check_token($tok)){
		$uatime=getUniTime();
		$i=0; 
		$conn=mysql_connect($mysql_server, $mysql_user,$mysql_pwd);
		foreach($content as $msg){
				$sqlstr= "call up_share_record('" .$tok."',".$entarg.",".$msg[0].",'".$msg[1]."',".$i.",'".$uatime[1]."','".$uatime[0]."');";
				echo $sqlstr."</br>";
				mysql_db_query($mysql_db,$sqlstr, $conn);
				$i++;

		}
		mysql_close($conn);  
	}else{
	return false;
	}
}

function RecvEntry($tok,$towho,$unikey,$time){
	include 'web_const.php';
	if(check_token($tok)){
		if ($time==NULL)
			$time=getUniTime()[1];
		
		$conn=mysql_connect($mysql_server, $mysql_user,$mysql_pwd);
		$sqlstr= "call get_share_record('" .$tok."',".$towho.",'".$unikey."','".$time."');";
		//echo $sqlstr;
		$result=mysql_db_query($mysql_db,$sqlstr, $conn);
		$reslist = array();
		while(1){
			$res=mysql_fetch_row($result);
			//echo print_r($res);
			if($res==false)break;
			array_push($reslist,$res);
		}

		//echo "count:".count($reslist)."\n";
		if(count($reslist)!=0){
			$time=$reslist[0][0][1]; 
			array_unshift($reslist,$reslist[0][1]);
			mysql_free_result($result); 
			mysql_close($conn);  
			//echo print_r($reslist);
			return $reslist;
		}else return false;
	}else{
		return false;
	}
}
function RecvEntryQuery($tok,$towho,$unikey,$time,$hmany){
	if($time!=NULL)
		$time=str_replace("+"," ",$time);
	else $time=NULL;
	$msglist=array();
	for($i=0;$i<$hmany;$i++){
		$buf=RecvEntry($tok,$towho,$unikey,$time);
		//print_r($buf);
		if($buf==false)break;
		$time=$buf[0];unset($buf[0]);
		$unikey=$buf[1][5];
		array_push($msglist,$buf);
		
	}
	array_unshift($msglist,$time);
	//echo $time."@\n";
	//print_r($msglist);
	//echo "@\n";
	return $msglist;
}
function UserBeFriend($tok,$fid){
	include 'web_const.php';
	$id=get_id_by_token($tok);
	$conn=mysql_connect($mysql_server, $mysql_user,$mysql_pwd);
	$sqlstr= "call user_befriend('" .$tok."','".$fid."');";
	//echo $sqlstr;
	$result=mysql_db_query($mysql_db,$sqlstr, $conn);
	$res=mysql_fetch_row($result);
	mysql_close($conn);  
	return $res[0];

}
function addNotToUser($tok,$fid){
}
function readNot($tok){
}
?>
