jQuery(document).ready(function($) {
	var total = function(){
		var intime = $('input[name="post[intime]"]').val();
		var outtime = $('input[name="post[outtime]"]').val();
		var s = ((new Date(outtime.replace(/-/g,"\/"))) - (new Date(intime.replace(/-/g,"\/")))); 
		var day = s/1000/60/60/24;
		var perpirce = $('input[name="post[price]"]').val();
		var number = $('select[name="number"]').val();
		var quan = 0.0;
		if( day > 0 ){
			var  total = parseFloat(perpirce) * parseInt(day) * parseInt(number);
			$('#price').html(total.toFixed(1));
			$('input[name="quan[]"]').each(function(index, el) {
				var _this = $(this);
				if(_this.is(":checked")){
					var qp = parseFloat(_this.attr('data-price'));
					quan = parseFloat(quan) + qp;
				}
			});
			quan = quan.toFixed(1);
			$('#coupon').html('' + quan);
			var subtotal = parseFloat(total) + parseFloat(quan);
			$('#total').html(subtotal.toFixed(1));
			$('.box2_fr .nums').html(number);
			//console.log(subtotal);
		}
		
	}
	$('select[name="number"]').change(function(event) {
		total();
	});
	$('input[name="quan[]"]').change(function(){
		total();
	})
	$('input[name="post[intime]"]').focus(function(event) {
		ca_show('post[intime]', this, '-',total);
	});
	$('input[name="post[outtime]"]').focus(function(event) {
		ca_show('post[outtime]', this, '-',total);
		
	});
});