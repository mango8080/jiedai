<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
if(!$id) show_menu($menus);
?>
<script type="text/javascript">var errimg = '<?php echo DT_SKIN;?>image/nopic50.gif';</script>

<form method="post">
<div class="tt">交易记录</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="20"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th>日期</th>
<th>申请方式</th>
<th>客户</th>
<th>年纪</th>
<th>提现金额</th>
<th>月还款/剩余期数</th>
<th>申请状态</th>

<th>订单号</th>
<th>备注</th>
<th>操作</th>
<th>明细</th>
</tr>
<?php foreach($lists as $k=>$v) {?>

<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>"/></td>
<td class="px11"><?php echo $v['updatetime'];?></td>
<td class="px11"><?php 
if($v['leixing']==1){
	echo "公积金社保卡借款";
}elseif($v['leixing']==2){
	echo "企业法人";
}elseif($v['leixing']==3){
	echo "卡帐借款";
}elseif($v['leixing']==4){
	echo "房借";
}elseif($v['leixing']==5){
	echo "车借";
}elseif($v['leixing']==6){
	echo "申请提现";
}

?> 
</td>

<td class="px11"><?php echo $v['name'];?></td>
<td class="f_red px11 f_b"><?php echo $v['nianling'];?></td>
<td class="f_red px11 f_b"><?php echo $v['tixian'];?></td>
<td class="f_red px11 f_b"><?php echo $v['yhke'];?><br /><?php echo $v['hkqs'];?></td>
<td>
<?php if($v['status']==3){	
 echo $v['dstatus'];?><br />
 退款流水:<input type="text" id="pageNo" onKeyPress="onlyNumber();" /><br/>
<a href="JavaScript:;" onclick="location ='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=queren&id=<?php echo $id;?>&itemid=<?php echo $v['itemid'];?>&pageNo='+document.getElementById('pageNo').value;">确认退款</a>

<?php }else if($v['status']==6){
  echo $v['dstatus'];
 echo "<br />";
  echo "退款流水:".$v['querenhao'];
 }else{
 echo $v['dstatus'];
}?>	
</td>

<td class="px11"><?php echo $v['ordercode'];?></td>

<td><?php echo $v['snote'];?></td>
<td>
<?php if($v['status']==0){ ?>
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=refund&id=<?php echo $id;?>&itemid=<?php echo $v['itemid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="受理" alt=""/></a>
<?php }?>	
</td>
<td>
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=show&id=<?php echo $id;?>&itemid=<?php echo $v['itemid'];?>"><img src="admin/image/view.png" width="16" height="16" title="查看" alt=""/></a>

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