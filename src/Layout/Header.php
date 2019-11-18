<?php
/*
 * This file is part of the jinyPHP package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Jiny\Theme\Layout;

use Jiny\Filesystem\File;

trait Header
{
    public $header;

    /**
     * 해더파일을 읽어 옵니다.
     * 해더 프로퍼티에 저장을 합니다.
     */
    public function header()
    {
        $filename = $this->headerFile();
        $this->header = $this->loadHeader($filename);
        return $this->header;
    }

    /**
     * 저장된 해더body를 읽어옵니다.
     */
    public function getHeader()
    {
        return $this->header;
    }

    private function headerFile()
    {
        $file = $this->Theme->path();
        return implode([
            $file, 
            // str_replace("/",DIRECTORY_SEPARATOR,$this->Theme->themeName), 
            // DIRECTORY_SEPARATOR, 
            $this->Theme->Info->getHeader()
        ]);
    }    

    private function loadHeader($filename)
    {
        if (file_exists($filename)) {
            $body = file_get_contents($filename);
            return $body;
        } else {
            return "<!--해더파일이 없습니다.-->";
        }
    }

    /**
     * 
     */
}