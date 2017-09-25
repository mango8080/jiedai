 <?php
  if($_userid){
    $url = "../login.php";  
    header( "Location: $url" ); 
  }
  ?>
<!DOCTYPE html>
<!-- saved from url=(0019)https://m.panda.tv/ -->
<html lang="zh-cmn-Hans" data-dpr="1" max-width="640" style="font-size: 40px;">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="hotcss" content="initial-dpr=1;max-width=640">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
  <!-- 图标 -->
  <link rel="shortcut icon" type="image/x-icon" href="">
  <!-- 初始化 -->
  <link rel="stylesheet" href="css/general.css">
  <script>
  (function(window, document) {
      'use strict';
      var hotcss = {};
      (function() {
          var viewportEl = document.querySelector('meta[name="viewport"]'),
              hotcssEl = document.querySelector('meta[name="hotcss"]'),
              dpr = window.devicePixelRatio || 1,
              maxWidth = 540,
              designWidth = 0;
          dpr = dpr >= 3 ? 3 : (dpr >= 2 ? 2 : 1);
          if (hotcssEl) {
              var hotcssCon = hotcssEl.getAttribute('content');
              if (hotcssCon) {
                  var initialDprMatch = hotcssCon.match(/initial\-dpr=([\d\.]+)/);
                  if (initialDprMatch) {
                      dpr = parseFloat(initialDprMatch[1]);
                  }
                  var maxWidthMatch = hotcssCon.match(/max\-width=([\d\.]+)/);
                  if (maxWidthMatch) {
                      maxWidth = parseFloat(maxWidthMatch[1]);
                  }
                  var designWidthMatch = hotcssCon.match(/design\-width=([\d\.]+)/);
                  if (designWidthMatch) {
                      designWidth = parseFloat(designWidthMatch[1]);
                  }
              }
          }
          document.documentElement.setAttribute('data-dpr', dpr);
          hotcss.dpr = dpr;
          document.documentElement.setAttribute('max-width', maxWidth);
          hotcss.maxWidth = maxWidth;
          if (designWidth) {
              document.documentElement.setAttribute('design-width', designWidth);
          }
          hotcss.designWidth = designWidth;
          var scale = 1 / dpr,
              content = 'width=device-width, initial-scale=' + scale + ', minimum-scale=' + scale + ', maximum-scale=' + scale + ', user-scalable=no';
          if (viewportEl) {
              viewportEl.setAttribute('content', content);
          } else {
              viewportEl = document.createElement('meta');
              viewportEl.setAttribute('name', 'viewport');
              viewportEl.setAttribute('content', content);
              document.head.appendChild(viewportEl);
          }
      })();
      hotcss.px2rem = function(px, designWidth) {
          if (!designWidth) {
              designWidth = parseInt(hotcss.designWidth, 10);
          }
          return parseInt(px, 10) * 320 / designWidth / 20;
      }
      hotcss.rem2px = function(rem, designWidth) {
          if (!designWidth) {
              designWidth = parseInt(hotcss.designWidth, 10);
          }
          return rem * 20 * designWidth / 320;
      }
      hotcss.mresize = function() {
          var innerWidth = document.documentElement.getBoundingClientRect().width || window.innerWidth;
          if (hotcss.maxWidth && (innerWidth / hotcss.dpr > hotcss.maxWidth)) {
              innerWidth = hotcss.maxWidth * hotcss.dpr;
          }
          if (!innerWidth) {
              return false;
          }
          document.documentElement.style.fontSize = (innerWidth * 20 / 320) + 'px';
          hotcss.callback && hotcss.callback();
      };
      hotcss.mresize();
      window.addEventListener('resize', function() {
          clearTimeout(hotcss.tid);
          hotcss.tid = setTimeout(hotcss.mresize, 33);
      }, false);
      window.addEventListener('load', hotcss.mresize, false);
      setTimeout(function() {
          hotcss.mresize();
      }, 333)
      window.hotcss = hotcss;
  })(window, document);
  </script>
  <title></title>
  <!-- index样式 -->
  <link rel="stylesheet" href="css/index.css">
</head>

<body>
  <!-- header 开始 -->
  <!-- <div id="header"></div> -->
  <!-- header 结束 -->
  <!-- slides 开始 -->
  <div id="slides">
    <div class="swiper-wrapper">
      <div class="swiper-slide">
        <img src="img/img_top1.jpg">
        <a class="btn" href="javascript:void(0)">立即邀请</a>
      </div>
    </div>
  </div>
  <!-- slides 结束 -->
  <!-- blocks 开始 -->
  <div id="blocks">
    <div class="item">
      <h1><span class="name">介绍</span></h1>
      <div class="container">
        <p>
          <span>房子借款、汽车借款、公积社保借款你的返利=借款额X3%</span>
          <span>例子：你成功邀请小王借款20万：20万X3%</span>
          <span>您的一次性返利=6000元</span>
        </p>
        <p>
          <span>企业借贷、您的返利=借贷额X2.5%</span>
          <span>例子：你成功邀请小王借款100万：1000万X2.5%</span>
          <span>你的一次性返利=25000元</span>
        </p>
        <p>
          <span>卡账借贷、你的返利=借款X3%</span>
          <span>例子：你成功邀请小王借款10万：10万X3%=300元</span>
          <span>小王借款签约时长为12个月</span>
          <span>你的返利=每月300元、共12个月</span>
        </p>
      </div>
    </div>
    <div class="item">
      <h1><span class="name">邀请方法</span></h1>
      <div class="container">
        <ul>
          <li><h6>01</h6></li>
          <li><h6>02</h6></li>
          <li><h6>03</h6></li>
        </ul>
        <div class="method">
          <div class="method-container"><span>邀请好友注册</span></div>
          <div class="method-container"><span>好友成功借款</span></div>
          <div class="method-container"><span>你获得实时返利</span></div>
        </div>
        <a class="btn" href="javascript:void(0)">立即邀请好友借款</a>
      </div>
    </div>
  </div>
  <!-- blocks 结束 -->
  <div id="copyright">
    <a href="content.html">返利发放说明<span>></span></a>
  </div>
  <div id="tip-download">
    <div class="arrows"><img src="img/2.png"></div>
    <div class="tip-download-container">

      <div class="top-tip-downoad">
        <a id='close' href="javascript:void(0)">X</a>

      </div>
      <div class="text-tip-downoad">
        <span>点击右上角分享专属连接给好友</span>
      </div>
      <div class="img-tip-downoad">
        <img src="img/1.jpg" alt="">
        <p></p>
      </div>

      <div class="text-tip-downoad">
        <p>朋友圈分享专属连接，可以要求更多好友哦！</p>
      </div>
    </div>

  </div>
<script src="js/jquery.min.js"></script>
 <script type="text/javascript">
    $(".btn").bind('touchstart click', function(){
      $("#tip-download").css("display","block");
    });

    $("#close").bind('touchstart click', function(){
      $("#tip-download").css("display","none");
    });
 </script>
</body>
</html>
