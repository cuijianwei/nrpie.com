<?php
/**
 * TOP API: taobao.wlb.orderstatus.get request
 * 
 * @author auto create
 * @since 1.0, 2011-11-14 13:22:04
 */
class WlbOrderstatusGetRequest
{
	/** 
	 * 物流宝订单编码
	 **/
	private $orderCode;
	
	private $apiParas = array();
	
	public function setOrderCode($orderCode)
	{
		$this->orderCode = $orderCode;
		$this->apiParas["order_code"] = $orderCode;
	}

	public function getOrderCode()
	{
		return $this->orderCode;
	}

	public function getApiMethodName()
	{
		return "taobao.wlb.orderstatus.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->orderCode,"orderCode");
	}
}
