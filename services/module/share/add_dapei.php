<?php
//$cache_file = getTplCache('services/share/add_dapei');
if(!@include($cache_file))
{
	FanweService::instance()->cache->loadCache('business');
	$business = $_FANWE['cache']['business'];
	include template('services/share/add_dapei');
}			
display($cache_file);
?>