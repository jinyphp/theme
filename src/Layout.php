<?php

namespace Jiny\Theme;

trait Layout
{
    public function layout()
    {
        $basePATH = $this->conf->data("ENV.path.theme");
        $filename = ROOT.$basePATH.DS.$this->_theme.DS.$this->_env['layout'];
        // echo $filename."<br>";
        if (file_exists($filename)) {
            return file_get_contents($filename);
        } else {
             return "레이아웃 파일이 없습니다.";
        }    
        
    }


}