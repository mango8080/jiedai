<?php
/*
	[Hotel System] Copyright (c) 2008-2016 www.idc580.cn
	房客
*/
//if ($username=='hanting2210031') log_write(time(), 'aliwap-notify-post-1', 1);
defined('IN_DESTOON') or exit('Access Denied');
$STARS = $L['star_type'];
$userid = isset($userid) ? intval($userid) : 0;
$username = isset($username) ? trim($username) : '';
check_name($username) or $username = '';
if ($userid || $username) {
	if ($userid) $username = get_user($userid, 'userid', 'username');
	$COM = userinfo($username,0,6);
	if (!$COM || ($COM['groupid'] < 5 && $COM['groupid'] > 1)) {
		userclean($username);
		mobile_msg($L['msg_not_corp']);
	}
	if (!$COM['edittime'] && !$MOD['openall']) mobile_msg($L['com_opening']);
	$COM['year'] = vip_year($COM['fromtime']);
	$COMGROUP = cache_read('group-' . $COM['groupid'] . '.php');
	if (!isset($COMGROUP['homepage']) || !$COMGROUP['homepage']) mobile_msg($L['com_no_home']);
	require_once DT_ROOT . '/module/member/global.func.php';
	$userid = $COM['userid'];
	$company = $COM['company'];
	$hotelid=$COM['hotelid'];
	$zhekoubl=$COM['zhekou'];
	
	$HURL = 'index.php?moduleid=4&username=' . $username;
	
	$head_title = $company;
	$foot = '';
	//if ($username=='hanting2210031') log_write(time(), 'aliwap-notify-post-2', 2);
	ob_flush();
	
	$days=diffBetweenTwoDays($beginDate,$endDate);
	$second1=strtotime($beginDate);
	// 该酒店的房型
	$fangxing = $db->query("SELECT a.*,b.content FROM `destoon_mall` as a left join `destoon_mall_data` as b on a.itemid=b.itemid where a.username='$username' and a.status=3  and a.price>0");
	if ($COM['apigroup']=='hanting'){
		//if ($username=='hanting2210031') log_write(time(), 'aliwap-notify-post-20', 2);
		$objEtt = new Ett();
		//if ($username=='hanting2210031') log_write(time(), 'aliwap-notify-post-21', 2);
		$fangxingstatus=$objEtt->checkroom_statusprice($hotelid,$beginDate,$endDate);
		//if ($username=='hanting2210031') log_write(time(), 'aliwap-notify-post-22', 2);
	}
	//if ($username=='hanting2210031') log_write(time(), 'aliwap-notify-post-3', 3);
	ob_flush();
	while ($r = $db->fetch_array($fangxing)) {
		$lowprice=0;
		// 取实时价
		//echo empty($COM['apigroup']);exit();
		if (empty($COM['apigroup'])){
			
			$r['RoomStatus']="A";	
			$arrfx=unserialize($r['moreamount']);
			for($day=0;$day<$days;$day++){
				$nowdate=date("Y-m-d",strtotime("+{$day} days",$second1));
				if(empty($arrfx)){

				}else{
					$fangtai=$arrfx[$nowdate];
					if($fangtai<=0)$r['RoomStatus']="N";
				}
			}
		}elseif ($COM['apigroup']=='hanting'){
			if (empty($fangxingstatus)){
				$r['RoomStatus']="N";
				$lowprice=0;
			}else{
				$r['RoomStatus']=$fangxingstatus[$r['roomtype']]['RoomStatus'];
				$lowprice=$fangxingstatus[$r['roomtype']]['LowPrice'];
			}
			$r['price']=$lowprice;
		}else{
			switch ($COM['apigroup']) {
				case 'jinjiang':
					$fangxingstatus=getonlineratemap($jjurl,$jjuser,$jjpass,$jjiata,$hotelid,$beginDate,$days,$r['roomtype'],$roomNum);
					if($fangxingstatus){
						$r['RoomStatus']=$fangxingstatus['RoomStatus'];
						$lowprice=min($fangxingstatus['RoomPrice']);
					}else{
						$r['RoomStatus']="N";
					}
					break;
				case 'hanting':
					
					$fangxingstatus=$ett->getonlineratemap($hotelid,$beginDate,$endDate,$r['roomtype']);
					if($fangxingstatus){
						$r['RoomStatus']=$fangxingstatus['RoomStatus'];
						$lowprice=$fangxingstatus['LowPrice'];
					}else{
						$r['RoomStatus']="N";
					}
					break;
				default:
					break;
			}
			$r['price']=$lowprice;
		}
		$malls[] = $r;
	}
	//if ($username=='hanting2210031') log_write(time(), 'aliwap-notify-post-4', 4);
	ob_flush();
	switch ($action) {
		
		case 'mall':
			$moduleid = 16;
			break;
		case 'sell':
			$moduleid = 5;
			break;
		case 'buy':
			isset($_MENU[$action]) or dheader($HURL);
			$could_buy = check_group($_groupid, $MOD['group_buy']);
			if ($username == $_username) $could_buy = true;
			$could_buy or mobile_msg($L['com_no_permission'] . $_MENU[$action]);
			$moduleid = 6;
			break;
		case 'job':
			$moduleid = 9;
			break;
		case 'photo':
			$moduleid = 12;
			break;
		case 'info':
			$moduleid = 22;
			break;
		case 'brand':
			$moduleid = 13;
			break;
		case 'video':
			$moduleid = 14;
			break;
		default:
			$background = (isset($HOME['background']) && $HOME['background']) ? $HOME['background'] : '';
			$logo = (isset($HOME['logo']) && $HOME['logo']) ? $HOME['logo'] : ($COM['thumb'] ? $COM['thumb'] : 'static/img/home-logo.png');
			$M = array();
			foreach ($MENU as $v) {
				if (in_array($v['file'], array('introduce', 'news', 'credit', 'contact'))) continue;
				$M[] = $v;
			}
			$COM['thumb']=DT_PATH.$COM['thumb'];
			$comment=array();
			$result = $db->query("SELECT a.*,b.username FROM {$DT_PRE}mall_comment as a left join {$DT_PRE}member b on a.buyer=b.username WHERE a.seller_star>0 and a.seller='".$COM[username]."' LIMIT 0,20");
			while ($r = $db->fetch_array($result)) {
				//$r['linkurl'] = mobileurl($moduleid, 0, $r['itemid']);
				$r['adddate'] = timetodate($r['seller_ctime'], 6);
				$r['username']= hideStr($r['username']);
				$comment[] = $r;
			}
			$commentcount=count($comment);
			//if ($username=='hanting2210031') log_write(time(), 'aliwap-notify-post-5', 5);
			ob_flush();
			include template('homepage', 'mobile');
			//if ($username=='hanting2210031') log_write(time(), 'aliwap-notify-post-6', 6);
			ob_flush();
			break;
		}
		if (in_array($action, array('mall', 'sell', 'buy', 'job', 'photo', 'info', 'brand', 'video'))) {
			isset($_MENU[$action]) or dheader($HURL);
			$table = get_table($moduleid);
			$head_name = $_MENU[$action];
			$head_title = $head_name . $DT['seo_delimiter'] . $head_title;
			$back_link = $HURL;
			$condition = "username='$username' AND status=3";
			if (in_array($action, array('mall', 'sell'))) {
				$typeid = isset($typeid) ? intval($typeid) : 0;
				if ($typeid) {
					$condition.= " AND mycatid='$typeid'";
					$back_link.= '&action=' . $action;
				}
			}
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition");
			$pages = mobile_pages($r['num'], $page, $pagesize);
			$lists = array();
			$result = $db->query("SELECT * FROM {$table} WHERE $condition ORDER BY edittime DESC LIMIT $offset,$pagesize");
			while ($r = $db->fetch_array($result)) {
				$r['linkurl'] = mobileurl($moduleid, 0, $r['itemid']);
				$r['date'] = timetodate($r['edittime'], 5);
				$lists[] = $r;
			}
			include template('homepage-channel', 'mobile');
		}
		
} else {
		$pagesize = 10;
		if (empty($orderDistance)) {$orderDistance="asc";}
		if ($kw) {
			check_group($_groupid, $MOD['group_search']) or mobile_msg($L['msg_no_search']);
		} else if ($catid) {
			$CAT or mobile_msg($L['msg_not_cate']);
			if (!check_group($_groupid, $MOD['group_list']) || !check_group($_groupid, $CAT['group_list'])) {
				mobile_msg($L['msg_no_right']);
			}
		} else {
			check_group($_groupid, $MOD['group_index']) or mobile_msg($L['msg_no_right']);
		}
		$head_title = $MOD['name'] . $DT['seo_delimiter'] . $head_title;
		if ($kw) $head_title = $kw . $DT['seo_delimiter'] . $head_title;
		$condition = "c.groupid>5 AND c.hotelstatus='active'";
		if ($cityName){
			$sql_1="Select * from destoon_area Where areaname = '{$cityName}市'";
			$sql_2="Select * from destoon_area Where areaname like '%{$cityName}%'";
			$area = $db->get_one($sql_1, 'CACHE');
			$area2 = $db->get_one($sql_2, 'CACHE');
			if (!empty($area)){
				$condition.= " AND c.areaid in (".$area['arrchildid'].")";
			}elseif(!empty($area2)){
				$condition.= " AND c.company like '%{$cityName}%'";
			}
		}
		//echo $sql_1;exit;
        // echo $table;exit;
		$toplists = array();
		$tmp_condition="0";
		//echo $condition;exit();
		$sql = "SELECT * FROM {$table} AS c WHERE {$condition} and vip=1 LIMIT 0,3";
		$result = $db->query($sql);
		//echo $sql;exit();
		while ($r = $db->fetch_array($result)) {
			$tmp_condition.=",".$r['userid'];
			if (empty($r['apigroup'])){
				$lowprice=$r['lowprice'];
			}else{
				$lowprice=getlowprice($jjurl,$jjuser,$jjpass,$jjiata,$r['hotelid'],$r['apigroup'],$beginDate);
			}
			
			if ($lowprice>0){
				if ($r['longitude'] > 0 && $r['latitude'] > 0) {
					/*$curLong = empty($curLong) ? $lng : $curLong;
					$curLat = empty($curLat) ? $lat : $curLat;*/
					$curLong = ($wtype=="10" ? $lng : (empty($curLong) ? $lng : $curLong));

					$curLat = ($wtype=="10" ? $lat : (empty($curLat) ? $lat : $curLat));
					$r['jl'] = getdistance($curLong, $curLat, $r['longitude'], $r['latitude']);
				} else {
					$r['jl'] = 0;
				}
				if ($r['jl'] > 1000) {
					$r['jlf'] = round($r['jl'] / 1000, 1);
					$r['jlu'] = "km";
				} elseif ($r['jl'] > 0) {
					$r['jlf'] = $r['jl'];
					$r['jlu'] = "m";
				} else {
					$r['jlf'] ="";
					$r['jlu'] = "";
				}
				$r['thumb']=DT_PATH.$r['thumb'];
				$r['lowprice']=$lowprice;
				$toplists[] = $r;
			}
		}
		$db->free_result($result);
		$condition.= " and userid not in ({$tmp_condition})";
		
		if ($wd){	
			if ($wtype=="10"){	

			}elseif ($wtype=="9"){
				$condition.= " AND (c.keyword LIKE '%{$wd}%' OR c.company LIKE '%{$wd}%')";
			}else{
				$aa=$bb=$cc="";
				$type_array=explode('/',$wtype);
				$wd_array=explode('/',$wd);
				$num = count($type_array);
				for($i=0;$i<$num;++$i){
					if ($type_array[$i]=="1")$aa.="'".$wd_array[$i]."',";
					//if ($type_array[$i]=="1")$aa.=$wd_array[$i];
                    // if($type_array[$i]=="1"){$aa.=$wd_array[$i];}elseif ($type_array[$i]=="") {
                     //	$aa.=$wd_array[$i];
                   //  }

					if ($type_array[$i]=="2")$bb.="'".$wd_array[$i]."',";
					if ($type_array[$i]=="3")$cc.="'".$wd_array[$i]."',";
				}
				if (!empty($aa)) $condition.= " AND c.groupname in ({$aa}'0')";
				//if (!empty($aa)) $condition.= " AND c.company like '%{$aa}%'";
				if (!empty($bb)) $condition.= " AND c.starrating in ({$bb}'0')";
				if (!empty($cc)) $condition.= " AND c.districtname in ({$cc}'0')";
			}
			
		}
		//echo "SELECT COUNT(userid) AS num FROM {$table} AS c WHERE {$condition}";exit;
		$r = $db->get_one("SELECT COUNT(userid) AS num FROM {$table} AS c WHERE {$condition}");
		$items = $r['num'];
		$offset = ($page-1)*$pagesize;
		$pages = mobile_pages($items, $page, $pagesize);
		$totalpage = ceil($items/$pagesize);
		$lists = array();
		if ($items) {
			$order = $MOD['order'];
			if (isset($orderPrice) && !empty($orderPrice)) $order = "c.lowprice {$orderPrice}";

			$sql = "SELECT c.* FROM {$table} AS c ";
			//if ((isset($orderDistance) && !empty($orderDistance)) || $action == "mod15") {
			//	$sql.= " WHERE {$condition} ";
			//} else {
				$sql.= " WHERE {$condition} ORDER BY $order";

			//}
			//echo $table;exit();
			$result = $db->query($sql);

			
			while ($r = $db->fetch_array($result)) {
				
				if (empty($r['apigroup'])){
					$lowprice=$r['lowprice'];
				}else{
					//$lowprice=getlowprice($jjurl,$jjuser,$jjpass,$jjiata,$r['hotelid'],$r['apigroup'],$beginDate);
				}
				
				if ($r['longitude'] > 0 && $r['latitude'] > 0 ) {
					/*$curLong = empty($curLong) ? $lng : $curLong;
					$curLat = empty($curLat) ? $lat : $curLat;*/
					$curLong = ($wtype=="10" ? $lng : (empty($curLong) ? $lng : $curLong));

					$curLat = ($wtype=="10" ? $lat : (empty($curLat) ? $lat : $curLat));
					$r['jl'] = getdistance($curLong, $curLat, $r['longitude'], $r['latitude']);
				} else {
					$r['jl'] = 0;
				}
				if ($r['jl'] > 1000) {
					$r['jlf'] = round($r['jl'] / 1000, 1);
					$r['jlu'] = "km";
				} elseif ($r['jl'] > 0) {
					$r['jlf'] = $r['jl'];
					$r['jlu'] = "m";
				} else {
					$r['jlf'] ="";
					$r['jlu'] = "";
				}
				$r['thumb']=DT_PATH.$r['thumb'];
				$lists[] = $r;
			}
			if (isset($orderDistance) && !empty($orderDistance)) {
				foreach ($lists as $key => $row) {
					$volume[$key] = $row['jl'];
				}
				if ($orderDistance == "desc") {
					array_multisort($volume, SORT_DESC, $lists);
				} else {
					array_multisort($volume, SORT_ASC, $lists);
				}
			}
			$db->free_result($result);
			$lists=array_slice($lists,$offset,$pagesize);
		}
		$back_link = mobileurl($moduleid);
		if ($kw) {
			$seo_file = 'search';
			$head_name = $MOD['name'] . $L['search'];
		} else if ($catid) {
			$seo_file = 'list';
			$head_name = $CAT['catname'];
			if ($CAT['parentid']) $back_link = mobileurl($moduleid, $CAT['parentid']);
		} else {
			$seo_file = 'index';
			$head_name = $MOD['name'];
		}
		if ($action == "mod15") {
			echo json_encode(array('status' => 0, 'totalRecords' => count($lists),'nowpage'=>$page, 'data' => $lists));
		} else {
			include DT_ROOT . '/include/seo.inc.php';
			include template($module, 'mobile');
		}
}
	//if ($username=='hanting2210031') log_write(time(), 'aliwap-notify-post-7', 7);
	function getdistance($lng1, $lat1, $lng2, $lat2) {
		$radLat1 = deg2rad($lat1);
		$radLat2 = deg2rad($lat2);
		$radLng1 = deg2rad($lng1);
		$radLng2 = deg2rad($lng2);
		$a = $radLat1 - $radLat2;
		$b = $radLng1 - $radLng2;
		$s = round(2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000, 0);
		return $s;
	}
	function hideStr($string){
		if (empty($string)) return false;
	    $array = array();
		$strlen = $length = mb_strlen($string);
	    while ($strlen) {
	            $array[] = mb_substr($string, 0, 1, "utf8");
	            $string = mb_substr($string, 1, $strlen, "utf8");
	            $strlen = mb_strlen($string);
	    }
	    $left = 1;
	    $right = 1;
	    $tem = array();
	    for ($i = 0; $i < ($length - $right); $i++) {
	            if (isset($array[$i]))
	                $tem[] = $i >= $left ? "*" : $array[$i];
	    }
	    $array = array_chunk(array_reverse($array), $right);
	    $array = array_reverse($array[0]);
	    for ($i = 0; $i < $right; $i++) {
	            $tem[] = $array[$i];
	    }
	    $string = implode("", $tem);
	    return $string;
	}
	function getlowprice($jjurl,$jjuser,$jjpass,$jjiata,$hotelid,$apigroup,$beginDate){
		global $db;
		$tmpprice=1000;
		
		$fx = $db->query("SELECT * FROM `destoon_mall` where hotelid='$hotelid' and status=3 ");
		switch ($apigroup) {
			case 'jinjiang':
				while ($rr = $db->fetch_array($fx)) {
					$nowprice=getprice($jjurl,$jjuser,$jjpass,$jjiata,$hotelid,$beginDate,1,$rr['roomtype'],'COR85',1);
					if ($nowprice<$tmpprice) $tmpprice=$nowprice;
				}

				break;
			case 'hanting':
				$endDate=date("Y-m-d",strtotime("+1 day",$beginDate));
				$objEtt = new Ett();
				$tmpprice=$objEtt->getprice($hotelid,$beginDate,$endDate);
				break;	
			default:
					
				break;
		}

		
		
		
		return $tmpprice;
	}
?>