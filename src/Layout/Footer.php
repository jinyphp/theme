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

trait Footer
{
    public $footer;

    /**
     * 푸터파일을 읽어 옵니다.
     * 푸터 프로퍼티에 저장을 합니다.
     */
    public function footer()
    {
        $filename = $this->footerFile();
        $this->footer = $this->loadFooter($filename);
        return $this->footer;
    }

    /**
     * 저장된 푸터를 읽어옵니다.
     */
    public function getFooter()
    {
        return $this->footer;
    }

    private function footerFile()
    {
        $file = $this->Theme->path();
        return implode([
            $file, 
            // str_replace("/",DIRECTORY_SEPARATOR,$this->Theme->themeName), 
            // DIRECTORY_SEPARATOR, 
            $this->Theme->Info->getFooter()
        ]);
    }

    

    private function loadFooter($filename)
    {
        if (file_exists($filename)) {
            $body = file_get_contents($filename);
            return $body;
        } else {
            return "<!--푸터 파일이 없습니다.-->";
        }
    }

    /**
     * 
     */
}