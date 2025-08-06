<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class SalesDetail extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];

    public function _items(){
    	return $this->hasOne(ProductPriceList::class,'id','_p_p_l_id')->with(['_units','_sales_items'])
        ->select('id','_item as _name','_qty','_item_id','_unique_barcode','_unit_id','_barcode');
    }

    public function master_data(){
        return $this->hasOne(Sales::class,'id','_no');
    }

    public function _items_inv(){
        return $this->hasOne(Inventory::class,'id','_item_id')->with(['_units','_pack_size','unit_conversion','_brands','_category']);
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

    public function _warrant(){
        return $this->hasOne(Warranty::class,'id','_warranty')->select('id','_name');
    }

      public function _units(){
        return $this->hasOne(Units::class,'id','_base_unit')->select('id','_name','_code');
    }
    public function _trans_unit(){
        return $this->hasOne(Units::class,'id','_transection_unit')->select('id','_name','_code');
    }

 public function unit_conversion(){
       return $this->hasMany(UnitConversion::class,'_item_id','_item_id')->where('_status',1);
    }

    // public function _p_p_l(){
    // 	return $this->hasOne(ProductPriceList::class,'id','_p_p_l_id')->select('_qty');
    // }
}
