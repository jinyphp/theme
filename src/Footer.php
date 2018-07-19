<?php

namespace Jiny\Theme;

trait Footer
{
    // 공통적으로 처리되는 하단 내용을 읽어옵니다.
    // 읽어올 설정파일은 config에 설정되어 있습니다.
    public function footer()
    {
        // echo __METHOD__."를 호출합니다.<br>";
        // 하단 HTML의 파일의 경로를 확인합니다.
        // 지정한 경로에 하단푸터 파일이 있는지 확인후에 값을 읽어옵니다.
        $basePATH = ROOT.$this->conf->data("ENV.path.theme");
        $filename = $basePATH.DS.$this->_theme.DS.$this->_env['footer'];

        if (file_exists($filename)) {
            $this->_footer = file_get_contents($filename);
        } else {
            $this->_footer = "푸터 파일이 없습니다.";
        }

        return $this->_footer;
    }

    // 푸터 내용을 랜더링 합니다.
    /*
    public function footerRender($data=[])
    {
        $prefixdCode = $this->setPrefix(self::PREFIX_START, self::PREFIX_END)->preFixs($this->_footer);
        foreach ($prefixdCode as $value) {

            switch ($value[0]) {
                case '#':
                    // 환경변수의 값을 출력합니다.
                    $data = $this->conf->data( substr($value, 1) );
                    $this->_footer = str_replace(
                        self::PREFIX_START." ".$value." ".self::PREFIX_END, 
                        $data, 
                        $this->_footer);
                    break;
            }

        }

        return $this->_footer;
    }
    */
    
}