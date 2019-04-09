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

use \Jiny\Core\Registry\Registry;

class ThemeLayout extends \Jiny\Theme\Process
{
    public $Theme;

    /**
     * 
     */
    public function __construct($theme)
    {
        $this->Theme = $theme;
        
    }


    /**
     * 레이아웃을 결합합니다.
     */
    protected function algorithm($theme, $html)
    {
        $header = $theme->header();
        $footer = $theme->footer();

        // 레이아웃 파일을 읽어옵니다.
        $basePATH = $theme->path();
        $filename = ROOT.$basePATH.DS.$theme->_theme.DS.$theme->_env['layout'];
  
        if (file_exists($filename)) {
            $layout = file_get_contents($filename);

            // 환경설정에 따라 해더를 치환합니다.
            $layout = str_replace( $theme->_env['_header'], $header, $layout);

            // 환경설정에 따라 푸더를 치환합니다.            
            $layout = str_replace( $theme->_env['_footer'], $footer, $layout);

            if ($html) {
                // 본문을 치환합니다.            
                $layout = str_replace( $theme->_env['_content'], $html->_body, $layout);
                $html->setBody($layout);
            } else {
                // theme() 헬퍼함수용
                return $layout;
            }
            

        } else {
            echo "테마 레이아웃을 읽어 올수 없습니다.";
            exit;
        }

    }

    /**
     * 
     */
}