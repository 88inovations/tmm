<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class CostCenter extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];


    public function _branch()
    {
    	return $this->hasOne(Branch::class,'id','_branch_id')->select('id','_name');
    }

    public function chain(){
        return $this->hasMany(CostCenterAuthorisedChain::class,'_cost_center_id','id')->where('_status',1)->orderBy('ack_order','ASC');
    }
}
