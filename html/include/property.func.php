<?php
/*
	[Hotel System] Copyright (c) 2008-2015 www.idc580.cn
	
*/
defined('IN_DESTOON') or exit('Access Denied');
function property_update($post_ppt, $moduleid, $catid, $itemid) {
	global $db;
	$catid = intval($catid);
	if(!$post_ppt || !$moduleid || !$catid || !$itemid) return;
	$OP = property_option($catid);
	if(!$OP) return;
	$post_ppt = dhtmlspecialchars($post_ppt);	
	$db->query("DELETE FROM {$db->pre}category_value WHERE moduleid=$moduleid AND itemid=$itemid");
	$ppt = array();
	foreach($OP as $v) {
		if($v['type'] > 1 && $v['search']) $ppt[] = $v['oid'];
	}
	$pptword = '';
	foreach($post_ppt as $k=>$v) {
		if(in_array($k, $ppt)) {
			if(is_array($v)) {
				foreach($v as $_v) {
					$pptword .= 'O'.$k.':'.$_v.';';
				}
			} else {
				$pptword .= 'O'.$k.':'.$v.';';
			}
		}
		if(is_array($v)) $v = implode(',', $v);
		$db->query("INSERT INTO {$db->pre}category_value (oid,moduleid,itemid,value) VALUES ('$k','$moduleid','$itemid','$v')");
	}
	if($pptword) $db->query("UPDATE ".get_table($moduleid)." SET pptword='$pptword' WHERE itemid=$itemid");
}

function property_check($post_ppt) {
	global $post;
	include load('include.lang');
	$OP = $post['catid'] ? property_option($post['catid']) : array();
	if(!$OP) return;
	foreach($OP as $v) {
		if($v['required'] && !$post_ppt[$v['oid']]) {
			$msg = lang($v['type'] > 1 ? $L['fields_choose'] : $L['fields_input'], array($v['name']));
			defined('DT_ADMIN') ? msg($msg) : dalert($msg);
		}
	}
}

function property_option($catid) {
	global $db;
	$catid = intval($catid);
	$lists = array();
	$result = $db->query("SELECT * FROM {$db->pre}category_option WHERE catid=$catid ORDER BY listorder ASC,oid ASC");
	while($r = $db->fetch_array($result)) {
		$lists[] = $r;
	}
	return $lists;
}

function property_value($moduleid, $itemid) {
	global $db;
	$lists = array();
	$result = $db->query("SELECT oid,value FROM {$db->pre}category_value WHERE moduleid=$moduleid AND itemid=$itemid");
	while($r = $db->fetch_array($result)) {
		$lists[$r['oid']] = $r['value'];
	}
	return $lists;
}

function property_condition($catid) {
	global $db;
	$catid = intval($catid);
	$lists = array();
	$result = $db->query("SELECT * FROM {$db->pre}category_option WHERE catid=$catid AND type>1 AND search>0 ORDER BY listorder ASC,oid ASC");
	while($r = $db->fetch_array($result)) {
		$r['options'] = explode('|', str_replace('(*)', '', $r['value']));
		$lists[] = $r;
	}
	return $lists;
}

function property_js() {
	include template('property_js', 'chip');
}

function property_html($var, $oid, $type, $value, $extend = '') {
	global $L;
	$str = '';
	if($type == 0) {
		if(strpos($extend, 'size=') === false) $extend .= ' size="50"';
		$str = '<input type="text" name="post_ppt['.$oid.']" id="property-'.$oid.'" value="'.($var ? $var : $value).'" '.$extend.'/>';
	} else if($type == 1) {
		if(strpos($extend, 'rows=') === false) $extend .= ' rows="5"';
		if(strpos($extend, 'cols=') === false) $extend .= ' cols="80"';
		$str = '<textarea name="post_ppt['.$oid.']" id="property-'.$oid.'" '.$extend.'>'.($var ? $var : $value).'</textarea><br/>';
	} else if($type == 2) {
		$str = '<select name="post_ppt['.$oid.']" id="property-'.$oid.'" '.$extend.'><option value="">'.$L['choose'].'</option>';
		$ops = explode('|', $value);
		foreach($ops as $o) {
			if($var) {
				$o = str_replace('(*)', '', $o);
				$selected = $o == $var ? ' selected' : '';
			} else {
				$selected = strpos($o, '(*)') !== false ? ' selected' : '';
				$o = str_replace('(*)', '', $o);
			}
			$str .= '<option value="'.$o.'"'.$selected.'>'.$o.'</option>';
		}
		$str .= '</select>';
	} else if($type == 3) {
		$str = '<span id="property-'.$oid.'" '.$extend.'>';
		$ops = explode('|', $value);
		foreach($ops as $o) {
			if($var) {
				$o = str_replace('(*)', '', $o);
				$tmp = explode(',', $var);
				$selected = in_array($o, $tmp) ? ' checked' : '';
			} else {
				$selected = strpos($o, '(*)') !== false ? ' checked' : '';
				$o = str_replace('(*)', '', $o);
			}
			$str .= '<input type="checkbox" name="post_ppt['.$oid.'][]" value="'.$o.'"'.$selected.'>'.$o.'&nbsp;&nbsp;';
		}
		$str .= '</span>';
	}
	$str .= ' <span id="dproperty-'.$oid.'" class="f_red"></span>';
	return $str;
}
?>