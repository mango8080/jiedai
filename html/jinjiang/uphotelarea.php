<?php
require '../common.inc.php';
//更新酒店基础信息
set_time_limit(0);
$i=0;
$hotels=$db->query("select * from destoon_company where tmpaa=0 and apigroup='jinjiang' Limit 0,100");

while ($r=$db->fetch_array($hotels)) {	
	$hotelid=$r['hotelid'];
	// 酒店基础信息
$data= <<< XML
<crsmessage PropID="$hotelid" user="$jjuser" pass="$jjpass" msgtype="getProperty"> 
</crsmessage>
XML;
	$response = curlxml($jjurl,$data);
	$xml  =  simplexml_load_string ( $response );

	$res=object2array($xml);
	if ($res["@attributes"]["result"]=='success') {
		$areaid=areatoareaid_new($res['prop']['cityname'],$res['prop']['districtname']);
		$db->query("UPDATE destoon_company set tmpaa=1,areaid='{$areaid}' WHERE hotelid = '{$hotelid}' and apigroup='jinjiang'");	
	}	
	$i++;
	echo $i.date("Y-m-d H:i:s")."<br/>";
	
}
echo "ok";