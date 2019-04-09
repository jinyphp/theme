<?php
/*
 * This file is part of the jinyPHP package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (! function_exists('theme')) {

    function theme()
    {
        // 테마처리
        $theme = new \Jiny\Theme\Theme();
        if ($theme->isTheme()) {
            return $theme->render();        
        }
    }
    
}