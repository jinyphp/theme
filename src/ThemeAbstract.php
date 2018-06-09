<?php
namespace Jiny\Theme;

abstract class ThemeAbstract
{
    protected $conf;
    protected $_theme;
    protected $_env=[];

    protected $_header;
    protected $_footer;

    /**
     * 동작 테마설정
     */ 
    public function getTheme()
    {
        return $this->_theme;
    }

    public function setTheme($theme)
    {
        // echo $theme."를 선택하셨습니다.<br>";
        $this->_theme = $theme;
        return $this;
    }

    public function getENV()
    {
        return $this->_env;
    }
}