<?php

namespace Jiny\Theme\View\Components\Theme;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Theme extends Component
{
    public $theme_name;

    public function __construct($theme=null)
    {
        // 속성값으로 전달받은 테마명을 설정합니다.
        if($theme) {
            xTheme()->setTheme($theme);
            $this->theme_name = $theme;
        }
    }

    public function render()
    {
        $Theme = xTheme(); // 테마 싱글턴 인스턴스
        if($Theme->isTheme()) {

            // App.blade.php 파일존재 확인
            if ($view = $Theme->isThemeApp()) {
                if (View::exists($view)) {
                    return view($view); // 테마 리소스가 있는 경우
                }
            }

            //dd($view);
            return $Theme->getName()." 테마 폴더안에 app.blade.php 파일이 없습니다.";
        }


        return view("jinytheme::error.message.alert",[
            'message'=>$Theme->getName()." 테마가 설치되어 있지 않습니다. 콘솔 또는 Admin에서 테마를 설치해 주세요."
        ]);
        //return $Theme->getName()." 테마가 설치되어 있지 않습니다. 콘솔 또는 Admin에서 테마를 설치해 주세요.";


        // else 처리
        /*
        $view = 'jinytheme::components.theme.theme';
        return view($view);
        */
    }
}
