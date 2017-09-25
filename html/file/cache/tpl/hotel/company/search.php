<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header');?>
<link href="<?php echo DT_SKIN;?>indexx.css" rel="stylesheet" type="text/css">
<div class="wrapper jinjiang_zhixing ">
<div class="path_bar">
          <a href="<?php echo $MODULE['1']['linkurl'];?>">首页</a> &raquo; <a href="<?php echo $MOD['linkurl'];?>"><?php echo $MOD['name'];?></a>&raquo;
    </div>
<form action="" method="get">
    <div class="search_bar yahei">
        <input name="" value="提交" class="btn_search" type="submit">
<!-- 
        <div class="city"><span class="fl">城市</span>
        <div class="city_box">
            <input type="text" value="" size="15" id="homecity_name" class=" city_input" name="homecity_name" mod="address|notice" mod_address_source="hotel"  mod_address_reference="cityid" mod_notice_tip="请选择地点" />
            <input id="cityid" name="areaid" type="hidden" value="<?php echo $cityid;?>" />
            <div id="jsContainer" class="jsContainer" style="height:0">
            </div>
        </div>
        </div>  -->
        <!-- <div class="terminal">
        <span class="fl">目的地</span>
            <div class="selecct_box" id="terminal_select">
                <div class="select_val_box" initvalue="请选择">请选择</div>
                <ul class="select_list" style="display: none;">
                    <li class="ellipsis" title="目的地1">目的地1</li>
                </ul>
            </div>
        </div> -->
<?php echo $area_select;?>
        <span class="start_time"><span class="fl">入住日期</span>
        <input placeholder="请选择入住日期" name="Check_in_date" class="input_txt dateCheckIn hasDatepicker" id="Check_in_date" value="<?php echo $Check_in_date;?>" readonly="readonly" type="text" onfocus="ca_show('Check_in_date', this, '-');"  ondblclick="this.value='';"/>
        </span> 
        <span class="end_time"><span class="fl">离店日期</span>
        <input placeholder="请选择离店日期" name="Check_out_date" class="input_txt dateCheckOut hasDatepicker" id="Check_out_date" value="<?php echo $Check_out_date;?>" readonly="readonly" type="text" onfocus="ca_show('Check_out_date', this, '-');"  ondblclick="this.value='';"/>
        </span>
        <div class="keyword"><span class="name">关键字</span>
          <div class="kw">
            <input name="kw" autocomplete="off" value="<?php echo $kw;?>" class="input_txt kw_input" id="kw_input" data-type="" title="酒店名称/地标" type="text" placeholder="请输入关键字">
          </div>
        </div>
    </div>
</form>
    <div class="filter_box clearfix" id="include" style="height: 109px;overflow: hidden;">
        
            <div id="filter_price" class="filter_unit dis">
            <div class="filter_label">价格</div>
                <div <?php if($price) { ?>class="off"<?php } else { ?>class="unlimited_btn"<?php } ?>
 ><a href="search.php?areaid=<?php echo $areaid;?>&Check_in_date=<?php echo $Check_in_date;?>&Check_out_date=<?php echo $Check_out_date;?>&kw=<?php echo $kw;?>&starrating=<?php echo $starrating;?>&waibin=<?php echo $waibin;?>&brandv=<?php echo $brandv;?>">全部</a></div>
                <ul class="chklist">
                <li><label class="ellipsis checkbox" style="font-family:arial;" title="¥200以下"><a href="search.php?areaid=<?php echo $areaid;?>&Check_in_date=<?php echo $Check_in_date;?>&Check_out_date=<?php echo $Check_out_date;?>&kw=<?php echo $kw;?>&price=0v200&starrating=<?php echo $starrating;?>&waibin=<?php echo $waibin;?>&brandv=<?php echo $brandv;?>" <?php if($price=='0v200') { ?>class="active"<?php } ?>
 >¥200以下</a></label></li>
                <li><label class="ellipsis checkbox" style="font-family:arial;" title="¥200-400"><a href="search.php?areaid=<?php echo $areaid;?>&Check_in_date=<?php echo $Check_in_date;?>&Check_out_date=<?php echo $Check_out_date;?>&kw=<?php echo $kw;?>&price=200v400&starrating=<?php echo $starrating;?>&waibin=<?php echo $waibin;?>&brandv=<?php echo $brandv;?>" <?php if($price=='200v400') { ?>class="active"<?php } ?>
>¥200-400</a></label></li>
                <li><label class="ellipsis checkbox" style="font-family:arial;" title="¥400-600"><a href="search.php?areaid=<?php echo $areaid;?>&Check_in_date=<?php echo $Check_in_date;?>&Check_out_date=<?php echo $Check_out_date;?>&kw=<?php echo $kw;?>&price=400v600&starrating=<?php echo $starrating;?>&waibin=<?php echo $waibin;?>&brandv=<?php echo $brandv;?>" <?php if($price=='400v600') { ?>class="active"<?php } ?>
