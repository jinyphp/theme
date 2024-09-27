<?php
namespace Jiny\Theme\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class ThemeView extends Component
{
    public $name;
    public $data;
    private $layout_path = "_layouts";

    public function __construct($name=null, $data=null)
    {
        if($name) {
            $this->name = $name;
        } else {
            // Action 설정값 읽기
            $val = Action()->get('layouts.content');
            //dump(Action());
            //dd($val);
            if($val) {
                $this->name = $val;
            } else {
                $this->name = "content"; // 기본값
            }
        }

        $this->data = $data;
    }

    public function render()
    {
        // 우선순위2. 테마에서 header 읽기
        if($result = $this->themeView($this->name)) {
            return $result;
        }

        $msg = $this->name."의 content 디자인 리소스를 읽어 올 수 없습니다.";
        return $this->errorView($msg);

    }

    private function themeView($name)
    {
        $theme_name = xTheme()->getName();
        $theme_name = trim($theme_name,'"');
        if ($theme_name) {

            $viewFile = $theme_name.".".$this->layout_path.".".$name;
            if (View::exists("theme::".$viewFile)) {
                return view("theme::".$viewFile);
            }

            // 테마 리소스가 없는 경우
            $msg = $theme_name." 테마에 _layouts.".$name.".blade.php 파일을 찾을 수 없습니다.";
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


}
