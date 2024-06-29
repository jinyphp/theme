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
        //$theme_name = xTheme()->getName();
        //$theme_name = trim($theme_name,'"');
        $path = base_path('theme');
        $theme = file_get_contents($path.DIRECTORY_SEPARATOR."default.txt");

        if($theme) {
            $viewFile = $theme.".topmenu";

            // 테마 리소스가 있는 경우
            if (View::exists("theme::".$viewFile)) {
                return view("theme::".$viewFile);
            }

            return view("jinytheme::errors.alert",[
                'message'=>$theme." 테마에 topmenu.blade.php 파일을 찾을 수 없습니다."
            ]);
        }

        return view("jinytheme::errors.alert",[
            'message'=>"테마이름이 지정되어 있지 않습니다."
        ]);
    }

}
