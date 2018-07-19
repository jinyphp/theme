<?php

namespace Jiny\Theme;

trait Footer
{
    /**
     * 푸터파일을 읽어 옵니다.
     * 푸터 프로퍼티에 저장을 합니다.
     */
    public function footer()
    {
        $basePATH = ROOT.conf("ENV.path.theme");
        $filename = $basePATH.DS.$this->_theme.DS.$this->_env['footer'];

        if (file_exists($filename)) {
            $this->_footer = file_get_contents($filename);
        } else {
            $this->_footer = "<!--푸터 파일이 없습니다.-->";
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