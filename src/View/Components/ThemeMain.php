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
            theme()->setTheme($theme); 
            $this->theme_name = $theme;
        } else {
            $this->theme_name = theme()->getTheme();
        }
    }

    public function render()
    {
        if($this->theme_name) {
            $path = theme()->path();
            if (View::exists($path.".".$this->theme_name.'.main')) {
                // 테마 리소스가 있는 경우
                return view($path.".".$this->theme_name.'.main');
            }
        }
        
        // 컴포넌트 리소스로 대체하여 출력함
        return view('jinytheme::components.layout.main');
    }
}
