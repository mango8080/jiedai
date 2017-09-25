<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);
require_once '../../lib/functions.php';
require_once "../lib/WxPay.Api.php";
require_once '../lib/WxPay.Notify.php';
require_once 'log.php';


//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			$link = mysql_connect('www.anluze.com', 'root', 'yanji818');
			mysql_select_db('dingdan', $link);
			$i=mysql_query("delete from `ddb` ddh='".$data['out_trade_no']."'");
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			$link = mysql_connect('www.anluze.com', 'root', 'yanji818');
			mysql_select_db('dingdan', $link);
			$i=mysql_query("delete from `ddb` ddh='".$data['out_trade_no']."'");
			return false;
		}
		$link = mysql_connect('www.anluze.com', 'root', 'yanji818');
		mysql_select_db('dingdan', $link);
		$i=mysql_query("update `ddb` set status=1 where ddh='".$data['out_trade_no']."'");
		if($i){
			sendSMS($_SESSION['mobile'],"您预订的 ".$data['attach']." 订单号为".$data['out_trade_no']);
			
		}
		return true;
	}
}

Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);
