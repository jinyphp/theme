<?php

namespace Jiny\Theme\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;


use Jiny\Members\Http\Controllers\CrudController;


//use Sunra\PhpSimple\HtmlDomParser;
use KubAT\PhpSimple\HtmlDomParser;


class AdminThemeCopy //extends CrudController
{
    public $theme;
    public $url;
    public function __construct()
    {
        /*
        $this->theme = "samples.replacer";
        $this->url = "https://demo.getreplacer.com/index.html";
        */

        $this->theme = "samples.varkala";
        $this->url = "https://demo.bootstrapious.com/varkala/1-2-1/index.html";

    }

    public function index()
    {        
        $filename = $this->themePath($this->theme);

        ## cURL 파일을 다운로드 합니다.
        $this->download($this->url, $filename."app.blade.php");

        // 경로분석
        if ($html = $this->loadFile($filename."app.blade.php")) {
            $res = $this->parserAppLayout($html);

            
          
            $app = $this->splitBody($html);
            file_put_contents($filename."app.blade.php", $app['app']);
            

            $app = $this->splitHeader($app['body']);
            file_put_contents($filename."header.blade.php", $app['header']);

            $app = $this->splitFooter($app['body']);
            file_put_contents($filename."footer.blade.php", $app['footer']);


            file_put_contents($filename."layout.blade.php", $app['body']);
            //dd($app);
            

            return response($res, 200)
                ->header('Content-Type', 'text/plain');
        }
    }

    private function parserAppLayout($html)
    {
        $path = $this->themePath($this->theme);

        $Dom = new \Jiny\Theme\HtmlDom();
        $res = $Dom->parser($html);

        // 이미지 다운로드
        $tags = $Dom->find("img");

        $imgPath = $path.DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."images";
        if(!is_dir($imgPath)) {
            mkdir($imgPath,777,true);
        }

        //dd($tags);

        foreach($tags as $item) {
            //echo $item->attr['src'];
            if($item->attr['src'][0] == ".") {
                // 이미지 파일명 추출
                if($pos = strpos($this->url,"/",0)) {
                    $domain = substr($this->url,0,$pos+1);
                } else {
                    $domain = $this->url."/";
                }
                
                $img = substr($item->attr['src'], strrpos($item->attr['src'], "/"));
                $this->download($domain.substr($item->attr['src'],1), $imgPath.DIRECTORY_SEPARATOR.$img);

            } else 
            if($item->attr['src'][0] == "/") {
                // 이미지 파일명 추출
                if($pos = strpos($this->url,"/",0)) {
                    $domain = substr($this->url,0,$pos+1);
                } else {
                    $domain = $this->url."/";
                }
                
                $img = substr($item->attr['src'], strrpos($item->attr['src'], "/"));
                $this->download($domain.$item->attr['src'], $imgPath.DIRECTORY_SEPARATOR.$img);

            } else 
            if($item->attr['src'][0] == "h" 
                && $item->attr['src'][1] == "t"
                && $item->attr['src'][2] == "t"
                && $item->attr['src'][3] == "p") {
                // 이미지 파일명 추출
                $img = substr($item->attr['src'], strrpos($item->attr['src'], "/"));
                $this->download($item->attr['src'], $imgPath.DIRECTORY_SEPARATOR.$img);
            }

            $html = str_replace($item->attr['src'],$imgPath.DIRECTORY_SEPARATOR.$img,$html);
            //$item->attr['href'] = "aaa===".$item->attr['href'];
        }
        
        return $html;
    }



    private function loadFile($filename)
    {
        if (file_exists($filename)) {
            return file_get_contents($filename);
        }
    }

    private function themePath($theme)
    {
        $path = resource_path("views".DIRECTORY_SEPARATOR."theme");
        $filename = $path.DIRECTORY_SEPARATOR;
        $filename .= str_replace(".", DIRECTORY_SEPARATOR, $theme);

        if (!is_dir($filename)) {
            mkdir($filename,777,true);
        }

        return $filename.DIRECTORY_SEPARATOR;
    }


    private function download($url, $filename)
    {
        // 다운로드 파일이 없는 경우 진행
        if(!file_exists($filename)) {
            $ch = curl_init($url);
            $fp = fopen($filename, "w");
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);

            return true;
        }

        return false;
    }




















    private function splitHeader($html)
    {
        $pos = strpos($html,"<header");
        $pos1 = $pos;
        $start = $pos; //strpos($html,">",$pos)+1;

        //echo $start."\n";

        $pos = strpos($html,"</header",$pos);
        $end = strpos($html,">",$pos)+1;

        //echo $end."\n";
        //return substr($html,$start,$end-$start);

        $header = substr($html, $start, $end);
       
       
        //$header .= substr($html,$end);

        $body =  substr($html,0,$start);
        $body .= "\n"."@theme(\".header\")";
        $body .= "\n";
        $body .= substr($html,$end);
        return ['header'=>$header, 'body'=>$body];
        //return $app;
    }

    private function splitFooter($html)
    {
        $pos = strpos($html,"<footer");
        $pos1 = $pos;
        $start = $pos; //strpos($html,">",$pos)+1;

        //echo $start."\n";

        $pos = strpos($html,"</footer",$pos);
        $end = strpos($html,">",$pos)+1;

        //echo $end."\n";
        //return substr($html,$start,$end-$start);

        $footer = substr($html, $start, $end);
       
       
        //$header .= substr($html,$end);

        $body =  substr($html,0,$start);
        $body .= "\n"."@theme(\".footer\")";
        $body .= "\n";
        $body .= substr($html,$end);
        return ['footer'=>$footer, 'body'=>$body];
    }

    private function splitBody($html)
    {
        $pos = strpos($html,"<body");
        $start = strpos($html,">",$pos)+1;

        $end = strpos($html,"<script",$pos);

        $app = substr($html,0,$start);
        $app .= "\n"."{{".'$';
        $app .= "slot}}"."\n";
        $app .= substr($html,$end);

        return ['app'=>$app, 'body'=>substr($html, $start, $end-$start)];
    }


}
