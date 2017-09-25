<?php
/*
	取得锦江之星所有酒店列表
*/ 
require '../common.inc.php';
$count=0;
$startDate=date("Y-m-d H:i:s");
$perpage=300;
if (empty($page)) $page=1;
$offset=($page-1)*$perpage;
//echo "更新开始-".date("Y-m-d H:i:s");
//echo str_repeat(" ", 128);
set_time_limit(0);
$hotels=$db->query("select * from destoon_company where hotelstatus='active' and apigroup='jinjiang' Limit {$offset},{$perpage}");

while ($company=$db->fetch_array($hotels)) {	
	$hotelid=$company['hotelid'];
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
	$r0=object2array($xml);
	if ($r0["@attributes"]["result"]=='success') {
		$today=date('Y-m-d');
		$arrPrice=getallroomprice($jjurl,$jjuser,$jjpass,$jjiata,$hotelid,$today,1);
		if (empty($arrPrice)){//没价格,暂时关闭
			$db->query("Update destoon_company Set hotelstatus='inactive',edit_time='".date("Y-m-d H:i:s")."' WHERE hotelid='{$hotelid}' and apigroup='jinjiang'");
		}else{
			$havePrice=0;
			$lowPrice=100000;
			foreach ($arrPrice as $key => $value) {
				$roomType=$key;
				$havePrice=$havePrice || floatval($value);
				if (floatval($value)<$lowPrice) $lowPrice=floatval($value);

				$m=$db->get_one("SELECT itemid FROM destoon_mall WHERE hotelid='{$hotelid}' and roomtype='{$roomType}'");
				if (empty($m)){

				}else{

				}

			}
			if (empty($havePrice)){//所有房型都没价格,暂时关闭
				$tmpSet="hotelstatus='inactive'";
			}else{
				$tmpSet="lowprice={$lowPrice}";
			}
			$db->query("Update destoon_company Set {$tmpSet},edit_time='".date("Y-m-d H:i:s")."' WHERE hotelid='{$hotelid}' and apigroup='jinjiang'");
		}
	}else{//没房型,暂时关闭
		$errcode=$r["error"]["errorcode"];
		$db->query("Update destoon_company Set hotelstatus='{$errcode}',edit_time='".date("Y-m-d H:i:s")."' WHERE hotelid='{$hotelid}' and apigroup='jinjiang'");
				
	}
	$count++;
	//echo date("Y-m-d H:i:s");
	//ob_flush();
	//flush();
}
$endDate=date("Y-m-d H:i:s");
$strSQL="Insert Into destoon_trans_log(apigroup,trans_type,trans_num,startdate,enddate) Values('jinjiang','room','{$count}','{$startDate}','{$endDate}')";
$db->query($strSQL);
echo "更新酒店房型信息完成-".date("Y-m-d H:i:s");
if ($page<20){
	$page++;
	echo '<script type="text/javascript">window.location.href="updateHotel_Room_jinjiang.php?page='+$page+'";</script>';
}

//exit();
?>