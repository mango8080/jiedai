<?php
/*
	酒店数据库操作api
*/
require '../common.inc.php';
// token验证
// if ($token != md5(md5('HaNShanLing'))) {
// 	exit('Access Denied');
// }

switch ($action) {
	case 'page':
		$items=page(stripslashes($condition),$cache);
		exit($items);
		break;
	case 'list':
		$items=hotellist(stripslashes($condition),$fds,$order,$os,$perpage);
		exit(json_encode($items));
		break;
	case 'hothotel':
		$items=hothotel(stripslashes($condition),$ps,$aid);
		exit(json_encode($items));
		break;
	case 'malllist':
		//$items=malllist(stripslashes($condition),$order,$intime,$days,$jjurl,$jjuser,$jjpass,$jjiata);
		$condition2=stripslashes($condition2);
		$COM = $db->get_one("SELECT apigroup,hotelid FROM {$DT_PRE}company as a WHERE {$condition2}");

		$condition=stripslashes($condition);
		$roomNum=1;
	 	$results = array();
	  	$result = $db->query("SELECT a.*,b.apigroup,b.hotelid as hotelid1,b.jiameng FROM {$DT_PRE}mall as a Left Join {$DT_PRE}company as b ON a.username=b.username WHERE {$condition}");
	  	if ($COM['apigroup']=='hanting'){

	  		
	  		$endDate=date("Y-m-d",strtotime(" +{$days} day",strtotime($intime)));
			$ett = new Ett();
			$fangxingstatus=$ett->checkroom_statusprice($COM['hotelid'],$intime,$endDate);
	 	}
	 	//exit(json_encode($fangxingstatus));
		while($r = $db->fetch_array($result)) {
			$lowprice=0;
			if (empty($r['apigroup'])){
				
				$r['RoomStatus']="A";
			}elseif ($r['apigroup']=='hanting'){
				if (empty($fangxingstatus)){
					$r['RoomStatus']="N";
					$lowprice=0;
				}else{
					$r['RoomStatus']=$fangxingstatus[$r['roomtype']]['RoomStatus'];
					$lowprice=$fangxingstatus[$r['roomtype']]['LowPrice'];
				}
				$r['price']=$lowprice;
			}else{
				//echo $roomNum;exit(); 
				$fangxingstatus=getonlineratemap($jjurl,$jjuser,$jjpass,$jjiata,$r['hotelid1'],$intime,$days,$r['roomtype'],$roomNum);
				
				if($fangxingstatus){
					$r['RoomStatus']=$fangxingstatus['RoomStatus'];
					$lowprice=min($fangxingstatus['RoomPrice']);
				}else{
					$r['RoomStatus']="N";
				}

				$r['price']=$lowprice;
			}
			
			$results[] = $r;
		}
		exit(json_encode($results));
		break;
	case 'mall':
		$items=getmall($itemid);
		exit(json_encode($items));
		break;
	case 'mallcontent':
		$items=getmallcontent($itemid);
		exit(json_encode($items));
		break;
	case 'gethotel':
		$items=apigethotel($condition);
		exit(json_encode($items));
		break;
	case 'checkbuy':
		$arrDatePrice=array();
		
			
			if ($apigroup=='jinjiang'){
				$arrDatePrice=getonlineratemap($jjurl,$jjuser,$jjpass,$jjiata,$hotelid,$intime,$days,$roomtype,$roomNum,1);
			}
			if($apigroup=='hanting'){
				$endDate=date("Y-m-d",strtotime(" +{$days} day",strtotime($intime)));
				$ett = new Ett();
			 	$arrDatePrice=$ett->getonlineratemap($hotelid,$intime,$endDate,$roomtype);
			}
			
		
		exit(json_encode($arrDatePrice));
		break;

	default:
		# code...
		break;
}

// 分页数据
function page($condition,$cache=0){
	global $db, $DT_TIME, $DT_PRE;
	$items = $db->count("{$DT_PRE}company", $condition, $cache);
	return $items;
 }

// 酒店列表
 function hotellist($condition,$fds,$order,$offset,$pagesize){
 	global $db, $DT_TIME, $DT_PRE;
 	$results = array();
 	$result = $db->query("SELECT $fds FROM {$DT_PRE}company WHERE {$condition}{$order} LIMIT {$offset},{$pagesize}");
 	while($r = $db->fetch_array($result)) {
			$results[] = $r;
		}
 	return $results;
 }
// 热门酒店
 function hothotel($condition,$pagesize,$areaid,$order=' order by vip desc '){
 	global $db, $DT_TIME, $DT_PRE;
 	if($areaid) $condition.=" and areaid=$areaid";
 	$results = array();
  	$result = $db->query("SELECT * FROM {$DT_PRE}company WHERE {$condition}{$order} LIMIT 0, {$pagesize}");
	while($r = $db->fetch_array($result)) {
			$results[] = $r;
		}
	return $results;
 }
// 房型列表
 function malllist($condition,$order='order by itemid desc',$intime,$days,$jjurl,$jjuser,$jjpass,$jjiata){
 	global $db, $DT_TIME, $DT_PRE;
 	$roomNum=1;
 	$results = array();
  	$result = $db->query("SELECT a.*,b.apigroup,b.hotelid as hotelid1,b.jiameng FROM {$DT_PRE}mall as a Left Join {$DT_PRE}company as b ON a.username=b.username WHERE {$condition} {$order}");
	while($r = $db->fetch_array($result)) {
		$lowprice=0;
		if (empty($r['apigroup'])){
			
			$r['RoomStatus']="A";
		}else{
			//echo $roomNum;exit(); 
			$fangxingstatus=getonlineratemap($jjurl,$jjuser,$jjpass,$jjiata,$r['hotelid1'],$intime,$days,$r['roomtype'],$roomNum);
			
			if($fangxingstatus){
				$r['RoomStatus']=$fangxingstatus['RoomStatus'];
				$lowprice=min($fangxingstatus['RoomPrice']);
			}else{
				$r['RoomStatus']="N";
			}

			$r['price']=$lowprice;
		}
			$results[] = $r;
	}
	return $results;
 }
// 房型信息
function getmall($itemid){
	global $db, $DT_TIME, $DT_PRE;
	$item = $db->get_one("SELECT * FROM {$DT_PRE}mall WHERE itemid=$itemid");
	return $item;
}
// 房型详细内容
function getmallcontent($itemid){
	global $db, $DT_TIME, $DT_PRE;
	$item = $db->get_one("SELECT content FROM {$DT_PRE}mall_data WHERE itemid=$itemid");
	return $item;
}
// 取得酒店信息
function apigethotel($condition){
	global $db, $DT_TIME, $DT_PRE;
	return $db->get_one("SELECT * FROM {$DT_PRE}company WHERE {$condition}");
}
