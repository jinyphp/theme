<?php

namespace Jiny\Theme\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class ThemeActive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:active {theme} {--disable} {--enable}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'theme enable';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $theme = $this->argument('theme');

        $isTheme = $this->option('enable') ? 1:0;
        if($this->option('disable')) {
            $isTheme = 0;
        }

        $setting = config("jiny.theme.setting");
        if($isTheme) {
            if(!in_array($theme, $setting['active'])) {
                $setting['active'] []= $theme;
                $content = $this->convToPHP($setting);
                $content = str_replace("\/","/",$content);

                $path = config_path('jiny/theme').DIRECTORY_SEPARATOR."setting.php";
                file_put_contents($path, $content);
            }

            $this->info('Success : '. $theme." is Actived");
        } else {

            if(in_array($theme, $setting['active'])) {
                foreach($setting['active'] as $i=>$item) {
                    if($item == $theme) {
                        unset($setting['active'][$i]);
                    }
                }

                $content = $this->convToPHP($setting);
                $content = str_replace("\/","/",$content);

                $path = config_path('jiny/theme').DIRECTORY_SEPARATOR."setting.php";
                file_put_contents($path, $content);

            }

            $this->info('Success : '. $theme." is Disable");
        }

        return 0;
    }

    public function convToPHP($form)
    {
        $str = json_encode($form);

        // php 배열형태로 변환
        $str = str_replace('{',"[\r\n",$str);
        $str = str_replace('}',"\r\n]",$str);
        $str = str_replace('":',"\"=>",$str);
        $str = str_replace(',',",\r\n",$str);

        // php 파일
        $file = "<?php
return ".$str.";";

        return $file;
    }


}
