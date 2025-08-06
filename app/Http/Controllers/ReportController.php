<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    //

    public function reportPanel(){
        $page_name=__('label.report_panel');
        return view('report-panel.dashboard',compact('page_name'));
    }
}
