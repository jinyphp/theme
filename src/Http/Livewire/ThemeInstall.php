<?php

namespace Jiny\Theme\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use ZipArchive;

class ThemeInstall extends Component
{
    public $actions;

    public function mount()
    {

    }

    public function render()
    {
        return view("jinytheme::livewire.popup.install");
    }

    /** ----- ----- ----- ----- -----
     *  json 데이터 읽기
     */
    public $dataType = "table";
    protected function dataFetch($actions)
    {
        // table 필드를 source로 활용
        if(isset($actions['table']) && $actions['table']) {
            $source = $actions['table'];
        }

        if(isset($actions['source']) && $actions['source']) {
            $source = $actions['source'];
        }

        //$source = "https://jinytheme.github.io/store/themelist.json";
        if ($source) {
            if($pos = strpos($source,"://")) {
                $this->dataType = "uri";

                // url 리소스
                $response = HTTP::get($source);
                $body = $response->body();
                $json = json_decode($body);
                return $json->data;
            } else {
                $this->dataType = "file";

                // 파일 리소스
                $path = resource_path().$source;
                if (file_exists($path)) {
                    $json = file_get_contents($path);
                    $rows = json_decode($json)->data;
                    return $rows;
                }
            }
        }

        return [];
    }

    /** ----- ----- ----- ----- -----
     *  팝업창 관리
     */
    protected $listeners = ['popupStoreOpen','popupStoreClose', 'install', 'uninstall'];
    public $popupstore = false;

    public function popupStoreOpen()
    {
        $this->popupstore = true;
    }

    public function popupStoreClose()
    {
        $this->popupstore = false;

        // 초기화
        //if(isset($this->theme['installed'])) unset($this->theme['installed']);
        $this->theme = [];
    }

    /** ----- ----- ----- ----- -----
     *  설치 프로세스
     */
    public $code;
    public $theme=[];
    public function install($code)
    {
        $this->code = $code;

        // 테마 정보 데이터 읽기
        if($this->dataType == "table") {
            $row = DB::table("site_theme_store")->where('code',$code)->first();
            //$row = DB::table("site_theme")->where('code',$code)->first();
        } else {
            // json 데이터의 경우, 파일 또는 uri를 통하여 얻음
            $rows = $this->dataFetch($this->actions);
            foreach($rows as $item) {
                if($item->code == $code) {
                    $row = $item; // 검색조건
                    break;
                }
            }
        }

        // 테마정보를 설정
        if($row) {
            foreach($row as $key => $value) {
                $this->theme[$key] = $value;
            }

            $theme = DB::table("site_theme")->where('code',$code)->first();
            if($theme) {
                $this->theme['installed'] = $theme->installed;
            }

        }

        $this->popupStoreOpen();
    }

    public function download()
    {
        // 다운로드
        if($this->theme['url']) {

            dd($this->theme['url']);

            // 1. 다운로드
            $path = resource_path('views/theme').DIRECTORY_SEPARATOR;
            $filename = $path.str_replace("/","-",$this->theme['code']).".zip";
            $source = $this->theme['url'];
            $response = (new Client)->get($source);
            file_put_contents($filename, $response->getBody());

            $vendor = explode("/",$this->theme['code']);

            //dd($vendor);

            // 2. 압축풀기
            if (file_exists($filename)) {
                $archive = new ZipArchive;
                $archive->open($filename);
                $archive->extractTo($path.$vendor[0]); // vendor 폴더에 압축풀기
                //rename("jiny-0.1.6", $directory);
                $archive->close();

                // 다운로드 파일 삭제
                unlink($filename);
            }

            // 3. 파일 폴더이동
            if(isset($vendor[1])) {
                $theme_name = $vendor[1];
            } else {
                $theme_name = "src";
            }

            foreach(scandir($path.$vendor[0]) as $p) {
                if($p == "." || $p == "..") continue;
                if(is_dir($path.$vendor[0].DIRECTORY_SEPARATOR.$p) && $p != $theme_name) {
                    rename(
                        $path.$vendor[0].DIRECTORY_SEPARATOR.$p,
                        $path.$vendor[0].DIRECTORY_SEPARATOR.$theme_name
                    );
                }
            }


            // 4. DB 정보 갱신
            $row = DB::table("site_theme")->where('code',$this->theme['code'])->first();
            if($row) {
                // 기존 설치되어 있는 경우, 설치일자만 재설정
                DB::table("site_theme")->where('code',$this->theme['code'])->update([
                    'installed'=> date("Y-m-d H:i:s")
                ]);
            } else {
                // 목록에 삽입
                $this->theme['installed'] = date("Y-m-d H:i:s"); // 설치일자 설정
                DB::table("site_theme")->insertOrIgnore($this->theme);
            }


        } else {
            // 다운로드 url이 없습니다.
            dd($this->theme);
        }



        $this->theme=[]; // 초기화
        $this->popupStoreClose();

        // Livewire Table을 갱신을 호출합니다.
        $this->emit('refeshTable');
    }


    /** ----- ----- ----- ----- -----
     *  제거 프로세스
     */
    public function uninstall($code)
    {
        $this->code = $code;

        // 테마 정보 데이터 읽기
        if($this->dataType == "table") {
            $row = DB::table("site_theme_store")->where('code',$code)->first();
        } else {
            // json 데이터의 경우, 파일 또는 uri를 통하여 얻음
            $rows = $this->dataFetch($this->actions);
            foreach($rows as $item) {
                if($item->code == $code) {
                    $row = $item; // 검색조건
                    break;
                }
            }
        }

        if ($row) {
            foreach($row as $key => $value) {
                $this->theme[$key] = $value;
            }

            $theme = DB::table("site_theme")->where('code',$code)->first();
            if($theme) {
                $this->theme['installed'] = $theme->installed;
            }
        }

        //dd($this->theme);
        $this->popupStoreOpen();
    }

    public function remove()
    {
        if ($this->theme['code']) {
            // 모든 파일을 삭제
            $path = resource_path('views/theme').DIRECTORY_SEPARATOR;
            $filename = $path.$this->theme['code'];
            if(file_exists($filename) && is_dir($filename)) {
                $this->unlinkAll($filename);
            }

            // 설치항목 초기화
            DB::table("site_theme")->where('code',$this->theme['code'])->update([
                'installed'=> ""
            ]);
        }

        $this->theme=[]; // 초기화
        $this->popupStoreClose();

        // Livewire Table을 갱신을 호출합니다.
        $this->emit('refeshTable');
    }

    // delete all files and sub-folders from a folder
    public function unlinkAll($dir) {
        foreach( scandir($dir) as $file) {
            if($file == "." || $file == "..") continue;
            if(is_dir($dir.DIRECTORY_SEPARATOR.$file)) {
                $this->unlinkAll($dir.DIRECTORY_SEPARATOR.$file);
            } else {
                //dump($dir.DIRECTORY_SEPARATOR.$file);
                unlink($dir.DIRECTORY_SEPARATOR.$file);
            }
        }
        rmdir($dir);
    }


}
