<?php
require '../common.inc.php';
include load('order.lang');

$_status = $L['trade_status'];
// token验证
// if ($token != md5(md5('HaNShanLing'))) {
// 	exit('Access Denied');
// }
$gTable=$table;
$gAs=$tableas;
$gJoin=empty($join)?"":str_replace("#pre#", "{$DT_PRE}", $join);
$gFields=empty($fields)?"*":stripslashes($fields);
$gWhere=empty($condition)?"":"Where ".stripslashes($condition);
$gOrder=empty($order)?"":"Order by $order";
$gLimit=empty($perpage)?"" : "LIMIT $start,$perpage";
$gUpdate=empty($autoadd)?"":$autoadd;
switch ($op) {
	case 'getWebcount':
		$db->query("Update {$DT_PRE}setting Set item_value=item_value+1 WHERE item='webcount' and item_key='{$source}'");
		$count=$db->get_one("SELECT Sum(item_value) as nCount FROM {$DT_PRE}setting WHERE item='webcount' and item_key='{$source}'");
		exit(json_encode($count['nCount']));
		break;
	case 'getWebcountm':
		
		$count=$db->get_one("SELECT Sum(item_value) as nCount FROM {$DT_PRE}setting WHERE item='webcount' and item_key='{$source}'");
		exit(json_encode($count['nCount']));
		break;	
	case 'getPageList':
		exit(json_encode(getPageList($specflag)));
		break;
	case 'getInfo':
		$info=getRow();
		exit(json_encode($info));
		break;
	case 'addRec':
		exit(json_encode(addRec()));
		break;
	case 'updateMember':
		exit(json_encode(upFields()));
		break;
	case 'deleteRec':
		exit(json_encode(delRec()));
		break;
	case 'getCount':
		exit(json_encode(getRowCount()));
		break;
	case 'commentTrade':
		exit(json_encode(addComment($star,$mallid,$content)));
		break;
	case 'sendSms':
		exit(json_encode(sendsms($mobilecode)));
		break;
	case 'checkbuy':
		$arrDatePrice=array();
		$item = $db->get_one("SELECT a.*,b.apigroup,b.hotelid as hotelid1 FROM {$DT_PRE}mall as a Left Join {$DT_PRE}company as b ON a.username=b.username WHERE a.itemid={$itemid}");
		if (empty($item)){
			exit();
		}
		$apigroup=$item['apigroup'];
		if (empty($apigroup)){//加盟

		}else{
			switch ($apigroup){
				case 'jinjiang':
					$arrDatePrice=getonlineratemap($jjurl,$jjuser,$jjpass,$jjiata,$item['hotelid1'],$intime,$days,$item['roomtype'],$roomNum,1);
					break;
				case 'hanting':
					$endDate=date("Y-m-d",strtotime(" +{$days} day",strtotime($intime)));
					$ett = new Ett();
			 		$arrDatePrice=$ett->getonlineratemap($item['hotelid1'],$intime,$endDate,$item['roomtype']);
					break;	
				default:

					break;
			}
		}
		$arrDatePrice['HotelMall']=$item;
		exit(json_encode($arrDatePrice));
		break;
	case 'addOrder':
		$arrResult=$arrDatePrice=array();
		$item = $db->get_one("SELECT a.*,b.apigroup,b.hotelid as hotelid1,b.jiameng,c.mobile FROM {$DT_PRE}mall as a Left Join {$DT_PRE}company as b ON a.username=b.username Left Join {$DT_PRE}member as c ON b.username=c.username WHERE a.itemid={$itemid}");
		if (empty($item)){
			$arrResult['success']=0;
			$arrResult['message']="房型信息未发现";
			exit(json_encode($arrResult));
		}
		$apigroup=$item['apigroup'];
		if (empty($apigroup)){//加盟
			$access=0;//前台确认
			$status=0;//待确认
		}else{
			$access=1;//自动确认,并生成接口订单
			switch ($apigroup){
				case 'jinjiang':
					$arrDatePrice=getonlineratemap($jjurl,$jjuser,$jjpass,$jjiata,$item['hotelid1'],$intime,$days,$item['roomtype'],$roomNum,1);
					break;
				case 'hanting':
					$endDate=date("Y-m-d",strtotime(" +{$days} day",strtotime($intime)));
					$ett = new Ett();
			 		$arrDatePrice=$ett->getonlineratemap($item['hotelid1'],$intime,$endDate,$item['roomtype']);
					break;	
				default:

					break;
			}
		}
		if (empty($arrDatePrice) || $arrDatePrice['RoomStatus']!='A'){
			$arrResult['success']=0;
			$arrResult['message']="此房型已满,请选择其他房型";
			exit(json_encode($arrResult));
		}
		$ordercode=date("Ymdhis") . rand(10000, 99999);
		$isconfirm = 0;
		$orderss='';
		switch ($apigroup) {
			case 'jinjiang':
				$order = array(
					'order_code' => $ordercode,
					'order_inday' => $intime,
					'order_days' => $days,
					'order_price' => $amount,
					'order_roomtype' => $item['roomtype'],
					'order_rateclass' => 'COR85',
					'order_truename' => $buyer_name,
					'order_mobile' => $buyer_mobile,
					'order_email' => $buyer_email,
					'order_note' => $note,
					'order_rooms' => $roomNum,
					'order_arrivetime' => $arrivetime,
				 );
				$orderss=neworder($jjorderurl,$jjuser,$jjpass,$jjiata,$item['hotelid1'],$paytype,$order,$arrDatePrice['RoomPrice']);
				
				if (empty($orderss)) {
					$arrResult['success']=0;
					$arrResult['message']="提交订单失败1";
					exit(json_encode($arrResult));
				}else{
					$isconfirm = 1;
				}
					
				break;
			case 'hanting':
						$order = array(
								'order_code' => $ordercode,
								'order_inday' => $intime,
								'order_days' => $days,
								'order_price' => $amount,
								'order_roomtype' => $item['roomtype'],
								'order_truename' => $buyer_name,
								'order_mobile' => $buyer_mobile,
								'order_email' => $buyer_email,
								'order_note' => $note,
								'order_rooms' => $roomNum,
								'order_arrivetime' =>$intime." ".$arrivetime,
						);
						$endDate=date("Y-m-d",strtotime(" +{$days} day",strtotime($intime)));
						$ett = new Ett();
						$orderss=$ett->neworder($item['hotelid1'],$intime,$endDate,"0",$order);
						if (empty($orderss)) {
							$arrResult['success']=0;
							$arrResult['message']="提交订单失败1";
							exit(json_encode($arrResult));
						}else{
							$isconfirm = 1;
						}
						break;
			default:
				
				break;
		}
		$seller=$item['username'];
		$price=$fee=0;

		$db->query("INSERT INTO {$DT_PRE}mall_order (mid,mallid,buyer,seller,title,thumb,price,number,amount,addtime,updatetime,note, buyer_name,buyer_phone,buyer_mobile,status,fee_name,fee,cod,days,paytype,voucherid,buyer_email,arrivetime,ordercode,intime,outtime,isconfirm,outconfnum,hotelid,roomtype,access) VALUES ('$moduleid','$itemid','$buyer','$seller','".$item['title']."','".$item['thumb']."','$price','$roomNum','$amount','$DT_TIME','$DT_TIME','$note','$buyer_name','$buyer_phone','$buyer_mobile','$status','$fee_name','$fee','$cod','$days','$paytype','$voucherid','$buyer_email','$arrivetime','$ordercode','".strtotime($intime)."','".strtotime($outtime)."','$isconfirm','{$orderss}','".$item['hotelid']."','".$item['roomtype']."','$access')");
		$oid = $db->insert_id();
		if (empty($oid)){
			$arrResult['success']=0;
			$arrResult['message']="提交订单失败";
			exit(json_encode($arrResult));
		}
		$db->query("REPLACE INTO {$DT_PRE}mall_comment (itemid,mallid,buyer,seller,orderid) VALUES ('$oid','$itemid','$buyer','$seller','$oid')");
		$tmp = $db->get_one("SELECT mallid FROM {$DT_PRE}mall_stat WHERE mallid=$itemid");
		if(!$tmp) $db->query("REPLACE INTO {$DT_PRE}mall_stat (mallid,buyer,seller,orderid) VALUES ('$itemid','$buyer','$seller','$oid')");
		
		$sms = new Sms();
		if ($item['jiameng']==0){//直连的需要发短信给住客
			$mobile=$buyer_mobile;
			$sms_note='{"name":"'.$buyer_name.'","hotelname":"'.$item['company'].'","roomtype":"'.$item['title'].'","intime":"'.$intime.'"}';
			$status = $sms->send_sms($mobile, $sms_note, 'SMS_34845362');
		}else{//加盟的需要发短信给前台
			$mobile=$item['mobile'];
			$sms_note='{"hotelname":"'.$item['company'].'","name":"'.$buyer_name.'","roomtype":"'.$item['title'].'","roomnum":"'.$roomNum.'","intime":"'.$intime.'"}';
			$status = $sms->send_sms($mobile, $sms_note, 'SMS_34870256');
		}
		$arrResult['success']=1;
		$arrResult['message']=$oid;
		exit(json_encode($arrResult));
		break;
	case 'cancelOrder':
		$arrResult=array();
		$order = $db->get_one("SELECT a.*,b.apigroup,b.hotelid as hotelid1,b.jiameng FROM {$DT_PRE}mall_order as a Left Join {$DT_PRE}company as b ON a.seller=b.username WHERE a.itemid={$itemid}");
		if (empty($order)){
			$arrResult['success']=0;
			$arrResult['message']="订单信息未发现";
			exit(json_encode($arrResult));
		}
		$apigroup=$order['apigroup'];
		if ($order['status']==2){
			$status=5;
		}else{
			$status=8;
		}
		if (!empty($apigroup)){
			switch ($apigroup) {
				case 'jinjiang':
					$res=jjcancelorder($jjorderurl,$jjuser,$jjpass,$order['hotelid1'],$order['outconfnum']);
					if (!$res){
						$arrResult['success']=0;
						$arrResult['message']="取消订单失败1";
						exit(json_encode($arrResult));
					}
					break;
				case 'hanting':
					$ett = new Ett();
					$res=$ett->cancelorder($order['hotelid1'],$order['outconfnum']);
					if ($res!='ok'){
						$arrResult['success']=0;
						$arrResult['message']="取消订单失败1";
						exit(json_encode($arrResult));	
					}
					break;	
				default:
						
					break;
			}
		}
		$sql="Update destoon_mall_order Set status={$status} Where itemid='$itemid'";
		if ($db->query($sql)){
			$arrResult['success']=1;
			$arrResult['message']="取消订单成功";
		}else{
			$arrResult['success']=0;
			$arrResult['message']="取消订单失败";
		}
		exit(json_encode($arrResult));
		break;
	default:
		
}
function getPageList($specflag){
	global $db, $DT_TIME, $DT_PRE,$DT_IP,$MOD;
	global $gTable,$gAs,$gJoin,$gFields,$gWhere,$gOrder,$gLimit;
	$list = array();
	$result=$db->query("SELECT {$gFields} FROM {$DT_PRE}{$gTable} {$gAs} {$gJoin} {$gWhere} {$gOrder} {$gLimit}");
	while ($row=$db->fetch_array($result)) {
		if (isset($row['addtime'])){
            $row['adddate'] = date("Y-m-d",$row['addtime']);
        }
        if ($specflag=="message"){
        	$row['adddate'] = date("Y年m月d日 H:i",$row['addtime']);
			$row['dtitle'] = dsubstr($row['title'], 55, '...');
			$row['user'] = $row['status'] > 2 ? ($row['fromuser'] ? $row['fromuser'] : '系统信使') : $row['touser'];
			if($row['fromuser']) {
				$row['user'] =  $row['status'] > 2 ? $row['fromuser'] : $row['touser'];
				$row['userurl'] = userurl($row['user']);
			} else {
				$row['user'] = $row['typeid'] == 4 ? '系统信使' : $L['guest'];
				$row['userurl'] = '';
			}
        }
        if ($specflag=="myorder"){
        	global $_status;
        	$row['gone'] = $DT_TIME - $row['updatetime'];
			if($row['status'] == 3) {
				if($row['gone'] > ($MOD['trade_day']*86400 + $row['add_time']*3600)) {
					$row['lefttime'] = 0;
				} else {
					$row['lefttime'] = secondstodate($MOD['trade_day']*86400 + $row['add_time']*3600 - $row['gone']);
				}
			}
			$row['par'] = '';
			if(strpos($row['note'], '|') !== false) list($row['note'], $row['par']) = explode('|', $row['note']);
			$row['addtime'] = str_replace(' ', '<br/>', timetodate($row['addtime'], 5));
			$row['updatetime'] = str_replace(' ', '<br/>', timetodate($row['updatetime'], 5));
			$row['linkurl'] = DT_PATH.'api/redirect.php?mid='.$row['mid'].'&itemid='.$row['mallid'];
			$row['dstatus'] = $_status[$row['status']];
			$row['money'] = $row['amount'] + $row['fee'];
			$row['money'] = number_format($row['money'], 2, '.', '');
			if ($row['status']==0 || $row['status']==1 || $row['status']==2 || $row['status']==7){
				if (strtotime(timetodate($row['intime'], 0).$row['arrivetime'])>time()){
					$row['maycancel']=1;
				}else{
					$row['maycancel']=0;
				}
				
			}else{
				$row['maycancel']=0;
			}
        }
		$list[]=$row;
	}
	return $list;
}

