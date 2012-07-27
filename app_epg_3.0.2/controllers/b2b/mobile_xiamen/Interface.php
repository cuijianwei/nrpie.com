<?php
//接口
Configure::write('Ifree' , "http://interface.voole.com/itv/service.php?");//免费接口
Configure::write('Iresume' , "http://interface.voole.com/resume/old.php?"); //续播接口
Configure::write('Ifavorite' , "http://interface.voole.com/favorite/old.php?");//收藏接口


//计费
Configure::write('IUser' , "http://119.97.153.67:8012/tv/playauth.php?");//帐户接口
Configure::write('IProduct' , "http://interface.voole.com/products/service.php?");//产品接口
Configure::write('ISysM' , "http://interface.voole.com/message/getinfo/?");//系统消息接口
Configure::write('Iarealist' , "http://interface.voole.com/resource/arealist/?");//地域消息
Configure::write('Ifee' , "http://interface.voole.com/itv/pay.php?"); //计费接口

//产品接口参数
function IProductParam() {
	$g = $_GET;
	return array(
		"charset" => "utf-8",
		"epgid"   => EPGID,
		"spid"    => SPID, 
		"mid"     => (empty($g['mid'])? 0 : intval($g['mid'])),
		//影片对应介质FID
		"fid"     => null,
		//默认1	影片对应的剧集数
		"sid"     => 1,
		//：电影；1：电视剧；2：短视频；3：预告片；4：花絮；默认0，全局有效
		"mtype"   => empty($g['mtype'])? 0 : intval($g['mtype']),
		"responseformat" => "xml"
	);
}
//用户接口参数
function IuserParam() {
	list($usec, $sec) = explode(" ", microtime());
	return array(
		"type" => 1,#调用的接口类型
		"sequenceno" => "10000101_".date("YmdHis", $sec).substr($usec, 2, 3),#生成本次接口访问的记录ID号（流水号）
		"format" => "1",#播放格式
		"actiontype" => "",#动作类型
		"pagecode" => "utf-8",#页面编码
		"uid" => Configure::read('tmp.uid'),#用户UID
		"datetime" => $sec,#当前时间的UNIX时间戳
		"p" => 1,#当前页码
		"psize" > 12#一页显示记录条数
	);
}
//系统消息接口参数
function ISysMParam() {
	$g = $_GET;
	$status = $g["status"] ? 0 : 1;
	return array(
		"spid" => SPID,#运营商ID
		"epgid" => EPGID,#一个运营商下的不同门户ID（如：广东移动下有1.珠海2.深圳3.厦门，那么珠海的PROTALID为1.）PROTALID
		"uid" => Configure::read('tmp.uid'),#用户ID
		"hid" => Configure::read('tmp.hid'),#基于某个厂商的唯一值（硬件地址）
		"oemid" => Configure::read('tmp.oemid'),#厂商ID标识
		"status" => $status#状态
	);
}
//公用参数
function IPublicParam() {
	return array(
		"spid" => SPID,
		"epgid" => EPGID,
		"uid" => Configure::read('tmp.uid'),
		"hid" => Configure::read('tmp.hid'),
		"oemid" => Configure::read('tmp.oemid'),
		"responseformat" => "xml"
	);
}
/**
 * 系统分隔符
 */
//var_dump(DIRECTORY_SEPARATOR);exit;
/**
 * 创建一个文件，并写入提供的内容
 * 
 */
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
function createFile($path, $content, $ftype = "w") {
	$pArray = pathinfo($path);//dirname，basename 和 extension
	if (!is_dir($pArray["dirname"])) {
		createDir($pArray["dirname"]);
	}
	$f = fopen($path, $ftype);
	fwrite($f, $content);
	fclose($f);
}

   /* 安装照字符的路径在如果文件夹不存在就系统上创建文件夹
     * @param unknown_type $p
     */
    function createDir($p)
    {
    	$p = preg_replace("/\/|\\\\/", DS, $p);
		
		$pA = explode(DS, $p);
		$temp =  ""; 
		for ($i = 0 ; $i< count($pA); $i++) {
			$TS = $pA[$i];
			if (strpos($TS, ":") !== false) {
				$temp .= $TS;
				continue;
			}
			$temp .= DS.$TS;
			//echo $temp;
			if (!is_dir($temp)) {
			
				mkdir($temp, 7777);
				$shell = "chmod 777 ".$temp;
				exec($shell);
			}
		}
			
				//$shell = "chmod -Rf 777 ".$p.DS."../";
				//exec($shell);
		return $p;
    }
function getServerFile()
{
	return WEBROOT."tmp".DS."serverset".DS.implode("-", IPublicParam()).DS."server.txt";
	
}
?>