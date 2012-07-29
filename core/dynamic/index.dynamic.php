<?php
//首页动态内容的函数

/**
 * 获取今日达人
 */
function getIndexTodayDaren()
{
	$args['today_daren'] = FS('Daren')->getIndexTodayDaren();
	return tplFetch('inc/index/today_daren',$args);
}

/**
 * 正在分享
 */
function getNewShare()
{
	$args['shares'] = FS('Share')->getNewShare();
	return tplFetch('inc/index/new_share',$args);
}

/**
 * 最新活动,热门主题
 */
function getHotTopic()
{
	$cache_file = getTplCache('inc/index/hot_topic',array(),1);
	if(getCacheIsUpdate($cache_file,600))
	{
		$args['new_events'] = FS('Event')->getHotNewEvent(3);
		$args['hot_topics'] = FS('Topic')->getHotTopicList(0,0,3);
	}

	return tplFetch('inc/index/hot_topic',$args,'',$cache_file);
}

/**
 * 分类最近7天热门分享
 */
function getDayCateShare()
{
	$args = array();
	$cache_file = getTplCache('inc/index/cate_share',array(),1);
	if(getCacheIsUpdate($cache_file,600))
	{
		$args['cate_list'] = FS('Share')->getIndexShareHotTags();
	}

	return tplFetch('inc/index/cate_share',$args,'',$cache_file);
}

/**
 * 分类最新的主题
 */
function getIndexTopic()
{
	global $_FANWE;
	$args = array();
	$cache_file = getTplCache('inc/index/new_topic',array(),1);
	if(getCacheIsUpdate($cache_file,600))
	{
		$res = FDB::query('SELECT fid,thread_count FROM '.FDB::table('forum').' WHERE parent_id = 0');
		while($data = FDB::fetch($res))
		{
			$_FANWE['cache']['forums']['all'][$data['fid']]['thread_count'] = $data['thread_count'];
		}

		$args['new_list'] = FS('Topic')->getImgTopic('new',7,4);
		$args['ask_list'] = FS('Ask')->getImgAsk('new',2,1);
	}

	return tplFetch('inc/index/topics',$args,'',$cache_file);
}

/**
 * 分类最新的主题
 */
function getDarenLists()
{
	$args['daren_list'] = FS('Daren')->getDarens();
	return tplFetch('inc/index/daren_list',$args);
}

/**
 * 搭配秀列表
 */
function getDapeiLists()
{
	$args = array();
	$cache_file = getTplCache('inc/index/dapei_list',array(),1);
	if(getCacheIsUpdate($cache_file,600))
	{
		$args['dapei_list'] = FS('Share')->getPhotoListByType("dapei");
	}
	return tplFetch('inc/index/dapei_list',$args,'',$cache_file);
}
/**
 * 晒货列表
 */
function getLookLists()
{
	$args = array();
	$cache_file = getTplCache('inc/index/look_list',array(),1);
	if(getCacheIsUpdate($cache_file,600))
	{
		$args['look_list'] = FS('Share')->getPhotoListByType("look");
	}
	return tplFetch('inc/index/look_list',$args,'',$cache_file);
}

/**
 * 热门杂志列表
 */
function getIndexHotAblum(){
	$args = array();
	$cache_file = getTplCache('inc/index/album_list',array(),1);
	if(getCacheIsUpdate($cache_file,600))
	{
		$args['album_list'] = FS("Album")->getIndexAlbums(6);
	}
	return tplFetch('inc/index/album_list',$args,'',$cache_file);
}

/**
 * 首页最新分享
 */
