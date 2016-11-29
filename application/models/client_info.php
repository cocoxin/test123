<{include file="pageheader.htm"}>
<style>
    .main-div table td{padding:4px 5px;border: 0px}
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
    .main-margin-div{
      margin-bottom:0px;
    }
    .tabs-panels{
       -webkit-box-shadow: #CCC 0px 0px 5px;  
       -moz-box-shadow: #CCC 0px 0px 5px;  
       box-shadow: #CCC 0px 0px 5px; 
    }

  #display_repeat_data table{
     width:100%;
  }
  #display_repeat_data .datagrid-header-inner{
    width:100%;
  }
</style>
<div id="tab_client" style="margin-bottom:10px;">
<div data-options="border:false" title="<span>客户基本信息<{if $cle_phone}>【没有搜索到相关信息 - 添加客户】<{/if}></span>">
<div class="main-div main-margin-div" style="padding-bottom: 0">
  <div class="form-horizontal">
      <div class="control-group">
          <label for="cle_name">客户名称</label>
          <input type="text" require="true"  name="cle_name" id="cle_name"  value="<{$cle_name}>" onkeyup="check_repeat_data();" />
      </div>
      <div class="control-group">
          <div class="input_append row3">
            <label for="cle_phone">客户电话</label>
            <div class="input-append">
                  <input type="text" id="cle_phone"  name="cle_phone"  value="<{$cle_phone|default:''}>" onkeyup="number_verification('cle_phone','_phone_update_msg')" />
                  <button class="btn" onclick="sys_dial_num('<{$cle_phone}>','cle_phone')" title="呼叫号码">
                      <span class="glyphicon glyphicon-phone"></span>
                  </button>
                  <button class="btn" onclick="sys_send_sms('<{$cle_phone}>','cle_phone')" title="发送短信">
                      <span class="glyphicon glyphicon-envelope"></span>
                  </button>
              </div>
              <span id='_phone_update_msg' style='color:red;'></span>
          </div>
          <{if $client_base.cle_info_source}>
          <div class="input_append row3">
              <label for="cle_info_source">信息来源</label>
              <select name="cle_info_source" id="cle_info_source" base_field='true'>
                  <{foreach from=$cle_info_source item=info_source key=skey}>
                  <option value="<{$info_source.name}>" ><{$info_source.name}></option>
                  <{/foreach}>
              </select>
          </div>
          </div>
       <div class="control-group">
          <{/if}>
          
 <{if $client_base.cle_phone2}>
           <div class="input_append row3">
               <label for="cle_phone2">办公电话</label>
               <div class="input-append">
                   <input type="text" id="cle_phone2"  name="cle_phone2"  value="" onkeyup="number_verification('cle_phone2','_phone_update_msg2')"  base_field='true' />
                   <button class="btn" onclick="sys_dial_num('','cle_phone2')" title="呼叫号码">
                       <span class="glyphicon glyphicon-phone"></span>
                   </button>
                   <button class="btn" onclick="sys_send_sms('','cle_phone2')" title="发送短信">
                       <span class="glyphicon glyphicon-envelope"></span>
                   </button>
               </div>
               <span id='_phone_update_msg2' style='color:red;'></span>
          </div>
      <{if !$client_base.cle_info_source}>
      </div>
      <div class="control-group">
      <{/if}>
  <{/if}>
  
  <{if $client_base.cle_phone3}>
          <div class="input_append row3">
              <label for="cle_phone3">其他电话</label>
              <div class="input-append">
                  <input type="text" id="cle_phone3"  name="cle_phone3"  value="" onkeyup="number_verification('cle_phone3','_phone_update_msg3')" base_field='true' />
                  <button class="btn" onclick="sys_dial_num('','cle_phone3')" title="呼叫号码">
                      <span class="glyphicon glyphicon-phone"></span>
                  </button>
                  <button class="btn" onclick="sys_send_sms('','cle_phone3')" title="发送短信">
                      <span class="glyphicon glyphicon-envelope"></span>
                  </button>
              </div>
              <span id='_phone_update_msg3' style='color:red;'></span>
          </div>
  <{/if}> 
