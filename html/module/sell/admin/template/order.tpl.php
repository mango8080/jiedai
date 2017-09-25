<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
if(!$id) show_menu($menus);
?>
<script type="text/javascript">var errimg = '<?php echo DT_SKIN;?>image/nopic50.gif';</script>
<div class="tt">记录搜索</div>
<form action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="id" value="<?php echo $id;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>&nbsp;
<select name="fields">
<option value="0" selected="selected">按条件</option>
<option value="1">房型名称</option>
<option value="2">酒店</option>
<option value="3">客户</option>
<option value="4">订单金额</option>
<option value="7">客户名称</option>
<option value="11">客户手机</option>
</select>&nbsp;
<input type="text" size="20" name="kw" value="<?php echo $kw;?>"/>&nbsp;
<select name="status" style="width:200px;">
<option value="">状态</option>
<option value="0">待确认</option>
<option value="1">待付款</option>
<option value="2">已付款</option>
<option value="4">已入住</option>
<option value="7">到店付款</option>
<option value="8">客户取消</option>
<option value="9">酒店取消</option>
<option value="10">已离店</option>
</select>&nbsp;
<?php echo $order_select;?>&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>&nbsp;
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>&id=<?php echo $id;?>');"/>
</td>
</tr>
<?php if(!$id) { ?>
<tr>
<td>&nbsp;
<select name="timetype">
<option value="addtime" <?php if($timetype == 'addtime') echo 'selected';?>>下单时间</option>
<option value="updatetime" <?php if($timetype == 'updatetime') echo 'selected';?>>更新时间</option>
</select>&nbsp;
<?php echo dcalendar('fromtime', $fromtime);?> 至 <?php echo dcalendar('totime', $totime);?>&nbsp;
<select name="mtype">
<option value="money" <?php if($mtype == 'money') echo 'selected';?>>交易总额</option>
<option value="amount" <?php if($mtype == 'amount') echo 'selected';?>>下单金额</option>
<option value="price" <?php if($mtype == 'price') echo 'selected';?>>房型单价</option>
<option value="fee" <?php if($mtype == 'fee') echo 'selected';?>>附加费用</option>
<option value="number" <?php if($mtype == 'number') echo 'selected';?>>购买数量</option>
</select>&nbsp;
<input type="text" name="minamount" value="<?php echo $minamount;?>" size="5"/> 至 
<input type="text" name="maxamount" value="<?php echo $maxamount;?>" size="5"/>&nbsp;

<select name="seller_star">
<option value="0" <?php if($seller_star == 0) echo 'selected';?>>酒店评价</option>
<option value="3" <?php if($seller_star == 3) echo 'selected';?>>好评</option>
<option value="2" <?php if($seller_star == 2) echo 'selected';?>>中评</option>
<option value="1" <?php if($seller_star == 1) echo 'selected';?>>差评</option>
</select>&nbsp;

<select name="buyer_star">
<option value="0" <?php if($buyer_star == 0) echo 'selected';?>>客户评价</option>
<option value="3" <?php if($buyer_star == 3) echo 'selected';?>>好评</option>
<option value="2" <?php if($buyer_star == 2) echo 'selected';?>>中评</option>
<option value="1" <?php if($buyer_star == 1) echo 'selected';?>>差评</option>
</select>&nbsp;
</td>
</tr>
<tr>
<td>&nbsp;
订单单号：<input type="text" name="itemid" value="<?php echo $itemid;?>" size="10"/>&nbsp;
房型单号：<input type="text" name="mallid" value="<?php echo $mallid;?>" size="10"/>&nbsp;
酒店：<input type="text" name="seller" value="<?php echo $seller;?>" size="10"/>&nbsp;
客户：<input type="text" name="buyer" value="<?php echo $buyer;?>" size="10"/>&nbsp;
</td>
</tr>
<?php } ?>
</table>
</form>
<form method="post">
<div class="tt">交易记录</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="20"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th width="60">缩略图</th>
<th>借款类型</th>
<th>交易总额</th>
<th>酒店</th>
<th>客户</th>
<th width="75">下单时间</th>
<th width="75">更新时间</th>
<th>状态</th>
<th>操作</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>"/></td>
<td><a href="<?php echo $v['linkurl'];?>" target="_blank"><img src="<?php if($v['thumb']) { ?><?php echo $v['thumb'];?><?php } else { ?><?php echo DT_SKIN;?>image/nopic50.gif<?php } ?>" width="50" height="50" onerror="this.src=errimg;" style="padding:5px;"/></a></td>
<td align="left" class="f_gray">
&nbsp;
<a href="<?php echo $v['linkurl'];?>" target="_blank" class="t px14 f_b"><?php echo $v['title'];?></a><br/>&nbsp;
<strong>单号：</strong><?php echo $v['itemid'];?>&nbsp;
<strong>单价：</strong><?php echo $v['price'];?>&nbsp;
<strong>数量：</strong><?php echo $v['number'];?>
</td>
<td class="f_red px11 f_b"><?php echo $v['money'];?></td>
<td class="px11">
<a href="javascript:_user('<?php echo $v['seller'];?>');"><?php echo $v['seller'];?></a><br/>
<?php if($v['seller_star'] > 0) {?>
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=show&id=<?php echo $id;?>&itemid=<?php echo $v['itemid'];?>#comment1"><img src="<?php echo DT_PATH;?>file/image/star<?php echo $v['seller_star'];?>.gif" width="36" height="12" title="客户评价酒店：<?php echo $STARS[$v['seller_star']];?> 点击查看详情"/></a>
<?php } ?>
</td>
<td class="px11">
<a href="javascript:_user('<?php echo $v['buyer'];?>');"><?php echo $v['buyer'];?></a><br/>
<?php if($v['buyer_star'] > 0) {?>
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=show&id=<?php echo $id;?>&itemid=<?php echo $v['itemid'];?>#comment2"><img src="<?php echo DT_PATH;?>file/image/star<?php echo $v['buyer_star'];?>.gif" width="36" height="12" title="酒店评价客户：<?php echo $STARS[$v['buyer_star']];?> 点击查看详情"/></a>
<?php } ?>
</td>
<td class="px11"><?php echo $v['addtime'];?></td>
<td class="px11"><?php echo $v['updatetime'];?></td>
<td><?php echo $v['dstatus'];?></td>
<td>
<?php if($v['status'] == 5) {?>
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=refund&id=<?php echo $id;?>&itemid=<?php echo $v['itemid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="受理" alt=""/></a>
<?php } else { ?>
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=show&id=<?php echo $id;?>&itemid=<?php echo $v['itemid'];?>"><img src="admin/image/view.png" width="16" height="16" title="查看" alt=""/></a>
<?php } ?>
</td>
</tr>
<?php }?>
<tr align="center">
<td></td>
<td><strong>小计</strong></td>
<td></td>
<td class="f_red f_b"><?php echo $money;?></td>
<td colspan="7">&nbsp;</td>
</tr>
</table>
<div class="btns">
<input type="submit" value=" 批量删除 " class="btn" onclick="if(confirm('确定要删除选中记录吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>
</div>
</form>
<div class="pages"><?php echo $pages;?></div>
<script type="text/javascript">Menuon(1);</script>
<br/>
<?php include tpl('footer');?>