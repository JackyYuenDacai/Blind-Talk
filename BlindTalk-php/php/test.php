<?php
	/*$tok = "9d584597d1c7c0adaf7784c22ce1e7a3";
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
	}*/
	/*$tok="2057ae50bad084211ae0ed83f36735d9";
	include'web_func.php';
	$ftype=2;
	$fpath='aaa';
<div class="file-preview-frame" id="preview-1473553864583-0" data-fileindex="0" data-template="audio" title="纯音乐 _ 泰坦尼克号.mp3" style="width:213px;height:80px;"><div class="kv-file-content">
<audio class="kv-preview-data" controls="">
<source src="blob:http://localhost/d8b1b865-cc8b-44e8-b7ff-ddbf8700e28a" type="audio/mpeg">
<div class="file-preview-other">
<span class="file-other-icon"><i class="glyphicon glyphicon-king"></i></span>
</div>
</audio>
</div><div class="file-thumbnail-footer">
    <div class="file-footer-caption" title="纯音乐 _ 泰坦尼克号.mp3">纯音乐 _ 泰坦尼克号.mp3 <br><samp>(10.82 MB)</samp></div>
    <div class="file-thumb-progress hide"><div class="progress">
    <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%;">
        0%
     </div>
</div></div> <div class="file-actions">
    <div class="file-footer-buttons">
        <button type="button" class="kv-file-upload btn btn-xs btn-default" title="Upload file"><i class="glyphicon glyphicon-upload text-info"></i></button> <button type="button" class="kv-file-remove btn btn-xs btn-default" title="Remove file"><i class="glyphicon glyphicon-trash text-danger"></i></button>
 <button type="button" class="kv-file-zoom btn btn-xs btn-default" title="View Details"><i class="glyphicon glyphicon-zoom-in"></i></button>     </div>
    
    <div class="file-upload-indicator" title="Not uploaded yet"><i class="glyphicon glyphicon-hand-down text-warning"></i></div>
	echo get_file($tok,'11d3d092b3b4553559e306fa8a3dd077');*/
	include'web_func.php';
	$tok="fa2e236b13286eda100cec24b8381bd7";
	//print_r(RecvEntryQuery($tok,1,'0',NULL,3));
echo get_file($tok,'b53faf5d043a833c16bddc1c63f21957');
?>
