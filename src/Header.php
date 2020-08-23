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

class Header 
{
    private $Theme;
    private $filename = "header.html";
    private $body;
    public function __construct($theme=null)
    {
        $this->Theme = $theme;
    }

    public function setFile($name)
    {
        $this->filename = $name;
        //echo "파일설정=".$name;
        return $this;
    }

    // 기본 레이아웃 파일 읽기
    public function load($args=[])
    {
        $file = $this->Theme->_path."/src//".$this->filename;
        $this->body = \jiny\html_get_contents($file, $args);
        return $this->body;
    }


}