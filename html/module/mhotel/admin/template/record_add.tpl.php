<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form method="post" action="?" id="dform" onsubmit="return check();">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<div class="tt"><?php echo $DT['money_name'];?>增减</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><span class="f_red">*</span> 用户名</td>
<td><textarea name="username" id="username" style="width:200px;height:100px;overflow:visible;"><?php echo $username;?></textarea><?php tips('允许批量添加，一行一个，点回车换行');?><br/><span id="dusername" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 类型</td>
<td>
<input name="type" type="radio" value="1" checked/> 收入&nbsp;&nbsp;&nbsp;&nbsp;
<input name="type" type="radio" value="0"/> 支出
</td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 金额</td>
<td><input name="amount" id="amount" type="text" size="10"/> <?php echo $DT['money_unit'];?> <span id="damount" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 支付方式</td>
<td>
<select name="bank" id="bank">
<option value="">请选择</option>
<?php
foreach($BANKS as $v) {
	echo '<option value="'.$v.'">'.$v.'</option>';
}
?>
<option value="其他">其他</option>
</select> <span id="dbank" class="f_red"></span>
</td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 事由</td>
<td><input name="reason" id="reason" type="text" size="40" value="现金"/> <span id="dreason" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 备注</td>
<td><input name="note" type="text" size="40" value="手工"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 注意</td>
<td class="f_red">此表单一经提交，将不可再修改或删除，请务必谨慎操作</td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<script type="text/javascript">
function check() {
	var l;
	var f;
	f = 'username';
	l = Dd(f).value.length;
	if(l < 3) {
		Dmsg('请填写用户名', f);
		return false;
	}
	f = 'amount';
	l = Dd(f).value;
	if(l == '') {
		Dmsg('请填写金额', f);
		return false;
	}
	f = 'bank';
	l = Dd(f).value;
	if(l == '') {
		Dmsg('请选择支付方式', f);
		return false;
	}
	f = 'reason';
	l = Dd(f).value.length;
	if(l < 2) {
		Dmsg('请填写事由', f);
		return false;
	}
	return true;
}
</script>
<script type="text/javascript">Menuon(0);</script>
<?php include tpl('footer');?>