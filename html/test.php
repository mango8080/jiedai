<?php
require 'common.inc.php';

$hotelid="4500122";
$begindate="2017-03-02";
$enddate="2017-03-03";
$arrResult=array();
echo '连接开始:'.date("Y-m-d H:i:s").'<br/>';
ob_flush();

echo '连接成功，获取房态和房价开始:'.date("Y-m-d H:i:s").'<br/>';
ob_flush();
    $fangxingstatus=$objEtt->checkroom_statusprice($hotelid,$beginDate,$endDate);
echo '获取成功:'.date("Y-m-d H:i:s").'<br/>';
ob_flush();

exit();
// hotel info
$data= <<< XML
<crsmessage PropID="60001" user="$jjuser" pass="$jjpass" msgtype="getProperty"> 
</crsmessage>
XML;
$response = curlxml($jjorderurl,$data);
  $xml  =  simplexml_load_string ( $response );
  $r=object2array($xml);
 var_dump($r); 
exit;

$data= <<< XML
<crsmessage PropID="" user="$jjuser" pass="$jjpass" msgtype="getproplist">
  <PropLimits>
    <date></date>
    <pageno>1</pageno>
  </PropLimits>
</crsmessage>
XML;
$response = curlxml($jjorderurl,$data);
  $xml  =  simplexml_load_string ( $response );
  $r=object2array($xml);
 var_dump($r); 
exit;


$data= <<< XML
<crsmessage user="$jjuser" pass="$jjpass" msgtype="getauditresv" language="zh">
  <confnum>61098R05295</confnum>
  <iata>$jjiata</iata>
</crsmessage>
XML;

echo $data;exit;
/*
$response = curlxml($jjorderurl,$data);
  $xml  =  simplexml_load_string ( $response );
  $r=object2array($xml);

  echo $r['auditresv']['auditstatus'];
  
exit();
*/
$data= <<< XML
<crsmessage PropID="61012" user="$jjuser" pass="$jjpass" msgtype="getimage"> 
</crsmessage>
XML;
  $response = curlxml($jjurl,$data);
  $xml  =  simplexml_load_string ( $response );
  $r=object2array($xml);
  //var_dump($r);
  $hotel_thumb_arr = array();
  $hotel_thumb=$r["picture"];
  foreach ($r["coverimages"]['coverimage'] as $key => $value) {
        $hotel_thumb_arr[] =GrabImage(arrtostr($value),'','file/upload/jj/');
  }

  foreach ($r["gallerys"] as $key => $value) {
    $a=$value['@attributes']["width"];
    foreach ($value["gallery"] as $k => $v) {
      if ($v['roomtype']!='') {
        $thumb[$v['roomtype']][$a] =GrabImage(arrtostr($v['imageUrl']),'','file/upload/jj/');
        
      }
    
    }
  }
  foreach ($thumb as $key => $value) {
      $SQL="Update destoon_mall Set hotelid='{$hotelid}'";
      foreach ($value as $k => $v) {
        $sfilter="thumb";
        if ($k=="400") $sfilter="thumb1";
        if ($k=="640") $sfilter="thumb2";
        $SQL.=",{$sfilter}='{$v}'";
        # code...
      }
      $SQL.=" Where hotelid='{$hotelid}' and roomtype='".$key."'";
      echo $SQL;
    }

//var_dump($thumb);
exit();


$data= <<< XML
<crsmessage PropID="1080" user="$jjuser" pass="$jjpass" msgtype="getcratemap" nolog="1">
  <options cascade="true"/>
  <staydetail>
    <date>2017-01-07</date>
    <nights>1</nights>
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


$response = curlxml($jjurl,$data);
$xml  =  simplexml_load_string ( $response );

$r=object2array($xml);
 var_dump($r);
//var_dump($r["ratemap"]["ratedata"]);
$pricearr=array();
foreach ($r["ratemap"]["ratedata"] as $key => $value) {
  $pricearr[$value['plandetail']['Room']]=$value['ratedetail']['Single'];
  
   //exit();
}
foreach ($pricearr as $key => $value) {
  echo $value;
  }

 exit;
 
 //$fangxingstatus=jjcheckroom($jjorderurl,$jjuser,$jjpass,$jjiata,'60968','2017-01-04',3,'TWRC',0,1);
//$res=jjcancelorder($jjorderurl,$jjuser,$jjpass,61012,'61012R03753');
//exit();
//$fangxingstatus=jjreliefholdresv($jjorderurl,$jjuser,$jjpass,$jjiata,'61012','61012R03701','');
//var_dump($fangxingstatus);exit();
// fangxing
/*
$data= <<< XML
<crsmessage PropID="60721" user="$jjuser" pass="$jjpass" msgtype="getroomobj">
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
var_dump($r);
*/
$fangxingstatus=getonlineratemap($jjurl,$jjuser,$jjpass,$jjiata,'60015','2017-01-05',1,'BURA',2,1);

//$fangxingstatus=getprice($jjurl,$jjuser,$jjpass,$jjiata,'60853','2017-01-05',1,'','',1);

