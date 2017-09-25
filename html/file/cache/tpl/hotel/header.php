<?php defined('IN_DESTOON') or exit('Access Denied');?><!DOCTYPE html>
<html>
  
  <head>
         
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="Keywords" content="<?php echo $head_keywords;?>">
    <meta name="Description" content="<?php echo $head_description;?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>借借平台
<meta name="keywords" content="<?php echo $head_keywords;?>"/>
<?php } ?>
<?php if($head_description) { ?>
<meta name="description" content="<?php echo $head_description;?>"/>
<?php } ?>
<?php if($head_mobile) { ?>
<meta http-equiv="mobile-agent" content="format=html5;url=<?php echo $head_mobile;?>">
<?php } ?>
<?php if($moduleid>4) { ?><link rel="stylesheet" type="text/css" href="<?php echo DT_SKIN;?><?php echo $module;?>.css"/><?php } ?>
<?php if($CSS) { ?>
<?php if(is_array($CSS)) { foreach($CSS as $css) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo DT_SKIN;?><?php echo $css;?>.css"/>
<?php } } ?>
<?php } ?>
<!--[if lte IE 6]>
<link rel="stylesheet" type="text/css" href="<?php echo DT_SKIN;?>ie6.css"/>
<![endif]-->
<?php if(!DT_DEBUG) { ?><script type="text/javascript">window.onerror=function(){return true;}</script><?php } ?>
  <script type="text/javascript" src="<?php echo DT_STATIC;?>lang/<?php echo DT_LANG;?>/lang.js"></script>
  <script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/config.js"></script>
  <script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/jquery.js"></script>
  <script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/common.js"></script>
  <script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/page.js"></script>
  <?php if($lazy) { ?><script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/jquery.lazyload.js"></script><?php } ?>
  <?php if($JS) { ?>
  <?php if(is_array($JS)) { foreach($JS as $js) { ?>
  <script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/<?php echo $js;?>.js"></script>
  <?php } } ?>
  <?php } ?>
<?php $searchid = ($moduleid > 3 && $MODULE[$moduleid]['ismenu'] && !$MODULE[$moduleid]['islink']) ? $moduleid : 5;?>

    <link type="text/css" rel="stylesheet" href="<?php echo DT_SKIN;?>jquery-ui.css">
    <link href="<?php echo DT_SKIN;?>global.css" rel="stylesheet" type="text/css">
    <link href="<?php echo DT_SKIN;?>base.css" rel="stylesheet" type="text/css">
    <link href="<?php echo DT_SKIN;?>index.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
    <?php if($head_mobile && $EXT['mobile_goto']) { ?>
    GoMobile('<?php echo $head_mobile;?>');
    <?php } ?>
    var searchid = <?php echo $searchid;?>;
    <?php if($itemid && $DT['anticopy']) { ?>
    document.oncontextmenu=function(e){return false;};
    document.onselectstart=function(e){return false;};
    <?php } ?>
    </script>
    </head>
  <body class="zh-CN">
    
    
     
     