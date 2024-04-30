<?php

namespace Jiny\Theme\View\Components\Theme;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class App extends Component
{
    public $theme_name;

    public function __construct($theme=null)
    {

        if($theme) {
            xTheme()->setTheme($theme);
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

            return view("jinytheme::error.alert",[
                'message'=>$Theme->getName()." 테마에 app.blade.php 파일을 찾을 수 없습니다."
            ]);

        }

        return view("jinytheme::error.alert",[
            'message'=>$Theme->getName()." 테마가 설치되어 있지 않습니다. 콘솔 또는 Admin에서 테마를 설치해 주세요."
        ]);


    }

}
