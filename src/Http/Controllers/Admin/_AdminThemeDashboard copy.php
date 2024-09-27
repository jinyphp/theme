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


    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        $this->actions['view']['layout'] = "jinytheme::admin.dashboard.dash";

        $this->actions['title'] = "Theme Dashboard";
        $this->actions['subtitle'] = "테마를 관리합니다.";


    }


    public function index(Request $request)
    {
        return parent::index($request);
    }

}
