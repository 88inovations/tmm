<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PurchaseDetail extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];

    public function _items(){
    	return $this->hasOne(Inventory::class,'id','_item_id')->select('id','_item as _name','_unit_id','_unique_barcode','_pur_rate','_barcode','_pack_size_id','_code')->with(['_units','_pack_size']);
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

    public function _store(){
    	return $this->hasOne(StoreHouse::class,'id','_store_id')->select('id','_name');
    }
    public function _lot_product(){
      return $this->hasOne(ProductPriceList::class,'_purchase_detail_id','id')->where('_input_type','purchase')
      ->select('id','_item_id','_purchase_detail_id');
    }
    
}
