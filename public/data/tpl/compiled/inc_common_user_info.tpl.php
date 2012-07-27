<? if(!defined('IN_FANWE')) exit('Access Denied'); ?>
<div class="logins">
    
    <? if($_FANWE['uid'] > 0) { ?>
     <ul class="links">     
        <li class="avatar"><a href="<?php echo FU('u/me',array()); ?>" rel="nofollow"><img src="<?php echo avatar($_FANWE['uid'],'s',$_FANWE['user']['server_code'],1);?>"></a></li>	
        <li class="name"><a href="<?php echo FU('u/me',array()); ?>" rel="nofollow"><?=$_FANWE['user_name']?></a></li>	
        <li class="weibo"><a href="<?=$_FANWE['site_root']?>login.php?mod=sina" rel="nofollow">微博</a></li>	
        <li class="collect"><a href="#" rel="nofollow">收藏</a></li>	
        <li class="show"><a href="#" rel="nofollow">晒货</a></li>
        <li class="tuic"><a href="<?php echo FU('user/logout',array()); ?>" rel="nofollow">退出</a></li>
    </ul>
    <a href="#" class="weibo_amount">n</a>
    <? } else { ?>
    <ul class="links">
        <li class="login"><a href="<?php echo FU('user/login',array()); ?>" rel="nofollow">登录</a></li>   
        <li class="">|</li>  
        <li class="signup"><a href="<?php echo FU('user/register',array()); ?>" target="_blank" rel="nofollow">注册</a></li>
    </ul>
    <? } ?>
</div>
