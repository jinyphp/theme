<?php
namespace Jiny\Theme\Http\Controllers\Site;

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
        $this->actions['table'] = "site_theme_store"; // 테이블 정보
        $this->actions['paging'] = 10; // 페이지 기본값

        $this->setLayout("jinytheme::site.store.layout");


        //$this->actions['view']['main'] = "jinytheme::admin.list.main";
        //$this->actions['view']['list'] = "jinytheme::site.store.list";
        $this->actions['view']['list'] = 'jinytheme::site.store.cell';

        $this->actions['view']['form'] = "jinytheme::site.store.form";

        // https://github.com/jinyphp/theme_docs_bootstrap/archive/refs/heads/master.zip
        // https://github.com/jinyphp/theme_admin_sidebar/archive/refs/heads/master.zip

    }

    public function index(Request $request)
    {
        // Request 객체에서 'any' 값을 가져옴
        $any = $request->route('any');
        $uri = request()->path();

        $this->params['slug'] = $any;
        return parent::index($request);
    }


}
