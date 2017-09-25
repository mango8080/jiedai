<?php
require 'common.inc.php';
if (empty($source)) $source="pc";

$db->query("Update `destoon_setting` Set item_value=item_value+1 WHERE item='webcount' and item_key='{$source}'");
/*
	$txt_db = 'count.txt';
	$nums = file_get_contents($txt_db);
	$nums++;
	file_put_contents($txt_db,$nums);
*/
?>