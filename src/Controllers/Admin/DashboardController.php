<?php

namespace Exdeliver\Causeway\Controllers\Admin;

use Exdeliver\Causeway\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('causeway::admin.dashboard');
    }
}
