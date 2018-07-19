<?php
namespace Jiny\Theme;

use \Jiny\Core\Registry\Registry;

class Theme extends ThemeAbstract
{
    private $App;

    const PREFIX_START = "{%%";
    const PREFIX_END = "%%}";
    use PreFix;

    use Header, Footer, Layout;

    private $_path;

    // 뷰인스턴스
    public $View;

    public function __construct($view)
    {
        //echo __CLASS__."테마를 초기화 합니다.<br>";

        // 객체참조 개선을 위해서 임시저장합니다.
        $this->View = $view;
        $this->App = $view->App;
        // $this->conf = $this->App->Config;

    }

    public function isTheme()
    {
        // 테마 환경 설정을 읽어 옵니다.             
        if ($this->_theme = $this->themeName()) {
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
    public function themeName()
    {
        if (isset($this->View->_data['page']['theme'])) {
            // 뷰파일에 적용할 테마를 직접 지정을 할 경우
            // 우선 처리합니다.
            return $this->View->_data['page']['theme'];
        }

        // 뷰파일에 테마설정이 없는 경우
        // 기본환경 설정을 적용합니다.
        return conf("site.theme");
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
     * 
     */
    public function themeENV($file, $path)
    {
        if ($file) {           
            $path = str_replace("/", DS, ROOT.$path.DS.$file.DS);
            $this->_env = $this->conf->Drivers['INI']->loadINI("theme", $path);
            return $this;
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

    public function render($body)
    {
        $header = $this->header();
        $footer = $this->footer();

        if ($this->_env['layout']) {

            // 레이아웃 파일을 읽어옵니다.
            $layout = $this->layout();

            // 해더를 생성합니다.         
            // 해더를 치환합니다.
            
            $layout = str_replace( $this->_env['_header'], $header, $layout);

            // 푸터를 생성합니다.            
            // 푸터를 치환합니다.
            
            $layout = str_replace( $this->_env['_footer'], $footer, $layout);

            // 본문을 치환합니다.    
            $layout = str_replace( $this->_env['_content'], $body, $layout);

        } else {
            // 레이아웃이 없는 경우 바로 출력합니다.
            //echo "레이아웃이 없습니다.<br>";
            $layout = $header.$body.$footer; 
        }

        return $layout;
    }

}