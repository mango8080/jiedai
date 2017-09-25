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
<td class="tl">外部订单号</td>
<td><?php echo $td['outconfnum'];?> </td>
</tr>
<tr>
<td class="tl">房型名称</td>
<td class="tr"><?php echo $td['title'];?></td>
</tr>
<tr>
<td class="tl">房型图片</td>
<td class="tr"><img src="<?php if($td['thumb']) { ?><?php echo $td['thumb'];?><?php } else { ?><?php echo DT_SKIN;?>image/nopic60.gif<?php } ?>" width="60" height="60"/></td>
</tr>

<tr>
<td class="tl">酒店</td>
<td><?php if($DT['im_web']) { ?><?php echo im_web($td['seller']);?>&nbsp;<?php } ?><a href="javascript:_user('<?php echo $td['seller'];?>');" class="t"><?php echo $td['seller'];?></a></td>
</tr>
<tr>
<td class="tl">客户</td>
<td><?php if($DT['im_web']) { ?><?php echo im_web($td['buyer']);?>&nbsp;<?php } ?><a href="javascript:_user('<?php echo $td['buyer'];?>');" class="t"><?php echo $td['buyer'];?></a></td>
</tr>
</table>
<div class="tt">客户信息</div>
<table cellpadding="2" cellspacing="1" class="tb">

<tr>
<td class="tl">姓名</td>
<td><?php echo $td['buyer_name'];?></td>
</tr>

<tr>
<td class="tl">手机</td>
<td><?php echo $td['buyer_mobile'];?></td>
</tr>

<tr>
<td class="tl">客户留言</td>
<td><?php echo $td['note'];?></td>
</tr>
</table>
<div class="tt">价格信息</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">单价</td>
<td><?php echo $DT['money_sign'];?><?php echo $td['price'];?></td>
</tr>
<tr>
<td class="tl">数量</td>
<td><?php echo $td['number'];?></td>
</tr>
<?php if($td['fee']>0) { ?>
<tr>
<td class="tl"><?php echo $td['fee_name'];?></td>
<td><?php echo $DT['money_sign'];?><?php echo $td['fee'];?></td>
</tr>
<?php } ?>
<tr>
<td class="tl">总额</td>
<td class="f_red"><?php echo $DT['money_sign'];?><?php echo $td['money'];?></td>
</tr>
</table>
<div class="tt">订单状态</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">下单时间</td>
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

<div class="tt">客户评价<a name="comment1"></a></div>
<table cellpadding="2" cellspacing="1" class="tb">
<?php if($cm['seller_star']) { ?>
<tr>
<td class="tl">客户评分</td>
<td>
<span class="f_r"><a href="#comment" onclick="Ds('c_edit');" class="t">[修改]</a></span>
<img src="<?php echo DT_PATH;?>file/image/star<?php echo $cm['seller_star'];?>.gif" width="36" height="12" alt="" align="absmiddle"/> <?php echo $STARS[$cm['seller_star']];?>
</td>
</tr>
<tr>
<td class="tl">客户评论</td>
<td><?php echo nl2br($cm['seller_comment']);?></td>
</tr>
<tr>
<td class="tl">评论时间</td>
<td class="px11"><?php echo timetodate($cm['seller_ctime'], 6);?></td>
</tr>
<?php if($cm['buyer_reply']) { ?>
<tr>
<td class="tl">酒店解释</td>
<td style="color:#D9251D;"><?php echo nl2br($cm['buyer_reply']);?></td>
</tr>
<tr>
<td class="tl">解释时间</td>
<td class="px11"><?php echo timetodate($cm['buyer_rtime'], 6);?></td>
</tr>
<?php } ?>
<?php } else { ?>
<tr>
<td class="tl">客户评论</td>
<td>暂未评论</td>
</tr>
<?php } ?>
</table>

