<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header');?>
<link href="<?php echo DT_SKIN;?>company.css" rel="stylesheet" type="text/css">
<?php if($itemid) { ?>
<div class="w1200">
        <div class="leftmain">
            
      <div class="searchmain tabBox">
      <form action="/company/search.php" method="get">
      <input type="hidden" name="page" value="1">
        
        <div class="tabMain" style="display:block;background:#FFF">
          <div class="label city">
            <p class="name">入住城市</p>
            <div class="city_box">
              <input name="" class="input_txt city_input" id="cityInfo" value="上海" type="text">
            </div>
          </div>
          
         
          <div class="label">
            <p class="name">关键字</p>
            <div class="kw">
              <input name="kw"  value="" class="input_txt kw_input" type="text" placeholder="酒店名称/地标">
            </div>
          </div>
          <div class="label">
          <input type="submit" name="submit" value="搜索" class="btn">
          </div>
          <div class="clear_float"></div>
        </div>
        </form>
    </div>
            
        </div>
        <div class="rightmain">
            <div class="brandMain tabBox">
                <div class="newspage">
                    <div class="tit2">
                        <h1 class="yahei"><?php echo $title;?></h1>
                        <div class="tip"><?php echo $adddate;?> </div>
                    </div>
                </div>
                <div class="newMain"><?php echo $content;?></div>
            </div>
        </div>
    </div>
<?php } else { ?>
<div class="w1200">
        <div class="leftmain">
            
      <div class="searchmain tabBox">
      <form action="/company/search.php" method="get">
      <input type="hidden" name="page" value="1">
        
        <div class="tabMain" style="display:block;background:#FFF">
          <div class="label city">
            <p class="name">入住城市</p>
            <div class="city_box">
              <input name="" class="input_txt city_input" id="cityInfo" value="上海" type="text">
            </div>
          </div>
          
         
          <div class="label">
            <p class="name">关键字</p>
            <div class="kw">
              <input name="kw"  value="" class="input_txt kw_input" type="text" placeholder="酒店名称/地标">
            </div>
          </div>
          <div class="label">
          <input type="submit" name="submit" value="搜索" class="btn">
          </div>
          <div class="clear_float"></div>
        </div>
        </form>
    </div>
            
        </div>
        <div class="rightmain">
            <div class="brandMain tabBox">
                <div class="titbox">
                    <h2>最新公告</h2>
                </div>
                <div class="p30">
                    <div class="newpage">
                        <ul class="link">
                            <?php if(is_array($lists)) { foreach($lists as $k => $v) { ?>
                                    <li>
                                        <span class="date"><?php echo $v['adddate'];?></span>
                                        <a href="<?php echo $v['linkurl'];?>" target="_blank"><?php echo $v['title'];?></a>
                                    </li>
                                
                               <?php } } ?> 
                        </ul>
                        <div class="fenye"><?php echo $pages;?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php include template('footer');?>