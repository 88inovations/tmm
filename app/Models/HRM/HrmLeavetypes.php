<?php

namespace App\Models\HRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class HrmLeavetypes extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];

     public function _entry_by(){
    	return $this->hasOne(User::class,'id','_user')->select('id','name','email');
    }
}
