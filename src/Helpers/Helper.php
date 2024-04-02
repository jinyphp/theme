<?php
// 테마 객체를 생성합니다.
/*
if (!function_exists('theme')) {
    function theme()
    {
        return \Jiny\Theme\Theme::instance();
    }
}
*/

if (!function_exists('xTheme')) {
    function xTheme($name=null)
    {
        $obj = \Jiny\Theme\Theme::instance();
        if($name) $obj->setTheme($name);
        return $obj;
    }
}

function setTheme($name=null) {
    $obj = \Jiny\Theme\Theme::instance();
    if($name) $obj->setTheme($name);
    return $obj;
}

if(!function_exists("getThemeName")) {
    function getThemeName() {
        return xTheme()->getName();
    }
}


function themeCSS($path, $name=null) {
    if($name) {
        $theme = $name;
    } else {
        $theme = xTheme()->getTheme();
    }

    if($theme) {
        $themeName = str_replace(".", DIRECTORY_SEPARATOR, $theme);
        $filename = resource_path("views/theme/".$themeName.DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR.$path);
        if(file_exists($filename)) {
            $css = file_get_contents($filename);
            return $css;
        }
    }

    return null;
}

function themeScript($path, $name=null) {
    if($name) {
        $theme = $name;
    } else {
        $theme = xTheme()->getTheme();
    }

    if($theme) {
        $themeName = str_replace(".", DIRECTORY_SEPARATOR, $theme);
        $filename = resource_path("views/theme/".$themeName.DIRECTORY_SEPARATOR."js".DIRECTORY_SEPARATOR.$path);
        if(file_exists($filename)) {
            $css = file_get_contents($filename);
            return $css;
        }
    }

    return null;
}

