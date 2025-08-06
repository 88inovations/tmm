<?php

namespace App\Models\HRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class HrmMonthlySalaryMaster extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];

    public function _employee(){
        return $this->hasOne(\App\Models\HRM\HrmEmployees::class,'id','_employee_id')->with(['_organization','_branch','_cost_center','_employee_cat','_emp_department','_emp_designation','_emp_grade','_emp_location']);
    }

    public function _details(){
        return $this->hasMany(HrmMonthlySalaryDetail::class,'_master_id','id')->with(['_payhead','_payhead_type']);
    }

    public function _employee_cat(){
    return $this->hasOne(HrmEmpCategory::class,'id','_category_id')->select('id','_name');
        }
        public function _emp_department(){
            return $this->hasOne(HrmDepartment::class,'id','_department_id')->select('id','_department as _name');
        }
        public function _emp_designation(){
            return $this->hasOne(Designation::class,'id','_jobtitle_id')->select('id','_name');
        }
        public function _emp_grade(){
            return $this->hasOne(HrmGrade::class,'id','_grade_id')->select('id','_grade as _name');
        }
        

         public function _branch(){
                return $this->hasOne(\App\Models\Branch::class,'id','_branch_id')->select('id','_name');
        }
         public function _cost_center(){
                return $this->hasOne(\App\Models\CostCenter::class,'id','_cost_center_id')->select('id','_name');
        }
        public function _organization(){
                return $this->hasOne(\App\Models\HRM\Company::class,'id','organization_id')->select('id','_name');
        }


    
}
