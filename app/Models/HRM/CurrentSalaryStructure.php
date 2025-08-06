<?php

namespace App\Models\HRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;


class CurrentSalaryStructure extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $table="current_salary_structures";
    protected $guarded = [];

    public function _payhead(){
        return $this->hasOne(HrmPayheads::class,'id','_payhead_id')->with(['_payhead_type']);
    }
    public function _payhead_type(){
        return $this->hasOne(HrmPayHeadType::class,'id','_payhead_type_id');
    }
}
