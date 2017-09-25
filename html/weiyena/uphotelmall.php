<?php
require '../common.inc.php';
//更新酒店房型
set_time_limit(0);
$i=0;
$hotels=$db->query("select * from destoon_company where tmpaa=0 and apigroup='jinjiang' Limit 0,100");

while ($company=$db->fetch_array($hotels)) {	
	$hotelid=$company['hotelid'];
	// 房型基础信息
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
			$roomType=arrtostr($value['roomtype']);
			$m=$db->get_one("SELECT itemid FROM destoon_mall WHERE hotelid='{$hotelid}' and roomtype='{$roomType}'");
			// 取得酒店数据
			$mall['username']=$company['username'];
			$mall['groupid']=$company['groupid'];
			$mall['company']=$company['company'];
			$mall['areaid']=$company['areaid'];
			$mall['status']=3;
			$mall['hotelid']=$hotelid;

			$mall['title']=arrtostr($value['roomname']);
			$mall['roomtype']=$roomType;
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
			$prices=getprice($jjurl,$jjuser,$jjpass,$jjiata,$hotelid,$today,1,$roomType);

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
			if (empty($m)){
				$thumbs=getimg($jjurl,$jjuser,$jjpass,$hotelid,arrtostr($value['roomname']));
				$images= array('thumb','thumb1','thumb2' );
				foreach ($thumbs as $key => $value) {
					$thumbname=$images[$key];
					$mall[$thumbname]=GrabImage(arrtostr($value),'','../file/upload/jj/');
				}
			}

			$company_sqlk = $company_sqlv = $fielter= '';
			foreach($mall as $k=>$v) {
				$company_sqlk .= ','.$k; 
				$company_sqlv .= ",'$v'";
				$fielter .=",$k='$v'";
			}
			$company_sqlk = substr($company_sqlk, 1);
	    	$company_sqlv = substr($company_sqlv, 1);
	    	$fielter = substr($fielter, 1);
	    	if (empty($m)){
	    		$SQL="INSERT INTO `destoon_mall` ($company_sqlk) VALUES ($company_sqlv)";
	    		$content=arrtostr($value['description']);
				$db->query("INSERT INTO `destoon_mall_data` (itemid,content) VALUES ('".$itemid."','".$content."')");
	    	}else{
	    		$SQL="Update destoon_mall Set {$fielter} WHERE hotelid='{$hotelid}' and roomtype='{$roomType}' ";
	    	}
	    	$db->query($SQL);
			
			//echo $mall['title']." input ok <br/>";
		}
	}

	$db->query("UPDATE destoon_company set tmpaa=1,lowprice='".min($hotelprice)."' WHERE hotelid = '{$hotelid}' and apigroup='jinjiang'");
	$i++;
	echo $i.date("Y-m-d H:i:s")."<br/>";
	
}
echo "ok";