<? if(!defined('IN_FANWE')) exit('Access Denied'); 
0
|| checkTplRefresh('./tpl/nrpie/page/book/book_cate_one.htm', './tpl/nrpie/inc/pages.htm', 1343313515, './data/tpl/compiled/page_book_book_cate_one.tpl.php', './tpl/nrpie', 'page/book/book_cate_one')
;?><? include template('inc/header'); ?><!--主体盒子开始-->
<!--频道页面开始-->

<div class="listmenu clearfix">
    <?php 
        $category_tags_a = array_slice($category_tags,0,3);
     ?>
    <div class="hd clearfix">
        <div class="nav_show"><a href="#"><b class="color"><?=$cate_name?></b>/<?=$cate_code?></a></div>
        <div class="fl infor"><p><?=$desc?></p></div>
    </div>
    <div class="bd_tags clearfix">
        <ul class="tagshow">

            <?php $cindex = 1; ?>            <? if(is_array($category_tags_a)) { foreach($category_tags_a as $key => $cate) { ?>            <li class="wd<?=$cindex?>">
                <span class="t_tit"><?=$cate['cate_name']?></span>
                <p class="wordsbox">                
                    <? if(is_array($cate['tags'])) { foreach($cate['tags'] as $k => $tag) { ?> 
<span <? if($tag['tag_name'] == $tag) { ?>class="on r3"<? } ?>><a href="<?=$tag['url']?>" <? if($tag['is_hot'] == 1) { ?>class="h"<? } ?>><?=$tag['tag_name']?></a></span>
<? } } ?>                    
                    <a href="<?=$cate['url']?>" class="more">更多&gt;&gt;</a>
                </p>                    
            </li>
            <?php $cindex++; ?>            <? } } ?>

        </ul>
        
        <div class="avdbox">
                <p><span class="btn"><a class="a_l" href="javascript:;"></a><a class="a_r" href="javascript:;"></a></span><b id="num" class="count"></b><a class="tit" href="#">流行单品</a></p>
                <ul class="listimg">
                    <li style="display:block"><a href="#"><img width="159"height="160" src="http://p0.55tuanimg.com/static/goods/goods/2012/06/08/15/goods_1339140345_5820_1.jpg" title="短裤" alt="短裤"></a>
                    </li>
                    <li><a href="#"><img width="159" height="160" src="http://p3.55tuanimg.com/static/goods/goods/2012/06/08/17/goods_1339148892_4502_1.jpg" title="T恤" alt="T恤" ></a>
                    </li>
                    <li><a href="#"><img width="159" height="160" src="http://p3.55tuanimg.com/static/goods/goods/2012/06/08/12/goods_1339131230_3423_1.jpg" title="开衫" alt="开衫" ></a>
                    </li>
                    <li><a href="#"><img width="159" height="160" src="http://p3.55tuanimg.com/static/goods/goods/2012/06/01/09/goods_1338513225_4495_1.jpg" title="牛仔裤" alt="牛仔裤"></a>
                    </li>
                </ul>
            </div>            
    </div>
</div>


<div class="seco_box">
    <? include template('inc/sortnav'); ?>    <div class="list_box clearfix" id="container">
    <? if(is_array($share_list)) { foreach($share_list as $share) { ?>        <div class="counbox" shareID="<?=$share['share_id']?>" id="share_item_<?=$share['share_id']?>">
        <? if(is_array($share['imgs'])) { foreach($share['imgs'] as $share_img) { if($share_img['type'] == 'g') { ?>
            <div class="pic">
                <a href="<?=$share_img['url']?>" target="_blank"><img src="<?php echo getImgName($share_img['img'],210,999,0); ?>"></a>
            </div>
            <p class="words_msg"><a class="lef" href="<?=$share_img['url']?>"><?php echo cutStr($share_img['name'],16,'...');?></a><span class="rig"><?=$share_img['price_format']?></span></p>
            <? } else { ?>
            <div class="pic">
                <a href="<?=$share_img['url']?>" target="_blank"><img src="<?php echo getImgName($share_img['img'],210,999,0); ?>" ></a>
            </div>
            <? } } } ?>
            <div class="favbox">
                <a href="javascript:;" onclick="$.Fav_Share(<?=$share['share_id']?>,this,32,'#share_item_<?=$share['share_id']?>');" class="favaimg bh">赞</a>
                <div class="favcountbox">
                	<a target="_blank" href="<?=$share['url']?>" class="fav_count"><?=$share['collect_count']?></a>
                	<i></i>
                </div>
                <a href="#" class="linkurl">淘宝网</a>
            </div>
            <p class="confont"><a target="_blank" href="<?=$share['url']?>"><?php echo cutStr($share['content'],50,'...');?></a></p>
            <div class="infor">
                <a href="#" class="a1">同类筛选</a><a target="_blank" href="<?=$share['url']?>" title="<?=$share['comment_count']?>条评论">评论</a><a href="#">收藏</a>
            </div>            
        </div>
        <? } } ?>
    </div>
