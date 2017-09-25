<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div class="tt">用户信息</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">用户名</td>
<td>&nbsp;<a href="javascript:_user('<?php echo $U['username'];?>');"><?php echo $U['username'];?></a></td>
<td class="tl">公司名</td>
<td>&nbsp;<a href="<?php echo $U['linkurl'];?>" target="_blank"><?php echo $U['company'];?></a></td>
</tr>
</table>
<form method="post" action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="username" value="<?php echo $username;?>"/>
<div class="tt">修改详情</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25">通过</th>
<th width="120">项目</th>
<th width="40%">修改前</th>
<th width="40%">修改为</th>
</tr>
<?php if(isset($E['thumb'])) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';">
<td align="center"><input type="checkbox" name="pass[]" value="thumb" checked/></td>
<td align="center">形象图片</td>
<td><img src="<?php echo imgurl($U['thumb']);?>" width="80"/></td>
<td><img src="<?php echo imgurl($E['thumb']);?>" width="80"/></td>
</tr>
<?php }?>
<?php if(isset($E['areaid'])) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';">
<td align="center"><input type="checkbox" name="pass[]" value="areaid" checked/></td>
<td align="center">所在地区</td>
<td><?php echo area_pos($U['areaid'], ' / ');?></td>
<td><?php echo area_pos($E['areaid'], ' / ');?></td>
</tr>
<?php }?> 
<?php if(isset($E['type'])) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';">
<td align="center"><input type="checkbox" name="pass[]" value="type" checked/></td>
<td align="center">公司类型</td>
<td><?php echo $U['type'];?></td>
<td><?php echo $E['type'];?></td>
</tr>
<?php }?>
<?php if(isset($E['business'])) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';">
<td align="center"><input type="checkbox" name="pass[]" value="business" checked/></td>
<td align="center">经营范围</td>
<td><?php echo $U['business'];?></td>
<td><?php echo $E['business'];?></td>
</tr>
<?php }?>
<?php if(isset($E['regyear'])) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';">
<td align="center"><input type="checkbox" name="pass[]" value="regyear" checked/></td>
<td align="center">成立年份</td>
<td><?php echo $U['regyear'];?></td>
<td><?php echo $E['regyear'];?></td>
</tr>
<?php }?>
<?php if(isset($E['capital']) || isset($E['regunit'])) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';">
<td align="center"><input type="checkbox" name="pass[]" value="capital" checked/></td>
<td align="center">注册资本</td>
<td><?php echo $U['capital'];?> <?php echo isset($E['regunit']) ? $U['regunit'] : '';?></td>
<td><?php echo $E['capital'];?> <?php echo isset($E['regunit']) ? $E['regunit'] : '';?></td>
</tr>
<?php }?>
<?php if(isset($E['address'])) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';">
<td align="center"><input type="checkbox" name="pass[]" value="address" checked/></td>
<td align="center">公司地址</td>
<td><?php echo $U['address'];?></td>
<td><?php echo $E['address'];?></td>
</tr>
<?php }?>
<?php if(isset($E['telephone'])) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';">
<td align="center"><input type="checkbox" name="pass[]" value="telephone" checked/></td>
<td align="center">联系电话</td>
<td><?php echo $U['telephone'];?></td>
<td><?php echo $E['telephone'];?></td>
</tr>
<?php }?>
<?php if(isset($E['content'])) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';">
<td align="center"><input type="checkbox" name="pass[]" value="content" checked/></td>
<td align="center">公司介绍</td>
<td valign="top"><?php echo $U['content'];?></td>
<td valign="top"><?php echo $E['content'];?></td>
</tr>
<?php }?>
</table>
<table>
<tr>
<td>
&nbsp;<textarea style="width:300px;height:16px;" name="reason" id="reason" onfocus="if(this.value=='操作原因')this.value='';"/>操作原因</textarea> 
</td>
<td>
<input type="checkbox" name="msg" id="msg" value="1" onclick="Dn();" checked/><label for="msg"> 站内通知</label>
<input type="checkbox" name="eml" id="eml" value="1" onclick="Dn();"/><label for="eml"> 邮件通知</label>
<input type="checkbox" name="sms" id="sms" value="1" onclick="Dn();"/><label for="sms"> 短信通知</label>
<input type="checkbox" name="wec" id="wec" value="1" onclick="Dn();"/><label for="wec"> 微信通知</label>
</td>
</tr>
</table>
<div class="btns">
<input type="submit" name="submit" value=" 确 定 " class="btn"/>
</div>
</form>
<script type="text/javascript">Menuon(0);</script>
<?php include tpl('footer');?>