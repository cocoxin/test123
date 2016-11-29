<?php /* Smarty version 2.6.19, created on 2016-11-17 10:55:24
         compiled from client_accept.htm */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'client_accept.htm', 225, false),array('modifier', 'cat', 'client_accept.htm', 246, false),array('modifier', 'default', 'client_accept.htm', 407, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<style>
    select,textarea,input[type="text"],input[type="password"],input[type="datetime"],input[type="datetime-local"],input[type="date"],input[type="month"],input[type="time"],input[type="week"],input[type="number"],input[type="email"],input[type="url"],input[type="search"],input[type="tel"],input[type="color"]{
        margin-bottom: 0;
    }
    .input-append{
        margin-bottom: 0;
    }
    .table th,.table td{
        vertical-align: middle;
    }
    #mainNav>span:first-of-type{
        margin-left:12px;
    }
    .control-group table{
        display:inline-block;
        vertical-align:top;
        margin-left:10px;
    }
    label.inline{
        width:auto!important;
    }
    label.inline>input{
        margin:0px!important;
    }
    #buttom_button{
        margin-bottom: 10px;
    }
    #buttom_button button{
        margin-right: 30px;
    }
    #bottom_div button{
        margin-right: 10px;
    }
</style>
<div class="form-div main-margin-div">
  <form action="javascript:quick_search()" name="searchForm" id="searchForm" class="form-search">
      <div class="control-group  bottom_none">
        <label for="">查询条件</label>
        <input type="text" name="search_cle_name" id="search_cle_name" placeholder="姓名" />
        <input type="text" name="search_cle_phone" id="search_cle_phone" placeholder="电话号码"
                data-toggle="tooltip" title='只能检索4位以上电话'/>
        <button class="new_btn" type="button" onclick="$('#searchForm').submit();">
            <span class="iconfont">&#xe60c;&nbsp;<span class="btn-size">搜索</span></span> 
        </button>
      </div>
  </form>
</div>
<div class='easyui-panel' data-options="border:false" title='<span>客户基本信息</span>'>
<div class="main-div main-margin-div" style="padding-bottom: 0">
<div class="form-horizontal">
    <div class="control-group">
        <label for="cle_name">客户姓名</label>
        <input type="text" name="cle_name" id="cle_name" value="<?php echo $this->_tpl_vars['client_info']['cle_name']; ?>
" onkeyup="check_repeat_data();"/>
        <input type="hidden"  name="cle_id" id="cle_id" value="<?php echo $this->_tpl_vars['client_info']['cle_id']; ?>
"/>
    </div>
    <?php if ($this->_tpl_vars['cle_contact_info'] && $this->_tpl_vars['power_use_contact'] != 1): ?>
    <div class="control-group">
        <div class="input_append row3">
            <label>联系人</label>
            <select name="cle_contact_name" id="cle_contact_name" onchange='change_contact_mobile()'>
                <?php $_from = $this->_tpl_vars['cle_contact_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['skey'] => $this->_tpl_vars['con_info']):
?>
                <option value="<?php echo $this->_tpl_vars['con_info']['con_mobile']; ?>
"  ><?php echo $this->_tpl_vars['con_info']['con_name']; ?>
</option>
                <?php endforeach; endif; unset($_from); ?>
            </select>
        </div>
        <div class="input_append row3">
            <label for="cle_con_mobile">联系人电话</label>
            <!-- <span id="cle_con_mobile" ></span> -->
            <div class="input-append">
            <input  id="cle_con_mobile" type="text" disabled="true">
            <span id='_cle_con_sms_dial' style='display:none;' >
                <button class="btn btn-mini" onclick="sys_dial_num('','cle_contact_name');" title='呼叫号码'>
                    <span class="glyphicon glyphicon-phone"></span>
                </button>
                <?php if ($this->_tpl_vars['power_sendsms']): ?>
                <button class="btn btn-mini" onclick="sys_send_sms('','cle_contact_name');" title='发送短信'>
                    <span class="glyphicon glyphicon-envelope"></span>
                </button>
                <?php endif; ?>
            </span>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="control-group">
        <div class="input_append row3"><label for="cle_phone">客户电话</label>
            <?php if ($this->_tpl_vars['power_update_c_phone']): ?>
                <div class="input-append">
                    <input type="text" id="cle_phone" name="cle_phone" onkeyup="number_verification('cle_phone','_phone_update_msg')"
                       value="<?php echo $this->_tpl_vars['client_info']['cle_phone']; ?>
" onblur="check_repeat_data('cle_phone')" />
                    <button class="btn" onclick="sys_dial_num('<?php echo $this->_tpl_vars['client_info']['cle_phone']; ?>
','cle_phone')" title="呼叫号码">
                        <span class="glyphicon glyphicon-phone"></span>
                    </button>
                    <?php if ($this->_tpl_vars['power_sendsms']): ?>
                    <button class="btn" onclick="sys_send_sms('<?php echo $this->_tpl_vars['client_info']['cle_phone']; ?>
','cle_phone')" title="发送短信">
                        <span class="glyphicon glyphicon-envelope"></span>
                    </button>
                    <?php endif; ?>
                </div>
                <span id='_phone_update_msg' style='color:red;'></span>
            <?php else: ?>
                <div class="input-append">
                    <input type="text" id="cle_phone" name="cle_phone" onkeyup="number_verification('cle_phone','_phone_update_msg')"
                       value="<?php echo $this->_tpl_vars['client_info']['cle_phone']; ?>
" onblur="check_repeat_data('cle_phone')" disabled/>
                    <?php if ($this->_tpl_vars['client_info']['cle_phone']): ?>
                        <?php if ($this->_tpl_vars['power_sendsms']): ?>
                            <button class="btn btn-mini" onclick="sys_send_sms('<?php echo $this->_tpl_vars['client_info']['cle_phone']; ?>
','');" title='发送短信'>
                                <span class="glyphicon glyphicon-envelope"></span>
                            </button>
                        <?php endif; ?>
                        <button class="btn btn-mini" onclick="sys_dial_num('<?php echo $this->_tpl_vars['client_info']['cle_phone']; ?>
','');" title='呼叫号码'>
                            <span class="glyphicon glyphicon-phone"></span>
                        </button>
                    <?php endif; ?>
                </div>
                <input type="hidden" id="cle_phone" name="cle_phone" value="<?php echo $this->_tpl_vars['client_info']['cle_phone']; ?>
"  />
            <?php endif; ?>
        </div>
    <?php if ($this->_tpl_vars['client_base']['cle_info_source']): ?>
        <div class="input_append row3">
            <label for="cle_info_source">信息来源</label>
            <select name="cle_info_source" id="cle_info_source" base_field='true'>
                <?php $_from = $this->_tpl_vars['cle_info_source']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['skey'] => $this->_tpl_vars['info_source']):
