<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
if(!$id) show_menu($menus);
?>
<div class="tt">记录搜索</div>
<form action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>&nbsp;
<?php echo $fields_select;?>&nbsp;
<input type="text" size="20" name="kw" value="<?php echo $kw;?>"/>&nbsp;
展会ID：<input type="text" name="id" value="<?php echo $id;?>" size="5"/>&nbsp;
<?php echo $order_select;?>&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>&nbsp;
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>');"/>
</td>
</tr>
<tr>
<td>&nbsp;
报名时间&nbsp;
<?php echo dcalendar('fromtime', $fromtime);?> 至 <?php echo dcalendar('totime', $totime);?>&nbsp;
报名人数&nbsp;
<input type="text" name="minamount" value="<?php echo $minamount;?>" size="5"/> 至 
<input type="text" name="maxamount" value="<?php echo $maxamount;?>" size="5"/>&nbsp;
</td>
</tr>
</table>
</form>
<form method="post">
<div class="tt">报名记录</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="20"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th>展会</th>
<th>报名人数</th>
<th>用户</th>
<th width="130">报名时间</th>
<th width="40">操作</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>"/></td>
<td align="left">
&nbsp;<a href="<?php echo $v['linkurl'];?>" target="_blank"><?php echo $v['title'];?></a>
</td>
<td class="f_red px11"><?php echo $v['amount'];?></td>
<td class="px11">
<a href="javascript:_user('<?php echo $v['username'];?>');"><?php echo $v['username'];?></a>
</td>
<td class="px11"><?php echo $v['addtime'];?></td>
<td>
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=show&itemid=<?php echo $v['itemid'];?>&id=<?php echo $id;?>"><img src="admin/image/view.png" width="16" height="16" title="查看" alt=""/></a>
</td>
</tr>
<?php }?>
</table>
<div class="btns">
<input type="submit" value=" 批量删除 " class="btn" onclick="if(confirm('确定要删除选中记录吗？请谨慎!此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>
</div>
</form>
<div class="pages"><?php echo $pages;?></div>
<script type="text/javascript">Menuon(1);</script>
<br/>
<?php include tpl('footer');?>