>¥400-600</a></label></li>
                <li><label class="ellipsis checkbox" style="font-family:arial;" title="¥600以上"><a href="search.php?areaid=<?php echo $areaid;?>&Check_in_date=<?php echo $Check_in_date;?>&Check_out_date=<?php echo $Check_out_date;?>&kw=<?php echo $kw;?>&price=600v100000&starrating=<?php echo $starrating;?>&waibin=<?php echo $waibin;?>&brandv=<?php echo $brandv;?>" <?php if($price=='600v100000') { ?>class="active"<?php } ?>
>¥600以上</a></label></li>
                </ul>
              
            </div>
            
            <div id="filter_star_level" class="filter_unit dis" style="">
            <div class="filter_label">星级</div>
                <div <?php if($starrating) { ?>class="off"<?php } else { ?>class="unlimited_btn"<?php } ?>
><a href="search.php?areaid=<?php echo $areaid;?>&Check_in_date=<?php echo $Check_in_date;?>&Check_out_date=<?php echo $Check_out_date;?>&kw=<?php echo $kw;?>&price=<?php echo $price;?>&brandv=<?php echo $brandv;?>&waibin=<?php echo $waibin;?>">全部</a></div>
                <ul class="chklist">
                <li>
                <label class="ellipsis checkbox" rating="0">
                    <a href="search.php?areaid=<?php echo $areaid;?>&Check_in_date=<?php echo $Check_in_date;?>&Check_out_date=<?php echo $Check_out_date;?>&kw=<?php echo $kw;?>&price=<?php echo $price;?>&starrating=二星级及以下&brandv=<?php echo $brandv;?>&waibin=<?php echo $waibin;?>" <?php if($starrating=='二星级及以下') { ?>class="active"<?php } ?>
>二星级及以下</a>
                </label>
                </li>
                <li>
                <label class="ellipsis checkbox" rating="0">
                    <a href="search.php?areaid=<?php echo $areaid;?>&Check_in_date=<?php echo $Check_in_date;?>&Check_out_date=<?php echo $Check_out_date;?>&kw=<?php echo $kw;?>&price=<?php echo $price;?>&starrating=三星级&brandv=<?php echo $brandv;?>&waibin=<?php echo $waibin;?>" <?php if($starrating=='三星级') { ?>class="active"<?php } ?>
>三星级</a>
                </label>
                </li>
                <li>
                <label class="ellipsis checkbox" rating="0">
                    <a href="search.php?areaid=<?php echo $areaid;?>&Check_in_date=<?php echo $Check_in_date;?>&Check_out_date=<?php echo $Check_out_date;?>&kw=<?php echo $kw;?>&price=<?php echo $price;?>&starrating=四星级&brandv=<?php echo $brandv;?>&waibin=<?php echo $waibin;?>" <?php if($starrating=='四星级') { ?>class="active"<?php } ?>
>四星级</a>
                </label>
                </li>
                <li>
                <label class="ellipsis checkbox" rating="0">
                    <a href="search.php?areaid=<?php echo $areaid;?>&Check_in_date=<?php echo $Check_in_date;?>&Check_out_date=<?php echo $Check_out_date;?>&kw=<?php echo $kw;?>&price=<?php echo $price;?>&starrating=五星级&brandv=<?php echo $brandv;?>&waibin=<?php echo $waibin;?>" <?php if($starrating=='五星级') { ?>class="active"<?php } ?>
>五星级</a>
                </label>
                </li>
                </ul>
            </div>
            <div id="filter_brand" class="filter_unit dis" style="">
            <div class="filter_label">品牌</div>
                <div <?php if($brandv) { ?>class="off"<?php } else { ?>class="unlimited_btn"<?php } ?>
><a href="search.php?areaid=<?php echo $areaid;?>&Check_in_date=<?php echo $Check_in_date;?>&Check_out_date=<?php echo $Check_out_date;?>&kw=<?php echo $kw;?>&price=<?php echo $price;?>&starrating=<?php echo $starrating;?>&waibin=<?php echo $waibin;?>">全部</a></div>
                <ul class="chklist">
                <?php if(is_array($brand)) { foreach($brand as $b => $bb) { ?>
  <li>
    <label class="ellipsis checkbox" style="font-family:arial;" title="JJDC">
                    <a href="search.php?areaid=<?php echo $areaid;?>&Check_in_date=<?php echo $Check_in_date;?>&Check_out_date=<?php echo $Check_out_date;?>&kw=<?php echo $kw;?>&price=<?php echo $price;?>&starrating=<?php echo $starrating;?>&brandv=<?php echo $bb['groupcode'];?>&waibin=<?php echo $waibin;?>" <?php if($brandv==$bb['groupcode']) { ?>class="active"<?php } ?>
><?php echo $bb['groupname'];?></a>
      </label>
  </li>
                  <?php } } ?>
</ul>
            </div>
            <div id="filter_facilities" class="filter_unit dis" style="">
            <div class="filter_label">设备</div>
