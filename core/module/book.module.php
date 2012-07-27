<?php
class BookModule
{
	const CATE_TYPE_ONE = 1;
	const CATE_TYPE_TWO = 2;
	static $sortArr = array(
		"new"	=> "new",
		"hot7"	=> "hot7",
		"pop"	=> "pop",
	);
	static $psortArr = array(
		"all" 	=> "all",
		"p1"	=> "100以下",
		"p2"	=> "101~200",
		"p3"	=> "201~500",
		"high"	=> "500以上",
	);
	static $csortArr = array(
		"c1" 	=> "red",
		"c2"	=> "orange",
		"c3"	=> "yellow",
		"c4"	=> "green",
		"c5"	=> "blue",
		"c6"	=> "white",
	);
	static $searchTypeArr = array(
		"goods"		=> "goods",
		"brand"		=> "brand",
		"person"	=> "person",
		"all"		=> "all",
	);
	public function cate()
	{
		global $_FANWE;
		$category = urldecode($_FANWE['request']['cate']);
		$type     = urldecode($_FANWE['request']['type']);
		if(!isset($_FANWE['cache']['goods_category']['cate_code'][$category])){
			fHeader('location: '.FU('book/shopping'));
		}
		
		switch($type)
		{
			case self::CATE_TYPE_TWO://二级分类入口
				self::getListCateTwo();
				break;
			case self::CATE_TYPE_ONE:;
			default://默认走一级分类入口
				self::getListCateOne();
		}
	}

	public function shopping()
	{
		self::getListShopping();
	}

	public function search()
	{
		self::getListSearch();
	}

	/******新增方法*****/

	//默认展示所有分享入口
	private function getListShopping()
	{
		global $_FANWE;
		$_FANWE['user_click_share_id'] = (int)$_FANWE['request']['sid'];
		unset($_FANWE['request']['sid']);
		
		$cache_file = getTplCache('page/book/book_shopping',$_FANWE['request'],2);
		if(getCacheIsUpdate($cache_file,BOOK_CACHE_PAGE_TIME,1))
		{
			$page_args = array();
			$cate_id = $_FANWE['cache']['goods_category']['root'];
	
			$category_data = $_FANWE['cache']['goods_category']['all'][$cate_id];
			$cate_name = $category_data['cate_name'];
			$cate_code = $category_data['cate_code'];
			$desc      = $category_data['desc'];
			$category_tags = array();
	
			$_FANWE['nav_title'] = $category_data['cate_name'];
			
			if(!empty($category_data['seo_keywords']))
			{
				$_FANWE['seo_keywords'] = $category_data['seo_keywords'];
				$_FANWE['setting']['site_keywords'] = '';
			}
			
			if(!empty($category_data['seo_desc']))
			{
				$_FANWE['seo_description'] = $category_data['seo_desc'];
				$_FANWE['setting']['site_description'] = '';
			}

			$sort 				= isset(self::$sortArr[$_FANWE['request']['sort']]) ? $_FANWE['request']['sort'] : "new";
			$page_args['sort'] 	= isset($sort) ? $sort : "new";
			$psort 				= isset(self::$psortArr[$_FANWE['request']['psort']]) ? $_FANWE['request']['psort'] : null;
			if(isset($psort)){
				$page_args['psort']	=	$psort;
			}
			$csort 				= isset(self::$csortArr[$_FANWE['request']['csort']]) ? $_FANWE['request']['csort'] : null;
			if(isset($csort)){
				$page_args['csort']	=	$csort;
			}
			
			$condition = " WHERE s.share_data IN ('goods','photo','goods_photo')";
			if(isset($psort) || isset($csort)){
				$condition = " WHERE s.share_data IN ('goods','goods_photo')";
			}

			$title = $category_data['short_name'];
			$is_match = false;
			$tag = urldecode($_FANWE['request']['tag']);
			if(!empty($tag))
			{
				$_FANWE['nav_title'] = $tag .' - '. $_FANWE['nav_title'];
				$title = htmlspecialchars($tag);
				$is_match = true;
				//$match_key = FS('Words')->segment($tag,10);
				//$match_key = tagToUnicode($match_key,'+');
				$match_key = segmentToUnicode($tag,'+');
				$condition.=" AND match(sm.content_match) against('".$match_key."' IN BOOLEAN MODE) ";
				$page_args['tag'] = urlencode($tag);
			}
	
			//取通用排序条件信息			
			$arra 		= self::getGeneralCondition($sort);
			$field 		= $arra["field"];
			$order_by  	= $arra["order_by"];
			//取通用排序URL
			$new_url = $hot7_url = $pop_url = array();
			self::getGeneralNavInfo($sort,$page_args,$new_url,$hot7_url,$pop_url);

			//取价格排序条件信息
			if(isset($psort)){
				$arrb 		= self::getPriceCondition($psort);
				$condition .= $arrb["condition"];
			}
			//取价格排序URL
			$pall_url = $p1_url = $p2_url = $p3_url = $phigh_url = array();			
			self::getPriceNavInfo($psort,$page_args,$pall_url,$p1_url,$p2_url,$p3_url,$phigh_url);
			
			//取颜色筛选条件信息
			if(isset($csort)){
				$arrc 		= self::getColorCondition($csort);
				$condition .= $arrc["condition"];
			}
			//取颜色筛选URL
			$c1_url = $c2_url = $c3_url = $c4_url = $c5_url = $c6_url = array();			
			self::getColorNavInfo($csort,$page_args,$c1_url,$c2_url,$c3_url,$c4_url,$c5_url,$c6_url);
	
			//取数据
			$pager = array();
			$share_list = self::processResult($page_args,$field,$psort,$csort,$is_match,$condition,$order_by,$pager);
	
			include template('page/book/book_shopping');
			display($cache_file);
			exit;
		}
		else
		{
			include $cache_file;
			display();
		}
	}
	
