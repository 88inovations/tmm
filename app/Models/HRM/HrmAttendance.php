<?php

namespace App\Models\HRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;


class HrmAttendance extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    protected $table="hrm_attendances";
    protected $guarded = [];

    public function _employee_info(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','_employee_id');
    }

    public function _entry_by(){
        return $this->hasOne(\App\Models\User::class,'id','_user_id');
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
