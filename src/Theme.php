<?php
namespace Jiny\Theme;

use \Jiny\Core\Registry;

class Theme extends ThemeAbstract
{
    private $Application;

    const PREFIX_START = "{%%";
    const PREFIX_END = "%%}";
    use PreFix;

    use Header, Footer, Layout;

    private $_path;

    public function __construct($app)
    {
        //echo __CLASS__." 객체가 생성이 되었습니다.<br>";
        $this->Application = $app;

        // 객체참조 개선을 위해서 임시저장합니다.
        $this->conf = $this->Application->Config;

        // 테마 환경 설정을 읽어 옵니다.
        $this->_theme = $this->Application->Config->data("site.theme");
        //echo "테마 이름 = ".$this->_theme."<br>";
        if ($this->_theme) {
            // 테마 환경설정파일의 경로
            $this->_path = $this->Application->Config->data("ENV.theme");
            //echo "테마 경로 = ".$this->_path."<br>";

            $this->loadENV();
        } else {
            echo "사이트 테마가 설정되어 있지 않습니다.<br>";
        }
    }

    /**
     * 테마 환경변수를 읽어 옵니다.
     */
    public function loadENV()
    {
        if ($this->_theme) {           
            $path = $this->_path."/".$this->_theme."/";
            $this->_env = $this->conf->Drivers['INI']->loadINI("theme", $path);
            //echo "<pre>";
            //print_r($this->_env);
            //echo "</pre><hr>";
        } else {
            //echo "테마가 설정되어 있지 않습니다.<br>";
        }
        return $this;
    }

    public function loadFile($name)
    {
        $filename = $this->_path."/".$this->_theme."/".$name.".htm";
        echo $filename."<br>";
        if (file_exists($filename)) {
            return file_get_contents($filename);
        } else {
             return NULL;
        }    
        
    }

}