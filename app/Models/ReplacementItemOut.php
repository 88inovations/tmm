<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ReplacementItemOut extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];

    public function _items(){
    	return $this->hasOne(ProductPriceList::class,'id','_p_p_l_id')->select('id','_item as _name','_qty','_item_id','_unique_barcode');
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
}