<div <?php if($waibin) { ?>class="off"<?php } else { ?>class="unlimited_btn"<?php } ?>
><a href="search.php?areaid=<?php echo $areaid;?>&Check_in_date=<?php echo $Check_in_date;?>&Check_out_date=<?php echo $Check_out_date;?>&kw=<?php echo $kw;?>&price=<?php echo $price;?>&brandv=<?php echo $brandv;?>&starrating=<?php echo $starrating;?>">全部</a></div>
               
                <ul class="chklist">   
                            <li >
                           <input class="hide" type="checkbox">
                           <label class="ellipsis checkbox" data-type="WIFI" >
                               <a href="search.php?areaid=<?php echo $areaid;?>&Check_in_date=<?php echo $Check_in_date;?>&Check_out_date=<?php echo $Check_out_date;?>&kw=<?php echo $kw;?>&price=<?php echo $price;?>&starrating=<?php echo $starrating;?>&brandv=<?php echo $brandv;?>&waibin=Y" <?php if($waibin) { ?>class="active"<?php } ?>
>可接待外宾</a>
                           </label>
                            </li>
                        
                </ul>
            </div>
    </div>
    <!-- 加载更多 -->
    <div><a href="javascript:showinclude()" id="includebtn">加载更多</a></div>
        <div class="base_wrap base_wrap_dev">
        <div class="base_side">
        <div class="float_side fs_box" style="position: relative; top: 0px;">
            <div class="hotselect">
                <p class="tit"><span> 热门酒店</span></p>
<?php $hot=tag("moduleid=4&condition=level=1 and status=3&areaid=$areaid&pagesize=5&order=vip desc&template=null")?>
                            <ul id="hotHotelul">
                            
<?php if(is_array($hot)) { foreach($hot as $h => $hh) { ?>
<li class="clearfix">
                                            <a href="<?php echo DT_PATH;?>index.php?homepage=<?php echo $hh['username'];?>" >
                                            <img src="<?php echo DT_PATH;?><?php echo $hh['thumb'];?>" height="100"  width="134">
                                    
                                            <h6><?php echo $hh['company'];?></h6>
                                            <p>¥<span><?php echo $hh['lowprice'];?></span>起</p>
                                            </a>
                                        </li>
<?php } } ?>
                
            </div>
        </div>        
</div>
        <div class="base_main">
        <div id="hotel_list_data" class="hotel_list">
                <!-- 置顶vip -->
<?php $zhiding=tag("moduleid=4&condition=vip>0 and status=3&areaid=$areaid&pagesize=5&order=fromtime desc&template=null")?>
          
                <?php if(is_array($zhiding)) { foreach($zhiding as $v => $vc) { ?>
                <div class="hotel_item clearfix" style="">
                      <ul class="hotel_info">
                        <li class="pic">
                          <a href="<?php echo DT_PATH;?>index.php?homepage=<?php echo $vc['username'];?>" target="_blank" >
                            <img src="<?php echo DT_PATH;?><?php echo $vc['thumb'];?>"  width="140" height="105"></a>
                        </li>
                        <li class="info">
                          <div class="info-tit">
                            <h2>
                              <a id="hotelDetailHeader1" class="yahei" href="<?php echo DT_PATH;?>index.php?homepage=<?php echo $vc['username'];?>" target="_blank" title="">
                                <?php echo $vc['company'];?></a>
                              
                            </h2>
                          </div>
                          <div>
                            <div class="address ellipsis horizantal" title="">地址：<?php echo $vc['address'];?></div>
                            </div>
                          <p class="introduction ellipsis" ><?php echo $vc['introduce'];?></p>
                        </li>
                        <li class="price">
                          <span>¥</span>
                          <b><?php echo $vc['lowprice'];?></b>起</li>
                      </ul>
    </div>
    <?php } } ?>
        <?php if($tags) { ?>
<?php include template('list-company', 'tag');?>
<?php } else { ?>
<?php include template('noresult', 'message');?>
<?php } ?>
        </div>
        </div>
        <div class="clearfix"></div>
        </div>
</div>
<style>
    #includebtn{
        background: #FFF;
        text-align: center;
        width: 80px;
        margin:0 auto;
        margin-bottom: 30px;
        margin-top: -21px;
        color: black;
        border: 1px solid #D9E8FF;
        border-top: none;
        display: block;
        text-decoration: none;
    }
</style>
<script>
    function showinclude(){
        document.getElementById('include').style.height="276px";
        document.getElementById('includebtn').innerHTML="收起";
        document.getElementById('includebtn').href="javascript:hideinclude()";
    }
    function hideinclude(){
        document.getElementById('include').style.height="109px";
        document.getElementById('includebtn').innerHTML="显示更多";
        document.getElementById('includebtn').href="javascript:showinclude()";
    }
    function showdiv(a){
        document.getElementById(a).style.height="";
        document.getElementById(a+'more').innerHTML="收起";
        document.getElementById(a+'more').href="javascript:hidediv('"
    +a+"')";
    }
    function hidediv(a){
        document.getElementById(a).style.height="130px";
        document.getElementById(a+'more').innerHTML="显示更多";
        document.getElementById(a+'more').href="javascript:showdiv('"+a+"')";
    }
</script> 
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/fixdiv.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/address.js"></script>
<script type="text/javascript" src="/lang/zh-cn/lang.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/common.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/calendar.js"></script> 
<script src="<?php echo DT_STATIC;?>file/script/jquery-1.8.2.min.js"></script>  
<?php include template('footer');?>