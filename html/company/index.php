<?php
define('DT_REWRITE', true);
require 'config.inc.php';
require '../common.inc.php';
dheader('search.php?page=1');
require DT_ROOT.'/module/'.$module.'/index.inc.php';
?>