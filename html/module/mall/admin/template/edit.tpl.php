<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<style type="text/css">
	ime-mode: disabled;
</style>
<form method="post" action="?" id="dform" onsubmit="return check();">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<input type="hidden" name="post[mycatid]" value="<?php echo $mycatid;?>"/>
<div class="tt"><?php echo $action == 'add' ? '添加' : '修改';?>借款类型</div>
<table cellpadding="2" cellspacing="1" class="tb">

<tr>
<td class="tl"><span class="f_red">*</span> 房型分类</td>
<td><div id="catesch"></div><?php echo ajax_category_select('post[catid]', '选择分类', $catid, $moduleid, 'size="2" style="height:120px;width:180px;"');?>
<br/> <span id="dcatid" class="f_red"></span></td>
</tr>

<tr>
<td class="tl"><span class="f_red">*</span> 房型名称</td>
<td><input name="post[title]" type="text" id="title" size="60" value="<?php echo $title;?>" readonly="readonly" />  <span id="dtitle" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 房型价格</td>
<td>
<input name="post[price]" type="text" id="title" size="60" value="<?php echo $price;?>" readonly="readonly"/>
</td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 最高价格</td>
<td>
<input name="post[hiprice]" type="text" id="hiprice" size="60" value="<?php echo $hiprice;?>" readonly="readonly"/>
</td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 假日调整最高价格</td>
<td>
<input name="post[shiprice]" type="text" id="shiprice" size="60" value="<?php echo $shiprice;?>" readonly="readonly"/>
</td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 调价时间段</td>
<td>
从<input name="post[shifromdate]" type="text" id="shifromdate" size="20" value="<?php echo timetodate($shifromdate,0);?>" readonly="readonly"/> 到<input name="post[shitodate]" type="text" id="shitodate" size="20" value="<?php echo timetodate($shitodate,0);?>" readonly="readonly"/>
</td>
</tr>

<tr>
<td class="tl"><span class="f_red">*</span> 房型库存</td>
<td><input name="post[amount]" type="text" size="10" value="<?php echo $amount;?>" id="amount" readonly="readonly"/> <input name="post[unit]" type="text" size="2" value="<?php echo $unit;?>" id="unit" title="计量单位" readonly="readonly"/> <span id="damount" class="f_red"></span></td>
</tr>

<?php if($CP) { ?>
<script type="text/javascript">
var property_catid = <?php echo $catid;?>;
var property_itemid = <?php echo $itemid;?>;
var property_admin = 1;
</script>
<script type="text/javascript" src="<?php echo DT_PATH;?>file/script/property.js"></script>
<tbody id="load_property" style="display:none;">
<tr><td></td><td></td></tr>
</tbody>
<?php } ?>
<?php echo $FD ? fields_html('<td class="tl">', '<td>', $item) : '';?>
<tr>
<td class="tl"><span class="f_red">*</span> 房型图片</td>
<td>
	<input type="hidden" name="post[thumb]" id="thumb" value="<?php echo $thumb;?>"/>
	<input type="hidden" name="post[thumb1]" id="thumb1" value="<?php echo $thumb1;?>"/>
	<input type="hidden" name="post[thumb2]" id="thumb2" value="<?php echo $thumb2;?>"/>
	<table width="360">
	<tr align="center" height="120" class="c_p">
	<td width="120"><img src="<?php echo $thumb ? $thumb : DT_SKIN.'image/waitpic.gif';?>" width="100" height="100" id="showthumb" title="预览图片" alt="" onclick="if(this.src.indexOf('waitpic.gif') == -1){_preview(Dd('showthumb').src, 1);}else{Dalbum('',<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, Dd('thumb').value, true);}"/></td>
	<td width="120"><img src="<?php echo $thumb1 ? $thumb1 : DT_SKIN.'image/waitpic.gif';?>" width="100" height="100" id="showthumb1" title="预览图片" alt="" onclick="if(this.src.indexOf('waitpic.gif') == -1){_preview(Dd('showthumb1').src, 1);}else{Dalbum(1,<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, Dd('thumb1').value, true);}"/></td>
	<td width="120"><img src="<?php echo $thumb2 ? $thumb2 : DT_SKIN.'image/waitpic.gif';?>" width="100" height="100" id="showthumb2" title="预览图片" alt="" onclick="if(this.src.indexOf('waitpic.gif') == -1){_preview(Dd('showthumb2').src, 1);}else{Dalbum(2,<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, Dd('thumb2').value, true);}"/></td>
	</tr>
	
	</table>
	<span id="dthumb" class="f_red"></span>
</td>
</tr>

