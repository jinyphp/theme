<?php

namespace Jiny\Theme\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use Jiny\Admin\Http\Controllers\AdminController;
class ThemeStoreController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ##
        //$this->actions['table']['name'] = "site_theme_store"; // 테이블 정보
        //$this->actions['paging'] = 10; // 페이지 기본값

        ///$this->actions['view']['main'] = "jinytheme::admin.store.main";
        ///$this->actions['view']['main_layout'] = "jinytheme::admin.store.main_layout";
        ///$this->actions['view']['list'] = "jinytheme::admin.store.tile";
        ///$this->actions['view']['form'] = "jinytheme::admin.store.form";

        // https://github.com/jinyphp/theme_docs_bootstrap/archive/refs/heads/master.zip
        // https://github.com/jinyphp/theme_admin_sidebar/archive/refs/heads/master.zip

    }

    public function HookIndexed($wire, $rows)
    {
        // 목록을 파일로 저장
        $themes = DB::table("site_theme")->get();
        $this->wire->installed = []; // 라이브와이어 동적 property 생성
        foreach($themes as $item) {
            $code = $item->code;
            $this->wire->installed[$code] = $item->installed;
        }

        return $rows;
    }


}
