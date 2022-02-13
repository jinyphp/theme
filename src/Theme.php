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
        }

        return self::$Instance;
    }

    // 테마명
    const THEME = "theme"; //리소스 폴더명
    public $theme;
    //public $vendor, $name;

    public function setTheme($theme)
    {
        $this->theme = str_replace('/','.',$theme);
        return $this;
    }

    public function getTheme()
    {
        return $this->theme;
    }

    public function isTheme()
    {
        if ($this->theme) {
            return $this->theme;
        }
        return false;
    }

    /**
     * 테마의 App 파일이 존재하는지 검사
     */
    public function isThemeApp()
    {
        if ($this->theme) {
            return self::THEME.".".$this->theme.'.app';
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
        return self::THEME;
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
