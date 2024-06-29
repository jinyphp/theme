<?php
namespace Jiny\Theme\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class ThemeComponent extends Component
{
    public $theme_name;

    public function __construct($theme=null)
    {
        if($theme) {
            xTheme()->setTheme($theme);
            $this->theme_name = $theme;
        } else {
            $this->theme_name = xTheme()->getName();
        }


    }

    public function render()
    {
        //$path = base_path('theme');
        //$theme = file_get_contents($path.DIRECTORY_SEPARATOR."default.txt");

        if ($this->theme_name) {
            $componentName = str_replace("theme-","",$this->componentName);
            $viewFile = $this->theme_name.".".$componentName;
            //dd($viewFile );
            if (View::exists($viewFile)) { // 테마 리소스가 있는 경우
                return view($viewFile);
            }
        }

        return $this->theme_name." 테마 폴더안에 ".$componentName.".blade.php 파일이 없습니다.";

        //$layout = 'jinytheme::components.theme.layout';
        //dd($layout);
        //return view($layout);
    }
}