	//一级分类入口
    private function getListCateOne()
	{
		global $_FANWE;
		$_FANWE['user_click_share_id'] = (int)$_FANWE['request']['sid'];
		unset($_FANWE['request']['sid']);

		$cache_file = getTplCache('page/book/book_cate_one',$_FANWE['request'],2);
		if(getCacheIsUpdate($cache_file,BOOK_CACHE_PAGE_TIME,1))
		{
			$category = urldecode($_FANWE['request']['cate']);
			$page_args = array();
			if(isset($_FANWE['cache']['goods_category']['cate_code'][$category]))
			{
				$page_args['cate'] = $_FANWE['request']['cate'];
				$cate_id = $_FANWE['cache']['goods_category']['cate_code'][$category];
				$goods_cate_code = $category;
			}
			if(!$cate_id || ($_FANWE['cache']['goods_category']['root'] == $cate_id))
			{//如果没有取到或取到的是默认分类，跳转
				fHeader("Location:{$_FANWE['site_root']}book.php?action=shopping");
			}
			
			$category_data = $_FANWE['cache']['goods_category']['all'][$cate_id];
			$cate_name = $category_data['cate_name'];
			$cate_code = $category_data['cate_code'];
			$desc      = $category_data['desc'];
			$category_tags = array();
			
			$_FANWE['nav_title'] = $category_data['cate_name'];
			
			if(!empty($category_data['seo_keywords']))
			{
				$_FANWE['seo_keywords'] = $category_data['seo_keywords'];
				$_FANWE['setting']['site_keywords'] = '';
			}
			
			if(!empty($category_data['seo_desc']))
			{
				$_FANWE['seo_description'] = $category_data['seo_desc'];
				$_FANWE['setting']['site_description'] = '';
			}
	
			$child_ids = $params = array();
			if(isset($category_data['child']))
			{
				$child_ids = $category_data['child'];
				$tagurlpara['cate'] = urlencode($category_data['cate_code']);
				foreach($category_data['child'] as $child_id)
				{
					$child_cate = $_FANWE['cache']['goods_category']['all'][$child_id];
					$params = array("action"=>"cate","cate"=>$category,"cid"=>$child_cate['cate_id'],"type"=>self::CATE_TYPE_TWO);
					$child_cate["url"] = "./book.php?".http_build_query($params);
					$tag_key = 'goods_category_tags_'.$child_id;
					FanweService::instance()->cache->loadCache($tag_key);
					foreach($_FANWE['cache'][$tag_key] as $k => $tag)
					{
						if($k > 15){
							break;
						}
						$tagurlpara['tag'] = urlencode($tag['tag_name']);
						$tagurlpara['cid'] = urlencode($params['cid']);
						$tagurlpara['type'] = urlencode($params['type']);
						$tag['url'] = FU("book/".ACTION_NAME,$tagurlpara);
						$child_cate['tags'][] = $tag;						
					}
					$category_tags[] = $child_cate;
				}
			}
			
			$sort 				= isset(self::$sortArr[$_FANWE['request']['sort']]) ? $_FANWE['request']['sort'] : "new";
			$page_args['sort'] 	= isset($sort) ? $sort : "new";
			$psort 				= isset(self::$psortArr[$_FANWE['request']['psort']]) ? $_FANWE['request']['psort'] : null;
			if(isset($psort)){
				$page_args['psort']	=	$psort;
			}
			$csort 				= isset(self::$csortArr[$_FANWE['request']['csort']]) ? $_FANWE['request']['csort'] : null;
			if(isset($csort)){
				$page_args['csort']	=	$csort;
			}
			
			$condition = " WHERE s.share_data IN ('goods','photo','goods_photo')";
			if(isset($psort) || isset($csort)){
				$condition = " WHERE s.share_data IN ('goods','goods_photo')";
			}
						
			$cids = array();
			FS('Share')->getChildCids($cate_id,$cids);
			$condition .= " AND sc.cate_id IN (".implode(',',$cids).")";
	
			$title = $category_data['short_name'];
			$is_match = false;
			$tag = urldecode($_FANWE['request']['tag']);
			if(!empty($tag))
			{
				$_FANWE['nav_title'] = $tag .' - '. $_FANWE['nav_title'];
				$title = htmlspecialchars($tag);
				$is_match = true;
				//$match_key = FS('Words')->segment($tag,10);
				//$match_key = tagToUnicode($match_key,'+');
				$match_key = segmentToUnicode($tag,'+');
				$condition.=" AND match(sm.content_match) against('".$match_key."' IN BOOLEAN MODE) ";
				$page_args['tag'] = urlencode($tag);
			}
			
			//取通用排序条件信息			
			$arra 		= self::getGeneralCondition($sort);
			$field 		= $arra["field"];
			$order_by  	= $arra["order_by"];
			//取通用排序URL
			$new_url = $hot7_url = $pop_url = array();
			self::getGeneralNavInfo($sort,$page_args,$new_url,$hot7_url,$pop_url);

			//取价格排序条件信息
			if(isset($psort)){
				$arrb 		= self::getPriceCondition($psort);
				$condition .= $arrb["condition"];
			}
			//取价格排序URL
			$pall_url = $p1_url = $p2_url = $p3_url = $phigh_url = array();			
			self::getPriceNavInfo($psort,$page_args,$pall_url,$p1_url,$p2_url,$p3_url,$phigh_url);
			
			//取颜色筛选条件信息
			if(isset($csort)){
				$arrc 		= self::getColorCondition($csort);
				$condition .= $arrc["condition"];
			}
			//取颜色筛选URL
			$c1_url = $c2_url = $c3_url = $c4_url = $c5_url = $c6_url = array();			
			self::getColorNavInfo($csort,$page_args,$c1_url,$c2_url,$c3_url,$c4_url,$c5_url,$c6_url);

			//取数据
			$pager = array();
			$share_list = self::processResult($page_args,$field,$psort,$csort,$is_match,$condition,$order_by,$pager);
			//var_dump($share_list);			
			
			include template('page/book/book_cate_one');
			display($cache_file);
			exit;
		}
		else
		{
			include $cache_file;
			display();
		}
	}
	