<div class="tt">酒店评价<a name="comment2"></a></div>
<table cellpadding="2" cellspacing="1" class="tb">
<?php if($cm['buyer_star']) { ?>
<tr>
<td class="tl">酒店评分</td>
<td>
<span class="f_r"><a href="#comment" onclick="Ds('c_edit');" class="t">[修改]</a></span>
<img src="<?php echo DT_PATH;?>file/image/star<?php echo $cm['buyer_star'];?>.gif" width="36" height="12" alt="" align="absmiddle"/> <?php echo $STARS[$cm['buyer_star']];?>
</td>
</tr>
<tr>
<td class="tl">酒店评论</td>
<td><?php echo nl2br($cm['buyer_comment']);?></td>
</tr>
<tr>
<td class="tl">评论时间</td>
<td class="px11"><?php echo timetodate($cm['buyer_ctime'], 6);?></td>
</tr>
<?php if($cm['seller_reply']) { ?>
<tr>
<td class="tl">客户解释</td>
<td style="color:#D9251D;"><?php echo nl2br($cm['seller_reply']);?></td>
</tr>
<tr>
<td class="tl">解释时间</td>
<td class="px11"><?php echo timetodate($cm['seller_rtime'], 6);?></td>
</tr>
<?php } ?>
<?php } else { ?>
<tr>
<td class="tl">酒店评论</td>
<td>暂未评论</td>
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
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">客户评分</td>
<td>
<input type="radio" name="post[seller_star]" value="3"<?php echo $cm['seller_star'] == 3 ? ' checked' : '';?>/> 好评 
<input type="radio" name="post[seller_star]" value="2"<?php echo $cm['seller_star'] == 2 ? ' checked' : '';?>/> 中评 
<input type="radio" name="post[seller_star]" value="1"<?php echo $cm['seller_star'] == 1 ? ' checked' : '';?>/> 差评 
<input type="radio" name="post[seller_star]" value="0"<?php echo $cm['seller_star'] == 0 ? ' checked' : '';?>/> 待评
</td>
</tr>
<tr>
<td class="tl">客户评论</td>
<td><textarea name="post[seller_comment]" style="width:300px;height:60px;"><?php echo $cm['seller_comment'];?></textarea></td>
</tr>
<tr>
<td class="tl">评论时间</td>
<td><input type="text" style="width:150px;" name="post[seller_ctime]" value="<?php echo $cm['seller_ctime'] ? timetodate($cm['seller_ctime'], 6) : '';?>"/></td>
</tr>
<tr>
<td class="tl">酒店解释</td>
<td><textarea name="post[buyer_reply]" style="width:300px;height:60px;"><?php echo $cm['buyer_reply'];?></textarea></td>
</tr>
<tr>
<td class="tl">解释时间</td>
<td><input type="text" style="width:150px;" name="post[buyer_rtime]" value="<?php echo $cm['buyer_rtime'] ? timetodate($cm['buyer_rtime'], 6) : '';?>"/></td>
</tr>

<tr>
<td class="tl">酒店评分</td>
<td>
<input type="radio" name="post[buyer_star]" value="3"<?php echo $cm['buyer_star'] == 3 ? ' checked' : '';?>/> 好评 
<input type="radio" name="post[buyer_star]" value="2"<?php echo $cm['buyer_star'] == 2 ? ' checked' : '';?>/> 中评 
<input type="radio" name="post[buyer_star]" value="1"<?php echo $cm['buyer_star'] == 1 ? ' checked' : '';?>/> 差评 
<input type="radio" name="post[buyer_star]" value="0"<?php echo $cm['buyer_star'] == 0 ? ' checked' : '';?>/> 待评
</td>
</tr>
<tr>
<td class="tl">酒店评论</td>
<td><textarea name="post[buyer_comment]" style="width:300px;height:60px;"><?php echo $cm['buyer_comment'];?></textarea></td>
</tr>
<tr>
<td class="tl">评论时间</td>
<td><input type="text" style="width:150px;" name="post[buyer_ctime]" value="<?php echo $cm['buyer_ctime'] ? timetodate($cm['buyer_ctime'], 6) : '';?>"/></td>
</tr>
<tr>
<td class="tl">客户解释</td>
<td><textarea name="post[seller_reply]" style="width:300px;height:60px;"><?php echo $cm['seller_reply'];?></textarea></td>
</tr>
<tr>
<td class="tl">解释时间</td>
<td><input type="text" style="width:150px;" name="post[seller_rtime]" value="<?php echo $cm['seller_rtime'] ? timetodate($cm['seller_rtime'], 6) : '';?>"/></td>
</tr>
</table>
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