<?php defined('IN_DESTOON') or exit('Access Denied');?><?php if($typeid==1) { ?>
<?php echo $code;?>
<?php } else if($typeid==2) { ?>
<a href="<?php echo $url;?>" title="<?php echo $text_title;?>" target="_blank"><?php echo $text_name;?></a>
<?php } else if($typeid==3) { ?>
<?php if($url) { ?><a href="<?php echo $url;?>" target="_blank"><?php } ?>
<img src="<?php echo $image_src;?>" width="<?php echo $width;?>" height="<?php echo $height;?>" alt="<?php echo $image_alt;?>"/><?php if($url) { ?></a><?php } ?>
<?php } else if($typeid==4) { ?>
<?php if($url) { ?><a href="<?php echo $url;?>" target="_blank"><img src="<?php echo DT_SKIN;?>image/spacer.gif" width="<?php echo $width;?>" height="<?php echo $height;?>" alt="" style="position:absolute;z-index:2;"/></a><?php } ?>
<embed src="<?php echo $flash_src;?>" quality="high" loop="<?php if($flash_loop) { ?>true<?php } else { ?>false<?php } ?>
" extendspage="http://get.adobe.com/flashplayer/" type="application/x-shockwave-flash" width="<?php echo $width;?>" height="<?php echo $height;?>"></embed>
<?php } else if($typeid == 5) { ?>
<?php echo load('slide.js');?>
<div id="slide_a<?php echo $pid;?>" class="slide" style="width:<?php echo $width;?>px;height:<?php echo $height;?>px;">
<?php if(is_array($tags)) { foreach($tags as $i => $t) { ?>
<a href="<?php if($t['linkurl']) { ?><?php echo $t['linkurl'];?><?php } else { ?>###<?php } ?>
" target="<?php if($t['linkurl']) { ?>_blank<?php } else { ?>_self<?php } ?>
"><img src="<?php echo $t['thumb'];?>" width="<?php echo $width;?>" height="<?php echo $height;?>" alt="<?php echo $t['alt'];?>"/></a>
<?php } } ?>
</div>
<script type="text/javascript">new dslide('slide_a<?php echo $pid;?>');</script>
<?php } else if($typeid==6) { ?>
<?php if($tags) { ?>
<div id="adword">
<div class="adword"><?php include template('list-'.$ad_module, 'tag');?></div>
</div>
<?php } ?>
<?php } ?>
