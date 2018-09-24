<?php

namespace Jiny\Theme;

trait Footer
{
    public $_footer;

    /**
     * 푸터파일을 읽어 옵니다.
     * 푸터 프로퍼티에 저장을 합니다.
     */
    public function footer()
    {
        $basePATH = ROOT.$this->path();
        $filename = $basePATH.DS.$this->_theme.DS.$this->_env['footer'];

        if (file_exists($filename)) {
            $this->_footer = file_get_contents($filename);
        } else {
            $this->_footer = "<!--푸터 파일이 없습니다.-->";
        }

        return $this->_footer;
    }

    /**
     * 저장된 푸터를 읽어옵니다.
     */
    public function getFooter()
    {
        return $this->_footer;
    }

    
}