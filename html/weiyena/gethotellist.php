<?php
/*
	取得锦江之星所有酒店列表
*/ 
require '../common.inc.php';

// hotel list
$data= <<< XML
<crsmessage PropID="" user="$jjuser" pass="$jjpass" msgtype="getproplist">
	<PropLimits>
		<date></date>
		<pageno>3</pageno>
	</PropLimits>
</crsmessage>
XML;
// hotel info
// $data= <<< XML
// <crsmessage PropID="60001" user="ids_207_959177_xuzhouga" pass="959177xuzhou" msgtype="getProperty"> 
// </crsmessage>
// XML;
// $url='http://taxmltest.hubs1.net/servlet/SwitchReceiveServlet';

$response = curlxml($jjurl,$data);

$xml  =  simplexml_load_string ( $response );

$r=object2array($xml);
 
foreach ($r['props']['prop'] as $key => $value) {
	$a=$db->query("INSERT INTO destoon_hotel (hotelid,hotelname,status,brandname,brandcode,apigroup) VALUES ('".$value['id']."','".$value['name']."','".$value['status']."','".$value['brandname']."','".$value['brandcode']."','jinjiang')");

	 echo ($value['id']).'<br>';
}
echo "导入酒店列表完成";