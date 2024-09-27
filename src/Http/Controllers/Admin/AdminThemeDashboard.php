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
class AdminThemeDashboard extends WireDashController
{
    //use \Jiny\WireTable\Http\Trait\TableAction;

    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this); // Livewire와 Visit 패턴으로 상호 연결합니다.

        // Json Actions 정보를 읽어 옵니다.
        // if($actions = $this->getActionJson(__DIR__, $this)) {
        //     $this->actions = $actions;
        // }

        // 수동으로 Actions 정보를 추가로 설정합니다.
        $this->actions['view']['layout'] = "jinytheme::admin.dashboard.dash";
        $this->actions['title'] = "Theme Dashboard";
        $this->actions['subtitle'] = "테마를 관리합니다.";

        // Action 정보를 통하여 컨트롤러를 초기화 합니다.
        //$this->initControllerByActions();
        //dd("theme dashboard");
        //session(['theme1' => "aaa1"]);
        //_setThemeName("bbb1");
    }



    public function index(Request $request)
    {
        //session(['theme' => "aaa1"]);
        // session()->put('theme1', 1);
        //$theme = session('theme1', 'default');
        // $theme = _getThemeName();
        // dd($theme);
        return parent::index($request);
    }

}
