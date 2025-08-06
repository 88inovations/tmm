<?php

namespace App\Models\LC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LcItemCost extends Model
{
    use HasFactory;


   public function _items(){
      return $this->hasOne(\App\Models\Inventory::class,'id','_item_id')
      ->select('id','_item as _name','_unit_id','_unique_barcode','_pur_rate','_barcode','_pack_size_id','_code')
      ->with(['_units','_pack_size','unit_conversion']);
    }


    public function _ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','_cost_deduct_ledger_id')->select('id','_name');
    }
}
