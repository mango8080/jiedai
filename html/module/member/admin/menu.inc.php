<?php
defined('DT_ADMIN') or exit('Access Denied');
$menu = array(
	array('添加用户', '?moduleid=2&action=add'),
	array('用户列表', '?moduleid=2'),
	array('审核用户', '?moduleid=2&action=check'),
	array(VIP.'管理', '?moduleid=4&file=vip'),
	array('资料审核', '?moduleid=2&file=validate'),
	// array('联系用户', '?moduleid=2&file=contact'),
	// array('在线用户', '?moduleid=2&file=online'),
	// array('在线对话', '?moduleid=2&file=chat'),
	// array('一键登录', '?moduleid=2&file=oauth'),
	// array('微信管理', '?moduleid=2&file=weixin'),
	// array('用户升级', '?moduleid=2&file=grade&action=check'),
	array('用户组管理', '?moduleid=2&file=group'),
	array('模块设置', '?moduleid=2&file=setting'),
);
$menu_finance = array(
	array($DT['money_name'].'管理', '?moduleid=2&file=record'),
	array($DT['credit_name'].'管理', '?moduleid=2&file=credit'),
	array('短信管理', '?moduleid=2&file=sms&action=record'),
	array('充值记录', '?moduleid=2&file=charge'),
	array('提现记录', '?moduleid=2&file=cash'),
	array('帐单管理', '?moduleid=2&file=zhangdan'),
	// array('信息支付', '?moduleid=2&file=pay'),
	// array('保证金管理', '?moduleid=2&file=deposit'),
	// array('充值卡管理', '?moduleid=2&file=card'),
	// array('优惠码管理', '?moduleid=2&file=promo'),
);
$menu_relate = array(
	array('站内信件', '?moduleid=2&file=message'),
	array('电子邮件', '?moduleid=2&file=sendmail'),
	array('手机短信', '?moduleid=2&file=sendsms'),
	// array('客服中心', '?moduleid=2&file=ask'),
	// array('贸易提醒', '?moduleid=2&file=alert'),
	// array('邮件订阅', '?moduleid=2&file=mail'),
	// array('商机收藏', '?moduleid=2&file=favorite'),
	// array('用户商友', '?moduleid=2&file=friend'),
	// array('收货地址', '?moduleid=2&file=address'),
	array('登录日志', '?moduleid=2&file=loginlog'),
);
if(!$_founder) unset($menu_relate[7]);
?>