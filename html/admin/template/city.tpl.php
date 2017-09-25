<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form action="?">
<div class="tt">分站搜索</div>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>&nbsp;
<input type="text" size="50" name="kw" value="<?php echo $kw;?>" title="分站名称或绑定域名"/>
&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>&nbsp;
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?file=<?php echo $file;?>');"/>
</td>
</tr>
</table>
</form>
<div class="tt">分站管理</div>
<form method="post">
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th>字母索引</th>
<th>排序</th>
<th>地区</th>
<th>分站名称</th>
<th>绑定域名</th>
<th width="80">操作</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><input type="checkbox" name="areaids[]" value="<?php echo $v['areaid'];?>"/></td>
<td>
<input name="post[<?php echo $v['areaid'];?>][areaid]" type="hidden" value="<?php echo $v['areaid'];?>"/>
<input name="post[<?php echo $v['areaid'];?>][letter]" type="text" value="<?php echo $v['letter'];?>" size="3"/>
</td>
<td><input name="post[<?php echo $v['areaid'];?>][listorder]" type="text" size="3" value="<?php echo $v['listorder'];?>"/></td>
<td>&nbsp;<a href="<?php echo $v['linkurl'];?>" target="_blank"><?php echo $AREA[$v['areaid']]['areaname'];?></a>&nbsp;</td>

<td>
<input name="post[<?php echo $v['areaid'];?>][name]" type="text" value="<?php echo $v['name'];?>" style="width:100px;color:<?php echo $v['style'];?>"/>
<?php echo dstyle('post['.$v['areaid'].'][style]', $v['style']);?>
</td>
<td><input name="post[<?php echo $v['areaid'];?>][domain]" type="text" value="<?php echo $v['domain'];?>" size="30"/></td>

<td>
<a href="?file=<?php echo $file;?>&action=edit&areaid=<?php echo $v['areaid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?file=<?php echo $file;?>&action=delete&areaid=<?php echo $v['areaid'];?>" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a></td>
</tr>
<?php }?>
</table>
<div class="btns">&nbsp;
<input type="submit" name="submit" value="更新分站" class="btn" onclick="this.form.action='?file=<?php echo $file;?>&action=update'"/>&nbsp;
<input type="submit" value="删除选中" class="btn" onclick="if(confirm('确定要删除选中分站吗？此操作将不可撤销')){this.form.action='?file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;

</div>
</form>
<div class="pages"><?php echo $pages;?></div>
<script type="text/javascript">Menuon(1);</script>
<?php include tpl('footer');?>