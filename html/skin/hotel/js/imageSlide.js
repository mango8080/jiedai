// JavaScript Document
$.fn.imageSlide=function(param){
	var par=param?param:{
			imgShow:'.fouce div',
			trigger:'.boxone ul li',
			activeClass:'active'
		}
	_imgShow=par.imgShow;
	_trigger=par.trigger;
	_activeClass=par.activeClass;
	var slideSwitch=function(){			
            var $active = $(''+_imgShow+'.'+_activeClass+','+_trigger+'.'+_activeClass+'');
            if ($active.length == 0) $active = $(''+_imgShow+':last,'+_trigger+':last');		
            var $next = $active.next().length ? $active.next(): $(''+_imgShow+':first,'+_trigger+':first');
			$active.addClass('last-active');
			$active.removeClass(_activeClass);
            $next.css({ opacity: 0.0 }).addClass(_activeClass).animate({ opacity: 1.0 }, 1000, function(){
					$active.removeClass('last-active');																				
        	});		
		}	
	var autoPlay=function(){
		_ivt=window.setInterval(slideSwitch, 4000);	
	}
	var stopPlay=function(){
		window.clearInterval(_ivt);
	}	
	$(_trigger).hover(function(){		
		stopPlay();			   
		var num=$(this).index();	
		var $active = $(''+_imgShow+'.'+_activeClass+','+_trigger+'.'+_activeClass+'');
		$active.addClass('last-active');
		$active.removeClass(_activeClass);
		$(_imgShow).eq(num).css({ opacity: 0.0 }).addClass(_activeClass).animate({ opacity: 1.0 }, 1000, function(){
					$active.removeClass('last-active');																				
        });	
		$(this).addClass(_activeClass);	
//		$(''+_imgShow+','+_trigger+'').removeClass(_activeClass);
//		$(this).addClass(_activeClass);
//		$(_imgShow).eq(num).addClass(_activeClass);		
		
		},function(){			
			autoPlay();			
	});
	autoPlay();
		
}