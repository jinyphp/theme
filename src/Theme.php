<?php
namespace Jiny\Theme;

use \Jiny\Core\Registry;

class Theme extends ThemeAbstract
{
    const PREFIX_START = "{%%";
    const PREFIX_END = "%%}";
    use PreFix;

    use Header, Footer, Layout;

    public function __construct()
    {

        //echo __CLASS__." 객체가 생성이 되었습니다.<br>";
        // 객체참조 개선을 위해서 임시저장합니다.
        $this->conf = \Jiny\Core\Registry\Registry::get("CONFIG");
    }

    /**
     * 테마 환경변수를 읽어 옵니다.
     */
    public function load()
    {
        if ($this->_theme) {
            $basePATH = $this->conf->data("ENV.theme");
            $path = $basePATH."/".$this->_theme."/";
            $this->_env = $this->conf->Drivers['INI']->loadINI("theme", $path);
            //echo "<pre>";
            //print_r($this->_env);
            //echo "</pre>";
        } else {
            //echo "테마가 설정되어 있지 않습니다.<br>";
        }
        return $this;
    }

    public function loadFile($name)
    {
        $basePATH = $this->conf->data("ENV.theme");
        $filename = $basePATH."/".$this->_theme."/".$name.".htm";
        echo $filename."<br>";
        if (file_exists($filename)) {
            return file_get_contents($filename);
        } else {
             return NULL;
        }    
        
    }

}