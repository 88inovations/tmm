<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class CostCenterAuthorisedChain extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];


    public function erp_user_detail(){
        return $this->hasOne(ERPUser::class,'office_id','erp_user_id')->with(['_designation']);
    }
}