?>
                <option value="<?php echo $this->_tpl_vars['info_source']['name']; ?>
"  <?php if ($this->_tpl_vars['client_info']['cle_info_source'] == $this->_tpl_vars['info_source']['name']): ?> SELECTED <?php endif; ?>   ><?php echo $this->_tpl_vars['info_source']['name']; ?>
</option>
                <?php endforeach; endif; unset($_from); ?>
            </select>
        </div>
    </div>
    <div class="control-group">
    <?php endif; ?>

    <?php if ($this->_tpl_vars['client_base']['cle_phone2']): ?>
        <div class="input_append row3">
            <label for="cle_phone2">办公电话</label>
            <?php if ($this->_tpl_vars['power_update_c_phone']): ?>
            <div class="input-append">
                <input type="text" id="cle_phone2" name="cle_phone2" onkeyup="number_verification('cle_phone2','_phone_update_msg2')"
                       value="<?php echo $this->_tpl_vars['client_info']['cle_phone2']; ?>
" onblur="check_repeat_data('cle_phone2')" base_field='true' />
                <button class="btn" onclick="sys_dial_num('<?php echo $this->_tpl_vars['client_info']['cle_phone2']; ?>
','cle_phone2')" title="呼叫号码">
                    <span class="glyphicon glyphicon-phone"></span>
                </button>
                <?php if ($this->_tpl_vars['power_sendsms']): ?>
                <button class="btn" onclick="sys_send_sms('<?php echo $this->_tpl_vars['client_info']['cle_phone2']; ?>
','cle_phone2')" title="发送短信">
                    <span class="glyphicon glyphicon-envelope"></span>
                </button>
                <?php endif; ?>
            </div>
            <span id='_phone_update_msg2' style='color:red;'></span>
            <?php else: ?>
            <!-- <span id='label_cle_phone2'><?php echo $this->_tpl_vars['client_info']['cle_phone2']; ?>
</span> -->
            <div class="input-append">
                <input type="text" id="cle_phone2" name="cle_phone2" onkeyup="number_verification('cle_phone2','_phone_update_msg2')"
                           value="<?php echo $this->_tpl_vars['client_info']['cle_phone2']; ?>
" onblur="check_repeat_data('cle_phone2')" base_field='true' disabled/>
                <?php if ($this->_tpl_vars['client_info']['cle_phone2']): ?>
                <?php if ($this->_tpl_vars['power_sendsms']): ?>
                <button class="btn btn-mini" onclick="sys_send_sms('<?php echo $this->_tpl_vars['client_info']['cle_phone2']; ?>
','');" title='发送短信'>
                    <span class="glyphicon glyphicon-envelope"></span>
                </button>
                <?php endif; ?>
                <button class="btn btn-mini" onclick="sys_dial_num('<?php echo $this->_tpl_vars['client_info']['cle_phone2']; ?>
','');" title='呼叫号码'>
                    <span class="glyphicon glyphicon-phone"></span>
                </button>
                <?php endif; ?>
                <input type="hidden" id="cle_phone2" name="cle_phone2" value="<?php echo $this->_tpl_vars['client_info']['cle_phone2']; ?>
"  />
            </div>
            <?php endif; ?>
        </div>
        <?php if (! $this->_tpl_vars['client_base']['cle_info_source']): ?>
        </div><div class="control-group">
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['client_base']['cle_phone3']): ?>
        <div class="input_append row3">
            <label for="cle_phone3">其他电话</label>
            <?php if ($this->_tpl_vars['power_update_c_phone']): ?>
            <div class="input-append">
                <input type="text" id="cle_phone3" name="cle_phone3" onkeyup="number_verification('cle_phone3','_phone_update_msg3')"
                       value="<?php echo $this->_tpl_vars['client_info']['cle_phone3']; ?>
