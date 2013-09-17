<?php

class response{
	public function responseTo(){
		if($_SERVER['REQUEST_METHOD']=='POST') {
			$postObj = $this->getReqDataWX();
		}else{
          	echo "GET";
			$postObj = $_POST;
		}
		$this->responseM($postObj);
	} 

	private function responseMsg($postObj){
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
    }// responseMsg END
  
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
      return $postObj;
    }//function responseWX END
}// class resopnse END


?>