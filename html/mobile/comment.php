<?php
/*
	[Destoon B2B System] Copyright (c) 2008-2015 www.destoon.com
	This is NOT a freeware, use is subject to license.txt
*/
$moduleid = 3;
require 'common.inc.php';
$itemid or dheader('index.php');
require DT_ROOT.'/include/post.func.php';
require DT_ROOT.'/include/module.func.php';$head_name = $L['comment_title'];$head_title = $head_name.$DT['seo_delimiter'].$head_title;
switch($action) {
	case 'user':
		(isset($username) && check_name($username)) or $username = '';
		$username or mobile_msg($L['msg_not_user']);
		$_userid or dheader('login.php?forward='.urlencode('comment.php?action='.$action.'&username='.$username.'&mid='.$mid.'&itemid='.$itemid));
		$user = userinfo($username);
		$user or mobile_msg($L['msg_not_user']);
		$condition = "status=3 AND username='$username' AND hidden=0";
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}comment WHERE $condition", 'CACHE');
		$items = $r['num'];
		$pages = mobile_pages($items, $page, $pagesize);
		$lists = array();
		if($items) {
			$result = $db->query("SELECT * FROM {$DT_PRE}comment WHERE $condition ORDER BY itemid DESC LIMIT $offset,$pagesize");
			while($r = $db->fetch_array($result)) {
				$lists[] = $r;
			}
			$db->free_result($result);
		}
		$head_name = $L['comment_user'];
		$head_title = $head_name.$DT['seo_delimiter'].$head_title;
		$foot = '';
		include template('comment_user', 'mobile');
		if(DT_CHARSET != 'UTF-8') toutf8();
	break;
	case 'comment':		$td = $db->get_one("SELECT * FROM {$DT_PRE}mall_order WHERE itemid=$itemid");		if($td['mid'] != 16) message($L['trade_msg_deny_comment']);						include template('comment', 'mobile');		if(DT_CHARSET != 'UTF-8') toutf8();
	break;
	case 'post':		
		$content = isset($content) ? convert(input_trim(nl2br($content)), 'UTF-8', DT_CHARSET) : '';
		$content = dhtmlspecialchars(trim($content));
		$content = preg_replace("/&([a-z]{1,});/", '', $content);
		$star = intval($star);
		in_array($star, array(1, 2, 3)) or $star = 3;
		$content = nl2br($content);		$db->query("UPDATE {$DT_PRE}mall SET comments=comments+1 WHERE itemid=$mallid");		$db->query("UPDATE {$DT_PRE}mall_order SET seller_star=$star WHERE itemid=$itemid");		$s = 's'.$star;		$db->query("UPDATE {$DT_PRE}mall_comment SET seller_star=$star,seller_comment='$content',seller_ctime=$DT_TIME WHERE itemid=$itemid");		$db->query("UPDATE {$DT_PRE}mall_stat SET scomment=scomment+1,`$s`=`$s`+1 WHERE mallid=$mallid");				echo json_encode(array('stat'=>1));
		exit();
		break;
	default:
		if($EXT['comment_api']) {
			//
		} else {
			$lists = array();
			$condition = "item_mid=$mid AND item_id=$itemid AND status=3";
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}comment WHERE {$condition}");
			$items = $r['num'];
			$pages = mobile_pages($items, $page, $pagesize);
			if($items) {
				$result = $db->query("SELECT * FROM {$DT_PRE}comment WHERE {$condition} ORDER BY itemid ASC LIMIT $offset,$pagesize");
				$floor = $page == 1 ? 0 : ($page-1)*$pagesize;
				while($r = $db->fetch_array($result)) {
					$r['floor'] = ++$floor;
					if($r['username']) {
						$r['name'] = $r['hidden'] ? $MOD['comment_am'] : $r['passport'];
						$r['uname'] = $r['hidden'] ? '' : $r['username'];
					} else {
						$r['name'] = 'IP:'.hide_ip($r['ip']);
						$r['uname'] = '';
					}
					$lists[] = $r;
				}
			}
		}		
		$head_title = $title.$DT['seo_delimiter'].$head_title;
		$foot = '';
		include template('comment', 'mobile');
		if(DT_CHARSET != 'UTF-8') toutf8();
	break;
}
?>