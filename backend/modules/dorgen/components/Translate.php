<?php

class Translate
{
    public $text;
    public static $UA = array (
			"Mozilla/5.0 (Windows; U; Windows NT 6.0; fr; rv:1.9.1b1) Gecko/20081007 Firefox/3.1b1",
			"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.0",
			"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.19 (KHTML, like Gecko) Chrome/0.4.154.18 Safari/525.19",
			"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.2.149.27 Safari/525.13",
			"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)",
			"Mozilla/4.0 (compatible; MSIE 7.0b; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.40607)",
			"Mozilla/4.0 (compatible; MSIE 7.0b; Windows NT 5.1; .NET CLR 1.1.4322)",
			"Mozilla/4.0 (compatible; MSIE 7.0b; Windows NT 5.1; .NET CLR 1.0.3705; Media Center PC 3.1; Alexa Toolbar; .NET CLR 1.1.4322; .NET CLR 2.0.50727)",
			"Mozilla/45.0 (compatible; MSIE 6.0; Windows NT 5.1)",
			"Mozilla/4.08 (compatible; MSIE 6.0; Windows NT 5.1)",
			"Mozilla/4.01 (compatible; MSIE 6.0; Windows NT 5.1)");
    
        public static function getRandomUserAgent ( ) {
               srand((double)microtime()*1000000);
               return "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36";
               return Translate::$UA[rand(0,count(Translate::$UA)-1)];
        }
////	
	public static function getContent ($text,$from='en',$to='ru') {
                       

//            $text=urlencode($text);
            $url = 'http://translate.google.com.ua/translate_a/t';
            $post = "client=t&text=$text&hl=$to&sl=$from&tl=$to&ie=UTF-8&oe=UTF-8&multires=1&otf:1&ssel=0&tsel=0&otf=1&pc=1&ssel=0&tsel=0";
            $post = "sl=$from&tl=$to&prev=_t&text=$text&ie=UTF-8";
	 	// Crea la risorsa CURL
            $spys= Yii::app()->getModule('spys')->getProxy();
	    $ch = curl_init();
	 
	    // Imposta l'URL e altre opzioni
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_USERAGENT, Translate::getRandomUserAgent());
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            
            //proxy
            
	    curl_setopt($ch, CURLOPT_POST,true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // add POST fields  
            
	    // Scarica l'URL e lo passa al browser
	    $output = curl_exec($ch);
	    $info = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $info22 = curl_getinfo($ch);
	    // Chiude la risorsa curl
	    curl_close($ch);

	    if ($output === false || $info != 200) {
	      $output = null;
	    }
            
            
	    return $output;
	 
	}
    
    public static function tr($text, $from='en', $to='ru') {
        
        $translate_text = Translate::getContent($text);
        
        if(!$translate_text)
            return FALSE;
        
        $text_arr=array();
        $arr = explode(',',$translate_text);
//        Y::dump($translate_text);
        foreach ($arr as $i => $value) {
            if($arr[$i]==="\"en\"")
                break;
            $text_arr[$i]=$value;
        }
        unset($arr);
        $text_str = implode('', $text_arr);
        $text_str=preg_replace("/([A-Za-z\"\[\]\'])|(ʹ+)/","",$text_str);
        $text_str=preg_replace("/(\d\d\\\\)|(\\\\)|(\. )/",'',$text_str);
    
    return $text_str;
//     echo $text_str=preg_replace("/(ʹ+)|(\.  )/","",$text_str);
//      echo $text_str=preg_replace('#(\.  )#', "\1",$text_str);
    }
    
    public static function Tr_Page($url,$http='http://') {
            $url = preg_match('~http://~', $url) ? $url : $http.$url;
            $url= 'http://translate.google.com.ua/translate?hl=ru&ie=UTF8&prev=_t&sl=auto&tl=ru&u='.$url;
            $referer='http://translate.google.com.ua/';
	    $ch = curl_init();
	 
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_USERAGENT, Translate::getRandomUserAgent());
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            curl_setopt($ch, CURLOPT_REFERER, $referer); //откуда пришли
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//разрешить переадресацию
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	    $output = curl_exec($ch);
	    $info = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    $info2 = curl_getinfo($ch);
	    curl_close($ch);

	    if ($output === false || $info != 200) {
	      $output = null;
	    }

            if($output){
                
                preg_match_all('/<iframe src="(.*?)" name=c/i', $output, $res);
                $res[1][0] =urldecode($res[1][0]);
                $res = "http://translate.google.com.ua".$res[1][0];
            }
            if(!isset($res))
                return FALSE;
            
            return Translate::Tr_Page1($res, $url);
        
    }
    
    public static function Tr_Page1($url,$referer='') {

            $referer= $referer ? $referer : 'http://translate.google.com.ua/';
	    $ch = curl_init();
            $url = preg_replace('/;/', '&', $url);

            curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_USERAGENT, Translate::getRandomUserAgent());
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            curl_setopt($ch, CURLOPT_REFERER, $referer); //откуда пришли
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//разрешить переадресацию
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	    $output = curl_exec($ch);
	    $info = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    curl_close($ch);
	    if ($output === false || $info != 200) {
	      $output = null;
	    }

            preg_match_all('/URL=(.*?)">/i', $output, $res);
            $res[1][0] =urldecode($res[1][0]);
            $url = preg_replace('/;/', '&', $res[1][0]);

            return Translate::Tr_Page2($url, $url);
        
    }
    
    public static function Tr_Page2($url,$referer='') {
        
            $origUrl = $url;
            
            $referer= $referer ? $referer : 'http://translate.google.com.ua/';
	    $ch = curl_init();
            $url = preg_replace('/;/', '&', $url);

            curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_USERAGENT, Translate::getRandomUserAgent());
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            curl_setopt($ch, CURLOPT_REFERER, $referer); //откуда пришли
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//разрешить переадресацию
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            
            $cookieFile = Yii::getpathOfAlias('application.components.TranslateCookieGoogle');
            
