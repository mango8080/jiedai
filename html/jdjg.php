<?php

require 'common.inc.php';
//$zuixiao=4;
//$username=yjw2016;
//$db->query("UPDATE destoon_company set lowprice=$zuixiao where username='".$username."'");exit;

$num=0;
$hotel=$db->query("SELECT username FROM destoon_company where lowprice=0 and hotelid>0 and hotelstatus='active'");
//select * from destoon_company where lowprice=0 and hotelid>0 and hotelstatus="active"
foreach ($hotel as $key => $value) {

  $mall=$db->query("SELECT price,username FROM destoon_mall where username='".$value['username']."'");
  $username;
  $arr=array();
   foreach ($mall as $key1 => $value1) {
    //echo $value1['price'];
    $arr[]=$value1['price'];
     $username=$value1['username'];
    
  }
  $num++;
  $zuixiao = min($arr);
  $db->query("UPDATE destoon_company set lowprice=$zuixiao where username='".$username."'");
  
  //echo $username;
  
 
     
}
echo $num;
echo "成功";


?>