<?php exit;?>
<sql>
	<time>2016-12-12 11:04:04</time>
	<ip>112.84.105.242</ip>
	<user>zhangming</user>
	<php>/mobile/index.php</php>
	<querystring>moduleid=4&amp;username=jindu&amp;beginDate=2016-12-12&amp;endDate=2016-12-13&amp;roomNum=1</querystring>
	<message>		<query>SELECT a.*,b.jingzhong,b.username,b.danwei FROM destoon_mall_comment as a left join destoon_member b on a.buyer=b.username WHERE a.seller_star>0 and a.seller='jindu' DESC LIMIT 0,20</query>
		<errno>0</errno>
		<error>You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'DESC LIMIT 0,20' at line 1</error>
		<errmsg>MySQL Query Error</errmsg>
</message>
</sql>