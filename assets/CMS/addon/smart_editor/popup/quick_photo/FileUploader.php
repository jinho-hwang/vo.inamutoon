<?php

include_once $_SERVER["DOCUMENT_ROOT"]."/core/core.php";

$k = $_REQUEST["k"];

//기본 리다이렉트
/*echo $_REQUEST["htImageInfo"];
$url = $_REQUEST["callback"] .'?callback_func='. $_REQUEST["callback_func"];
*/
$bSuccessUpload = is_uploaded_file($_FILES['Filedata']['tmp_name']);

if ($bSuccessUpload) { //성공 시 파일 사이즈와 URL 전송
	
	$Dir = "/data/".date("Ym")."/";
	$DataLink = $_SERVER["DOCUMENT_ROOT"].$Dir;
	$urlLink = $Dir;

	if(is_dir($DataLink))
	{
		//디렉토리이미존재
	}
	else
	{
		//디렉토리생성
		mkdir("$DataLink",0707,true);
		chmod("$DataLink",0707);
	}

	$FileName = addslashes($_FILES["Filedata"]["name"]);	# 파일명
	$File	  = $_FILES["Filedata"]["tmp_name"];			# 파일
	$FileSize = $_FILES["Filedata"]["size"];				# 파일 사이즈

	#-- File Upload [S]  ---------------------------------------#
	
	// 파일 사이즈 체크
	FileSizeCheck($FileSize, 3000000);


	// 업로드 금지 파일 체크
	$TailName = "JPG|jpg|GIF|gif|PNG|png|BMP|bmp";	# 제한확장자
	FileNameCheck($FileName, $TailName);

	if($userid == "") $userid = rand(0999,9999);
	$tail = strrchr($FileName, ".");
	$img_code = time()."_".$userid;
	$FileRename = $img_code.$tail;

	
	// Save To Folder And Check
	$FileUploadName = $DataLink.$FileRename;
	$FileUrl		= $urlLink.$FileRename;
	FileUpload($File, $FileUploadName);

	/*$imageinfo = GetImageSize($FileUploadName);
	$imageW = $imageinfo[0];
	if($imageW > 600)
	{
		# width resize
		MakeThumb($FileUploadName, $FileUploadName, '');
	}*/

	chmod($FileUploadName,0644);


	//echo "[1]".$img_code."<br>";
	//echo "[2]".$FileRename."<br>";
	//echo "[3]".$FileUploadName."<br>";

	$SQL = "
	INSERT INTO 
		bbs_img 
	SET
		img_code = '$img_code',
		filename = '$FileRename',
		fileurl = '".$Dir.$FileRename."',
		signdate = now()
	";
	mysql_query($SQL);

	$SQL2 = "SELECT idx FROM bbs_img WHERE img_code = '$img_code'";
	$RLT2 = mysql_query($SQL2);
	$ROW2 = mysql_fetch_array($RLT2);
	$img_idx = $ROW2["idx"];
	
	//echo $k.$img_idx;

	#-- File Upload [E]  ---------------------------------------#

	/*$tmp_name = $_FILES['Filedata']['tmp_name'];
	$name = $_FILES['Filedata']['name'];
	$new_path = "../upload/".urlencode($_FILES['Filedata']['name']);
	move_uploaded_file($tmp_name, $new_path);
	$url .= "&bNewLine=true";
	$url .= "&sFileName=".urlencode(urlencode($name));
	//$url .= "&size=". $_FILES['Filedata']['size'];
	//아래 URL을 변경하시면 됩니다.
	$url .= "&sFileURL=http://test.naver.com/popup/upload/".urlencode(urlencode($name));

	echo $url;
	*/
} else { //실패시 errstr=error 전송
	$url .= '&errstr=error';
}
//header('Location: '. $url);
?>
<script src="/js/jquery-1.6.4.min.js"></script>

<?if($k == "thumb"){?>
	<script>
	var target = opener.parent;
	target.$("#thumb_info").val("<?=$img_idx?>");
	target.$("#thumb_url").val("<?=$FileUrl?>");
	target.$("#thumb_area").html("<img src='<?=$FileUrl?>' width='230' height='170'><?=$img_idx?>");
	target.$("#detail_img").html("<img src='<?=$FileUrl?>'>");
	</script>
<?}elseif($k == "mobile"){?>
	<script>
	var target = opener.parent;
	target.$("#mobile_info").val("<?=$img_idx?>");
	target.$("#mobile_url").val("<?=$FileUrl?>");
	target.$("#mobile_area").html("<img src='<?=$FileUrl?>'>");
	</script>
<?}else{?>
	<script>
	var sHTML = "<img src='<?=$FileUrl?>'>";
	var target = opener.parent;
	target.pasteHTML(sHTML);	// 이미지 textarea에 삽입
	var img_info = target.$("#img_info").val();
	if(img_info != "")	img_info = img_info +",<?=$img_idx?>";
	else				img_info = "<?=$img_idx?>";
	target.$("#img_info").val(img_info);	// 이미지 idx값을 form 으로 전달
	</script>
<?}?>

<script>
window.close();
</script>