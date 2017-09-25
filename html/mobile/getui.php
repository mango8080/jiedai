<?php
require 'common.inc.php';
require_once DT_ROOT.'/include/getui.func.php';
$clientid=$_GET['clientid'];//获取到的clientid
define('TITLE','测试');
define('CONTENT','测试内容');
pushMessageToSingle($clientid);


