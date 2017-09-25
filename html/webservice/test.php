<?php
require '../common.inc.php';
include load('order.lang');

var_dump(json_encode('8989899'));exit;
$gTable=$table;
$gAs=$tableas;
$gJoin=empty($join)?"":str_replace("#pre#", "{$DT_PRE}", $join);
$gFields=empty($fields)?"*":stripslashes($fields);
$gWhere=empty($condition)?"":"Where ".stripslashes($condition);
$gOrder=empty($order)?"":"Order by $order";
$gLimit=empty($perpage)?"" : "LIMIT $start,$perpage";
$gUpdate=empty($autoadd)?"":$autoadd;
switch ($op) {
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
?>