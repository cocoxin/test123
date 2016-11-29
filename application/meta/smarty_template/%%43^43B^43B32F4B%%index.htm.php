<?php /* Smarty version 2.6.19, created on 2016-11-29 09:00:46
         compiled from index.htm */ ?>
<html>
<head>
	<meta charset="UTF-8">
	<title></title>	      
	
	<link rel="stylesheet" type="text/css" href="assets/easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="assets/css/index.css?v=1.0">
	<script type="text/javascript" src="assets/easyui/jquery.min.js"></script>
	<script type="text/javascript" src="assets/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="assets/js/index.js"></script>
</head>
<body class="easyui-layout">
    <div region='north' align='left' title="123"  style='height:0px;padding:0px;overflow:hidden;' data-options="collapsible:false">

    </div>



    <div region='west' style='width:200px;overflow:hidden;'>
        <div class='easyui-accordion'  id='left_menu' fit='true' border='false'>
            <div id='left_menu_div' title="<span  class='menu_text'>客户管理</span>" icon='icon_menu'  style='overflow:auto;'>
                <a href='#' class='menu_item' url="index.php?c=wechat&m=wechat_info_list"><span class="menu_icon_client" >&nbsp;</span>公众号</a>
            </div>
            <div id='left_menu_div' title="<span  class='menu_text'>客户管理</span>" icon='icon_menu'  style='overflow:auto;'>
                <a href='#' class='menu_item' url="index.php?c=client"><span class="menu_icon_client" >&nbsp;</span>我的客户</a>
            </div>
            <div id='left_menu_div' title="<span  class='menu_text'>客户管理</span>" icon='icon_menu'  style='overflow:auto;'>
                <a href='#' class='menu_item' url="index.php?c=client"><span class="menu_icon_client" >&nbsp;</span>我的客户</a>
            </div>
        </div>
    </div>  









    <div region='center'  style='overflow:hidden;'>
      <div id='tabs' class='easyui-tabs' fit='true'  border='false'>
       <div title='工作桌面'>
        <iframe name='mainFrame' frameborder='0' src='index.php?c=main&m=workbench' scrolling='auto' style='width:100%;height:100%;'></iframe>
    </div>
</div>
</div>
<div id="mm" class="easyui-menu cs-tab-menu">
  <div id="mm-tabupdate">刷新</div>
  <div class="menu-sep"></div>
  <div id="mm-tabclose">关闭</div>
  <div id="mm-tabcloseother">关闭其他</div>
  <div id="mm-tabcloseall">关闭全部</div>
</div>
</body>
</html>