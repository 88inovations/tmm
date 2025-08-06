<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class StockIn extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];

      public function _items(){
    	return $this->hasOne(Inventory::class,'id','_item_id')->select('id','_item as _name','_unit_id','_unique_barcode','_pur_rate','_barcode')->with(['_units']);
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

    public function _lot_product(){
      return $this->hasOne(ProductPriceList::class,'_purchase_detail_id','id')->where('_input_type','production')
      ->select('id','_item_id','_purchase_detail_id');
    }
}
