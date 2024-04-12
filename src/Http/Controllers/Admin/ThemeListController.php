<?php

namespace Jiny\Theme\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use Jiny\Admin\Http\Controllers\AdminController;
class ThemeListController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ##
        $this->actions['table'] = "site_theme"; // 테이블 정보
        $this->actions['paging'] = 10; // 페이지 기본값

        $this->actions['view']['main'] = "jinytheme::admin.list.main";
        $this->actions['view']['list'] = "jinytheme::admin.list.list";
        $this->actions['view']['form'] = "jinytheme::admin.list.form";

        // https://github.com/jinyphp/theme_docs_bootstrap/archive/refs/heads/master.zip
        // https://github.com/jinyphp/theme_admin_sidebar/archive/refs/heads/master.zip

    }


    /**
     * DB 갱신전에 호출되는 동작
     */
    public function hookUpdating($form)
    {
        /*
        // 코드명 변경 체크
        if ($this->wire->old['route'] != $form['route']) {
            $path = resource_path('actions');
            $filename = $path.$this->wire->old['route'].".json";
            if(file_exists($filename)) {
                // 파일명 변경하기
                $newfile = str_replace("/","_",ltrim($form['route'],"/")).".json";
                rename($filename, $path.DIRECTORY_SEPARATOR.$newfile);
            }
        }
        */

        return $form;
    }


    /**
     * DB 데이터를 삭제하기 전에 동작
     */
    public function hookDeleting($row)
    {
        $path = resource_path('views/theme').DIRECTORY_SEPARATOR;
        $filename = $path.$row->code;
        if(file_exists($filename) && is_dir($filename)) {
            $this->unlinkAll($filename);
        }

        return $row;
    }

    public function hookCheckDeleting($selected)
    {
        $path = resource_path('views/theme').DIRECTORY_SEPARATOR;

        $rows = DB::table($this->actions['table'])->whereIn('id',$selected)->get();
        foreach($rows as $row) {
            $filename = $path.$row->code;
            if(file_exists($filename) && is_dir($filename)) {
                $this->unlinkAll($filename);
            }
        }
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
