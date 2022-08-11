<?php

namespace Jiny\Theme;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Livewire;

class JinyThemeServiceProvider extends ServiceProvider
{
    private $package = "jinytheme";
    public function boot()
    {
        // 모듈: 라우트 설정
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', $this->package);

        // 데이터베이스
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        ## 테마를 선택하고 app과 컨덴츠를 결합합니다.
        Blade::component(\Jiny\Theme\View\Components\Theme\Theme::class, "theme");

        ## css, javascript등 페이지의 골격 뼈대를 읽어 옵니다.
        Blade::component(\Jiny\Theme\View\Components\Theme\App::class, "theme-app");


        ## app에 테마의 레이아웃을 결합합니다.
        Blade::component(\Jiny\Theme\View\Components\ThemeLayout::class, "theme-layout");

        Blade::component(\Jiny\Theme\View\Components\ThemeSidebar::class, "theme-sidebar");
        Blade::component(\Jiny\Theme\View\Components\ThemeMain::class, "theme-main");

        // 테마 컴포넌트 등록
        foreach($this->themeDir() as $theme) {
            $this->themeComponents($theme);
        }

        $this->Directive();
    }

    private function themeDir()
    {
        $path = resource_path('views/theme');
        if (file_exists($path) && is_dir($path)) {
            $dir = scandir($path);
            $themes = [];
            foreach($dir as $item) {
                if($item == '.' || $item == '..') continue;
                if($item[0] == '.') continue;
                //dump($item);
                if(is_dir($path.DIRECTORY_SEPARATOR.$item)) {
                    //$vendor = $item;
                    $dir2 = scandir($path.DIRECTORY_SEPARATOR.$item);
                    foreach($dir2 as $item2) {
                        if($item2 == '.' || $item2 == '..') continue;
                        if($item2[0] == '.') continue;
                        if(is_dir($path.DIRECTORY_SEPARATOR.$item.DIRECTORY_SEPARATOR.$item2)) {
                            $themes []= $item."/".$item2;
                        }
                    }
                }
            }
            return $themes;
        }

        return [];
    }

    private function themeComponents($theme)
    {
        $path = resource_path('views/theme');
        $path = $path.DIRECTORY_SEPARATOR.$theme.DIRECTORY_SEPARATOR."components";
        $path = str_replace('/',DIRECTORY_SEPARATOR,$path);
        //dump($path);
        if(is_dir($path)) {
            $dir = scandir($path);

            //$this->callAfterResolving(BladeCompiler::class, function ($dir, $theme) {
                foreach($dir as $item) {
                    if($item == '.' || $item == '..') continue;
                    $this->registerComponent($item, $theme);
                }
            //});
        }
    }

    private function registerComponent(string $item, string $theme)
    {
        $name = str_replace('.blade.php', '', $item);
        $component = "theme.".str_replace('/','.',$theme).".components.".$name;
        Blade::component($component, 'theme-'.$name);
    }


    public function register()
    {
        /* 라이브와이어 컴포넌트 등록 */
        $this->app->afterResolving(BladeCompiler::class, function () {
            Livewire::component('ThemeInstall', \Jiny\Theme\Http\Livewire\ThemeInstall::class);
        });
    }


    private function Directive()
    {
        // 테마설정
        Blade::directive('setTheme', function ($args) {
            $expression = Blade::stripParentheses($args);
            xTheme()->setTheme($expression);
        });

        // 테마안에 있는 리소스를 읽어 옵니다.
        Blade::directive('theme', function ($args) {
            $expression = Blade::stripParentheses($args);
            $name = trim($expression,'"');
            $name = trim($expression,"'");
            $name = trim($name,'/');

            $name = str_replace("/",".",$name);

            $path = "";
            /*

            $name = str_replace('/','.',$name);


            //dd("aaa");
            $viewBasePath = Blade::getPath();
            $base = dirname(trim($viewBasePath,'\/'));
            $base = str_replace(['/','\\'], ".", $base);
            $base = array_reverse(explode(".",$base));
            for($path="", $i=0; $i<count($base);$i++) {
                if($base[$i] == "theme") break;
                $path = $base[$i].".".$path;
            }
            */

            //dd($path);

            /*


            // 상대경로 parsing
            if($path[0] == ".") {
                $path = substr($path,1);

                $viewBasePath = Blade::getPath();
                $base = dirname(trim($viewBasePath,'\/'));
                $base = str_replace(['/','\\'], ".", $base);
                $base = array_reverse(explode(".",$base));
                for($i=0; $i<count($base);$i++) {
                    if($base[$i] == "theme") break;
                    $path = $base[$i].".".$path;
                }
            }
            */

            $expression = '"'."theme.".$path.$name.'"';
            return "<?php echo \$__env->make({$expression}, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>";

        });
    }


}