</div>
 <{if $client_base.cle_stat}>
 <div class="control-group">
    <div class="input_append row3"><label for="cle_stat">号码状态</label>
    <{foreach from=$client_state item=state key=skey}>
    <input type="radio"  name="cle_stat" value="<{$state.name}>" base_field='true' <{if $state.name == '未拨打'}> CHECKED <{/if}> /> <span><{$state.name}></span>
    <{/foreach}>
   </div>
</div>
<{/if}>
<{if $client_base.cle_stage}>
<div class="control-group">
   <div id="mainNav">
     <label for="cle_stage" style="float:left;">客户阶段</label>
     <input id="cle_stage" name="cle_stage" value="" type="hidden" base_field='true' />
       <{foreach from=$cle_stage item=stage key=skey name=listName}>
       <span id="stage_step_<{$skey}>" onclick="click_stage_step('<{$skey}>','<{$smarty.foreach.listName.total}>')" title="<{$stage.name}>" cvalue="span_step" <{if $smarty.foreach.listName.last}>class="mainNavNoBg"<{/if}>  ><a title="<{$stage.name}>"><{$stage.name}></a></span>
       <div class="pre1"></div> 
      <div class="pre2"></div> 
       <{/foreach}>
   </div>
</div>
  <{/if}>
<!--配置字段  -----begin-------->
<{counter start=0 print=false assign='client_confirm_count'}><!--  计算  -->
<{foreach from=$client_confirm item=confirm_info key=ckey name=list_Name}>

<{if $confirm_info.data_type==3}>
<{if $client_confirm_count%2 != 0 }>
    </div>
<{/if}>
<{counter start=0 print=false assign='client_confirm_count'}><!-- 从新计算 -->
<div class="control-group">
  <div class="input_append row3"><label for="<{$confirm_info.fields}>"><{$confirm_info.name}></label>
      <textarea id="<{$confirm_info.fields}>" confirm_field='true'  name="<{$confirm_info.fields}>" rows="3" cols="20" <{if $confirm_info.if_require==2}>class="text_area easyui-validatebox" required="true" missingMessage="<{$confirm_info.name}>不能为空" if_require='true' _chinese_name='<{$confirm_info.name}>' <{else}>class="text_area" <{/if}> ><{$confirm_info.default}></textarea>
      <{if $confirm_info.if_require==2}><span class="require-field">*</span><{/if}>
  </div>
</div>

<{elseif $confirm_info.data_type==4}>
<{if $client_confirm_count%2 != 0 }>
    </div>
<{/if}>
<{counter start=0 print=false assign='client_confirm_count'}><!-- 从新计算 -->
<div class="control-group">
<label for="<{$confirm_info.fields}>"><{$confirm_info.name}></label>
  <span id="<{$confirm_info.fields}>_1">
   <select name='<{$confirm_info.fields}>_1' confirm_field='true' onchange="get_comfirm_jl_options(1,'<{$confirm_info.fields}>','<{$confirm_info.jl_series}>',<{$confirm_info.id}>)" <{if $confirm_info.if_require==2}>class="easyui-validatebox" required="true" if_require='true' _chinese_name='<{$confirm_info.name}>_1'<{/if}> >
   <option value="" >--请选择--</option>
    <{assign var="field_type" value=$confirm_info.fields|cat:'_1'}>
    <{foreach from=$jl_options.$field_type item=option key=jlkey}>
    <option value="<{$jlkey}>" ><{$option}></option>
    <{/foreach}>
   </select>
  </span>
  <span id="<{$confirm_info.fields}>_2"></span>
  <{if $confirm_info.jl_series==3}>
  <span id="<{$confirm_info.fields}>_3"></span>
  <{/if}>
  <{if $confirm_info.if_require==2}><span class="require-field">*</span><{/if}>
