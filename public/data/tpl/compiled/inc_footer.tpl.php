<? if(!defined('IN_FANWE')) exit('Access Denied'); ?>
    <div id="footer" class="">
<div class="foot_nav">
<ul>
<li <? if(MODULE_NAME == 'Index') { ?>class="on"<? } ?>><a href="<?php echo FU('index',array()); ?>">首页</a></li>
            
            <?php 						
                $cate_active = false;
               
                if(MODULE_NAME == 'Book' && ACTION_NAME == 'shopping'){
                    $cate_active = true;
                }
             ?>
            <? if($g_r_cate['cate_name'] ) { ?>
            <li <? if($cate_active == true ) { ?>class="on"<? } ?>><a href="<?php echo FU('book/shopping',array()); ?>"><?=$g_r_cate['cate_name']?></a></li>
            <? } ?>
            <? if(is_array($g_i_cates)) { foreach($g_i_cates as $g_i_cate_id) { ?>            <?php 
                $g_i_cate = &$_FANWE['cache']['goods_category']['all'][$g_i_cate_id];
                $g_i_code = &$g_i_cate['cate_code'];
                if($g_i_cate['is_index'] == 0) continue;
                if(MODULE_NAME == 'Book' && $goods_cate_code == $g_i_code)
                    $cate_active = true;
                else
                    $cate_active = false;
             ?>
            <li <? if($cate_active == true ) { ?>class="on"<? } ?>>
                <a href='<?php echo FU('book/cate',array("cate"=>$g_i_code)); ?>'><?=$g_i_cate['cate_name']?></a>
            </li>
            <? } } ?>
            <li <? if(defined('IS_DAPEI')) { ?>class="on"<? } ?>><a href="<?php echo FU('book/dapei',array()); ?>">搭配秀</a></li>
            <li <? if(MODULE_NAME == 'Club') { ?>class="on"<? } ?>><a href="<?php echo FU('club/index',array()); ?>">主题</a></li>
</ul>
</div>
<div class="foot_nav2"><a href="#">关于我们</a>  <a href="#"> 联系我们</a> <a href="#">  广告投放</a>  <a href="#"> 给我们留言 </a><a href="#">  新手指南</a>  <a href="#"> 隐私政策</a><a href="">男人派</a><a href="">版权所有© 京ICP备12008301号</a></div>
<div class="foot_log bh">男人派</div>
</div>
<div id="USER_INFO_TIP" style="display:none;">
<div id="nru_infobox">
<div class="tip_info">
<img class="avatar" alt="" src="./tpl/images/nr_loading.gif">
<div>
<p><a href="#">&nbsp;</a></p>
<p>获取用户信息...</p>
<p>&nbsp;</p>
</div>
</div>
<div class="tip_toolbar"></div>
<div class="tip_arrow"></div>
</div>
</body>
<?php 
    $default_js = array();
$default_js[] = './public/js/setting.js';
$default_js[] = './public/js/jquery.bgiframe.js';
$default_js[] = './public/js/jquery.weebox.js';
$default_js[] = './public/js/ajaxfileupload.js';
$default_js[] = './public/js/jquery.dragsort.js';
$default_js[] = './public/js/swfobject.js';
 ?>
<script src="<?php echo scriptParse($default_js); ?>" type="text/javascript" defer="true"></script><? if(is_array($js_list)) { foreach($js_list as $js) { ?><script src="<?php echo scriptParse($js); ?>" type="text/javascript"></script>
<? } } ?><!--dynamic getScript--><script type="text/javascript">
jQuery(function($){
$(".lazyload").lazyload({"placeholder":"./tpl/images/nr_loading.gif"});
});
$(function() {
$('#container').masonry({
itemSelector: '.cbox',
columnWidth: 235,
gutterWidth:18
});
});
</script>
</html>