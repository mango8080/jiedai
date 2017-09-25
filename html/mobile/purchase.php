<?php
/*

	[Hotel System] Copyright (c) 2008-2015 QQ:59693566
*/
require 'common.inc.php';
$itemid or dheader(mobileurl($moduleid));
mobile_login();
$u = $db->get_one("SELECT truename,username,mobile FROM {$DT_PRE}member WHERE userid={$_userid}");
$addr = array();
$order_name = 'trade';
require DT_ROOT . '/module/' . $module . '/common.inc.php';
require DT_ROOT . '/include/post.func.php';
include load('misc.lang');
include load('member.lang');
include load('order.lang');
$back_link = mobileurl($moduleid, 0, $itemid);
$head_name = $L['purchase_title'];
$head_title = $head_name . $DT['seo_delimiter'] . $MOD['name'] . $DT['seo_delimiter'] . $head_title;
$foot = '';

switch ($module) {
	case 'mall':
		$itemid or dheader(mobileurl($moduleid));
		//echo $table;exit();
		$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");

		if (!$item || $item['status'] != 3) mobile_msg($L['purchase_msg_goods']);
		if ($item['username'] == $_username) mobile_msg($L['purchase_msg_self']);
		$t = $item;
	
		intval($roomNum) or $roomNum=1;
		
		
	

		if (isset($ok)) {
			$cod = 0;
			$second1 = strtotime($beginDate);
			$second2 = strtotime($endDate);
			
			
            
			$title = addslashes($t['title']);
			if (!empty($apigroup)) {//直连
			 	if ($paytype==1) {//到店付
			 		$status = 7;
			 		$arrivetime='18:00';
			 	}else{
			 		$status = 1;
			 		$arrivetime='23:59';
			 	}
			 	
			 				 
			}else{
				if ($paytype==1) {//到店付
                	$status = 7;
            	}else{
            		$status = 0;
            	}
			}
			
			$price =0;
			$number = intval($roomNum);
			if ($number < 1) $number = 1;
			//$amount = $number * $price * $days;
			$amount = $priceTotal-$couponsPrice;// $number * $price * $days;
			$note = '';
			$ordercode = date("Ymdhis") . rand(10000, 99999);
			$isconfirm = 0;
			$orderss='';
			// 如果是直联借口先判断能不能预定
			
			if($roomNum==1){
				$sql = "INSERT INTO {$DT_PRE}mall_order (name,nianling,mobile,shouru,gjj,shebao,yhdf,snote,time,ordercode,status,leixing,username) VALUES ('$name','$nianling','$mobile','$nianshouru','$gjj','$shebao','$yhdf','$snote','$DT_TIME','$ordercode',0,1,'$username')";
			}elseif($roomNum==2){
				$sql = "INSERT INTO {$DT_PRE}mall_order (name,nianling,mobile,danweiname,shouru,snote,time,ordercode,status,qiyedizhi,guoshui,dishui,pos,leixing,username) VALUES ('$name','$nianling','$mobile','$danweiname','$nianshouru','$snote','$DT_TIME','$ordercode',0,'$qiyedizhi','$guoshui','$dishui','$pos',2,'$username')";
			}elseif($roomNum==3){
				$sql = "INSERT INTO {$DT_PRE}mall_order (name,nianling,mobile,shouru,snote,time,ordercode,status,youxiang,yxmima,xykzh,xykmima,leixing,username) VALUES ('$name','$nianling','$mobile','$nianshouru','$snote','$DT_TIME','$ordercode',0,'$youxiang','$yxmima','$xykzh','$xykmima',3,'$username')";
			}elseif($roomNum==4){
				$sql = "INSERT INTO {$DT_PRE}mall_order (name,nianling,mobile,shouru,snote,time,ordercode,status,car,carnj,carxh,carprice,leixing,yhke,yhqs,username) VALUES ('$name','$nianling','$mobile','$nianshouru','$snote','$DT_TIME','$ordercode',0,'$car','$carnj','$carxh','$carprice',4,'$yhke','$yhqs','$username')";
			}elseif($roomNum==5){
				$sql = "INSERT INTO {$DT_PRE}mall_order (name,nianling,mobile,shouru,snote,time,ordercode,status,carnj,carprice,homewz,homedx,leixing,yhke,yhqs,username) VALUES ('$name','$nianling','$mobile','$nianshouru','$snote','$DT_TIME','$ordercode',0,'$carnj','$carprice','$home','$homedx',5,'$yhke','$yhqs','$username')";
			}elseif($roomNum==6){
				$sql = "INSERT INTO {$DT_PRE}mall_order (name,mobile,yhkh,tixian,time,ordercode,status,leixing,username) VALUES ('$name','$mobile','$yhkh','$tixian','$DT_TIME','$ordercode',0,6,'$username')";
			}
			
			//echo json_encode(array('stat' => 0, 'msg' => $sql));
							//exit();
			if ($db->query($sql)) {
				$oid = $db->insert_id();
			} else {
				echo json_encode(array('stat' => 0, 'msg' => "提交订单失败"));
				exit();
			}
			
			
			echo json_encode(array('stat' => 1));
			exit();
			
		}
		// 电子券分类
		//$coupcat=$db->get_one("SELECT * FROM {$DT_PRE}setting WHERE item=23 and item_key='type'");
		//$coupcats=explode('|', $coupcat['item_value']);
	    //var_dump($coupcats);die;
		$coup = array();
		$sql = "Select a.itemid,a.price,a.title,a.maxamount,a.enddate,b.nNum From {$DT_PRE}sell_23 a Inner Join (Select categoryid,count(*) as nNum From {$DT_PRE}sell_dianzijuan Where enddate>NOW() and state=0 group by categoryid) b On a.itemid=b.categoryid where a.enddate > now() Order by itemid,enddate";
		$trade = $db->query($sql);
		while ($r = $db->fetch_array($trade)) {
			$coup[] = $r;
		}
		break;
	default:
		dheader('index.php?reload=' . $DT_TIME);
		break;
	}
	include template('purchase', 'mobile');

	if (DT_CHARSET != 'UTF-8') toutf8();
?>