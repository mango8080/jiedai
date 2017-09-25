<?php
/*
	取得锦江之星所有酒店列表
*/ 
require '../common.inc.php';
$startDate=date("Y-m-d H:i:s");
//echo "更新开始-".date("Y-m-d H:i:s");
//echo str_repeat(" ", 256);
set_time_limit(0);
$hasnext="true";
$count=0;
$c=1;
$page=1;
$kk=0;
while ($hasnext=="true"){
$data= <<< XML
<crsmessage PropID="" user="$jjuser" pass="$jjpass" msgtype="getproplist">
	<PropLimits>
		<date></date>
		<pageno>$page</pageno>
	</PropLimits>
</crsmessage>
XML;
	$response = curlxml($jjurl,$data);
	$xml  =  simplexml_load_string ( $response );
	$r0=object2array($xml);
	if ($r0["@attributes"]["result"]=='success') {
		$hasnext=$r0["hasnext"];
		$page++;
		foreach ($r0['props']['prop'] as $key => $value) {
			$hotelid=$value['id'];
			$h=$db->get_one("SELECT itemid FROM destoon_company WHERE hotelid='{$hotelid}' and apigroup='jinjiang'");

			// 酒店基础信息
$data1= <<< XML
<crsmessage PropID="$hotelid" user="$jjuser" pass="$jjpass" msgtype="getProperty"> 
</crsmessage>
XML;
			$response1 = curlxml($jjurl,$data1);
			$xml1  =  simplexml_load_string ( $response1 );
			$r=object2array($xml1);
			if ($r["@attributes"]["result"]=='success') {
				$htl=array();
				// 酒店名称
				$company=$truename=$r['prop']['name'];
				$email=implode('|',$r['prop']['hotelemail']);
				$areaid=areatoareaid_new($r['prop']['cityname'],$r['prop']['districtname']);

				if (empty($h)){
					$username=$passport=strtolower($r["prop"]["group"]["code"].$r["@attributes"]["PropID"]);
					$password=md5(md5(substr($username, -6)));
					$gender= 1 ;
					$groupid=$regid=6;
					$mobile='';					
					// 插入用户数据
					$db->query("REPLACE INTO `destoon_member` ( `username`, `passport`, `company`, `password`,  `email`, `gender`, `truename`,  `groupid`, `regid`, `areaid`) VALUES ('".$username."', '".$username."', '".$company."', '".$password."', '".$email."', '".$gender."', '".$truename."', '6', '6', '".$areaid."')");
					$userid = $db->insert_id();
					$htl['userid']=$userid;
					$htl['username']=$username;
					$htl['groupid']=6;
					$htl['hotelid']=$hotelid;
					$htl['catid']=',3,';	
					$htl['catids']=',3,';
					$htl['mode']='服务业';
					$htl['status']=3; // 状态
					$htl['apigroup']='jinjiang';
					$htl['add_time']=date("Y-m-d H:i:s");
// 酒店图片
$dataimg= <<< XML
<crsmessage PropID="$hotelid" user="$jjuser" pass="$jjpass" msgtype="getimage"> 
</crsmessage>
XML;
					$response2 = curlxml($jjurl,$dataimg);
					$xml2  =  simplexml_load_string ( $response2 );
					$r2=object2array($xml2);
					if ($r2["@attributes"]["result"]=='success'){
						$thumb=trim($r2['picture']);
						$thumb_s=trim($r2['coverimages']['coverimage'][0]);
						$thumb_m=trim($r2['coverimages']['coverimage'][1]);
						$thumb_b=trim($r2['coverimages']['coverimage'][2]);
					}
					// 采集图片
					$thumb=getfilename($thumb);

					$htl['thumb']=GrabImage($thumb,'','../file/upload/jj/');
					$htl['thumb_s']=GrabImage($thumb_s,'','../file/upload/jj/');
					$htl['thumb_m']=GrabImage($thumb_m,'','../file/upload/jj/');
					$htl['thumb_b']=GrabImage($thumb_b,'','../file/upload/jj/');
				}
				$htl['company']=$company;
				$htl['type']=dhoteltype($r['prop']['proptype']);
				$htl['areaid']=$areaid;
				$htl['regyear']=arrtostr($r['prop']['dateopened']);
				$htl['mail']=$email;
				$htl['telephone']=arrtostr($r['prop']['phone']);
				$htl['fax']=arrtostr($r['prop']['fax']);
				$htl['address']= arrtostr($r['prop']['address1']);
				$htl['address2']= arrtostr($r['prop']['address2']);
				$htl['postcode']=arrtostr($r['prop']['zip']);
				$htl['holdtime']=arrtostr($r['prop']['holdtime']);
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
				$htl['districtname']=arrtostr($r['prop']['districtname']);
				$htl['receptionforeigner']=$r['prop']['receptionforeigner']; // 是否接待外宾
				$htl['introduce']=$r['prop']['shortdescription']; // 酒店简介
				$content=arrtostr($r["prop"]["descriptions"]["property"]) ; // 详细介绍
				$htl['edit_time']=date("Y-m-d H:i:s");

				$company_sqlk = $company_sqlv = $fielter= '';
				foreach($htl as $k=>$v) {
					$company_sqlk .= ','.$k; 
					$company_sqlv .= ",'$v'";
					$fielter .=",$k='$v'";
				}
				$company_sqlk = substr($company_sqlk, 1);
			    $company_sqlv = substr($company_sqlv, 1);
			    $fielter = substr($fielter, 1);
			    if (empty($h)){
			   		$db->query("INSERT INTO `destoon_company` ($company_sqlk) VALUES ($company_sqlv)");
			   		$db->query("INSERT INTO `destoon_company_data` (userid,content) VALUES ('".$userid."','".$content."')");
			   }else{
			   		$db->query("Update destoon_company Set {$fielter} WHERE hotelid='{$hotelid}' and apigroup='jinjiang'");
			   }

			}else{
				$errcode=$r["error"]["errorcode"];
				//if ($r["error"]["errorcode"]=='TA407'){
					$db->query("Update destoon_company Set hotelstatus='{$errcode}',edit_time='".date("Y-m-d H:i:s")."' WHERE hotelid='{$hotelid}' and apigroup='jinjiang'");
				//}
			}
			$count++;
		}
	}else{
		$c++;
		if ($c>3) $hasnext="false";
	}
	
	//echo date("Y-m-d H:i:s");
	//ob_flush();
	//flush();
}
$endDate=date("Y-m-d H:i:s");
$strSQL="Insert Into destoon_trans_log(apigroup,trans_type,trans_num,startdate,enddate) Values('jinjiang','hotel','{$count}','{$startDate}','{$endDate}')";
$db->query($strSQL);
//echo "更新酒店基础信息完成-".date("Y-m-d H:i:s");;
//exit();
?>