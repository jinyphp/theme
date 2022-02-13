<?php
/**
 * 테마, 사이드바 디자인 설정 컴포넌트
 * 메뉴코드 생성 함수포함
 */
namespace Jiny\Theme\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class ThemeSidebar extends Component
{
    public $theme_name;

    public function __construct($theme=null)
    {
        if($theme) {
            xTheme()->setTheme($theme);
            $this->theme_name = $theme;
        } else {
            $this->theme_name = xTheme()->getTheme();
        }
    }

    public function render()
    {
        if($this->theme_name) {
            $path = xTheme()->path();
            if (View::exists($path.".".$this->theme_name.'.sidebar')) {
                // 테마 리소스가 있는 경우
                $res = view($path.".".$this->theme_name.'.sidebar');
                return $res;
            }
        }

        // 컴포넌트 리소스로 대체하여 출력함
        return view('jinytheme::components.layouts.sidebar');
    }

}
