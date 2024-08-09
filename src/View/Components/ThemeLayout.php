<?php
namespace Jiny\Theme\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class ThemeLayout extends Component
{
    public $data;

    public function __construct($data=null)
    {
        $this->data = $data;
    }

    public function render()
    {

        //$path = base_path('theme');
        //$theme = file_get_contents($path.DIRECTORY_SEPARATOR."default.txt");
        $theme = xTheme()->getTheme();
        if($theme) {

            if($viewFile = $this->inLayout($theme)) {
                return view("theme::".$viewFile,[
                    //'theme_name' => $theme
                ]);
            }

            if($viewFile = $this->inRoot($theme)) {
                return view("theme::".$viewFile,[
                    //'theme_name' => $theme
                ]);
            }


            // $viewFile = $theme.".layout";

            // // 테마 리소스가 있는 경우
            // if (View::exists("theme::".$viewFile)) {
            //     return view("theme::".$viewFile);
            // }

            return view("jinytheme::errors.alert",[
                'message'=>$theme." 테마에 layout.blade.php 파일을 찾을 수 없습니다."
            ]);

        }

        return view("jinytheme::errors.alert",[
            'message'=>"테마이름이 지정되어 있지 않습니다."
        ]);
    }

    // _layouts 안에 app.blade.php 검사
    private function inLayout($theme)
    {
        $viewFile = $theme."._layouts.layout";
        if (View::exists("theme::".$viewFile)) {
            return $viewFile;
        }

        return false;
    }

    private function inRoot($theme)
    {
        $viewFile = $theme.".layout";
        if (View::exists("theme::".$viewFile)) {
            return $viewFile;
        }

        return false;
    }
}