</div>

<{elseif $confirm_info.data_type==7}><!--级联多选框-->
<{if $client_confirm_count%2 != 0 }>
    </div>
<{/if}>
<{counter start=0 print=false assign='client_confirm_count'}><!-- 从新计算 -->
<div class="control-group">
  <label for="<{$confirm_info.fields}>"><{$confirm_info.name}></label>
  <table>
      <{assign var="field_type" value=$confirm_info.id|cat:'_1'}>
      <{assign var="field_type2" value=$confirm_info.id|cat:'_2'}>
      <{foreach from = $checkbox_options.$field_type item=check_option1 key=id1}>
      <tr>
          <th style="padding-bottom:5px;"><{$check_option1.name}></th>
      </tr>
      <tr>
          <td style="padding-bottom:5px;">
              <{foreach from = $checkbox_options.$field_type2 item=check_option key=id2}>
                  <{if $check_option.p_id == $id1}>
                      <input type="checkbox" checkbox_name="<{$confirm_info.fields}>" checkbox_pid="<{$id1}>" name="<{$confirm_info.fields}>_2[]" value="<{$id2}>" confirm_field='true' /> <{$check_option.name}>&nbsp;
                  <{/if}>
              <{/foreach}>
          </td>
      </tr>
      <{/foreach}>
  </table>
</div>
   
<{else}>
<{if $client_confirm_count%2 == 0 }>
<div class="control-group">
<{/if}>
  <div class="input_append row3">
  <label for="<{$confirm_info.fields}>"  ><{$confirm_info.name}></label>
      <{assign var="parent_id" value=$confirm_info.id}>
      <{if $field_detail.$parent_id||$confirm_info.data_type==2}>
          <select id="<{$confirm_info.fields}>"  name="<{$confirm_info.fields}>" confirm_field='true' <{if $confirm_info.if_require==2}>class="easyui-validatebox" required="true" missingMessage="<{$confirm_info.name}>不能为空" if_require='true' _chinese_name='<{$confirm_info.name}>'<{/if}> >
              <{foreach from=$field_detail.$parent_id item=detail key=dkey}>
              <option value="<{$detail}>"><{$detail}></option>
              <{/foreach}>
              <option value="" selected></option>
          </select> 
          <{if $confirm_info.if_require==2}><span class="require-field">*</span><{/if}>
      <{elseif $confirm_info.data_type==5}><!-- 日期框 -->
          <div class="input-append">
              <input type="text" name="<{$confirm_info.fields}>" id="<{$confirm_info.fields}>" value="<{if $confirm_info.default=='系统时间'}><{if $confirm_info.datefmt=='yyyy-MM-dd'}><{$now_date}><{else}><{$now_time}><{/if}><{else}><{$confirm_info.default}><{/if}>" confirm_field='true'  <{if $confirm_info.if_require==2}>_date='date_box' _chinese_name='<{$confirm_info.name}>' if_require='true'<{/if}> readonly>
              <button type="button" role="date" class="btn" onclick="WdatePicker({el: '<{$confirm_info.fields}>',dateFmt:'<{$confirm_info.datefmt}>'})">
                  <span class="glyphicon glyphicon-calendar"></span>
              </button>
          </div>
          <{if $confirm_info.if_require==2}><span class="require-field">*</span><{/if}>
      <{else}>
         <input type="text" id="<{$confirm_info.fields}>" name="<{$confirm_info.fields}>" confirm_field='true' value="<{$confirm_info.default}>" <{if $confirm_info.if_require==2}>class="easyui-validatebox" required="true"  missingMessage="<{$confirm_info.name}>不能为空" if_require='true' _chinese_name='<{$confirm_info.name}>'<{/if}> />
         <{if $confirm_info.if_require==2}><span class="require-field">*</span><{/if}>
        <{/if}>
      </div>
      <{if $client_confirm_count%2 != 0 }>
      </div>
      <{/if}>
       <{counter print=false assign='client_confirm_count'}><!--   加1   -->
      <{/if}>
      <{/foreach}>
       <{if $client_base.cle_province_name||$client_base.cle_address}>
       <{if $client_confirm_count%2 != 0 }>
          </div>
      <{/if}>
      <div class="control-group">
        <label for="">详细地址</label>
          <{if $client_base.cle_province_name}>
          <select id="cle_province_id" name='cle_province_id' style="width:103px;" base_field='true' onchange="change_regions_type('cle_province_id','cle_city_id','2');"><option value="0" >--选择省--</option>
              <{html_options options=$regions_info }>
          </select>
          <select id="cle_city_id" name="cle_city_id" style="width:103px;" base_field='true'>
          <option value="0">--选择市--</option>
          </select>
          <{/if}>
          <{if $client_base.cle_address}>
          <input  class="input_cle_address" type="text" name="cle_address" id="cle_address" base_field='true' value="">
          <{/if}>
      </div>
      <{/if}>
       <{if $client_base.cle_remark}>
      <div class="control-group">
          <label for="cle_remark">客户备注</label>
          <textarea id="cle_remark"  name="cle_remark"  base_field='true' rows="3" cols="20" class="text_area" ></textarea>
      </div>
      <{/if}>

  </div>
