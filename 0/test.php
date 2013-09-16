<?php
    
                $fromUsername = $_POST[ "FromUserName" ];
                $toUsername = $_POST[ "ToUserName" ];
                $keyword = trim($_POST[ "Content" ];
                $msgType = trim($_POST[ "MsgType" ];
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
                  $contentStr = $keyword;
                  // $contentStr = $this->baiduTran($keyword);
                  //  $contentStr = $this->youdaoTran($keyword);
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }


                                       /*

$name = $_POST[ 'name' ];
$passwd = $_POST[ 'passwd'  ];
echo "name: ".$name;
echo "\npasswd: ".$passwd;

                                       */

?>