<?php

namespace Jiny\Theme\Console\Commands;

use Illuminate\Console\Command;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

use ZipArchive;

class ThemeGetUrl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:geturl {url?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'theme download from url';

    private $setting;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setting = config("jiny.theme.setting");
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = $this->argument('url');
        if($url) {
            // $url = "https://github.com/jinyerp/work-module/archive/refs/heads/master.zip";
            // https://github.com/jinyphp/tailwind.git
            $filename = $this->checkUrl($url);
            if($filename) {
                $this->info("Downloading...");

                $file = $this->download($filename);

                $this->unzip($file);

                //$setting = config("jiny.theme.setting");
                $path = base_path($this->setting['path']).DIRECTORY_SEPARATOR."__";
                if(!is_dir($path)) mkdir($path);

                $dir = scandir($path);
                //dd($dir);
                $foldername = $path.DIRECTORY_SEPARATOR.$dir[2];
                $jsonBody = file_get_contents($foldername.DIRECTORY_SEPARATOR."theme.json");
                $theme = json_decode($jsonBody);

                if(file_exists($path)) {
                    passthru("mv ".$foldername." ".base_path($this->setting['path']).DIRECTORY_SEPARATOR.$theme->name);
                    rmdir($path);
                    $this->info($url." installed");
                }



            } else {
                $this->info("유효하지 않은 주소 입니다.");
            }


        } else {
            $this->info("url 경로가 입력되지 않았습니다.");
        }

        return 0;
    }

    private function checkUrl($url)
    {
        $ext = $this->getExtension($url);
        switch($ext) {
            case 'git':
                $filename = str_replace(".git",'',$url);
                $filename .= "/archive/refs/heads/master.zip";
                return $filename;
                //break;
            case 'zip':
                $filename = $url;
                return $filename;
                //break;
        }

        return false;
    }


    private function getExtension($file)
    {
        $pos = strrpos($file,'.');
        if($pos>0) {
            return substr($file,$pos+1);
        }
    }



    /**
     *  파일 다운로드
     */
    public function download($url)
    {
        // $url = "https://github.com/jinyerp/work-module/archive/refs/heads/master.zip";
        //$url = "https://github.com/jinyerp/blog/archive/refs/heads/master.zip";

        // 다운로드 url 체크
        if($url) {
            $source = $url;
            $this->info($source);

            //dd($source);
            try {
                $response = (new Client)->get($source);
                 //dd($response);

                $path = base_path($this->setting['path']).DIRECTORY_SEPARATOR;
                file_put_contents($path."__.zip", $response->getBody());

                return $path."__.zip";

            } catch (ClientException $e) {
                echo Psr7\Message::toString($e->getRequest());
                echo Psr7\Message::toString($e->getResponse());
            }

        } else {
            // 다운로드 url이 없습니다.
        }
    }

    public function unzip($file)
    {
        // 2. 압축풀기
        if (file_exists($file)) {
            $archive = new ZipArchive;
            $archive->open($file);

            $temp = str_replace(".zip","",$file);
            $archive->extractTo($temp); // 압축풀기
            $archive->close();

            // 다운로드 파일 삭제
            unlink($file);
        }
    }

}
