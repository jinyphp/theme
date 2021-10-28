<?php
/*
 * This file is part of the jinyPHP package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace jiny;

// 테마 객체를 생성합니다.
if (! function_exists('theme')) {
    function theme($body=null, $name=null) {
        $obj = \Jiny\Theme\Theme::instance();
        
        // 매개변수에 따른 처리동작
        if (func_num_args()) {
            // 테마 선택
            if($name) $obj->setName($name)->setPath();

            // 레이아웃 로드
            if (is_string($body)) {
                //전달되는 값이 문자열일 경우 content 내용으로 치환
                $args['content'] = $body;
            } else             
            if (is_array($body)) {
                // 배열 인자인 경우 키값을 매칭하여 변환처리
                $args = $body;
            }
            
            $layout = $obj->layout()->load();
            $layout->build($args);
            return $layout->get();        
        } else 
        // 매개변수가 없는 경우, 객체 반환
        {
            return $obj;
        }        
    }
}

/**
 * 서브 네임스페이스
 */
namespace jiny\theme;
// 테마에서 css 파일을 읽어옵니다.
if (! function_exists('csslink')) {
    function csslink($name)
    {
        $obj = \Jiny\Theme\Theme::instance();
        $file = "../theme/".$this->_name."/css//".$name;
        return "<style>".\file_get_contents($file)."<style>";
    }
}












if (! function_exists('_header')) {
    function _header($file=null)
    {
        $obj = \Jiny\Theme\Theme::instance();
        return $obj->header()->load($file);
    }
}

if (! function_exists('footer')) {
    function footer($file=null)
    {
        $obj = \Jiny\Theme\Theme::instance();
        return $obj->footer()->load($file);
    }
}



// 이전버젼

use \Jiny\Theme\Theme;
use \Jiny\Theme\Layout\Layout;
use \Jiny\Theme\Layout\Show;

/*
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
*/

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