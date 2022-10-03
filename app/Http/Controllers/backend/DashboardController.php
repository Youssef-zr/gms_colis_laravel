<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\controller;
use App\Models\Priorite;
use App\Models\Service;
use App\Models\TypeDocument;
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
