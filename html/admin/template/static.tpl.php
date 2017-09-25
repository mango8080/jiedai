<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
?>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td style="padding:6px 10px 6px 10px;">
通过静态文件分离部署功能，可以将网站的静态文件部署到独立的服务器，从而减轻主站的压力和提高主站访问速度。<br/>
例如静态文件所在服务器绑定的域名为static.idc580.cn，请在部署地址处填写http://static.idc580.cn/，然后上传网站的静态文件至static.idc580.cn所在的站点目录。<br/>
<?php if($itemid) { ?>
静态文件已经整理到站点<span class="f_red">file/static</span>目录，请将static目录下的所有文件上传到静态文件服务器的站点目录。
<?php } else { ?>
<a href="?file=<?php echo $file;?>&action=static&itemid=1" class="t">点这里整理需要分离的静态文件&raquo;</a>
<?php } ?>
</td>
</tr>
</table>
<?php include tpl('footer');?>