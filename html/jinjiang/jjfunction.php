<?php 
/*
	锦江之星接口调用函数
	copay right by aaron QQ：59693566
*/
// 获取订单状态
function jjorderstatus($jjorderurl,$jjuser,$jjpass,$jjiata,$confnum){
$data= <<< XML
<crsmessage user="$jjuser" pass="$jjpass" msgtype="getauditresv" language="zh">
  <confnum>$confnum</confnum>
  <iata>$jjiata</iata>
</crsmessage>
XML;
	$response = curlxml($jjorderurl,$data);
	$xml  =  simplexml_load_string ( $response );
	$r=object2array($xml);
	if ($r["@attributes"]["result"]=='success'){
		return $r['auditresv']['auditstatus'];
	}else{
		return $r["@attributes"]['result'];
	}
}
// 锦江之星撤销订单
function jjcancelorder($jjorderurl,$jjuser,$jjpass,$hotelid,$confnum){
	$data= <<< XML
<crsmessage PropID="$hotelid" user="$jjuser" pass="$jjpass" msgtype="cancelresv" nolog="1">
	<reservation>
		<confnum>$confnum</confnum>
		<paymentinfo>
			<paymentstatus>5</paymentstatus>
			<!--支付状态 5=已退款-->
			<refundamount></refundamount>
			<tradeno></tradeno>
		</paymentinfo>
	</reservation>
</crsmessage>
XML;
	$response = curlxml($jjorderurl,$data,'hubs1.crt');
	$xml  =  simplexml_load_string ( $response );
	$r=object2array($xml);
	if ($r["@attributes"]["result"]=='success'){
		return true;
	}else{
		return false;
	}
}
/* jjcheckroom  锦江之星检查房型状态
	$jjorderurl 请求订单url
	$hotelid 酒店id
	$jjuser,$jjpass,$jjiata  接口账号
	$today 开始日期
	$days 入住天数
	$roomtype 房型代码
	$mallid 房型的自增id
*/
function jjcheckroom($jjorderurl,$jjuser,$jjpass,$jjiata,$hotelid,$today,$days,$roomtype,$mallid=0,$rooms=1,$arrtype=0,$rateclass='COR85',$adults=1,$filter=0){
	$data= <<< XML
<crsmessage PropID="$hotelid" user="$jjuser" pass="$jjpass" msgtype="getonlineratemap" nolog="1">
	<options cascade="true"/>
	<staydetail>
		<date>$today</date>
		<nights>$days</nights>
		<roomtype>$roomtype</roomtype>
		<rateclass>$rateclass</rateclass>
		<rooms>$rooms</rooms>
		<adults>$adults</adults>
		<children/>
		<filter>$filter</filter>
		<channel>Website</channel>
	</staydetail>
<iata>$iata</iata>
</crsmessage>

XML;
	$response = curlxml($jjorderurl,$data,'hubs1.crt');
	
	$xml  =  simplexml_load_string ( $response );
	$r=object2array($xml);
	//var_dump($r);exit();
	
	if ($r["@attributes"]["result"]=='success'){
		if ($r["ratemap"]["ratedata"]["resv"]["ResvStatus"]=='A') {//可以预订
			return true;
		}else{
			
			

		}
	}else{
		return false;
	}
}
/*
锦江新增订单
$url 请求url
	$hotelid 酒店id
	$jjuser,$jjpass,$jjiata  接口账号
	$paytype  预付还是到付
*/ 