function getIndexNewShare()
{
	$args = array();
	//$cache_file = getTplCache('inc/index/index_new_share',array(),1);
	if(getCacheIsUpdate($cache_file,600))
	{
		$sql = "SELECT s.* FROM ".FDB::table("share")." as s 
				INNER JOIN ".FDB::table("share_category")." as sc ON sc.share_id = s.share_id 
				INNER JOIN ".FDB::table("goods_category_tags")." as gct ON gct.cate_id = sc.cate_id
				WHERE s.is_index=1 AND s.status=1 and s.title='' GROUP BY s.share_id ORDER BY s.share_id desc limit 15";
		$v['share_list'] = FDB::fetchAll($sql);
		foreach($v['share_list'] as $kk=>$vv)
		{
			$tag['tag_name'] = $vv['tag_name'];
			$tag['tag_code'] = $vv['tag_name'];
			$tag['encode'] = urlencode($vv['tag_name']);
			$v['hot_tags'][$vv['tag_name']] = $tag;
		}
		$v['share_list'] = FS("Share")->getShareDetailList($v['share_list']);
		$args = $v;
//		echo "<pre>";
//		var_dump($v);
	}
	return tplFetch('inc/index/index_new_share',$args,'',$cache_file);
}

/**
 * 首页分类推荐分享
 */
function getIndexCateShare()
{
 	$args = array();
	//$cache_file = getTplCache('inc/index/index_cate_share',array(),1);
	if(getCacheIsUpdate($cache_file,600))
	{
	 	global $_FANWE;
	 	FanweService::instance()->cache->loadCache('goods_category');
	 	$cate_indexs = $_FANWE['cache']['goods_category']['all'];
//	 	var_dump($cate_indexs);
	 	foreach($cate_indexs as $k=>$v)
		{
			if($v['child'])
			{
				$arr = array();
				foreach ($v['child'] as $val)
				{
					FanweService::instance()->cache->loadCache('goods_category_tags_'.$val);
					$arr[$val]['tagArr'] = $_FANWE['cache']['goods_category_tags_'.$val];
					$arr[$val]['name'] = $cate_indexs[$val]['cate_name'];
				}
				unset($v['child']);
			}
//			var_dump($arr);
			$v['child'] = $arr;
			if($v['parent_id']==0 && $v['is_index']==1)
			{
				$cids = array();
				FS('Share')->getChildCids($v['cate_id'],$cids);
				/*$tags = FDB::fetchAll("select gt.tag_name,gt.tag_code from ".FDB::table("goods_category_tags")." as gct INNER JOIN ".FDB::table("goods_tags")." as gt on gt.tag_id = gct.tag_id where gct.cate_id in (".implode(",",$cids).") order by  gct.weight desc,gt.count desc,gt.tag_id desc limit 12");
				foreach($tags as $tk=>$tv){
					$tags[$tk]["encode"] = urlencode($tv['tag_code']);
				}
				$v['hot_tags'] = $tags ;
				*/
				$v['share_count'] = FDB::resultFirst("select count(*) from ".FDB::table("share")." as s INNER JOIN ".FDB::table("share_category")." as sc ON sc.share_id = s.share_id where s.status=1 and sc.cate_id in (".implode(",",$cids).")");
				$v['user'] = array();
//				$users = FDB::fetchAll("select DISTINCT(s.uid) as uid from ".FDB::table("share")." as s INNER JOIN ".FDB::table("share_category")." as sc ON sc.share_id = s.share_id where sc.cate_id in (".implode(",",$cids).") AND s.status=1 order by s.share_id desc limit 10");
//				foreach ($users as $kk=>$vv)
//				{	$user = FS("User")->getUserShowName($vv['uid']);
//					$v['user'][$vv['uid']] = $user['name'];
//				}
				$sql = "SELECT s.* FROM ".FDB::table("share")." as s 
						INNER JOIN ".FDB::table("share_category")." as sc ON sc.share_id = s.share_id 
						INNER JOIN ".FDB::table("goods_category_tags")." as gct ON gct.cate_id = sc.cate_id
						WHERE gct.cate_id in (".implode(",",$cids).") AND s.is_index=1 AND s.status=1 and s.title!='' GROUP BY s.share_id ORDER BY s.sort desc,s.share_id desc limit 30";
//				echo $sql.'<br>';
				$v['share_list'] = FDB::fetchAll($sql);
				foreach($v['share_list'] as $kk=>$vv)
				{
					$tag['tag_name'] = $vv['tag_name'];
					$tag['tag_code'] = $vv['tag_name'];
					$tag['encode'] = urlencode($vv['tag_name']);
					$v['hot_tags'][$vv['tag_name']] = $tag;
				}
				$v['share_list'] = FS("Share")->getShareDetailList($v['share_list']);
				$args['cate_list'][] = $v;
			}
		}
//		var_dump($args['cate_list']);
		unset($cate_indexs);
	}
	return tplFetch('inc/index/index_cate_share',$args,'',$cache_file);
}