	//二级分类入口
    private function getListCateTwo()
	{
		global $_FANWE;
		$_FANWE['user_click_share_id'] = (int)$_FANWE['request']['sid'];
		unset($_FANWE['request']['sid']);
		
		$cache_file = getTplCache('page/book/book_cate_two',$_FANWE['request'],2);
		if(getCacheIsUpdate($cache_file,BOOK_CACHE_PAGE_TIME,1))
		{
			$category = urldecode($_FANWE['request']['cate']);//一级分类代码标示
			$cate_id_child      = urldecode($_FANWE['request']['cid']);//子分类CID
			$page_args = array();
			//var_dump($_FANWE['cache']);
			if($_FANWE['cache']['goods_category']['cate_code'][$category])
			{
				$page_args['cate'] = urlencode($category);
				$page_args['type'] = self::CATE_TYPE_TWO;
				$cate_id_root = $_FANWE['cache']['goods_category']['cate_code'][$category];//一级分类CID
				$goods_cate_code = $category;
			}
			if(!$cate_id_root || ($_FANWE['cache']['goods_category']['root'] == $cate_id_root))
			{//如果没有取到或取到的是默认分类，跳转
				fHeader("Location:{$_FANWE['site_root']}book.php?action=shopping");
			}
			
			$category_data = $_FANWE['cache']['goods_category']['all'][$cate_id_root];
			
			$category_tags = array();
	
			$_FANWE['nav_title'] = $category_data['cate_name'];
			
			if(!empty($category_data['seo_keywords']))
			{
				$_FANWE['seo_keywords'] = $category_data['seo_keywords'];
				$_FANWE['setting']['site_keywords'] = '';
			}
			
			if(!empty($category_data['seo_desc']))
			{
				$_FANWE['seo_description'] = $category_data['seo_desc'];
				$_FANWE['setting']['site_description'] = '';
			}
	
			$child_ids = $params = array();
			if(isset($category_data['child']))
			{//将一级分类下子分类及对应Tag全部取出
				$child_ids = $category_data['child'];
				$tagurlpara['cate'] = urlencode($category_data['cate_code']);
				
				foreach($category_data['child'] as $child_id)
				{
					$child_cate = $_FANWE['cache']['goods_category']['all'][$child_id];
					$params = array("action"=>"cate","cate"=>$category,"cid"=>$child_cate['cate_id'],"type"=>self::CATE_TYPE_TWO);
					$child_cate["url"] = "./book.php?".http_build_query($params);
					if($cate_id_child == $child_cate["cate_id"]){//发现子分类ID与传参CID相同时，对cate_id重新赋值
						$cate_id = $cate_id_child;
						$page_args['cid'] = $cate_id;
					}
					$tag_key = 'goods_category_tags_'.$child_id;
					FanweService::instance()->cache->loadCache($tag_key);
					foreach($_FANWE['cache'][$tag_key] as $k => $tag)
					{
						if($k > 11){
							break;
						}
						$tagurlpara['tag'] = urlencode($tag['tag_name']);
						$tagurlpara['cid'] = urlencode($params['cid']);
						$tagurlpara['type'] = urlencode($params['type']);
						$tag['url'] = FU("book/".ACTION_NAME,$tagurlpara);
						$child_cate['tags'][] = $tag;						
					}
					$category_tags[] = $child_cate;
				}
			}
			//var_dump($category_tags);

			$sort 				= isset(self::$sortArr[$_FANWE['request']['sort']]) ? $_FANWE['request']['sort'] : "new";
			$page_args['sort'] 	= isset($sort) ? $sort : "new";
			$psort 				= isset(self::$psortArr[$_FANWE['request']['psort']]) ? $_FANWE['request']['psort'] : null;
			if(isset($psort)){
				$page_args['psort']	=	$psort;
			}
			$csort 				= isset(self::$csortArr[$_FANWE['request']['csort']]) ? $_FANWE['request']['csort'] : null;
			if(isset($csort)){
				$page_args['csort']	=	$csort;
			}
			
			$condition = " WHERE s.share_data IN ('goods','photo','goods_photo')";
			if(isset($psort) || isset($csort)){
				$condition = " WHERE s.share_data IN ('goods','goods_photo')";
			}
			
			$cids = array();
			FS('Share')->getChildCids($cate_id,$cids);
			$condition .= " AND sc.cate_id IN (".implode(',',$cids).")";
	
			$title = $category_data['short_name'];
			$is_match = false;
			$tag = urldecode($_FANWE['request']['tag']);
			if(!empty($tag))
			{
				$_FANWE['nav_title'] = $tag .' - '. $_FANWE['nav_title'];
				$title = htmlspecialchars($tag);
				$is_match = true;
				//$match_key = FS('Words')->segment($tag,10);
				//$match_key = tagToUnicode($match_key,'+');
				$match_key = segmentToUnicode($tag,'+');
				$condition.=" AND match(sm.content_match) against('".$match_key."' IN BOOLEAN MODE) ";
				$page_args['tag'] = urlencode($tag);
			}
	
			//取通用排序条件信息			
			$arra 		= self::getGeneralCondition($sort);
			$field 		= $arra["field"];
			$order_by  	= $arra["order_by"];
			//取通用排序URL
			$new_url = $hot7_url = $pop_url = array();
			self::getGeneralNavInfo($sort,$page_args,$new_url,$hot7_url,$pop_url);

			//取价格排序条件信息
			if(isset($psort)){
				$arrb 		= self::getPriceCondition($psort);
				$condition .= $arrb["condition"];
			}
			//取价格排序URL
			$pall_url = $p1_url = $p2_url = $p3_url = $phigh_url = array();			
			self::getPriceNavInfo($psort,$page_args,$pall_url,$p1_url,$p2_url,$p3_url,$phigh_url);
			
			//取颜色筛选条件信息
			if(isset($csort)){
				$arrc 		= self::getColorCondition($csort);
				$condition .= $arrc["condition"];
			}
			//取颜色筛选URL
			$c1_url = $c2_url = $c3_url = $c4_url = $c5_url = $c6_url = array();			
			self::getColorNavInfo($csort,$page_args,$c1_url,$c2_url,$c3_url,$c4_url,$c5_url,$c6_url);
			
			//取数据
			$pager = array();
			$share_list = self::processResult($page_args,$field,$psort,$csort,$is_match,$condition,$order_by,$pager);
				
			include template('page/book/book_cate_two');
			display($cache_file);
			exit;
		}
		else
		{
			include $cache_file;
			display();
		}
	}

