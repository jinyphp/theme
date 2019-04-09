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

class ThemeShow extends \Jiny\Theme\Process
{
    public $Theme;

    public function __construct($theme)
    {
        $this->Theme = $theme;
        
    }

    /**
     * 결합합니다.
     */
    protected function algorithm($theme, $html)
    {
        $header = $theme->header();
        $footer = $theme->footer();

        if ($html) {
            $layout = $header.$html->getBody().$footer;
            $html->setBody($layout);
        } else {
            // theme() 헬퍼함수용
            return $layout;
        }
        
    }

    /**
     * 
     */
}