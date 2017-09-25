<?php exit;?>
<sql>
	<time>2016-12-03 17:09:13</time>
	<ip>222.45.91.194</ip>
	<user>guest</user>
	<php>/mhotel/login.php</php>
	<querystring></querystring>
	<message>		<query>SELECT a.username,a.passport,b.step FROM destoon_member as a left join destoon_company as b on a.username=b.username WHERE `a.username`='test' LIMIT 0,1</query>
		<errno>0</errno>
		<error>Unknown column 'a.username' in 'where clause'</error>
		<errmsg>MySQL Query Error</errmsg>
</message>
</sql>