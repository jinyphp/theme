<?php

namespace Jiny\Theme;

trait Header
{
    /**
     * 해더파일을 읽어 옵니다.
     * 해더 프로퍼티에 저장을 합니다.
     */
    public function header()
    {

        $basePATH = ROOT.conf("ENV.path.theme");
        $filename = $basePATH."/".$this->_theme."/".$this->_env['header'];

        if (file_exists($filename)) {
            $this->_header = file_get_contents($filename);
        } else {
            $this->_header = "<!--해더파일이 없습니다.-->";
        }
        
        return $this->_header;
    }

    // 해더 내용을 랜더링 합니다.
    /*
    public function headerRender($viewData=[])
    {
        $prefixdCode = $this->setPrefix(self::PREFIX_START, self::PREFIX_END)->preFixs($this->_header);
        foreach ($prefixdCode as $value) {

            switch ($value[0]) {
                case '#':
                    // 환경변수의 값을 출력합니다.
                    $data = $this->conf->data( substr($value, 1) );
                    $this->_header = str_replace(
                        self::PREFIX_START." ".$value." ".self::PREFIX_END, 
                        $data, 
                        $this->_header);
                    break;
                case '&':
                    $cmd = explode("::",substr($value, 1));
                    //echo "classname = ".$cmd[0]."<br>";
                    // echo "method = ".$cmd[1]."<br>";
                    
                    $classname = $cmd[0];
                    $method = $cmd[1]; 
                    $this->_header = str_replace(
                        self::PREFIX_START." ".$value." ".self::PREFIX_END, 
                        $classname::$method(), 
                        $this->_header);
                    break;    
            }

        }

        return $this->_header;
    }
    */

    /**
     * 저장된 해더body를 읽어옵니다.
     */
    public function getHeader()
    {
        return $this->_header;
    }

    
}