<?php
    			echo '<meta charset="utf-8" >';
                $fromUsername = $_POST[ "FromUserName" ];
                $toUsername = $_POST[ "ToUserName" ];
                $keyword = trim($_POST[ "Content" ]);;
                $time = time();
                $textTpl = "<pre>
					ToUserName:%s
					FromUserName:%s
					Time:%s
					MsgType:%s
					Result:[%s] > %s
							</pre>";             
				if(!empty( $keyword ))
                {
              		$msgType = "text";
                  $contentStr = "Welcome to wechat world!";
                  //$contentStr = $keyword;
                  $baiduobj = new baidu();
                  //$contentStr = $baiduobj->baiduTran($keyword);
				  $contentStr = $baiduobj->youdaoTran($keyword);
                  //  $contentStr = $this->youdaoTran($keyword);
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType,$keyword, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }


class baidu{

  public function youdaoTran($word){
        $keyfrom = "goodbaiA";    //申请APIKEY时所填表的网站名称的内容
        $apikey = "2122702772";  //从有道申请的APIKEY    
        //有道翻译-json格式
        //$url_youdao = 'http://fanyi.youdao.com/fanyiapi.do?keyfrom='.$keyfrom.'&key='.$apikey.'&type=data&doctype=json&version=1.1&q='.$word; 
    	$url_youdao = 'http://fanyi.youdao.com/openapi.do?keyfrom=goodbaiA&key=2122702772&type=data&doctype=json&version=1.1&q=wolf'; 
   echo $url_youdao;
    $result = json_decode($this->getdata4URL($url_youdao));

    //   $errorCode = $result['errorCode'];        
    $trans = $result['translation'];
       //	$trans = "dddddd";
        return $trans;  
    }

 	public function baiduTran($word,$from="auto",$to="auto")
    {
      //echo "My tran function.";
      //$word = "你好";
        $appid = "ANGEgE28iVZYfWqOY80ih0Az";
		$word_code=urlencode($word);
		$baidu_url = "http://openapi.baidu.com/public/2.0/bmt/translate?client_id=".$appid."&q=".$word_code."&from=".$from."&to=".$to;
        $text=json_decode($this->getdata4URL($baidu_url));
        $text = $text->trans_result;
    /*    echo "----debug---<br>";
      echo "<a href=".$baidu_url.">OUT</a>";
        echo "----debug---<br>";*/
        $src = $text[0]->src;
        $dst = $text[0]->dst;
        $outstr = "[".$src."]: ".$dst;
        return $outstr;
       
     /* $trans = '';
        $errorCode = $result['error_code'];  
 		if(isset($errorCode)){
            $trans = '出现异常';
        }else{
       		$trans1 = $result['trans_result']['0'];
          	$trans = $trans1->dst;
        	return $trans;
        }
 */
    }

                                                                          
    //百度翻译-获取目标URL所打印的内容
    public function getdata4URL($url){
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
}
?>