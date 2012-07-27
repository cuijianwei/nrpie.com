<?php
require_once rtrim(dirname(__FILE__) , '/') . '/config.ini.php';
require_once FRAME_LIB . 'core.lib.php';
$core = new CORE();
Configure::write('core',$core);
$core->loadThemeConfig();
$post = $_GET;
//var_dump($post);exit;
// Loading PHP file.
$act = (!isset($post['act']) || empty($post['act'])) ? 'index' : trim($post['act']);
// Loading Data cache.
$cache = (isset($post['cache']) && !empty($post['cache'])) ? true : false;
$cache_page = (!isset($post['cache_page']) || empty($post['cache_page'])) ? '' : trim($post['cache_page']);
/*paramster*/
$page =	empty($post['page'])? 1 : intval($post['page']);
$pagesize = empty($post['pagesize'])? 8 : intval($post['pagesize']);
$mtype = empty($post['mtype'])? 0 : intval($post['mtype']);
$section = trim($post['section']);
$atype = intval($post['atype']);
$cid = empty($post['cid'])? 0 : intval($post['cid']);
$mid = empty($post['mid'])? 0 : intval($post['mid']);
$res = trim($_REQUEST['s']);
$keytype = empty($post['keytype'])? '' : trim($post['keytype']);
$keycolumn = empty($post['keycolumn'])? '' : trim($post['keycolumn']);

$request_cfg = array(
	'act'		=> $act,
	'cache'		=> $cache,
	'cache_page'=> $cache_page,
	'page'		=> $page,
	'pagesize'	=> $pagesize,
	'mtype'		=> $mtype,
	'section'	=> $section,
	'atype'		=> $atype,
	'cid'		=> $cid,
	'mid'		=> $mid,
	'res'		=> $res,
	'keytype'	=> $keytype,
	'keycolumn'	=> $keycolumn
);
Configure::write('request' , $request_cfg);
$core->template->Assign('request',	$request_cfg);
//var_dump($request_cfg);
/*栏目菜单*/
if($_EPG_TYPE == 'EPG' && $act != 'viewhtml5'){
	$menu = $core->get_cache("" , false);
	$mt = $menu->xpath("/FilmClassList/FilmClass[@ChannelId!='-1']");
	$mn = $menu->xpath("/FilmClassList/FilmClass[@ChannelId='".$mtype."']");
	$me = $menu->xpath("/FilmClassList/FilmClass[@ChannelId='".$mtype."']/FilmClass");
	
	//var_dump($mt);
	//var_dump($mn);
	//var_dump($me);
	
	//exit;
	if (count($mn)>0){
		$attr = $mn[0]->attributes();
		$tips = $attr["FilmClassName"];
	}else{
		$tips = "";
	}
	//smarty paramstr
	$core->template->Assign('act',	$act);
	$core->template->Assign('menu',	$mt);
	$core->template->Assign('menus',$me);
	$core->template->Assign('uid',	Configure::read('tmp.uid'));
	$core->template->Assign("oemid", Configure::read('tmp.oemid'));
	$core->template->Assign("hid", Configure::read('tmp.hid'));
	$core->template->Assign('tips',	$tips);
	$cfg = Configure::read("cfg");
	$core->template->Assign('mode',$cfg["mode"]);
	$core->template->Assign('mtype',$mtype);
	
	$core->template->Assign("HTTP_REFERER", isset($post["returl"]) ? $post["returl"] : $_SERVER['HTTP_REFERER']  );
}
$core->loadThemeController($act);
// run time
$runTime = $core->getRuntime()->stopAndSpent();
$core->getRuntime()->pr('======= RunTime : '.$runTime.' ms');
exit;
?>