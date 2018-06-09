<?php

namespace Jiny\Theme;

trait Layout
{
    public function layout()
    {
        $basePATH = $this->conf->data("ENV.theme");
        $filename = $basePATH."/".$this->_theme."/".$this->_env['layout'];

        if (file_exists($filename)) {
            return file_get_contents($filename);
        } else {
             return "레이아웃 파일이 없습니다.";
        }    
        
    }


}