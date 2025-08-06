<?php

namespace App\Models\AssetManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetImportCostDetail extends Model
{
    use HasFactory;


    public function _unit(){
        return $this->hasOne(\App\Models\Units::class,'id','_unit_id');
    }

    public function _items(){
        return $this->hasOne(\App\Models\Inventory::class,'id','_item_id')->with(['_units']);
    }

    public function _asset_ledger(){
        return $this->hasOne(\App\Models\ItemCategory::class,'id','_asset_category_id');
    }

    
}
