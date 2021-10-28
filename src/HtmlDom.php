<?php
namespace Jiny\Theme;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Livewire;

class HtmlDom
{
    public $dom;

    public function __construct()
    {
        $this->dom = [];
    }

    
    public function find($tagname)
    {
        $this->_find = [];
        //dd($this->dom);
        foreach($this->dom as &$tag) {
            $this->findTag($tag, $tagname);
        }
        return $this->_find;
    }

    private $i=1;
    public $_find;
    private function findTag(&$dom, $tagname)
    {
        
        //if($this->i==3) dd($dom);

        foreach($dom->item as &$tag) {
            if(is_object($tag)) {
                if (isset($tag->tagname)) {
                    //echo $tag->tagname;
                    if($tag->tagname == $tagname) {
                        $this->_find []= $tag;
                    }
                }

                //dump($tag);
                //dump($tag->item);
                $this->findTag($tag, $tagname);

                
                
                //
                //$this->i++;
            }
        }        
    }


    public function parser($html)
    {
        $el = new \Jiny\Theme\Tag();

        $el->dom = [];
        $el->item = [];
        $el->next = strpos($html,"<",0);
        $el->dom []= substr($html,0,$el->next);
        
        $el = $this->element($html,$el->next);
        $tagname = $el->tagname;
        $this->dom[ $tagname ] = $el;

        $el = $this->element($html,$el->next);
        $tagname = $el->tagname;
        $this->dom[ $tagname ] = $el;
        
        return $this->dom;
    }

    private function eleAttr($code)
    {
        $pos = strpos($code," ");
        $code = substr($code,$pos+1);
        $code = explode('" ',$code);
        
        $attr = [];
        foreach($code as $item) {
            $k = explode("=",$item);
            if(isset($k[0])) {
                if(isset($k[1])) {
                    if($k[0] == "class") {
                        $val = trim($k[1], '"');
                        $attr[ $k[0] ] = explode(" ",$val);
                    } else 
                    if($k[0] == "style") {
                        $val = trim($k[1], '"');
                        $attr[ $k[0] ] = explode(";",$val);
                    } else {
                        $val = trim($k[1], '"');
                        $attr[ $k[0] ] = $val;
                    }
                }
            }
        }
        
        return $attr;
    }


    private function element($html, $next)
    {
        $el = new \Jiny\Theme\Tag();
        $el->dom = [];
        $el->item = [];
        $el->next = $next;

        // 테그 시작검사
        $el->pos = strpos($html,"<",$el->next);
        //$dom['pos'] = $el['pos'];
        $el->len = strpos($html,">",$el->pos) - $el->pos +1;
        //$dom['len'] = $el['len'];
        
        

        // 테그명 추출
        $code = substr($html,$el->pos + 1, $el->len - 2);
        //$el['code'] = $code;
        $el->tagname = explode(" ", $code)[0];
        //$dom['tagname'] = $el['tagname'];

        

        // 이전 문자열 추출
        $el->text = substr($html, $el->next, $el->pos - $el->next);
        $text = $this->text($el->text);
        if($text) {
            $el->dom []= $text;
            $el->item []= $text;
        }
        // 속성
        $el->attr = $this->eleAttr($code);

        // 다음 검색요소 위치 결정
        $el->next = $el->pos + $el->len;


        // 테그타입
        $el->pare = $this->tagType($el->tagname);

        

        

        // 테그타입별 재귀호출      
        while($el->pare == true) {
            
            //dump($el);
    
            $e = $this->element($html,$el->next);
            $el->next = $e->next; //다음요소

            
            
            if(($e->tagname)[0] == "/") {

                // 종료테그 탈출
                $text = $this->text($e->text);
                if($text) {
                    $el->dom []= $text;
                    $el->item []= $text;
                }

                if($e->tagname == "/head") {
                    //dump($el);
                //dd($e);
                }
                
                break;
            } else {
                // 서브 요소 저장, 주석 요소는 제외
                if($e->tagname != "!--") {
                    $el->dom []= $e;
                    $el->item []= $e;
                }                
            }

            //if($el->tagname == "link") dd($el);
        }

        //dd($el);
        return $el;
    }

    private function text($text)
    {
        $str = [];
        $lines = explode("\n",$text);
        foreach($lines as $line) {
            if(chop($line) !== '') {
                $str []= $line;
            }
        }

        if(!empty($str)) {
            return implode("\n",$str);
        }
        
        return false;
    }


    private function tagType($tagname)
    {
        switch($tagname){
            case 'img': return false;

            case '!DOCTYPE': return false;
            case 'html': return true;
            case 'head': return true;
            case 'meta': return false;
            
            case 'title': return true;
            //case '/title': return true;

            case 'script': return true;
            case 'body': return true;
            case 'header': return true;
            case 'div': return true;
            case 'ul': return true;
            case 'li': return true;
            case 'a': return true;
            case 'footer': return true;
            case 'svg': return true;
            case 'use': return true;
            case 'p': return true;
            case 'nav': return true;
            case 'button': return true;
            case 'form': return true;
            case 'h1': return true;
            case 'h2': return true;
            case 'h3': return true;
            case 'h4': return true;
            case 'h5': return true;
            case 'h6': return true;
            case 'span': return true;
            case 'section': return true;
            case 'small': return true;
            case 'strong': return true;
            case 'i': return true;
            case 'label': return true;
            case 'del': return true;
            case 'select': return true;
            case 'option': return true;
            default:
                return false;
        }
    }


}