function getRow(){
	global $db, $DT_TIME, $DT_PRE,$DT_IP;
	global $gTable,$gAs,$gJoin,$gFields,$gWhere,$gUpdate;
	if (!empty($gUpdate)){
		$db->query("UPDATE {$DT_PRE}{$gTable} SET {$gUpdate}={$gUpdate}+1 {$gWhere}");
	}
	$row = $db->get_one("SELECT {$gFields} FROM {$DT_PRE}{$gTable} {$gAs} {$gJoin} {$gWhere}");
	return $row;
}
function getRowCount(){
	global $db, $DT_TIME, $DT_PRE,$DT_IP;
	global $gTable,$gWhere,$gAs,$gJoin;
	$row = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}{$gTable} {$gAs} {$gJoin} {$gWhere}");
	return $row;
}
function upFields(){
	global $db, $DT_TIME, $DT_PRE,$DT_IP;
	global $gTable,$gFields,$gWhere;
	$db->query("UPDATE {$DT_PRE}{$gTable} SET {$gFields} {$gWhere}");
	return true;
}
function delRec(){
	global $db, $DT_TIME, $DT_PRE,$DT_IP;
	global $gTable,$gWhere;
	$db->query("DELETE From {$DT_PRE}{$gTable} {$gWhere}");
	return true;
}
function addRec(){
	global $db, $DT_TIME, $DT_PRE,$DT_IP;
	global $gTable,$gFields;
	$db->query("INSERT INTO {$DT_PRE}{$gTable} {$gFields} ");
	$recid=$db->insert_id();
	return $recid;
}
function addComment($star,$mallid,$content){
	global $db, $DT_TIME, $DT_PRE,$DT_IP;
	global $gTable,$gWhere;
	
	$s = 's'.$star;
	$db->query("UPDATE {$DT_PRE}{$gTable} SET seller_star=$star {$gWhere}");
	$db->query("UPDATE {$DT_PRE}mall_comment SET seller_star=$star,seller_comment='".stripslashes($content)."',seller_ctime=$DT_TIME {$gWhere}");
	$db->query("UPDATE {$DT_PRE}mall SET comments=comments+1 WHERE itemid=$mallid");
	$db->query("UPDATE {$DT_PRE}mall_stat SET scomment=scomment+1,`$s`=`$s`+1 WHERE mallid=$mallid");
	return true;
}
function sendsms($mobilecode){
	global $db, $DT_TIME, $DT_PRE,$DT_IP;
	global $gTable,$gFields,$gWhere;
	$row = $db->get_one("SELECT {$gFields} FROM {$DT_PRE}{$gTable} {$gWhere}");
	if (!empty($row['mobile'])){
		$sms = new Sms();
		$sms_note='{"code":"'.$mobilecode.'"}';
		$status = $sms->send_sms($row['mobile'], $sms_note, 'SMS_34980186');
		if ($status){
				return true;
		}else{
				return false;
		}
	}else{
		return false;
	}
}
?>