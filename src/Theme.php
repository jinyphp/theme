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

class Theme extends process
{
    private $App;

    const PREFIX_START = "{%%";
    const PREFIX_END = "%%}";
    use PreFix;

    use Header, Footer, Layout;

    private $_path;

    // 뷰인스턴스
    public $View;

    /**
     * 테마 초기화
     */
    public function __construct($view=null)
    {
        // 객체참조 개선을 위해서 임시저장합니다.
        $this->View = Registry::get("View"); // $view;
        $this->App = Registry::get("App"); // $view->App;
        $this->conf = Registry::get("CONFIG");
    }

    /**
     * 테마의 설정을 읽어 옵니다.
     */
    public function isTheme($body)
    {
        // 테마 환경 설정을 읽어 옵니다.          
        if ($this->_theme = $this->themeName($body)) {
            // 테마 환경설정파일의 경로
            $this->_path = $this->themePath();
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
    public function themePath()
    {
        return conf("ENV.path.theme");
    }

    /**
     * 테마의 환경변수를 읽어 옵니다.
     */
    public function themeENV($file, $path)
    {
        if ($file && $path) {           
            $path = str_replace("/", DS, ROOT.$path.DS.$file.DS);
            $this->_env = $this->conf->Drivers['INI']->load("theme", $path);
            if ($this->_env) {
                return $this;
            } else {
                echo "테마 설정파일을 읽을 수 없습니다.";
            }            
        } 
        
        //echo "테마가 설정되어 있지 않습니다.<br>";
        return NULL;     
    }


    public function loadFile($name)
    {
        $filename = ROOT.DS.$this->_path.DS.$this->_theme.DS.$name.".htm";
        if (file_exists($filename)) {
            return file_get_contents($filename);
        }
        
        return NULL;
    }

    /**
     * 레아아웃 파일을 읽어 옵니다.
     */
    public function layout()
    {
        $basePATH = conf("ENV.path.theme");
        $filename = ROOT.$basePATH.DS.$this->_theme.DS.$this->_env['layout'];
        //echo $filename."<br>";
        if (file_exists($filename)) {
            return file_get_contents($filename);
        } else {
             return "레이아웃 파일이 없습니다.";
        }    
        
    }


    /**
     * 템플릿 메소드 패턴
     */
    public function assamble($html)
    {
        $header = $this->header();
        $footer = $this->footer();

        if ($this->_env['layout']) {

            // 레이아웃 파일을 읽어옵니다.
            $layout = $this->layout();

            // 환경설정에 따라 해더를 치환합니다.
            $layout = str_replace( $this->_env['_header'], $header, $layout);

            // 환경설정에 따라 푸더를 치환합니다.            
            $layout = str_replace( $this->_env['_footer'], $footer, $layout);

            // 본문을 치환합니다.    
            $layout = str_replace( $this->_env['_content'], $html->_body, $layout);
  

        } else {
            // 레이아웃이 없는 경우 바로 출력합니다.
            $layout = $header.$html->_body.$footer; 
        }

        $html->_body = $layout;
    }

    /**
     * 
     */

}