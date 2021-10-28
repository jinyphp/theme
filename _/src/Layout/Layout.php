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

use \Jiny\Core\Registry\Registry;
use Jiny\Filesystem\File;

class Layout extends \Jiny\Theme\Process
{
    public $Theme;

    use Header, Footer;

    /**
     * 
     */
    public function __construct($theme)
    {
        $this->Theme = $theme;
        
    }

    /**
     * 레이아웃을 결합합니다.
     * progress
     */
    protected function algorithm($theme)
    {
        $header = $this->header();
        $footer = $this->footer();

        $filename = $this->layoutFile();  
        if (file_exists($filename)) {
            $layout = file_get_contents($filename);

            // 환경설정에 따라 해더를 치환합니다.
            $layout = str_replace( $this->Theme->_env['_header'], $header, $layout);

            // 환경설정에 따라 푸더를 치환합니다.            
            $layout = str_replace( $this->Theme->_env['_footer'], $footer, $layout);

            return $layout;           
        } else {
            echo "테마 레이아웃을 읽어 올수 없습니다.";
            exit;
        }
    }

    private function layoutFile()
    {
        // 레이아웃 파일을 읽어옵니다.
        $basePATH = $this->Theme->path();
        return File::pathImplode([
            ROOT.$basePATH,
            $this->Theme->theme,
            $this->Theme->_env['layout']
        ]);
    }

    /**
     * 
     */
}