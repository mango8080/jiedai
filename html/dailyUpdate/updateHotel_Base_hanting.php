<?php
/*
	取得汉庭所有酒店列表
*/ 
require '../common.inc.php';
$apiurl="http://ett.huazhu.com:8086/AgentService.asmx?wsdl";
$sAgentID="VCENTCRM1016527815";
$sAuthCode="A16146A8-0CF3-4605-93E2-A23C83D8C7EF";
try{
	$client = new SoapClient($apiurl);
}catch(Exception $e){
	print $e->getMessage();
	exit();
}
try{
	$hotelResult = $client->__call('QueryHotelIDList',array(array('sAgentID'=>$sAgentID,'sAuthCode'=>$sAuthCode)));
}catch(Exception $e){
	print $e->getMessage();
	exit();
}
$response=json_decode($hotelResult->QueryHotelIDListResult,true);

$arrBrand=array("","quanji","hanting","haiyou","xincheng","xiyue","manxing","yilai");
$startDate=date("Y-m-d H:i:s");
echo "更新开始-".date("Y-m-d H:i:s");
//echo str_repeat(" ", 256);
set_time_limit(0);
$hasnext="true";
$count=0;
$c=1;
$perpage=100;
if (empty($page)) $page=1;
$offset=($page-1)*$perpage;

try{
	$client = new SoapClient($apiurl);
}catch(Exception $e){
	print $e->getMessage();
	exit();
}

		$hotel=$db->query("SELECT * FROM `destoon_hotel` Limit {$offset},{$perpage}");
		$jsonHotelID='';
		$kk=0;
		while ($value=$db->fetch_array($hotel)) {		
			$kk++;
			$jsonHotelID.='{"HotelID":"'.$value['hotelid'].'"},';
			if ($kk==100){
				// 酒店基础信息
				$hotelRe = $client->__call('QueryHotel',array(array('sAgentID'=>$sAgentID,'sAuthCode'=>$sAuthCode,'jsonHotelID'=>$jsonHotelID)));
				$res=json_decode($hotelRe->QueryHotelResult,true);
				//var_dump($res);
				if ($res['ResultCode']==0){
					
					if ($res['ResponseCode']==1){
						foreach ($res['ResultContent'] as $k => $v) {
							$areaid=areatoareaid_new($v['ProvinceName'],$v['CityName']);
							if ($areaid==0){
								$areaid=areatoareaid($v['CityName']);
							}
							updateHotel($v,$arrBrand[$v["BrandCode"]],$areaid);
						}
					}
				}				
				$jsonHotelID='';
				$kk=0;
			}
			$count++;
		}
		if ($kk!=0 && $jsonHotelID!=''){
			// 酒店基础信息
			$hotelResult = $client->__call('QueryHotel',array(array('sAgentID'=>$sAgentID,'sAuthCode'=>$sAuthCode,'jsonHotelID'=>$jsonHotelID)));
			$response=json_decode($hotelResult->QueryHotelResult,true);
			if ($response['ResultCode']==0){
				if ($response['ResponseCode']==1){
					foreach ($response['ResultContent'] as $k => $v) {
						$areaid=areatoareaid_new($v['ProvinceName'],$v['CityName']);
						if ($areaid==0){
							$areaid=areatoareaid($v['CityName']);
						}
						updateHotel($v,$arrBrand[$v["BrandCode"]],$areaid);
					}
				}
			}
		}
	


