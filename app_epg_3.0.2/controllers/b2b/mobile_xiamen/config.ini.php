<?php
define('EPG_DEBUG' , false);
define('EPG_THEME_DEFAULT' , 'default/b2b_1.0.1');	// EPG_Theme
define('EPG_NOIMG' , 'default');	//设置图片默认图的基础路径 [default|theme]

// filmlist
define('EPGID', 100106);
define('SPID', 10002001);
define('APPID', 120503);
$ary = array("LB_recommenended","LB_topview");	//EPG_Tuijian,EPG_Paihang
defined("IMLIST") or define("IMLIST", Configure::read('Ifree'));

// CDN导向
$terminalcode = 01;		//The code of Terminal-type.
$areacode = '4404';		//The code of CDN area-type.
$wlan = '4';			//The code of CDN network-type.

// Cache
define('EPG_CACHE_TYPE' , 'file');		// [type:file|memcache|null]
define('EPG_CACHE_PAGE_NUM' , 1);

// ===============

// Data
$PlayParam = array(
	"charset"   => "utf-8",
	"responseformat" => "xml",
	'uid'		=> Configure::read('tmp.uid'),
	'oemid'		=> Configure::read('tmp.oemid'),
	'hid'		=> Configure::read('tmp.hid'),
	"appid"    => APPID,
	"epgid"     => EPGID,
	"spid"      => SPID,
	"area"      => $areacode,
	"wlan"     	=> $wlan
);
$this && $this->template->Assign('PlayParam',	$PlayParam);#给模板同赋值
define("XML_ROOT", IMLIST.http_build_query($PlayParam));#生成播放地址URL地址请求串
//这是在某些特殊项目中启用, 标准的官网版根据我了解是没有这个功能的
$ckurl_login = "http://218.107.60.7:35121/action/gd/";		//The interface for regisite,login.

// ===============

$cfg = array(
	'areacode'	=> $areacode,			//The code of CDN area-type.
	'wlan'		=> $wlan,				//The code of CDN network-type.
	'mode'		=> $mode,				//1:fee|0:no fee.
	'appcode'	=> APPID,			//Tongji Code.
	'terminalcode'=> $terminalcode,		//The code of Terminal-type.
	'ary'		=> $ary,				//EPG_Tujian,EPG_Paihang
	'uid'		=> Configure::read('tmp.uid'),
	'oemid'		=> Configure::read('tmp.oemid'),
	'hid'		=> Configure::read('tmp.hid'),
	'ckurl'		=> $ckurl,
	'ckurl_login'=> $ckurl_login,
	'epg_default'=> EPG_THEME_DEFAULT,
	'tpl_section'=> array(
		'theme'		=> array('header'=>'default_header.html' , 'footer'=>'default_footer.html'),
		'default'	=> array('header'=>'default_header.html' , 'footer'=>'default_footer.html')
	)
);
Configure::write('cfg' , $cfg);
$this && $this->template->Assign('cfg',	$cfg);
$cfg_xmlcache = array(
	'type'		=> EPG_CACHE_TYPE,	// [type:file|memcache|null]
	'lifetime'	=> 600,
	'fileDir'	=> CACHE_XML,									// File cache XML
	'memcache'	=> array('host'=>array('127.0.0.1:11211') , 'compress'=>1024000)		// Memcache cache XML
);
Configure::write('cfg_cache' , $cfg_xmlcache);

//图片服务器   VOSP域名
define('IS_REPLACE',true);
$replace_conf = array(
	'source'	=> array(
		"/imgstbox.voole.com/",
		"/vosp:\/\/cdn.voole.com/"
	),
	'replace'	=> array(
		"xmmobboximg.voole.com",
		"vosp://183.203.8.235"
	)
);
Configure::write('replace_conf' , $replace_conf);

?>