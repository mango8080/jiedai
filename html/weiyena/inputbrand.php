<?php 
// 检索所有品牌
require '../common.inc.php';
$result=$db->query("SELECT groupname,groupcode FROM `destoon_company` group by groupcode");

while($r = $db->fetch_array($result)){
	if(empty($r['groupcode'])) continue;
	$db->query("INSERT INTO `destoon_brand` (`groupname`, `groupcode`) VALUES ('".$r['groupname']."','".$r['groupcode']."')");
	
	$b=$db->get_one("SELECT * FROM `destoon_brand` where groupcode='".$r['groupcode']."' and groupname='".$r['groupname']."'");
	if ($b) {
		continue;
	}
}

echo "over";
 ?>