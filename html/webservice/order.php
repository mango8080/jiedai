<?php
/*
	用户登录数据库操作api
*/
require '../common.inc.php';
// token验证
// if ($token != md5(md5('HaNShanLing'))) {
// 	exit('Access Denied');
// }

switch ($action) {
	case 'neworder':
		$oid=apineworder($jjurl,$jjuser,$jjpass,$jjiata,$fds);
		exit(json_encode($oid));
		break;
	case 'getorder':
		$r=apigetorder($itemid);
		exit(json_encode($r));
		break;
	case 'uporder':
		$r=apiuporder($itemid,$orderstatus);
		exit(($r));
		break;
	case 'delorder':
		$r=apidelorder($itemid,$rooms,$mallid);
		exit(($r));
		break;
	default:

		break;

}

// 新增订单
function apineworder($jjurl,$jjuser,$jjpass,$jjiata,$fds) {
	global $db, $DT_TIME, $DT_PRE;

	extract($fds);
	$c=$db->get_one("SELECT a.jiameng,a.apigroup,a.company,b.mobile FROM {$DT_PRE}company as a Left Join {$DT_PRE}member as b ON a.username=b.username WHERE a.username='{$seller}'");
	
	if ($c['jiameng']==1){
		$access=0;//前台确认
		$status=0;//待确认
	}else{
		$access=1;//自动确认,并生成接口订单
		if ($c['apigroup']=='jinjiang'){
			/*
			$order=array('order_code' => $ordercode,'order_inday'=>date("Y-m-d",$intime), );
			$orderres= neworder($jjurl,$jjuser,$jjpass,$jjiata,$hotelid,$order);
			if (!$orderres){
				return 0;
				exit();
			}
			*/
		}
	}

	$db->query("INSERT INTO {$DT_PRE}mall_order (mid,mallid,buyer,seller,title,thumb,price,number,amount,addtime,updatetime,note, buyer_name,buyer_phone,buyer_mobile,status,fee_name,fee,cod,days,paytype,voucherid,buyer_email,arrivetime,ordercode,intime,outtime,isconfirm,hotelid,roomtype,access) VALUES ('$moduleid','$itemid','$buyer','$seller','$title','$thumb','$price','$number','$amount','$DT_TIME','$DT_TIME','$note','$buyer_name','$buyer_phone','$buyer_mobile','$status','$fee_name','$fee','$cod','$days','$paytype','$voucherid','$buyer_email','$arrivetime','$ordercode','$intime','$outtime','0','$hotelid','$roomtype','$access')");
	$oid = $db->insert_id();
	$db->query("REPLACE INTO {$DT_PRE}mall_comment (itemid,mallid,buyer,seller,orderid) VALUES ('$oid','$itemid','$buyer','$seller','$oid')");
	$tmp = $db->get_one("SELECT mallid FROM {$DT_PRE}mall_stat WHERE mallid=$itemid");
	if(!$tmp) $db->query("REPLACE INTO {$DT_PRE}mall_stat (mallid,buyer,seller,orderid) VALUES ('$itemid','$buyer','$seller','$oid')");
	// 房型中减去房间数
	$db->query("update {$DT_PRE}mall set amount=(amount-$number) WHERE itemid=$itemid");

	$sms = new Sms();
	if ($c['jiameng']==0){//直连的需要发短信给住客
		$mobile=$buyer_mobile;
		$sms_note='{"name":"'.$buyer_name.'","hotelname":"'.$c['company'].'","roomtype":"'.$title.'","intime":"'.date("Y-m-d",$intime).'"}';
		$status = $sms->send_sms($mobile, $sms_note, 'SMS_34845362');
	}else{//加盟的需要发短信给前台
		$mobile=$c['mobile'];
		$sms_note='{"hotelname":"'.$c['company'].'","name":"'.$buyer_name.'","roomtype":"'.$title.'","roomnum":"'.$number.'","intime":"'.date("Y-m-d",$intime).'"}';
		$status = $sms->send_sms($mobile, $sms_note, 'SMS_34870256');
	}
	return $oid;
}
// 取得订单
function apigetorder($itemid){
	global $db, $DT_TIME, $DT_PRE;
	$myorder=$db->get_one("SELECT * FROM {$DT_PRE}mall_order WHERE itemid=$itemid");
	return $myorder;
}
// 更新订单
function apiuporder($itemid,$orderstatus){
	global $db, $DT_TIME, $DT_PRE;
	$db->query("UPDATE {$DT_PRE}mall_order SET outconfnum='$orderstatus',isconfirm=1 WHERE itemid=$itemid");
	return true;
}
// 删除订单
function apidelorder($itemid,$rooms,$mallid){
	global $db, $DT_TIME, $DT_PRE;
		$db->query("DELETE FROM {$DT_PRE}mall_order WHERE itemid=$itemid");
		$db->query("DELETE FROM {$DT_PRE}voucher_order WHERE orderid=$itemid");
		$db->query("DELETE FROM {$DT_PRE}mall_comment WHERE orderid=$itemid");
		$db->query("DELETE FROM {$DT_PRE}mall_stat WHERE orderid=$itemid");

		$db->query("update {$DT_PRE}mall set amount=(amount+".$rooms.") WHERE itemid=".$mallid);
	return true;
}