/**
 * 首页热门搜索、品牌、风格
 */
function getIndexHotManu(){
	$args = array();
	//$cache_file = getTplCache('inc/index/hot_manu',array(),1);
	if(getCacheIsUpdate($cache_file,600))
	{
		global $_FANWE;
		$args['search_cate'] = $_FANWE['cache']['goods_category']['all'][41]['cate_name'];
		$args['manu_cate'] = $_FANWE['cache']['goods_category']['all'][42]['cate_name'];
		$args['touch_cate'] = $_FANWE['cache']['goods_category']['all'][43]['cate_name'];
		FanweService::instance()->cache->loadCache('goods_category_tags_41');
		FanweService::instance()->cache->loadCache('goods_category_tags_42');
		FanweService::instance()->cache->loadCache('goods_category_tags_43');
		$args['search_list'] = $_FANWE['cache']['goods_category_tags_41'];
		$args['manu_list'] = $_FANWE['cache']['goods_category_tags_42'];
		$args['touch_list'] = $_FANWE['cache']['goods_category_tags_43'];
	}
	return tplFetch('inc/index/hot_manu',$args,'',$cache_file);
}

/**
 * 首页热门话题
 */
function getIndexHotThread()
{
	$args = array();
	//$cache_file = getTplCache('inc/index/hot_thread',array(),1);
	if(getCacheIsUpdate($cache_file,600))
	{
		global $_FANWE;
		$sql = 'SELECT ft.fid,ft.tid,ft.title,ft.content,ft.create_time,ft.lastpost,ft.lastposter,
			ft.uid,ft.post_count,ft.share_id,s.cache_data,ft.is_top,ft.is_best,s.click_count,s.relay_count 
			FROM '.FDB::table('forum_thread').' AS ft 
			INNER JOIN '.FDB::table('share').' AS s ON s.share_id = ft.share_id 
			WHERE ft.is_index=1 ORDER BY ft.tid desc LIMIT 6';
		$res = $v['share_list'] = FDB::fetchAll($sql);
		foreach ($res as &$val)
		{
			if(!empty($data['lastposter'])) $data['last_time'] = getBeforeTimelag($val['lastpost']);
			$val['title_t'] = cutStr($val['title'], 12);
			$val['cache_data'] = fStripslashes(unserialize($val['cache_data']));
			$val['time'] = getBeforeTimelag($val['create_time']);
			$val['last_time'] = getBeforeTimelag($val['lastpost']);
			$val['url'] = FU('club/detail',array('tid'=>$val['tid']));
			FS('Share')->shareImageFormat($val,1);
            unset($val['cache_data']);
            $args['hot_thread'][] = $val;
		}
	}
	return tplFetch('inc/index/hot_thread',$args,'',$cache_file);
}

/**
 * 首页话题、公告
 */