	//搜索	
    private function getListSearch()
	{
		global $_FANWE;
		$_FANWE['user_click_share_id'] = (int)$_FANWE['request']['sid'];
		unset($_FANWE['request']['sid']);

		$cache_file = getTplCache('page/book/book_search',$_FANWE['request'],2);
		if(getCacheIsUpdate($cache_file,BOOK_CACHE_PAGE_TIME,1))
		{
			$page_args = array();
	
			$t    = isset(self::$searchTypeArr[$_FANWE['request']['t']]) ? $_FANWE['request']['t'] : "all";
			$page_args['t'] 	= isset($t) ? $t : "all";
			switch($t)
			{
				case 'goods':
					$condition = " WHERE s.share_data IN ('goods','goods_photo')";
					break;
				case 'branch':
					$condition = " WHERE s.share_data IN ('goods','goods_photo')";
					break;
				case 'person':
					$condition = " WHERE s.share_data IN ('goods','goods_photo')";
					break;
				case 'all':;
				default://全部
					$condition = " WHERE s.share_data IN ('goods','photo','goods_photo')";
			}
			
			$sort 				= isset(self::$sortArr[$_FANWE['request']['sort']]) ? $_FANWE['request']['sort'] : "new";
			$page_args['sort'] 	= isset($sort) ? $sort : "new";
			$psort 				= isset(self::$psortArr[$_FANWE['request']['psort']]) ? $_FANWE['request']['psort'] : null;
			if(isset($psort)){
				$page_args['psort']	=	$psort;
			}
			$csort 				= isset(self::$csortArr[$_FANWE['request']['csort']]) ? $_FANWE['request']['csort'] : null;
			if(isset($csort)){
				$page_args['csort']	=	$csort;
			}
			
			if(isset($psort) || isset($csort)){
				$condition = " WHERE s.share_data IN ('goods','goods_photo')";
			}	
			
			$is_match = false;
			
			$tag = urldecode($_FANWE['request']['tag']);
			if(!empty($tag))
			{
				$_FANWE['nav_title'] = $tag .' - '. $_FANWE['nav_title'];
				$title = htmlspecialchars($tag);
				$is_match = true;
				//$match_key = FS('Words')->segment($tag,10);
				//$match_key = tagToUnicode($match_key,'+');
				$match_key = segmentToUnicode($tag,'+');
				$condition.=" AND match(sm.content_match) against('".$match_key."' IN BOOLEAN MODE) ";
				$page_args['tag'] = urlencode($tag);
			}
	
			//取通用排序条件信息			
			$arra 		= self::getGeneralCondition($sort);
			$field 		= $arra["field"];
			$order_by  	= $arra["order_by"];
			//取通用排序URL
			$new_url = $hot7_url = $pop_url = array();
			self::getGeneralNavInfo($sort,$page_args,$new_url,$hot7_url,$pop_url);

			//取价格排序条件信息
			if(isset($psort)){
				$arrb 		= self::getPriceCondition($psort);
				$condition .= $arrb["condition"];
			}
			//取价格排序URL
			$pall_url = $p1_url = $p2_url = $p3_url = $phigh_url = array();			
			self::getPriceNavInfo($psort,$page_args,$pall_url,$p1_url,$p2_url,$p3_url,$phigh_url);
			
			//取颜色筛选条件信息
			if(isset($csort)){
				$arrc 		= self::getColorCondition($csort);
				$condition .= $arrc["condition"];
			}
			//取颜色筛选URL
			$c1_url = $c2_url = $c3_url = $c4_url = $c5_url = $c6_url = array();			
			self::getColorNavInfo($csort,$page_args,$c1_url,$c2_url,$c3_url,$c4_url,$c5_url,$c6_url);
	
			//取数据
			$pager = array();
			$share_list = self::processResult($page_args,$field,$psort,$csort,$is_match,$condition,$order_by,$pager);
			
			include template('page/book/book_search');
			display($cache_file);
			exit;
		}
		else
		{
			include $cache_file;
			display();
		}
	}

