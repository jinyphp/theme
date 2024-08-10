<?php
/**
 * 테마, 사이드바 디자인 설정 컴포넌트
 * 메뉴코드 생성 함수포함
 */
namespace Jiny\Theme\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class ThemeTopMenu extends Component
{
    public $data;

    public function __construct($data=null)
    {
        $this->data = $data;
    }

    public function render()
    {
        $theme = xTheme()->getTheme();
        if($theme) {

            if($viewFile = $this->inLayout($theme,"topmenu")) {
                return view("theme::".$viewFile,[
                ]);
            }

            if($viewFile = $this->inRoot($theme,"topmenu")) {
                return view("theme::".$viewFile,[

                ]);
            }

            return view("jinytheme::errors.alert",[
                'message'=>$theme." 테마에 layout.blade.php 파일을 찾을 수 없습니다."
            ]);

        }

        return view("jinytheme::errors.alert",[
            'message'=>"테마이름이 지정되어 있지 않습니다."
        ]);
    }

    // _layouts 안에 .blade.php 검사
    private function inLayout($theme, $name)
    {
        $viewFile = $theme."._layouts.".$name;
        if (View::exists("theme::".$viewFile)) {
            return $viewFile;
        }

        return false;
    }

    private function inRoot($theme, $name)
    {
        $viewFile = $theme.".".$name;
        if (View::exists("theme::".$viewFile)) {
            return $viewFile;
        }

        return false;
    }

}
