<?php

namespace Jiny\Theme\View\Components\Theme;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Theme extends Component
{
    public $theme_name;

    public function __construct($theme=null, $name=null)
    {
        // 속성값으로 전달받은 테마명을 설정합니다.
        if($theme) {
            $this->theme_name = $theme;
        }

        if($name) {
            $this->theme_name = $name;
        }

        if($this->theme_name) {
            xTheme()->setTheme($this->theme_name);
        }

    }

    public function render()
    {
        $theme_name = xTheme()->getName();
        $theme_name = trim($theme_name,'"');

        if ($theme_name) {

            $viewFile = $theme_name.".app";

            // 테마 리소스가 있는 경우
            if (View::exists("theme::".$viewFile)) {
                return view("theme::".$viewFile);
            }

            return view("jinytheme::errors.alert",[
                'message'=>$viewFile." 테마에 app.blade.php 파일을 찾을 수 없습니다."
            ]);
        }

        return view("jinytheme::errors.alert",[
            'message'=>"테마명이 선택되어 있지 않습니다."
        ]);
    }
}
