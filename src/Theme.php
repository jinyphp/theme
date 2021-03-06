<?php
/*
 * This file is part of the jinyPHP package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Jiny\Theme;

//use \Jiny\Core\Registry\Registry;
//use \Jiny\Theme\Layout\Layout;
//use \Jiny\Theme\Layout\Show;
//use Jiny\Filesystem\File;

/**
 * 테마 관리 객체
 */
class Theme 
{
    use \Jiny\Petterns\Singleton; // 싱글턴 패턴 적용

    /**
     * 테마 초기화
     */
    public function __construct($name=null, $path=null)
    {
        $this->setName($name);
        $this->setPath($path);
    }

    /**
     * 테마를 선택합니다.
     */
    public $_name; // 테마이름
    public function setName($name) { $this->_name = $name; return $this; }

    /**
     * 선택한 테마의 경로명을 선택합니다.
     */
    public $_path; // 테마 파일 경로
    public function setPath($path=null) { 
        if($path) {
            $this->_path = $path; 
        } else {
            $this->_path = "../theme/".$this->_name;//."/src";
        }
        return $this; 
    }

    private function init($name=null, $path=null)
    {
        // echo __METHOD__;
    }

    private $_layout;
    public function layout($file=null)
    {
        if (!$this->_layout) {
            $this->_layout = new \Jiny\Theme\Layout($this);
            if ($file) $this->_layout->setFile($file);
        }
        return $this->_layout;
    }

    private $_header;
    public function header()
    {
        if (!$this->_header) {
            $this->_header = new \Jiny\Theme\Header($this);
        }
        
        return $this->_header;
    }

    public function footer()
    {
        $layout = new \Jiny\Theme\Footer($this);
        return $layout;
    }

    public function nav()
    {
        $layout = new \Jiny\Theme\Nav($this);
        return $layout;
    }

    // 테마안에 있는 리소스를 읽어옵니다.
    public function resource($file, $args=[])
    {
        $subpath = DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR;
        $file = $this->_path.$subpath.$file;
        return \jiny\html_get_contents($file);
    }






    /**
     * 테마정보
     */
    private $path;
    public function path()
    {
        /*
        if(isset($this->path)) {
            return $this->path;
        } else {
            $this->path = conf("ENV.path.theme");
            return $this->path;
        }
        */
    }






    use PreFix;

    // 인스턴스
    private $App;
    public $View;

    public $_env=[];
    const FRONTMATTER = "page";
    


    

    public $theme;

    /**
     * 테마명을 읽어옵니다.
     */ 
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * 테마를 설정합니다.
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
        return $this;
    }

    /**
     * 테마 이를을 확인합니다.
     */
    public function name($body)
    {
        
        // 머리말에 적용할 테마를 직접 지정을 할 경우
        if ($theme = $this->pageTheme($body->getData())) {
            // 커스텀 테마 확인
            return $theme;

        } else if($this->theme) {
            // 기본 설정값 (반복중지)
            return $this->theme;

        } else if ($theme = $this->siteTheme()) {
            // 기본환경 설정을 적용합니다.
            $this->theme = $theme;
            return $theme;
        }
    }

    /**
     * 페이지의 커스텀 테마
     */
    private function pageTheme($data)
    {
        // 커스텀 테마 확인
        if (isset($data[self::FRONTMATTER]['theme'])) {
            // 머리말에 적용할 테마를 직접 지정을 할 경우
            // 우선 처리합니다.
            return $data[self::FRONTMATTER]['theme'];
        }
    }

    /**
     * 사이트 환경 변수 설정 테마
     */
    private function siteTheme()
    {
        return conf("site.theme");
    }

    /**
     * 테마의 설정을 읽어 옵니다.
     */
    public function isTheme($body=null)
    {
        // 테마 환경 설정을 읽어 옵니다.          
        if ($theme_name = $this->name($body)) {

            // 테마 환경설정파일의 경로
            $this->_path = $this->path();

            $path = $this->themePath();
            $this->_env = ini(".".$path.File::DS."theme.ini");
            return $this->_env;
            // return $this->themeENV($theme_name, $this->_path);
        } else {
            /*
            echo "테마가 설정되어 있지 않습니다.\n";
            echo __FILE__."(".__LINE__.")\n";
            exit;
            */
        }
        
        // 사이트 테마가 설정되어 있지 않습니다
        return NULL;
    }





    private function themePath()
    {
        $env_file = File::osPath($this->path);
        $env_file .= File::DS;
        $env_file .= File::osPath($this->theme);

        return $env_file;
    }

    /**
     * 테마의 환경변수를 읽어 옵니다.
     */
    /*
    public function themeENV($file, $path)
    {
        if ($file && $path) {
            echo "테마 경로\n";        
            $path = str_replace("/", File::DS, ROOT.$path.File::DS.$file.File::DS);

            $Conf = Registry::get("CONFIG");
            $this->_env = $Conf->Drivers['INI']->load("theme", $path);
            if ($this->_env) {
                return $this;
            } else {
                echo "테마 설정파일을 읽을 수 없습니다.";
            }            
        } 
        
        //echo "테마가 설정되어 있지 않습니다.<br>";
        return NULL;     
    }
    */
    
    /**
     * 테마 환경설정 파일을 읽어옵니다.
     */
    public function getENV()
    {
        return $this->_env;
    }

    /**
     * 테마를 랜더링 합니다.
     * 탬플릿 메소드 패턴으로 구현합니다.
     */
    public function render($html=null)
    {
        if ($this->_env['layout']) { 
            $layout = \jiny\layout();
            $code = $this->_env['_content'];
        } else {
            // 레이아웃이 없는 경우 바로 출력합니다.
            $layout = (new Show($this))->progress();
            $code = "{(content)}";
        }

        // 본문을 치환합니다.            
        $layout = str_replace($code, $html->getContent(), $layout); 
        $html->setContent($layout);

        return $layout;
    }

    /**
     * 
     */
}