function neworder($jjorderurl,$user,$pass,$iata,$hotelid,$paytype,$order = array(),$arrDatePrice=array()){
	extract($order);
	$strdateprice="";
	foreach($arrDatePrice as $key=>$val){
		$strdateprice.="<bookedrate>";
		$strdateprice.="	<date>".$val['date']."</date>";
		$strdateprice.="	<rate>".$val['price']."</rate>";
		$strdateprice.="</bookedrate>";
	}
	if ($paytype==1) {
		// 到店付
		$holdresv='';
		$isassure=0;
		$payment='CASH';
	}else{
		// 预付（在线付）
		$holdresv=1;
		$isassure=4;
		$payment='P100';
	}
	$data= <<< XML
<crsmessage createtime="" PropID="$hotelid" user="$user" pass="$pass" msgtype="newresv" language="zh">
	<reservation>
		<outconfnum>$order_code</outconfnum>
		<!--外部订单号-->
		<holdresv>$holdresv</holdresv>
		<!--holdresv=1表示订单需要支付，暂时锁定房量，如在30分钟内未完成解锁房量，CRS将自动取消该预订-->
		<isassure>$isassure</isassure>
		<!--isassure=4,6 -->
		<bookedrates>
			<totalrevenue>$order_price</totalrevenue>
      		<currency>CNY</currency>
			$strdateprice
		</bookedrates>
		<staydetail>
			<date>$order_inday</date>
			<nights>$order_days</nights>
			<roomtype>$order_roomtype</roomtype>
			<rateclass>$order_rateclass</rateclass>
			<rooms>$order_rooms</rooms>
			<promotioncode/>
			<!--促销代码，暂不使用-->
			<promotiondesc/>
			<adults>1</adults>
			<children/>
			<channel>Website</channel>
		</staydetail>
		<guestinfo>
			<firstname></firstname>
			<lastname>$order_truename</lastname>
			<!--如无法拆分姓和名，请将客人统一传入lastname节点-->
			<phone>$order_mobile</phone>
			<mobile>$order_mobile</mobile>
			<email>$order_email</email>
			<street1></street1>
			<holdTime>$order_arrivetime</holdTime>
			<!--客房保留时间，也是客人最晚到店时间-->
			<otherguest/>
		</guestinfo>
		<contactinfo>
			<name>$order_truename</name>
			<phone>$order_mobile</phone>
			<mobile>$order_mobile</mobile>
			<email>$order_email</email>
			<fax/>
		</contactinfo>
		<paymentinfo>
			<payment>$payment</payment>
			<paymentstatus>0</paymentstatus>
			<!--paymentstatus=0 待支付-->
			<paymentamount></paymentamount>
			<!--支付金额-->
			<paymentsource/>
			<!--支付渠道-->
			<tradeno/>
			<!--交易编号-->
			<paidurl/>
			<!--第三方支付提交的url-->
			<returnurl/>
			<!--第三方支付返回的url-->
			<payresult/>
			<!--第三方返回的支付结果-->
		</paymentinfo>
		<remarks>
			<remark></remark>
		</remarks>
		<miscinfo>
			<maincontractedid/>
			<!--企业客户父帐户ID，使用于直销渠道-->
			<contractedid/>
			<!--企业客户ID，使用于直销渠道-->
			<companyno/>
			<!--协议公司编号-->
			<IATA>$iata</IATA>
		</miscinfo>
		<tracelogid/>
		<!--对外跟踪编号-->
		<couponinfo>
			<coupon>
				<coupontype/>
				<!--优惠券类型-->
				<couponnum/>
				<!--优惠券编号-->
				<couponamount/>
				<!--优惠券面额-->
			</coupon>
			<couponcount/>
			<!--优惠券总数-->
			<coupontotalamount/>
			<!--优惠券总金额-->
		</couponinfo>
		<memberinfo>
			<guestid></guestid>
			<!--用户ID，使用于直销渠道-->
			<memberno></memberno>
			<!--用户卡号，使用于直销渠道-->
			<memberclass>SIL</memberclass>
			<!--用户等级，使用于直销渠道-->
		</memberinfo>
		<ccinfo>
			<ccexp/>
			<ccname/>
			<ccnum/>
			<cctype/>
			<cvv/>
		</ccinfo>
	</reservation>
</crsmessage>
XML;
    //var_dump($data);
	$response = curlxml($jjorderurl,$data,'hubs1.crt');
	
	$xml  =  simplexml_load_string ($response);
	//var_dump($xml);
	$r=object2array($xml);
	
	if ($r["@attributes"]["result"]=='success') {
		return $r["resvdata"]["resvdetail"]["confnum"];
	}else{
		return '';
	}
}