<tr>
<td class="tl"><span class="f_red">*</span> 房型详情</td>
<td><textarea name="post[content]" id="content" class="dsn" readonly="readonly"><?php echo $content;?></textarea>
<?php echo deditor($moduleid, 'content', $MOD['editor'], '100%', 350);?><br/><span id="dcontent" class="f_red"></span>
</td>
</tr>



<tr>
<td class="tl"><span class="f_red">*</span> 用户名</td>
<td><input name="post[username]" type="text"  size="20" value="<?php echo $username;?>" id="username" readonly="readonly"/> <a href="javascript:_user(Dd('username').value);" class="t">[资料]</a> <span id="dusername" class="f_red"></span></td>
</tr>


<tr>
<td class="tl"><span class="f_hid">*</span> 信息状态</td>
<td>
<input type="radio" name="post[status]" value="3" <?php if($status == 3) echo 'checked';?>/> 通过
<input type="radio" name="post[status]" value="2" <?php if($status == 2) echo 'checked';?>/> 待审
<input type="radio" name="post[status]" value="1" <?php if($status == 1) echo 'checked';?> onclick="if(this.checked) Dd('note').style.display='';"/> 拒绝
<input type="radio" name="post[status]" value="4" <?php if($status == 4) echo 'checked';?>/> 下架
<input type="radio" name="post[status]" value="0" <?php if($status == 0) echo 'checked';?>/> 删除
</td>
</tr>
<tr id="note" style="display:<?php echo $status==1 ? '' : 'none';?>">
<td class="tl"><span class="f_red">*</span> 拒绝理由</td>
<td><input name="post[note]" type="text"  size="40" value="<?php echo $note;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 添加时间</td>
<td><input type="text" size="22" name="post[addtime]" value="<?php echo $addtime;?>" readonly="readonly"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 浏览次数</td>
<td><input name="post[hits]" type="text" size="10" value="<?php echo $hits;?>" readonly="readonly"/></td>
</tr>

</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<?php load('clear.js'); ?>
<?php if($action == 'add') { ?>
<form method="post" action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>


</form>
<?php } ?>
<script type="text/javascript">
function _p() {
	if(Dd('tag').value) {
		Ds('reccate');
	}
}
function check() {
	var l;
	var f;
	f = 'catid_1';
	if(Dd(f).value == 0) {
		Dmsg('请选择房型分类', 'catid', 1);
		return false;
	}
	f = 'title';
	l = Dd(f).value.length;
	if(l < 2) {
		Dmsg('房型名称最少2字，当前已输入'+l+'字', f);
		return false;
	}
	f = 'amount';
	l = Dd(f).value;
	if(l < 1) {
		Dmsg('请填写库存', f);
		return false;
	}
	f = 'thumb';
	l = Dd(f).value.length;
	if(l < 5) {
		Dmsg('请上传第一张房型图片', f, 1);
		return false;
	}
	f = 'content';
	l = FCKLen();
	if(l < 5) {
		Dmsg('详细说明最少5字，当前已输入'+l+'字', f);
		return false;
	}
	f = 'username';
	l = Dd(f).value.length;
	if(l < 2) {
		Dmsg('请填写用户名', f);
		return false;
	}
	if(Dd('v1').value) {
		if(!Dd('n1').value) {
			alert('请填写属性名称');
			Dd('n1').focus();
			return false;
		}
		if(Dd('v1').value.indexOf('|') == -1) {
			alert(Dd('n1').value+'至少需要两个属性');
			Dd('v1').focus();
			return false;
		}
	}
	if(Dd('v2').value) {
		if(!Dd('n2').value) {
			alert('请填写属性名称');
			Dd('n2').focus();
			return false;
		}
		if(Dd('v2').value.indexOf('|') == -1) {
			alert(Dd('n2').value+'至少需要两个属性');
			Dd('v2').focus();
			return false;
		}
	}
	if(Dd('v3').value) {
		if(!Dd('n3').value) {
			alert('请填写属性名称');
			Dd('n3').focus();
			return false;
		}
		if(Dd('v3').value.indexOf('|') == -1) {
			alert(Dd('n3').value+'至少需要两个属性');
			Dd('v3').focus();
			return false;
		}
	}
	if(Dd('n1').value && (Dd('n1').value == Dd('n2').value || Dd('n1').value == Dd('n3').value)) {
		alert('属性名称不能重复');
		return false;
	}
	if(Dd('n2').value && (Dd('n2').value == Dd('n1').value || Dd('n2').value == Dd('n3').value)) {
		alert('属性名称不能重复');
		return false;
	}
	if(Dd('n3').value && (Dd('n3').value == Dd('n1').value || Dd('n3').value == Dd('n2').value)) {
		alert('属性名称不能重复');
		return false;
	}
	if(Dd('express_name_1').value && (Dd('express_name_1').value == Dd('express_name_2').value || Dd('express_name_1').value == Dd('express_name_3').value)) {
		alert('快递名称不能重复');
		return false;
	}
	if(Dd('express_name_2').value && (Dd('express_name_2').value == Dd('express_name_1').value || Dd('express_name_2').value == Dd('express_name_3').value)) {
		alert('快递名称不能重复');
		return false;
	}
	if(Dd('express_name_3').value && (Dd('express_name_3').value == Dd('express_name_1').value || Dd('express_name_3').value == Dd('express_name_2').value)) {
		alert('快递名称不能重复');
		return false;
	}	
	<?php echo $FD ? fields_js() : '';?>
	<?php echo $CP ? property_js() : '';?>
	return Dstep();
}
function Dexpress(i, s) {
	if(Dd('express_'+i).value > 0) {
		var t1 = s.split('[');
		var t2 = t1[1].split(',');
		Dd('express_name_'+i).value = t2[0];
		Dd('fee_start_'+i).value = t2[1];
		Dd('fee_step_'+i).value = t2[2];
	} else {
		Dd('express_name_'+i).value = '';
		Dd('fee_start_'+i).value = '';
		Dd('fee_step_'+i).value = '';
	}
}

