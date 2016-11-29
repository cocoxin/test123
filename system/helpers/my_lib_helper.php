<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 得到列表参数
 * @return array page limit sort order
 */
function get_list_param()
{
    $CI = & get_instance();
    $page = $CI->input->post("page");
    $page = empty($page) ? 1 : $page;
    $limit = $CI->input->post("rows");
    $limit = empty($limit) ? 10 : $limit;
    $sort = $CI->input->post("sort");
    $sort = empty($sort) ? NULL : $sort;
    $order = $CI->input->post("order");
    $order = empty($order) ? NULL : $order;

    return array($page, $limit, $sort, $order);
}

/**
 * 创建一个JSON格式的数据
 *
 * @access  public
 * @param   string $content
 * @param   integer $error
 * @param   string $message
 * @param   array $append
 * @return  void
 */
function make_json_response($content = '', $error = 0, $message = '', $append = array())
{
    $CI = & get_instance();
    $CI->load->library('Json');

    $res = array('error' => $error, 'message' => $message, 'content' => $content);
    if (!empty($append) && is_array($append)) {
        foreach ($append AS $key => $val) {
            $res[$key] = $val;
        }
    }
    $val = $CI->json->encode($res);
    exit($val);
}

/**
 * 创建一个JSON格式的正确信息
 *
 * @access  public
 * @param string $content
 * @param string $message
 * @param array $append
 * @return  void
 */
function make_json_result($content = '', $message = '', $append = array())
{
    make_json_response($content, 0, $message, $append);
}

/**
 * 创建一个JSON格式的错误信息
 *
 * @access  public
 * @param string $msg
 * @param   array $append
 * @return  void
 */
function make_json_error($msg = '', $append = array())
{
    make_json_response('', 1, $msg, $append);
}


/**
 * 返回简单sql结果
 *
 * @param bool $result
 * @exception true make_json_result false make_json_error
 * @return string
 */
function make_simple_response($result = TRUE)
{
    if ($result) {
        make_json_result($result);
    } else {
        make_json_error();
    }
}
/**
 * 检查管理员权限
 *
 * @access  public
 * @param   string $authz
 * @return  boolean
 */
function check_authz($authz)
{
    $CI = & get_instance();
    $action_list = $CI->session->userdata('role_action_list');
    // return (preg_match('/^(.*,)?' . $authz . ',/i', $action_list) || $action_list == 'all');
    return 1;
}

/**
 * 数据权限限制
 *
 * @return string where条件
 */
function data_permission()
{
    //检索条件
    $wheres = "1=1 ";
    // $CI = & get_instance();
    // $role_type = $CI->session->userdata('role_type');
    // $user_id = $CI->session->userdata("user_id");
    // $dept_id = $CI->session->userdata('dept_id');

    // switch ($role_type) {
    //     case DATA_DEPARTMENT: //部门数据权限
    //         $CI->load->model("department_model");
    //         //得到所有的子部门的ID(包含自身)
    //         $dept_children = $CI->department_model->get_department_children_ids($dept_id);
    //         if (!empty($dept_children)) {
    //             $dept_children = implode(",", $dept_children);
    //             $wheres = "dept_id IN ($dept_children)";
    //         } else {
    //             $wheres = "dept_id = $dept_id";
    //         }
    //         break;
    //     case DATA_PERSON:
    //         $wheres = "user_id = '$user_id'";
    //         break;
    //     default:
    //         $wheres = "user_id = '$user_id'";

    // }
    return $wheres;
}

/**
 * 将对象成员变量或者数组的特殊字符进行转义
 *
 * @access   public
 * @param    mix        $obj      对象或者数组
 * @author   Xuan Yan
 *
 * @return   mix                  对象或者数组
 */
function addslashes_deep_obj($obj)
{
    if (is_object($obj) == true)
    {
        foreach ($obj AS $key => $val)
        {
            $obj->$key = addslashes_deep($val);
        }
    }
    else
    {
        $obj = addslashes_deep($obj);
    }

    return $obj;
}
/**
 * 递归方式的对变量中的特殊字符进行转义
 *
 * @access  public
 * @param   mix     $value
 *
 * @return  mix
 */
function addslashes_deep($value)
{
    if (empty($value))
    {
        return $value;
    }
    else
    {
        if(is_object($value))
        {
            return addslashes_deep_obj($value);
        }
        else
        {
            return is_array($value) ? array_map('addslashes_deep', $value) : addslashes($value);
        }
    }
}

/**
 * 编码格式转换
 *
 */
function est_iconv($source_lang, $target_lang, $source_string = '')
{
    if(function_exists('mb_convert_encoding'))
    {
        $c = mb_convert_encoding($source_string,$target_lang,$source_lang);
    }
    else
    {
        $c = @iconv($source_lang, $target_lang, $source_string);
    }

    return $c;
}

/**
 * 系统提示信息
 *
 * @access      public
 * @param       string $msg_detail 消息内容
 * @param       int $msg_type 消息类型， 0消息，1错误，2询问
 * @param       array $links 可选的链接
 * @param       bool $auto_redirect 是否需要自动跳转
 */
function sys_msg($msg_detail = '', $msg_type = 0, $links = array(), $auto_redirect = TRUE)
{
    $CI = & get_instance();
    if (count($links) == 0) {
        $links[0]['text'] = '';
        $links[0]['href'] = '';
        $auto_redirect = FALSE;
    }

    $CI->smarty->assign('ur_here', '系统消息');
    $CI->smarty->assign('msg_detail', $msg_detail);
    $CI->smarty->assign('msg_type', $msg_type);
    $CI->smarty->assign('links', $links);
    $CI->smarty->assign('default_url', $links[0]['href']);
    $CI->smarty->assign('auto_redirect', $auto_redirect);

    $CI->smarty->display('message.htm');

    exit;
}