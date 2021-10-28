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
        
        if ($view = theme()->isThemeApp()) {
            //dd($view);
            if (View::exists($view)) {
                // 테마 리소스가 있는 경우
                //dd("view 존재");
                return view($view);
            }
        }
        //dd("파일 없음".$view);
        $view = 'jinytheme::components.theme.theme';
        return view($view);
    }
}
