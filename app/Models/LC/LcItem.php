<?php

namespace App\Models\LC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LcItem extends Model
{
    use HasFactory;

     protected $fillable = [
        'id', 'lc_master_id', '_item_id', '_item_name', '_item_code', '_unit_conversion', '_transection_unit', '_base_unit', '_base_rate', '_qty', '_category_id', '_short_note', 'item_quantity', '_rate', '_foreign_rate', '_foreign_amount', '_value', '_barcode', '_hs_code', '_hs_code_2', 'hs_code2', 'organization_id', '_cost_center_id', '_branch_id', 'weight_avg', '_status', 'created_at', 'updated_at'
    ];


   public function _items(){
      return $this->hasOne(\App\Models\Inventory::class,'id','_item_id')
      ->select('id','_item as _name','_unit_id','_unique_barcode','_pur_rate','_barcode','_pack_size_id','_code')
      ->with(['_units','_pack_size','unit_conversion']);
    }

     public function unit_conversion(){
        return $this->hasMany(\App\Models\UnitConversion::class,'_item_id','_item_id')->where('_status',1);
    }
}




