<?php
/*
 * This file is part of the jinyPHP package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Jiny\Theme;

abstract class Process
{
    protected $conf;
    protected $_theme;
    public $_env=[];

    public $_header;
    public $_footer;
    public $_layout;

    public $_name;

    /**
     * >>템플릿 메소드 패턴
     * 테마를 랜더링 합니다.
     */
    final public function render($html)
    {
        $this->assamble($html);      
        return $this;
    }



    
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