<?php

namespace Jiny\Theme;

trait Header
{
    // 공통적으로 처리되는 상단 내용을 읽어옵니다.
    // 읽어올 설정파일은 config에 설정되어 있습니다.
    public function header()
    {
        // echo __METHOD__."를 호출합니다.<br>";
        // 해더 HTML의 파일의 경로를 확인합니다.
        // 지정한 경로에 상단해더 파일이 있는지 확인후에 값을 읽어옵니다.
        $basePATH = $this->conf->data("ENV.theme");
        $filename = $basePATH."/".$this->_theme."/".$this->_env['header'];

        if (file_exists($filename)) {
            $this->_header = file_get_contents($filename);
        } else {
            $this->_header = "해더파일이 없습니다.";
        }
        
        return $this;
    }

    // 해더 내용을 랜더링 합니다.
    public function headerRender($data=[])
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
            }

        }
    

        return $this->_header;
    }
}