//            curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookieFile );
            curl_setopt( $ch, CURLOPT_COOKIEFILE, $cookieFile );
            
	    $output = curl_exec($ch);
	    $info = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    $info22 = curl_getinfo($ch);
//            Y::dump($info22);
//            Y::dump($info,false);

             $infoFull=curl_getinfo($ch);
             $infoUrl=$infoFull['url'];
             $is_eHow =   preg_match('/ehow\.com\/how/', $infoUrl);
	    curl_close($ch);
//            echo $output;
//        Y::dump($output);
            if($info22 === 403)
            {
                Y::dump($output);
//                echo $output;
                sleep(360);
                return 403;
                echo $output;
                  Y::dump($info22);
                  exit;
            }
            //бан, нужна капча
            if($info == 503){
//                echo $output;
//                  Y::dump($output);
                
               echo 503;
                exit; 
//            sleep(30);
                
                preg_match('/<img src="(.*?)" border/', $output, $imageUrl);
                $imageUrl = "http://ipv4.google.com".$imageUrl[1];
                preg_match('/id=(\d+)/', $imageUrl, $imageId);
                $imageId = $imageId[1];
                $rucapcha = new RuCaptcha();
                $rucapcha->googleFields=array(
                    'continue'=>$referer,
                    'id'=>$imageId,
                    'captcha'=>'123456',
                    'submit'=>'Отправить',
                );
                                

                $url = str_replace('&&', '&', $url);
                $rucapcha->googleRefferer = $url;
                
                $rucapcha->googleUrl = 'http://ipv4.google.com/sorry/CaptchaRedirect';
                
                $gogleAbus = new GoogleAbus();
                $saved = $gogleAbus->goToErrorPage();
                
                
                if($saved)
                {

//                                            Y::dump($rucapcha);
        
        $post = http_build_query(array('continue'=>$rucapcha->googleFields['continue']));
	$post=$rucapcha->googleUrl.'?'.$post;
        $rucapcha->googleRefferer = urldecode($post);
//        echo $rucapcha->googleRefferer;
//          Y::dump($rucapcha);
//        exit;
        /*
         * 
         */
//        $rucapcha = new AntigateCaptcha();
        
        
                    $rucapcha->imagePach = $gogleAbus->imagePach;
                    $code = $rucapcha->sendToRuCaptcha();
//                      Y::dump($imageId,FALSE);
//                      Y::dump($code,false);
                    $gogleAbus = new GoogleAbus();
                    $gogleAbus->sendCode($code,$imageId);
                    return 503;
                    echo 503;
                    exit; 
                }
                else
                {
                    echo 503;
                    exit; 
                }
                 
                
            }

            //на деве странный редирект
//             if($info != 200 && !isset($GLOBALS['sasa12'])){
//                
//            $GLOBALS['sasa12']=123;
//          echo $as= Translate::Tr_Page2($info22['redirect_url'], $info22['url']);
//           Y::dump(111111111111,false);
//            }
//            Y::dump($as,false);
//            echo $output;
//            Y::dump($output);
	    if ($output === false || $info != 200) {
	      $output = null;
	    }
            if($info != 200)
                return $info;
                                                       
//            if(!$is_eHow)
//                return 'no_eHow';

           return Translate::clearPage($output);
        
    }
    
    public static function clearPage($page) {
         $page = preg_replace('/<span class="google-src-text"(.*?)\/span>/', '', $page);
//         $page = preg_replace('/<span class="notranslate"(.*?)span>/', '', $page);
         $page = preg_replace('/<iframe(.*?)iframe>/', '', $page);
         $page = preg_replace('!<script(.*?)</script>!si', '', $page);
         $page = preg_replace('!(lang=ru-x-mtfrom-es)!', '', $page);
         $page = preg_replace('!<span onmouseover="_tipon\(this\)" onmouseout="_tipoff\(\)">(.*?)<\/span>!', "$1", $page);
         
         $page = preg_replace('!<div align=center id=mega>(.*?)<\/noscript><\/div>!', '', $page);
         $page = preg_replace('!<noscript(.*?)noscript>!', '', $page);
         $page = preg_replace('!http:\/\/translate(.*?)http!', 'http', $page);
         $page = preg_replace('!&amp;usg(.*?)( |>)!', '$2', $page);
         
         $page = preg_replace('!<style type="text\/css">\.google-src-text(.*?)style>!', '', $page);
         $page = preg_replace('!<meta http-equiv="X-Translated-By" content="Google">!', '', $page);
         $page = preg_replace('!<\!--(.*?)-->!', '', $page);
         
          $page = preg_replace("!<script(.*?)</script>!si","",$page);
            $page = preg_replace("!notranslate!si","text",$page);
            $page = preg_replace("!onmouseover=!si","",$page);
            $page = preg_replace("!_tipon\(this\)!si","",$page);
            $page = preg_replace("!onmouseout=!si","",$page);
            $page = preg_replace("!_tipoff\(\)!si","",$page);
         
         
         return $page;
    }
    

    
    
    

    
}

