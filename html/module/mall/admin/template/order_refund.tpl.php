<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
if(!$id) show_menu($menus);
?>
<form method="post" action="?" id="dform" onsubmit="return check();">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<input type="hidden" name="mallid" value="<?php echo $mallid;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<input type="hidden" name="tixian" value="<?php echo $td['tixian'];?>"/>
<input type="hidden" name="username" value="<?php echo $td['username'];?>"/>
<div class="tt">房型信息</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">订单单号</td>
<td><?php echo $td['itemid'];?> <?php if($DT['trade']) { ?>(<?php echo $DT['trade_nm'];?>订单单号:<a href="https://lab.alipay.com/consume/queryTradeDetail.htm?tradeNo=<?php echo $td['trade_no'];?>" target="_blank" class="t"><?php echo $td['trade_no'];?></a>)<?php } ?></td>
</tr>
<tr>
<td class="tl">申请类型</td>
<td class="tr"><?php 
if($td['leixing']==1){
	echo "公积金社保卡借款";
}elseif($td['leixing']==2){
	echo "企业法人";
}elseif($td['leixing']==3){
	echo "卡帐借款";
}elseif($td['leixing']==4){
	echo "房借";
}elseif($td['leixing']==5){
	echo "车借";
}

?> </td>
</tr>

</table>

<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">申请时间</td>
<td><?php echo $td['adddate'];?></td>
</tr>
<tr>
<td class="tl">更新时间</td>
<td><?php echo $td['updatedate'];?></td>
</tr>
<tr>
<td class="tl">申请状态</td>
<td><?php echo $_status[$td['status']];?></td>
</tr>
<tr>
<td class="tl">受理结果</td>
<td id="status">
<input type="radio" name="status" value="1"/> 通过申请<br/>
<input type="radio" name="status" value="9"/> 不通过 <span id="dstatus" class="f_red"></span>
</td>
</tr>
<tr>
<td class="tl">操作理由</td>
<td>
<textarea name="content" id="content" class="dsn"></textarea>
<?php echo deditor($moduleid, 'content', 'Simple', '100%', 200);?>
<br/>请谨慎填写，一经提交将不可更改 <span id="dcontent" class="f_red"></span>
</td>
</tr>
<tr>
<td class="tl">通知双方</td>
<td>
<input type="checkbox" name="msg" id="msg" value="1" onclick="Dn();" checked/><label for="msg"> 站内通知</label>
<input type="checkbox" name="eml" id="eml" value="1" onclick="Dn();"/><label for="eml"> 邮件通知</label>
<input type="checkbox" name="sms" id="sms" value="1" onclick="Dn();"/><label for="sms"> 短信通知</label>
<input type="checkbox" name="wec" id="wec" value="1" onclick="Dn();"/><label for="wec"> 微信通知</label>
</td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/></div>
</form>
<script type="text/javascript">
function check() {
	var l;
	l = checked_count('status');
	if(l == 0) {
		Dmsg('请选择受理结果', 'status');
		return false;
	}
	l = FCKLen();
	if(l < 5) {
		Dmsg('操作理由不能少于5个字，当前已输入'+l+'个字', 'content');
		return false;
	}
	return confirm('确定要进行此操作吗？提交后将不可恢复');
}
</script>
<script type="text/javascript">Menuon(1);</script>
<?php include tpl('footer');?>