	//搭配
	public function dapei()
	{
		global $_FANWE;
		$_FANWE['user_click_share_id'] = (int)$_FANWE['request']['sid'];
		unset($_FANWE['request']['sid']);
		$cache_file = getTplCache('page/book/book_dapei',$_FANWE['request'],2);
		if(getCacheIsUpdate($cache_file,BOOK_CACHE_PAGE_TIME,1))
		{
			FanweService::instance()->cache->loadCache('style_category');
	
			$category_data = $_FANWE['cache']['style_category']['all'][1];
			$category_tags = array();
			
			$_FANWE['nav_title'] = $category_data['cate_name'];
	
			$sort 				= isset(self::$sortArr[$_FANWE['request']['sort']]) ? $_FANWE['request']['sort'] : "new";
			$page_args['sort'] 	= isset($sort) ? $sort : "new";
			$psort 				= isset(self::$psortArr[$_FANWE['request']['psort']]) ? $_FANWE['request']['psort'] : null;
			if(isset($psort)){
				$page_args['psort']	=	$psort;
			}
			$csort 				= isset(self::$csortArr[$_FANWE['request']['csort']]) ? $_FANWE['request']['csort'] : null;
			if(isset($csort)){
				$page_args['csort']	=	$csort;
			}
			
			$condition = " WHERE sp.type = 'dapei' AND s.status=1 ";			
			if(isset($psort) || isset($csort)){
				$condition .= " AND s.share_data IN ('goods','goods_photo')";
			}
			
			$title = $category_data['short_name'];
			$is_match = false;
			$tag = urldecode($_FANWE['request']['tag']);
			if(!empty($tag))
			{
				$_FANWE['nav_title'] = $tag .' - '. $_FANWE['nav_title'];
				$title = htmlspecialchars($tag);
				$is_match = true;
				$match_key = segmentToUnicode($tag,'+');
				$condition.=" AND match(sm.content_match) against('".$match_key."' IN BOOLEAN MODE) ";
				$page_args['tag'] = urlencode($tag);
			}
	
			//取通用排序条件信息			
			$arra 		= self::getGeneralCondition($sort);
			$field 		= $arra["field"];
			$order_by  	= $arra["order_by"];
			//取通用排序URL
			$new_url = $hot7_url = $pop_url = array();
			self::getGeneralNavInfo($sort,$page_args,$new_url,$hot7_url,$pop_url);

			//取价格排序条件信息
			if(isset($psort)){
				$arrb 		= self::getPriceCondition($psort);
				$condition .= $arrb["condition"];
			}
			//取价格排序URL
			$pall_url = $p1_url = $p2_url = $p3_url = $phigh_url = array();			
			self::getPriceNavInfo($psort,$page_args,$pall_url,$p1_url,$p2_url,$p3_url,$phigh_url);
			
			//取颜色筛选条件信息
			if(isset($csort)){
				$arrc 		= self::getColorCondition($csort);
				$condition .= $arrc["condition"];
			}
			//取颜色筛选URL
			$c1_url = $c2_url = $c3_url = $c4_url = $c5_url = $c6_url = array();			
			self::getColorNavInfo($csort,$page_args,$c1_url,$c2_url,$c3_url,$c4_url,$c5_url,$c6_url);
			
			//取数据
			$pager = array();
			$share_list = self::processDaPeiResult($page_args,$field,$psort,$csort,$is_match,$condition,$order_by,$pager);
	
			include template('page/book/book_dapei');
			display($cache_file);
			exit;
		}
		else
		{
			include $cache_file;
			display();
		}
	}
	
