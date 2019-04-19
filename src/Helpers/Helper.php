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
    function theme($body, $theme_name=null) {
        if (func_num_args()) {
            $theme = Theme::instance();

            // 선택 테마를 설정합니다.
            if ($theme_name) {
                $theme->setTheme($theme_name);
            }

            if ($theme->isTheme($body)) {
                // 테마를 결합합니다.
                return $theme->render($body);        
            } else {
                // 테마가 존재하지 않는 경우
                // 본문을 반환합니다.
                return $body->getContent();
            }
        } else {
            // 인자값이 없는 경우, 인스턴스를 반환합니다.
            return $theme;
        }
    } 
}

/**
 * 테마를 선택합니다.
 */
if (! function_exists('setTheme')) {
    function setTheme($name) {
        $theme = Theme::instance();
        return $theme->setTheme($theme);
    }
}

/**
 * 레이아웃 틀을 읽어 옵니다.
 */
if (! function_exists('layout')) {
    function layout() {
        $theme = Theme::instance();
        return (new Layout($theme))->progress();
    }
}