<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
?>
<?php if(!isset($js)) { ?><div class="tt"><?php echo $mobile;?></div><?php } ?>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>&nbsp;<a href="<?php echo DT_PATH;?>api/redirect.php?url=https://www.baidu.com/s?wd=<?php echo $mobile;?>" target="_blank"><?php echo mobile2area($mobile);?></a></td>
</tr>
</table>
<?php include tpl('footer');?>