<?php

namespace Jiny\Theme\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class ThemeMain extends Component
{
    public $theme_name;

    public function __construct($theme=null)
    {
        if($theme) {
            xTheme()->setTheme($theme);
            $this->theme_name = $theme;
        } else {
            $this->theme_name = xTheme()->getName();
        }
    }

    public function render()
    {
        if($this->theme_name) {
            $viewFile = $this->theme_name.'.main';
            if (View::exists($viewFile)) { // 테마 리소스가 있는 경우
                return view($viewFile);
            }
        }

        return $this->theme_name." 테마 폴더안에 main.blade.php 파일이 없습니다.";

        // 컴포넌트 리소스로 대체하여 출력함
        //return view('jinytheme::components.layout.main');
    }
}
