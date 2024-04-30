<?php

namespace Jiny\Theme;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Livewire;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class JinyThemeServiceProvider extends ServiceProvider
{
    private $package = "jinytheme";
    public function boot()
    {
        // 모듈: 라우트 설정
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', $this->package);

        // Custom Site Resources
        $path = base_path('theme');
        if(!is_dir($path)) {
            mkdir($path,0777,true);
        }
        $this->loadViewsFrom($path, 'theme');

        // 데이터베이스
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // 설정파일 복사
        $this->publishes([
            __DIR__.'/../config/theme/setting.php' => config_path('jiny/theme/setting.php'),
        ]);


        $setting = config("jiny.theme.setting");
        if($setting) {
            /*
            // 테마 view 경로 추가
            $paths = config('view.paths');
            $paths []= base_path($setting['path']);
            config(['view.paths' => $paths]);

            // Active Components 등록
            if(isset($setting['active'])) {
                foreach($setting['active'] as $item) {
                    $path = base_path($setting['path'].DIRECTORY_SEPARATOR.$item);
                    if(is_dir($path)) {
                        $componentNames = $this->scanComponents($path, ['app']);
                        // ,'layout','sidebar','main','footer','header'
                    }
                }
            }
            */


        }

        /*
        테마 레아이웃 컴포넌트
        */
        Blade::component(\Jiny\Theme\View\Components\Theme\Theme::class, "theme");
        Blade::component(\Jiny\Theme\View\Components\Theme\App::class, "theme-app");

        // 프레임워크 선택 컴포넌트
        Blade::component(\Jiny\Theme\View\Components\ThemeBootstrap::class, "theme-bootstrap");


        Blade::component(\Jiny\Theme\View\Components\ThemeLayout::class, "theme-layout");
        Blade::component(\Jiny\Theme\View\Components\ThemeMain::class, "theme-main");
        Blade::component(\Jiny\Theme\View\Components\ThemeHeader::class, "theme-header");
        Blade::component(\Jiny\Theme\View\Components\ThemeFooter::class, "theme-footer");
        Blade::component(\Jiny\Theme\View\Components\ThemeSidebar::class, "theme-sidebar");
        Blade::component(\Jiny\Theme\View\Components\ThemeMenu::class, "theme-menu");
        Blade::component(\Jiny\Theme\View\Components\ThemeTopMenu::class, "theme-topmenu");
        Blade::component(\Jiny\Theme\View\Components\ThemeTopBar::class, "theme-topbar");


        // artisan 명령등록
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Jiny\Theme\Console\Commands\ThemeGetUrl::class,
                \Jiny\Theme\Console\Commands\ThemeActive::class
            ]);
        }

        // 디렉티브
        Blade::directive('theme', function ($expression) {
            $args = str_getcsv($expression);
            $themeFile = trim($args[0], '\'"');
            $themeVariables = isset($args[1]) ? trim($args[1], '\'"') : '';

            $themeName = xTheme()->getName();
            if($themeName) {
                // 미리 @setThem를 통하여 테마가 선언되어 있어야 함.
                $base = base_path('theme/');
                $path = str_replace('.', DIRECTORY_SEPARATOR, trim($themeName,'"'));
                $themePath = $path . DIRECTORY_SEPARATOR . $themeFile;
                $themePath = str_replace(['/','\\'], DIRECTORY_SEPARATOR, $themePath);


                if(file_exists($base.$themePath.".blade.php")) {
                    $themeContent = File::get($base.$themePath.".blade.php");
                } else
                if(file_exists($base.$themePath.".html")) {
                    $themeContent = File::get($base.$themePath.".html");
                } else {
                    $themeContent = "can't read ".$themePath;
                }
            } else {
                $themeContent = "미리 테마가 선택되어 있어야 합니다.";
            }

            // 변수를 템플릿에 전달하고 컴파일된 결과를 반환합니다.
            return Blade::compileString($themeContent, $themeVariables);
        });

        // 테마설정
        Blade::directive('setTheme', function ($args) {
            $expression = Blade::stripParentheses($args);
            //dd($args);
            $expression = trim($expression,'"');
            xTheme()->setTheme($expression);
        });

        Blade::directive('themeAssets', function ($expression) {
            $args = str_getcsv($expression);
            $themeFile = trim($args[0], '\'"');
            $themeVariables = isset($args[1]) ? trim($args[1], '\'"') : '';


            $base = base_path('theme/');
            $themePath = str_replace(['/','\\'], DIRECTORY_SEPARATOR, $themeFile);
            $themeContent = File::get($base.$themePath);


            // 변수를 템플릿에 전달하고 컴파일된 결과를 반환합니다.
            return Blade::compileString($themeContent, $themeVariables);
        });

    }


    private function scanComponents($path, $except=[])
    {
        foreach($except as $i => $name) {
            $except[$i] .= ".blade.php";
        }

        $dir = scandir($path);
        $names = [];
        foreach($dir as $file) {
            if($file == '.' || $file == '..') continue;
            if($file[0] == '.') continue;
            if(in_array($file,$except)) continue;

            if(is_dir($path.DIRECTORY_SEPARATOR.$file)) {
                $sub = $this->scanComponents($path.DIRECTORY_SEPARATOR.$file);
                foreach($sub as $name) {
                    $component = str_replace(".blade.php","",$file.".".$name);
                    Blade::component(\Jiny\Theme\View\Components\ThemeComponent::class, "theme-".$component);
                    $names []= $component;
                }
            } else {
                $component = str_replace(".blade.php","",$file);
                Blade::component(\Jiny\Theme\View\Components\ThemeComponent::class, "theme-".$component);
                $names []= $component;
            }
        }

        return $names;
    }




    public function register()
    {
        /* 라이브와이어 컴포넌트 등록 */
        $this->app->afterResolving(BladeCompiler::class, function () {
            Livewire::component('ThemeInstall', \Jiny\Theme\Http\Livewire\ThemeInstall::class);

            Livewire::component('theme-list', \Jiny\Theme\Http\Livewire\ThemeList::class);
        });
    }

}
