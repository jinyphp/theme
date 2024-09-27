<?php
namespace Jiny\Theme\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use Jiny\WireTable\Http\Controllers\WireDashController;
class AdminThemeMarket extends WireDashController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        $this->actions['table'] = "site_theme_store"; // 테이블 정보
        $this->actions['paging'] = 10; // 페이지 기본값

        $this->setLayout("jinytheme::admin.market.layout");
        $this->actions['view']['list'] = 'jinytheme::site.store.cell';
        $this->actions['view']['form'] = "jinytheme::site.store.form";

        $this->actions['title'] = "테마 마켓 관리";
        $this->actions['subtitle'] = "테마를 관리합니다.";
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
