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

class Infomation 
{
    const FILENAME = "theme.ini";
    private $themeName;
    private $env;

    private $Theme;
    public function __construct($theme)
    {
        $this->Theme = $theme;
        $this->themeName = $this->Theme->themeName;
    }

    

    private function filename()
    {
        $filename = ".."; // root 위치
        $filename .= str_replace("/", DIRECTORY_SEPARATOR, rtrim(\Jiny\conf("ENV.path.theme"),"/")); // 테마 환경경로

        $filename .= DIRECTORY_SEPARATOR;
        $filename .= str_replace("/", DIRECTORY_SEPARATOR, rtrim($this->themeName,"/"));
      
        $filename .= DIRECTORY_SEPARATOR;
        $filename .= self::FILENAME;

        return $filename;
    }

    /**
     * 테마 환경 설정값
     */
    public function load()
    {
        $filename = $this->filename(); // 파일명 경로 처리
        if (file_exists($filename)) {
            $this->env = \Jiny\ini($filename);
            return $this->env;
        } else {
            echo "테마 정보파일 ".$filename."을 찾을 수 없습니다.<br>";
            echo __FILE__.", line=".__LINE__;
            exit;
        }
    }

    public function getEnv()
    {
        return $this->env;
    }

    public function getLayout()
    {
        // echo $this->env['layout']."<br>";
        return $this->env['layout'];
    }

    public function getContent()
    {
        return $this->env['_content'];
    }

    public function getHeader()
    {
        return $this->env['header'];
    }

    public function getFooter()
    {
        return $this->env['footer'];
    }
}