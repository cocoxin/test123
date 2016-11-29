<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define("TOKEN", "icsoc_chat");
define("appID", "wx5144f49e64def255");
define("appsecret", "bddcdb4c51320cd765b73aa42f69b6b6");

class Web_chat extends CI_Controller {

	public function index()
	{
		$echoStr = $_GET["echostr"];
		$this->log_msg('ERROR', '更新数据异常，est_wkf表的id:'.$echoStr);
        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
	   
	}
	/**
     * log_file()
     *
     * @param $text
     * @return void
     */
    function log_msg($state,$text)
    {
        $today = date('Y-m-d');
        $filename = './application/logs/wkf-' . $today . '.log';
        file_put_contents($filename, '['.date("Y-m-d H:i:s").']'.$state.' --> '.$text."\r\n", FILE_APPEND);
    }


    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";             
				if(!empty( $keyword ))
                {
              		$msgType = "text";
                	$contentStr = "Welcome to wechat world!";
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}


	/**
     * GET 请求
     * @param string $url
     */
    public function http_get($url) {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1);
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        }
    }

    /**
     * 以post方式提交xml到对应的接口url
     * @param type $url
     * @param type $postdata
     * @return boolean
     */
    public function http_post($url, $postdata) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        if (is_array($postdata)) {
            foreach ($postdata as &$value) {
                if (is_string($value) && stripos($value, '@') === 0 && class_exists('CURLFile', FALSE)) {
                    $value = new CURLFile(realpath(trim($value, '@')));
                }
            }
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        $data = curl_exec($ch);
        curl_close($ch);
        if ($data) {
            return $data;
        }
        return false;
    }

    public function get_token(){
    	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".appID."&secret=".appsecret;
    	$result = $this->http_get($url);
    	$this->log_msg('ERROR', '更新数据异常，est_wkf表的id:'.$result);
    }

    public function create_menu(){
    	$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=7fKtKYCTcJr-pzz_NXS7s7Kbq5yrHIjmiOHZUC3liBmajGqOUvHdUpKH-Jixq6wJLu6ViarT45OZN_LX_ku4BnC6-lmujViYu2uSA9QlxevkYs_V15-vnRt8zdI20UIqGLMcABAAFG";
    	$data = '{
     "button":[
     {	
          "type":"click",
          "name":"今日歌曲",
          "key":"V1001_TODAY_MUSIC"
      },
      {
           "name":"菜单",
           "sub_button":[
           {	
               "type":"view",
               "name":"搜索",
               "url":"http://www.soso.com/"
            },
            {
               "type":"view",
               "name":"视频",
               "url":"http://v.qq.com/"
            },
            {
               "type":"click",
               "name":"赞一下我们",
               "key":"V1001_GOOD"
            }]
       }]
 }';
    	$result = $this->http_post($url,$data);
    	    	$this->log_msg('ERROR', '更'.$result);
    }
}