	//晒货
	public function look()
	{
		global $_FANWE;
		$_FANWE['user_click_share_id'] = (int)$_FANWE['request']['sid'];
		unset($_FANWE['request']['sid']);
		$cache_file = getTplCache('page/book/book_look',$_FANWE['request'],2);
		if(getCacheIsUpdate($cache_file,BOOK_CACHE_PAGE_TIME,1))
		{
			FanweService::instance()->cache->loadCache('style_category');
	
			$category_data = $_FANWE['cache']['style_category']['all'][2];
			$category_tags = array();
			
			$_FANWE['nav_title'] = $category_data['cate_name'];
	
			$sort 				= isset(self::$sortArr[$_FANWE['request']['sort']]) ? $_FANWE['request']['sort'] : "new";
			$page_args['sort'] 	= isset($sort) ? $sort : "new";
			$psort 				= isset(self::$psortArr[$_FANWE['request']['psort']]) ? $_FANWE['request']['psort'] : null;
			if(isset($psort)){
				$page_args['psort']	=	$psort;
			}
			$csort 				= isset(self::$csortArr[$_FANWE['request']['csort']]) ? $_FANWE['request']['csort'] : null;
			if(isset($csort)){
				$page_args['csort']	=	$csort;
			}
	
			$condition = " WHERE sp.type = 'look' AND s.status=1 ";
			if(isset($psort) || isset($csort)){
				$condition .= " AND s.share_data IN ('goods','goods_photo')";
			}
			
			$title = $category_data['short_name'];
			$is_match = false;
			$tag = urldecode($_FANWE['request']['tag']);
			if(!empty($tag))
			{
				$_FANWE['nav_title'] = $tag .' - '. $_FANWE['nav_title'];
				$title = htmlspecialchars($tag);
				$is_match = true;
				$match_key = segmentToUnicode($tag,'+');
				$condition.=" AND match(sm.content_match) against('".$match_key."' IN BOOLEAN MODE) ";
				$page_args['tag'] = urlencode($tag);
			}
	
			//取通用排序条件信息			
			$arra 		= self::getGeneralCondition($sort);
			$field 		= $arra["field"];
			$order_by  	= $arra["order_by"];
			//取通用排序URL
			$new_url = $hot7_url = $pop_url = array();
			self::getGeneralNavInfo($sort,$page_args,$new_url,$hot7_url,$pop_url);

			//取价格排序条件信息
			if(isset($psort)){
				$arrb 		= self::getPriceCondition($psort);
				$condition .= $arrb["condition"];
			}
			//取价格排序URL
			$pall_url = $p1_url = $p2_url = $p3_url = $phigh_url = array();			
			self::getPriceNavInfo($psort,$page_args,$pall_url,$p1_url,$p2_url,$p3_url,$phigh_url);
			
			//取颜色筛选条件信息
			if(isset($csort)){
				$arrc 		= self::getColorCondition($csort);
				$condition .= $arrc["condition"];
			}
			//取颜色筛选URL
			$c1_url = $c2_url = $c3_url = $c4_url = $c5_url = $c6_url = array();			
			self::getColorNavInfo($csort,$page_args,$c1_url,$c2_url,$c3_url,$c4_url,$c5_url,$c6_url);
	
			//取数据
			$pager = array();
			$share_list = self::processLookResult($page_args,$field,$psort,$csort,$is_match,$condition,$order_by,$pager);
			
			include template('page/book/book_look');
			display($cache_file);
			exit;
		}
		else
		{
			include $cache_file;
			display();
		}
	}

	private function getGeneralCondition($sort)
	{
		$today_time = getTodayTime();
		switch($sort)
		{
			//最热 7天点击次数
			case 'hot7':
				$day7_time = $today_time - 604800;
				$field = ",(s.create_time > $day7_time) AS time_sort ";
				$order_by = " ORDER BY time_sort DESC,s.click_count DESC";
			break;
			
			//有派 7天喜欢人数
			case 'pop':
				$day7_time = $today_time - 604800;
				$field = ",(s.create_time > $day7_time) AS time_sort ";
				$order_by = " ORDER BY time_sort DESC,s.collect_count DESC";
			break;
			//最新
			case 'new':;
			default:
				$field = '';
				$order_by = " ORDER BY s.share_id DESC";
		}
		return array("field"=>$field,"order_by"=>$order_by);
	}
	
	private function getGeneralNavInfo($sort,$page_args,&$new_url,&$hot7_url,&$pop_url)
	{
		$page_args['sort'] = 'new';
		$new_url['url'] = FU('book/'.ACTION_NAME,$page_args);
		if($sort=='new'){
			$new_url['act'] = 1;
		}
		
		$page_args['sort'] = 'hot7';	
		$hot7_url['url'] = FU('book/'.ACTION_NAME,$page_args);
		if($sort=='hot7'){
			$hot7_url['act'] = 1;
		}
	
		$page_args['sort'] = 'pop';
		$pop_url['url'] = FU('book/'.ACTION_NAME,$page_args);
		if($sort=='pop'){
			$pop_url['act'] = 1;
		}
	}
	
