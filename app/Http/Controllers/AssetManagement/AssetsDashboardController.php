<?php

namespace App\Http\Controllers\AssetManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssetsDashboardController extends Controller
{
    public function index(){
        $page_name = "Asset Management Dashboard";
        return view('apps.asset-management.dashboard',compact('page_name'));
    }
}
