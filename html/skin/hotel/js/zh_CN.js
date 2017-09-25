/*********************************
 * Themes, rules, and i18n support
 * Locale: Chinese; 中文
 *********************************/
(function(factory) {
    if (typeof define === 'function') {
        define(function(require, exports, module){
            var $ = require('jquery');
            $._VALIDATOR_URI = module.uri;
            require('../src/jquery.validator')($);
            factory($);
        });
    } else {
        factory(jQuery);
    }
}(function($) {
    /* Global configuration
     */
	 if($("html").attr("lang") == "en"){
	 	$.validator.config({
			//stopOnError: false,
			//theme: 'yellow_right',
			defaultMsg: "This field is not valid.",
			loadingMsg: "Validating...",
			
			// Custom rules
			rules: {
				tel: [/^(?:(?:0\d{2,3}[\- ]?[1-9]\d{6,7})|(?:[48]00[\- ]?[1-9]\d{6}))$/, ""]
				,mobile: [/^1[3-9]\d{9}$/, "Please enter the correct phone number"]
				,email: [/^[\w\+\-]+(\.[\w\+\-]+)*@[a-z\d\-]+(\.[a-z\d\-]+)*\.([a-z]{2,4})$/i, "Please enter the correct email"]
				,username: [/^\w{3,12}$/, ""]
				,chinesename: [/^([\u4e00-\u9fa5]{2,25}|([a-zA-Z]+\s?){2,25})$/, "Please enter the correct name"]
				,password: [/^[0-9a-zA-Z]{6,16}$/, ""]
				,accept: function (element, params){
					if (!params) return true;
					var ext = params[0];
					return (ext === '*') ||
						   (new RegExp(".(?:" + (ext || "png|jpg|jpeg|gif") + ")$", "i")).test(element.value) ||
						   this.renderMsg("只接受{1}后缀", ext.replace('|', ','));
				}
			}
		});
	
		/* Default error messages
		 */
		$.validator.config({
			messages: {
				required: "This field is required.",
				remote: "Please try another name."
			}
		});
	 } else if ($("html").attr("lang") == "ja-JP"){
	 	$.validator.config({
			//stopOnError: false,
			//theme: 'yellow_right',
			defaultMsg: "このフィールドは有効ではありません",
			loadingMsg: "検証プロセス...",
			
			// Custom rules
			rules: {
				tel: [/^(?:(?:0\d{2,3}[\- ]?[1-9]\d{6,7})|(?:[48]00[\- ]?[1-9]\d{6}))$/, ""]
				,mobile: [/^1[3-9]\d{9}$/, "お電話番号を正しく入力してください"]
				,email: [/^[\w\+\-]+(\.[\w\+\-]+)*@[a-z\d\-]+(\.[a-z\d\-]+)*\.([a-z]{2,4})$/i, "メールアドレスを正しく入力してください"]
				,username: [/^\w{3,12}$/, ""]
				,chinesename: [/^([\u4e00-\u9fa5]{2,25}|([a-zA-Z]+\s?){2,25})$/, "お名前を正しく入力してください"]
				,password: [/^[0-9a-zA-Z]{6,16}$/, ""]
				,accept: function (element, params){
					if (!params) return true;
					var ext = params[0];
					return (ext === '*') ||
						   (new RegExp(".(?:" + (ext || "png|jpg|jpeg|gif") + ")$", "i")).test(element.value) ||
						   this.renderMsg("只接受{1}后缀", ext.replace('|', ','));
				}
			}
		});
	
		/* Default error messages
		 */
		$.validator.config({
			messages: {
				required: "このフィールドは必須です",
				remote: "この値が使用されている",
				
			}
		});
	 } else {
		$.validator.config({
			//stopOnError: false,
			//theme: 'yellow_right',
			//defaultMsg: "{0}格式不正确",
			loadingMsg: "正在验证...",
			
			// Custom rules
			rules: {
				digits: [/^\d+$/, "请输入数字"]
				,phone: [/^\d+$/, "请输入数字"]
				,letters: [/^[a-z]+$/i, "{0}只能输入字母"]
				,tel: [/^(?:(?:0\d{2,3}[\- ]?[1-9]\d{6,7})|(?:[48]00[\- ]?[1-9]\d{6}))$/, "格式不正确"]
				,mobile: [/^1[3-9]\d{9}$/, "格式不正确"]
				,email: [/^[\w\+\-]+(\.[\w\+\-]+)*@[a-z\d\-]+(\.[a-z\d\-]+)*\.([a-z]{2,4})$/i, "邮箱格式不正确"]
				,qq: [/^[1-9]\d{4,}$/, "QQ号格式不正确"]
				,date: [/^\d{4}-\d{1,2}-\d{1,2}$/, "请输入正确的日期,例:yyyy-mm-dd"]
				,time: [/^([01]\d|2[0-3])(:[0-5]\d){1,2}$/, "请输入正确的时间,例:14:30或14:30:00"]
				,ID_card: [/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])((\d{4})|\d{3}[A-Z])$/, "请输入正确的身份证号码"]
				,url: [/^(https?|ftp):\/\/[^\s]+$/i, "网址格式不正确"]
				,postcode: [/^[1-9]\d{5}$/, "邮政编码格式不正确"]
				//,chinesename: [/[\u4E00-\u9FA5]{2,5}(?:·[\u4E00-\u9FA5]{2,5})*/, "名字格式错误"]
				,username: [/^\w{3,12}$/, "请输入3-12位数字、字母、下划线"]
				,chinesename: [/^([\u4e00-\u9fa5]{2,25}|([a-zA-Z]+\s?){2,25})$/, "请输入准确的姓名"]
				, address: [/^([\u4e00-\u9fa50-9]{2,25}|([a-zA-Z0-9]+\s?){2,25})$/, "请输入正确地址"]
				, company: [/^([\u4e00-\u9fa5]{2,25}|([a-zA-Z]+\s?){2,25})$/, "请输入正确发票抬头"]
				,password: [/^[0-9a-zA-Z]{6,16}$/, "密码由6-16位数字、字母组成"]
				,accept: function (element, params){
					if (!params) return true;
					var ext = params[0];
					return (ext === '*') ||
						   (new RegExp(".(?:" + (ext || "png|jpg|jpeg|gif") + ")$", "i")).test(element.value) ||
						   this.renderMsg("只接受{1}后缀", ext.replace('|', ','));
				}
				
			}
		});
	
		/* Default error messages
		 */
		$.validator.config({
			messages: {
				required: "{0}必填",
				remote: "{0}已被使用",
				integer: {
					'*': "请输入整数",
					'+': "请输入正整数",
					'+0': "请输入正整数或0",
					'-': "请输入负整数",
					'-0': "请输入负整数或0"
				},
				match: {
					eq: "{0}与{1}不一致",
					neq: "{0}与{1}不能相同",
					lt: "{0}必须小于{1}",
					gt: "{0}必须大于{1}",
					lte: "{0}必须小于或等于{1}",
					gte: "{0}必须大于或等于{1}"
				},
				range: {
					rg: "请输入{1}到{2}的数",
					gte: "请输入大于或等于{1}的数",
					lte: "请输入小于或等于{1}的数"
				},
				checked: {
					eq: "请选择{1}项",
					rg: "请选择{1}到{2}项",
					gte: "请至少选择{1}项",
					lte: "请最多选择{1}项"
				},
				length: {
					eq: "请输入{1}个字符",
					rg: "请输入{1}到{2}个字符",
					gte: "请至少输入{1}个字符",
					lte: "请最多输入{1}个字符",
					eq_2: "",
					rg_2: "",
					gte_2: "",
					lte_2: ""
				}
			}
		});
	 }
    

    /* Themes
     */
    var TPL_ARROW = '<span class="n-arrow"><b>◆</b><i>◆</i></span>';
    $.validator.setTheme({
        'simple_right': {
            formClass: 'n-simple',
            msgClass: 'n-right'
        },
        'simple_bottom': {
            formClass: 'n-simple',
            msgClass: 'n-bottom'
        },
        'yellow_top': {
            formClass: 'n-yellow',
            msgClass: 'n-top',
            msgArrow: TPL_ARROW
        },
        'yellow_right': {
            formClass: 'n-yellow',
            msgClass: 'n-right',
            msgArrow: TPL_ARROW
        },
        'yellow_right_effect': {
            formClass: 'n-yellow',
            msgClass: 'n-right',
            msgArrow: TPL_ARROW,
            msgShow: function($msgbox, type){
                var $el = $msgbox.children();
                if ($el.is(':animated')) return;
                if (type === 'error') {
                    $el.css({
                        left: '20px',
                        opacity: 0
                    }).delay(100).show().stop().animate({
                        left: '-4px',
                        opacity: 1
                    }, 150).animate({
                        left: '3px'
                    }, 80).animate({
                        left: 0
                    }, 80);
                } else {
                    $el.css({
                        left: 0,
                        opacity: 1
                    }).fadeIn(200);
                }
            },
            msgHide: function($msgbox, type){
                var $el = $msgbox.children();
                $el.stop().delay(100).show().animate({
                    left: '20px',
                    opacity: 0
                }, 300, function(){
                    $msgbox.hide();
                });
            }
        }
    });
}));