
var startDay,endDay;
function f_Confirm(){
    if(!startDay){
        return;
    }
	$("#checkInMonth").html(startDay.month+startDay.week);
	$("#checkInDay").html(startDay.day);
	
	$("#checkOutMonth").html(endDay.month+endDay.week);
	$("#checkOutDay").html(endDay.day);
	
	$('#widgetCalendar').stop().animate({height:  0 }, 500);
	state = !state;
}

function f_Cancel(){
	$('#widgetCalendar').stop().animate({height:  0 }, 500);
		state = !state;
}

(function($){
	var initLayout = function() {
			$('#widgetCalendar').DatePicker({
			flat: true,
			format: 'Y-m-d',
			date: [new Date(),new Date(GetDateStr(1))],
			calendars: 1,
			mode: 'range',
			starts: 1,
			onChange: function(formated) {
				
				var year0=formated[0].split("-")[0];
				var month0= formated[0].split("-")[1];
				var day0= formated[0].split("-")[2];
				
				var date0 = year0+"/"+month0+"/"+day0;
				
				var year1=formated[1].split("-")[0];
				var month1= formated[1].split("-")[1];
				var day1= formated[1].split("-")[2];
				
				var date1 = year1+"/"+month1+"/"+day1;
				
				if(formated[0]!=formated[1]){
					startDay={date:formated[0],
							day:(new Date(date0)).getDate(),
							week:getWeek(new Date(date0)),
							month:((new Date(date0)).getMonth()+1)+'月'};
					endDay={date:formated[1],
							day:(new Date(date1)).getDate(),
							week:getWeek(new Date(date1)),
							month:((new Date(date1)).getMonth()+1)+'月'};
				}else{
					startDay={date:formated[0],
							day:(new Date(date0)).getDate(),
							week:getWeek(new Date(date0)),
							month:((new Date(date0)).getMonth()+1)+'月'};
					formated[1]=GetDateStrs(formated[0],1);
					endDay={date:formated[1],
							day:(new Date(date1)).getDate(),
							week:getWeek(new Date(date1)),
							month:((new Date(date1)).getMonth()+1)+'月'};
				}
			},
			onRender: function(date) {
					return {
						disabled: duibi(getNowFormatDate(date) , getNowFormatDate(new Date()) )
					}
			}
		});
		$('#widgetCalendar div.datepicker').css('position', 'absolute');
	};
	
	
	
	
	function duibi(a, b) {
	    var arr = a.split("-");
	    var starttime = new Date(arr[0]+"/"+arr[1]+"/"+arr[2]);
	    var starttimes = starttime.getTime();

	    var arrs = b.split("-");
	    var lktime = new Date(arrs[0]+"/"+arrs[1]+"/"+arrs[2]);
	    var lktimes = lktime.getTime();

	    if (starttimes >= lktimes) {
	        return false;
	    }
	    else{
	        return true;
	    }

		}
	
	
	var showTab = function(e) {
		var tabIndex = $('ul.navigationTabs a')
							.removeClass('active')
							.index(this);
		$(this)
			.addClass('active')
			.blur();+
		$('div.tab')
			.hide()
				.eq(tabIndex)
				.show();
	};
	
	EYE.register(initLayout, 'init');
})(jQuery)