<?php
defined('DT_ADMIN') or exit('Access Denied');
$menu = array(
	array("添加房型", "?moduleid=$moduleid&action=add"),
	array("房型列表", "?moduleid=$moduleid"),
	array("订单列表", "?moduleid=$moduleid&file=order"),
	array("审核房型", "?moduleid=$moduleid&action=check"),
	array("房型分类", "?file=category&mid=$moduleid"),
	array("更新数据", "?moduleid=$moduleid&file=html"),
	array("模块设置", "?moduleid=$moduleid&file=setting"),
);
?>