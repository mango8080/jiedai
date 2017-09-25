<?php defined('IN_DESTOON') or exit('Access Denied');?>
<style type="text/css">
.qr {width:140px;font-size:14px;cursor:pointer;display:none;}
.qr_li {line-height:32px;height:32px;padding-left:20px;overflow:hidden;}
.qr_on {line-height:32px;height:32px;padding-left:20px;overflow:hidden;background:#FFFFFF;border-radius:0 10px 10px 0;}
</style>
<div class="w1200">
<div class="nav">当前位置: <a href="<?php echo $MODULE['1']['linkurl'];?>">首页</a> &raquo; 手机浏览</div>
</div>
<div class="w1200">
<div style=" no-repeat;height:500px;">
<div style="padding:48px 50px 0 520px;">
<div style="line-height:22px;font-size:14px;">
<strong>功能简介：</strong><br/>您可以通过手机上网，随时随地浏览商机资讯，享用用户功能...<br/>
<br/>
<strong>访问网址：</strong><?php if($action=='device') { ?><span class="f_red">抱歉，请用手机访问</span><?php } ?>
<br/>
在手机浏览器地址栏输入：<a href="http://www.anluze.com/mobile" class="b"><?php echo $url;?></a><br/><br/>
或者用二维码扫描软件(微信、QQ等)扫描下面的二维码<br/>
</div>
<br/>
<div>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td valign="top" class="qr">
<ul>
<li class="qr_on" id="type_0" onclick="Dqr(0);"><img src="<?php echo DT_STATIC;?>file/image/qr-mobile.png" align="absmiddle"/> 手机浏览</li>
<?php if($EXT['weixin']) { ?>
<li class="qr_li" id="type_1" onclick="Dqr(1);"><img src="<?php echo DT_STATIC;?>file/image/qr-weixin.png" align="absmiddle"/> 微信关注</li>
<?php } ?>
<?php if($ios_app) { ?>
<li class="qr_li" id="type_2" onclick="Dqr(2);"><img src="<?php echo DT_STATIC;?>file/image/qr-ios.png" align="absmiddle"/> 苹果客户端</li>
<?php } ?>
<?php if($android_app) { ?>
<li class="qr_li" id="type_3" onclick="Dqr(3);"><img src="<?php echo DT_STATIC;?>file/image/qr-android.png" align="absmiddle"/> 安卓客户端</li>
<?php } ?>
</ul>
</td>
<td width="10"> </td>
<td id="qrcode-box">
<img src="/file/image/ewm.png" id="qrcode-img" width="140" height="140"/>
</td>
</tr>
</table>
</div>
</div>
</div>
</div>
<script type="text/javascript">
var tid = 0;
var qrc = [
'<?php echo DT_PATH;?>api/qrcode.png.php?auth=<?php echo urlencode($url);?>',
'<?php echo DT_PATH;?>api/weixin/qrcode.php',
'<?php echo $ios_app;?>',
'<?php echo $android_app;?>',
];
function Dqr(id) {
if(id == tid) return;
$('.qr li').each(function(i){
if($(this).attr('class') == 'qr_on') $(this).attr('class', 'qr_li');
});
$('#type_'+id).attr('class', 'qr_on');
$('#qrcode-img').fadeOut(50);
$('#qrcode-img').attr('src', qrc[id]);
$('#qrcode-img').fadeIn(200);
tid = id;
}
$(document).ready(function() {
if($('.qr li').length== 1) $('.qr').html('');
$('.qr').show('slow');
});
</script>
