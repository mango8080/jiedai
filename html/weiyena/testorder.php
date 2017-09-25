<?php
require '../common.inc.php';
// 测试订单 接口 

$hotelid='66010';
// fangxing

$testorder=neworder($jjorderurl,$jjuser,$jjpass,$jjiata,$hotelid,1,$order = array());
var_dump($testorder);

exit;