function getprice($url,$user,$pass,$jjiata,$hotelid,$today,$nights=1,$roomtype='',$rateclass='',$rooms=1,$adults=1,$filter=1){
	
	$data= <<< XML
<crsmessage PropID="$hotelid" user="$user" pass="$pass" msgtype="getcratemap" nolog="1">
	<options cascade="true"/>
	<staydetail>
		<date>$today</date>
		<nights>$nights</nights>
		<roomtype>$roomtype</roomtype>
		<rateclass>COR85</rateclass>
		<rooms>$rooms</rooms>
		<adults>$adults</adults>
		<children/>
		<filter>$filter</filter>
		<channel>Website</channel>
	</staydetail>
	<iata></iata>
</crsmessage>
XML;
	// $url='http://taxmltest.hubs1.net/servlet/SwitchReceiveServlet';

	$response = curlxml($url,$data);
	$xml  =  simplexml_load_string ( $response );
	$r=object2array($xml);
	//var_dump($r);
	$pricearr=array();
	if ($r["@attributes"]["result"]=='success') {
		$pricearr['price'] =floatval($r["ratemap"]["ratedata"]["ratedetail"]["Single"]);
		$pricearr['double'] =floatval($r["ratemap"]["ratedata"]["ratedetail"]["Double"]);
		$pricearr['triple'] =floatval($r["ratemap"]["ratedata"]["ratedetail"]["Triple"]);
		$pricearr['quad'] =floatval($r["ratemap"]["ratedata"]["ratedetail"]["Quad"]);
		$pricearr['breakfastdesc'] =$r["ratemap"]["ratedata"]["ratedetail"]["BreakfastDesc"];// 早餐信息
		$pricearr['netdesc'] =$r["ratemap"]["ratedata"]["ratedetail"]["Netdesc"];// 宽带信息
		$pricearr['amount'] =$r["ratemap"]["ratedata"]["ratedetail"]["Allotment"];// 房量
		$pricearr['resvstatus'] =$r["ratemap"]["ratedata"]["resv"]["ResvStatus"];// 预订条件时房态
	}
	return $pricearr;

}
// 锦江之星实时房价接口
function getonlineratemap($url,$user,$pass,$iata,$hotelid,$today,$nights=1,$roomtype='',$rooms=1,$arrtype=0,$rateclass='COR85',$adults=1,$filter=0){
	
	$data= <<< XML
<crsmessage PropID="$hotelid" user="$user" pass="$pass" msgtype="getonlineratemap" nolog="1">
	<options cascade="true"/>
	<staydetail>
		<date>$today</date>
		<nights>$nights</nights>
		<roomtype>$roomtype</roomtype>
		<rateclass>$rateclass</rateclass>
		<rooms>$rooms</rooms>
		<adults>$adults</adults>
		<children/>
		<filter>$filter</filter>
		<channel>Website</channel>
	</staydetail>
<iata>$iata</iata>
</crsmessage>

XML;
	
	$response = curlxml($url,$data);
	//var_dump($response);exit();
	$xml  =  simplexml_load_string ( $response );
	$r=object2array($xml);
	$arrResult=array();
	$hotelprice = array();

	if ($r["@attributes"]["result"]=='success') {
		if ($nights==1){
			if ($r["ratemap"]["ratedata"]["resv"]["ResvStatus"]=='A') {//可以预订
				$arrResult['RoomStatus']='A';
			}else{
				$arrResult['RoomStatus']='N';
			}
			if ($arrtype==0){
				$hotelprice[0]=floatval($r["ratemap"]["ratedata"]["ratedetail"]["Single"]);
			}else{
				$hotelprice[0]['date']=$r["ratemap"]["ratedata"]["ratedetail"]["date"];
				$hotelprice[0]['price']=floatval($r["ratemap"]["ratedata"]["ratedetail"]["Single"]);
			}
		}else{

			$tmpStatus="A";
			foreach ($r["ratemap"]["ratedata"]["ratedetail"] as $key => $value) {
				if ($arrtype==0){
					$hotelprice[$key]= $value['Single'];
				}else{
					$hotelprice[$key]['date']=$value['date'];
					$hotelprice[$key]['price']= $value['Single'];
				}
				if (intval($value['pr'])==0){
					if ($value['AvStat']=='A' || $value['AvStat']=='L'){

					}else{
						$tmpStatus="N";
					}
				}else{
					$tmpStatus="N";
				}
			}
			//var_dump($r);exit;
			if ($r["ratemap"]["ratedata"]["resv"]["ResvStatus"]=='A') {//可以预订
				$arrResult['RoomStatus']='A';
			}else{
				$arrResult['RoomStatus']=$tmpStatus;
			}
		}
		$arrResult['RoomPrice']=$hotelprice;
	}
	
	return $arrResult;

}

