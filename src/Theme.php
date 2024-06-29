<?php
namespace Jiny\Theme;

class Theme
{
    /**
     * 싱글턴 인스턴스를 생성합니다.
     */
    private static $Instance;
    public static function instance()
    {
        if (!isset(self::$Instance)) {
            // 자기 자신의 인스턴스를 생성합니다.
            self::$Instance = new self();

            //설정파일 로드
            self::$Instance->setting = config("jiny.theme.setting");
        }

        return self::$Instance;
    }

    // 테마명
    const THEME = "theme"; //리소스 폴더명
    public $theme;
    public $setting;
    //public $vendor, $name;

    public function setTheme($theme)
    {
        $this->theme = str_replace('/','.',$theme);

        $path = base_path('theme');
        file_put_contents($path.DIRECTORY_SEPARATOR."default.txt",$theme);

        return $this;
    }

    public function getTheme()
    {
        $path = base_path('theme');
        $theme = file_get_contents($path.DIRECTORY_SEPARATOR."default.txt");
        return $theme;

        //return $this->theme;
    }

    public function getName()
    {
        $path = base_path('theme');
        $theme = file_get_contents($path.DIRECTORY_SEPARATOR."default.txt");
        return $theme;

        //return $this->theme;
    }

    public function isTheme()
    {
        if ($this->theme) {
            // 테마 설정값이 있는지 확인
            if(isset($this->setting['path'])) {

                // 경로 추출
                $path = base_path().DIRECTORY_SEPARATOR.$this->setting['path'];
                if(!is_dir($path)) {
                    mkdir($path);
                }

                // 폴더 검사
                $themePath = $path.DIRECTORY_SEPARATOR.str_replace('.', DIRECTORY_SEPARATOR, $this->theme);
                if(is_dir($themePath)) {
                    return $this->theme;
                }
            }

        }

        // 테마 폴더가 존재하지 않음
        return false;
    }



    /**
     * 테마의 App 파일이 존재하는지 검사
     */
    public function isThemeApp()
    {
        if ($this->theme) {
            return $this->theme.'.app';
            //return self::THEME.".".$this->theme.'.app';
        }
        return false;
    }

    public function init()
    {
        $path = resource_path("views/".self::THEME);
        if(!is_dir($path)) {
            mkdir($path);
        }
        return $this;
    }

    public function path()
    {
        $this->setting['path'];
        //return self::THEME;
    }


    public function view($resource, $data=[])
    {
        $name = str_replace("/",".",$this->theme);
        return view("theme.".$name.".".$resource, $data);
    }

    public function getThemeList()
    {
        $path = resource_path("views/".self::THEME);
        $filename = $path.DIRECTORY_SEPARATOR."theme.json";
        if(file_exists($filename)) {
            $text = file_get_contents($filename);
            return json_decode($text,true);
        }

        return [];
    }
}
