<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<?php 
$link = mysql_connect('www.anluze.com', 'root', 'yanji818');
		mysql_select_db('dingdan', $link);
		$i=mysql_query("INSERT INTO  `ddb`(`beizhu`) VALUES ('".$data."')");
var_dump($i);
?>
</body>
</html>
