<?php
// +----------------------------------------------------------------------
// | 方维购物分享网站系统 (Build on ThinkPHP)
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://fanwe.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: awfigq <awfigq@qq.com>
// +----------------------------------------------------------------------
/**
 +------------------------------------------------------------------------------
 * 敏感词分类模型
 +------------------------------------------------------------------------------
 */
class WordTypeModel extends CommonModel
{
	public $_validate = array(
		array('name','require','{%NAME_REQUIRE}'),
		array('name','','{%NAME_UNIQUE}',0,'unique'),
	);

	protected $_auto = array( 
		array('status','1'),  // 新增的时候把status字段设置为1
	);
}
?>