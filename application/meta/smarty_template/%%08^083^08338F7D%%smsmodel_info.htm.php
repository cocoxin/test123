<?php /* Smarty version 2.6.19, created on 2016-11-17 07:34:37
         compiled from smsmodel_info.htm */ ?>
<div class="main-div main-win">
  <input type="hidden" name="mod_id" id="mod_id" value="<?php echo $this->_tpl_vars['smsmodel_info']['mod_id']; ?>
">
  <div class="control-group" >
    <label>主题</label>
    <input class="easyui-validatebox" required="true" size="50" type="text" name="theme" id="theme" missingMessage="模板主题不能为空"  value="<?php echo $this->_tpl_vars['smsmodel_info']['theme']; ?>
">
  </div>
  <div class="control-group" >
    <label>信息内容</label>
    <textarea id="content"  name="content" class="easyui-validatebox text_area" required="true" missingMessage="模板内容不能为空" rows="10" cols="48" onpropertychange="calculation()" oninput="calculation()" ><?php echo $this->_tpl_vars['smsmodel_info']['content']; ?>
</textarea>
  </div>
  <div class="control-group" >
    <span class="em4">
      您一共输入了<input type="text" id="cal" name="cal" size="3" style="border:0;color:red;width:35px;margin:0px;text-align:center;" readonly/>个字,还可以输入<input type="text" id="yuxia" name="yuxia" size="3" style="border:0;color:red;width:35px;margin:0px;text-align:center;" readonly/>个字(<input type="text" id="tiaoshu" name="tiaoshu" size="3" style="border:0;color:red;width:35px;margin:0px;text-align:center;" readonly/>条)
    </span>
  </div>
</div>
<div style="text-align:right;padding-top:5px;padding-right:20px">
<button class="new_con_btn" type="button" id="save_newmodel" onclick="mod_send_action()">
    <span class="iconfont">&#xe637;&nbsp;</span>保存 
</button>
<button class="new_clo_btn" type="button" onclick="mod_cancel_action()">
    <span class="iconfont">&#xe609;&nbsp;</span>取消
</button>
</div>  

<script language="JavaScript" type="text/javascript">
$(document).ready(function() {
  calculation();
});

//取消
function mod_cancel_action()
{
  $('#smsmodel_add_panel').window('close');
}
//保存
function mod_send_action()
{
  if( !$('#theme').validatebox('isValid') )
  {
    $.messager.alert( '警告', '请输入主题', 'error' );
    return false;
  }
  if( !$('#content').validatebox('isValid') )
  {
    $.messager.alert( '警告', '请输入信息内容', 'error' );
    return false;
  }
  var _data = {};

  _data.mod_id = $('#mod_id').val();//模板id
  _data.theme = $('#theme').val();//模板主题
  _data.content = $('#content').val();//模板内容

  $('#save_newmodel').linkbutton({'disabled':true});
  $.ajax({
    type:'POST',
    url: "index.php?c=sms&m=<?php echo $this->_tpl_vars['form_act']; ?>
",
    data:_data,
    dataType:"json",
    success: function(responce){
      if(responce['error']=='0')
      {
        $('#smsmodel_list_table').datagrid('reload');
        $('#smsmodel_add_panel').window('close');
      }
      else
      {
        $.messager.alert('错误',responce['message'],'error');
      }
      $('#save_newmodel').linkbutton({'disabled':false});
    }
  });
}

//计算模板字数
function calculation()
{
  var length = $("#content").val().length;
  if( length <= <?php echo $this->_tpl_vars['MAX_smsLength']; ?>
)
  {
    $("#cal").val(length);//已输入字符数
    $("#yuxia").val(<?php echo $this->_tpl_vars['MAX_smsLength']; ?>
-length);//剩余可输入字符数
    $("#tiaoshu").val(Math.ceil( length/<?php echo $this->_tpl_vars['EACH_smsLength']; ?>
 )+"/<?php echo $this->_tpl_vars['MAX_tiaoshu']; ?>
" );//短信条数
  }
  else
  {
    var str = $("#content").val().substr(0,parseInt('<?php echo $this->_tpl_vars['MAX_smsLength']; ?>
'));
    $("#content").val(str);
    $.messager.alert('提示',"达到短信模板最大输入上限",'info');
  }
}
</script>