exit();
/*
$data= <<< XML
<?xml version="1.0" encoding="utf-8"?>
<srvmessage msgid="20161028161133419-0050568946E9-08849" PropID="60853" user="$user" pass="$pass" msgtype="newresv" result="success" language="zh" createtime="2016-12-31 16:11:33">
  <resvdata>
    <resvdetail>
      <confnum>60853R01659</confnum>
      <bookdate>2016-12-31 16:11:34</bookdate>
      <status>New</status>
      <arrival>2017-01-02</arrival>
      <departure>2016-10-30</departure>
      <planid>BURA-COR85</planid>
      <firstname>建伟</firstname>
      <lastname>张</lastname>
      <bookedrates>
        <totalrevenue>723.0</totalrevenue>
        <currency>CNY</currency>
        <bookedrate>
          <date>2016-10-29</date>
          <rate>723.0</rate>
        </bookedrate>
      </bookedrates>
      <guarruledetail>
        <rule>RH</rule>
        <description>预订保留至入住日18:00。</description>
      </guarruledetail>
      <cxlruledetail>
        <rule>NP</rule>
        <description>请在入住日期的18:00前取消,超时需支付1晚房费</description>
        <allowcancel>0</allowcancel>
        <lastcanceltime>2016-10-29 18:00:00</lastcanceltime>
      </cxlruledetail>
      <resvclass>RT</resvclass>
      <singleroomnum>60853R01659</singleroomnum>
    </resvdetail>
  </resvdata>
</srvmessage>
XML;
*/

$data= <<< XML
<?xml version="1.0" encoding="utf-8"?>
<crsmessage createtime="2017-01-03 09:11:33" PropID="60968" user="ids_207_959177_xuzhouga" pass="xzga959177" msgtype="newresv" language="zh">
  <reservation>
    <outconfnum>20170103121053106325</outconfnum>
    <!--外部订单号-->
    <holdresv>1</holdresv>
    <!--holdresv=1表示订单需要支付，暂时锁定房量，如在30分钟内未完成解锁房量，CRS将自动取消该预订-->
    <isassure>4</isassure>
    <!--isassure=4,6 -->
    <bookedrates>
      <totalrevenue>288.0</totalrevenue>
      <currency>CNY</currency>
      <bookedrate>
        <date>2017-01-08</date>
        <rate>144</rate>
      </bookedrate>
      <bookedrate>
        <date>2017-01-09</date>
        <rate>144</rate>
      </bookedrate>
    </bookedrates>
    <staydetail>
      <date>2017-01-08</date>
      <nights>2</nights>
      <roomtype>TWRC</roomtype>
      <rateclass>COR85</rateclass>
      <rooms>1</rooms>
      <promotioncode/>
      <!--促销代码，暂不使用-->
      <promotiondesc/>
      <adults>1</adults>
      <children/>
      <channel>Website</channel>
    </staydetail>
    <guestinfo>
      <firstname></firstname>
      <lastname>建伟</lastname>
      <!--如无法拆分姓和名，请将客人统一传入lastname节点-->
      <phone>13915808892</phone>
      <mobile>13915808892</mobile>
      <email>123456@qq.com</email>
      <street1></street1>
      <holdTime>2017-01-05 23:00:00</holdTime>
      <!--客房保留时间，也是客人最晚到店时间-->
      <otherguest/>
    </guestinfo>
    <contactinfo>
      <name>建伟</name>
      <phone>13915808892</phone>
      <mobile>13915808892</mobile>
      <email>123456@qq.com</email>
      <fax/>
    </contactinfo>
    <paymentinfo>
      <payment>CASH</payment>
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
      <IATA>959177</IATA>
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
var_dump($data);




// hotel list
/*
$data= <<< XML
<crsmessage PropID="" user="ids_207_959177_xuzhouga" pass="959177xuzhou" msgtype="getproplist">
	<PropLimits>
		<date></date>
		<pageno>1</pageno>
	</PropLimits>
</crsmessage>
XML;
*/
// hotel info
// $data= <<< XML
// <crsmessage PropID="60001" user="ids_207_959177_xuzhouga" pass="959177xuzhou" msgtype="getProperty"> 
// </crsmessage>
// XML;
//$url='http://taxmltest.hubs1.net/servlet/SwitchReceiveServlet';
$url='https://taxml.hubs1.net/servlet/SwitchReceiveServlet';
$response = curlxml($url,$data,'hubs1.crt');

$xml  =  simplexml_load_string ( $response );

$r=object2array($xml);
 //var_dump($r);


/*
foreach ($r['props']['prop'] as $key => $value) {
	$db->query("INSERT INTO {$DT_PRE}hotel (hotelid,hotelname,status,brandname,brandcode) VALUES ('".$value['id']."','".$value['name']."','".$value['status']."','".$value['brandname']."','".$value['brandcode']."')");
	echo ($value['id']).'<br>';
}
echo "导入酒店列表完成";
*/