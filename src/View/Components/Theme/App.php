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
            theme()->setTheme($theme);          
        }
    }

    public function render()
    {
        //dd("this app");
        if ($app = theme()->isThemeApp()) {
            if (View::exists($app)) {
                //dd("app 있음".$app);
                // 테마 리소스가 있는 경우
                return view($app);
            }
        }

        

        $app = 'jinytheme::components.theme.app';
        //dd($app);
        return view($app);
    }

}
