<?php 
define('MODULE_NAME','Book');

$actions = array(
	'cate'		=>"cate",	
	'search'	=> 'search',
	'dapei'		=> 'dapei',
	//'look'		=> 'look',
	'shopping' 	=> 'shopping',
);

if(isset($_REQUEST['action']))
{
	$action = strtolower($_REQUEST['action']);
	if(!isset($actions[$action]))
	{
		$action = 'shopping';
	}
} else {
	$action = 'shopping';
}

define('ACTION_NAME',$action);

require dirname(__FILE__).'/core/fanwe.php';
$fanwe = &FanweService::instance();
$fanwe->initialize();

require fimport('module/book');

switch(ACTION_NAME)
{
	case 'cate'://分类展示
		BookModule::cate();
	break;
	case 'search'://搜索
		BookModule::search();
	break;
	case 'dapei'://搭配
		define('IS_DAPEI',true);
		BookModule::dapei();
	break;
	/*
	case 'look'://晒货
		define('IS_LOOK',true);
		BookModule::look();
	break;
	*/
	case 'shopping'://默认入口，展示所有
		BookModule::shopping();
	break;
}
?>