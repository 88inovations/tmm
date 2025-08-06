<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PurchaseReturnDetail extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];

      public function _items(){
    	return $this->hasOne(Inventory::class,'id','_item_id')->select('id','_item as _name','_unique_barcode','_unit_id','_pur_rate');
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

      public function _units(){
        return $this->hasOne(Units::class,'id','_base_unit')->select('id','_name','_code');
    }
    public function _trans_unit(){
        return $this->hasOne(Units::class,'id','_transection_unit')->select('id','_name','_code');
    }
    public function _warranty_name(){
        return $this->hasOne(Warranty::class,'id','_warranty')->select('id','_name');
    }

    public function unit_conversion(){
       return $this->hasMany(UnitConversion::class,'_item_id','_item_id')->where('_status',1);
    }

    public function _product_price_item(){
        return $this->hasOne(ProductPriceList::class,'_purchase_detail_id','_purchase_detal_ref')->where('_input_type','purchase');
    }
}
