<?php
set_time_limit(0);
if(!isset($_SESSION) && !isset($cron)){ session_start(); }
header('Cache-control: private');
header('Content-type: text/html; charset=utf-8');
//print(__FILE__);exit;
if(__FILE__ == ''){die('Fatal error code: 0');}
/* 初始化设 */
ini_set('memory_limit', '-1');//不限制内存使用量    麻晓飞注
//@ini_set('memory_limit',          '100M');
@ini_set('session.cache_expire',  180);// php5里session有效期默认的是180分
@ini_set('session.use_trans_sid', 0);//指定是否启用透明SID支持，默认为0（表示禁用）但如果浏览器关闭了cookie支持，那么如果还想用session，那么就必须激活此选项!
@ini_set('session.use_cookies',   1);//session.use_cookies：默认的值是“1”，代表SessionID使用Cookie来传递，反之就是使用Query_String来传递
@ini_set('session.auto_start',    0);//指定会话模块是否在请求开始时自动启动一个会话，默认是0，表示不启动
@ini_set('display_errors',        1);//开启错误显示

//session.name：这个就是SessionID储存的变量名称，可能是Cookie，也可能是Query_String来传递，默认值是“PHPSESSID”；
//session.cookie_lifetime：这个代表SessionID在客户端Cookie储存的时间，默认是0，代表浏览器一关闭SessionID就作废……就是因为这个所以Session不能永久使用
//session.gc_maxlifetime：这个是Session数据在服务器端储存的时间，如果超过这个时间，那么Session数据就自动删除
//var_dump(ini_get(session.save_handler));exit;
ob_start();
error_reporting(E_ALL ^ E_NOTICE);
//var_dump(PATH_SEPARATOR);exit;
define('OS', (PATH_SEPARATOR==':') ? 'Linux' : 'Windows');
define('D' , '/');
define('DT' , '..'.D);
define('U', D);
define("WEBROOT" , rtrim(dirname(__FILE__) , D) . D);
define("CONTROLLERS" , 'controllers');
define("CONTROLLERS_PATH" , WEBROOT . CONTROLLERS . D);
define("VIEWS" , 'views');
define("VIEWS_PATH" , WEBROOT . VIEWS . D);
define("VIEWS_SECTION" , 'section');
define("FRAME_LIB" , WEBROOT . 'includes' . D . 'libs' . D);
define("FRAME_CLASS" , WEBROOT . 'includes' . D . 'class' . D);
define("CACHE_SMARTY" , WEBROOT . 'tmp/smarty' . D);
define("CACHE_XML" , WEBROOT . 'tmp/xmlcache' . D);
//var_dump(CACHE_SMARTY);
//var_dump(CACHE_XML);exit;
// Smarty
define("TPL_TEMPLATE_DIR" , VIEWS);
define("TPL_COMPILED_DIR" , CACHE_SMARTY . 'compiled' . D);
define("TPL_PLUGINS_DIR" , FRAME_LIB . 'smarty_plugins' . D);
//var_dump(FRAME_LIB);exit;
// Configure::write();
require_once FRAME_LIB . 'configure.lib.php';//引入configure操作类

// Configure::write();
require_once FRAME_LIB . 'LYRuntime.lib.php';//引入页面计时类
$runTime = new LYRuntime();
$runTime->start();
Configure::write('runTime' , $runTime);

// $a=Configure::read('runTime');
// var_dump($a);exit;
// OEMID , HID , UID
$headers = apache_request_headers();
//var_dump($headers);exit;
$hid = empty($headers['Voole-HID'])?empty($_GET['hid'])? '':trim($_GET['hid']):$headers['Voole-HID'];
$oemid = empty($headers['Voole-OEMID'])?empty($_GET['oemid'])? '':trim($_GET['oemid']):$headers['Voole-OEMID'];
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

// Configure::write();
Configure::write('tmp.uid' , $uid);
Configure::write('tmp.oemid' , $oemid);
Configure::write('tmp.hid' , $hid);
// EPG_Theme
$_EPG_THEME = "default/b2b_1.0.1";
$_EPG_TYPE = "EPG";
$domain = $_SERVER["HTTP_HOST"];
//var_dump($domain);exit;
switch($domain){
	//case 'xmmobbox.voole.com':{$_EPG_THEME = "b2b/mobile_xiamen";break;}
	case 'liveb2b.voole.com':{$_EPG_THEME = "default/live_1.0.1";$_EPG_TYPE = "LIVE";break;}
	default:{break;}
}
switch($oemid){
	default:{break;}
}
require_once CONTROLLERS_PATH .$_EPG_THEME.'/Interface.php';
define('EPG_THEME' , "$_EPG_THEME");
session_write_close();
//var_dump(EPG_THEME);exit;
// View Flag
Configure::write('views.theme.flag' , false);	// [true:default-theme|false:theme]
?>