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

class Nav
{
    private $Theme;
    private $filename = "nav.html";
    public function __construct($theme=null)
    {
        $this->Theme = $theme;
    }

    // 기본 레이아웃 파일 읽기
    public function load($file=null)
    {
        if ($file) {
            return \file_get_contents($this->Theme->_path."/".$this->file);
            
        } else {
            return \file_get_contents($this->Theme->_path."/".$this->filename);
        }
    }


}