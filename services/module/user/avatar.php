<?php
if($_FANWE['uid'] == 0)
	exit;
//$img = FS('Image')->save('avatar','temp',true,array('avatar'=>array(160,160,1)),true);
$img = FS('Image')->save('avatar','temp',true,array('avatar'=>array(200,200,1)),true);//modified by mxf 2012.06.18
if($img['thumb']['avatar']['url'] === false)
	$img['thumb']['avatar']['url'] = "";
outputJson(array('src'=>$img['thumb']['avatar']['url']));
?>