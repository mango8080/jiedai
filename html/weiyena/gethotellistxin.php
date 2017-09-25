<?php
/*
	取得锦江之星所有酒店列表
*/ 
require '../common.inc.php';
//echo $sid;exit;
// hotel list
$data=file_get_contents("http://quickapitest.wyn88.com:8080/hotel/getList?sid=$sid");
// hotel info
// $data= <<< XML
// <crsmessage PropID="60001" user="ids_207_959177_xuzhouga" pass="959177xuzhou" msgtype="getProperty"> 
// </crsmessage>
// XML;
// $url='http://taxmltest.hubs1.net/servlet/SwitchReceiveServlet';
$response=json_decode($data);
var_dump($data);exit;
$response = curlxml($jjurl,$data);

$xml  =  simplexml_load_string ( $response );

$r=object2array($xml);
 
foreach ($r['props']['prop'] as $key => $value) {
	$a=$db->query("INSERT INTO destoon_hotel (hotelid,hotelname,status,brandname,brandcode,apigroup) VALUES ('".$value['id']."','".$value['name']."','".$value['status']."','".$value['brandname']."','".$value['brandcode']."','jinjiang')");

	 echo ($value['id']).'<br>';
}
echo "导入酒店列表完成";