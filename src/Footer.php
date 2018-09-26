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

trait Footer
{
    public $_footer;

    /**
     * 푸터파일을 읽어 옵니다.
     * 푸터 프로퍼티에 저장을 합니다.
     */
    public function footer()
    {
        $basePATH = ROOT.$this->path();
        $filename = $basePATH.DS.$this->_theme.DS.$this->_env['footer'];

        if (file_exists($filename)) {
            $this->_footer = file_get_contents($filename);
        } else {
            $this->_footer = "<!--푸터 파일이 없습니다.-->";
        }

        return $this->_footer;
    }

    /**
     * 저장된 푸터를 읽어옵니다.
     */
    public function getFooter()
    {
        return $this->_footer;
    }

    /**
     * 
     */
}