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

use \Jiny\Core\Registry\Registry;

class Theme 
{
    //const PREFIX_START = "{%%";
    //const PREFIX_END = "%%}";
    use PreFix;

    use Header, Footer;

    // 인스턴스
    private $App;
    public $View;

    public $_theme;
    public $_env=[];
    public $_path;

    /**
     * 테마 초기화
     */
    public function __construct($view=null)
    {
        // 객체참조 개선을 위해서 임시저장합니다.
        $this->View = Registry::get("View"); // $view;
        $this->App = Registry::get("App"); // $view->App;
        // $this->conf = Registry::get("CONFIG");

        // 매소드 속도개선을 위해서
        // 초기화 작업을 합니다.
        $this->_path = conf("ENV.path.theme");
    }


    /**
     * 테마를 랜더링 합니다.
     * 탬플릿 메소드 패턴으로 구현합니다.
     */
    public function render($html=null)
    {
        if ($this->_env['layout']) { 
            return (new ThemeLayout($this))->progress($html);
        } else {
            // 레이아웃이 없는 경우 바로 출력합니다.
            return (new ThemeShow($this))->progress($html);
        }        
        return $this;
    }


    /**
     * 테마의 설정을 읽어 옵니다.
     */
    public function isTheme($body=null)
    {
        // 테마 환경 설정을 읽어 옵니다.          
        if ($this->_theme = $this->themeName($body)) {
            // 테마 환경설정파일의 경로
            $this->_path = $this->path();
            return $this->themeENV($this->_theme, $this->_path);
        } 
        
        // echo "사이트 테마가 설정되어 있지 않습니다.<br>";
        return NULL;
    }


    /**
     * 테마이를을 확인합니다.
     */
    public function themeName($body)
    {
        // 커스텀 테마 확인
        if (isset($body->_data['page']['theme'])) {
            // 머리말에 적용할 테마를 직접 지정을 할 경우
            // 우선 처리합니다.
            return $body->_data['page']['theme'];
        
        } else {
            // 기본환경 설정을 적용합니다.
            return conf("site.theme");
        }  
    }


    /**
     * 테마 파일의 환경설정
     */
    public function path()
    {
        return $this->_path;
    }


    /**
     * 테마의 환경변수를 읽어 옵니다.
     */
    public function themeENV($file, $path)
    {
        if ($file && $path) {           
            $path = str_replace("/", DS, ROOT.$path.DS.$file.DS);

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


    /**
     * 
     */
    public function loadFile($name)
    {
        $filename = ROOT.DS.$this->_path.DS.$this->_theme.DS.$name.".htm";
        if (file_exists($filename)) {
            return file_get_contents($filename);
        }
        
        return NULL;
    }


    /**
     * 테마명을 읽어옵니다.
     */ 
    public function getTheme()
    {
        return $this->_theme;
    }


    /**
     * 테마를 설정합니다.
     */
    public function setTheme($theme)
    {
        $this->_theme = $theme;
        return $this;
    }


    /**
     * 테마 환경설정 파일을 읽어옵니다.
     */
    public function getENV()
    {
        return $this->_env;
    }

    /**
     * 
     */
}