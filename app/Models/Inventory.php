<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Inventory extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];


    public function _category(){
    	return $this->hasOne(ItemCategory::class,'id','_category_id')->select('id','_name','asset_ledger_id', 'asset_dep_ledger_id', 'asset_dep_exp_ledger_id', 'dep_rate');
    }

    public function _units(){
    	return $this->hasOne(Units::class,'id','_unit_id')->select('id','_name','_code');
    }

    public function _warranty_name(){
    	return $this->hasOne(Warranty::class,'id','_warranty')->select('id','_name');
    }

    public function unit_conversion(){
        return $this->hasMany(UnitConversion::class,'_item_id','id')->where('_status',1);
    }
    public function _brands(){
        return $this->hasOne(ItemBrand::class,'id','_brand_id')->where('_status',1);
    }
    public function _pack_size(){
        return $this->hasOne(ItemPackSize::class,'id','_pack_size_id')->where('_status',1);
    }
}
