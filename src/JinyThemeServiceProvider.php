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


        // 디자인

        $this->Directive();

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
