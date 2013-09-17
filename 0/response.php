<?php

class response{
	public function responseTo(){
		if($_SERVER['REQUEST_METHOD']=='POST') {     	
			$postObj = $this->getReqDataWX();
			$this->responseMsg($postObj);
		}else{
          	echo "GET";
			$postObj = $_GET;
            $fromUsername = $postObj['FromUserName'];
            $toUsername = $postObj['ToUserName'];
            $keyword = trim($postObj['Content']);
          	//echo "postObj4:".trim($postObj["Content"]);
			if(!empty( $keyword )){
              	$msgType = "text";
                $translateOBJ = new translate();                  
                $contentStr = $translateOBJ->youdaoTran($keyword);
             	$textTpl = '<div align="center">
					ToUserName:%s
					<br>FromUserName:%s
					<br>Time:%s
					<br>MsgType:%s
					<br>Result:[%s] > %s
					</div>';
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType,$keyword, $contentStr);
                echo $resultStr;
            }else{
                echo "Must Input something...";
            }
		}
	} // responseTo END

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
                	echo "Must Input something...";
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