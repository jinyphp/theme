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
        if ($app = xTheme()->isThemeApp()) {
            if (View::exists($app)) {
                // 테마 리소스가 있는 경우
                return view($app);
            }
        }

        $app = 'jinytheme::components.theme.app';
        return view($app);
    }

}
