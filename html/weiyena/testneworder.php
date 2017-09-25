<?php
require '../common.inc.php';

$hotelid='60302';
$order = array(
						'order_code' => '888889999999',
						'order_inday' => '2016-12-31',
						'order_days' => 1,
						'order_price' => 280.0,
						'order_roomtype' => 'BURB',
						'order_rateclass' => 'COR85',
						'order_truename' => '令狐冲',
						'order_mobile' => '13388888888',
						'order_email' => 'ww@qq.com',
						'order_note' => '有窗户',
						'order_rooms' => 1,
						'order_arrivetime' => '17:00',

					 );
$orderss=neworder($jjorderurl,$jjuser,$jjpass,$jjiata,$hotelid,1,$order);
var_dump($orderss);exit;