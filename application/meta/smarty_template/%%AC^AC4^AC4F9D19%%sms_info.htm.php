<?php /* Smarty version 2.6.19, created on 2016-11-17 04:30:24
         compiled from sms_info.htm */ ?>
<style type="text/css">
input[type="file"]{
  line-height: 20px;
}
input[disabled]{
  background-color: #fff;
}
#_file_address{
  margin-left:10px;
  margin-top:10px;
  background:#fff;
}
#_group_phone{
  height: 32px!important;
}
<?php if ($this->_tpl_vars['group_sms']): ?>
.temps{
  line-height:15px;
  padding-left:15px;
  border-bottom: 1px solid rgb(229, 229, 229);
  padding-bottom: 10px;    
  color: #666;
}
<?php endif; ?>
</style>
<?php if ($this->_tpl_vars['group_sms']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['group_sms']): ?>
<div class="form-div controls main-margin-div">
<?php else: ?>
<div class="form-div">
<?php endif; ?>
<div class="temps"><b>使用步骤及注意事项</b></div>
<div style="padding-top:10px;">
<ol style="padding-left:25px;line-height:15px;">
<?php if ($this->_tpl_vars['group_sms']): ?> 
<li>上传文本文件(csv或txt)，手机号码之间用逗号或回车换行符隔开</li>
<?php endif; ?>
<li>短信模版使用：在短信模版页面建立模版，发短信时选择所需模板。</li>
</ol>
</div>
</div>
<?php if ($this->_tpl_vars['group_sms']): ?>
<div class="main-div main-margin-div">
<?php else: ?>
<div class="main-div">
<?php endif; ?>
<form class="form-horizontal" name="_sms_form" id="_sms_form" action="" method="post" enctype="multipart/form-data" >
    <?php if ($this->_tpl_vars['group_sms']): ?>       
      <div class="control-group" >
        <label>
          <input type="radio"  id="type_kind"  name="type_kind" value="3" onclick="radio_click(3)" checked/>手机号码
        </label>
        <input type="text"  id="_group_phone"  name="_group_phone"  size="40" class="easyui-validatebox"  validType="phone_num" style="width:220px;"/>（多个号码以逗号分隔）
      </div>
      <div class="control-group" >
        <label>
          <input type="radio" align="right" id="type_kind"  name="type_kind" value="2" onclick="radio_click(2)"/>手机号码
        </label>
        <!-- <a href="#" class="File iconfont">
            &#xe671;&nbsp;请选择文件 -->
            <input type="file" name="_file_address" id="_file_address" size="40" disabled />
        <!-- </a>&nbsp;未选择任何文件 -->
        <img id="loading" src="./image/loading.gif" style="display:none;">
      </div>
    <?php else: ?>
      <div class="control-group" >
        <label>手机号码</label>
        <input  type="text" id="_single_phone"  name="_single_phone"  value="" class="easyui-validatebox"  validType="phone_single" style="margin-left:10px;"/>
      </div>
    <?php endif; ?>
      <div class="control-group" >
        <label>短信模板</label>
          <input name="sms_model" id="sms_model" style="width:425;margin-left:20px;" value='--请选择短信模板--' >
      </div>
      <div class="control-group" >
        <label for="_sms_content">短信内容</label>
          <textarea id="_sms_content"   name="_sms_content"  rows="10" cols="58" onpropertychange="calculation()" oninput="calculation()" class="text_area"></textarea>
      </div>
      <div class="control-group" >
        <label style="margin-right: 10px;"></label>
          您一共输入了<input type="text" id="_cal" name="_cal"  value="0" style="border:0;color:red;width:35px;margin:0px;text-align:center;" readonly/>个字,还可以输入<input type="text" id="_left_num" name="_left_num" value="<?php echo $this->_tpl_vars['MAX_smsLength']; ?>
"  style="border:0;color:red;width:35px;margin:0px;text-align:center;" readonly/>个字(<input type="text" id="tiaoshu" name="tiaoshu"  value="0/<?php echo $this->_tpl_vars['MAX_tiaoshu']; ?>
"  style="border:0;color:red;width:35px;margin:0px;text-align:center;" readonly/>条)
      </div>
</form>
      <div class="control-group" >
          <button class="new_con_btn" type="button" onclick="_send_sms();">
            <span class="iconfont">&#xe637;&nbsp;</span> 发送
          </button>
      </div>
  <!-- </div> -->
</div>
<!-- </div> -->
<div id="massmsg_add_contact"></div>
<?php if ($this->_tpl_vars['group_sms']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<script type="text/javascript" src="jssrc/ajaxfileupload.js"></script>
<script src="assets/easyui/easyui-validtype.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
var power_phone_view = <?php echo $this->_tpl_vars['power_phone_view']; ?>
;
var receiver_phone = '<?php echo $this->_tpl_vars['receiver_phone']; ?>
';

var MAX_smsLength = <?php echo $this->_tpl_vars['MAX_smsLength']; ?>
;
var EACH_smsLength = <?php echo $this->_tpl_vars['EACH_smsLength']; ?>
;
var MAX_tiaoshu = <?php echo $this->_tpl_vars['MAX_tiaoshu']; ?>
;
var group_sms = <?php echo $this->_tpl_vars['group_sms']; ?>
;
</script>
<script src="assets/js/sms_info.js" type="text/javascript"></script>