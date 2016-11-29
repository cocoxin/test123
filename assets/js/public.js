/**
* 写列表显示行数cookie
**/
function set_list_rows_cookie(row)
{
	if(row >= 10 && row !== get_cookie('list_rows'))
	{
		set_cookie('list_rows',row);
	}
}
/**
* 获取列表显示行数cookie
**/
function get_list_rows_cookie()
{
	var row = get_cookie('list_rows');
	if(row == null || row < 10)
	{
		set_list_rows_cookie(10);
		row = 10;
	}
	return row;
}
/**
* 写cookies函数
**/
function set_cookie(name,value)
{
	var Days = arguments[2];
	if(Days>0)
	{
		var exp  = new Date();  //new Date("December 31, 9998");
		exp.setTime(exp.getTime() + Days*24*60*60*1000);
		document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
	}
	else
	{
		document.cookie = name + "="+ escape (value);
	}
}
/**
* 取cookies函数
**/
function get_cookie(name)
{
	var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
	if(arr != null) return unescape(arr[2]);
	return null;
}
/**
* 删除cookie
**/
function del_cookie(name)
{
	var Days = -1; //此 cookie 将被保存 30 天
	var exp  = new Date();  //new Date("December 31, 9998");
	exp.setTime(exp.getTime() + Days*24*60*60*1000);
	document.cookie = name + "="+ '0' + ";expires=" + exp.toGMTString();
}

/**
* 得到列表高度以适应窗口
*
**/
function get_list_height_fit_window()
{
	var _height = 0;
	var search_panel_id = arguments[0];
	var minus_height = 0;
	if (arguments[1]) {
		minus_height = arguments[1];
	}
	if(!dom_if_exist(search_panel_id))
	{
		search_panel_id = '';
	}
	if(search_panel_id == '')
	{
		_height = $(window).height() -50 -minus_height;
	}
	else
	{
		_height = $(window).height()-$('#'+search_panel_id).height() -50 -minus_height;
	}
	if(_height < 350)
	{
		_height = 350;
	}
	return _height;
}
/**
* 元素是否存在 存在ture 不存在 false
*
**/
function dom_if_exist(dom_id)
{
	if($('#'+dom_id).size() == 0)
	{
		return false;
	}
	else
	{
		return true;
	}
}

/**
*判断对象是否为空
*/
function empty_obj(obj)
{
	var result = true;
	$.each(obj, function(property,value) {
		//针对对象
		if(  value )
		{
			result = false;
			return result;
		}
	});

	return result;
}

/**
*  发短信
*phone_num   号码
*from_file   字段： 如果存在from_file 直接从from_file 中去取得号码，如果from_file 取得的号码有*号 那么用phone_num
*/
function sys_send_sms(phone_num)
{
	if(arguments[1])
	{
		var from_file = arguments[1];
		var tmp_phone_num = $('#'+from_file).val();
		if(tmp_phone_num &&  !exist_star(tmp_phone_num) )
		{
			phone_num = tmp_phone_num;
		}
	}

	if(!dom_if_exist('sys_send_sms_panel'))
	{
		$("<div id='sys_send_sms_panel'></div>").appendTo("body");
	}

	$('#sys_send_sms_panel').window({
		href:"index.php?c=sms&m=send_sms&receiver_phone="+phone_num,
		top:80,
		width:670,
		title:"发短信",
		collapsible:false,
		minimizable:false,
		maximizable:false,
		resizable:false,
		modal:true,
		cache:false
	});
}

function set_active(id)
{
	$('#'+id).parent().children("div").attr('class','tabs_large');
	$('#'+id).attr("class","tabs_large active");
}

/**
* json语句转成字符串
*/
function json2str(o)
{
	var arr = [];
	var fmt = function(s) {
		if(typeof s == 'function')
		return;
		else if (typeof s == 'object' && s != null)
		return json2str(s);
		else
		return /^(string|number|undefined)$/.test(typeof s) ? '"' + s + '"' : s;
	}
	for (var i in o)
	{
		if(i == 'source')
		{
			arr.push('"' + i + '":' + o[i].index);
		}
		else if(i == 'destination')
		{
			arr.push('"' + i + '":' + o[i].index);
		}
		else if(typeof o[i] != 'function')
		{
			arr.push('"' + i + '":' + fmt(o[i]));
		}
	}
	return '{' + arr.join(',') + '}';
}
/**
* json 语句 转成 url
*/
function json2url(json){
	var tmps = [];
	var urlstr = "";
	$.each(json, function(property,value) {
		tmps.push(property + '=' + value);
	});
	return tmps.join('&');
}