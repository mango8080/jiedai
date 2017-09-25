<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
if(!$id) show_menu($menus);
?>
<div class="tt">房型信息</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">订单单号</td>
<td><?php echo $td['itemid'];?> (对外单号:<?php echo $td['ordercode'];?>)</td>
</tr>
<tr>
<td class="tl">申请类型</td>
<td><?php 
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
<div class="tt">客户信息</div>
<table cellpadding="2" cellspacing="1" class="tb">

<tr>
<td class="tl">姓名</td>
<td><?php echo $td['name'];?></td>
</tr>

<tr>
<td class="tl">手机</td>
<td><?php echo $td['mobile'];?></td>
</tr>
<tr>
<td class="tl">年龄</td>
<td><?php echo $td['nianling'];?></td>
</tr>
<tr>
<td class="tl">年收入</td>
<td><?php echo $td['shouru'];?></td>
</tr>
<tr>
<td class="tl">企业名称</td>
<td><?php echo $td['qiyename'];?></td>
</tr>
<tr>
<td class="tl">客户留言</td>
<td><?php echo $td['note'];?></td>
</tr>
</table>
<?php if($td['leixing']==1){?>
<div class="tt">公积金社保卡借款
</div>

<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">月缴公积金</td>
<td><?php if($td['gjj']==shi)echo "缴纳公积金";?></td>
</tr>
<tr>
<td class="tl">银行代发工资</td>
<td><?php if($td['yhdf']==shi){echo "银行代发工资";}else{echo "银行不代发工资";}?></td>
</tr>
<tr>
<td class="tl">月缴社保</td>
<td class="f_red"><?php if($td['shebao']==shi){echo "月缴社保";}else{echo "不缴社保";}?></td>
</tr>

</table>
<?php }?>
<?php if($td['leixing']==2){?>
<div class="tt">企业法人
</div>

<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">企业地址</td>
<td><?php echo $td['qiyedizhi'];?></td>
</tr>
<tr>
<td class="tl">国税</td>
<td class="f_red"><?php if($td['guoshui']==shi){echo "国税";}else{echo "没有国税";}?></td>
</tr>
<tr>
<td class="tl">地税</td>
<td class="f_red"><?php if($td['dishui']==shi){echo "地税";}else{echo "没有地税";}?></td>
</tr>
<tr>
<td class="tl">POS流水</td>
<td class="f_red"><?php if($td['pos']==shi){echo "POS流水";}else{echo "没有POS流水";}?></td>
</tr>
</table>
<?php }?>
<?php if($td['leixing']==3){?>
<div class="tt">卡帐借款
</div>

<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">信用卡邮箱</td>
<td><?php echo $td['youxiang'];?></td>
</tr>
<tr>
<td class="tl">邮箱密码</td>
<td><?php echo $td['yxmima'];?></td>
</tr>
<tr>
<td class="tl">XX银行查询网银帐号</td>
<td class="f_red"><?php echo $td['xykzh'];?></td>
</tr>
<tr>
<td class="tl">XX银行查询网银密码</td>
<td class="f_red"><?php echo $td['xykmima'];?></td>
</tr>
</table>
<?php }?>
<?php if($td['leixing']==4){?>
<div class="tt">房借
</div>

<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">房屋地址</td>
<td><?php echo $td['homewz'];?></td>
</tr>
<tr>
<td class="tl">使用年份</td>
<td><?php echo $td['carnj'];?></td>
</tr>
<tr>
<td class="tl">房屋地址/平方</td>
<td class="f_red"><?php echo $td['homedx'];?></td>
</tr>
<tr>
<td class="tl">房屋价格</td>
<td class="f_red"><?php echo $td['carprice'];?></td>
</tr>
</table>
<?php }?>
<?php if($td['leixing']==5){?>
<div class="tt">车借
</div>

<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">车牌号</td>
<td><?php echo $td['car'];?></td>
</tr>
<tr>
<td class="tl">使用年份</td>
<td><?php echo $td['carnj'];?></td>
</tr>
<tr>
<td class="tl">品牌型号</td>
<td class="f_red"><?php echo $td['carxh'];?></td>
</tr>
<tr>
<td class="tl">价格</td>
<td class="f_red"><?php echo $td['carprice'];?></td>
</tr>
</table>
<?php }?>

<div class="tt">订单状态</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">提交时间</td>
<td><?php echo $td['adddate'];?></td>
</tr>
<tr>
<td class="tl">更新时间</td>
<td><?php echo $td['updatedate'];?></td>
</tr>
<?php if($td['send_time']>0) { ?>
<tr>
<td class="tl">发货时间</td>
<td><?php echo $td['send_time'];?></td>
</tr>
<?php } ?>
<tr>
<td class="tl">交易状态</td>
<td><?php echo $_status[$td['status']];?></td>
</tr>
<?php if($td['buyer_reason']) { ?>
<tr>
<td class="tl">退款原因</td>
<td><?php echo $td['buyer_reason'];?></td>
</tr>
<?php } ?>
<?php if($td['refund_reason']) { ?>
<tr>
<td class="tl">操作原因</td>
<td><?php echo $td['refund_reason'];?></td>
</tr>
<tr>
<td class="tl">操作人</td>
<td><?php echo $td['editor'];?></td>
</tr>
<tr>
<td class="tl">操作时间</td>
<td><?php echo $td['updatetime'];?></td>
</tr>
<?php } ?>
</table>





<div id="c_edit" style="display:none;">
<div class="tt">修改评价<a name="comment"></a></div>
<form method="post" action="?" id="dform" onsubmit="return check();">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="comment"/>
<input type="hidden" name="mallid" value="<?php echo $mallid;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>

<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/></div>
</form>
</div>
<script type="text/javascript">
function check() {
	return confirm('确定要修改该订单的评论吗？');
}
</script>
<script type="text/javascript">Menuon(1);</script>
<?php include tpl('footer');?>