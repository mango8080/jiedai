<?php
require '../common.inc.php';
// 更新酒店价格为0的酒店 

$hotels=$db->query("select * from destoon_company where `lowprice`=0 and apigroup='jinjiang' Limit 0,1");

while ($r=$db->fetch_array($hotels)) {

	$hotelprice = array();
	$hotelid=$r['hotelid'];
// 删除 借款类型 价格为0 的房型 和酒店
	// $db->query("delete  from destoon_mall_data where itemid in(select itemid from destoon_mall where username='".$r['username']."')");
	// $db->query("delete from destoon_mall where username='".$r['username']."' ");
	$mall=$db->query("select * from destoon_mall where username='".$r['username']."'");
	while ( $mr=$db->fetch_array($mall)) {
		// 价格
		$today=date('Y-m-d');
		$prices=getprice($jjurl,$jjuser,$jjpass,$jjiata,$hotelid,$today,1,$mr['roomtype']);
		if ($prices['price']<=0) {
			continue;
		}
		
		// 酒店最低价格数组
		$hotelprice[]=$prices['price'];
	}

	$db->query("UPDATE `destoon_company` set `lowprice`='".min($hotelprice)."',hiprice='".max($hotelprice)."' WHERE `hotelid` = '".$hotelid."' and apigroup='jinjiang'");	
}
echo "ok";