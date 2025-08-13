<?php

namespace App\Http\Controllers\STM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\STM\StmStudent;
use App\Models\STM\StmClass;
use App\Models\STM\StmDivision;
use App\Models\HRM\HrmAttendance;

class AttendanceReportController extends Controller
{
    public function index(Request $request)
{
    $classes = StmClass::all();
    $divisions = \App\Models\STM\StmDivision::all();

    $reports = [];

    if ($request->filled('date') && $request->filled('class_id') && $request->filled('division_id')) {
        $date = $request->date;
        $classId = $request->class_id;
        $divisionId = $request->division_id;

        $reports = StmStudent::query()
            ->select(
                'stm_students.id as student_id',
                'stm_students._roll_no as student_roll',
                'stm_students._name_in_english as student_name',
                'stm_classes._name as class_name',
                'stm_divisions._name as division_name',
                'hrm_attendances._datetime as date',
                'hrm_attendances.in_time',
                'hrm_attendances.out_time',
                'hrm_attendances.remarks'
            )
            ->join('stm_classes', 'stm_classes.id', '=', 'stm_students._current_class_id')
            ->join('stm_divisions', 'stm_divisions.id', '=', 'stm_students._education_type')
            ->leftJoin('hrm_attendances', function($join) use ($date) {
                $join->on('stm_students._proximity_card_no', '=', 'hrm_attendances._emp_id')
                    ->whereDate('hrm_attendances._datetime', '=', $date);
            })
            ->where('stm_students._current_class_id', $classId)
            ->where('stm_students._education_type', $divisionId)
            ->orderBy('stm_students._roll_no')
            ->get();
    }

    return view('stm.report.datewiseattendance', compact('classes', 'divisions', 'reports'));
}

}
