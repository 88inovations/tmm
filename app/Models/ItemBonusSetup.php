<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ItemBonusSetup extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];

    public function _items(){
        return $this->hasOne(Inventory::class,'id','_item_id')->select('id','_item','_item as _name','_unit_id','_unique_barcode','_code','_pack_size_id','_brand_id','_category_id')->with(['_units','unit_conversion','_pack_size']);
    }

    public function _item_detail(){
        return $this->hasMany(BonusItemDetail::class,'_no','id')->with(['_items','_trans_unit']);
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

    public function _trans_unit(){
        return $this->hasOne(Units::class,'id','_transection_unit')->select('id','_name','_code');
    }
   

    

    

}
