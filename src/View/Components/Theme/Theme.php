<?php
namespace Jiny\Theme\View\Components\Theme;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

/**
 * x-theme 컴포넌트를 처리합니다.
 */
class Theme extends Component
{
    public $theme_name;

    public function __construct($theme=null, $name=null)
    {

        // 속성값으로 전달받은 테마명을 설정합니다.
        if($theme) {
            $this->theme_name = $theme;

            //$path = base_path('theme');
            //file_put_contents($path.DIRECTORY_SEPARATOR."default.txt",$theme);

            // 세션에 테마명 저장
            //session()->put('theme', $name);
        }

        if($name) {
            $this->theme_name = $name;

            // 세션에 테마명 저장
            //session()->put('theme', $name);
        }

        // 공유객체에 저장합니다.
        if($this->theme_name) {
            xTheme()->setTheme($this->theme_name);
        }
    }

    /**
     * 화면 렌더링
     */
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

        //dd($this->theme_name);
        if ($this->theme_name) {

            $theme = str_replace("/",".",$this->theme_name);
            $viewFile = $theme.".app";

            // 테마 리소스가 있는 경우
            if (View::exists("theme::".$viewFile)) {
                return view("theme::".$viewFile);
            }

            return view("jinytheme::errors.alert",[
                'message'=>$viewFile." 테마에 app.blade.php 파일을 찾을 수 없습니다."
            ]);
        }

        return view("jinytheme::errors.alert",[
            'message'=>"테마명이 선택되어 있지 않습니다."
        ]);
    }
}
