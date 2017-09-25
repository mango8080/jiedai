<?php 
defined('IN_DESTOON') or exit('Access Denied');
if($DT_BOT || $_POST) dhttp(403);
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$condition = "1=1";
$itemid=$_GET["itemid"];
isset($fromtime) or $fromtime = '';
isset($totime) or $totime = '';
if($fromtime) $condition .= " AND addtime>".(strtotime($fromtime.' 00:00:00'));
if($totime) $condition .= " AND addtime<".(strtotime($totime.' 23:59:59'));
if($itemid) $condition .= " AND ordercode=$itemid";
if($buyer_name) $condition .= " AND buyer_name like '%$buyer_name%'";
if($buyer) $condition .= " AND buyer=$buyer";
if($moblie) $condition .= " AND buyer_moblie=$moblie";
//$perpage=10;
//if(empty($page))$page=1;
//$offset=($page-1)*$perpage;
//echo "SELECT * FROM destoon_mall_order limit {$offset},{$perpage}";
//echo "SELECT * FROM destoon_mall_order where $condition limit 0,20";
$result = $db->query("SELECT * FROM destoon_mall_order where $condition limit 0,20");
//$count=$db->get_one("SELECT count(*) FROM destoon_mall_order");
//$count1=ceil($count["count(*)"]/10);

//$r = $db->fetch_array($result);
$xuhao=0;
while($r = $db->fetch_array($result)) {
		
		$xuhao++;
		$r['gone'] = $DT_TIME - $r['updatetime'];
		if($r['status'] == 3) {
			if($r['gone'] > ($MOD['trade_day']*86400 + $r['add_time']*3600)) {
				$r['lefttime'] = 0;
			} else {
				$r['lefttime'] = secondstodate($MOD['trade_day']*86400 + $r['add_time']*3600 - $r['gone']);
			}
		}
		$itemid1=$r['itemid'];
		$username=$r['seller'];
		
		$result1=$db->get_one("select * from {$DT_PRE}finance_charge where substring(reason,7)={$itemid1}");
		$result2=$db->get_one("select * from {$DT_PRE}company where username='{$username}'");
		$r['zhifu']=$result1['bank'];
		$r['seller']=$result2['company'];
		$r['xuhao']=$xuhao;
		$r['par'] = '';
		if(strpos($r['note'], '|') !== false) list($r['note'], $r['par']) = explode('|', $r['note']);
		$r['addtime'] = str_replace(' ', '<br/>', timetodate($r['addtime'], 5));
		$r['updatetime'] = str_replace(' ', '<br/>', timetodate($r['updatetime'], 5));
		$r['linkurl'] = DT_PATH.'api/redirect.php?mid='.$r['mid'].'&itemid='.$r['mallid'];
		$r['dstatus'] = $_status[$r['status']];
		$r['money'] = $r['amount'] + $r['fee'];
		$r['money'] = number_format($r['money'], 2, '.', '');
		$amount += $r['amount'];
		$fee += $r['fee'];
		$lists[] = $r;
		
	}

include template('hujiao', $module);

?>