</div>

<!--分页开始--><? if($pager['page_count'] > 1) { ?>
<ul class="fenye">
<li class="first"><a href="<?=$pager['page_prev']?>" class="page_prev" page="<?=$pager['prev_page']?>" style="text-indent:99999px;float:left;width:25px;height:25px;display:inline-block;">&lt;上一页</a></li>
<? if($pager['page'] > 1) { ?>
<!--<li class="first"><a href="<?=$pager['page_prev']?>" class="page_prev" page="<?=$pager['prev_page']?>">&lt;上一页</a></li>-->
<? } if(is_array($pager['page_nums'])) { foreach($pager['page_nums'] as $page_num) { if($pager['page'] == $page_num['name']) { ?>
<li class="hover"><?=$page_num['name']?></li>
<? } elseif($page_num['name'] == '...') { ?>
<li><i>...</i></li>
<? } else { ?>
<li><a href="<?=$page_num['url']?>" page="<?=$page_num['name']?>"><?=$page_num['name']?></a></li>
<? } } } if($pager['page'] < $pager['page_count']) { ?>
<!--<li class="last"><a href="<?=$pager['page_next']?>" class="page_next" page="<?=$pager['next_page']?>">下一页&gt;</a></li>-->
<? } ?>
<li class="last"><a href="<?=$pager['page_next']?>" class="page_next" page="<?=$pager['next_page']?>" style="text-indent:99999px;float;left;width:25px;height:25px;display:inline-block">下一页&gt;</a></li>
<!--
<li class="yeshu">跳至
<input type="text" name="">
页</li>
<li class="qding"><a href="javascript:;" onclick='self.location.href="<?=$page_num['url']?>"'>确定</a></li>
-->
</ul>
<div id="fenye" style="display:none;">
<ul class="fenye_con fenye_detail">
<li class="first"><a href="<?=$pager['page_prev']?>" class="page_prev" page="<?=$pager['prev_page']?>">&lt;上一页</a></li>
<? if($pager['page'] > 1) { ?>
<!--<li class="first"><a href="<?=$pager['page_prev']?>" class="page_prev" page="<?=$pager['prev_page']?>">&lt;上一页</a></li>-->
<? } if(is_array($pager['page_nums'])) { foreach($pager['page_nums'] as $page_num) { if($pager['page'] == $page_num['name']) { ?>
<li class="on"><?=$page_num['name']?></li>
<? } elseif($page_num['name'] == '...') { ?>
<li><i>...</i></li>
<? } else { ?>
<li><a href="<?=$page_num['url']?>" page="<?=$page_num['name']?>"><?=$page_num['name']?></a></li>
<? } } } if($pager['page'] < $pager['page_count']) { ?>
<!--<li class="last"><a href="<?=$pager['page_next']?>" class="page_next" page="<?=$pager['next_page']?>">下一页&gt;</a></li>-->
<? } ?>
<li class="last"><a href="<?=$pager['page_next']?>" class="page_next" page="<?=$pager['next_page']?>">下一页&gt;</a></li>
<!--
<li class="yeshu">跳至
<input type="text" name="">
页</li>
<li class="qding"><a href="javascript:;" onclick='self.location.href="<?=$page_num['url']?>"'>确定</a></li>
-->
</ul>
</div>
<script>

</script>
<? } ?>
<!--分页结束-->
<!--主体盒子结束-->

<script type="text/javascript">
FANWE.NO_COUNTER = true;
var colHeight = 0;
var colIndex = 0;
var rowHtml = '<div class="i_w_f_f empty_row"><div class="hd"></div><div class="bd"></div><div class="ft"></div></div>';
jQuery(function(){<!--dynamic getShareByUserClickShareID--><!--dynamic getManageDynamic args=book_index-->if($.browser.msie&&($.browser.version == "6.0")&&!$.support.style)
{
return ;
}
else{
$(".share_col").each(function(i){
$(this).append(rowHtml);
});
$(window).scroll(function(){
$(".share_col").each(function(i){
$('.empty_row .bd',this).height(0);
if($(this).height() > colHeight)
{
colIndex = i;
colHeight = $(this).height();
}
});

$(".share_col").each(function(i){
if(i != colIndex)
{
$('.empty_row .bd',this).height(colHeight - $(this).height());
}
});
});
}
});

function ShowUserClickShare(result)
{
if($("#share_item_" + result.share_id).length > 0)
{
var thisshare = $("#share_item_" + result.share_id);
var preshare = thisshare.prev();
var parentcol = thisshare.parent();
$(".col1").prepend(thisshare);
if(!parentcol.hasClass("col1") && $(".col1 .i_w_f").length > 1)
{
if(preshare.get(0))
preshare.after($(".col1 .i_w_f").eq(1));
else
parentcol.prepend($(".col1 .i_w_f").eq(1));
}
}
else
$(".col1").prepend(result.html);
}
</script><? include template('inc/footer'); ?>