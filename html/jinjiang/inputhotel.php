<?php
/*
	导入锦江之星的酒店基础数据
*/
require '../common.inc.php';
$hotel=$db->get_one("SELECT * FROM `destoon_hotel` WHERE `is_input` = 0");
if (!$hotel) {
	exit('导入完成');
}
// $hotelid=68050;
$hotelid=$hotel['hotelid'];
// 酒店图片
$dataimg= <<< XML
<crsmessage PropID="$hotelid" user="$jjuser" pass="$jjpass" msgtype="getimage"> 
</crsmessage>
XML;
// $url='http://taxmltest.hubs1.net/servlet/SwitchReceiveServlet';
$response = curlxml($jjurl,$dataimg);
$xml  =  simplexml_load_string ( $response );

$r=object2array($xml);
if ($r["@attributes"]["result"]=='success'){
	$thumb=trim($r['picture']);
	$thumb_s=trim($r['coverimages']['coverimage'][0]);
	$thumb_m=trim($r['coverimages']['coverimage'][1]);
	$thumb_b=trim($r['coverimages']['coverimage'][2]);
}
// 酒店基础信息
$data= <<< XML
<crsmessage PropID="$hotelid" user="$jjuser" pass="$jjpass" msgtype="getProperty"> 
</crsmessage>
XML;

$response = curlxml($jjurl,$data);
$xml  =  simplexml_load_string ( $response );

