<?php
/**
*维也纳酒店接口
*
*/
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
                'sAuthCode' => 'apixyprepaytest'
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
		
		$arr=$response;
		var_dump($arr);exit;
		if($arr==""){
			echo "调用接口失败";exit;
		}
	    
		return 'ok';
    }
    //检查某个酒店某个房型的状态和价格--预定页展示和下单前验证使用
    public function getonlineratemap($hotelid,$begindate,$enddate,$roomtype){
    	$arrResult=array();
    	try{
			$hotelResult = $this->client->__call('DoubleCheckBeforeCreateOrder',array(array('sAgentID'=>$this->AgentID,'sAuthCode'=>$this->AuthCode,'sHotelID'=>$hotelid,'dCheckIn'=>$begindate,'dCheckOut'=>$enddate,'sRoomType'=>$roomtype)));
		}catch(Exception $e){
			$this->error = $e->getMessage();
			return $arrResult;
		}
		$hotelprice = array();
		$response=json_decode($hotelResult->DoubleCheckBeforeCreateOrderResult,true);
    	if ($response['ResultCode']!=0){
			$this->error = '调用接口失败';
		}else{
			if ($response['ResponseCode']!=1){
				if ($response['ResponseCode']==6){
					$this->error = '无记录';
				}else{
					$this->error = '返回结果错误';
				}
			}else{
				if ($response['ResultContent']['RoomCount']['RemainBookingRoomCount']>0){
					$tmpStatus="A";
				}else{
					$tmpStatus="N";
				}
				$lowprice=10000;
				foreach ($response['ResultContent']['RoomPrice'] as $key => $val) {
					$hotelprice[$key]['date']=date("Y-m-d",strtotime($val['BizDate']));
					$hotelprice[$key]['price']= $val['Price'];
					$hotelprice[$key]['check']= $val['PriceCheck'];
					if ($val['Price']<0 || $val['MarketPrice']<=0){
						$tmpStatus="N";
					}
					if ($val['Price']<$lowprice){
						$lowprice=$val['Price'];
					}
				}
				$arrResult['RoomStatus']=$tmpStatus;
				$arrResult['RoomPrice']=$hotelprice;
				$arrResult['LowPrice']=$lowprice;
			}
		}
		return $arrResult;
    }
    //生成订单
    function neworder($hotelid,$begindate,$enddate,$paytype,$roomtypeno,$roomnum,$arrivetime,$linkname,$mobile,$paytype,$ordertotalprice,$outflagno){
    	$hotelResult = file_get_contents($this->OrderURL.'/Order2/Booking2?sid='.$this->AgentID.'&hotelno='.$hotelid.'&roomtypeno='.$roomtypeno.'&indate='.$begindate.'&outdate='.$enddate.'&roomnum='.$roomnum.'&arrivetime='.$arrivetime.'&linkname='.$linkname.'&mobile='.$mobile.'&paytype='.$paytype.'&ordertotalprice='.$ordertotalprice.'&outflagno='.$outflagno);

    	$arrDatePrice=$this->getonlineratemap($hotelid,$begindate,$enddate,$order_roomtype);
	    foreach($arrDatePrice['RoomPrice'] as $key=>$val){
	    	$jsonDailyRate.=',{"BizDate":"'.$val['date'].'","Price":'.$val['price'].',"PriceCheck":"'.$val['check'].'"}';
		}
		$jsonDailyRate = substr($jsonDailyRate, 1);
    	$arrOrder=array('sAgentID'=>$this->AgentID,'sAuthCode'=>$this->AuthCode,'sHotelID'=>$hotelid,'dCheckIn'=>date("Y-m-d",strtotime($begindate)),'dCheckOut'=>date("Y-m-d",strtotime($enddate)),'sRoomType'=>$order_roomtype,'iRoomCount'=>$order_rooms,'sLinkName'=>$order_truename,'sLinkMobile'=>$order_mobile,'sLinkEmail'=>$order_email,'dArrTime'=>$order_arrivetime,'sComment'=>$order_note,'sCreditNo'=>'0','JsonDailyRate'=>$jsonDailyRate,'requestNo'=>$order_code,'jsonPaymentCard'=>'{}','payType'=>$paytype);
    	//var_dump($arrOrder);
    	try{
			$orderResult = $this->client->__call('CreateOrder2',array($arrOrder));
		}catch(Exception $e){
			$this->error = $e->getMessage();
			return '';
		}
		$response=json_decode($orderResult->CreateOrder2Result,true);
		$recode='';
		if ($response['ResultCode']!=0){
			$this->error = '调用接口失败';
		}else{
			if ($response['ResponseCode']==1){
				$recode=$response['ResultContent'];
			}else{
				$this->error = $response['ResponseMessage'];
			}
		}
		return $recode;
    }
    //取消订单
    function cancelorder($hotelid,$confnum){
    	try{
			$hotelResult = $this->client->__call('CancelOrder',array(array('sAgentID'=>$this->AgentID,'sAuthCode'=>$this->AuthCode,'sOrderID'=>$confnum,'sHotelID'=>$hotelid)));
		}catch(Exception $e){
			$this->error = $e->getMessage();
			return 'failed';
		}
		$response=json_decode($hotelResult->CancelOrderResult,true);
		$re='failed';
    	if ($response['ResultCode']!=0){
			$this->error = '调用接口失败';
		}else{
			if ($response['ResponseCode']==1){
				$re='ok';
			}else{
				$this->error = $response['ResponseMessage'];
			}
		}
		return $re;
    }
    //获取房型最低的价格
    function getprice($hotelid,$begindate,$enddate){
    	try{
			$hotelResult = $this->client->__call('DoubleCheckBeforeCreateOrderForAllRoomType',array(array('sAgentID'=>$this->AgentID,'sAuthCode'=>$this->AuthCode,'sHotelID'=>$hotelid,'dCheckIn'=>$begindate,'dCheckOut'=>$enddate)));
		}catch(Exception $e){
			$this->error = $e->getMessage();
			return 0;
		}
		$response=json_decode($hotelResult->DoubleCheckBeforeCreateOrderForAllRoomTypeResult,true);
		
		$re=0;
    	if ($response['ResultCode']!=0){
			$this->error = '调用接口失败';
		}else{
			if ($response['ResponseCode']!=1){
				if ($response['ResponseCode']==6){
					$this->error = '无记录';
				}else{
					$this->error = '返回结果错误';
				}
			}else{
				$aa=1000;
				foreach ($response['ResultContent'] as $key => $val) {
					if ($val['RoomCountPriceDetail'][0]['Price']<$aa){
						$aa=$val['RoomCountPriceDetail'][0]['Price'];
					}
				}
				$re=$aa;
			}
		}
		return $re;
    }
    // 获取订单状态
    function orderstatus($confnum){
    	try{
			$hotelResult = $this->client->__call('QueryOrder',array(array('sAgentID'=>$this->AgentID,'sAuthCode'=>$this->AuthCode,'jsonOrderID'=>'{"OrderID":"'.$confnum.'"}')));
		}catch(Exception $e){
			$this->error = $e->getMessage();
			return 'failed';
		}
		$response=json_decode($hotelResult->QueryOrderResult,true);
		$re='';
    	if ($response['ResultCode']!=0){
			$this->error = '调用接口失败';
			$re='failed';
		}else{
			if ($response['ResponseCode']==1){
				if ($response['ResultContent'][0]['OrderStatus']=='E'){
					$re=$response['ResultContent'][0]['ReceiveDTO'][0]['RecStatusId'];
				}else{
					$re=$response['ResultContent'][0]['OrderStatus'];
				}
			}else{
				$this->error = $response['ResponseMessage'];
				$re='failed';
			}
		}
		return $re;
    }
}
?>