	private function getPriceCondition($psort)
	{
		$condition = "";
		switch($psort)
		{
			//100以下
			case 'p1':
				$condition = " AND sg.price <= 100";
			break;
			
			//101~200
			case 'p2':
				$condition = " AND sg.price > 100 AND sg.price <= 200";
			break;
			
			//201~500
			case 'p3':
				$condition = " AND sg.price > 200 AND sg.price <= 500";
			break;
			
			//500以上
			case 'high':
				$condition = " AND sg.price > 500";
			break;
			
			default:;
		}
		return array("condition"=>$condition);
	}
	
	private function getPriceNavInfo($psort,$page_args,&$pall_url,&$p1_url,&$p2_url,&$p3_url,&$phigh_url)
	{
		$page_args['psort'] = 'all';
		$pall_url['url'] = FU('book/'.ACTION_NAME,$page_args);
		if($psort=='all'){
			$pall_url['act'] = 1;
		}
		
		$page_args['psort'] = 'p1';
		$p1_url['url'] = FU('book/'.ACTION_NAME,$page_args);
		if($psort=='p1'){
			$p1_url['act'] = 1;
		}
		
		$page_args['psort'] = 'p2';	
		$p2_url['url'] = FU('book/'.ACTION_NAME,$page_args);
		if($psort=='p2'){
			$p2_url['act'] = 1;
		}
	
		$page_args['psort'] = 'p3';
		$p3_url['url'] = FU('book/'.ACTION_NAME,$page_args);
		if($psort=='p3'){
			$p3_url['act'] = 1;
		}
		
		$page_args['psort'] = 'high';
		$phigh_url['url'] = FU('book/'.ACTION_NAME,$page_args);
		if($psort=='high'){
			$phigh_url['act'] = 1;
		}
	}
	
	private function getColorCondition($csort)
	{
		$condition = "";
		if(isset($csort) && $csort){
			$color = self::$csortArr[$csort];
			$condition = " AND sg.color='{$color}'";
		}
		return array("condition"=>$condition);
	}
	
	private function getColorNavInfo($csort,$page_args,&$c1_url,&$c2_url,&$c3_url,&$c4_url,&$c5_url,&$c6_url)
	{
		$page_args['csort'] = 'c1';
		$c1_url['url'] = FU('book/'.ACTION_NAME,$page_args);
		if($csort=='c1'){
			$c1_url['act'] = 1;
		}
		
		$page_args['csort'] = 'c2';
		$c2_url['url'] = FU('book/'.ACTION_NAME,$page_args);
		if($csort=='c2'){
			$c2_url['act'] = 1;
		}
		
		$page_args['csort'] = 'c3';	
		$c3_url['url'] = FU('book/'.ACTION_NAME,$page_args);
		if($csort=='c3'){
			$c3_url['act'] = 1;
		}
	
		$page_args['csort'] = 'c4';
		$c4_url['url'] = FU('book/'.ACTION_NAME,$page_args);
		if($csort=='c4'){
			$c4_url['act'] = 1;
		}
		
		$page_args['csort'] = 'c5';
		$c5_url['url'] = FU('book/'.ACTION_NAME,$page_args);
		if($csort=='c5'){
			$c5_url['act'] = 1;
		}
		
		$page_args['csort'] = 'c6';
		$c6_url['url'] = FU('book/'.ACTION_NAME,$page_args);
		if($csort=='c6'){
			$c6_url['act'] = 1;
		}
	}
			
	private function processResult($page_args,$field,$psort,$csort,$is_match,$condition,$order_by,&$pager,$page_size = 100,$max_page = 100)
	{
		global $_FANWE;
		$sql = 'SELECT DISTINCT(s.share_id),s.uid,s.content,s.collect_count,s.comment_count,s.title,s.create_time,s.cache_data '.$field.'
				FROM '.FDB::table('share').' AS s ';

		$sql .= 'INNER JOIN '.FDB::table('share_category').' AS sc ON s.share_id = sc.share_id ';
				
		if(isset($psort) || isset($csort)){
			$sql .= 'INNER JOIN '.FDB::table('share_goods').' AS sg ON s.share_id = sg.share_id ';
		}		 			
		if($is_match){
			$sql .= 'INNER JOIN '.FDB::table('share_match').' AS sm ON sm.share_id = s.share_id ';
		}
		
		$condition .=" and s.status=1 ";
		$sql .= $condition.$order_by;

		$sql_count = 'SELECT COUNT(DISTINCT s.share_id)	FROM '.FDB::table('share').' AS s ';

		$sql_count .= 'INNER JOIN '.FDB::table('share_category').' AS sc ON s.share_id = sc.share_id ';

		if(isset($psort) || isset($csort)){
			$sql_count .= 'INNER JOIN '.FDB::table('share_goods').' AS sg ON s.share_id = sg.share_id ';
		}					
		if($is_match){
			$sql_count .= 'INNER JOIN '.FDB::table('share_match').' AS sm ON sm.share_id = s.share_id ';
		}

		$sql_count .= $condition;

		$count = FDB::resultFirst($sql_count);
		
		if($count > $max_page * $page_size){
			$count = $max_page * $page_size;
		}
		
		if($_FANWE['page'] > $max_page){
			$_FANWE['page'] = $max_page;
		}

		$action = ACTION_NAME;

		$pager = buildPage('book/'.$action,$page_args,$count,$_FANWE['page'],$page_size,'',3);

		$sql  = $sql.' LIMIT '.$pager['limit'];
		//var_dump($sql_count,$sql);exit;
		$share_list = FDB::fetchAll($sql);
		//var_dump($share_list);exit;
		$share_list = FS('Share')->getShareDetailList($share_list,false,false,false,true,2);
		return $share_list;
	}
	
