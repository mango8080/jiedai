<?php
require '../common.inc.php';
// 测试酒店信息和房型 信息 
// 酒店基础信息
/*$data= <<< XML
<crsmessage PropID="66010" user="$jjuser" pass="$jjpass" msgtype="getProperty"> 
</crsmessage>
XML;*/
$hotelid='61468';
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

$response = curlxml($jjurl,$data);
$xml  =  simplexml_load_string ( $response );
// var_dump($response);exit();
$r=object2array($xml);

foreach ($r["roomobjmap"]["roomobjdata"]["roomobjdetail"] as $key => $value) {
		// 取得酒店数据
		
		$mall['roomtype']=arrtostr($value['roomtype']);
	// echo $mall['roomtype'];
		// 价格
		$today=date('Y-m-d');
		$prices=getonlineratemap($jjurl,$jjuser,$jjpass,$jjiata,$hotelid,$today,1,$mall['roomtype']);
		
		// 酒店最低价格数组
		$hotelprice[]=$prices['price'];
		 var_dump($prices);
	}



exit;
