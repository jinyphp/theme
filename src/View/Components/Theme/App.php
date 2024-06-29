<?php
namespace Jiny\Theme\View\Components\Theme;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

/**
 * x-app 컴포넌트를 처리합니다.
 */
class App extends Component
{
    public $theme_name;

    public function __construct($theme=null)
    {

        if($theme) {
            $this->theme_name = $theme;

            //$path = base_path('theme');
            //file_put_contents($path.DIRECTORY_SEPARATOR."default.txt",$theme);

            xTheme()->setTheme($theme);

            // 세션에 테마명 저장
            //session()->put('theme', $name);
        }
    }

    public function render()
    {
        /*
        $theme_name = xTheme()->getName();
        $theme_name = trim($theme_name,'"');

        // 세션에 저장되어 있는 테마명을 확인
        if(!$theme_name) {
            $theme_name = session()->get('theme');
        }
        */


        if ($this->theme_name) {

            $theme = str_replace("/",".",$this->theme_name);
            $viewFile = $theme.".app";

            // 테마 리소스가 있는 경우
            if (View::exists("theme::".$viewFile)) {
                return view("theme::".$viewFile);
            }

            return view("jinytheme::error.alert",[
                'message'=>$Theme->getName()." 테마에 app.blade.php 파일을 찾을 수 없습니다."
            ]);
        }

        return view("jinytheme::error.alert",[
            'message'=>$Theme->getName()." 테마가 설치되어 있지 않습니다. 콘솔 또는 Admin에서 테마를 설치해 주세요."
        ]);
    }

}
