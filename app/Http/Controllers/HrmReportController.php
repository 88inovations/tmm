<?php

namespace App\Http\Controllers;

use App\Models\HRM\HrmMonthlySalaryDetail;
use App\Models\HRM\HrmPayheads;
use App\Models\HRM\HrmMonthlySalaryMaster;
use App\Models\HRM\HrmEmpCategory;
use App\Models\HRM\HrmDepartment;
use App\Models\HRM\Designation;
use App\Models\HRM\HrmGrade;
use App\Models\HRM\HrmEmpLocation;
use App\Models\HRM\HrmEmployees;
use App\Models\HRM\SalarySheet;
use App\Models\Zone;

use App\Models\VoucherMaster;
use App\Models\VoucherMasterDetail;
use App\Models\AccountLedger;
use App\Models\AccountGroup;
use App\Models\AccountHead;
use App\Models\Accounts;
use App\Models\Branch;
use App\Models\VoucherType;
use App\Models\VoucharCheckInfo;

use Illuminate\Http\Request;
use Auth;
use Session;
use DB;

class HrmReportController extends Controller
{
    //




    public function hrm_report_panel(){
        $page_name =__('label.hrm_report_panel');
        return view('hrm.report.report_panel',compact('page_name'));
    }


    public function payment_slip_report(){
        $page_name =__('label.payment_slip_report');
        return view('hrm.report.payment_slip_report',compact('page_name'));
    }

    public function hrm_user_report(){
        $page_name =__('label.hrm_user_report');
        return view('hrm.report.hrm_user_report',compact('page_name'));
    }

    public function sallary_sheet_filter(){
        $page_name =__('label.sallary_sheet_filter');
        $users = \Auth::user();
           
         $employee_catogories = HrmEmpCategory::where('_status',1)->orderBy('_name','ASC')->get();
         $departments = HrmDepartment::where('_status',1)->orderBy('_department','ASC')->get();
         $designations = Designation::where('_status',1)->orderBy('_name','ASC')->get();
         $grades = HrmGrade::where('_status',1)->orderBy('_grade','ASC')->get();
         $job_locations = HrmEmpLocation::where('_status',1)->orderBy('_name','ASC')->get();
         $job_zones = Zone::where('_status',1)->orderBy('_name','ASC')->get();
       
       return view('hrm.report.sallary_sheet_filter',compact('page_name','employee_catogories','departments','designations','grades','job_locations','job_zones'));
        
    }


    public function sallary_sheet_report(Request $request){

    }
}
