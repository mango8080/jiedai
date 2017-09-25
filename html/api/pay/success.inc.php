<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common.inc.php';

$db->query("UPDATE {$DT_PRE}finance_charge SET status=3,money=$charge_money,receivetime='$DT_TIME',editor='$editor' WHERE itemid=$charge_orderid");

include load('member.lang');
require DT_ROOT.'/include/module.func.php';
//money_add($r['username'], $r['amount']);
//money_record($r['username'], $r['amount'], $PAY[$bank]['name'], 'system', $L['charge_online'], $L['charge_id'].':'.$charge_orderid);

$MOD = cache_read('module-2.php');
/*
if($MOD['credit_charge'] > 0) {
	$credit = intval($r['amount']*$MOD['credit_charge']);
	if($credit > 0) {
		credit_add($r['username'], $credit);
		credit_record($r['username'], $credit, 'system', $L['charge_reward'], $L['charge'].$r['amount'].$DT['money_unit']);
	}
}
*/
//Pay
$r=$db->get_one("Select * From {$DT_PRE}finance_charge Where itemid=$charge_orderid");
if($r['reason']) {
	include load('order.lang');
	$_username = $r['username'];
	$timenow = timetodate($DT_TIME, 3);
	$memberurl = $MODULE[2]['linkurl'];
	$myurl = userurl($_username);
	$arr = explode('|', $r['reason']);
	if($arr[0] == 'trade' || $arr[0] == 'trades') {
		foreach(explode(',', $arr[1]) as $id) {
			$itemid = intval($id);
			if($itemid < 1) continue;
			$table = $DT_PRE.'mall_order';
			$td = $db->get_one("SELECT a.*,b.company,b.apigroup,b.hotelid as hotelid2 FROM {$table} as a Left Join {$DT_PRE}company as b On a.seller=b.username WHERE a.itemid=$itemid");
			if($td && $td['buyer'] == $r['username'] && $td['status'] == 1) {
				$confstatus=true;
				$mallid = $td['mallid'];
				$apigroup=$td['apigroup'];
				$outconfnum=$td['outconfnum'];
				if ($apigroup) {
					switch ($apigroup) {
						case 'jinjiang':
							$confstatus=jjreliefholdresv($jjorderurl,$jjuser,$jjpass,$jjiata,$td['hotelid2'],$outconfnum,'');

                          //log_write($confstatus, 'confstatus', 1);

							break;
						
						default:
							# code...
							break;
					}
				}
			

				$confstatus=($confstatus==true?1:0);
				//$m = $db->get_one("SELECT money FROM {$DT_PRE}member WHERE username='$r[username]'");
				$money = $td['amount'] + $td['fee'];
			
					$smscode="";
					//money_add($_username, -$money);
					//money_record($_username, -$money, $L['in_site'], 'system', $L['trade_pay_order_title'], $L['trade_order_id'].$itemid);

					$db->query("UPDATE {$table} SET status=2,ispay=$confstatus,updatetime=$DT_TIME WHERE itemid=$itemid");
					if ($td['fee']>0){//有电子券
						$smscode="您购买的";
						$quan=$db->query("Select b.*,a.title from {$DT_PRE}voucher_order as b Left Join {$DT_PRE}sell_23 as a On b.voucherid=a.itemid Where b.orderid=$itemid");
						while ($r=$db->fetch_array($quan)) {
							$smscode.=$r['title'];
							$vouchercode="";
							$aa=$db->query("Select * From {$DT_PRE}sell_dianzijuan Where categoryid=".$r['voucherid']." and state=3 and orderid=$itemid");
							while ($d=$db->fetch_array($aa)) {
								$smscode.=" 提取码:".$d['code']." 有效期到:".$d['enddate'].";";
								$vouchercode.=$d['code'].',';
								$db->query("UPDATE {$DT_PRE}sell_dianzijuan SET state=1,saledate='".timetodate($DT_TIME,0)."',membername='".$td['buyer']."',orderid=$itemid WHERE juanid=".$d['juanid']);
							}
							$vouchercode=rtrim($vouchercode, ",");
							$db->query("UPDATE {$DT_PRE}voucher_order SET status=1,vouchercode='$vouchercode' WHERE itemid=".$r['itemid']);
						}
						$smscode=rtrim($smscode, ";");
					}

					$touser = $td['seller'];
					$title = lang($L['trade_message_t2'], array($itemid));
					$url = $memberurl.'trade.php?itemid='.$itemid;
					$content = lang($L['trade_message_c2'], array($myurl, $_username, $timenow, $url));
					$content = ob_template('messager', 'mail');
					send_message($touser, $title, $content);
					//send sms
					if($td['buyer_mobile']) {
						$sms = new Sms();
						$beginDate=timetodate($td['intime'],0);
						$mobile=$td['buyer_mobile'];
						$sms_note='{"name":"'.$td['buyer_name'].'","hotelname":"'.$td['company'].'","roomtype":"'.$td['title'].'","intime":"'.$beginDate.'。'.$smscode.'"}';
						$status = $sms->send_sms($mobile, $sms_note, 'SMS_36170276');
					}
					/*
					if($td['mid'] == 16) {
						$db->query("UPDATE {$DT_PRE}mall SET orders=orders+1,sales=sales+$td[number],amount=amount-$td[number] WHERE itemid=$mallid");
					} else {
						$db->query("UPDATE ".get_table($td['mid'])." SET amount=amount-$td[number] WHERE itemid=$mallid");
					}
					*/
				
			}
		}
	} else if($arr[0] == 'group') {
		$itemid = intval($arr[1]);
		$table = $DT_PRE.'group_order';
		$td = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
		if($td && $td['buyer'] == $_username && $td['status'] == 6) {
			$m = $db->get_one("SELECT money FROM {$DT_PRE}member WHERE username='$r[username]'");
			$money = $td['amount'];
			if($m['money'] >= $money) {
				money_add($_username, -$money);
				money_record($_username, -$money, $L['in_site'], 'system', $L['group_order_credit'], $L['trade_order_id'].$itemid);
				$password = $td['logistic'] ? '' : random(6, '0123456789');
				$db->query("UPDATE {$table} SET status=0,password='$password',updatetime=$DT_TIME WHERE itemid=$itemid");
				if($password) {
					//send sms
					if($DT['sms']) {
						$message = lang('sms->ord_group', array($td['title'], $itemid, $password));
						$message = strip_sms($message);
						send_sms($td['buyer_mobile'], $message);
					}
					//send sms
				}
				$db->query("UPDATE {$DT_PRE}group SET orders=orders+1,sales=sales+$td[number] WHERE itemid=$td[gid]");
			}
		}
	}
}
dheader(DT_PATH.'mobile/myorder.php');
?>