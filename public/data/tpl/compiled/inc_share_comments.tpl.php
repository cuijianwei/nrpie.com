<? if(!defined('IN_FANWE')) exit('Access Denied'); 
0
|| checkTplRefresh('./tpl/nrpie/inc/share/comments.htm', './tpl/nrpie/inc/pages.htm', 1343313178, './data/tpl/compiled/inc_share_comments.tpl.php', './tpl/nrpie', 'inc/share/comments')
;?>
<ul id="SHARE_COMMENT_LIST_<?=$share['share_id']?>" class="c_l rb5"><? if(is_array($comments)) { foreach($comments as $comment) { ?><li class="c_f" id="COMMENT_<?=$comment['comment_id']?>"><?php echo setTplUserFormat($comment['uid'],1,0,'s',0,'','avt',''); ?><p class="sms"><?php echo setTplUserFormat($comment['uid'],0,1,'',0,'n icard','',''); ?>：回复<?=$comment['content']?><span>（<?=$comment['time']?>）</span></p>
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