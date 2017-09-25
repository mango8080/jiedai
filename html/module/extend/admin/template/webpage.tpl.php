<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form action="?">
<div class="tt">单页搜索</div>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="item" value="<?php echo $item;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>
&nbsp;<?php echo $fields_select;?>&nbsp;
<input type="text" size="30" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<?php echo $level_select;?>&nbsp;
<?php echo $DT['city'] ? ajax_area_select('areaid', '地区(分站)', $areaid).'&nbsp;' : '';?>
<?php echo $order_select;?>
&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&item=<?php echo $item;?>&itemid=<?php echo $itemid;?>');"/>
</td>
</tr>
</table>
</form>
<form method="post">
<input type="hidden" name="item" value="<?php echo $item;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<div class="tt">管理单页</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th width="50">排序</th>
<th width="14"> </th>
<th>标 题</th>
<th>地 址</th>
<th>浏览次数</th>
<?php if($itemid) { ?><th>分组标识</th><?php } ?>
<th width="130">更新时间</th>
<th width="50">操作</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>"/></td>
<td><input type="text" size="2" name="listorder[<?php echo $v['itemid'];?>]" value="<?php echo $v['listorder'];?>"/></td>
<td><?php if($v['level']) {?><a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>&level=<?php echo $v['level'];?>"><img src="admin/image/level_<?php echo $v['level'];?>.gif" title="<?php echo $v['level'];?>级" alt=""/></a><?php } ?></td>
<td align="left">&nbsp;<a href="<?php echo $v['linkurl'];?>" target="_blank"><?php echo $v['title'];?></a></td>
<td align="left">&nbsp;<a href="<?php echo $v['linkurl'];?>" target="_blank"><?php echo $v['linkurl'];?></a></td>
<td class="px11"><?php echo $v['hits'];?></td>
<?php if($itemid) { ?><td><?php echo $v['item'];?></td><?php } ?>
<td class="px11"><?php echo $v['editdate'];?></td>
<td>
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=edit&itemid=<?php echo $v['itemid'];?>&item=<?php echo $v['item'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&itemid=<?php echo $v['itemid'];?>&item=<?php echo $v['item'];?>" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
</td>
</tr>
<?php }?>
</table>
<div class="btns">
<input type="submit" value=" 更新排序 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=order&item=<?php echo $item;?>';"/>&nbsp;
<input type="submit" value=" 删 除 " class="btn" onclick="if(confirm('确定要删除选中单页吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&item=<?php echo $item;?>'}else{return false;}"/>&nbsp;
<?php echo level_select('level', '设置级别为</option><option value="0">取消', 0, 'onchange="this.form.action=\'?moduleid='.$moduleid.'&file='.$file.'&action=level&item='.$item.';?>\';this.form.submit();"');?>&nbsp;
</div>
</form>
<div class="pages"><?php echo $pages;?></div>
<br/>
<script type="text/javascript">Menuon(<?php echo $itemid ? 2 : 1;?>);</script>
<?php include tpl('footer');?>