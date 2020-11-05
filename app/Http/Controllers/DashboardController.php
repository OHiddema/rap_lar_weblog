<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function index(){
        $this->authorize('admin', \Auth::user());
        return view('dashboard.index');
    }
}