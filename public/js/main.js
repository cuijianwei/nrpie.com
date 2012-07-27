// JavaScript Document

(function($){

//选项卡

$.fn.lc_tab = function(options){

	var $this = $(this),_this = this;

	var opts = $.extend({

		list_nav:"",//导航列表

		box_nav:"",//显示文本列表

		on_class:"",//导航选中效果

		hover_class:"",//导航滑过效果

		num:"",//默认选中项

		hoverok:true,//滑过效果要不要

		use_eve:""//触发事件

		},options);

	if($this.length == 0) return false;

	var listNav = $(opts.list_nav),

		boxNav = $(opts.box_nav),

		Num = opts.num,

		onClass = opts.on_class,

		hoverClass = opts.hover_class,

		hoverOk = opts.hoverok,

		useEve = opts.use_eve;

		//设置默认显示项

		listNav.eq(Num).addClass(onClass);

		boxNav.eq(Num).show();

		//导航划过效果

	var firstEve = function(){

		  if(!$(this).hasClass(onClass)){

			$(this).addClass(hoverClass);

		   };

		};

	var secondEve = function(){

		$(this).removeClass(hoverClass);

		};

		//判断是否执行划过效果

	if(hoverOk == true){

			listNav.hover(firstEve,secondEve);

		}

		//选项卡切换效果

	var tabEve = function(){

		var $num = $(this).index();

		    listNav.removeClass(onClass);

		    boxNav.hide();

		    listNav.eq($num).addClass(onClass);

		    boxNav.eq($num).show();

			listNav.removeClass(hoverClass);

		};

		//执行

		listNav.bind(useEve,tabEve);	

	

};	



//焦点图开始

$.fn.pictab = function(options){

		var $this = $(this),_this=this;	

		var opts = $.extend({

			conBox:".content",

			onClass:"current",

			runTime:5000		//轮播停留的时间

		},options);

		var menuli = $this.find("ul li"),conbox=$(opts.conBox),num = menuli.size()-1;

		//设置默认项

		menuli.first().addClass(opts.onClass);

		$(opts.conBox).first().show();

		//点击事件

		var clickEvent = function(){

			var index = $(this).index();

			menuli.removeClass(opts.onClass);

			$(opts.conBox).hide();

			menuli.eq(index).addClass(opts.onClass);

			$(opts.conBox).eq(index).show();

		};		

		var nextEvent = function(){

			var _currli = $this.find("li."+opts.onClass);//获取当前的li

				_conbox = $this.find(opts.conBox+":visible");//获取当前的内容图片

			var _currindex = _currli.index();//获取当前的索引值

			_currli.removeClass(opts.onClass);

			_conbox.hide();

			if(_currindex<num){

				_currli.next().addClass(opts.onClass);

				_conbox.next().show();

			}else{

				menuli.first().addClass(opts.onClass);

				conbox.first().show();

			}

			return false;

		};

		//轮播

		picnum = setInterval(nextEvent,opts.runTime);

		var stopEvent = function(){

			window.clearInterval(picnum)	

		};

		var beginEvent = function(){

			picnum = setInterval(nextEvent,opts.runTime);

		};		

		

		menuli.bind("mouseover",clickEvent);

		$this.hover(stopEvent,beginEvent);//轮播

	};	



//焦点图结束



//跑马灯开始

$.fn.scrollPic = function(options){

		var $this = $(this), _this = this,isover = true, tt;

		var opts = $.extend({

				leftbtn:".lft",

				rightbtn:".rit",

				autotime:1000,

				runtime:10,

				distance:74,

				auto: false 

		},options);

		if($this.length == 0) return false;

		var _objul = $this.find("ul"),

		       _size = _objul.find("li").size();

			  // alert(_size)

		

		var leftEvent = function(){

		var	objfirst = $this.find("li:first"),

				objlast = $this.find("li:last");

				//objlast.after(objfirst);//让第一个查到最后一个的后面去   注释的为特简单方法 无动画效果

				objfirst.animate({'margin-left':'-' + opts.distance +'px'},opts.runtime,function(){

					$(this).insertAfter(objlast).removeAttr("style");

					isover = true;

				});

		};

		var rightEvent = function(){

		var	objfirst = $this.find("li:first"),

		

				objlast = $this.find("li:last");

				//objfirst.before(objlast);//让最后一个查到第一个前面去

				objfirst.before(objlast.css({'margin-left':'-' + opts.distance+'px'}));

				objlast.animate({'margin-left':'0'+'px'},opts.runtime,function(){

					$(this).removeAttr("style");

					isover = true;	

				});

		};

		var intEvent = function(){

				_objul.width(opts.distance*_size);

				if(isover){$(opts.leftbtn).bind("click",leftEvent)};

				if(isover){$(opts.rightbtn).bind("click",rightEvent)};

				if(opts.auto){

					beginEvent();

					$this.hover(stopEvent,beginEvent);

				};

		};

		//轮播		

		var beginEvent = function(){

			tt = window.setInterval(leftEvent,opts.autotime);

		};

		var stopEvent = function(){

			if(tt) window.clearInterval(tt);

		};

		intEvent();	   

	};



//跑马灯结束

//返回顶部的插件

//兼容IE6的

	$.fn.ieFixed = function(options) {

			var opts = $.extend({

				x: 0,

				y: 0

			}, options),

			isIe6 = ($.browser.msie && parseInt($.browser.version) == 6)?true:false;

			if (isIe6) {

				var $html =  $("html");

				($html.css("backgroundAttachment") !== "fixed") && ($html.css("backgroundAttachment", "fixed"));

				($html.css("backgroundImage")=="none") && ($html.css("backgroundImage", "url(about:blank)"));

			};

			return this.each(function() {

				var $this = $(this),_this = this;

				if (isIe6){

					$this.css("position", "absolute");

					_this.style.setExpression("left", 'eval(document.documentElement.scrollLeft + ' + opts.x + ') + "px"');

					_this.style.setExpression("top", 'eval(document.documentElement.scrollTop + ' + opts.y + ') + "px"');

				}else{

					$this.css("position", "fixed").css("top", opts.y).css("left", opts.x)

				};

			});

		};

	$.fn.wowoScrollTop = function(options){

		var $this = $(this),_this=this;

		var opts = $.extend({

			width : 69,

			height : 99,

			runtime : 400,

			scrolltop : 130,

			bgimg : "",

			pgoffset : [50,70],

			bgoffset : [[-104,-34],[-104,-34]]

		},options);	

		if($this.length == 0) return false;

		var _objicon = $("<a href='javascript:'></a>").css({

			"width":opts.width+"px",

			"height":opts.height+"px",

			"background":"url("+opts.bgimg+") no-repeat " + opts.bgoffset[1][0]+"px "+opts.bgoffset[1][1]+"px",

			"overflow":"hidden",

			"line-height":999

		}).hide();

		var scrollTopEvent = function(){

			var _scrolltop = $(document).scrollTop(),

				  _width = $(window).width(),

				  _height = $(window).height(),

				  _pagetop = _scrolltop+_height,

				  _footertop = $("#footer").offset().top,

				  _x = _width - opts.pgoffset[0],

				  _y = (_pagetop >= _footertop) ? _footertop - _scrolltop - opts.pgoffset[1] : _height -opts.pgoffset[1];

			if (_scrolltop > opts.scrolltop){

				_objicon.ieFixed({

					x: _x,

					y: _y

				}).show();

			}else{

				_objicon.hide();

			}

		};

		var gotoTopEvent = function(){

			$('html,body').animate({

				scrollTop: 0

			},opts.runtime);

			return false;		

		};

		_objicon.hover(function(){

			$(this).css({"background-position":opts.bgoffset[0][0]+"px "+opts.bgoffset[0][1]+"px"});

		},function(){

			$(this).css({"background-position":opts.bgoffset[1][0]+"px "+opts.bgoffset[1][1]+"px"});

		});

		$("body").append(_objicon);

		$this.bind("scroll resize",scrollTopEvent);

		_objicon.bind("click",gotoTopEvent);

	};

//返回顶部的插件结束



//鼠标滑过插件

$.fn.onhover = function(options){

	var $this = $(this), _this = this;

	var opts = $.extend({

				className:"on"

		},options);

		if($this.length == 0) return false;

		 var beginEvent = function() {

            $(this).addClass(opts.className);

        };

        var endEvent = function() {

            $(this).removeClass(opts.className);

        };

		$(this).hover(beginEvent, endEvent)

	

	}



//首页弹层插件

$.fn.onhover_con = function(options){

	var $this = $(this), _this = this;

	var opts = $.extend({

				objboxcon:""

		},options);

		if($this.length == 0) return false;

		var _objboxcon=$(opts.objboxcon)

		 var beginEvent = function() {

            $(this).find(_objboxcon).slideDown(200);

        };

        var endEvent = function() {

            $(this).find(_objboxcon).slideUp(200);

        };

		$(this).hover(beginEvent, endEvent)

	

	}



//首页搜索

$.fn.wwSearch = function(options){  //搜索

		var $this = $(this),_this=this;

		var opts = $.extend({

			btnID: "#soso_submit",

			changeClass : "on",

			textVal : "输入商品、商家、分类名称"

		},options);

		var objtext = $this.find("input[type='text']"),objform = $this.find("form"),objbtn = $(opts.btnID);

		if($this.length==0) return false;	  

		var txtFocusEvent = function(){

			var textval = $.trim(objtext.val()).replace(/^\s+|\s+$/g,'');

			if(textval==opts.textVal){

				$this.addClass("on");

				objtext.val('');

			}else{

				return false;

			}

		};

		var txtBlurEvent = function(){

			var textval = $.trim(objtext.val()).replace(/^\s+|\s+$/g,'');

			if(textval==''){

				$this.removeClass("on");

				objtext.val(opts.textVal);

			}else{

				return false;

			}	

		};

		var btnClickEvent = function(){

			

			var textval = $.trim(objtext.val()).replace(/^\s+|\s+$/g,'');

			if(textval=='' || textval==opts.textVal) return false;

			objform.submit();

		};

		objtext.bind("focus",txtFocusEvent);

		objtext.bind("blur",txtBlurEvent);

		objbtn.bind("click",btnClickEvent);

	};

	//input框点击样式

	$.fn.bor = function(options){

		var $this = $(this),_this=this;			

		if($this.length==0) return false;

		var opts = $.extend({		

			changeClass:"bor2",

			changeInput:".int"

		},options);

		var useInput =$this.find(opts.changeInput);				

		var txtFocusEvent = function(){

			$(this).parent().addClass(opts.changeClass);

		};

		var txtBlurEvent = function(){

			$(this).parent().removeClass(opts.changeClass);

		};

		useInput.bind("focus",txtFocusEvent);

		useInput.bind("blur",txtBlurEvent);			

	};

	//一级页面广告焦点图

	$.fn.avdbanner = function(options){

		var $this = $(this),_this=this;	

		var opts = $.extend({

			imgBox:".listimg"		

		},options);

		if($this.length == 0) return false;

		var initEvent =function(){

			var curimgli = $(opts.imgBox).find("li:visible");

			var currindex=curimgli.index();	//获取当前图片的索引值	

			var Numimg = $(opts.imgBox).find("li").size()-1;

			$this.find(".count").html((currindex+1)+"/"+(Numimg+1));

		};

		var lftEvent = function(){

			var curimgli = $(opts.imgBox).find("li:visible");

			var currindex=curimgli.index();	//获取当前图片的索引值	

			var Numimg = $(opts.imgBox).find("li").size()-1;		

			if(currindex!=0){

				$this.find(".count").html( (currindex)+"/"+(Numimg+1));

				curimgli.hide();

				curimgli.prev().show();

			}else{

				$this.find(".count").html("4/4");

				curimgli.hide();

				$(opts.imgBox).find("li:last").show();

			}

			return false;		

		};

		var ritEvent = function(){	

			var curimgli = $(opts.imgBox).find("li:visible");

			var currindex=curimgli.index();	//获取当前图片的索引值	

			var Numimg = $(opts.imgBox).find("li").size()-1;			

			if(currindex!=Numimg){

				$this.find(".count").html( (currindex+2)+"/"+(Numimg+1));

				curimgli.hide();

				curimgli.next().show();				

			}else{

				$this.find(".count").html("1/4");

				curimgli.hide();

				$(opts.imgBox).find("li:first").show();

			}			

			return false;		

		};

		initEvent();

		$this.find(".a_l").bind("click",lftEvent);

		$this.find(".a_r").bind("click",ritEvent);

	};

	//滑过状态隐藏显示

	$.fn.switchstate = function (options){ //我的窝窝券下来菜单开始

		var $this = $(this),_this=this;

		var opts = $.extend({		

			stateClass:"",

			changeClass:""	

		},options);

		if($this.length==0) return false;

		var beginEvent=function(){

			$(this).addClass(opts.changeClass);

		};

		var stopEvent=function(){

			$(this).removeClass(opts.changeClass);

		};

		$this.hover(beginEvent,stopEvent);

	};

})(jQuery)



