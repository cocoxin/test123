<?php /* Smarty version 2.6.19, created on 2016-11-16 09:33:10
         compiled from client_search_base.htm */ ?>
<div class="form-div box-shadow-class">
<form action="javascript:quick_search()" method="POST" name="searchForm"  id="searchForm" class="form-search">
   <div class="control-group  bottom_none">
        <label for="search_key">查询条件</label>
        <input type="text" data-toggle="tooltip" title="支持客户/联系人名称 或 电话(4位以上)搜索,注最多检索10条" 
           id="search_key" name="search_key" onclick='search_cle_name()' onblur='if_null()' value="客户姓名支持拼音首字母" />
        <button class="new_btn" type="button" onclick="$('#searchForm').submit();">
            <span class="iconfont">&#xe60c;&nbsp;</span>搜索 
        </button>
        <?php if ($this->_tpl_vars['power_client_add']): ?>
        <button class="new_other_btn" type="button" onclick="add_client()">
            <span class="iconfont">&#xe626;&nbsp;</span>添加客户 
        </button>
        <?php endif; ?>
   </div>
</form>
</div>
<div id="more_div" style="margin-bottom:10px;margin-top:0px;" onclick="select_fun(1)">
    <span class="iconfont" title='高级搜索'>&#xe60f;</span>
</div>
<div class="tabs_list">

    <?php if ($this->_tpl_vars['flag'] == 'my_client'): ?>
        <div class="tabs_large active" id='td0' onclick="visit_type = '0';set_active('td0'); quick_search('visit');">
            <span>我的客户</span>
        </div>
    <?php else: ?>
        <div class="tabs_large active" id='td0' onclick="visit_type = '0';set_active('td0'); quick_search('visit');">
            <span>全部客户</span>
        </div>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['power_cle_stat']): ?>
        <div class="tabs_large" id='td1' onclick="visit_type='1';set_active('td1'); quick_search('visit');">
            <span>今天已呼通</span>
        </div>
    <?php endif; ?>
    <div class="tabs_large"  id='td2' onclick="visit_type='2';set_active('td2'); quick_search('visit');">
        <span>今天要回访</span>
    </div>
    <div class="tabs_large"  id='td3' onclick="visit_type='3';set_active('td3'); quick_search('visit');">
        <span>3天内要回访</span>
    </div>
    <div class="tabs_large"  id='td4' onclick="visit_type='4';set_active('td4'); quick_search('visit');">
        <span>过期未回访</span>
    </div>

    <?php if ($this->_tpl_vars['power_cle_stat']): ?>
        <div class="tabs_large"  id='td5' onclick="stat_type='未拨打';set_active('td5'); quick_search('stat');">
            <span>未拨打</span>
        </div>
        <div class="tabs_large"  id='td6' onclick="stat_type='未呼通';set_active('td6'); quick_search('stat');">
            <span>未呼通</span>
        </div>
    <?php endif; ?>
</div>
<script language="JavaScript" type="text/javascript">
$(document).ready(function(){
	//text绑定回车事件
	$("input[type='text']").keydown(function(event){
		if(event.keyCode == 13){
			$('#searchForm').submit();
		}
	});
	$('#search_key').on('focus', function(){
		$(this).tooltip({placement: 'bottom'}).tooltip('show');
	});
});

function add_client(){
    window.parent.addTab('添加客户',"index.php?c=client&m=new_client","menu_icon");
}

/*1：今天已联系/2:今天要回访/3:7天内要回访/4:过期未回访*/
var visit_type = "";
/*未拨打  / 未呼通 */
var stat_type = "";
/*客户阶段*/
//var stage_type = "";
//检索
function quick_search(type)
{
	/*客户名称*/
	if($('#search_key').val() == '客户姓名支持拼音首字母')
	{
		var search_key = '';
	}
	else
	{
		var search_key = $('#search_key').val();
	}

    if(type=='visit')
    {
        stat_type = "";
    }else{
        visit_type = "";
    }

	$('#client_list').datagrid('options').queryParams = {};
	var queryParams = $('#client_list').datagrid('options').queryParams;
	queryParams.visit_type = visit_type;
	
	queryParams.cle_stat   = stat_type;
	//queryParams.cle_stage  = stage_type;
	queryParams.search_key = search_key;
	<?php if ($this->_tpl_vars['flag'] == 'my_client'): ?>
	queryParams.user_id   = '<?php echo $this->_tpl_vars['user_session_id']; ?>
';
	<?php endif; ?>
	$('#client_list').datagrid('reload');
}

//点击清空
function search_cle_name()
{
	var _name = $('#search_key').val();
	if(_name == '客户姓名支持拼音首字母')
	{
		$('#search_key').css('color','#000000');
		$('#search_key').val('');
	}
}
//判断是否为空
function if_null()
{
	var name_value = $('#search_key').val();
	if(name_value.length == 0)
	{
		$('#search_key').css('color','#cccccc');
		$('#search_key').val('客户姓名支持拼音首字母');
	}
}

function set_color_all(id)
{
    //全部数据、我的数据
    if( id == "all1" )
    {
        //清除所有选中
        $('A[id^="all"]').css('color','#335b64');
        $('A[id^="deal"]').css('color','#335b64');
    }
    else
    {
        /*1已分配   2未分配*/
        if( id == "all2"  || id == "all3"  || id == "all4" || id == "all5" )
        {
            $('A[id^="all"]').css('color','#335b64');
        }

        /*1未处理  2已处理*/
        if( id == "deal1" || id == "deal2" )
        {
            $('A[id^="deal"]').css('color','#335b64');
        }

    }

    //选中变色
    $('#'+id).css('color','red');
}


</script>