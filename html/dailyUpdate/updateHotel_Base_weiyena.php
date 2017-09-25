<?php
/**
*维也纳酒店接口
*
*/
header("Content-type: text/html; charset=utf-8");
class Ettwyn{
	public $error;
	private $OrderURL='';
	private $AgentID='';
	private $AuthCode='';
	public $client='';
	
	public function __construct($cofig = array()) {
        $cofig = array (
        		'sURL'=>'http://quickapitest.wyn88.com:8080',
                'sAgentID'=>'1507091XY',
                'sAuthCode' => 'c7a8cea37e2e4e5ea7bfa868410d4d6c'
        );
        // 配置参数
        $this->OrderURL = $cofig['sURL'];
        $this->AgentID = $cofig['sAgentID'];
        $this->AuthCode = $cofig['sAuthCode'];
      
    }
    //检查某个酒店的所有房型状态和价格--酒店房型展示页使用
       public function checkroom_statusprice($hotelid,$begindate,$enddate){
	
	    $hotelResult = file_get_contents($this->OrderURL.'/Room2/HotelDailyRoomStatus?sid='.$this->AgentID.'&hotelno='.$hotelid.'&indate='.$begindate.'&outdate='.$enddate);

		$response=json_decode($hotelResult,true);
		
		//var_dump($response['Data']);exit;
		//var_dump($response);exit;
		if($response['Result']!=1){
			echo "调用接口失败";
		}
	    
		return 'ok';
    }
    //检查某个酒店某个房型的状态和价格--预定页展示和下单前验证使用
    public function getonlineratemap($hotelid,$begindate,$enddate,$roomtype){
		
    	$arrResult=array();
    	
	    $hotelResult = file_get_contents($this->OrderURL.'/Room2/HotelDailyRoomStatus?sid='.$this->AgentID.'&hotelno='.$hotelid.'&roomtypeno='.$roomtype.'&indate='.$begindate.'&outdate='.$enddate);

		$response=json_decode($hotelResult,true);
		// echo $response['Data']['0']['OrderNum'];
		//var_dump($response);exit;
		$hotelprice = array();
		
    	if ($response['Result']!=1){
			$this->error = '调用接口失败';
		}else{
			
				if ($response['Data']['0']['OrderNum']>0){
					$tmpStatus="A";
				}else{
					$tmpStatus="N";
				}
				//echo $tmpStatus;
				$lowprice=10000;
			
				foreach ($response['Data'] as $val) {
				$hotelprice[$key]['date']=date("Y-m-d",strtotime($val['BizDay']));
					$hotelprice[$key]['price']= $val['DisRate'];
					$hotelprice[$key]['check']= $val['DisRate2'];
					if ($val['OrderNum']<=0){
						$tmpStatus="N";
					}
					if ($val['DisRate']<$lowprice){
						$lowprice=$val['DisRate'];
					}
				}
				$arrResult['RoomStatus']=$tmpStatus;
				$arrResult['RoomPrice']=$hotelprice;
				$arrResult['LowPrice']=$lowprice;
			
		}
		//var_dump($arrResult);exit;
		return $arrResult;
    }
	function neworder($hotelid,$beginDate,$enddate,$paytype,$roomtypeno,$roomnum,$arrivetime,$linkname,$mobile,$ordertotalprice,$outflagno){
		echo $this->OrderURL.'/Order2/Booking2?sid='.$this->AgentID.'&token='.$this->AuthCode.'&hotelno='.$hotelid.'&roomtypeno='.$roomtypeno.'&indate='.$beginDate.'&outdate='.$enddate.'&roomnum='.$roomnum.'&arrivetime='.$arrivetime.'&linkname='.$linkname.'&mobile='.$mobile.'&paytype='.$paytype.'&ordertotalprice='.$ordertotalprice.'&outflagno='.$outflagno;exit;
		 $hotelorder = file_get_contents($this->OrderURL.'/Order2/Booking2?sid='.$this->AgentID.'&token='.$this->AuthCode.'&hotelno='.$hotelid.'&roomtypeno='.$roomtypeno.'&indate='.$beginDate.'&outdate='.$enddate.'&roomnum='.$roomnum.'&arrivetime='.$arrivetime.'&linkname='.$linkname.'&mobile='.$mobile.'&paytype='.$paytype.'&ordertotalprice='.$ordertotalprice.'&outflagno='.$outflagno);
		
    	$response=json_decode($hotelorder,true);
		if($response["Result"]==1){
			echo "yes";
		}
		
    }
    //取消订单
    function cancelorder($orderNumber){
	
    	$hotelcancel = file_get_contents($this->OrderURL.'/order2/cancel?sid='.$this->AgentID.'&token='.$this->AuthCode.'&orderNumber='.$orderNumber);
		
    	$response=json_decode($hotelcancel,true);
		if($response["Result"]==1){
			echo "yes";
		}
    }
    //获取房型最低的价格
	function getprice($hotelid,$begindate,$enddate,$roomtype){
    	$hotelResult = file_get_contents($this->OrderURL.'/Room2/HotelDailyRoomStatus?sid='.$this->AgentID.'&hotelno='.$hotelid.'&roomtypeno='.$roomtype.'&indate='.$begindate.'&outdate='.$enddate);

		$response=json_decode($hotelResult,true);
		//var_dump($response);exit;
    	if ($response['Result']!=1){
			$this->error = '调用接口失败';
		}else{
			
				$aa=1000;
				foreach ($response['Data'] as $key => $val) {
					if ($val['DisRate']<$aa){
						$aa=$val['DisRate'];
					}
				}
				$re=$aa;
			
		}
		return $re;
    }
   
   
}
?>