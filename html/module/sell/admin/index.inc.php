<?php
defined('DT_ADMIN') or exit('Access Denied');
require MD_ROOT.'/sell.class.php';
require_once MD_ROOT.'/Excel/reader.php';

$do = new sell($moduleid);
$menus = array (
    array('添加'.$MOD['name'], '?moduleid='.$moduleid.'&action=add'),
    array($MOD['name'].'列表', '?moduleid='.$moduleid),
    array('审核'.$MOD['name'], '?moduleid='.$moduleid.'&action=check'),
    array('过期'.$MOD['name'], '?moduleid='.$moduleid.'&action=expire'),
    array('未通过'.$MOD['name'], '?moduleid='.$moduleid.'&action=reject'),
    array('回收站', '?moduleid='.$moduleid.'&action=recycle'),
    array('移动分类', '?moduleid='.$moduleid.'&action=move'),
);

if(in_array($action, array('add', 'edit'))) {
	$FD = cache_read('fields-'.substr($table, strlen($DT_PRE)).'.php');
	if($FD) require DT_ROOT.'/include/fields.func.php';
	isset($post_fields) or $post_fields = array();
	$CP = $MOD['cat_property'];
	if($CP) require DT_ROOT.'/include/property.func.php';
	isset($post_ppt) or $post_ppt = array();
}

if($_catids || $_areaids) require DT_ROOT.'/admin/admin_check.inc.php';

