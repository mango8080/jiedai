<?php
/*
	[Hotel System] Copyright (c) 2008-2016 www.idc580.cn
	
*/
defined('IN_DESTOON') or exit('Access Denied');
class dcache {
	var $pre;

    function __construct() {
		//
    }

    function dcache() {
		$this->__construct();
    }

    function get($key) {
        return eaccelerator_get($this->pre.$key);
    }

    function set($key, $val, $ttl = 600) {
        eaccelerator_lock($this->pre.$key);
        return eaccelerator_put($this->pre.$key, $val, $ttl);
    }

    function rm($key) {
        return eaccelerator_rm($this->pre.$key);
    }

    function clear() {
        return eaccelerator_gc();
    }

	function expire() {
		return eaccelerator_gc();
	}
}
?>