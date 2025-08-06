<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationCostCenter extends Model
{
    use HasFactory;
    protected $table="organization_cost_centers";

    public function _cost_center(){
        return $this->hasOne(\App\Models\Basic\CostCenter::class,'id','cost_center_id');
    }
}
