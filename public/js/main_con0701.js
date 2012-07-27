// JavaScript Document

$(function(){

	$(".tab_top").lc_tab({

	list_nav:".tab_top .tab_p li",

	box_nav:".tab_top .tab_con dl",

	on_class:"on",

	hover_class:"hov",

	num:0,

	hoverok:true,

	use_eve:"hover"

	});

	$(".tab_btm").lc_tab({

	list_nav:".tab_btm .tab_p li",

	box_nav:".tab_btm .tab_con dl",

	on_class:"on",

	hover_class:"hov",

	num:0,

	hoverok:true,

	use_eve:"hover"

	});		

	//首页焦点图	

	$("#Marquee").pictab({

		conBox:".content",

		onClass:"current",

		runTime:6000		//轮播停留的时间

	});		

	//跑马灯开始

	$(".imgbd .hoveimg").scrollPic({

		leftbtn:".lft",

		rightbtn:".rit",

		autotime:3000,

		runtime:300,

		distance:74,

		auto: true

	});	

	//返回顶部开始

	$(window).wowoScrollTop({

		width:68,

		height:99,

		runtime:400,

		scrolltop:130,

		bgimg:"bgimg/index_bg.png",

		pgoffset:[135,170],

		bgoffset:[[-104,-34],[-104,-34]]

	});	

	//底部鼠标滑过开始		

	$(".topic_lefcon table").onhover({

		className:"on"

	});			

	$("#footer .foot_nav ul li").onhover({

		className:"on"

	});			

	//头部导航滑过以及选中状态

	var navList=$("#header .nav ul li");

		var channelId=$("#headNav").val(),

			channelArr="nav_index|nav_cloth|nav_shoes|nav_ornam|nav_numb|nav_skin|nav_engag|nav_show|nav_style|nav_topic|nav_newmen",

			ChannelArr=channelArr.split("\|");

		$("li[date='"+ChannelArr[channelId-1]+"']").addClass("on");

	$("#header .nav_ul li").not(".on").onhover({

		className:"on"

	});	

	//首页列表部分鼠标滑过显示弹层

	$(".box_detail").onhover_con({

		objboxcon:".con_text"	

	});

	//首页搜素

	$("#header .rig .searchbox").wwSearch({

		btnID: "#search",

		changeClass : "on",

		textVal:"春季新款 夹克 风衣 T恤 卫衣 毛衣"

	});	

	//搜索页面搜索

	$(".sousuo_main").wwSearch({

		btnID: "#search_main",

		changeClass : "on",

		textVal:"请输入搜索内容"

	});			

	//input框点击添加样式

	$(".reg_from .intxtbg").bor({

		changeClass:"bor2",

		changeInput:".int"

	});	

	$(".log_form .intxtbg").bor({

		changeClass:"bor2",

		changeInput:".int"

	});		

	$(".telogin .intxtbg").bor({

		changeClass:"bor2",

		changeInput:".int"

	});

	//一级页面广告焦点图

	$(".avdbox").avdbanner({

		imgBox:".listimg"		

	});

	$(".bds_more").switchstate({});

	//加入收藏开始

	var jia = document.getElementById("jia");

	jia.onclick = function(){

		addfavorite();

	};

	function addfavorite(){

		var Urlnow = window.location.href;

		   if (document.all)

		   {

			  window.external.addFavorite(Urlnow,'收藏夹');

		   }

		   else if (window.sidebar)

		   {

			  window.sidebar.addPanel('测试', Urlnow, "");

		   };

	};		

			

})	





	

	

	

	

	

	

	

	

	

	

	

	

	



