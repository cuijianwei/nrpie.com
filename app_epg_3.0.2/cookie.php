<?
$headers = apache_request_headers();
$hid = empty($headers['Voole-HID'])?empty($_GET['hid'])? '':trim($_GET['hid']):$headers['Voole-HID'];
$oemid = empty($headers['Voole-OEMID'])?empty($_GET['oemid'])? '':trim($_GET['oemid']):$headers['Voole-OEMID'];
echo "oemid:$oemid,hid:$hid";
//$oemid = 106;
// oemid
if(!empty($oemid)){
	setcookie("oemid",$oemid);
}else{
	if (isset($_COOKIE['oemid'])) {
		$oemid = $_COOKIE["oemid"];
	} 
}
// hid
if(!empty($hid)){
	setcookie("hid",$hid);
}else{
	if (isset($_COOKIE['hid'])) {
		$hid = $_COOKIE["hid"];
	}
}
// UID
if (isset($_GET['uid'])){
	$uid = trim($_GET['uid']);
	setcookie("uid",$uid);
}else{
	if (isset($_COOKIE['uid'])) {
		$uid = $_COOKIE["uid"];
	}else{
		$uid = "";setcookie("uid",$uid);
	}
}

?>