<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class DirectProduction extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];

      public function _stock_in(){
        return $this->hasMany(DirectProductionFinisGoods::class,'_no','id')->with(['_items','_units','_trans_unit','unit_conversion'])->where('_status',1);
    }


    public function _stock_out(){
        return $this->hasMany(DirectProductionRowGoods::class,'_no','id')->with(['_items','_units','_trans_unit','unit_conversion'])->where('_status',1);
    }

    public function _master_details(){
        return $this->hasMany(DirectProductionFinisGoods::class,'_no','id')->with(['_items','_units','_trans_unit','unit_conversion','_lot_product'])->where('_status',1);
    }

     public function _master_cost_center(){
        return $this->hasOne(CostCenter::class,'id','_cost_center_id')->select('id','_name');
    }
   public function _organization(){
        return $this->hasOne(\App\Models\HRM\Company::class,'id','organization_id')->select('id','_name');
    }
    public function _master_branch(){
        return $this->hasOne(Branch::class,'id','_branch_id')->select('id','_name');
    }
    
}
