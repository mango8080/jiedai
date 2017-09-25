<?php exit;?>
<sql>
	<time>2016-12-02 10:50:33</time>
	<ip>180.116.183.236</ip>
	<user>m31728165</user>
	<php>/mobile/showorder.php</php>
	<querystring>itemid=201</querystring>
	<message>		<query>SELECT a.*,b.title,b.price,b.number FROM `destoon_voucher_order` as a left join `destoon_sell_23`as b on a.voucherid=b.itemid where a.orderid= 201</query>
		<errno>0</errno>
		<error>Unknown column 'b.number' in 'field list'</error>
		<errmsg>MySQL Query Error</errmsg>
</message>
</sql>