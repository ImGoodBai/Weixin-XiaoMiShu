<?php

echo "Welcome to goodbai.duapp";
//define your token
define("TOKEN", "qwerty2345");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
//$wechatObj->responseMsg();
$wechatObj->baiduTran();

//echo $wecharObj->baiduDic("你好");
class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }
 	public function baiduTran()
    {
    	echo "My tran function.";
    	$word = "你好”;
		$word_code=urlencode($word);
		$appid="aaa";

		$baidu_url = "http://openapi.baidu.com/public/2.0/bmt/translate?client_id=".$appid."&q=".$word_code."&from=".$from."&to=".$to;
		echo $baidu_url;
        $text=json_decode($this->language_text($baidu_url));
        $text = $text->trans_result;
		echo $text;
        return $text[0]->dst;
    }
  
  //百度翻译
    public function baiduDic($word,$from="auto",$to="auto"){
        echo "translating";
        //首先对要翻译的文字进行 urlencode 处理
        $word_code=urlencode($word);
        
        //注册的API Key
        $appid="ANGEgE28iVZYfWqOY80ih0Az";
        
        //生成翻译API的URL GET地址
        $baidu_url = "http://openapi.baidu.com/public/2.0/bmt/translate?client_id=".$appid."&q=".$word_code."&from=".$from."&to=".$to;
        $text=json_decode($this->language_text($baidu_url));

        $text = $text->trans_result;
		echo $text;
        return $text[0]->dst;
    }
        
    //百度翻译-获取目标URL所打印的内容
    public function language_text($url){

        if(!function_exists('file_get_contents')){

            $file_contents = file_get_contents($url);

        }else{
                
            //初始化一个cURL对象
            $ch = curl_init();

            $timeout = 5;

            //设置需要抓取的URL
            curl_setopt ($ch, CURLOPT_URL, $url);

            //设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

            //在发起连接前等待的时间，如果设置为0，则无限等待
            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

            //运行cURL，请求网页
            $file_contents = curl_exec($ch);

            //关闭URL请求
            curl_close($ch);
        }

        return $file_contents;
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                
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
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>