function Nexpress(i, s) {
	Dd('express_name_1').value = s;
	Dd('fee_start_1').value = i;
	Dd('fee_step_1').value = '0.00';
	$('#express_1').val(0);
	Dd('express_name_2').value = '';
	Dd('fee_start_2').value = '0.00';
	Dd('fee_step_2').value = '0.00';
	$('#express_2').val(0);
	Dd('express_name_3').value = '';
	Dd('fee_start_3').value = '0.00';
	Dd('fee_step_3').value = '0.00';
	$('#express_3').val(0);
}

function Dstep() {
	Dd('p_a_1').innerHTML=Dd('p_p_1').innerHTML=Dd('p_a_2').innerHTML=Dd('p_p_2').innerHTML=Dd('p_a_3').innerHTML=Dd('p_p_3').innerHTML='';
	var a1 = parseInt(Dd('a1').value);
	var p1 = parseFloat(Dd('p1').value);
	var a2 = parseInt(Dd('a2').value);
	var p2 = parseFloat(Dd('p2').value);
	var a3 = parseInt(Dd('a3').value);
	var p3 = parseFloat(Dd('p3').value);
	var u = Dd('unit').value;
	if(u.length < 1) Dd('unit').value = u = '件';
	var m = '<?php echo $DT['money_unit'];?>';
	if(!a1 || a1 < 1) {
		alert('起订量必须大于0');
		Dd('a1').value = '1';
		Dd('a1').focus();
		return false;
	}
	if(!p1 || p1 < 0.1) {
		alert('请填写房型价格');
		Dd('p1').value = '';
		Dd('p1').focus();
		return false;
	}
	Dd('p_a_1').innerHTML = a1+u+'以上';
	Dd('p_p_1').innerHTML = p1+m+'/'+u;
	if(a2 > 1 && p2 > 0.01) {
		if(a2 <= a1) {
			alert('数量必须大于'+a1);
			Dd('a2').value = '';
			Dd('a2').focus();
			return false;
		}
		if(p2 >= p1) {
			alert('价格必须小于'+p1);
			Dd('p2').value = '';
			Dd('p2').focus();
			return false;
		}
		Dd('p_a_1').innerHTML = a1+'-'+a2+u;
		Dd('p_p_1').innerHTML = p1+m+'/'+u;
		Dd('p_a_2').innerHTML = '>'+a2+u;
		Dd('p_p_2').innerHTML = p2+m+'/'+u;
	}
	if(a3 > 1 && p3 > 0.01) {
		if(a3 <= a2) {
			alert('数量必须大于'+a2);
			Dd('a3').value = '';
			Dd('a3').focus();
			return false;
		}
		if(p3 >= p2) {
			alert('价格必须小于'+p2);
			Dd('p3').value = '';
			Dd('p3').focus();
			return false;
		}
		Dd('p_a_2').innerHTML = (a2+1)+'-'+a3+u;
		Dd('p_p_2').innerHTML = p2+m+'/'+u;
		Dd('p_a_3').innerHTML = '>'+a3+u;
		Dd('p_p_3').innerHTML = p3+m+'/'+u;
	}
	return true;
}
</script>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>