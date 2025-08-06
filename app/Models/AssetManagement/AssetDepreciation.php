<?php

namespace App\Models\AssetManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetDepreciation extends Model
{
    use HasFactory;

    protected $table="asset_depreciations";

    public function asset_dep_detail(){
        return $this->hasMany(AssetDepreciationDetail::class,'_no','id')->with(['_asset_item','_asset_ledger','_asset_dep_ledger','_asset_dep_exp_ledger']);
    }
}


