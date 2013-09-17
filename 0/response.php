<?php

class response{
	public function responseMsg(){
		if($_SERVER['REQUEST_METHOD']=='POST') {
			$this->responseWX();
		}else{  
			$this->responseWeb();
		}
	} 
	private function responseWeb(){
        $keyfrom = "goodbaiA";    //申请APIKEY时所填表的网站名称的内容
        $apikey = "2122702772";  //从有道申请的APIKEY    
        //有道翻译-json格式
        $url_youdao = 'http://fanyi.youdao.com/fanyiapi.do?keyfrom='.$keyfrom.'&key='.$apikey.'&type=data&doctype=json&version=1.1&q='.$word; 
    echo $url_youdao;
	$resultstr = $this->getdata4URL($url_youdao);
	echo $resultstr;
    $result = json_decode($resultstr,true);
	echo $result;
	echo $result->translation;

    $errorCode = $result['errorCode']; 
	if($errorCode == 0){

		$phonetic = "[".$result[ 'basic' ][ 'phonetic' ]."]\n";
		$title = $result[ 'query' ].": ".$phonetic;
		$explains = $result['basic']['explains'][0]."\n";
		$devide = "=========\n相关词组：\n";
		$other = $result['web'][0]['key'].": ".$result['web'][0]['value'][0]."\n";
		
	}else{
		$trans = "服务出错";
	}
 //   $trans = $result['translation'][0];
       //	$trans = "dddddd";
		$trans = $title.$explains.$devide.$other;
        return $trans;   
	}
	private function responseWX(){
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
                  //$contentStr = "Welcome to wechat world!";
                  //$contentStr = $keyword;
                   // $contentStr = $this->baiduTran($keyword);
                  $translateOBJ = new translate();                  
                  $contentStr = $translateOBJ->youdaoTran($keyword);
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }
    }
    private function getReqDataWX()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
      	//extract post data
		if (!empty($postStr)){               
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);               
        }else {
        	echo "NULL";
        	exit;
        }
    }//function responseWX END
}// class resopnse END


?>