<? if(!defined('IN_FANWE')) exit('Access Denied'); 
0
|| checkTplRefresh('./tpl/nrpie/page/note/note_index_new.htm', './tpl/nrpie/inc/pages.htm', 1343313718, './data/tpl/compiled/page_note_note_index_new.tpl.php', './tpl/nrpie', 'page/note/note_index_new')
;?>
<?php 
$css_list[0]['url'][] = './tpl/css/tweetlist.css';
$css_list[0]['url'][] = './tpl/css/sidebar.css';
$css_list[0]['url'][] = './tpl/css/note.css';
$js_list[0] = './tpl/js/note.js';
 include template('inc/header'); ?><!--主体盒子开始-->

<!--频道页面开始-->

<div class="detail_box clearfix">

<div class="lef">
<div id="bdshare_m_c">
<h6>分享到</h6>
<ul>
<li><a class="bds_qzone qqkj" href="#">QQ空间</a></li>
<li><a class="bds_tsina xlwb" href="#">新浪微博</a></li>
<li><a class="bds_baidu bdsc" href="#">百度搜藏</a></li>
<li><a class="bds_renren rrw" href="#">人人网</a></li>
<li><a class="bds_tqq txwb" href="#">腾讯微博</a></li>
<li><a class="bds_kaixin001 kxw" href="#">开心网</a></li>
<li><a class="bds_tqf txpy" href="#">腾讯朋友</a></li>
<li><a class="bds_more" href="#">更多...</a></li>
</ul>
<p><a class="goWebsite" href="#">百度分享</a></p>
</div>
<div class="show_body clearfix">
<div class="img_wrap">
<div class="img_show"><? if(is_array($share_detail['imgs'])) { foreach($share_detail['imgs'] as $k=>$img) { if($img['id']==$id) { ?>
<a href="<?=$img['url']?>" style="display:block"><img src="<?php echo getImgName($img['img'],468,468,0); ?>"></a>
<? } else { ?>
<a href="<?=$img['url']?>"><img src="<?php echo getImgName($img['img'],468,468,0); ?>"></a>
<? } } } ?>
</div>
<? if(count($share_detail['imgs'])>1) { ?>
<div class="img_small"><? if(is_array($share_detail['imgs'])) { foreach($share_detail['imgs'] as $k=>$img) { if($img['id']==$id) { ?>
<a href="<?=$img['url']?>" class="on"><img src="<?php echo getImgName($img['img'],468,468,0); ?>"><b class="jiao"></b></a>
<? } else { ?>
<a href="<?=$img['url']?>"><img src="<?php echo getImgName($img['img'],468,468,0); ?>"><b class="jiao"></b></a>
<? } } } ?>
</div>
<? } ?>
</div>
<div class="img_conent">
<? if(count($all_obj)>=1) { ?>
<div class="goods_link">
<div class="goods">
<h2 class="xq_dapei">搭配：</h2><? if(is_array($all_obj)) { foreach($all_obj as $k=>$obj) { ?><p class="goods_more">
<span class="sp_name"><?=$share_detail['title']?></span>
<a class="shop_link" target="_blank" href="<?=$obj['to_url']?>"><?=$obj['name']?></a>
<span class="pay"><?=$obj['price_format']?></span>
</p>
<? } } ?>
</div>
</div>
<? } ?>
<dl class="content_dl">
<dt>
<a href="#"><img src="<?php echo getImgName($current_obj['img'],468,468,0); ?>"></a>
</br>
</dt>
<dd class="dd1"><span class="name"><?=$share_user['user_name']?></span><span class="time"><?=$share_detail['time']?></span></dd>
<dd class="text"><?=$share_detail['content']?></dd>
<dd>
<a href="#" class="select_xq"></a>
<div class="wb_infobar">
<a class="fw " href="javascript:void(0);"></a> 
<a class="fav" href="javascript:;">1</a>
</div>
<div  style="float:right" id="bdshare" class="deta_shore">
<span class="share">分享：</span>
<a class="bds_more" href="#"></a>
<a title="分享到新浪微博" class="bds_tsina"></a>
<a title="分享到QQ空间" class="bds_qzone"></a>
<a title="分享到腾讯微博" class="bds_tqq"></a>
<a title="分享到人人网" class="bds_renren"></a>
</div>
</dd>
</dl>
</div>
<div class="clear"></div>
<form method="post">
<div class="note_comment_xq">
<div class="pub_area">
<div class="pub_area_bd">
<span class="pub_area_bdspa"></span>
<textarea class="PUB_TXT pub_txt" id="pub_content" name="content" length="140" position="0" ></textarea>
</div>
<div class="pub_area_ft clearfix">
<div class="pub_ext">
<div class="pub_opt fl">
<span class="fl">添加：</span>
<a class="add_face fl" href="javascript:;" onclick="$.Show_Expression(this)" w="tpk">表情</a>
</div>
<span class="button_qued rigb" onclick="$.Add_Share_Comment(this,'#SHARE_COMMENT_LIST_<?=$share_detail['share_id']?>')"></span>
<div class="pub_out fr">
<input id="comment_relay_tweet" type="checkbox" name="is_relay" checked="checked" value="1" />
<label for="comment_relay_tweet">转发给我的粉丝</label>
<input type="hidden" value="<?=$share_detail['share_id']?>" name="share_id" />
<input type="hidden" name="parent_id" value="0" />
</div>
</div>
</div>
</div>
<div class="note_comment_xq2" id='SHARE_COMMENT_LIST_BOX'>
<ul class="c_l rb5" id="SHARE_COMMENT_LIST_<?=$share_detail['share_id']?>"><? if(is_array($share_detail['comments'])) { foreach($share_detail['comments'] as $comment) { ?><li id="COMMENT_<?=$comment['comment_id']?>" class="c_f">
<a target="_blank" href="/u.php?action=index&amp;uid=<?=$comment['uid']?>" title="<?=$comment['user']['user_name']?>" class="user_avt">
<img alt="<?=$comment['user']['user_name']?>" src="<?php echo avatar($share_user['uid'],'m',$share_user['server_code'],1);?>" uid="<?=$comment['uid']?>" class="GUID avt">
</a>
<p class="sms"><?php echo setTplUserFormat($comment['uid'],0,1,'',0,'n icard','',''); ?><span>（<?=$comment['time']?>）</span>
</br>
回复：<?=$comment['content']?>
</p>
<div>
<? if($is_remove_comment) { ?>

<a onclick="$.Delete_Comment(<?=$comment['comment_id']?>,this);" class="del" w="f" href="javascript:void(0);">删除</a>

<? } ?>

<a class="rpl" w="f" href="javascript:;" uname='<?=$comment['user']['user_name']?>' cid="<?=$comment['comment_id']?>" onclick="$.Reply_Comment(this);">回复</a>
</div>
</li>
<? } } ?>
</ul>
<div class="pagination"><? if($pager['page_count'] > 1) { ?>
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
</div>
</div>
</div>
</form>

<? if(count($all_obj)>=1) { ?>
<div class="buy_goods">
<span class="buy_goods_t">可以在这里买到：</span>
<div class="goods_pic">
<a target="_blank" href="<?=$current_obj['to_url']?>"><img src="<?php echo getImgName($current_obj['img'],100,100,0); ?>"></a>
<p>
<a target="_blank" href="<?=$current_obj['to_url']?>" class="name"><?php echo cutStr($current_obj['name'],32,'...');?>...</a>
<br>
<span class="lefc"><?=$current_obj['price_format']?></span>
</p>
</div>
<a target="_blank" class="buy_goods_link button_see bh" href="<?=$current_obj['to_url']?>">购买链接</a>
</div>
<? } ?>
</div>
</div>

    <div class="rig">

        <table width="164" height="188" border="0" cellpadding="0" cellspacing="0" class="shaihuo_daren">

            <tr>

                <td width="59" height="65" rowspan="2" align="left"><img src="<?php echo avatar($share_user['uid'],'m',$share_user['server_code'],1);?>" class="daren_toux"></td>

                <td width="91" height="25"><a href="<?php echo FU('u/index',array("uid"=>$share_user['uid'])); ?>" class="daren_name"><?=$share_user['user_name']?></a></td>

            </tr>

            <tr>

                <td height="12"><a href="javascript:;" onclick="$.AtMe_Share(this);" class="daren_talk" toname="<?=$share_user['user_name']?>" >@<?=$user_show_name['short']?></a></td>

            </tr>

            <tr>

                <td height="27" valign="top">

                 <!--getfollow <?=$share_user['uid']?> inc/getfollow/note_index-->                </td>

                <td valign="middle"><a href="#" class="daren_detail">查看个人资料</a></td>

            </tr>

            <tr>

                <td height="44" colspan="2">

                    <ul class="daren_listcon">

                        <li>

                            <a href="<?php echo FU('u/follow',array("uid"=>$share_user['uid'])); ?>"><?=$share_user['follows']?></a>

                            <span>关注</span>

                        </li>

                        <li>

                            <a href="<?php echo FU('u/fans',array("uid"=>$share_user['uid'])); ?>"><?=$share_user['fans']?></a>

                            <span>粉丝</span>

                        </li>

                        <li>

                            <a href="#"><?=$share_user['collects']?></a>

                            <span>被赞</span>

                        </li>

                    </ul>

                </td>

            </tr>

            <tr>

                <td colspan="2"><p class="introduce mt10">

                        <? if(empty($share_user['introduce'])) { if($share_user['uid'] != $_FANWE['uid']) { ?>

<a style="color:#aaa">真懒啊，连自我介绍都 不写。写一点也不会浪 费太多时间啦！</a> 

<? } else { ?>

<a class="s_d" href="<?php echo FU('settings/personal',array()); ?>" target="_blank">添加自我介绍</a>

<? } } else { ?>

<?=$share_user['introduce']?>

<? if($share_user['uid'] == $_FANWE['uid']) { ?>

( <a class="s_d" href="<?php echo FU('settings/personal',array()); ?>" target="_blank">修改</a> )

<? } } ?></p></td>

            </tr>

        </table>



        <ul class="daren_shuoshuo clearfix">

            <li><span>说说</span></li>

            <li>

                <span>私家晒货</span><a href="#"><?=$share_user['photos']?>件</a>

            </li>

            <li>

                <span>搭配</span><a href="#"><?=$share_user['goods']?>件</a>

            </li>

            <li>

                <span>收藏</span><a href="#"><?=$share_user['goods']?>件</a>

            </li>

        </ul>

        <p class="saihuo_other clearfix">

            <span>他的其他晒货</span><a href="#">更多</a>

        </p>

        <div class="saihuo_othercon clearfix">

            <? if(is_array($best_goods_share)) { foreach($best_goods_share as $goods_share) { ?><li><a target="_blank" href="<?=$goods_share['url']?>"><img src="<?php echo getImgName($goods_share['img'],100,100,0); ?>"></a></li>

<? } } ?>

        </div>

        <a class="mainTop_img shaihuo_btmimg" href="#"><img src="images/test5.png"></a>



    </div>

</div>

<div class="seco_box">

    <div class="top no_title">

        <h3>您可能喜欢的商品</h3>

    </div>

    <div class="list_box clearfix">

        <!--第一列开始-->

        <div class="count_list">

            <div class="lisxq_box">

                <div class="xq1">

                    <a href="#"><img src="images/test2.png"></a>

                    <p class="img_con"><a class="lef" href="#">潮男小西服外套</a><span class="rig">￥22334</span></p>

                </div>

                <div class="xq2">

                    <p><a href="#" class="xq_le">赞一个[<em>155</em>]</a><a href="#" class="xq_ri">淘宝网</a></p>

                    <p class="tex"><a href="">每日出货数量有限，喜欢的亲们请赶快下手！</a></p>

                </div>

                <div class="xq3">

                    <a href="" class="a1">同类对比</a><a href="">评论</a><a href="">分享</a>

                </div>

            </div>





        </div>

        <!--第一列结束-->

        <!--第二列开始-->

        <div class="count_list">

            <div class="lisxq_box">

                <div class="xq1">

                    <a href="#"><img src="images/test2.png"></a>

                    <p class="img_con"><a class="lef" href="#">潮男小西服外套</a><span class="rig">￥22334</span></p>

                </div>

                <div class="xq2">

                    <p><a href="#" class="xq_le">赞一个[<em>155</em>]</a><a href="#" class="xq_ri">淘宝网</a></p>

                    <p class="tex"><a href="">每日出货数量有限，喜欢的亲们请赶快下手！</a></p>

                </div>

                <div class="xq3">

                    <a href="" class="a1">同类对比</a><a href="">评论</a><a href="">分享</a>

                </div>

            </div>

            <div class="lisxq_box">

                <div class="xq1">

                    <a href="#"><img src="images/test2.png"></a>

                    <p class="img_con"><a class="lef" href="#">潮男小西服外套</a><span class="rig">￥22334</span></p>

                </div>

                <div class="xq2">

                    <p><a href="#" class="xq_le">赞一个[<em>155</em>]</a><a href="#" class="xq_ri">淘宝网</a></p>

                    <p class="tex"><a href="">每日出货数量有限，喜欢的亲们请赶快下手！</a></p>

                </div>

                <div class="xq3">

                    <a href="" class="a1">同类对比</a><a href="">评论</a><a href="">分享</a>

                </div>

            </div>





        </div>

        <!--第二列结束-->

        <!--第三列开始-->

        <div class="count_list">





            <div class="lisxq_box">

                <div class="xq1">

                    <a href="#"><img src="images/test2.png"></a>

                    <p class="img_con"><a class="lef" href="#">潮男小西服外套</a><span class="rig">￥22334</span></p>

                </div>

                <div class="xq2">

                    <p><a href="#" class="xq_le">赞一个[<em>155</em>]</a><a href="#" class="xq_ri">淘宝网</a></p>

                    <p class="tex"><a href="">每日出货数量有限，喜欢的快下手，喜欢的亲们请赶快下手赶快下手！</a></p>

                </div>

                <div class="xq3">

                    <a href="" class="a1">同类对比</a><a href="">评论</a><a href="">分享</a>

                </div>

            </div>



        </div>

        <!--第三列结束-->

        <!--第四列开始-->

        <div class="count_list">

            <div class="lisxq_box">

                <div class="xq1">

                    <a href="#"><img src="images/test2.png"></a>

                    <p class="img_con"><a class="lef" href="#">潮男小西服外套</a><span class="rig">￥22334</span></p>

                </div>

                <div class="xq2">

                    <p><a href="#" class="xq_le">赞一个[<em>155</em>]</a><a href="#" class="xq_ri">淘宝网</a></p>

                    <p class="tex"><a href="">每日出货数量有手！</a></p>

                </div>

                <div class="xq3">

                    <a href="" class="a1">同类对比</a><a href="">评论</a><a href="">分享</a>

                </div>

            </div>

            <div class="lisxq_box">

                <div class="xq1">

                    <a href="#"><img src="images/test2.png"></a>

                    <p class="img_con"><a class="lef" href="#">潮男小西服外套</a><span class="rig">￥22334</span></p>

                </div>

                <div class="xq2">

                    <p><a href="#" class="xq_le">赞一个[<em>155</em>]</a><a href="#" class="xq_ri">淘宝网</a></p>

                    <p class="tex"><a href="">每日出货数量有手！</a></p>

                </div>

                <div class="xq3">

                    <a href="" class="a1">同类对比</a><a href="">评论</a><a href="">分享</a>

                </div>

            </div>







        </div>

        <!--第四列结束-->



    </div>

</div>

<script type="text/javascript">

    function UpdateUserFollow(obj,result)

    {

        if(result.status == 1)

        {

            $(obj).before('<img class="fo_ok" src="./tpl/images/add_ok_03.png">');

            $(obj).remove();

        }

    }



    jQuery(function(){

        CommentInit();



        <? if(getIsManage('share')) { ?>

        $('#shareInfobox').hover(function(e){

            $.GetManageMenu('share',<?=$share_detail['share_id']?>,this,e);

        },function(){});

        <? } ?>



    });



    function CommentInit()

    {

        $(".pagination a").click(function(){

            var page = $(this).attr('page');

            $.Get_Share_Comment("<?=$share_detail['share_id']?>",page,'#SHARE_COMMENT_LIST_BOX',CommentInit);

            return false;

        });

    }

</script><? include template('inc/footer'); ?>