// 锦江之星取得房型图片
function getimg($url,$user,$pass,$hotelid,$caption){
	$data= <<< XML
<crsmessage PropID="$hotelid" user="$user" pass="$pass" msgtype="getimage"> 
</crsmessage>
XML;
	$response = curlxml($url,$data);
	$xml  =  simplexml_load_string ( $response );
	$r=object2array($xml);
	$thumb = array();
	foreach ($r["gallerys"] as $key => $value) {
		foreach ($value["gallery"] as $k => $v) {
			if ($v['caption']==$caption) {
				$thumb[] =$v['imageUrl'];
				
			}
		
		}
	}
	return $thumb;
}
//  锦江之星酒店类型转换
function dhoteltype($typeid){
	$arrtype = array(
		'APA' => '酒店式公寓',
		'BOU' => '精品酒店' ,
		'CON' => '托管公寓' ,
		'CTR' => '会议中心' ,
		'GAR' => '花园酒店' ,
		'HCC' => '酒店及会议中心',
		'HOT' => '酒店' ,
		'INN' => '经济型旅馆' ,
		'LUX' => '豪华酒店' ,
		'MOT' => '汽车旅馆' ,
		'RES' => '度假村' ,
		'RSD' => '公寓' ,
		'STE' => '全套房酒店',

		);
	return $arrtype[$typeid]?$arrtype[$typeid]:'酒店';
}
// 锦江支付完之后 确认订单
function jjreliefholdresv($jjorderurl,$jjuser,$jjpass,$jjiata,$hotelid,$confnum,$outcnfnum){
	$data= <<< XML
	<crsmessage PropID="$hotelid" user="$jjuser" pass="$jjpass" msgtype="reliefholdresv" nolog="1">
	　<reservation>
			<confnum>$confnum</confnum>
			<outcnfnum>$outcnfnum</outcnfnum>
			<iata>$jjiata</iata>
			<isfrompp>1</isfrompp>
		</reservation>
	</crsmessage>
XML;

	$response = curlxml($jjorderurl,$data,'hubs1.crt');
	
	$xml  =  simplexml_load_string ( $response );
	$r=object2array($xml);
	
	if ($r["@attributes"]["result"]=='success'){
		return true;
	}else{
		return false;
	}
}
//取某个酒店的所有房型价格
function getallroomprice($url,$user,$pass,$jjiata,$hotelid,$today,$nights=1){
$data= <<< XML
<crsmessage PropID="$hotelid" user="$user" pass="$pass" msgtype="getcratemap" nolog="1">
	<options cascade="true"/>
	<staydetail>
		<date>$today</date>
		<nights>$nights</nights>
		<roomtype></roomtype>
		<rateclass>COR85</rateclass>
		<rooms>1</rooms>
		<adults>1</adults>
		<children/>
		<filter>1</filter>
		<channel>Website</channel>
	</staydetail>
	<iata></iata>
</crsmessage>
XML;

	$response = curlxml($url,$data);
	$xml  =  simplexml_load_string ( $response );
	$r=object2array($xml);
	
	$pricearr=array();
	if ($r["@attributes"]["result"]=='success') {
		foreach ($r["ratemap"]["ratedata"] as $key => $value) {
			$pricearr[$value['plandetail']['Room']]=$value['ratedetail']['Single'];
		}
	}
	return $pricearr;
}
?>
