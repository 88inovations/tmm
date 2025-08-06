<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Zone extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];


    public function _master_branch(){
        return $this->hasOne(Branch::class,'id','_branch_id')->select('id','_name');
    }

    public function _organization(){
        return $this->hasOne(\App\Models\HRM\Company::class,'id','organization_id')->select('id','_name');
    }

    public function _entry_by(){
        return $this->hasOne(User::class,'id','_user_id')->select('id','name','email');
    }
}
