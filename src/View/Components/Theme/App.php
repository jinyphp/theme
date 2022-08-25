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
        if($Theme->isTheme()) {
            if ($app = xTheme()->isThemeApp()) {
                if (View::exists($app)) {
                    // 테마 리소스가 있는 경우
                    return view($app);
                }
            }
        }

        return view("jinytheme::error.message.alert",[
            'message'=>$Theme->getName()." 테마가 설치되어 있지 않습니다. 콘솔 또는 Admin에서 테마를 설치해 주세요."
        ]);

        //$app = 'jinytheme::components.theme.app';
        //return view($app);
    }

}
