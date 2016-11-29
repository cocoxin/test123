<?php /* Smarty version 2.6.19, created on 2016-11-29 10:19:51
         compiled from wechat/wechat_info_list.htm */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'wechat/wechat_info_list.htm', 36, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div  class="main-margin-div" >
	<div class="form-div">
	  	<form class="form-search" action="javascript:quick_search()"  method="POST" name="searchForm" id="searchForm">
	        <div class="control-group bottom_none">
		      	<label>查询条件</label>
	        	<input type="text" id="search_theme" name="search_theme" class="form-input-width" placeholder="主题">
		        <button class="new_btn" type="button" onclick="quick_search()">
		        <span class="iconfont"></span>搜索
		      	</button>
		    </div>
	  	</form>
	</div>
</div>
<div  class="main-margin-div" >
	<table id="wechat_info_list_table"></table> <!-- 模板列表  -->
</div>
<div id="smsmodel_add_panel"></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
<script language="JavaScript" type="text/javascript">
$(document).ready(function(){
	$('#wechat_info_list_table').datagrid({
		title:'<b>公众号列表</b>',
        height:get_list_height_fit_window('_search_panel',10),
		nowrap: true,
		striped: true,
		pagination:true,
		rownumbers:true,
		fitColumns:true,
		checkOnSelect:false,
		pageSize:get_list_rows_cookie(),
		sortName:'create_time',
		sortOrder:'desc',//降序排列
		idField:'mod_id',
		url:'index.php?c=wechat&m=get_wechat_info_list',
		queryParams:{"condition":"<?php echo ((is_array($_tmp=@$this->_tpl_vars['condition'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
"},
		frozenColumns:[[
		{field:'ck',checkbox:true},
		{title:'mod_id',field:'mod_id',hidden:true},
		{title:'操作',field:'opter_txt',width:90,sortable:true,align:'center',formatter:function(value,rowData,rowIndex){
			return "<span><a href='javascript:;' onclick=edit_model('"+rowData.mod_id+"') title='编辑'>编辑</a>&nbsp;&nbsp;<a href='javascript:;' onclick=remove_model('"+rowData.mod_id+"') title='删除'>删除</a></span>";
		}}
		]],
		columns:[[
		{title:'appID',field:'appid',width:300,align:'left',},
		{title:'appsecret',field:'appsecret',width:300,align:'left',},
		{title:'token',field:'token',width:300,align:'left',},
		{title:'创建时间',field:'create_time',width:130,sortable:true,align:'center',}
		]],
		onLoadSuccess: function(){
			$('#wechat_info_list_table').datagrid('clearSelections');
			$('#wechat_info_list_table').datagrid('clearChecked');
		},
		toolbar:[
		{
			// iconCls:'iconfont',
			text:'<span>添加</span>',
			handler:function(){
				$('#smsmodel_add_panel').window({
					href:"index.php?c=sms&m=add_smsmodel",
					top:100,
					width:560,
					title:"添加模板",
					collapsible:false,
					minimizable:false,
					maximizable:false,
					resizable:false,
					cache:false
				});
			}
		},
		{
			// iconCls:'iconfont',
			text:'<span>删除</span>',
			handler:function(){
				var ids = getSelections();
				if(ids == '')
				{
					$.messager.alert('提示','请选中要删除的数据！','error');
					return;
				}
				$.messager.confirm('提示', '您确定要删除这些数据么？', function(r){
					if(r){
						$.ajax({
							type:"POST",
							url:'index.php?c=sms&m=remove_smsmodel',
							data:{'mod_id':ids},
							dataType:'json',
							success:function (responce){
								if(responce['error']=='0'){
									$('#smsmodel_list_table').datagrid('reload');
								}
								else
								{
									$.messager.alert('执行错误',responce['message'],'error');
								}
							}
						});
					}
					else
					{
						return false;
					}
				});
			}
		}],
		onDblClickRow:function (rowIndex, rowData)  //双击 编辑
		{
			edit_model(rowData.mod_id);
		}
	});
	var pager = $('#wechat_info_list_table').datagrid('getPager');
	$(pager).pagination({onChangePageSize:function(rows){
		set_list_rows_cookie(rows);
	}});

});
function getSelections(){
	var ids = [];
	var rows = $('#smsmodel_list_table').datagrid('getChecked');
	for(var i=0;i<rows.length;i++){
		ids.push(rows[i].mod_id);
	}
	return ids.join(',');
}
//编辑短信模板信息
function edit_model(mod_id){
	$('#smsmodel_add_panel').window({
		href:"index.php?c=sms&m=edit_smsmodel&mod_id="+mod_id,
        top:100,
		width:550,
		title:"编辑模板",
		collapsible:false,
		minimizable:false,
		maximizable:false,
		resizable:false,
		cache:false
	});
}

//单条删除模板信息
function remove_model(mod_id){
	$.messager.confirm('提示', '您确定要删除这条短信模板数据么？', function(r){
		if(r){
			$.ajax({
				type:'POST',
				url: "index.php?c=sms&m=remove_smsmodel",
				data: {"mod_id":mod_id},
				dataType: "json",
				success: function(responce){
					if(responce["error"] == 0)
					{
						$('#smsmodel_list_table').datagrid('reload');
					}
					else
					{
						$.messager.alert('错误',responce["message"],'error');
					}
				}
			});
		}else{
			return false;
		}
	});
}
/**
* 关键字搜索
*/
function quick_search()
{
	var stu_search_theme = $("#search_theme").val();

	var queryParams = $('#smsmodel_list_table').datagrid('options').queryParams;
	queryParams.search_theme = stu_search_theme;
	$('#smsmodel_list_table').datagrid('reload');
}
</script>