function updateHotel($r,$strBrand,$areaid){
	global $db;
	$htl=array();
	$hotelid=$r['HotelNo'];
	
	// 酒店名称
	$company=$truename=$r['HotelName'];
	$email=$r['Email'];
	$username=$passport=$strBrand.$r["HotelNo"];
	
	$h=$db->get_one("SELECT itemid,userid FROM destoon_company WHERE hotelid='{$hotelid}' and apigroup='hanting'");
	
	if (empty($h)){
		//图片
		$thumb=$thumb_s=$thumb_m=$thumb_b="";
		$mm=0;
		foreach ($r['HotelPhotoList'] as $p=>$photo){
			if ($photo['RoomTypeCode']==""){//酒店图
				if ($photo['ChildClassCode']==0){//外部
					$thumb=$photo['PhotoURL'][0];
				}else{
					if ($mm==0)	$thumb_s=$photo['PhotoURL'][0];
					if ($mm==1)	$thumb_m=$photo['PhotoURL'][0];
					if ($mm==2)	$thumb_b=$photo['PhotoURL'][0];
					$mm++;
				}
			}
		}
		$password=md5(md5(substr($username, -6)));
		$gender= 1 ;
		$groupid=$regid=6;
		$mobile=$r["Mobile"];					
		// 插入用户数据
		$db->query("REPLACE INTO `destoon_member` ( `username`, `passport`, `company`, `password`,  `email`, `gender`, `truename`,  `groupid`, `regid`, `areaid`,`mobile`) VALUES ('".$username."', '".$username."', '".$company."', '".$password."', '".$email."', '".$gender."', '".$truename."', '6', '6', '".$areaid."','{$mobile}')");
		$userid = $db->insert_id();
		$htl['userid']=$userid;
		
		$htl['groupid']=6;
		$htl['hotelid']=$hotelid;
		$htl['catid']=',3,';	
		$htl['catids']=',3,';
		$htl['mode']='服务业';
		$htl['status']=3; // 状态
		$htl['apigroup']='hanting';
		$htl['add_time']=date("Y-m-d H:i:s");

		$htl['thumb']=GrabImage($thumb,'','../file/upload/ht/');
		if ($thumb_s!="") $htl['thumb_s']=GrabImage($thumb_s,'','../file/upload/ht/');
		if ($thumb_m!="") $htl['thumb_m']=GrabImage($thumb_m,'','../file/upload/ht/');
		if ($thumb_b!="") $htl['thumb_b']=GrabImage($thumb_b,'','../file/upload/ht/');
	}
	$htl['username']=$username;
	$htl['company']=$company;
	$htl['type']=$r['BrandName'];
	$htl['areaid']=$areaid;
	$htl['regyear']=$r['OpeningDate'];
	$htl['mail']=$email;
	$htl['telephone']=$r['Telephone'];
	$htl['fax']=$r['HFax'];
	$htl['address']= $r['HotelAddress'];
	$htl['address2']= $r['HotelAddressTip'];
	$htl['postcode']=$r['ZipCode'];
	$htl['holdtime']="18:00";
	$htl['starrating']=dxingji($r['HotelClassification']);//星级
	$htl['checkout']="12:00";// 离店时间
	//$htl['airportunits']=arrtostr($r['prop']['airportunits']);
	//$htl['airports']=arrtostr($r['prop']['airports']);// 机场
	//$htl['extraadult']=arrtostr($r['prop']['extraadult']);
	$htl['latitude']=$r['Latitude']; // 纬度
	$htl['longitude']=$r['Longitude']; // 经度 
	$htl['checkin']="14:00"; // 入住时间
	//$htl['tradearea']=arrtostr($r['prop']['tradearea']); // 商区名称
	$htl['cityname']=$r['CityName']; // 城市名称
	$htl['latecheckin']="23:00"; // 最晚入住时间
	$htl['totalrooms']=$r['RoomNum']; // 客房总数 
	$htl['hotelstatus']=$r['IsOpening']==true?"active":"inactive"; // 状态 
	//$htl['totalfloors']=arrtostr($r['prop']['totalfloors']); // 楼层 
	$htl['groupname']=$r['BrandName']; // 所属品牌  
	$htl['groupcode']=$r['BrandCode']; // 所属品牌id
	//$htl['groupstatus']=arrtostr($r['prop']['group']['status']); // 所属品牌zhuangtai
	//$htl['specialinvoice']=arrtostr($r['prop']['specialinvoices']); // 是否可开专票
	//$htl['attractions']=arrtostr($r['prop']['attractions']) ; // 旅游景点
	//$htl['dining']=arrtostr($r['prop']['dining']); // 餐饮设施
	//$htl['facilities']=arrtostr($r['prop']['facilities']); // 设施
	//$htl['frequentstay']=arrtostr($r['prop']['frequentstay']); // 常住政策
	//$htl['policies']=arrtostr($r['prop']['policies']); // 预订政策
	$htl['location']=$r['HotelAddressTip']; // 酒店位置
	//$htl['attractions']=$r['prop']['attractions']; // 旅游景点
	//$htl['meetings']=arrtostr($r['prop']['meetings']); // 会议设施
	//$htl['amenities']=arrtostr($r['prop']['amenities']); // 服务设施
	//$htl['districtname']=arrtostr($r['prop']['districtname']);
	//$htl['receptionforeigner']=$r['prop']['receptionforeigner']; // 是否接待外宾
	$htl['introduce']=substr($r['HotelWordIntroduce'],0,255); // 酒店简介
	$content=$r["HotelWordIntroduce"] ; // 详细介绍
	$htl['edit_time']=date("Y-m-d H:i:s");

	$company_sqlk = $company_sqlv = $company_sqlu= '';
	foreach($htl as $k=>$v) {
		$company_sqlk .= ','.$k; 
		$company_sqlv .= ",'$v'";
		$company_sqlu .=",$k='$v'";
	}
	$company_sqlk = substr($company_sqlk, 1);
    $company_sqlv = substr($company_sqlv, 1);
    $company_sqlu = substr($company_sqlu, 1);
    if (empty($h)){
   		$db->query("INSERT INTO `destoon_company` ($company_sqlk) VALUES ($company_sqlv)");
   		$db->query("INSERT INTO `destoon_company_data` (userid,content) VALUES ('".$userid."','".$content."')");
    }else{
    	$db->query("Update destoon_member Set username='{$username}',areaid='{$areaid}' WHERE userid=".$h['userid']);
   		$db->query("Update destoon_company Set {$company_sqlu} WHERE hotelid='{$hotelid}' and apigroup='hanting'");
    }
    //借款类型
	foreach ($r['HotelRoomTypeList'] as $kk=>$vv){
		$mall=array();
		$roomType=$vv['RoomTypeCode'];
		$room=$db->get_one("SELECT itemid FROM destoon_mall WHERE username='{$username}' and hotelid='{$hotelid}' and roomtype='{$roomType}'");
		
		$mall['company']=$company;
		$mall['areaid']=$areaid;
		$mall['title']=$vv['RoomTypeName'];
		$mall['numadults']=$vv['MaxCheckInPeoNum'];
		$mall['numchildren']=$vv['MaxCheckInPeoNum'];
		//$mall['rollaway']=arrtostr($value['rollaway']);
		$mall['maxoccupancy']=$vv['MaxCheckInPeoNum'];
		$mall['totadults']=0;
		$mall['totchildren']=0;
		//$mall['jihuo']=arrtostr($value['status']);
		$mall['area']=$vv['HotelArea'];
		$mall['floor']=$vv['FloorPlace'];
		$mall['bedtype']=$vv['BedType'];
		$mall['service']=$vv['Summary'];
		//$mall['category']=arrtostr($value['category']);
		$company_sqlk = $company_sqlv = $company_sqlu = '';
		if (empty($room)){
			$mall['username']=$username;
			$mall['groupid']=6;
			$mall['roomtype']=$roomType;
			$mall['status']=3;
			$mall['hotelid']=$hotelid;
			// 图片
			$mm=0;
			foreach ($r['HotelPhotoList'] as $p=>$photo){
				if ($photo['RoomTypeCode']==$roomType){//房型图
					if ($mm==0)	$mall['thumb']=GrabImage($photo['PhotoURL'][0],'','../file/upload/ht/');
					if ($mm==1)	$mall['thumb1']=GrabImage($photo['PhotoURL'][0],'','../file/upload/ht/');
					if ($mm==2)	$mall['thumb2']=GrabImage($photo['PhotoURL'][0],'','../file/upload/ht/');
					$mm++;
				}
			}
			foreach($mall as $k=>$v) {
				$company_sqlk .= ','.$k; 
				$company_sqlv .= ",'$v'";
			}
			$company_sqlk = substr($company_sqlk, 1);
	    	$company_sqlv = substr($company_sqlv, 1);
	    	
	    	$db->query("INSERT INTO `destoon_mall` ($company_sqlk) VALUES ($company_sqlv)");
	    	$itemid = $db->insert_id();
			$content=$vv['Summary'];
			$db->query("INSERT INTO `destoon_mall_data` (itemid,content) VALUES ('".$itemid."','".$content."')");
		}else{
			$itemid = $room['itemid'];
			foreach($mall as $k=>$v) {
				$company_sqlu .=",$k='$v'";
			}
	    	$company_sqlu = substr($company_sqlu, 1);
	    	
	    	$db->query("Update destoon_mall Set {$company_sqlu} WHERE itemid='{$itemid}'");
		}
	}
}

$endDate=date("Y-m-d H:i:s");
$strSQL="Insert Into destoon_trans_log(apigroup,trans_type,trans_num,startdate,enddate) Values('hanting','hotel','{$count}','{$startDate}','{$endDate}')";
$db->query($strSQL);
echo "更新酒店基础信息完成-".date("Y-m-d H:i:s");
exit();
?>