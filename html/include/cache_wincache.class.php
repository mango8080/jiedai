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
		return wincache_ucache_get($this->pre.$key);
    }

    function set($key, $val, $ttl = 600) {
		return wincache_ucache_set($this->pre.$key, $val, $ttl);
    }

    function rm($key) {
		return wincache_ucache_delete($this->pre.$key);
    }

    function clear() {
        return wincache_ucache_clear();
    }

	function expire() {
		return true;
	}
}
?>