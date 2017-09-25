<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header');?>
      
     
<script type="text/javascript" src="/lang/zh-cn/lang.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/common.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/calendar.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/fixdiv.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/address.js"></script>
<script src="<?php echo DT_STATIC;?>file/script/jquery-1.8.2.min.js"></script>
<script>
var move=$("#ad");
var x=0;
var y=0;
var xs=2;
var ys=2;
function go(){
x+=xs;
y+=ys;
if (x>=$(window).width()-265||x<0) {
xs=-1*xs;

}
if (y>=$(document).height()-160||y<0) {
ys=-1*ys;

}
move.offset({top:y,left:x});
}
var timer=setInterval("go()",100);
move.hover(function(){
clearInterval(timer);
},function(){
timer=setInterval("go()",100)
})
</script>
<script type="text/javascript">
var browser=navigator.appName
var b_version=navigator.appVersion
var version=b_version.split(";");
var trim_Version=version[1].replace(/[ ]/g,"");
if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE6.0"){
if(confirm('您的浏览器版本过低，是否升级至IE8？')){
location.href="app/IE8.exe";
}
}else if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE7.0"){
if(confirm('您的浏览器版本过低，是否升级至IE8？')){
location.href="app/IE8.exe";
}
}
</script>
<?php include template('footer');?>      