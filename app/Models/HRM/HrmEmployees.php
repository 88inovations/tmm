<?php

namespace App\Models\HRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HRM\CurrentSalaryStructure;
use App\Models\HRM\HrmPayheads;
use App\Models\HRM\HrmEducation;
use App\Models\HRM\HrmEmergency;
use App\Models\HRM\HrmEmpaddress;
use App\Models\HRM\HrmExperience;
use App\Models\HRM\HrmGuarantor;
use App\Models\HRM\HrmJobcontract;
use App\Models\HRM\HrmNominee;
use App\Models\HRM\HrmReward;
use App\Models\HRM\HrmTraining;
use App\Models\HRM\HrmTransfer;
use App\Models\HRM\HrmVacancies;
use App\Models\HRM\HrmLanguage;


use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class HrmEmployees extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];

    //HrmEmpCategory

    protected $table="hrm_employees";




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
public function _emp_location(){
    return $this->hasOne(HrmEmpLocation::class,'id','_location')->select('id','_name');
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

//_hrm_education
public function _hrm_education(){
    return $this->hasMany(HrmEducation::class,'_employee_id','id')->where('_status',1);
}
//hrm_emergencies
public function hrm_emergencies(){
    return $this->hasMany(HrmEmergency::class,'_employee_id','id')->where('_status',1);
}

//hrm_empaddresses
public function hrm_empaddresses(){
    return $this->hasMany(HrmEmpaddress::class,'_employee_id','id')->where('_status',1);
}

//_details // AS SAlary Details
public function _details(){
    return $this->hasMany(CurrentSalaryStructure::class,'_employee_id','id')->where('_status',1);
}

//_details // AS SAlary Details
public function _basic_salary_master(){
    return $this->hasOne(CurrentSalaryMaster::class,'_employee_id','id')->where('_status',1);
}

//hrm_experiences 
public function hrm_experiences(){
    return $this->hasMany(HrmExperience::class,'_employee_id','id')->where('_status',1);
}
//_hrm_guarantors 
public function _hrm_guarantors(){
    return $this->hasMany(HrmGuarantor::class,'_employee_id','id')->where('_status',1);
}


//_hrm_languages 
public function _hrm_languages(){
    return $this->hasMany(HrmLanguage::class,'_employee_id','id')->where('_status',1);
}

//hrm_nominees  //HasOne
public function hrm_nominees(){
    return $this->hasOne(HrmNominee::class,'_employee_id','id')->where('_status',1);
}
//_hrm_rewards  
public function _hrm_rewards(){
    return $this->hasMany(HrmReward::class,'_employee_id','id')->where('_status',1);
}
//_hrm_trainings  
public function _hrm_trainings(){
    return $this->hasMany(HrmTraining::class,'_employee_id','id')->where('_status',1);
}
//_hrm_transfers  
public function _hrm_transfers(){
    return $this->hasMany(HrmTransfer::class,'_employee_id','id')->where('_status',1);
}
//hrm_jobcontracts  
public function hrm_jobcontracts(){
    return $this->hasOne(HrmJobcontract::class,'_employee_id','id')->where('_status',1)->orderBy('id','DESC');
}





}
