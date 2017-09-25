<?php
/*
	[Hotel System] Copyright (c) 2008-2016 www.idc580.cn
	
*/
defined('DT_ADMIN') or exit('Access Denied');
$CAT or msg('请指定分类ID');
$menus = array (
    array('添加属性', '?file='.$file.'&catid='.$catid.'&action=add'),
    array('属性参数', '?file='.$file.'&catid='.$catid),
    array('复制属性', '?file='.$file.'&catid='.$catid.'&action=copy'),
);
$TYPE = array('单行文本(text)', '多行文本(textarea)', '列表选择(select)', '复选框(checkbox)');
$do = new property;
$do->catid = $catid;
switch($action) {
	case 'add':
		if($submit) {
			if($do->pass($post)) {
				$do->add($post);
				dmsg('添加成功', '?file='.$file.'&catid='.$catid);
			} else {
				msg($do->errmsg);
			}
		} else {
			$type = 2;
			$required = $search = 0;
			$name = $value = $extend = '';
			include tpl('property_edit');
		}
	break;
	case 'edit':
		$oid or msg();
		$do->oid = $oid;
		if($submit) {
			if($do->pass($post)) {
				$do->edit($post);
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			extract($do->get_one($oid));
			include tpl('property_edit');
		}
	break;
	case 'copy':
		if($submit) {
			if($type) {
				$fromid = intval($fromid);
				$fromid or msg('请选择来源分类');
				$fromid != $catid or msg('来源分类不能与当前分类相同');
				$id = $fromid;
				$type = 1;
			} else {
				$pid = intval($pid);
				$pid or msg('请填写属性ID');
				$id = $pid;
				$type = 0;
			}
			$name = $name ? 1 : 0;
			if($do->copy($id, $type, $name)) {
				dmsg('属性复制成功', '?file='.$file.'&catid='.$catid);
			} else {
				msg($do->errmsg);
			}
		} else {
			include tpl('property_copy');
		}
	break;
	case 'order':
		$do->order($listorder, $pid);
		dmsg('排序成功', $forward);
	break;
	case 'delete':
		$oid or msg();
		$do->oid = $oid;
		$do->delete($pid);
		dmsg('删除成功', '?file='.$file.'&catid='.$catid);
	break;
	default:
		$lists = $do->get_list();
		include tpl('property');
	break;
}
class property {
	var $db;
	var $oid;
	var $catid;
	var $table;
	var $errmsg = errmsg;

	function __construct() {
		global $db, $DT_PRE;
		$this->table = $DT_PRE.'category_option';
		$this->db = &$db;
	}

	function property() {
		$this->__construct();
	}

	function pass($post) {
		if(!is_array($post)) return false;
		//if(!$post['pid']) return $this->_(lang('message->pass_property_op_pid'));
		if(!$post['name']) return $this->_('请填写属性名称');
		if($post['type'] == 3) {
			if(!$post['value']) return $this->_('请填写备选值');
			if(strpos($post['value'], '|') === false) return $this->_('最少需要设定2个备选值');
		}
		return true;
	}

	function set($post) {
		$post['value'] = trim($post['value']);
		if($post['type'] < 2) $post['search'] = 0;
		return $post;
	}

	function add($post) {
		$post = $this->set($post);
		$sqlk = $sqlv = '';
		foreach($post as $k=>$v) {
			$sqlk .= ','.$k; $sqlv .= ",'$v'";
		}
        $sqlk = substr($sqlk, 1);
        $sqlv = substr($sqlv, 1);
		$this->db->query("INSERT INTO {$this->table} ($sqlk) VALUES ($sqlv)");
		return true;
	}

	function edit($post) {
		$post = $this->set($post);
		$sql = '';
		foreach($post as $k=>$v) {
			$sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
	    $this->db->query("UPDATE {$this->table} SET $sql WHERE oid=$this->oid");
		return true;
	}

	function copy($id, $type, $name) {
		$i = 0;
		$condition = $type ? "catid=$id" : "oid=$id";
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE {$condition}");
		while($r = $this->db->fetch_array($result)) {
			if($name) {
				$n = daddslashes($r['name']);
				$t = $this->db->get_one("SELECT * FROM {$this->table} WHERE catid=$this->catid AND name='$n'");
				if($t) {
					if($type) continue;
					return $this->_('属性名称 ['.$r['name'].'] 已存在');
				}
			}
			unset($r['oid']);
			$r['catid'] = $this->catid;
			$post = daddslashes($r);
			$sqlk = $sqlv = '';
			foreach($post as $k=>$v) {
				$sqlk .= ','.$k; $sqlv .= ",'$v'";
			}
			$sqlk = substr($sqlk, 1);
			$sqlv = substr($sqlv, 1);
			$this->db->query("INSERT INTO {$this->table} ($sqlk) VALUES ($sqlv)");
			$i++;
		}
		if($i) return true;
		return $this->_('属性参数不存在或存在同名');
	}

	function get_one() {
        return $this->db->get_one("SELECT * FROM {$this->table} WHERE oid=$this->oid");
	}

	function delete($pid) {
		$this->db->query("DELETE FROM {$this->table} WHERE oid=$this->oid");
	}

	function order($listorder) {
		if(!is_array($listorder)) return false;
		foreach($listorder as $k=>$v) {
			$k = intval($k);
			$v = intval($v);
			$this->db->query("UPDATE {$this->table} SET listorder=$v WHERE oid=$k");
		}
		return true;
	}

	function get_list() {
		global $pages, $page, $pagesize, $offset, $pagesize, $CAT, $sum;
		$condition = "catid=$this->catid";
		if($page > 1 && $sum) {
			$items = $sum;
		} else {			
			$r = $this->db->get_one("SELECT COUNT(*) AS num FROM {$this->table} WHERE $condition");
			$items = $r['num'];
		}
		if($items != $CAT['property']) $this->db->query("UPDATE {$this->db->pre}category SET property=$r[num] WHERE catid=$this->catid");
		$pages = pages($items, $page, $pagesize);
		$lists = array();
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE $condition ORDER BY listorder ASC,oid ASC LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result)) {
			$lists[] = $r;
		}
		return $lists;
	}

	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
?>