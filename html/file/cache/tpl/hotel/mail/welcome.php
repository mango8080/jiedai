<?php defined('IN_DESTOON') or exit('Access Denied');?><table cellpadding="0" cellspacing="0" width="700" align="center">
<tr>
<td></td>
</tr>
<tr>
<td style="border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:'Microsoft YaHei',Verdana,Arial;font-size:14px;color:#333333;">
尊敬的用户：<br/>
恭喜您成功注册成为<?php echo $DT['sitename'];?>用户！<br/>
以下为您的用户帐号信息：<br/>
<strong>户名：</strong><?php echo $username;?><br/>
<strong>密码：</strong><?php if(isset($post['password'])) { ?><?php echo $post['password'];?><?php } else { ?><i>已加密</i> (如果您忘记了密码，<a href="<?php echo $MODULE['2']['linkurl'];?>send.php" target="_blank" style="color:#005590;">请点这里找回</a>)<?php } ?>
<br/>
请您妥善保存，切勿告诉他人。<br/>
如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>
</td>
</tr>
<tr>
<td style="line-height:22px;padding:10px 0;font-family:'Microsoft YaHei',Verdana,Arial;font-size:12px;color:#666666;">
请注意：此邮件系 <a href="<?php echo DT_PATH;?>" target="_blank" style="color:#005590;"><?php echo $DT['sitename'];?></a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除
</td>
</tr>
</table>