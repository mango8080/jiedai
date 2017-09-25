/*
	[Hotel System] Copyright (c) 2008-2016 www.idc580.cn
	
*/
function Dd(i) {return document.getElementById(i);}
function Ds(i) {Dd(i).style.display = '';}
function Dh(i) {Dd(i).style.display = 'none';}
function Go(u) {window.location = u;}
function Dback(u, r, e) {
	var m = e ? '/'+e+'/' : '';
	if(r && m && r.match(eval(m))) {
		Go(u ? u : 'index.php');
	} else if(r) {
		window.history.back();
	} else if(document.referrer) {
		window.history.back();
	} else {
		Go(u ? u : 'index.php');
	}
}
function GoPage(max, url) {
	if(max < 2) return;
	var page = parseInt(prompt('Go to page of (1-'+max+')', ''));
	if(page >= 1 && page <= max) Go(url.replace(/\{destoon_page\}/, page));
}
function DTrim(s) {
	s = s.trim();
	var t = encodeURIComponent(s);
	if(t.indexOf('%E2%80%86') != -1) s = decodeURIComponent(t.replace(/%E2%80%86/g, ''));
	return s;
}
function Dtoast(msg, id, time) {
	var time = time ? time : 2;
	var id = id ? id : '';
	$('.ui-toast').html(msg);
	var w = $('.ui-toast').width();
	if(w < 14) w = msg.length*14;
	$('.ui-toast').css('left', $(document).scrollLeft()+($(document).width()-w)/2 - 16);
	$('.ui-toast').fadeIn('fast', function() {
		setTimeout(function() {
			$('.ui-toast').fadeOut('slow', function() {
				if(id) $('#'+id).focus();
			});
		}, time*1000);
	});
}
function Dsheet(action, cancel, msg) {
	if(action) {
		action = action.replace(/&#34;/g, '"').replace(/&#39;/g, "'");
		var arr = action.split('|');
		var htm = '<div>';
		if(msg) htm += '<em>'+msg+'</em>';
		htm += '<ul>';
		for(var i=0;i<arr.length;i++) {
			if(i > 4) break;
			htm += '<li'+(i==0&&!msg ? ' style="border:none;"' : '')+'>'+arr[i]+'</li>';
		}
		htm += '</ul></div>';
		if(cancel) htm += '<p onclick="Dsheet(0);">'+cancel+'</p>';
		$('.ui-sheet').html(htm);
		var h = $('.ui-sheet').height();
		if(h < 50) h = 400;
		$('.ui-mask').fadeIn('fast');
		$('.ui-sheet').css('bottom', -h);
		$('.ui-sheet').show();
		$('.ui-sheet').animate({'bottom':'0'}, 300);
		if(cancel) $('.ui-mask').on('tap swipe scrollstart', function() {Dsheet(0);});
		$('.ui-sheet li').on('tap', function() {
			var _htm = $('.ui-sheet div').html();
			setTimeout(function(){
				if(_htm == $('.ui-sheet div').html()) Dsheet(0);
			}, 1000);}
		);
	} else {
		$('.ui-mask').fadeOut('fast');
		$('.ui-sheet').animate({'bottom':-$('.ui-sheet').height()}, 300, function() {
			$('.ui-sheet').html('');
			$('.ui-sheet').hide();
		});
	}
}
//$(document).ready(function(){
$(document).on('pageinit', function(event) {
	$('.head-bar-title').on('click',function(event) {
		if($('#channel').length>0) $('#channel').removeClass('channel_fix');
		$('html, body').animate({scrollTop:0}, 500);
	});
	$('.head-bar-title').on('taphold', function(event){
		window.location.reload();
	});	
	$('.ui-icon-loading').on('click', function(event) {
		window.location.reload();
	});
	$('.list-txt li,.list-set li,.list-img').on('tap', function(event) {
		$(this).css('background-color', '#F6F6F6');
	});
	$('.list-txt li,.list-set li,.list-img').on('mouseout', function(event) {
		$(this).css('background-color', '#FFFFFF');
	});
});