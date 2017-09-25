<?php 
defined('IN_DESTOON') or exit('Access Denied');
if($DT_BOT) dhttp(403);
login();
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/post.func.php';
include load('misc.lang');
include load('member.lang');
include load('order.lang');
if($submit) {
	require DT_ROOT.'/module/'.$module.'/cart.class.php';
	$do = new cart();
	$cart = $do->get();
	$ids = '';
	if($post) {
		
		$itemid = intval($post['itemid']);
		$hotelid=$post['hotelid'];

		$t = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");

		if($t && $t['status'] == 3 && $t['username'] != $_username && $t['amount'] > 0)
		{
			// 计算天数
				$days=(strtotime($post['outtime'])-strtotime($post['intime']))/86400;
				
				$number = intval($post['number']);
				if($number > $t['amount']) $number = $t['amount'];
				if($number < 1) $number = 1;
				// 单价
				$price = get_price($number, $post['price'], $t['step']);
				$amount = $number*$price*$days;
				// 电子券
				// foreach ($quan as $k => $v) {
				// 	$quanprice=$db->get_one("SELECT * FROM {$DT_PRE}sell_23 WHERE itemid=".$v);
				// 	$amount +=$quanprice['price'];
				// }
				$title = addslashes($t['title']);
				$linkurl = $MOD['linkurl'].$t['linkurl'];
				$voucherid=implode(',', $quan);
				$paytype=intval($post['paytype']);
				$buyer_name= $post['truename'];
				$buyer_mobile = $post['mobile'];
				$buyer_email= $post['email'];
				$arrivetime=$post['arrivetime'];
				$note=dhtmlspecialchars($post['note']);
				$intime=strtotime($post['intime']);
				$outtime=strtotime($post['outtime']);
				$roomtype=$t['roomtype'];
				
				$ordercode=date('YmdHis').mt_rand(10000,99999);
				
				$status=($paytype==1) ? 7 : 1 ;

				$db->query("INSERT INTO {$DT_PRE}mall_order (mid,mallid,buyer,seller,title,thumb,price,number,amount,addtime,updatetime,note, buyer_name,buyer_phone,buyer_mobile,status,fee_name,fee,cod,days,paytype,voucherid,buyer_email,arrivetime,ordercode,intime,outtime,isconfirm,hotelid,roomtype) VALUES ('$moduleid','$itemid','$_username','$t[username]','$title','$t[thumb]','$price','$number','$amount','$DT_TIME','$DT_TIME','$note','$buyer_name','$buyer_phone','$buyer_mobile','$status','$fee_name','$fee','$cod','$days','$paytype','$voucherid','$buyer_email','$arrivetime','$ordercode','$intime','$outtime','0','$hotelid','$roomtype')");
				$oid = $db->insert_id();

				$db->query("REPLACE INTO {$DT_PRE}mall_comment (itemid,mallid,buyer,seller,orderid) VALUES ('$oid','$itemid','$_username','$t[username]','$oid')");
				$tmp = $db->get_one("SELECT mallid FROM {$DT_PRE}mall_stat WHERE mallid=$itemid");
				if(!$tmp) $db->query("REPLACE INTO {$DT_PRE}mall_stat (mallid,buyer,seller,orderid) VALUES ('$itemid','$_username','$t[username]','$oid')");
				$ids .= ','.$oid;
				// 电子券订单
				// foreach ($quan as $key => $value) {
				// 	$db->query("INSERT INTO {$DT_PRE}voucher_order (orderid,voucherid,status,addtime,buyer) VALUES('$oid','$value','$status','$DT_TIME','$_username')");
				// }
				// 房型中减去房间数
				// $db->query("update {$DT_PRE}mall set amount=(amount-$number) WHERE itemid=$itemid");
				//send message
				$touser = $t['username'];
				$_title = $title;
				$title = lang($L['trade_message_t6'], array($oid));
				// $url = $MODULE[2]['linkurl'].'trade.php?itemid='.$oid;
				$url = '/mhotel/trade.php?itemid='.$oid;
				$goods = '<a href="'.$linkurl.'" target="_blank" class="t"><strong>'.$_title.'</strong></a>';
				$content = lang($L['trade_message_c6'], array(userurl($_username), $_username, timetodate($DT_TIME, 3), $goods, $oid, $amount, $url));
				$content = ob_template('messager', 'mail');
				send_message($touser, $title, $content);

				unset($cart[$k]);
				// $_SESSION["orderid"]=$oid;
		}
	}
	
	$do->set($cart);
	$forward = 'action=order';
	/*if(!$MOD['checkorder']) {
		if($ids) {
			$ids = substr($ids, 1);
			if(is_numeric($ids)) {
				$forward = 'action=update&step=pay&itemid='.$ids;
			} else {
				$forward = 'action=muti&ids='.$ids;
			}
		}
	}*/
	if($ids) {
			$ids = substr($ids, 1);
			if(is_numeric($ids)) {
				$forward = 'action=update&step=pay&itemid='.$ids;
			} else {
				$forward = 'action=muti&ids='.$ids;
			}
		}
	dheader("?action=show&auth=".encrypt($forward, DT_KEY.'TURL'));

} else {
	if($action == 'show') {
		
		if (isset($auth)) {
			$forward =decrypt($auth, DT_KEY.'TURL');
			$arr = parse_url($forward);
			$querys=convertUrlQuery($arr["path"]);
			$itemid=$querys['itemid'];
			$myorder=$db->get_one("SELECT * FROM {$DT_PRE}mall_order WHERE itemid=$itemid");
					$order = array(
						'order_code' => $myorder['ordercode'],
						'order_inday' => timetodate($myorder['intime'],0),
						'order_days' => $myorder['days'],
						'order_price' => $myorder['price'],
						'order_roomtype' => $myorder['roomtype'],
						'order_rateclass' => 'COR85',
						'order_amount' => $myorder['amount'],
						'order_truename' => $myorder['buyer_name'],
						'order_mobile' => $myorder['buyer_mobile'],
						'order_email' => $myorder['buyer_email'],
						'order_note' => $myorder['note'],
						'order_rooms' => $myorder['number'],
						'order_arrivetime' => $myorder['arrivetime'],

					 );

			// 判断订单是否能生成
			// $orderstatus=neworder($jjorderurl,$jjuser,$jjpass,$jjiata,$myorder['hotelid'],$order);
			
			// if ($orderstatus) {
			// 	$db->query("UPDATE {$DT_PRE}mall_order SET outconfnum='$orderstatus',isconfirm=1 WHERE itemid=$itemid");
			// }else{
			// 	$db->query("DELETE FROM {$DT_PRE}mall_order WHERE itemid=$itemid");
			// 	$db->query("DELETE FROM {$DT_PRE}voucher_order WHERE orderid=$itemid");
			// 	$db->query("DELETE FROM {$DT_PRE}mall_comment WHERE orderid=$itemid");
			// 	$db->query("DELETE FROM {$DT_PRE}mall_stat WHERE orderid=$itemid");

			// 	$db->query("update {$DT_PRE}mall set amount=(amount+".$order['order_rooms'].") WHERE itemid=".$myorder['mallid']);
			// 	message('房型预订失败，请选择其他房型');
			// }
		}
		 
		$forward = $MODULE[2]['linkurl'].'trade.php?'.($forward ? $forward : 'action=order');

	} else {
		isset($cart) or $cart = array();
		$lists = $tags = $data = array();
		$itemids = '';
		if($itemid) {
			if(is_array($itemid)) {
				foreach($itemid as $id) {
					$itemids .= ','.$id;
					$k = $id.'-0-0-0';
					$r = array();
					$r['itemid'] = $id;
					$r['s1'] = $r['s2'] = $r['s3'] = $r['a'] = 0;
					$data[$k] = $r;
				}
			} else {
				$s1 = isset($s1) ? intval($s1) : 0;
				$s2 = isset($s2) ? intval($s2) : 0;
				$s3 = isset($s3) ? intval($s3) : 0;
				$a = isset($a) ? intval($a) : 1;
				$itemids .= ','.$itemid;
				$k = $itemid.'-'.$s1.'-'.$s2.'-'.$s3;
				$r = array();
				$r['itemid'] = $itemid;
				$r['s1'] = $s1;
				$r['s2'] = $s2;
				$r['s3'] = $s3;
				$r['a'] = $a;
				$data[$k] = $r;
			}
		} else if($cart) {
			isset($amounts) or $amounts = array();
			foreach($cart as $v) {
				$t = array_map('intval', explode('-', $v));
				$itemids .= ','.$t[0];
				$r = array();
				$r['itemid'] = $t[0];
				$r['s1'] = $t[1];
				$r['s2'] = $t[2];
				$r['s3'] = $t[3];
				$r['a'] = isset($amounts[$v]) ? $amounts[$v] : 1;
				$data[$v] = $r;
			}
		}
		if($itemids) {
			$itemids = substr($itemids, 1);
			$result = $db->query("SELECT * FROM {$table} WHERE itemid IN ($itemids)");
			while($r = $db->fetch_array($result)) {
				if($r['username'] == $_username || $r['status'] != 3) continue;
				$r['alt'] = $r['title'];
				$r['title'] = dsubstr($r['title'], 40, '..');
				$r['linkurl'] = $MOD['linkurl'].$r['linkurl'];
				$r['P1'] = get_nv($r['n1'], $r['v1']);
				$r['P2'] = get_nv($r['n2'], $r['v2']);
				$r['P3'] = get_nv($r['n3'], $r['v3']);
				if($r['step']) {
					$s = unserialize($r['step']);
					foreach(unserialize($r['step']) as $k=>$v) {
						$r[$k] = $v;
					}
				} else {
					$r['a1'] = 1;
					$r['p1'] = $r['price'];
					$r['a2'] = $r['a3'] = 0;
					$r['p2'] = $r['p3'] = 0.00;
				}			
				$tags[$r['itemid']] = $r;
			}
			if($tags) {
				foreach($data as $k=>$v) {
					if(isset($tags[$v['itemid']])) {
						$r = $tags[$v['itemid']];
						$r['key'] = $k;
						$r['s1'] = $v['s1'];
						$r['s2'] = $v['s2'];
						$r['s3'] = $v['s3'];
						$r['a'] = $v['a'];
						if($r['a'] > $r['amount']) $r['a'] = $r['amount'];
						if($r['a'] < $r['a1']) $r['a'] = $r['a1'];
						$r['price'] = get_price($r['a'],$r['price'], $r['step']);
						$r['m1'] = isset($r['P1'][$r['s1']]) ? $r['P1'][$r['s1']] : '';
						$r['m2'] = isset($r['P2'][$r['s2']]) ? $r['P2'][$r['s2']] : '';
						$r['m3'] = isset($r['P3'][$r['s3']]) ? $r['P3'][$r['s3']] : '';
						$lists[] = $r;
					}
				}
			}
		}
		if($lists) {
			$address = array();
			$result = $db->query("SELECT * FROM {$DT_PRE}address WHERE username='$_username' ORDER BY listorder ASC,itemid ASC LIMIT 30");
			while($r = $db->fetch_array($result)) {
				$r['street'] = $r['address'];
				if($r['areaid']) $r['address'] = area_pos($r['areaid'], '').$r['address'];
				$address[] = $r;
			}
			$user = userinfo($_username);
		}
	}
	$head_title = $L['buy_title'];
	include template('buy', $module);
}
?>