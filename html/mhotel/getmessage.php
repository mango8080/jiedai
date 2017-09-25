<?php 
require 'config.inc.php';
require '../common.inc.php';
// token验证
if ($token != md5(md5('HaNShanLing'))) {
	exit('Access Denied');
}
if ($username) {
	$ms = $db->count('destoon_mall_order', "seller='$username' and access=0");
	echo $ms;
}else{
	echo 0;
}
?>