</div>
</div>
</div>
<{if $power_use_contact!=1}>
<div id="tab_contact" style="margin-bottom:10px;">
<div data-options="border:false" title="<span>联系人基本信息</span>">
<div class="main-div main-margin-div" style="padding-bottom: 0">
<div class="form-horizontal">
    <div class="control-group">
       <div class="input_append row3">
           <label for="con_name">联系人姓名</label>
           <input type="text"  name="con_name" id="con_name"  value="">
       </div>
       <div class="input_append row3">
            <label for="con_mobile">联系人电话</label>
            <div class="input-append">
                <input type="text" id="con_mobile"  name="con_mobile"  value="" onkeyup="number_verification('con_mobile','_contact_phone_msg')" />
                <button class="btn" onclick="sys_dial_num('','con_mobile')" title="呼叫号码">
                    <span class="glyphicon glyphicon-phone"></span>
                </button>
                <button class="btn" onclick="sys_send_sms('','con_mobile')" title="发送短信">
                    <span class="glyphicon glyphicon-envelope"></span>
                </button>
            </div>
            <span id='_contact_phone_msg' style='color:red;'></span>
        </div>
      </div>
      <{if $contact_base.con_mail}>
        <div class="control-group">
            <label for="con_mail">邮箱</label>
            <input type="text" id="con_mail"  name="con_mail"  value="" class="easyui-validatebox"  validType="email" base_field='true'  />
          </div>
      <{/if}>
        <!--配置字段  -----begin-------->
        <{counter start=0 print=false assign='contact_confirm_count'}><!-- 计算 -->
        <{foreach from=$contact_confirm item=confirm_info key=ckey name=list_Name}>
  
        <{if $confirm_info.data_type==3}>
        <{if $contact_confirm_count%2 != 0 }>
          </div>
        <{/if}>
        <{counter start=0 print=false assign='contact_confirm_count'}><!-- 从新计算 -->
            <div class="control-group">
                <label for="<{$confirm_info.fields}>"><{$confirm_info.name}></label>
                <textarea id="<{$confirm_info.fields}>" confirm_field='true'  name="<{$confirm_info.fields}>" rows="3" cols="20" <{if $confirm_info.if_require==2}>class="easyui-validatebox text_area" required="true" missingMessage="<{$confirm_info.name}>不能为空" if_require='true' _chinese_name='<{$confirm_info.name}>' <{else}>class="text_area" <{/if}> ><{$confirm_info.default}></textarea>
                <{if $confirm_info.if_require==2}><span class="require-field">*</span><{/if}>
            </div>
    
<{elseif $confirm_info.data_type==4}>
<{if $contact_confirm_count%2 != 0 }>
  </div>
