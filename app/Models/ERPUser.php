<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ERPUser extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];

    protected $table="users_erp";


    public function _designation(){
        return $this->hasOne(\App\Models\HRM\Designation::class,'id','designation');
    }
}
