<?php

namespace App\Models\HRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class HrmDepartment extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];


 public function _entry_by(){
    	return $this->hasOne(\App\Models\User::class,'id','_user')->select('id','name','email');
    }
}
