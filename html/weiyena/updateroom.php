<?php
require '../common.inc.php';
if (!$thisid) {
	$thisid=$db->count('destoon_mall');
}
$offset=$thisid-1;
$result=$db->query("SELECT * FROM `destoon_mall`  order by addtime limit $offset, 1");
if (!$result) {
	exit('更新完成');
}
while ($r=$db->fetch_array($result)) {
	$hotelid=$r['hotelid'];
	$itemid=$r['itemid'];
	$data= <<< XML
<crsmessage PropID="$r[hotelid]" user="$jjuser" pass="$jjpass" msgtype="getroomobj">
	<roomobjmap>
		<roomobjdata>
			<roomobjlist>
				<roomtype>$r[roomtype]</roomtype>
			</roomobjlist>
		</roomobjdata>
	</roomobjmap>
</crsmessage>
XML;
	$response = curlxml($jjurl,$data);
	$xml  =  simplexml_load_string ( $response );
	$room=object2array($xml);

	$mall['title']=arrtostr($room["roomobjmap"]["roomobjdata"]["roomobjdetail"]['roomname']);
		$mall['roomtype']=arrtostr($room["roomobjmap"]["roomobjdata"]["roomobjdetail"]['roomtype']);
		$mall['numadults']=arrtostr($room["roomobjmap"]["roomobjdata"]["roomobjdetail"]['numadults']);
		$mall['numchildren']=arrtostr($room["roomobjmap"]["roomobjdata"]["roomobjdetail"]['numchildren']);
		$mall['rollaway']=arrtostr($room["roomobjmap"]["roomobjdata"]["roomobjdetail"]['rollaway']);
		$mall['maxoccupancy']=arrtostr($room["roomobjmap"]["roomobjdata"]["roomobjdetail"]['maxoccupancy']);
		$mall['totadults']=arrtostr($room["roomobjmap"]["roomobjdata"]["roomobjdetail"]['totadults']);
		$mall['totchildren']=arrtostr($room["roomobjmap"]["roomobjdata"]["roomobjdetail"]['totchildren']);
		$mall['jihuo']=arrtostr($room["roomobjmap"]["roomobjdata"]["roomobjdetail"]['status']);
		$mall['area']=arrtostr($room["roomobjmap"]["roomobjdata"]["roomobjdetail"]['area']);
		$mall['floor']=arrtostr($room["roomobjmap"]["roomobjdata"]["roomobjdetail"]['floor']);
		$mall['bedtype']=arrtostr($room["roomobjmap"]["roomobjdata"]["roomobjdetail"]['bedtype']);
		$mall['service']=arrtostr($room["roomobjmap"]["roomobjdata"]["roomobjdetail"]['service']);
		$mall['category']=arrtostr($room["roomobjmap"]["roomobjdata"]["roomobjdetail"]['category']);
		// 价格
		$today=date('Y-m-d');
		$prices=getprice($jjurl,$jjuser,$jjpass,$jjiata,$hotelid,$today,1,$mall['roomtype']);
		$mall['price ']=$prices['price'];
		$mall['pdouble ']=$prices['double'];
		$mall['ptriple ']=$prices['triple'];
		$mall['pquad ']=$prices['quad'];
		$mall['breakfastdesc ']=$prices['breakfastdesc'];
		$mall['netdesc ']=$prices['netdesc'];
		$mall['amount ']=$prices['amount'];
		// 酒店最低价格数组
		$hotelprice[]=$prices['price'];
		// 图片
		$thumbs=getimg($jjurl,$jjuser,$jjpass,$hotelid,arrtostr($room["roomobjmap"]["roomobjdata"]["roomobjdetail"]['roomname']));
		$images= array('thumb','thumb1','thumb2' );
		foreach ($thumbs as $key => $value) {
			$thumbname=$images[$key];
			$mall[$thumbname]=arrtostr($value);
		}
		$str='';

		foreach ($mall as $k => $v) {
			$str.=$k."='".$v."',";
			
		}
		$str=substr($str, 0,strlen($str)-1);
		$res=$db->query("update `destoon_mall` set $str where itemid='$itemid'");
		// get hotel price
		$hprice=$db->get_one("SELECT * from `destoon_company` where hotelid='".$hotelid."' and apigroup='jinjiang'");
		if ($hprice['lowprice']==0.0 || $hprice['hiprice']==0.0) {
			$db->query("UPDATE `destoon_company` set `lowprice`='".min($hotelprice)."',hiprice='".max($hotelprice)."' WHERE `itemid` = ".$hprice['itemid']);
		}
		if ($hprice['lowprice']>0 && $hprice['lowprice']>min($hotelprice)) {
			$db->query("UPDATE `destoon_company` set `lowprice`='".min($hotelprice)."' WHERE `itemid` = ".$hprice['itemid']);
		}
		if ($hprice['hiprice']>0 && $hprice['hiprice']<max($hotelprice)) {
			$db->query("UPDATE `destoon_company` set `hiprice`='".max($hotelprice)."' WHERE `itemid` = ".$hprice['itemid']);
		}
		// $res=$db->query("UPDATE `destoon_company` set `lowprice`='".min($hotelprice)."',hiprice='".max($hotelprice)."' WHERE `hotelid` = '".$hotelid."'and apigroup='jinjiang'");
echo $itemid;
}
if ($thisid==1) exit('更新完成');
?>
<script type="text/javascript">window.location.href="updateroom.php?thisid=<?php echo ($thisid); ?>"</script>