$r=object2array($xml);
// var_dump($r);
// exit;
if ($r["@attributes"]["result"]=='success') {
	// 构造用户名，密码
	$username=$passport=strtolower($r["prop"]["group"]["code"] .$r["@attributes"]["PropID"]);
	$password=md5(md5(substr($username, -6)));
	$gender= 1 ;
	$groupid=$regid=6;
	$mobile='';
	$email=implode('|',$r['prop']['hotelemail']);
	// 酒店名称
	$company=$truename=$r['prop']['name'];
	// 地区id
	$areaid=areatoareaid_new($r['prop']['cityname'],$r['prop']['districtname']);
	/*
	if (is_array($r['prop']['districtname'])) {
		$areaname=daddslashes($r['prop']['cityname']);
	}else{
		$areaname=daddslashes($r['prop']['districtname']);
	}
	$areaid=areatoareaid($areaname);
    
	if ($areaid==0) {
		$areaid=areatoareaid($r['prop']['cityname']);
	}
	*/
    
	// 插入用户数据
	$db->query("REPLACE INTO `destoon_member` ( `username`, `passport`, `company`, `password`,  `email`, `gender`, `truename`,  `groupid`, `regid`, `areaid`) 
		VALUES ('".$username."', '".$username."', '".$company."', '".$password."', '".$email."', '".$gender."', '".$truename."', '6', '6', '".$areaid."')");
	
	$userid = $db->insert_id();

	// 酒店信息
	
	$htl['userid']=$userid;
	$htl['username']=$username;
	$htl['groupid']=6;
	$htl['hotelid']=$hotelid;
	$htl['company']=$company;
	// 采集图片
	$thumb=getfilename($thumb);

	$htl['thumb']=GrabImage($thumb,'','../file/upload/jj/');
	$htl['thumb_s']=GrabImage($thumb_s,'','../file/upload/jj/');
	$htl['thumb_m']=GrabImage($thumb_m,'','../file/upload/jj/');
	$htl['thumb_b']=GrabImage($thumb_b,'','../file/upload/jj/');
	$htl['type']=dhoteltype($r['prop']['proptype']);
	$htl['catid']=',3,';	
	$htl['catids']=',3,';
	$htl['mode']='服务业';
	$htl['areaid']=$areaid;
	
	$htl['regyear']=arrtostr($r['prop']['dateopened']);
	$htl['mail']=$email;
	$htl['telephone']=arrtostr($r['prop']['phone']);
	$htl['fax']=arrtostr($r['prop']['fax']);
	$htl['address']= arrtostr($r['prop']['address1']);
	
	$htl['address2']= arrtostr($r['prop']['address2']);
	
	$htl['postcode']=arrtostr($r['prop']['zip']);
	$htl['holdtime']=arrtostr($r['prop']['holdtime']);
	// $htl['address2']=implode('|', $r['prop']['address2']);

	$htl['starrating']=arrtostr(dxingji($r['prop']['starrating']));//星级
	$htl['checkout']=arrtostr($r['prop']['checkout']);// 离店时间
	$htl['airportunits']=arrtostr($r['prop']['airportunits']);
	
	$htl['airports']=arrtostr($r['prop']['airports']);// 机场
	$htl['extraadult']=arrtostr($r['prop']['extraadult']);
	$htl['latitude']=arrtostr($r['prop']['latitude']); // 纬度
	$htl['longitude']=arrtostr($r['prop']['longitude']); // 经度 
	$htl['checkin']=arrtostr($r['prop']['checkin']); // 入住时间


	$htl['tradearea']=arrtostr($r['prop']['tradearea']); // 商区名称
	$htl['cityname']=arrtostr($r['prop']['cityname']); // 城市名称
	$htl['latecheckin']=arrtostr($r['prop']['latecheckin']); // 最晚入住时间
	$htl['totalrooms']=arrtostr($r['prop']['totalrooms']); // 客房总数 
	$htl['hotelstatus']=arrtostr($r['prop']['status']); // 状态 
	$htl['status']=3; // 状态
	$htl['totalfloors']=arrtostr($r['prop']['totalfloors']); // 楼层 
	$htl['groupname']=arrtostr($r['prop']['group']['name']); // 所属品牌  
	$htl['groupcode']=arrtostr($r['prop']['group']['code']); // 所属品牌id
	$htl['groupstatus']=arrtostr($r['prop']['group']['status']); // 所属品牌zhuangtai
	$htl['specialinvoice']=arrtostr($r['prop']['specialinvoices']); // 是否可开专票
	$htl['attractions']=arrtostr($r['prop']['attractions']) ; // 旅游景点
	$htl['dining']=arrtostr($r['prop']['dining']); // 餐饮设施
	$htl['facilities']=arrtostr($r['prop']['facilities']); // 设施
	$htl['frequentstay']=arrtostr($r['prop']['frequentstay']); // 常住政策
	$htl['policies']=arrtostr($r['prop']['policies']); // 预订政策
	$htl['location']=arrtostr($r['prop']['location']); // 酒店位置
	$htl['attractions']=$r['prop']['attractions']; // 旅游景点
	$htl['meetings']=arrtostr($r['prop']['meetings']); // 会议设施
	$htl['amenities']=arrtostr($r['prop']['amenities']); // 服务设施
	$htl['apigroup']='jinjiang'; 
	
	$htl['districtname']=arrtostr($r['prop']['districtname']);
	$htl['receptionforeigner']=$r['prop']['receptionforeigner']; // 是否接待外宾
	$htl['introduce']=$r['prop']['shortdescription']; // 酒店简介
	
	$content=arrtostr($r["prop"]["descriptions"]["property"]) ; // 详细介绍
	

	$company_sqlk = $company_sqlv = '';
	foreach($htl as $k=>$v) {
			$company_sqlk .= ','.$k; 
			$company_sqlv .= ",'$v'";
		}
	$company_sqlk = substr($company_sqlk, 1);
    $company_sqlv = substr($company_sqlv, 1);

   	$db->query("INSERT INTO `destoon_company` ($company_sqlk) VALUES ($company_sqlv)");
   	$db->query("INSERT INTO `destoon_company_data` (userid,content) VALUES ('".$userid."','".$content."')");

echo '导入 '.$company.' 完成';
}
$db->query("UPDATE `destoon_hotel` SET `is_input` = '1' WHERE `itemid` = ".$hotel['itemid']);

?>
  
<script type="text/javascript">window.location.href="inputhotel.php?a="+Math.random();</script>










