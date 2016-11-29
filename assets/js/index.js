// version 1.4

var menu_selected	= null;
var error_timeout	= null;
var last_call	= {callnum:'',callid:''};
var default_caller	= ''; //默认主叫
var default_que	= ''; //默认队列
var busy_btn_checked = false; //忙碌状态按钮点击过
var is_callin = false; //是否队列来电标记(true是 false不是)


//定义常量
var BUTTON_ON = 1;
var BUTTON_OFF = 2;
var MOUSE_ON = 3;
var OLMODEL_NONE = 0;//无长接通
var OLMODEL_AUTO = 1;//长接通
var OLMODEL_AUTOANSWER = 2//长接通并自动接听
var QUESTATE_LOGON = 1;//队列已登录/空闲
var user_phone_type;

var _pc;

$(document).ready(function (){

	//菜单效果
	$('.menu_item').focus(function (){
		this.blur();
	}).click(function (){
		if(menu_selected)
		{
			menu_selected.removeClass('selected');
		}
		$(this).addClass('selected');
		menu_selected = $(this);
		var tabTitle = $.trim($(this).text());
		tabTitle = tabTitle.replace('\u00a0', '');
		var url = $(this).attr('url');
		var icon = $('i',this).attr('class');
		addTab(tabTitle,url,icon);
	});

	
	//tab切换变形问题 /*点击工作桌面刷新*/
	$('#tabs').tabs({
		onSelect: function(title){
			$('#tabs').tabs('resize');
			if(title == '工作桌面')
			{
				var tab = $('#tabs').tabs('getSelected');
				$('#tabs').tabs('update', {
					tab: tab,
					options:{
						content:createFrame('index.php?c=main&m=workbench')
					}
				});
			}
		},
		onBeforeClose:function(title,index){
			
		}
	});

	window.onhashchange = function(){
	
	}

	/*window.onbeforeunload = function(){
	return "确认离开页面?";
	}*/



    // tabCloseEven();
});








//加选项卡函数
function addTab(subtitle,url,icon)
{
	if(!$('#tabs').tabs('exists',subtitle))
	{
		$('#tabs').tabs('add',{
			title:subtitle,
			content:createFrame(url),
			closable:true,
			// icon:icon,
			cache:false
		});
		/*双击关闭TAB选项卡*/
		$('.tabs-inner').dblclick(function(){
			var subtitle = $(this).children('span').text();
			if(subtitle != '工作桌面')
			$('#tabs').tabs('close',subtitle);
		});
	}
	else
	{
		$('#tabs').tabs('select',subtitle);
		var tab = $('#tabs').tabs('getSelected');
		$('#tabs').tabs('update', {
			tab: tab,
			options:{
				content:createFrame(url)
			}
		});
	}

    /*为选项卡绑定右键*/
    // $(".tabs-inner").bind('contextmenu',function(e){
    //     $('#mm').menu('show', {
    //         left: e.pageX,
    //         top: e.pageY
    //     });

    //     var subtitle =$(this).children(".tabs-closable").text();

    //     $('#mm').data("currtab",subtitle);
    //     $('#tabs').tabs('select',subtitle);
    //     return false;
    // });
}

function get_current_tabTitle()
{
	var selected = $('#tabs').tabs('getSelected');
	var title  = selected.panel('options').title;

	return title;
}

function closeTab(title)
{
	var opts = $('#tabs').tabs('options');
	opts.onBeforeClose = function(){};  // allowed to close now
	$('#tabs').tabs('close',title);
}

function createFrame(url)
{
	var s = "<iframe name='mainFrame' frameborder='0' scrolling='yes' src='"+url+"' style='width:100%;height:99%;'></iframe>";
	return s;
}



//绑定右键菜单事件
function tabCloseEven() {
    //刷新
    $('#mm-tabupdate').click(function(){
        var currTab = $('#tabs').tabs('getSelected');
        var url = $(currTab.panel('options').content).attr('src');
        if(url != undefined && currTab.panel('options').title != '工作桌面') {
            $('#tabs').tabs('update',{
                tab:currTab,
                options:{
                    content:createFrame(url)
                }
            })
        }
    })
    //关闭当前
    $('#mm-tabclose').click(function(){
        var currtab_title = $('#mm').data("currtab");
        $('#tabs').tabs('close',currtab_title);
    })
    //全部关闭
    $('#mm-tabcloseall').click(function(){
        $('.tabs-inner span').each(function(i,n){
            var t = $(n).text();
            if(t != '工作桌面') {
                $('#tabs').tabs('close',t);
            }
        });
    });
    //关闭除当前之外的TAB
    $('#mm-tabcloseother').click(function(){
        var prevall = $('.tabs-selected').prevAll();
        var nextall = $('.tabs-selected').nextAll();
        if(prevall.length>0){
            prevall.each(function(i,n){
                var t=$('a:eq(0) span',$(n)).text();
                if(t != '工作桌面') {
                    $('#tabs').tabs('close',t);
                }
            });
        }
        if(nextall.length>0) {
            nextall.each(function(i,n){
                var t=$('a:eq(0) span',$(n)).text();
                if(t != '工作桌面') {
                    $('#tabs').tabs('close',t);
                }
            });
        }
        return false;
    });
    //关闭当前右侧的TAB
    $('#mm-tabcloseright').click(function(){
        var nextall = $('.tabs-selected').nextAll();
        if(nextall.length==0){
            //msgShow('系统提示','后边没有啦~~','error');
            alert('后边没有啦~~');
            return false;
        }
        nextall.each(function(i,n){
            var t=$('a:eq(0) span',$(n)).text();
            $('#tabs').tabs('close',t);
        });
        return false;
    });
    //关闭当前左侧的TAB
    $('#mm-tabcloseleft').click(function(){
        var prevall = $('.tabs-selected').prevAll();
        if(prevall.length==0){
            alert('到头了，前边没有啦~~');
            return false;
        }
        prevall.each(function(i,n){
            var t=$('a:eq(0) span',$(n)).text();
            $('#tabs').tabs('close',t);
        });
        return false;
    });

}




