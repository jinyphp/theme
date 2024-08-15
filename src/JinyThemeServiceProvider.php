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
    private $components = []; //중복생성 방지를 위한 임시체크
    private $theme;

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

        $this->components = ['theme', 'theme-app']; // 제외할 이름
        $this->dynamicComponents();
        //dd($this->components);

        /*


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
        */


        // artisan 명령등록
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Jiny\Theme\Console\Commands\ThemeGetUrl::class,
                \Jiny\Theme\Console\Commands\ThemeActive::class
            ]);
        }

        // 디렉티브
        Blade::directive('theme', function ($expression) {
            // Parse the expression to extract the view name and variables
            $args = str_getcsv($expression, ',', "'");
            $view = trim($args[0], '\'"');
            $variables = isset($args[1]) ? trim($args[1]) : '[]';

            $theme = xTheme()->getTheme();
            $viewPath = "'theme::" . $theme . "." . $view . "'";

            return "<?php echo \$__env->make({$viewPath}, {$variables}, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>";
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

    /**
     * 동적 컴포넌트
     * _components 안에 있는 파일들을 동적으로 컴포넌트화 합니다.
     */
    private function dynamicComponents()
    {
        // 현재 테마 경로 읽기
        $base = base_path('theme');

        $theme = xTheme()->getTheme();
        $this->theme = xTheme()->getTheme();

        $theme = str_replace(['.','/','\\'], DIRECTORY_SEPARATOR, $this->theme);
        $path = $base;
        $path .= DIRECTORY_SEPARATOR.$theme;

        // 1. 컴포넌트 폴더 동적로드
        if(!is_dir($path.DIRECTORY_SEPARATOR."_components")) {
            mkdir($path.DIRECTORY_SEPARATOR."_components",0777,true);
        }
        $this->makeRescueComponents($path.DIRECTORY_SEPARATOR."_components",["theme_"]);

        //dd($this->components);

        // 2. 레이아웃 폴더 동적로드
        if(!is_dir($path.DIRECTORY_SEPARATOR."_layouts")) {
            mkdir($path.DIRECTORY_SEPARATOR."_layouts",0777,true);
        }
        $this->makeRescueLayout($path.DIRECTORY_SEPARATOR."_layouts",["theme-"]);

        //dd($this->components);
    }

    private function makeRescueComponents($path, $prefix=null)
    {
        // $prefix = trim($prefix, '-'); // 앞에 -로 시작하는 것 제외

        // 테마에서 파일을 읽기
        $dir = scandir($path);
        //dd($dir);
        foreach($dir as $file) {
            if($file == '.' || $file == '..') continue;
            if($file[0] == '.') continue; // 숨김파일

            if(is_dir($path.DIRECTORY_SEPARATOR.$file)) {
                // dd($prefix);
                $temp = $prefix;
                $temp []= $file;
                $this->makeRescueComponents($path.DIRECTORY_SEPARATOR.$file, $temp);
                continue;
            }

            // blade 파일인지 검사
            if(substr($file, -10) === '.blade.php') {
                $name = substr($file, 0, strlen($file)-10);

                $temp = $prefix;
                $temp []= $name;
                if(count($temp)>0) {
                    $comName = $temp[0];
                    $comName .= implode('-',array_slice($temp,1));
                    //dump($comName);
                    //$comName .= "-".$name;
                } else {
                    //$comName = "";
                    $comName = implode('-',array_slice($temp,1));
                    //$comName .= "-".$name;
                }
                //dump($comName);


                if(!in_array($comName, $this->components)) {
                    $this->components []= $comName;

                    $comPath = "theme::".$this->theme."._components.";
                    if(count($temp)>0) {
                        $comPath .= implode('.',array_slice($temp,1));
                    } else {

                    }
                    //$comPath .= ".".$name;
                    //dd($comPath);
                    //dump($comPath);
                    Blade::component($comPath,$comName);
                }
            }

        }
    }

    private function makeRescueLayout($path, $prefix=null)
    {
        // $prefix = trim($prefix, '-'); // 앞에 -로 시작하는 것 제외
        //dd("fasdfa");
        // 테마에서 파일을 읽기
        $dir = scandir($path);
        //dump($path);
        //dd($dir);
        foreach($dir as $file) {
            if($file == '.' || $file == '..') continue;
            if($file[0] == '.') continue; // 숨김파일

            if(is_dir($path.DIRECTORY_SEPARATOR.$file)) {
                // dd($prefix);
                $temp = $prefix;
                $temp []= $file;
                $this->makeRescueComponents($path.DIRECTORY_SEPARATOR.$file, $temp);
                continue;
            }

            // blade 파일인지 검사
            if(substr($file, -10) === '.blade.php') {
                $name = substr($file, 0, strlen($file)-10);

                $temp = $prefix;
                $temp []= $name;
                if(count($temp)>0) {
                    $comName = $temp[0];
                    $comName .= implode('-',array_slice($temp,1));
                    //dump($comName);
                    //$comName .= "-".$name;
                } else {
                    //$comName = "";
                    $comName = implode('-',array_slice($temp,1));
                    //$comName .= "-".$name;
                }
                //dump($comName);


                if(!in_array($comName, $this->components)) {
                    $this->components []= $comName;

                    $comPath = "theme::".$this->theme."._layouts.";
                    if(count($temp)>0) {
                        $comPath .= implode('.',array_slice($temp,1));
                    } else {

                    }
                    //$comPath .= ".".$name;
                    //dd($comPath);
                    //dump($comPath);
                    //dd($comPath);
                    Blade::component($comPath,$comName);
                }
            }

        }
    }

    /**
     * 테마 components 폴더 안에 있는 파일을
     * 동적으로 로드 합니다.
     */
    // private function scanComponents($path, $except=[])
    // {
    //     foreach($except as $i => $name) {
    //         $except[$i] .= ".blade.php";
    //     }

    //     $dir = scandir($path);
    //     $names = [];
    //     foreach($dir as $file) {
    //         if($file == '.' || $file == '..') continue;
    //         if($file[0] == '.') continue;
    //         if(in_array($file,$except)) continue;

    //         if(is_dir($path.DIRECTORY_SEPARATOR.$file)) {
    //             $sub = $this->scanComponents($path.DIRECTORY_SEPARATOR.$file);
    //             foreach($sub as $name) {
    //                 $component = str_replace(".blade.php","",$file.".".$name);
    //                 Blade::component(\Jiny\Theme\View\Components\ThemeComponent::class, "theme-".$component);
    //                 $names []= $component;
    //             }
    //         } else {
    //             $component = str_replace(".blade.php","",$file);
    //             Blade::component(\Jiny\Theme\View\Components\ThemeComponent::class, "theme-".$component);
    //             $names []= $component;
    //         }
    //     }

    //     return $names;
    // }




    public function register()
    {
        /* 라이브와이어 컴포넌트 등록 */
        $this->app->afterResolving(BladeCompiler::class, function () {
            Livewire::component('ThemeInstall', \Jiny\Theme\Http\Livewire\ThemeInstall::class);

            Livewire::component('theme-list', \Jiny\Theme\Http\Livewire\ThemeList::class);
        });
    }

}
