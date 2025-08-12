<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\STM\StudentController;
use App\Http\Controllers\STM\StmDivisionController;
use App\Http\Controllers\STM\StmClassController;
use App\Http\Controllers\STM\StmBillCollectionController;
use App\Http\Controllers\STM\StmEducationSessionController;
use App\Http\Controllers\STM\StmSubjectController;
use App\Http\Controllers\STM\StudentModuleSetupController;
use App\Http\Controllers\STM\StmBillMasterController;
use App\Http\Controllers\STM\StmReportController;
use App\Http\Controllers\STM\AttendanceReportController;



Route::get('/attendance-report', [AttendanceReportController::class, 'index']);


Route::get('attandance_update',function(){
   $server = 'tcp:175.29.198.92,1433';  // Don't forget 'tcp:' prefix
    $database = 'UNIS';
    $username = 'unisuser';
    $password = 'unisamho';

    try {
        $pdo = new PDO("dblib:host=175.29.198.92;dbname=UNIS", "unisuser", "unisamho");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "✅ Connected to SQL Server successfully!";
    } catch (PDOException $e) {
        echo "❌ Connection failed: " . $e->getMessage();
    }

    
//   try {
//         $pdo = new PDO("dblib:host=175.29.198.92;dbname=UNIS", "unisuser", "unisamh");
//         echo "✅ Connected successfully!";
//     } catch (PDOException $e) {
//         echo "❌ Failed: " . $e->getMessage();
//     }
    
});


Route::group(['prefix' => 'stm'], function () {
	Route::resource('stm_education_sessions',StmEducationSessionController::class);
	Route::resource('stm_divisions',StmDivisionController::class);
	Route::resource('stm_classes',StmClassController::class);
	Route::resource('stm_students',StudentController::class);
	Route::resource('stm_subjects',StmSubjectController::class);
	Route::get('session_class_div_wise_student',[StudentController::class,'session_class_div_wise_student'])->name('session_class_div_wise_student');

	
	Route::resource('stm_bill_masters',StmBillMasterController::class);
	Route::resource('stm_collection',StmBillCollectionController::class);

	Route::get('admission_fee_collection',[StmBillCollectionController::class,'admissionFeeCollectionForm'])->name('admission_fee_collection');
	Route::get('student_due_bill_search',[StmBillCollectionController::class,'student_due_bill_search'])->name('student_due_bill_search');
	

	Route::post('admission_fee_collection_store',[StmBillCollectionController::class,'admission_fee_collection_store'])->name('admission_fee_collection_store');

	Route::get('admission_fee_collection_list',[StmBillCollectionController::class,'admission_fee_collection_list'])->name('admission_fee_collection_list');

	Route::get('admission_fee_collection_show',[StmBillCollectionController::class,'admission_fee_collection_show'])->name('admission_fee_collection_show');
	Route::get('admission_fee_collection_edit',[StmBillCollectionController::class,'admission_fee_collection_edit'])->name('admission_fee_collection_edit');
	Route::get('admission_fee_collection_delete',[StmBillCollectionController::class,'admission_fee_collection_delete'])->name('admission_fee_collection_delete');

	Route::get('admission-form/pdf', [StudentController::class, 'downloadAdmissionForm'])->name('students.admissionFormPdf');
	Route::post('stm_students_excel_upload', [StudentController::class, 'stm_students_excel_upload'])->name('stm_students_excel_upload');

	Route::get('stm_division_class_students',[StudentModuleSetupController::class,'stm_division_class_students'])->name('stm_division_class_students');
	Route::post('stm_division_class_students_store',[StudentModuleSetupController::class,'stm_division_class_students_store'])->name('stm_division_class_students_store');


	Route::get('stm_income_ledger_setups',[StudentModuleSetupController::class,'stm_income_ledger_setups'])->name('stm_income_ledger_setups');
	Route::post('stm_income_ledger_setups_store',[StudentModuleSetupController::class,'stm_income_ledger_setups_store'])->name('stm_income_ledger_setups_store');

	Route::get('search_ledger', [StudentModuleSetupController::class, 'search_ledger'])->name('search_ledger');

/*Report Section Url*/

	Route::get('division_class_student_report', [StmReportController::class, 'division_class_student_report'])->name('division_class_student_report');
	Route::get('division_class_wise_student_list', [StmReportController::class, 'division_class_wise_student_list'])->name('division_class_wise_student_list');


	Route::get('division_class_collection_report', [StmReportController::class, 'division_class_collection_report'])->name('division_class_collection_report');
	Route::get('division_class_collection_list', [StmReportController::class, 'division_class_collection_list'])->name('division_class_collection_list');

	Route::get('division_class_collection_status_report', [StmReportController::class, 'division_class_collection_status_report'])->name('division_class_collection_status_report');
	Route::get('division_class_collection_status_list', [StmReportController::class, 'division_class_collection_status_list'])->name('division_class_collection_status_list');

	Route::get('student_ledger_report', [StmReportController::class, 'student_ledger_report'])->name('student_ledger_report');
	Route::get('student_ledger_report_data', [StmReportController::class, 'student_ledger_report_data'])->name('student_ledger_report_data');
	
	Route::get('month_wise_payment_status_report', [StmReportController::class, 'month_wise_payment_status_report'])->name('month_wise_payment_status_report');
	Route::get('month_wise_payment_status_data', [StmReportController::class, 'month_wise_payment_status_data'])->name('month_wise_payment_status_data');

	Route::get('monthly_class_wise_fee_collection_ledger', [StmReportController::class, 'monthly_class_wise_fee_collection_ledger'])->name('monthly_class_wise_fee_collection_ledger');
	Route::get('monthlyCollectionReport', [StmReportController::class, 'monthlyCollectionReport'])->name('monthlyCollectionReport');

	


/* Report Section End */

  
 
});





