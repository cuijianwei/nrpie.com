<? if(!defined('IN_FANWE')) exit('Access Denied'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><? if(!empty($_FANWE['nav_title'])) { ?><?=$_FANWE['nav_title']?> - <? } if(empty($no_site_name)) { ?><?=$_FANWE['setting']['site_title']?><? } ?></title>

<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

<meta name="keywords" content="<?=$_FANWE['seo_keywords']?><?=$_FANWE['setting']['site_keywords']?>" />

<meta name="description" content="<?=$_FANWE['seo_description']?><?=$_FANWE['setting']['site_description']?>" />

<link rel="icon" href="<?=$_FANWE['site_root']?>favicon.ico" type="image/x-icon" />

<?php 
$default_js[] = './public/js/jquery.js';
$default_js[] = './public/js/base.js';
        $default_js[] = './public/js/jquery.easing.js';
$default_js[] = './public/js/jquery.lazyload.js';
        $default_js[] = './public/js/jquery.masonry.min.js';
        $default_js[] = './public/js/main.js';
        $default_js[] = './public/js/main_con.js';
 ?>
<script src="<?php echo scriptParse($default_js); ?>" type="text/javascript"></script>

<?php 

$current_css[] = './tpl/css/usercenter.css';

        $current_css[] = './tpl/css/main.css';

 ?>

<link rel="stylesheet" type="text/css" href="<?php echo cssParse($current_css); ?>" media="all"/><? if(is_array($css_list)) { foreach($css_list as $css) { ?><link rel="stylesheet" type="text/css" href="<?php echo cssParse($css['url']); ?>"<? if(!empty($css['media'])) { ?> media="<?=$css['media']?>"<? } ?> />

<? } } ?>

<script type="text/javascript">

var SITE_PATH = '<?=$_FANWE['site_root']?>';

var SITE_URL = '<?=$_FANWE['site_url']?>';

var TPL_PATH = '<?=TPL_PATH?>';

var PUBLIC_PATH	 = '<?=PUBLIC_PATH?>';

var MODULE_NAME	 = '<?=MODULE_NAME?>';

var ACTION_NAME	 = '<?=ACTION_NAME?>';

var COOKIE_PRE = "<?=$_FANWE['config']['cookie']['cookie_pre']?>";

</script>

</head>

<body>



<div id="header">

<div class="top">

<div class="logo"></div>

<div class="rig">

<p class="con">您好，欢迎来到男人派！<a href="#" id="jia">收藏此网站</a><a href="#">分享</a></p>

<div class="searchbox">

<form id="soso_form" method="get" action="<?php echo FU('book/search',array()); ?>">

<input type="text" id="queryString" value="" tooltip="请输入关键字" name="tag">

                        <input type="submit" value="" id="search" class="btn" />

<input type="hidden" name="action" value="search" />

</form>	

</div>	

</div>

</div>

<div class="nav">

<ul class="nav_ul">

<li class="nav_ulli <? if(MODULE_NAME == 'Index') { ?>on<? } ?>"><a href="<?php echo FU('index',array()); ?>">首页</a><em></em></li>

                <?php 

                    $cate_active = false;

                    $g_r_cate = $_FANWE['cache']['goods_category']['root'];

                    $g_r_cate = &$_FANWE['cache']['goods_category']['all'][$g_r_cate];

                    

                    if(MODULE_NAME == 'Book' && ACTION_NAME == 'shopping'){

                        $cate_active = true;

                    }

                    $g_i_cates = &$_FANWE['cache']['goods_category']['parent'];

 ?>

                <? if($g_r_cate['cate_name'] ) { ?>

                <li class="nav_ulli <? if($cate_active == true ) { ?>on<? } ?>"><a href="<?php echo FU('book/shopping',array()); ?>"><?=$g_r_cate['cate_name']?></a><em></em></li>

                <? } ?>

            <? if(is_array($g_i_cates)) { foreach($g_i_cates as $g_i_cate_id) { ?>                <?php 

                    $g_i_cate = &$_FANWE['cache']['goods_category']['all'][$g_i_cate_id];

                    $g_i_code = &$g_i_cate['cate_code'];
if($g_i_cate['is_index'] == 0) continue;
                    if(MODULE_NAME == 'Book' && $goods_cate_code == $g_i_code)

                        $cate_active = true;

                    else

                        $cate_active = false;

                 ?>

                <li class="nav_ulli <? if($cate_active == true) { ?>on<? } ?>">

                	<a href='<?php echo FU('book/cate',array("cate"=>$g_i_code)); ?>'><?=$g_i_cate['cate_name']?></a>

                    <em></em>

                </li>

                <? } } ?>

<li class="sml_nav nav_engag"><a href="#">约会帮帮忙</a><em></em></li>

                <li class="sml_nav <? if(defined('IS_DAPEI')) { ?>on<? } ?>"><a href="<?php echo FU('book/dapei',array()); ?>">搭配秀</a><em></em></li>
                <!--li class="sml_nav <? if(defined('IS_LOOK')) { ?>on<? } ?>"><a href="<?php echo FU('book/look',array()); ?>">晒货</a><em></em></li-->
                <li class="sml_nav <? if(MODULE_NAME == 'Club') { ?>on<? } ?>"><a href="<?php echo FU('club/index',array()); ?>">主题</a><em></em></li>

</ul>

            <!--dynamic getUserInfo--></div>

</div>