<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesCommisionPlan extends Model
{
    use HasFactory;

    public function _detail(){
        return $this->hasMany(SalesCommisionPlanDetail::class,'_no','id')->where('_status',1);
    }

    public function _organization(){
        return $this->hasOne(\App\Models\HRM\Company::class,'id','organization_id')->select('id','_name');
    }
}
