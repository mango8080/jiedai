<?php
/*
	导入锦江之星所有的房型
*/ 

require '../common.inc.php';

$hotel=$db->get_one("SELECT * FROM `destoon_hotel` WHERE `is_fangxing` = 0 and apigroup='jinjiang'");
if (!$hotel) {
	exit('导入完成');
}


// $hotelid='66027';
$hotelid=$hotel['hotelid'];
//$hotelid=60308;
$company=$db->get_one("SELECT * FROM `destoon_company` WHERE `hotelid` = '".$hotelid."' and apigroup='jinjiang'");

$m=$db->get_one("SELECT * FROM destoon_mall WHERE username='".$company['username']."'");

if(empty($m)){
//echo 1;exit;	
// fangxing
$data= <<< XML
<crsmessage PropID="$hotelid" user="$jjuser" pass="$jjpass" msgtype="getroomobj">
	<roomobjmap>
		<roomobjdata>
			<roomobjlist>
				<roomtype></roomtype>
			</roomobjlist>
		</roomobjdata>
	</roomobjmap>
</crsmessage>
XML;

// $url='http://taxmltest.hubs1.net/servlet/SwitchReceiveServlet';

$response = curlxml($jjurl,$data);
$xml  =  simplexml_load_string ( $response );
$r=object2array($xml);
// 将所有房型的价格放在数组中，计算最低价格
$hotelprice = array();
// var_dump($r);exit;
if ($r["@attributes"]["result"]=='success') {
	foreach ($r["roomobjmap"]["roomobjdata"]["roomobjdetail"] as $key => $value) {
		// 取得酒店数据
		$company=$db->get_one("SELECT * FROM `destoon_company` WHERE `hotelid` = '".$hotelid."'");

		$mall['username']=arrtostr($company['username']);
		$mall['groupid']=arrtostr($company['groupid']);
		$mall['company']=arrtostr($company['company']);
		$mall['areaid']=arrtostr($company['areaid']);
		$mall['status']=3;
		$mall['hotelid']=$hotelid;

		$mall['title']=arrtostr($value['roomname']);
		$mall['roomtype']=arrtostr($value['roomtype']);
		$mall['numadults']=arrtostr($value['numadults']);
		$mall['numchildren']=arrtostr($value['numchildren']);
		$mall['rollaway']=arrtostr($value['rollaway']);
		$mall['maxoccupancy']=arrtostr($value['maxoccupancy']);
		$mall['totadults']=arrtostr($value['totadults']);
		$mall['totchildren']=arrtostr($value['totchildren']);
		$mall['jihuo']=arrtostr($value['status']);
		$mall['area']=arrtostr($value['area']);
		$mall['floor']=arrtostr($value['floor']);
		$mall['bedtype']=arrtostr($value['bedtype']);
		$mall['service']=arrtostr($value['service']);
		$mall['category']=arrtostr($value['category']);
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
		$thumbs=getimg($jjurl,$jjuser,$jjpass,$hotelid,arrtostr($value['roomname']));
		$images= array('thumb','thumb1','thumb2' );
		foreach ($thumbs as $key => $value) {
			$thumbname=$images[$key];
			$mall[$thumbname]=GrabImage(arrtostr($value),'','../file/upload/jj/');
		}
		$company_sqlk = $company_sqlv = '';
		foreach($mall as $k=>$v) {
			$company_sqlk .= ','.$k; 
			$company_sqlv .= ",'$v'";
		}
		$company_sqlk = substr($company_sqlk, 1);
    	$company_sqlv = substr($company_sqlv, 1);

    	$db->query("INSERT INTO `destoon_mall` ($company_sqlk) VALUES ($company_sqlv)");
    	$itemid = $db->insert_id();

		$content=arrtostr($value['description']);
		$db->query("INSERT INTO `destoon_mall_data` (itemid,content) VALUES ('".$itemid."','".$content."')");
		echo $mall['title']." input ok <br>";
	}
}
}
$db->query("UPDATE `destoon_company` set `lowprice`='".min($hotelprice)."',hiprice='".max($hotelprice)."' WHERE `hotelid` = '".$hotelid."'");
$db->query("UPDATE `destoon_hotel` SET `is_fangxing` = '1' WHERE `itemid` = ".$hotel['itemid']);



?>
<script type="text/javascript">window.location.href="getfangxingxiugai.php?a="+Math.random();</script>