<?php
require 'common.inc.php';
$lists=array();
$sql="SELECT areaid as cityId,areaname as cityName,jingdu as longitude,weidu as latitude FROM destoon_area WHERE areaname like '%{$key}%' and parentid<>0 and child<>0";
$result = $db->query($sql);
while($r = $db->fetch_array($result)) {
	$lists[] = $r;
}
$db->free_result($result);
if (empty($lists)){
	echo json_encode(array('stat'=>0));
}else{
	echo json_encode(array('result'=>$lists,'stat'=>1));
}
?>