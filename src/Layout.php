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

/**
 * 레이아웃 파일을 읽어 옵니다.
 */
class Layout
{
    use PreFix;

    private $Theme;
    private $filename = "index.html";
    public $body;

    public function __construct($theme=null)
    {
        $this->Theme = $theme;
    }

    public function setFile($name)
    {
        $this->filename = $name;
        return $this;
    }

    /**
     * 파일을 읽어 레이아웃을 출력합니다.
     */
    public function load($args=[])
    {
        $subpath = DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR;
        $file = $this->Theme->_path. $subpath. $this->filename;
        
        $this->body = \jiny\html_get_contents($file, $args);
        return $this;
    }

    public function build($args=[])
    {
       
        $codes = $this->setPrefix("{{", "}}")->preFixs($this->body);
        foreach ($codes as $code) {
            $this->body = str_replace("{{".$code."}}", $args[$code], $this->body);
        }
        
        return $this;
    }

    public function get()
    {
        return $this->body;
    }

    // 비어있는 html 생성
    public function empty($lang="ko")
    {
        $file = "../vendor/jiny/theme/resource/empty.html";
        return str_replace("__LANG__",$lang, \file_get_contents($file));
    }
}