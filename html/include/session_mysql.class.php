<?php
/*
	[Hotel System] Copyright (c) 2008-2016 www.idc580.cn
	
*/
defined('IN_DESTOON') or exit('Access Denied');
class dsession {
	var $db;
	var $table;
	var $time;

    function __construct() {
		global $db, $DT_TIME;
		$this->db = &$db;
		$this->table = $this->db->pre.'session';
	    $this->time = $DT_TIME;
		if(DT_DOMAIN) @ini_set('session.cookie_domain', '.'.DT_DOMAIN);
    	session_set_save_handler(array(&$this,'open'), array(&$this,'close'), array(&$this,'read'), array(&$this,'write'), array(&$this,'destroy'), array(&$this,'gc'));
		session_cache_limiter('private, must-revalidate');
		session_start();
		header("cache-control: private");
    }

    function dsession() {
		$this->__construct();
    }

    function open($path, $name) {
		return true;
    }

    function close() {
		$this->gc();
    } 

    function read($sid) {
		$r = $this->db->get_one("SELECT data FROM {$this->table} WHERE sessionid='$sid'");
		return $r ? $r['data'] : '';
    } 

    function write($sid, $data) {
		$data = addslashes($data);
        $this->db->query("REPLACE INTO {$this->table} (sessionid,data,lastvisit) VALUES('$sid', '$data', '$this->time')");
    } 

    function destroy($sid) { 
		$this->db->query("DELETE FROM {$this->table} WHERE sessionid='$sid'");
    } 

	function gc() {
		$expiretime = $this->time - 1800;
		$this->db->query("DELETE FROM {$this->table} WHERE lastvisit<$expiretime");
    }
}
?>