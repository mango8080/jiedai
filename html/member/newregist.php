<?php
/*

	[Hotel System] Copyright (c) 2008-2015 QQ:59693566
*/
require '../common.inc.php';
$sql = "Select count(*) as nNum From {$DT_PRE}member Where groupid=4";
$message = $db->get_one($sql);
if (empty($message)){
	echo json_encode(array('stat'=>0));
}else{
	echo json_encode(array('stat'=>$message['nNum']));
}
?>