<{/if}>
<{counter start=0 print=false assign='contact_confirm_count'}><!-- 从新计算 -->
    <div class="control-group">
        <label for="<{$confirm_info.fields}>"><{$confirm_info.name}></label>
        <span id="<{$confirm_info.fields}>_1">
         <select name='<{$confirm_info.fields}>_1' confirm_field='true' onchange="get_comfirm_jl_options(1,'<{$confirm_info.fields}>','<{$confirm_info.jl_series}>',<{$confirm_info.id}>)" <{if $confirm_info.if_require==2}>class="easyui-validatebox" required="true" if_require='true' _chinese_name='<{$confirm_info.name}>_1'<{/if}> >
         <option value="" >--请选择--</option>
          <{assign var="field_type" value=$confirm_info.fields|cat:'_1'}>
          <{foreach from=$jl_options.$field_type item=option key=jlkey}>
          <option value="<{$jlkey}>" ><{$option}></option>
          <{/foreach}>
         </select>
        </span>
        <span id="<{$confirm_info.fields}>_2"></span>
        <{if $confirm_info.jl_series==3}>
         <span id="<{$confirm_info.fields}>_3"></span>
        <{/if}>
        <{if $confirm_info.if_require==2}><span class="require-field">*</span><{/if}>
</div>
    
<{elseif $confirm_info.data_type==7}><!--级联多选框-->
<{if $contact_confirm_count%2 != 0 }>
  </div>
<{/if}>
<{counter start=0 print=false assign='contact_confirm_count'}><!-- 从新计算 -->
<div class="control-group">
    <label for="<{$confirm_info.fields}>"><{$confirm_info.name}></label>
        <table>
            <{assign var="field_type" value=$confirm_info.id|cat:'_1'}>
            <{assign var="field_type2" value=$confirm_info.id|cat:'_2'}>
            <{foreach from = $checkbox_options.$field_type item=check_option1 key=id1}>
            <tr>
                <th style="padding-bottom:5px;"><{$check_option1.name}></th>
            </tr>
            <tr>
                <td style="padding-bottom:5px;">
                    <{foreach from = $checkbox_options.$field_type2 item=check_option key=id2}>
                        <{if $check_option.p_id == $id1}>
                            <input type="checkbox" checkbox_name="<{$confirm_info.fields}>" checkbox_pid="<{$id1}>" name="<{$confirm_info.fields}>_2[]" value="<{$id2}>" confirm_field='true' /> <{$check_option.name}>&nbsp;
                        <{/if}>
                    <{/foreach}>
                </td>
            </tr>
            <{/foreach}>
        </table>
 </div>  
        
        <{else}>
            <{if $contact_confirm_count%2 == 0 }>
            <div class="control-group">
            <{/if}>
                <div class="input_append row3">
                  <label for="<{$confirm_info.fields}>"  ><{$confirm_info.name}></label>
                  <{assign var="parent_id" value=$confirm_info.id}>
                  <{if $field_detail.$parent_id||$confirm_info.data_type==2}>
                  <select id="<{$confirm_info.fields}>"  name="<{$confirm_info.fields}>" confirm_field='true' <{if $confirm_info.if_require==2}>class="easyui-validatebox" required="true" missingMessage="<{$confirm_info.name}>不能为空" if_require='true' _chinese_name='<{$confirm_info.name}>'<{/if}> >
                      <{foreach from=$field_detail.$parent_id item=detail key=dkey}>
                      <option value="<{$detail}>"><{$detail}></option>
                      <{/foreach}>
                      <option value="" selected></option>
                  </select> 
                  <{if $confirm_info.if_require==2}><span class="require-field">*</span><{/if}>
                  <{elseif $confirm_info.data_type==5}><!-- 日期框 -->
                  <div class="input-append">
                      <input type="text" name="<{$confirm_info.fields}>" id="<{$confirm_info.fields}>" value="<{if $confirm_info.default=='系统时间'}><{if $confirm_info.datefmt=='yyyy-MM-dd'}><{$now_date}><{else}><{$now_time}><{/if}><{else}><{$confirm_info.default}><{/if}>" confirm_field='true'  <{if $confirm_info.if_require==2}>_date='date_box' _chinese_name='<{$confirm_info.name}>' if_require='true'<{/if}> readonly>
                      <button type="button" role="date" class="btn" onclick="WdatePicker({el: '<{$confirm_info.fields}>',dateFmt:'<{$confirm_info.datefmt}>'})">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </button>
                  </div>
                  <{if $confirm_info.if_require==2}><span class="require-field">*</span><{/if}>
                  <{else}>
                  <input type="text" id="<{$confirm_info.fields}>" name="<{$confirm_info.fields}>" confirm_field='true' value="<{$confirm_info.default}>" <{if $confirm_info.if_require==2}>class="easyui-validatebox" required="true" missingMessage="<{$confirm_info.name}>不能为空" confirm_chinese_name='<{$confirm_info.name}>' if_require='true'<{/if}> />
                  <{if $confirm_info.if_require==2}><span class="require-field">*</span><{/if}>
                  <{/if}>
            </div>
            <{if $contact_confirm_count%2 != 0 }>
            </div>
            <{/if}>
            <{counter print=false assign='contact_confirm_count'}><!--   加1   -->
            <{/if}>
            <{/foreach}>
            <!--配置字段  ------end------- -->
            <{if $contact_base.con_remark}>
            <{if $contact_confirm_count%2 != 0 }>
              </div>
            <{/if}>
            <div class="control-group">
                <label for="con_remark">联系人备注</label>
                <textarea id="con_remark"  name="con_remark" base_field='true' rows="4" cols="20" class="text_area"></textarea>
            </div>
            <{/if}>
  </div>
