<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware("permission:paramètres_index", ['only' => ['settings']]);
    }

    public function welcome()
    {
        return view("backend.views.welcome");
    }


    public function logout()
    {
        Auth::logout();
        return redirect(url('/login'));
    }
}
