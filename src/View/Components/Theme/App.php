<?php
namespace Jiny\Theme\View\Components\Theme;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

/**
 * x-app 컴포넌트를 처리합니다.
 */
class App extends Component
{
    public $theme;
    public $name;
    public $data;
    private $layout_path = "_layouts";

    public function __construct($name=null)
    {
        if($name) {
            $this->theme = str_replace("/",".",$name);
        }

        //dd($name);

        // 공유객체에 저장합니다.
        if($this->theme) {
            xTheme()->setTheme($this->theme);
        }

    }

    public function render()
    {
        // 테마에서 읽기
        if($result = $this->themeView($this->name)) {
            return $result;
        }

        $msg = $this->name."의 content 디자인 리소스를 읽어 올 수 없습니다.";
        return $this->errorView($msg);

    }

    private function themeView($name)
    {

        $theme = xTheme()->getName();
        $theme = trim($theme,'"');
        if ($theme) {
            $viewFile = $theme.".".$this->layout_path.".app";
            //dd($viewFile);
            if (View::exists("theme::".$viewFile)) {
                return view("theme::".$viewFile);
            }

            // 테마 리소스가 없는 경우
            $msg = $theme." 테마에 _layouts.app.blade.php 파일을 찾을 수 없습니다.";
            return $this->errorView($msg);
        }

        return false;
    }

    private function errorView($message)
    {
        return view("jinytheme::errors.alert",[
            'message'=>$message
        ]);
    }

    // public $theme_name;

    // public function __construct($theme=null, $name=null)
    // {

    //     // 속성값으로 전달받은 테마명을 설정합니다.
    //     if($theme) {
    //         $this->theme_name = $theme;
    //     }

    //     if($name) {
    //         $this->theme_name = $name;
    //     }

    //     // 공유객체에 저장합니다.
    //     if($this->theme_name) {
    //         xTheme()->setTheme($this->theme_name);
    //     }
    // }

    // /**
    //  * 화면 렌더링
    //  */
    // public function render()
    // {
    //     if ($this->theme_name) {

    //         $theme = str_replace("/",".",$this->theme_name);

    //         if($viewFile = $this->inLayoutApp($theme)) {
    //             return view("theme::".$viewFile,[
    //                 //'theme_name' => $theme
    //             ]);
    //         }

    //         if($viewFile = $this->inRootApp($theme)) {
    //             return view("theme::".$viewFile,[
    //                 //'theme_name' => $theme
    //             ]);
    //         }

    //         return view("jinytheme::errors.alert",[
    //             'message'=>$viewFile." 테마에 app.blade.php 파일을 찾을 수 없습니다."
    //         ]);
    //     }

    //     return view("jinytheme::errors.alert",[
    //         'message'=>"테마명이 선택되어 있지 않습니다."
    //     ]);
    // }

    // // _layouts 안에 app.blade.php 검사
    // private function inLayoutApp($theme)
    // {
    //     $viewFile = $theme."._layouts.app";
    //     if (View::exists("theme::".$viewFile)) {
    //         return $viewFile;
    //     }

    //     return false;
    // }

    // private function inRootApp($theme)
    // {
    //     $viewFile = $theme.".app";
    //     if (View::exists("theme::".$viewFile)) {
    //         return $viewFile;
    //     }

    //     return false;
    // }

}
