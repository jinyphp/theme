<?php
/*
 * This file is part of the jinyPHP package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jiny;

use \Jiny\Theme\Theme;
use \Jiny\Theme\Layout\Layout;
use \Jiny\Theme\Layout\Show;

if (! function_exists('theme')) {
    function theme($body) {
        if (func_num_args()) {
            $theme = Theme::instance();
            if ($theme->isTheme($body)) {
                return $theme->render($body);        
            }
        } else {
            return $theme;
        }
    } 
}

if (! function_exists('layout')) {
    function layout() {
        $theme = Theme::instance();
        return (new Layout($theme))->progress();
    }
}