function getIndexThreadUser()
{
	$args = array();
	//$cache_file = getTplCache('inc/index/thread_user',array(),1);
	if(getCacheIsUpdate($cache_file,600))
	{
		global $_FANWE;
		$sql = 'SELECT ft.fid,ft.tid,ft.title,ft.content,ft.create_time,ft.lastpost,ft.lastposter,
			ft.uid,ft.post_count,ft.share_id,s.cache_data,ft.is_top,ft.is_best,s.click_count,s.relay_count,u.user_name 
			FROM '.FDB::table('forum_thread').' AS ft 
			INNER JOIN '.FDB::table('share').' AS s ON s.share_id = ft.share_id
			LEFT JOIN '.FDB::table('user').' AS u ON u.uid=s.uid
			WHERE ft.is_index=1 ORDER BY ft.tid desc LIMIT 1';
		$res = FDB::fetchAll($sql);
		$sql = 'SELECT ft.fid,ft.tid,ft.title,ft.content,ft.create_time,ft.lastpost,ft.lastposter,
			ft.uid,ft.post_count,ft.share_id,s.cache_data,ft.is_top,ft.is_best,s.click_count,s.relay_count
			FROM '.FDB::table('forum_thread').' AS ft 
			INNER JOIN '.FDB::table('share').' AS s ON s.share_id = ft.share_id
			WHERE ft.uid=6 ORDER BY ft.tid desc LIMIT 4';
		$res_t = FDB::fetchAll($sql);
		$res = array_merge($res, $res_t);
		foreach ($res as &$val)
		{
			if(!empty($data['lastposter'])) $data['last_time'] = getBeforeTimelag($val['lastpost']);
			$val['content_t'] = cutStr($val['content'], 35);
			$val['title_t'] = cutStr($val['title'], 15);
			$val['cache_data'] = fStripslashes(unserialize($val['cache_data']));
			$val['time'] = getBeforeTimelag($val['create_time']);
			$val['last_time'] = getBeforeTimelag($val['lastpost']);
			$val['url'] = FU('club/detail',array('tid'=>$val['tid']));
			FS('Share')->shareImageFormat($val,1);
            unset($val['cache_data']);
            $args['thread_user'][] = $val;
		}
	}
	return tplFetch('inc/index/thread_user',$args,'',$cache_file);
}

/**
 * 首页热度排行
 */
function getIndexHotRank()
{
	$args = array();
	//$cache_file = getTplCache('inc/index/hot_rank',array(),1);
	if(getCacheIsUpdate($cache_file,600))
	{
		global $_FANWE;
		$sql = "SELECT s.* FROM ".FDB::table("share")." as s 
				WHERE s.status=1 and s.type='default' ORDER BY s.click_count desc limit 6";
		$res = FDB::fetchAll($sql);
		$res = FS("Share")->getShareDetailList($res);
		foreach ($res as &$val)
		{
			$val['content_t'] = cutStr(preg_replace('/\[(.*?)\]$/is','',($val['content'])), 20);
		}
		$args['hot_rank'] = $res;
//		echo "<pre>";
//		var_dump($res);die;
	}
	return tplFetch('inc/index/hot_rank',$args,'',$cache_file);
}

//首页会员
function getIndexUser()
{
	//$cache_file = getTplCache('inc/index/index_user',array(),1);
	if(getCacheIsUpdate($cache_file,600))
	{
		global $_FANWE;
		$res['look'] = FDB::fetchAll("SELECT uid FROM ".FDB::table("user_count")." ORDER BY look desc,uid asc limit 3");
		$res['dapei'] = FDB::fetchAll("SELECT uid FROM ".FDB::table("user_count")." ORDER BY dapei desc,uid asc limit 3");
		$res['albums'] = FDB::fetchAll("SELECT uid FROM ".FDB::table("user_count")." ORDER BY albums desc,uid asc limit 3");
//		echo   "<pre>";
//		var_dump($res);die;
		foreach ($res as $key => &$val)
		{
			foreach ($val as $val_f)
			{
				$arr[$key][] = FS("User")->getUserById($val_f['uid']);
			}
		}
		$args['index_user'] = $arr;
//		echo "<pre>";
//		var_dump($arr);die;
	}
	return tplFetch('inc/index/index_user',$args,'',$cache_file);
}
?>