<?php
namespace Jiny\Theme\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class ThemeLayout extends Component
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
        //dd("this is layout");
        if ($this->theme_name) {
            $path = theme()->path();
            $layout = $path.'.'.$this->theme_name.".layout";
            
            if (View::exists($layout)) {
                //dd("레이아웃 있음".$layout);
                // 테마 리소스가 있는 경우
                return view($layout);
            }
        }

        $layout = 'jinytheme::components.theme.layout';
        //dd($layout);
        return view($layout);
    }
}
