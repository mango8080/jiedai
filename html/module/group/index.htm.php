<?php 
defined('IN_DESTOON') or exit('Access Denied');
$fileroot = DT_ROOT.'/'.$MOD['moduledir'].'/';
$filename = $fileroot.$DT['index'].'.'.$DT['file_ext'];
if(!$MOD['index_html']) {
	if(is_file($filename)) unlink($filename);
	return false;
}
if($DT['rewrite']) {
	defined('DT_REWRITE') or define('DT_REWRITE', true);
	$_SERVER["SCRIPT_NAME"] = 'index.php';
	$_SERVER['QUERY_STRING'] = '';
}
$GLOBALS['DT_URL'] = $DT_URL = 'index.php';
$maincat = get_maincat(0, $moduleid);
if($page == 1) $head_canonical = $MOD['linkurl'];
$seo_file = 'index';
include DT_ROOT.'/include/seo.inc.php';
$destoon_task = "moduleid=$moduleid&html=index";
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].mobileurl($moduleid, 0, 0, $page);
ob_start();
include template('index', $module);
$data = ob_get_contents();
ob_clean();
file_put($filename, $data);
return true;
?>