	private function processDaPeiResult($page_args,$field,$psort,$csort,$is_match,$condition,$order_by,&$pager,$page_size = 8,$max_page = 100)
	{
		global $_FANWE;
	
		$sql = 'SELECT DISTINCT(s.share_id),s.uid,s.content,s.collect_count,s.comment_count,s.create_time,s.cache_data '.$field.'
				FROM '.FDB::table('share_photo').' AS sp 
				INNER JOIN  '.FDB::table('share').' AS s ON s.share_id = sp.share_id ';

		if(isset($psort) || isset($csort)){
			$sql .= 'INNER JOIN '.FDB::table('share_goods').' AS sg ON s.share_id = sg.share_id ';
		}
		if($is_match){
			$sql .= 'INNER JOIN '.FDB::table('share_match').' AS sm ON sm.share_id = s.share_id ';
		}

		$sql .= $condition.$order_by;

		$sql_count = 'SELECT COUNT(DISTINCT s.share_id)
					  FROM '.FDB::table('share_photo').' AS sp 
					  INNER JOIN  '.FDB::table('share').' AS s ON s.share_id = sp.share_id ';

		if(isset($psort) || isset($csort)){
			$sql_count .= 'INNER JOIN '.FDB::table('share_goods').' AS sg ON s.share_id = sg.share_id ';
		}
		if($is_match){
			$sql_count .= 'INNER JOIN '.FDB::table('share_match').' AS sm ON sm.share_id = s.share_id ';
		}
		$sql_count .= $condition;

		$count = FDB::resultFirst($sql_count);
		
		if($count > $max_page * $page_size){
			$count = $max_page * $page_size;
		}
		
		if($_FANWE['page'] > $max_page){
			$_FANWE['page'] = $max_page;
		}

		$pager = buildPage('book/'.ACTION_NAME,$page_args,$count,$_FANWE['page'],$page_size,'',3);

		$share_datas = array();
		$sql  = $sql.' LIMIT '.$pager['limit'];
		
		$share_list = FDB::fetchAll($sql);
		$share_list = FS('Share')->getShareDetailList($share_list,false,false,false,true,5);
		$sid = (int)$_FANWE['request']['sid'];
		if($sid > 0)
		{
			if(isset($share_list[$sid]))
			{
				$temp_share = $share_list[$sid];
				unset($share_list[$sid]);
				array_unshift($share_list,$temp_share);
			}
			else
			{
				$temp_share[] = FS('Share')->getShareById($sid);
				if($temp_share)
				{
					$temp_share = FS('Share')->getShareDetailList($temp_share,false,false,false,true,5);
					array_unshift($share_list,$temp_share[$sid]);
				}
			}
		}
	
		return $share_list;
	}
	
	private function processLookResult($page_args,$field,$psort,$csort,$is_match,$condition,$order_by,&$pager,$page_size = 8,$max_page = 100)
	{
		global $_FANWE;
	
		$sql = 'SELECT DISTINCT(s.share_id),s.uid,s.content,s.collect_count,s.comment_count,s.create_time,s.cache_data '.$field.'
				FROM '.FDB::table('share_photo').' AS sp 
				INNER JOIN  '.FDB::table('share').' AS s ON s.share_id = sp.share_id ';
	
		if(isset($psort) || isset($csort)){
			$sql .= 'INNER JOIN '.FDB::table('share_goods').' AS sg ON s.share_id = sg.share_id ';
		}
		if($is_match){
			$sql .= 'INNER JOIN '.FDB::table('share_match').' AS sm ON sm.share_id = s.share_id ';
		}
		$sql .= $condition.$order_by;
	
		$sql_count = 'SELECT COUNT(DISTINCT s.share_id)
					  FROM '.FDB::table('share_photo').' AS sp 
					  INNER JOIN  '.FDB::table('share').' AS s ON s.share_id = sp.share_id ';
	
		if(isset($psort) || isset($csort)){
			$sql_count .= 'INNER JOIN '.FDB::table('share_goods').' AS sg ON s.share_id = sg.share_id ';
		}		
		if($is_match){
			$sql_count .= 'INNER JOIN '.FDB::table('share_match').' AS sm ON sm.share_id = s.share_id ';
		}
	
		$sql_count .= $condition;
	
		$count = FDB::resultFirst($sql_count);
		if($count > $max_page * $page_size){
			$count = $max_page * $page_size;
		}
	
		if($_FANWE['page'] > $max_page){
			$_FANWE['page'] = $max_page;
		}
	
		$pager = buildPage('book/'.ACTION_NAME,$page_args,$count,$_FANWE['page'],$page_size,'',3);
	
		$share_datas = array();
		$sql  = $sql.' LIMIT '.$pager['limit'];
		
		$share_list = FDB::fetchAll($sql);
		$share_list = FS('Share')->getShareDetailList($share_list,false,false,false,true);
	
		return $share_list;
	}
}
?>