<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HrmEmployeesController;
use App\Http\Controllers\HrmWeekworkdayController;
use App\Http\Controllers\HrmHolidaysController;
use App\Http\Controllers\HrmLeavetypesController;
use App\Http\Controllers\HrmPayheadsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HrmDepartmentController;
use App\Http\Controllers\HrmGradeController;
use App\Http\Controllers\HrmEmpCategoryController;
use App\Http\Controllers\HrmEmpLocationController;
use App\Http\Controllers\HrmDesignationController;
use App\Http\Controllers\HrmCurrentSalaryStruController;
use App\Http\Controllers\HrmAttendanceController;
use App\Http\Controllers\HrmMonthlySalaryController;
use App\Http\Controllers\HrmReportController;


//##########################
//  HRM Section Start
//
//#########

Route::group(['middleware' => ['auth']], function() {
Route::resource('hrm-employee',HrmEmployeesController::class);
Route::get('resume/{id}', [HrmEmployeesController::class, 'showResume']);
Route::resource('attandance',HrmAttendanceController::class);

Route::get('employee-search','App\Http\Controllers\HrmEmployeesController@employeeSearch');
Route::get('employee-dataupdate','App\Http\Controllers\HrmEmployeesController@employeeDataUpdate');
Route::resource('hrm-designation',HrmDesignationController::class);

Route::resource('initial-salary-structure',HrmCurrentSalaryStruController::class);
Route::get('salary-structure-search',[HrmCurrentSalaryStruController::class,'salaryStructureSearch']);


Route::get('branch_wise_sallary_sheet/{id}',[HrmMonthlySalaryController::class,'branch_wise_sallary_sheet'])->name('branch_wise_sallary_sheet');
Route::get('month_wise_sallary_sheet',[HrmMonthlySalaryController::class,'month_wise_sallary_sheet'])->name('month_wise_sallary_sheet');
Route::post('month_wise_salary_sheet_report',[HrmMonthlySalaryController::class,'month_wise_salary_sheet_report'])->name('month_wise_salary_sheet_report');

Route::get('salary_sheet',[HrmMonthlySalaryController::class,'salary_sheet'])->name('salary_sheet');
Route::get('salary_sheet_list',[HrmMonthlySalaryController::class,'salary_sheet_list'])->name('salary_sheet_list');
Route::post('salary_sheet_generate',[HrmMonthlySalaryController::class,'salary_sheet_generate'])->name('salary_sheet_generate');

Route::get('group_salary_structure',[HrmMonthlySalaryController::class,'salaryStructureGroup']);
Route::post('group_salary_structure_save',[HrmMonthlySalaryController::class,'salaryStructureGroupSave']);
Route::resource('monthly-salary-structure',HrmMonthlySalaryController::class);


Route::resource('weekworkday',HrmWeekworkdayController::class);

Route::resource('holidays',HrmHolidaysController::class);
Route::resource('leave-type',HrmLeavetypesController::class);
Route::resource('pay-heads',HrmPayheadsController::class);
Route::resource('companies',CompanyController::class);
Route::resource('hrm-department',HrmDepartmentController::class);
Route::resource('hrm-grade',HrmGradeController::class);
Route::resource('hrm-emp-location',HrmEmpLocationController::class);
Route::resource('hrm-emp-category',HrmEmpCategoryController::class);


/*HRM Report Section Start*/
Route::get('hrm_report_panel',[HrmReportController::class,'hrm_report_panel'])->name('hrm_report_panel');
Route::get('hrm_user_report',[HrmReportController::class,'hrm_user_report'])->name('hrm_user_report');
Route::any('payment_slip',[HrmReportController::class,'payment_slip'])->name('payment_slip');
Route::any('user_job_card',[HrmReportController::class,'user_job_card'])->name('user_job_card');
Route::any('payment_slip_report',[HrmReportController::class,'payment_slip_report'])->name('payment_slip_report');
Route::any('summary_attendance_report_filter',[HrmReportController::class,'summary_attendance_report_filter'])->name('summary_attendance_report_filter');
Route::any('late_attendance_summary_filter',[HrmReportController::class,'late_attendance_summary_filter'])->name('late_attendance_summary_filter');
Route::any('late_attendance_detail_filter',[HrmReportController::class,'late_attendance_detail_filter'])->name('late_attendance_detail_filter');
Route::any('date_wise_late_attandace_filter',[HrmReportController::class,'date_wise_late_attandace_filter'])->name('date_wise_late_attandace_filter');
Route::any('sallary_sheet_filter',[HrmReportController::class,'sallary_sheet_filter'])->name('sallary_sheet_filter');
Route::any('sallary_sheet_report',[HrmReportController::class,'sallary_sheet_report'])->name('sallary_sheet_report');







/*HRM Report section End*/


});