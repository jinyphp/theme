<?php
namespace Jiny\Theme\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use Jiny\WireTable\Http\Controllers\DashboardController;
class AdminThemeDashboard extends DashboardController
{
    use \Jiny\WireTable\Http\Trait\TableAction;

    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this); // Livewire와 Visit 패턴으로 상호 연결합니다.

        // Json Actions 정보를 읽어 옵니다.
        if($actions = $this->getActionJson(__DIR__, $this)) {
            $this->actions = $actions;
        }

        // 수동으로 Actions 정보를 추가로 설정합니다.
        $this->actions['view']['layout'] = "jinytheme::admin.dashboard.dash";
        $this->actions['title'] = "Theme Dashboard";
        $this->actions['subtitle'] = "테마를 관리합니다.";

        // Action 정보를 통하여 컨트롤러를 초기화 합니다.
        $this->initControllerByActions();
    }



    public function index(Request $request)
    {
        //$filename = $this->saveActions(__DIR__, $this);
        //dd($filename);
        //$json = json_encode($this->actions, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        //file_put_contents($filename, $json);

        return parent::index($request);
    }

}