" onblur="check_repeat_data('cle_phone3')" base_field='true' />
                <button class="btn" onclick="sys_dial_num('<?php echo $this->_tpl_vars['client_info']['cle_phone3']; ?>
','cle_phone3')" title="呼叫号码">
                    <span class="glyphicon glyphicon-phone"></span>
                </button>
                <?php if ($this->_tpl_vars['power_sendsms']): ?>
                <button class="btn" onclick="sys_send_sms('<?php echo $this->_tpl_vars['client_info']['cle_phone3']; ?>
','cle_phone3')" title="发送短信">
                    <span class="glyphicon glyphicon-envelope"></span>
                </button>
                <?php endif; ?>
            </div>
            <span id='_phone_update_msg3' style='color:red;'></span>
            <?php else: ?>
            <div class="input-append">
                <input type="text" id="cle_phone3" name="cle_phone3" onkeyup="number_verification('cle_phone3','_phone_update_msg3')"
                       value="<?php echo $this->_tpl_vars['client_info']['cle_phone3']; ?>
" onblur="check_repeat_data('cle_phone3')" base_field='true' />
                <?php if ($this->_tpl_vars['client_info']['cle_phone3']): ?>
                <?php if ($this->_tpl_vars['power_sendsms']): ?>
                <button class="btn btn-mini" onclick="sys_send_sms('<?php echo $this->_tpl_vars['client_info']['cle_phone3']; ?>
','');" title='发送短信'>
                    <span class="glyphicon glyphicon-envelope"></span>
                </button>
                <?php endif; ?>
                <button class="btn btn-mini" onclick="sys_dial_num('<?php echo $this->_tpl_vars['client_info']['cle_phone3']; ?>
','');" title='呼叫号码'>
                    <span class="glyphicon glyphicon-phone"></span>
                </button>
                <?php endif; ?>
                <input type="hidden" id="cle_phone3" name="cle_phone3" value="<?php echo $this->_tpl_vars['client_info']['cle_phone3']; ?>
"  />
            </div>
            <?php endif; ?>
        </div>
     <?php endif; ?>
    </div>
    <?php if ($this->_tpl_vars['client_base']['cle_stage']): ?>
    <div class="control-group">
        <div id="mainNav">
            <label for="cle_stage" style="float:left;">客户阶段</label>
            <input id="cle_stage" name="cle_stage" value="<?php echo $this->_tpl_vars['client_info']['cle_stage']; ?>
" type="hidden" base_field='true'/>
            <?php $_from = $this->_tpl_vars['cle_stage']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listName'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listName']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['skey'] => $this->_tpl_vars['stage']):
        $this->_foreach['listName']['iteration']++;
?>
            <span  onclick="change_stage_step('<?php echo $this->_tpl_vars['stage']['name']; ?>
')" title="<?php echo $this->_tpl_vars['stage']['name']; ?>
" <?php if (($this->_foreach['listName']['iteration'] == $this->_foreach['listName']['total'])): ?>class="mainNavNoBg"<?php endif; ?>  ><a title="<?php echo $this->_tpl_vars['stage']['name']; ?>
"><?php echo $this->_tpl_vars['stage']['name']; ?>
</a></span>
            <div class="pre1"></div> 
            <div class="pre2"></div> 
            <?php endforeach; endif; unset($_from); ?>
        </div>
    </div>
    <?php endif; ?>
    <!--自定义字段  -----begin-------->
    <?php echo smarty_function_counter(array('start' => 0,'print' => false,'assign' => 'client_confirm_count'), $this);?>
<!--  计算  -->
    <?php $_from = $this->_tpl_vars['client_confirm']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['list_Name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['list_Name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['ckey'] => $this->_tpl_vars['confirm_info']):
        $this->_foreach['list_Name']['iteration']++;
?>
    <?php if ($this->_tpl_vars['confirm_info']['data_type'] == 3): ?>
    <?php echo smarty_function_counter(array('start' => 0,'print' => false,'assign' => 'client_confirm_count'), $this);?>
<!-- 从新计算 -->
    <div class="control-group">
        <div class="input_append"><label for="<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
"><?php echo $this->_tpl_vars['confirm_info']['name']; ?>
</label>
            <textarea id="<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
" confirm_field='true'  name="<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
" rows="3" cols="20" <?php if ($this->_tpl_vars['confirm_info']['if_require'] == 2): ?>class="easyui-validatebox text_area" required="true" missingMessage="<?php echo $this->_tpl_vars['confirm_info']['name']; ?>
不能为空" if_require='true' _chinese_name='<?php echo $this->_tpl_vars['confirm_info']['name']; ?>
'  <?php else: ?>class="text_area"  <?php endif; ?> ><?php echo $this->_tpl_vars['client_info'][$this->_tpl_vars['confirm_info']['fields']]; ?>
</textarea>
            <?php if ($this->_tpl_vars['confirm_info']['if_require'] == 2): ?><span class="require-field">*</span><?php endif; ?>
        </div>
    </div>

    <?php elseif ($this->_tpl_vars['confirm_info']['data_type'] == 4): ?>
    <?php if ($this->_tpl_vars['client_confirm_count']%2 != 0): ?>
        </div>
    <?php endif; ?>
    <?php echo smarty_function_counter(array('start' => 0,'print' => false,'assign' => 'client_confirm_count'), $this);?>
