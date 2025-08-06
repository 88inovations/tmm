<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PurchaseOrderDetail extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];
    

     public function _items(){
    	return $this->hasOne(Inventory::class,'id','_item_id')
         ->select('id','_item as _name','_unit_id','_unique_barcode','_pack_size_id','_pur_rate','_sale_rate','_barcode','_code','_hs_code','_hs_code_2')
        ->with(['_units','unit_conversion','_pack_size']);
    }

    public function _trans_unit(){
        return $this->hasOne(Units::class,'id','_transection_unit')->select('id','_name');
    }


     public function _detail_branch(){
    	return $this->hasOne(Branch::class,'id','_branch_id')->select('id','_name');
    }

    public function _detail_cost_center(){
    	return $this->hasOne(CostCenter::class,'id','_cost_center_id')->select('id','_name');
    }
    public function _detail_organizaton(){
        return $this->hasOne(\App\Models\HRM\Company::class,'id','organization_id')->select('id','_name');
    }

    public function _store(){
    	return $this->hasOne(StoreHouse::class,'id','_store_id')->select('id','_name');
    }
}