if(in_array($action, array('', 'check', 'expire', 'reject', 'recycle'))) {
	$sfields = array('模糊', '标题', '产品品牌', '计量单位', '简介', '公司名', '联系人', '联系电话', '联系地址', '电子邮件', '联系MSN', '联系QQ', '用户名', '编辑', 'IP', '参数名1', '参数名2', '参数名3', '参数值1', '参数值2', '参数值3', '文件路径', '内容模板');
	$dfields = array('keyword', 'title', 'brand', 'unit', 'introduce', 'company', 'truename', 'telephone', 'address', 'email', 'msn', 'qq','username', 'editor', 'ip', 'n1', 'n2', 'n3', 'v1', 'v2', 'v3', 'filepath', 'template');
	$sorder  = array('结果排序方式', '更新时间降序', '更新时间升序', '添加时间降序', '添加时间升序', VIP.'级别降序', VIP.'级别升序', '产品单价降序', '产品单价升序', '供货总量降序', '供货总量升序', '最小起订降序', '最小起订升序', '浏览次数降序', '浏览次数升序', '信息ID降序', '信息ID升序');
	$dorder  = array($MOD['order'], 'edittime DESC', 'edittime ASC', 'addtime DESC', 'addtime ASC', 'vip DESC', 'vip ASC', 'price DESC', 'price ASC', 'amount DESC', 'amount ASC', 'minamount DESC', 'minamount ASC', 'hits DESC', 'hits ASC', 'itemid DESC', 'itemid ASC');

	$level = isset($level) ? intval($level) : 0;
	$typeid = isset($typeid) ? ($typeid === '' ? -1 : intval($typeid)) : -1;
	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	isset($order) && isset($dorder[$order]) or $order = 0;
	$thumb = isset($thumb) ? intval($thumb) : 0;
	$guest = isset($guest) ? intval($guest) : 0;
	$elite = isset($elite) ? intval($elite) : 0;
	$vip = isset($vip) ? intval($vip) : 0;
	$price = isset($price) ? intval($price) : 0;

	isset($datetype) && in_array($datetype, array('edittime', 'addtime', 'totime')) or $datetype = 'edittime';
	$fromdate = isset($fromdate) && is_date($fromdate) ? $fromdate : '';
	$fromtime = $fromdate ? strtotime($fromdate.' 0:0:0') : 0;
	$todate = isset($todate) && is_date($todate) ? $todate : '';
	$totime = $todate ? strtotime($todate.' 23:59:59') : 0;
	
	$minprice = isset($minprice) ? dround($minprice) : '';
	$minprice or $minprice = '';
	$maxprice = isset($maxprice) ? dround($maxprice) : '';
	$maxprice or $maxprice = '';
	$minamount = isset($minamount) ? dround($minamount) : '';
	$minamount or $minamount = '';
	$maxamount = isset($maxamount) ? dround($maxamount) : '';
	$maxamount or $maxamount = '';
	$minminamount = isset($minminamount) ? dround($minminamount) : '';
	$minminamount or $minminamount = '';
	$maxminamount = isset($maxminamount) ? dround($maxminamount) : '';
	$maxminamount or $maxminamount = '';
	$minvip = isset($minvip) ? intval($minvip) : '';
	$minvip or $minvip = '';
	$maxvip = isset($maxvip) ? intval($maxvip) : '';
	$maxvip or $maxvip = '';
	$itemid or $itemid = '';

	$fields_select = dselect($sfields, 'fields', '', $fields);
	$type_select = dselect($TYPE, 'typeid', $MOD['name'].'类型', $typeid);
	$level_select = level_select('level', '级别', $level, 'all');
	$order_select  = dselect($sorder, 'order', '', $order);

	$condition = '';
	if($_childs) $condition .= " AND catid IN (".$_childs.")";//CATE
	if($_areaids) $condition .= " AND areaid IN (".$_areaids.")";//CITY
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
	if($catid) $condition .= ($CAT['child']) ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
	if($areaid) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";

	if($typeid >=0) $condition .= " AND typeid=$typeid";
	if($level) $condition .= $level > 9 ? " AND level>0" : " AND level=$level";
	if($thumb) $condition .= " AND thumb<>''";
	if($guest) $condition .= " AND username=''";
	if($elite) $condition .= " AND elite>0";
	if($vip) $condition .= " AND vip>0";
	if($price) $condition .= " AND price>0";
	if($minprice)  $condition .= " AND price>=$minprice";
	if($maxprice)  $condition .= " AND price<=$maxprice";
	if($minamount)  $condition .= " AND amount>=$minamount";
	if($maxamount)  $condition .= " AND amount<=$maxamount";
	if($minminamount)  $condition .= " AND minamount>=$minminamount";
	if($maxminamount)  $condition .= " AND minamount<=$maxminamount";
	if($minvip)  $condition .= " AND vip>=$minvip";
	if($maxvip)  $condition .= " AND vip<=$maxvip";
	if($fromtime) $condition .= " AND `$datetype`>=$fromtime";
	if($totime) $condition .= " AND `$datetype`<=$totime";
	if($itemid) $condition .= " AND itemid=$itemid";

	$timetype = strpos($dorder[$order], 'add') !== false ? 'add' : '';
}
switch($action) {
	case 'add':
		if($submit) {
			//var_dump($FD);exit;
		  $wenjianming = time().$_FILES["file"]["name"];
          //echo $moduleid;exit;
		 move_uploaded_file($_FILES["file"]["tmp_name"],MD_ROOT."/upload/".$wenjianming);
		 
			if($do->pass($post)) {
				

				if($FD) fields_check($post_fields);
				if($CP) property_check($post_ppt);
				$do->add($post);
				if($FD) fields_update($post_fields, $table, $do->juanid);
				if($CP) property_update($post_ppt, $moduleid, $post['catid'], $do->juanid);
				if($MOD['show_html'] && $post['status'] > 2) $do->tohtml($do->juanid);
				
				$data = new Spreadsheet_Excel_Reader();
	            $data->setOutputEncoding('CP936');
				$data->read(MD_ROOT."/upload/".$wenjianming);
				error_reporting(E_ALL ^ E_NOTICE);
				$count=0;
		
				
				$addtime=strtotime($post['addtime']);
				$enddate=strtotime($post['totime']);
				$enddate=date('y-m-d',$enddate);
			    if($post['catid']==25){
					$catid=2;
				}else if($post['catid']==26){
					$catid=3;
				}
				else if($post['catid']==27){
					$catid=4;
				}
				else if($post['catid']==28){
					$catid=5;
				}
				
				$post1 = array("categoryid"=>$catid,"code"=>$post['code'],"membername"=>$post['title'],"enddate"=>$enddate,"addtime"=>$addtime);//字段太多重构一个数组
		
				//var_dump($post1);exit;
				
				for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
					$unit=iconv("GBK","UTF-8//IGNORE",$data->sheets[0]['cells'][$i][1]);
					
					$post1['code']=$unit;
					$do->add2($post1);
					if($MOD['show_html'] && $post['status'] > 2) $do->tohtml($do->juanid);
				
					
				}
				dmsg('添加成功', '?moduleid='.$moduleid.'&action='.$action);
				
			} else {
				msg($do->errmsg);
			}
		} else {
			foreach($do->fields as $v) {
				isset($$v) or $$v = '';
			}
			$content = '';
			$status = 3;
			$addtime = timetodate($DT_TIME);
			$totime = '';
			$username = $_username;
			$typeid = 0;
			$item = array();
			$menuid = 0;
			isset($url) or $url = '';
			if($url) {
				$tmp = fetch_url($url);
				if($tmp) extract($tmp);
			}
			include tpl('edit', $module);
		}
	break;
	case 'edit':
		$itemid or msg();
		$do->itemid = $itemid;
		if($submit) {
			if($do->pass($post)) {
				if($FD) fields_check($post_fields);
				if($CP) property_check($post_ppt);
				if($FD) fields_update($post_fields, $table, $do->itemid);
				if($CP) property_update($post_ppt, $moduleid, $post['catid'], $do->itemid);
				$do->edit($post);
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			$item = $do->get_one();
			extract($item);
			$addtime = timetodate($addtime);
			$totime = $totime ? timetodate($totime, 3) : '';
			$menuon = array('5', '4', '2', '1', '3');
			$menuid = $menuon[$status];
			include tpl($action, $module);
		}
	break;
	case 'move':
		if($submit) {
			$fromids or msg('请填写来源ID');
			if($tocatid) {
				$db->query("UPDATE {$table} SET catid=$tocatid WHERE `{$fromtype}` IN ($fromids)");
				$db->query("UPDATE {$table_search} SET catid=$tocatid WHERE `{$fromtype}` IN ($fromids)");
				dmsg('移动成功', $forward);
			} else {
				msg('请选择目标分类');
			}
		} else {
			$itemid = $itemid ? implode(',', $itemid) : '';
			$menuid = 6;
			include tpl($action);
		}
	break;
	case 'update':
		is_array($itemid) or msg('请选择'.$MOD['name']);
		foreach($itemid as $v) {
			$do->update($v);
		}
		dmsg('更新成功', $forward);
	break;
	case 'tohtml':
		is_array($itemid) or msg('请选择'.$MOD['name']);
		foreach($itemid as $itemid) {
			tohtml('show', $module);
		}
		dmsg('生成成功', $forward);
	break;
	case 'delete':
		$itemid or msg('请选择'.$MOD['name']);
		isset($recycle) ? $do->recycle($itemid) : $do->delete($itemid);
		dmsg('删除成功', $forward);
	break;
	case 'restore':
		$itemid or msg('请选择'.$MOD['name']);
		$do->restore($itemid);
		dmsg('还原成功', $forward);
	break;
	case 'refresh':
		$itemid or msg('请选择'.$MOD['name']);
		$do->refresh($itemid);
		dmsg('刷新成功', $forward);
	break;
	case 'clear':
		$do->clear();
		dmsg('清空成功', $forward);
	break;
	case 'level':
		$itemid or msg('请选择'.$MOD['name']);
		$level = intval($level);
		$do->level($itemid, $level);
		dmsg('级别设置成功', $forward);
	break;
	case 'type':
		$itemid or msg('请选择'.$MOD['name']);
		$tid = intval($tid);
		array_key_exists($tid, $TYPE) or $tid = 0;
		$do->type($itemid, $tid);
		dmsg('类型设置成功', $forward);
	break;
	case 'recycle':
		$lists = $do->get_list('status=0'.$condition, $dorder[$order]);
		$menuid = 5;
		include tpl('index', $module);
	break;
	case 'reject':
		if($itemid && !$psize) {
			$do->reject($itemid);
			dmsg('拒绝成功', $forward);
		} else {
			$lists = $do->get_list('status=1'.$condition, $dorder[$order]);
			$menuid = 4;
			include tpl('index', $module);
		}
	break;
	case 'expire':
		if(isset($refresh)) {
			if(isset($extend)) {
				$days = isset($days) ? intval($days) : 0;
				$days or msg('请填写天数');
				$itemid or msg('请选择信息');
				foreach($itemid as $v) {
					$db->query("UPDATE {$table} SET totime=totime+$days*86400,status=3 WHERE itemid='$v' AND totime>0");
				}
				$do->expire();
				dmsg('延时成功', $forward);
			} else {
				$do->expire();
				dmsg('刷新成功', $forward);
			}
		} else {
			$lists = $do->get_list('status=4'.$condition);
			$menuid = 3;
			include tpl('index', $module);
		}
	break;
	case 'check':
		if($itemid && !$psize) {
			$do->check($itemid);
			dmsg('审核成功', $forward);
		} else {
			$lists = $do->get_list('status=2'.$condition, $dorder[$order]);
			$menuid = 2;
			include tpl('index', $module);
		}
	break;
	default:
	
		$lists = $do->get_list('status=3'.$condition, $dorder[$order]);
		$menuid = 1;
		//var_dump($lists);exit;
		include tpl('index', $module);
	break;
}
?>