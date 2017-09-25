<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
if(!$itemid) show_menu($menus);
?>
<div class="tt">统计概况</div>
<table cellpadding="2" cellspacing="1" class="tb">


<tr>
<td class="tl"><a href="?moduleid=2" class="t">用户</a></td>

<td width="10%">&nbsp;<a href="?moduleid=2"><span id="member"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td class="tl"><a href="?moduleid=4&file=vip" class="t"><?php echo VIP;?>用户</a></td>

<td width="10%">&nbsp;<a href="?moduleid=4&file=vip"><span id="member_vip"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td class="tl"><a href="?moduleid=2&action=check" class="t">待审核</a></td>

<td width="10%">&nbsp;<a href="?moduleid=2&action=check"><span id="member_check"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>


<td class="tl"><a href="?moduleid=2&action=add" class="t">今日新增</a></td>

<td width="10%">&nbsp;<a href="?moduleid=2"><span id="member_new"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>


<?php
foreach ($MODULE as $m) {
	if($m['moduleid'] < 5 || $m['islink']) continue;
?>

<?php 
if($m['moduleid'] == 9) $m['name'] = '招聘';
?>

<tr>
<td class="tl"><a href="<?php echo $m['linkurl'];?>" class="t" target="_blank"><?php echo $m['name'];?></a></td>

<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>"><span id="m_<?php echo $m['moduleid'];?>"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td class="tl"><a href="?moduleid=<?php echo $m['moduleid'];?>" class="t">已发布</a></td>

<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>"><span id="m_<?php echo $m['moduleid'];?>_1"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td class="tl"><a href="?moduleid=<?php echo $m['moduleid'];?>&action=check" class="t">待审核</a></td>

<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>&action=check"><span id="m_<?php echo $m['moduleid'];?>_2"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td class="tl"><a href="?moduleid=<?php echo $m['moduleid'];?>&action=add" class="t">今日新增</a></td>

<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>"><span id="m_<?php echo $m['moduleid'];?>_3"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>


<?php
if($m['moduleid'] == 9) {
	$m['name'] = '简历';
?>
<tr>
<td class="tl"><a href="<?php echo $m['linkurl'];?>" class="t" target="_blank"><?php echo $m['name'];?></a></td>

<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>&file=resume"><span id="m_resume"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td class="tl"><a href="?moduleid=<?php echo $m['moduleid'];?>&file=resume" class="t">已发布</a></td>

<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>&file=resume"><span id="m_resume_1"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td class="tl"><a href="?moduleid=<?php echo $m['moduleid'];?>&file=resume&action=check" class="t">待审核</a></td>

<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>&file=resume&action=check"><span id="m_resume_2"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td class="tl"><a href="?moduleid=<?php echo $m['moduleid'];?>&file=resume&action=add" class="t">今日新增</a></td>

<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>"><span id="m_resume_3"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>

<?php } ?>

<?php
}
?>
</table>
<script type="text/javascript">Menuon(0);</script>
<script type="text/javascript" src="?file=<?php echo $file;?>&action=js"></script>
<?php include tpl('footer');?>