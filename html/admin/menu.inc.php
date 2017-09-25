<?php
defined('DT_ADMIN') or exit('Access Denied');
$menu = array(
	array('数据维护', '?file=database'),
	array('信息统计', '?file=count'),
	// array('模板风格', '?file=template'),
	// array('标签向导', '?file=tag'),
	array('后台搜索', '?file=search'),
	array('木马扫描', '?file=scan'),
	array('计划任务', '?file=cron'),
	array('后台日志', '?file=log'),
	array('上传记录', '?file=upload'),
	array('404日志', '?file=404'),
	// array('搜索记录', '?file=keyword'),
	// array('问题验证', '?file=question'),
	array('词语过滤', '?file=banword'),
	// array('重名检测', '?file=repeat'),
	array('禁止IP', '?file=banip'),
	// array('编辑助手', '?file=word'),
	// array('单页采编', '?file=fetch'),
	// array('系统体检', '?file=doctor'),
);
if(!$_founder) unset($menu[0],$menu[1],$menu[3]);
$menu_help = array(
	// array('使用协议', '?file=cloud&action=license'),
	// array('在线文档', '?file=cloud&action=doc'),
	// array('技术支持', '?file=cloud&action=support'),
	// array('官方论坛', '?file=cloud&action=bbs'),
	// array('信息反馈', '?file=cloud&action=feedback'),
	// array('检查更新', '?file=cloud&action=update'),
	// array('关于软件', '?file=cloud&action=about'),
);
$menu_system = array(
	array('网站设置', '?file=setting'),
	array('模块管理', '?file=module'),
	array('地区管理', '?file=area'),
	// array('城市分站', '?file=city'),
	array('管理员管理', '?file=admin'),
);
?>