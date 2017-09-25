<?php exit;?>
<sql>
	<time>2016-12-02 23:00:28</time>
	<ip>222.45.91.194</ip>
	<user>zhangming</user>
	<php>/member/trade.php</php>
	<querystring>action=order&amp;fields=1&amp;kw=%E5%95%86%E5%8A%A1&amp;status=&amp;fromtime=&amp;totime=</querystring>
	<message>		<query>SELECT COUNT(*) AS num FROM destoon_mall_order WHERE a.buyer='zhangming' AND a.title  LIKE '%商务%' LIMIT 0,1</query>
		<errno>0</errno>
		<error>Unknown column 'a.buyer' in 'where clause'</error>
		<errmsg>MySQL Query Error</errmsg>
</message>
</sql>