</div>
</div>
</div>
</div>
<{/if}>

<div class="form-inline" style="text-align:right;padding-bottom:5px;">
      <span style='color:red;' id='_save_msg'></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      保存之后：
      <input type="radio" name="end_type" id="end_type_0" value="0" onclick="record_end_type(0)" />
          <label for="end_type_0"  id="label_type_0">添加联系记录</label>
      <input type="radio" name="end_type" id="end_type_1" value="1" onclick="record_end_type(1)" />
          <label for="end_type_1"  id="label_type_1">继续添加客户</label>
      <input type="radio" name="end_type" id="end_type_2" value="2" onclick="record_end_type(2)" />
          <label for="end_type_2"  id="label_type_2">返回客户列表</label>
      <button class="new_con_btn" type="button"  id="save_client" onclick="save_client_info()">
          <span class="iconfont">&#xe637;&nbsp;</span>保存数据 
      </button>
</div>

<div id="display_repeat_data"></div>
<div id='set_field_confirm'></div><!--  自定义字段设置   -->
<div id='set_dictionary'></div><!--  数据字典   -->
<{include file="pagefooter.htm"}>
<script src="assets/datepicker/WdatePicker.js" type="text/javascript"></script>
<script src="assets/easyui/easyui-validtype.js" type="text/javascript"></script>
<script src="assets/js/client_info.js?1.2" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
var global_cle_phone = '<{$cle_phone|default:''}>';
var power_phone_view = <{$power_phone_view}>;
var phone_ifrepeat = <{$phone_ifrepeat}>;//是否允许系统电话重复（参数设置可设置）
var power_fieldsconfirm = <{$power_fieldsconfirm}>;
var power_dictionary = <{$power_dictionary}>;
var power_use_contact = "<{$power_use_contact|default:0}>";
var jl_field_type = eval("(" + '<{$jl_field_type}>' + ")");
<{if $transfer_type }>
var transfer_type = <{$transfer_type|default:0}>;
var pro_id = <{$pro_id}>;
var task_id = <{$task_id}>;
<{else}>
var transfer_type = 0;
var pro_id = 0;
var task_id = 0;
<{/if}>
</script>