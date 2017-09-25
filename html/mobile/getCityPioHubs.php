<?php
require 'common.inc.php';
$arr_n = array("二","三","四","五","六","七","八","九","十");
$lists=array();
$sql="SELECT distinct groupname as name,'' as location,1 as stype FROM destoon_company where groupname<>'' and hotelstatus='active'";
$result = $db->query($sql);
while($r = $db->fetch_array($result)) {
	$lists[] = $r;
}
$db->free_result($result);

$arrtmp=array();
$arrtmp[0]["results"]=$lists;
$arrtmp[0]["cityName"]=$cityName;
$arrtmp[0]["title"]="品牌";

$lists=array();
for ($x=0; $x<4; $x++) {
	$lists[$x]["name"]=$x==0? $arr_n[$x]."星级及以下":$arr_n[$x]."星级";
	$lists[$x]["location"]="";
	$lists[$x]["stype"]="2";
}

$arrtmp[1]["results"]=$lists;
$arrtmp[1]["cityName"]=$cityName;
$arrtmp[1]["title"]="星级";

$lists=array();
$r = $db->get_one("SELECT areaid FROM destoon_area WHERE areaname like '{$cityName}%'");
$sql="SELECT areaname as name,'' as location,3 as stype FROM destoon_area WHERE parentid=".$r['areaid'];
$result = $db->query($sql);
while($r = $db->fetch_array($result)) {
	$lists[] = $r;
}
$db->free_result($result);
$arrtmp[2]["results"]=$lists;
$arrtmp[2]["cityName"]=$cityName;
$arrtmp[2]["title"]="行政区";

echo json_encode(array('result'=>$arrtmp,'stat'=>1));

?>