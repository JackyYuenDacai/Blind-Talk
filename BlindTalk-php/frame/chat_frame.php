<html xmlns="http://www.w3.org/1999/xhtml" style="width:90%;margin-left:5%">
<head>
<link href="/bootstrap-3.3.6-dist/css/bootstrap.css" rel="stylesheet"/>
<link href="/css/icon_style0.css" rel="stylesheet"/>
<link href="/css/timline0.css" rel="stylesheet"/>
<link href="/css/boxshadow.css" rel="stylesheet"/>
<link href="/css/dumascroll.css" rel="stylesheet"/>
<script type="text/javascript" src="/jst/jquery-2.0.3UnCom.js"></script>
<script type="text/javascript" src="/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/jst/dumascroll.js" ></script>
<script type="text/javascript" src="/jst/base64.js" ></script>
<script type="text/javascript" src="/jst/global_funcs.js" ></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<script type="text/javascript">
	$.ajaxSetup({async: false});
	function chat_f_selected(id){
		setCookie('chat_fId',id);
		$("#flistb0").load(location.href+" #flistb0>*","");
		$("#namebox0").load(location.href+" #namebox0>*","");
		$("#msgbox0").load(location.href+" #msgbox0>*","");
	}
    var token;
    if (document.cookie.length > 0) {
        if (document.cookie.indexOf("token=") != -1) {
            token = document.cookie.slice(document.cookie.indexOf("token=") + 6 );
            //alert(token);
        }
        else {
            self.navigate("index.html");
        }
    } else {
        self.navigate("index.html");
    }

</script>
<script type="text/javascript">
    var id;
    var icon;
    $.post("/php/req.php", { "token": token, "req-type": "idc" }, function (json) {
        //alert(json[0]);
        if (json.slice(0, 8) == 'Negative') {
            document.cookie = null;
            //self.navigate("index.html");
        } else {
            id = json.slice(json.indexOf('Id=') + 3, json.indexOf('&Ico'));
            icon = json.slice(json.indexOf('Ico=') + 4);
            $("#idbox0").text(id);
            $("#idbox1").text(id);
            $("#iconbox0").attr('src', 'icon_st/' + icon); //alert(id);
        }
    });

</script>
<script type="text/javascript">
setInterval(function() {
    $("#flistb0").load(location.href+" #flistb0>*","");
	$("#namebox0").load(location.href+" #namebox0>*","");
	//$("#msgbox0").load(location.href+" #msgbox0>*","");
	//$("#chbox0").load(location.href+" #chbox0>*","");
}, 7000);
setInterval(function(){
	$("#msgbox0").load(location.href+" #msgbox0>*","");
}, 1000);
</script>

<script type="text/javascript">
var adds_count = 0;
var adds_array = new Array();
function ChtsendClicked(){
	adds_array.push(new Array(2,$("#tades0").val(),adds_array.length));
    $.post("/php/chat.php",{ 
			"token": token, 
			"req-type": "send" ,
			"to":getCookie('chat_fId'),
			"content":{adds_array}}, function(){adds_array = new Array();});
	$("#tades0").val("");
	$("#msgbox0").load(location.href+" #msgbox0>*","");
	$("#msgbox1").load(location.href+" #msgbox1>*","");
}
function ChtcleanClicked(){
}
function ChtaddClicked(){
}
</script>

<title></title>
</head>
<body >

	<div class="row">
         
		<div class="col-md-3 bs-docs-sidebar" >
			<div class="box-shadow-3" >
				<ul id="flistb0"class="nav nav-list bs-docs-sidenav" style="margin-top:14px;height:80%" >
	  <!--        <asp:Repeater ID="repe0" runat="server" DataSourceID="fclist">
		<ItemTemplate>
		<li style="background-color:<%#retOlSam((string)Eval("token"))%>"> 
		   <a style="font-size:20px"><i class="icon-chevron-right"></i><%#Eval("Id")%></a>  
		 </li>
		</ItemTemplate>
	    </asp:Repeater>-->
					<?php   
						include '../php/web_func.php';
						
						$holdarr=getuserflist($_COOKIE['token']);
						if (isset($_COOKIE["chat_fId"]))
							$select = $_COOKIE['chat_fId'];
						else
							$select = $holdarr[0][1];
						setcookie("chat_fId",$select);
						foreach($holdarr as $frd){
							echo  "<li style='background-color:";
							if($frd[0]==0)echo "#666";
							else echo "#EEE";
							echo "'>";
							echo "<a style='font-size:20px' onclick=\"chat_f_selected('" .$frd[1]."')\" ><i class='icon-chevron-right'></i>".$frd[1]."</a></li>\n";
						}
					?>
				</ul>
			</div>  
		</div>
		
		<div class="col-md-9" id="chbox0">
			<div class="box-shadow-3" >
				<div style="margin-top:14px;height:80%">
					<div>
						<div id="namebox0">
							<p class="text-center " style="color:
								<?php 	$i=0;
									while($holdarr[$i][1]!=$select&&$i<count($holdarr))
									{	$i++;
									}
									if($holdarr[$i][0]==0)echo '#666';
									else echo '#EEE';
								?>;font-size:35px;width:100%"><?php echo $select;?>
							</p>
						</div>
						<div id="msgbox0" style="margin-top:0px;width:94%;margin-left:3%;height:55%" class="dumascroll 
						<?php
							$i=0;
							while($holdarr[$i][1]!=$select&&$i<count($holdarr))
							{	$i++;
							}
							if($holdarr[$i][0]==0)echo ' box-shadow-3';
							else echo ' box-shadow-4';
								
						?>">	
							<div  id="msgbox1" style="height:100%;">
								<?php
									include '/php/web_func.php';
									if (isset($_COOKIE["chat_cltime"]))
										$ltime=$_COOKIE["chat_cltime"];
									else
										$ltime=NULL;
									$chquy=RecvChatQuery($_COOKIE['token'],$_COOKIE["chat_fId"],$ltime,120);
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
													echo "<div style='margin-left:3%;margin-right:3%;font-size:23px;'>\n";
													echo $ele[$i][3];
													echo "</div>\n";break;
												default:break;
											}
										}
										//print_r($ele);
										echo "</div>";
									}

								?>
								<div class="text-right">
								</div>
							</div>
							
						</div>
						<div style="margin-top:3%" class="text-bottom">
							<textarea  class="box-shadow-3" style="margin-left:3%;width:94%;
									height:16%;font-size:20px;resize:none"   
									id="tades0"></textarea>
							<div style="margin-top:1%;margin-left:3%;margin-right:3%">

			
									 
								<div class="text-right"> 
									<button  style="margin-right:6px;" type="button" onclick="ChtaddClicked()" class="btn btn-default">Add</button>
									<button  style="margin-right:6px;" type="button" onclick="ChtcleanClicked()" class="btn btn-default" >Clean</button>
									<button   type="button" onclick="ChtsendClicked()" class="btn btn-primary">Send</button>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

		</div>
	</div>
</body>
</html>
