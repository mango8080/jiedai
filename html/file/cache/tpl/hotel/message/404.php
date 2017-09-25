<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header');?>
<style charset="utf-8" type="text/css" class="firebugResetStyles">/* See license.txt for terms of usage */
/** reset styling **/
.firebugResetStyles {
    z-index: 2147483646 !important;
    top: 0 !important;
    left: 0 !important;
    display: block !important;
    border: 0 none !important;
    margin: 0 !important;
    padding: 0 !important;
    outline: 0 !important;
    min-width: 0 !important;
    max-width: none !important;
    min-height: 0 !important;
    max-height: none !important;
    position: fixed !important;
    transform: rotate(0deg) !important;
    transform-origin: 50% 50% !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    background: transparent none !important;
    pointer-events: none !important;
    white-space: normal !important;
}
style.firebugResetStyles {
    display: none !important;
}
.firebugBlockBackgroundColor {
    background-color: transparent !important;
}
.firebugResetStyles:before, .firebugResetStyles:after {
    content: "" !important;
}
/**actual styling to be modified by firebug theme**/
.firebugCanvas {
    display: none !important;
}
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
.firebugLayoutBox {
    width: auto !important;
    position: static !important;
}
.firebugLayoutBoxOffset {
    opacity: 0.8 !important;
    position: fixed !important;
}
.firebugLayoutLine {
    opacity: 0.4 !important;
    background-color: #000000 !important;
}
.firebugLayoutLineLeft, .firebugLayoutLineRight {
    width: 1px !important;
    height: 100% !important;
}
.firebugLayoutLineTop, .firebugLayoutLineBottom {
    width: 100% !important;
    height: 1px !important;
}
.firebugLayoutLineTop {
    margin-top: -1px !important;
    border-top: 1px solid #999999 !important;
}
.firebugLayoutLineRight {
    border-right: 1px solid #999999 !important;
}
.firebugLayoutLineBottom {
    border-bottom: 1px solid #999999 !important;
}
.firebugLayoutLineLeft {
    margin-left: -1px !important;
    border-left: 1px solid #999999 !important;
}
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
.firebugLayoutBoxParent {
    border-top: 0 none !important;
    border-right: 1px dashed #E00 !important;
    border-bottom: 1px dashed #E00 !important;
    border-left: 0 none !important;
    position: fixed !important;
    width: auto !important;
}
.firebugRuler{
    position: absolute !important;
}
.firebugRulerH {
    top: -15px !important;
    left: 0 !important;
    width: 100% !important;
    height: 14px !important;
    
    border-top: 1px solid #BBBBBB !important;
    border-right: 1px dashed #BBBBBB !important;
    border-bottom: 1px solid #000000 !important;
}
.firebugRulerV {
    top: 0 !important;
    left: -15px !important;
    width: 14px !important;
    height: 100% !important;
    
    border-left: 1px solid #BBBBBB !important;
    border-right: 1px solid #000000 !important;
    border-bottom: 1px dashed #BBBBBB !important;
}
.overflowRulerX > .firebugRulerV {
    left: 0 !important;
}
.overflowRulerY > .firebugRulerH {
    top: 0 !important;
}
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
.fbProxyElement {
    position: fixed !important;
    pointer-events: auto !important;
}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo DT_SKIN;?>404error.css"/>
<div class="wrapper">
      
    <div class="base_main">
        <div class="error_icon horizantal"></div><!--
        --><div class="error_info_box horizantal">
            <div class="error_title yahei">抱歉，出现错误啦！</div>
            <div class="erroe_head_text yahei">您请求地址不能访问，最有可能的原因是：</div>
            <div class="yahei">网址在某种程度上是输入错误的。请尝试以下操作：</div>
            <div class="operation_box">
                <a class="return_homepage_btn horizantal yahei" href="/" title="访问首页">
                    访问首页
                </a><!--
                -->
                <a onclick="history.go(-1);" title="返回上一步">
                    <div class="return_super_level_btn horizantal yahei">
                        返回上一步
                   </div>
                </a>
            </div>
           
        </div><!--
        -->
        <!--
-->
    </div>
        
</div>
<?php include template('footer');?>