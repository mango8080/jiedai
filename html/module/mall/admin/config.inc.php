<?php
defined('DT_ADMIN') or exit('Access Denied');
$MCFG['module'] = 'mall';
$MCFG['name'] = '借款类型';
$MCFG['author'] = 'idc580.cn';
$MCFG['homepage'] = 'www.idc580.cn';
$MCFG['copy'] = false;
$MCFG['uninstall'] = true;
$MCFG['moduleid'] = 16;

$RT = array();
$RT['file']['index'] = '房型管理';
$RT['file']['order'] = '订单管理';
$RT['file']['html'] = '更新网页';

$RT['action']['index']['add'] = '添加房型';
$RT['action']['index']['edit'] = '修改房型';
$RT['action']['index']['relate'] = '关联房型';
$RT['action']['index']['delete'] = '删除房型';
$RT['action']['index']['check'] = '审核房型';
$RT['action']['index']['expire'] = '下架房型';
$RT['action']['index']['onsale'] = '上架房型';
$RT['action']['index']['reject'] = '未通过';
$RT['action']['index']['recycle'] = '回收站';
$RT['action']['index']['move'] = '移动房型';
$RT['action']['index']['level'] = '信息级别';

$CT = 1;
?>