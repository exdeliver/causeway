<?php

namespace Exdeliver\Causeway\Controllers\Admin;

use Exdeliver\Causeway\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('causeway::admin.dashboard');
    }
}
