<? if(!defined('IN_FANWE')) exit('Access Denied'); if($is_follow > -1) { ?>
<div class="user_fo_st">
<? if($is_follow == 0) { ?>
<a href="javascript:;" onclick="$.User_Follow(<?=$uid?>,this,UpdateUserFollow);"><img src="./tpl/images/addfollower.png"></a>
<? } else { ?>
<img src="./tpl/<?=TMPL?>/images/add_ok_03.png">
<? } ?>
</div>
<? } ?>