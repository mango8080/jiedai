<?php
require 'common.inc.php';
if($_userid) set_cookie('auth', '');
dheader('login.php?reload='.$DT_TIME);
?>