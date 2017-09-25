<?php
require '../common.inc.php';

$r=jjcancelorder($jjorderurl,$jjuser,$jjpass,'60132',$confnum);
var_dump($r);
/*$url='http://taxml.hubs1.net/servlet/SwitchReceiveServlet';
$today=date('Y-m-d');
$days=1;
$roomtype='BURB';
// SBRA  TWRA  TWRC
$data= <<< XML
<crsmessage PropID="65001" user="ids_207_959177_xuzhouga" pass="xzga959177" msgtype="getroomobj">
	<roomobjmap>
		<roomobjdata>
			<roomobjlist>
				<roomtype>$roomtype</roomtype>
			</roomobjlist>
		</roomobjdata>
	</roomobjmap>
</crsmessage>
XML;
	$response = curlxml($url,$data);
	$xml  =  simplexml_load_string ( $response );
	$r=object2array($xml);
var_dump($r);*/
// $prices=getprice($url,$jjuser,$jjpass,$jjiata,'60001',$today,$days,$roomtype);
// var_dump($prices);
