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

trait Header
{
    public $_header;

    /**
     * 해더파일을 읽어 옵니다.
     * 해더 프로퍼티에 저장을 합니다.
     */
    public function header()
    {

        $basePATH = ROOT.$this->path();
        $filename = $basePATH."/".$this->_theme."/".$this->_env['header'];

        if (file_exists($filename)) {
            $this->_header = file_get_contents($filename);
        } else {
            $this->_header = "<!--해더파일이 없습니다.-->";
        }
        
        return $this->_header;
    }

    /**
     * 저장된 해더body를 읽어옵니다.
     */
    public function getHeader()
    {
        return $this->_header;
    }

    /**
     * 
     */
}