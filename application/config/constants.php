<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*字段类型*/
define('FIELD_TYPE_CLIENT_CONTACT',-1); //客户+联系人
define('FIELD_TYPE_CLIENT',0); //客户
define('FIELD_TYPE_CONTACT',1); //联系人
define('FIELD_TYPE_PRODUCT',2); //产品
define('FIELD_TYPE_ORDER',3); //订单
define('FIELD_TYPE_SERVICE',4); //客服服务

/*自定义字段文本类型*/
define('DATA_TYPE_INPUT',1); //文本框
define('DATA_TYPE_SELECT',2); //下拉选择
define('DATA_TYPE_TEXTAREA',3); //文本域
define('DATA_TYPE_JL',4); //级联框
define('DATA_TYPE_DATA',5); //日期框
define('DATA_TYPE_CHECKBOXJL',7); //关联级联

/*列表类型*/
define('LIST_CONFIRM_CLIENT',0); //客户管理列表配置
define('LIST_CONFIRM_CONTACT',1); //联系人列表配置
define('LIST_CONFIRM_CLIENT_RESOURCE',3); //资源调配列表配置
define('LIST_CONFIRM_CLIENT_DEAL',4); //数据处理列表配置
define('LIST_COMFIRM_PRODUCT',5); //产品列表配置
define('LIST_COMFIRM_ORDER',6); //订单列表配置
define('LIST_COMFIRM_SERVICE',7); //客服服务 列表配置


/*短信*/
define('MAXSMSLENGTH',300); //短信最大字符数
define('EACHSMSLENGTH',70); //每条短信字符数


/*数据字典*/
define('DICTIONARY_CLIENT_INFO',1); //客户信息- 信息来源 | 清洗信息 - 数据来源
define('DICTIONARY_CLIENT_STAGE',2); //客户信息- 客户阶段
define('DICTIONARY_ORDER_STATE',3); //订单信息- 订单状态
define('DICTIONARY_SERVICE_TYPE',4); //客服服务 - 服务类型
define('DICTIONARY_DELIVERY_MODE',5); //订单信息 - 配送方式
define('DICTIONARY_CLIENT_STATE',6); //客户信息 - 号码状态
define('DICTIONARY_CONTACR_RESULT', 7);//清洗信息 - 联系结果

define('REGION_PROVINCE',1);//省
define('REGION_CITY',2);//市