<?php

namespace App\Models\HRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;


class CurrentSalaryMaster extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $table="current_salary_masters";
    protected $guarded = [];
    protected $fillable=['_employee_id', '_employee_ledger_id', '_emp_code', 'total_earnings', 'total_deduction', 'net_total_earning', '_status', '_is_delete'];


    public function _employee(){
        return $this->hasOne(\App\Models\HRM\HrmEmployees::class,'id','_employee_id')->with(['_organization','_branch','_cost_center','_employee_cat','_emp_department','_emp_designation','_emp_grade','_emp_location']);
    }

    public function _details(){
        return $this->hasMany(CurrentSalaryStructure::class,'_master_id','id')->with(['_payhead','_payhead_type']);
    }

}


