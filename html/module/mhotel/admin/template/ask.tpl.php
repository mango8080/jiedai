<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form action="?">
<div class="tt">问题搜索</div>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>&nbsp;
<?php echo $fields_select;?>&nbsp;
<input type="text" size="20" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<?php echo $type_select;?>&nbsp;
<?php echo $status_select;?>&nbsp;
<?php echo $star_select;?>&nbsp;
<?php echo $order_select;?>
&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>&status=<?php echo $status;?>');"/>
</td>
</tr>
</table>
</form>
<div class="tt">问题列表</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th>流水号</th>
<th>分类</th>
<th>标题</th>
<th width="130">添加时间</th>
<th width="130">受理时间</th>
<th>用户名称</th>
<?php if($status > 1) {?>
<th width="130">评分</th>
<?php } ?>
<th width="50">操作</th>
</tr>
<?php foreach($asks as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><?php echo $v['itemid'];?></td>
<td><?php echo $v['type'];?></td>
<td align="left"><a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=edit&itemid=<?php echo $v['itemid'];?>"><?php echo $v['title'];?></a></td>
<td><?php echo $v['adddate'];?></td>
<td><?php echo $v['editdate'];?></td>
<td><a href="javascript:_user('<?php echo $v['username'];?>');"><?php echo $v['username'];?></a></td>
<?php if($status > 1) {?>
<td><?php echo $stars[$v['star']];?></td>
<?php } ?>
<td>
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=edit&itemid=<?php echo $v['itemid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="受理" alt=""/></a>&nbsp;
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&itemid=<?php echo $v['itemid'];?>" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
</td>
</tr>
<?php }?>
</table>
<div class="pages"><?php echo $pages;?></div>
<?php if(!$TYPE) { ?>
<script type="text/javascript">Dwidget('?file=type&item=<?php echo $file;?>', '启用客服中心，请先添加问题分类');</script>
<?php } ?>
<script type="text/javascript">Menuon(<?php echo $status;?>);</script>
<br/>
<?php include tpl('footer');?>