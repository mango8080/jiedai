<?php 
defined('IN_DESTOON') or exit('Access Denied');
$itemid or dheader($MOD['linkurl']);
login();
if(!check_group($_groupid, $MOD['group_show'])) include load('403.inc');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
if($item['groupid'] == 2) include load('404.inc');
if($item && $item['status'] > 2) {
	if($MOD['show_html'] && is_file(DT_ROOT.'/'.$MOD['moduledir'].'/'.$item['linkurl'])) d301($MOD['linkurl'].$item['linkurl']);
	extract($item);
} else {
	include load('404.inc');
}
if (date('Y-m-d')>$intime) {
		message('入住日期有误');
	}
	if ($intime >= $outtime) {
		message('离开日期要大于入住日期');
	}
// 检查房型是否可以预定
$days=diffBetweenTwoDays($intime,$outtime);
// $fangxingstatus=jjcheckroom($hotelid,$intime,$days,$roomtype,$itemid);
$fangxingstatus=jjcheckroom($jjorderurl,$jjuser,$jjpass,$jjiata,$hotelid,$intime,$days,$roomtype,$itemid)
if(!$fangxingstatus) message('此房型暂时不能预订');
// 重新赋值
$amount=$fangxingstatus['amount'];
$price=$fangxingstatus['price'];
$numbers = array();
for ($i=1; $i <= $amount; $i++) { 
	$numbers[]="<option value='$i'>$i</option> ";
}
$user = userinfo($_username);
$CAT = get_cat($catid);
if(!check_group($_groupid, $CAT['group_show'])) include load('403.inc');
$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
$content = $t['content'];
if($lazy) $content = img_lazy($content);
if($MOD['keylink']) $content = keylink($content, $moduleid);
$CP = $MOD['cat_property'] && $CAT['property'];
if($CP) {
	require DT_ROOT.'/include/property.func.php';
	$options = property_option($catid);
	$values = property_value($moduleid, $itemid);
}
$RL = $relate_id ? get_relate($item) : array();
$P1 = get_nv($n1, $v1);
$P2 = get_nv($n2, $v2);
$P3 = get_nv($n3, $v3);
if($step) {
	extract(unserialize($step));
} else {
	$a1 = 1;
	$p1 = $item['price'];
	$a2 = $a3 = $p2 = $p3 = '';
}
$unit or $unit = $L['unit'];
$adddate = timetodate($addtime, 3);
$editdate = timetodate($edittime, 3);
$linkurl = $MOD['linkurl'].$linkurl;
$thumbs = get_albums($item);
$albums =  get_albums($item, 1);
$amount = number_format($amount, 0, '.', '');
$fee = get_fee($item['fee'], $MOD['fee_view']);
$update = '';
if(check_group($_groupid, $MOD['group_contact'])) {
	if($fee) {
		$user_status = 4;
		$destoon_task = "moduleid=$moduleid&html=show&itemid=$itemid";
	} else {
		$user_status = 3;
		$member = $item['username'] ? userinfo($item['username']) : array();
		if($member) {
			$update_user = update_user($member, $item);
			if($update_user) $db->query("UPDATE {$table} SET ".substr($update_user, 1)." WHERE username='$username'");
		}
	}
} else {
	$user_status = $_userid ? 1 : 0;
	if($_username && $item['username'] == $_username) {
		$member = userinfo($item['username']);
		$user_status = 3;
	}
}
include DT_ROOT.'/include/update.inc.php';
$seo_file = 'show';
include DT_ROOT.'/include/seo.inc.php';
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].mobileurl($moduleid, 0, $itemid, $page);
$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'show');
include template($template, $module);
?>