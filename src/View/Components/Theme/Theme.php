<?php

namespace Jiny\Theme\View\Components\Theme;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Theme extends Component
{
    public $theme_name;

    public function __construct($theme=null)
    {
        if($theme) {
            theme()->setTheme($theme);
            $this->theme_name = $theme;
        }
    }

    public function render()
    {
        $Theme = theme(); // 테마 싱글턴 인스턴스
        if($Theme->isTheme()) {

            // App.blade.php 파일존재 확인
            if ($view = $Theme->isThemeApp()) {
                if (View::exists($view)) {
                    return view($view); // 테마 리소스가 있는 경우
                }
            }
        }

        // else 처리
        $view = 'jinytheme::components.theme.theme';
        return view($view);
    }
}