<!-- 从新计算 -->
    <div class="control-group">
        <div class="input_append row3" style="width:900px"><label for="<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
"><?php echo $this->_tpl_vars['confirm_info']['name']; ?>
</label>
            <span id="<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
_1">
             <select name='<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
_1' confirm_field='true' onchange="get_comfirm_jl_options(1,'<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
','<?php echo $this->_tpl_vars['confirm_info']['jl_series']; ?>
',<?php echo $this->_tpl_vars['confirm_info']['id']; ?>
)" <?php if ($this->_tpl_vars['confirm_info']['if_require'] == 2): ?>class="easyui-validatebox" required="true" if_require='true' _chinese_name='<?php echo $this->_tpl_vars['confirm_info']['name']; ?>
_1'<?php endif; ?> >
             <option value="" >--请选择--</option>
              <?php $this->assign('field_type', ((is_array($_tmp=$this->_tpl_vars['confirm_info']['fields'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_1') : smarty_modifier_cat($_tmp, '_1'))); ?>
              <?php $_from = $this->_tpl_vars['jl_options'][$this->_tpl_vars['field_type']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['jlkey'] => $this->_tpl_vars['option']):
?>
              <option value="<?php echo $this->_tpl_vars['jlkey']; ?>
" <?php if ($this->_tpl_vars['jlkey'] == $this->_tpl_vars['client_info'][$this->_tpl_vars['field_type']]): ?>selected<?php endif; ?> ><?php echo $this->_tpl_vars['option']; ?>
</option>
              <?php endforeach; endif; unset($_from); ?>
             </select>
            </span>
            <?php $this->assign('jl_f_t', $this->_tpl_vars['confirm_info']['jl_field_type']); ?>
            <?php $this->assign('field_type2', ((is_array($_tmp=$this->_tpl_vars['confirm_info']['fields'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_2') : smarty_modifier_cat($_tmp, '_2'))); ?>
            <span id="<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
_2">
            <?php if ($this->_tpl_vars['client_info'][$this->_tpl_vars['field_type']]): ?>
                <?php $this->assign('p_id', $this->_tpl_vars['client_info'][$this->_tpl_vars['field_type']]); ?>
                    <?php if ($this->_tpl_vars['jl_f_t'][$this->_tpl_vars['p_id']] && $this->_tpl_vars['jl_f_t'][$this->_tpl_vars['p_id']] == 1): ?>
                        <input type='text' name='<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
_2' value='<?php echo $this->_tpl_vars['client_info'][$this->_tpl_vars['field_type2']]; ?>
' confirm_field='true'/>
                    <?php else: ?>
                        <select name="<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
_2" confirm_field='true'  <?php if ($this->_tpl_vars['confirm_info']['jl_series'] == 3): ?>onchange="get_comfirm_jl_options(2,'<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
','<?php echo $this->_tpl_vars['confirm_info']['jl_series']; ?>
',<?php echo $this->_tpl_vars['confirm_info']['id']; ?>
)"<?php endif; ?> >
                            <option value="">--请选择--</option>
                            <?php $_from = $this->_tpl_vars['jl_options'][$this->_tpl_vars['field_type2']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['jlkey'] => $this->_tpl_vars['option']):
?>
                            <option value="<?php echo $this->_tpl_vars['jlkey']; ?>
" <?php if ($this->_tpl_vars['jlkey'] == $this->_tpl_vars['client_info'][$this->_tpl_vars['field_type2']]): ?>selected<?php endif; ?> ><?php echo $this->_tpl_vars['option']; ?>
</option>
                            <?php endforeach; endif; unset($_from); ?>
                        </select>
                    <?php endif; ?>
                 <?php endif; ?>
                </span>
             <?php if ($this->_tpl_vars['confirm_info']['jl_series'] == 3): ?>
              <span id="<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
_3">
                <?php $this->assign('field_type3', ((is_array($_tmp=$this->_tpl_vars['confirm_info']['fields'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_3') : smarty_modifier_cat($_tmp, '_3'))); ?>
                <?php if ($this->_tpl_vars['client_info'][$this->_tpl_vars['field_type2']]): ?>
                <?php $this->assign('p_id2', $this->_tpl_vars['client_info'][$this->_tpl_vars['field_type2']]); ?>
                    <?php if ($this->_tpl_vars['jl_f_t'][$this->_tpl_vars['p_id2']] && $this->_tpl_vars['jl_f_t'][$this->_tpl_vars['p_id2']] == 1): ?>
                        <input type='text' name='<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
_3' value='<?php echo $this->_tpl_vars['client_info'][$this->_tpl_vars['field_type3']]; ?>
' confirm_field='true'/>
                    <?php else: ?>
                        <select name="<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
_3" confirm_field='true'>
                            <option value="">--请选择--</option>
                            <?php $_from = $this->_tpl_vars['jl_options'][$this->_tpl_vars['field_type3']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['jlkey'] => $this->_tpl_vars['option']):
?>
                            <option value="<?php echo $this->_tpl_vars['jlkey']; ?>
" <?php if ($this->_tpl_vars['jlkey'] == $this->_tpl_vars['client_info'][$this->_tpl_vars['field_type3']]): ?>selected<?php endif; ?> ><?php echo $this->_tpl_vars['option']; ?>
</option>
                            <?php endforeach; endif; unset($_from); ?>
                        </select>
                    <?php endif; ?>
                <?php endif; ?>
                </span>
             <?php endif; ?>
             <?php if ($this->_tpl_vars['confirm_info']['if_require'] == 2): ?><span class="require-field">*</span><?php endif; ?>
        </div>
    </div>


    <?php elseif ($this->_tpl_vars['confirm_info']['data_type'] == 7): ?><!--级联多选框-->
    <?php if ($this->_tpl_vars['client_confirm_count']%2 != 0): ?>
        </div>
    <?php endif; ?>
    <?php echo smarty_function_counter(array('start' => 0,'print' => false,'assign' => 'client_confirm_count'), $this);?>
<!-- 从新计算 -->
    <div class="control-group">
        <label for="<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
"><?php echo $this->_tpl_vars['confirm_info']['name']; ?>
</label>
        <table>
            <?php $this->assign('field_type', ((is_array($_tmp=$this->_tpl_vars['confirm_info']['id'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_1') : smarty_modifier_cat($_tmp, '_1'))); ?>
            <?php $this->assign('field_type2', ((is_array($_tmp=$this->_tpl_vars['confirm_info']['id'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_2') : smarty_modifier_cat($_tmp, '_2'))); ?>
            <?php if ($this->_tpl_vars['client_info']): ?>
                <?php $this->assign('field_value', $this->_tpl_vars['client_info'][$this->_tpl_vars['field_type']]); ?>
                <?php $this->assign('field_value2', $this->_tpl_vars['client_info'][$this->_tpl_vars['field_type2']]); ?>
            <?php endif; ?>
            <?php $_from = $this->_tpl_vars['checkbox_options'][$this->_tpl_vars['field_type']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id1'] => $this->_tpl_vars['check_option1']):
?>
            <tr>
                <th style="padding-bottom:5px;"><?php echo $this->_tpl_vars['check_option1']['name']; ?>
</th>
            </tr>
            <tr>
                <td style="padding-bottom:5px;">
                    <?php $_from = $this->_tpl_vars['checkbox_options'][$this->_tpl_vars['field_type2']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id2'] => $this->_tpl_vars['check_option']):
?>
                        <?php if ($this->_tpl_vars['check_option']['p_id'] == $this->_tpl_vars['id1']): ?>
                            <input type="checkbox" checkbox_name="<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
" checkbox_pid="<?php echo $this->_tpl_vars['id1']; ?>
" name="<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
_2[]" value="<?php echo $this->_tpl_vars['id2']; ?>
" confirm_field='true' <?php if ($this->_tpl_vars['field_value2'][$this->_tpl_vars['id2']] == $this->_tpl_vars['id2']): ?>checked<?php endif; ?> /> <?php echo $this->_tpl_vars['check_option']['name']; ?>
&nbsp;
                        <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                </td>
            </tr>
            <?php endforeach; endif; unset($_from); ?>
        </table>
     </div>

    <?php else: ?>
    <?php if ($this->_tpl_vars['client_confirm_count']%2 == 0): ?>
    <div class="control-group">
        <?php endif; ?>
        <div class="input_append row3"><label for="<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
"  ><?php echo $this->_tpl_vars['confirm_info']['name']; ?>
</label>
        <?php if ($this->_tpl_vars['field_detail'][$this->_tpl_vars['confirm_info']['id']] || $this->_tpl_vars['confirm_info']['data_type'] == 2): ?><!--下拉选择-->
            <select id="<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
"  name="<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
" confirm_field='true' <?php if ($this->_tpl_vars['confirm_info']['if_require'] == 2): ?>class="easyui-validatebox" required="true" missingMessage="<?php echo $this->_tpl_vars['confirm_info']['name']; ?>
不能为空" if_require='true' _chinese_name='<?php echo $this->_tpl_vars['confirm_info']['name']; ?>
'<?php endif; ?> >
                <?php $_from = $this->_tpl_vars['field_detail'][$this->_tpl_vars['confirm_info']['id']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dkey'] => $this->_tpl_vars['detail']):
?>
                <option value="<?php echo $this->_tpl_vars['detail']; ?>
" <?php if ($this->_tpl_vars['detail'] == $this->_tpl_vars['client_info'][$this->_tpl_vars['confirm_info']['fields']]): ?>selected<?php endif; ?> ><?php echo $this->_tpl_vars['detail']; ?>
</option>
                <?php endforeach; endif; unset($_from); ?>
                <option value="" <?php if (! $this->_tpl_vars['client_info'][$this->_tpl_vars['confirm_info']['fields']]): ?>selected<?php endif; ?> >&nbsp;</option>
            </select>
            <?php if ($this->_tpl_vars['confirm_info']['if_require'] == 2): ?><span class="require-field">*</span><?php endif; ?>

        <?php elseif ($this->_tpl_vars['confirm_info']['data_type'] == 5): ?><!-- 日期框 -->
            <div class="input-append">
                <input type="text" name="<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
" id="<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
" value="<?php if ($this->_tpl_vars['client_info'][$this->_tpl_vars['confirm_info']['fields']]): ?><?php echo $this->_tpl_vars['client_info'][$this->_tpl_vars['confirm_info']['fields']]; ?>
<?php elseif ($this->_tpl_vars['confirm_info']['default'] == '系统时间'): ?><?php if ($this->_tpl_vars['confirm_info']['datefmt'] == 'yyyy-MM-dd'): ?><?php echo $this->_tpl_vars['now_date']; ?>
<?php else: ?><?php echo $this->_tpl_vars['now_time']; ?>
<?php endif; ?><?php else: ?><?php echo $this->_tpl_vars['confirm_info']['default']; ?>
<?php endif; ?>" confirm_field='true'  <?php if ($this->_tpl_vars['confirm_info']['if_require'] == 2): ?>_date='date_box' _chinese_name='<?php echo $this->_tpl_vars['confirm_info']['name']; ?>
' if_require='true'<?php endif; ?> readonly>
                <button type="button" role="date" class="btn" onclick="WdatePicker({el: '<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
',dateFmt:'<?php echo $this->_tpl_vars['confirm_info']['datefmt']; ?>
'})">
                    <span class="glyphicon glyphicon-calendar"></span>
                </button>
            </div>
            <?php if ($this->_tpl_vars['confirm_info']['if_require'] == 2): ?><span class="require-field">*</span><?php endif; ?>
        <?php else: ?><!-- 文本框 -->
            <input type="text" id="<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
" name="<?php echo $this->_tpl_vars['confirm_info']['fields']; ?>
" confirm_field='true' value="<?php if ($this->_tpl_vars['client_info'][$this->_tpl_vars['confirm_info']['fields']]): ?><?php echo $this->_tpl_vars['client_info'][$this->_tpl_vars['confirm_info']['fields']]; ?>
<?php else: ?><?php echo $this->_tpl_vars['confirm_info']['default']; ?>
<?php endif; ?>"
               <?php if ($this->_tpl_vars['confirm_info']['if_require'] == 2): ?>class="easyui-validatebox" required="true" missingMessage="<?php echo $this->_tpl_vars['confirm_info']['name']; ?>
不能为空" if_require='true' _chinese_name='<?php echo $this->_tpl_vars['confirm_info']['name']; ?>
'
                <?php endif; ?> />
               <?php if ($this->_tpl_vars['confirm_info']['if_require'] == 2): ?><span class="require-field">*</span><?php endif; ?>
            <?php endif; ?>
        </div>
        <?php if ($this->_tpl_vars['client_confirm_count']%2 != 0): ?>
    </div>
    <?php endif; ?>
    <?php echo smarty_function_counter(array('print' => false,'assign' => 'client_confirm_count'), $this);?>
<!--   加1   -->
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    <!--自定义字段  ------end------- -->
    <?php if ($this->_tpl_vars['client_base']['cle_province_name'] || $this->_tpl_vars['client_base']['cle_address']): ?>
    <?php if ($this->_tpl_vars['client_confirm_count']%2 != 0): ?>
        </div>
    <?php endif; ?>
    <div class="control-group">
        <label for="">详细地址</label>
        <?php if ($this->_tpl_vars['client_base']['cle_province_name']): ?>
            <select id="cle_province_id" name='cle_province_id' style="width:103px;" base_field='true' onchange="change_regions_type('cle_province_id','cle_city_id','2');">
                <option value="0" >--选择省--</option>
                <?php $_from = $this->_tpl_vars['regions_province_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pkey'] => $this->_tpl_vars['province']):
?>
                <option value="<?php echo $this->_tpl_vars['pkey']; ?>
" <?php if ($this->_tpl_vars['pkey'] == $this->_tpl_vars['client_info']['cle_province_id']): ?>selected<?php endif; ?> ><?php echo $this->_tpl_vars['province']; ?>
</option>
                <?php endforeach; endif; unset($_from); ?>
            </select>
            <select id="cle_city_id" name="cle_city_id" style="width:103px;" base_field='true'>
                <option value="0">--选择市--</option>
                <?php if ($this->_tpl_vars['regions_city_info']): ?>
                <?php $_from = $this->_tpl_vars['regions_city_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ckey'] => $this->_tpl_vars['city']):
?>
                <option value="<?php echo $this->_tpl_vars['ckey']; ?>
" <?php if ($this->_tpl_vars['ckey'] == $this->_tpl_vars['client_info']['cle_city_id']): ?>selected<?php endif; ?> ><?php echo $this->_tpl_vars['city']; ?>
</option>
                <?php endforeach; endif; unset($_from); ?>
                <?php endif; ?>
            </select>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['client_base']['cle_address']): ?>
            <input class="input_cle_address" type="text" name="cle_address" id="cle_address" base_field='true' value="<?php echo $this->_tpl_vars['client_info']['cle_address']; ?>
">
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['client_base']['cle_remark']): ?>
    <div class="control-group">
        <label for="cle_remark">客户备注</label>
        <textarea id="cle_remark" name="cle_remark" base_field='true' rows="3" cols="20"  class="text_area"><?php echo $this->_tpl_vars['client_info']['cle_remark']; ?>
</textarea>
    </div>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['client_base']['cle_stat']): ?>
    <div class="control-group">
        <!-- <div style="float:right;margin-right:40px;"> -->
        <label></label>
        <?php if ($this->_tpl_vars['power_client_update']): ?>
            <span>
                <label title="号码状态选为[未呼通]、[空号错号]时自动保存" class="easyui-tooltip"  style="text-align:left;color:black;">
                    <input type="checkbox" id="save_data" name="save_data" onclick="record_memrot_cookie()" />自动保存
                </label>
            </span>
            <?php endif; ?>
            <span>
                <span class="label label-info">号码状态：</span>
            <?php $_from = $this->_tpl_vars['client_state']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['skey'] => $this->_tpl_vars['state']):
?>
                <label class="inline" style="color:black;">
                    <input type="radio"  name="cle_stat" value="<?php echo $this->_tpl_vars['state']['name']; ?>
" base_field='true' onclick="auto_save('<?php echo $this->_tpl_vars['state']['name']; ?>
')" <?php if (((is_array($_tmp=@$this->_tpl_vars['client_info']['cle_stat'])) ? $this->_run_mod_handler('default', true, $_tmp, '未拨打') : smarty_modifier_default($_tmp, '未拨打')) == $this->_tpl_vars['state']['name']): ?> CHECKED <?php endif; ?> />
                    <?php if (((is_array($_tmp=@$this->_tpl_vars['client_info']['cle_stat'])) ? $this->_run_mod_handler('default', true, $_tmp, '未拨打') : smarty_modifier_default($_tmp, '未拨打')) == $this->_tpl_vars['state']['name']): ?>
                    <?php echo $this->_tpl_vars['state']['name']; ?>

                    <?php else: ?>
                    <?php echo $this->_tpl_vars['state']['name']; ?>

                    <?php endif; ?>
                </label>
            <?php endforeach; endif; unset($_from); ?>
            </span>
        <!-- </div> -->
        </div>
    </div>
    <?php endif; ?>
</div>

</div>
</div>

<div id="bottom_div" class="form-inline" style="text-align:right;padding-bottom:5px;">
    <span id='_accept_msg' style='color:red;'></span>
    <?php if ($this->_tpl_vars['system_pagination']): ?>
    <button class="new_otr_btn" type="button" id="last_client" onclick="jump_pre_client()">
        <span class="iconfont">&#xe64e;&nbsp;</span>上一条
    </button>
    【<?php echo $this->_tpl_vars['row_index']; ?>
/<?php echo $this->_tpl_vars['row_limit']; ?>
】
    <button class="new_otr_btn" type="button" id="next_client" onclick="jump_next_client()">
        下一条<span class="iconfont">&nbsp;&#xe64d;</span>
    </button>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['power_client_update']): ?>
    <?php if ($this->_tpl_vars['power_client_release']): ?>
    <?php if ($this->_tpl_vars['client_base']['cle_stat']): ?>
        <label class="checkbox easyui-tooltip" title="数据保存后，自动放弃状态为[空号错号]的数据">
            <input type="checkbox" id="release_invalid_data" name="release_invalid_data"
                   onclick="record_memrot_cookie();" class="checkbox"/> 自动放弃
        </label>
    <?php endif; ?>
    <button class="new_clo_btn" type="button" id="release_client" onclick="release_client();">
        <span class="iconfont">&#xe609;&nbsp;</span>放弃数据 
    </button>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['system_pagination']): ?>
        <label class="checkbox easyui-tooltip" title="数据保存后,自动取下一条<?php if ($this->_tpl_vars['config_call_type'] != 1): ?>并呼叫<?php endif; ?>">
            <input type="checkbox" id="save_next" name="save_next"
                   onclick="record_memrot_cookie();" class="checkbox"/> 自动跳转
        </label>
    <?php endif; ?>
        <button class="new_con_btn" type="button"  id="save_client" onclick="save_client()">
            <span class="iconfont">&#xe637;&nbsp;</span>保存数据 
        </button>
    <?php endif; ?>
</div>

<div class="easyui-tabs" data-options="tools:'#_contact_record_detail'">

<?php if ($this->_tpl_vars['power_work_flow']): ?>
<div title="新建工单" href="index.php?c=work_flow&m=client_accept_add_workflow&cle_id=<?php echo ((is_array($_tmp=@$this->_tpl_vars['client_info']['cle_id'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
"></div>
<?php endif; ?>
<?php if ($this->_tpl_vars['power_service_view']): ?>
<div title="新建服务" href="index.php?c=service&m=add_service&cle_id=<?php echo ((is_array($_tmp=@$this->_tpl_vars['client_info']['cle_id'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
"> </div>
<?php endif; ?>
<div title="新建联系记录" href="index.php?c=contact_record&m=new_contact_record&cle_id=<?php echo ((is_array($_tmp=@$this->_tpl_vars['client_info']['cle_id'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
"></div>
<div title='过往联系记录' href="index.php?c=contact_record&m=contact_record_list&cle_id=<?php echo ((is_array($_tmp=@$this->_tpl_vars['client_info']['cle_id'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
"></div>

<?php if ($this->_tpl_vars['power_use_contact'] != 1): ?>
<div  title="联系人" href="index.php?c=contact&cle_id=<?php echo $this->_tpl_vars['client_info']['cle_id']; ?>
"></div>
<?php endif; ?>

<?php if ($this->_tpl_vars['power_work_flow']): ?>
<div  title="工单信息" href="index.php?c=work_flow&m=work_client_list&cle_id=<?php echo $this->_tpl_vars['client_info']['cle_id']; ?>
"></div>
<?php endif; ?>
<?php if ($this->_tpl_vars['power_service_view']): ?>
<div  title="客服服务" href="index.php?c=service&m=client_service&cle_id=<?php echo $this->_tpl_vars['client_info']['cle_id']; ?>
"></div>
<?php endif; ?>
<?php if ($this->_tpl_vars['power_client_order']): ?>
<div  title="订单信息" href="index.php?c=order&m=client_order&cle_id=<?php echo $this->_tpl_vars['client_info']['cle_id']; ?>
"></div>
<?php endif; ?>
<div title="相关文件" href="index.php?c=file&cle_id=<?php echo $this->_tpl_vars['client_info']['cle_id']; ?>
"></div>
<div title="操作日志" href="index.php?c=client&m=client_other_message&cle_id=<?php echo $this->_tpl_vars['client_info']['cle_id']; ?>
"></div>

</div>
<!-- 这行代码不知道干嘛用的 -->
<div id="_contact_record_detail"><a href="#" class="icon-content" style="width:51px;" title="仅显示联系内容" onclick="show_contact_record_detail()"></a></div>
<div id="set_remind"></div> <!--提醒-->
<div id="display_repeat_data"></div>
<div id="contact_record_detail_window"></div><!--过往联系记录详情-->

<script src="./jssrc/datepicker/WdatePicker.js" type="text/javascript"></script>
<script src="./jssrc/easyui-validtype.js" type="text/javascript"></script>
<script src="./jssrc/viewjs/client_accept.js?1.3" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
var jl_field_type = eval("(" + '<?php echo $this->_tpl_vars['jl_field_type']; ?>
' + ")");
var power_phone_view = '<?php echo $this->_tpl_vars['power_phone_view']; ?>
';//显示全部号码权限
var power_update_c_phone = '<?php echo $this->_tpl_vars['power_update_c_phone']; ?>
';//编辑号码权限
var power_client_update = '<?php echo $this->_tpl_vars['power_client_update']; ?>
';//编辑客户权限
var power_client_release = '<?php echo $this->_tpl_vars['power_client_release']; ?>
';//放弃客户权限
var power_use_contact = '<?php echo $this->_tpl_vars['power_use_contact']; ?>
';//是否使用联系人模块
var row_index = '<?php echo ((is_array($_tmp=@$this->_tpl_vars['row_index'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
';//在列表中所处的位置 序号 从1开始
var row_limit = '<?php echo ((is_array($_tmp=@$this->_tpl_vars['row_limit'])) ? $this->_run_mod_handler('default', true, $_tmp, 10) : smarty_modifier_default($_tmp, 10)); ?>
';//列表长度
var config_call_type = '<?php echo ((is_array($_tmp=@$this->_tpl_vars['config_call_type'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
';//自动呼叫
var system_autocall = '<?php echo ((is_array($_tmp=@$this->_tpl_vars['system_autocall'])) ? $this->_run_mod_handler('default', true, $_tmp, false) : smarty_modifier_default($_tmp, false)); ?>
';//自动呼叫
var system_autocall_number = "<?php echo ((is_array($_tmp=@$this->_tpl_vars['system_autocall_number'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
";//自动呼叫的号码 默认为传过来的号码，一般是客户号码
var system_pagination = '<?php echo ((is_array($_tmp=@$this->_tpl_vars['system_pagination'])) ? $this->_run_mod_handler('default', true, $_tmp, false) : smarty_modifier_default($_tmp, false)); ?>
';//显示上一条下一条
var phone_allow_repeat = '<?php echo $this->_tpl_vars['phone_ifrepeat']; ?>
';//电话允许重复
var local_cle_stage = '<?php echo $this->_tpl_vars['client_info']['cle_stage']; ?>
';
var client_phone = '<?php echo $this->_tpl_vars['client_info']['cle_phone']; ?>
';//客户电话
var client_phone2 = '';
var client_phone3 = '';
<?php if ($this->_tpl_vars['client_base']['cle_phone2']): ?>
client_phone2 = '<?php echo $this->_tpl_vars['client_info']['cle_phone2']; ?>
';//办公电话
<?php endif; ?>
<?php if ($this->_tpl_vars['client_base']['cle_phone3']): ?>
client_phone3 = '<?php echo $this->_tpl_vars['client_info']['cle_phone3']; ?>
';//其他电话
<?php endif; ?>
var power_cle_stat = 0;//是否启用号码状态字段
<?php if ($this->_tpl_vars['client_base']['cle_stat']): ?>
power_cle_stat = 1;
<?php endif; ?>

$('#search_cle_phone').on('focus', function(){
    $(this).tooltip({placement: 'bottom'}).tooltip('show');
});

</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>