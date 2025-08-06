<?php

namespace App\Models\AssetManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetImportCost extends Model
{
    use HasFactory;

    public function _details(){
        return $this->hasMany(AssetImportCostDetail::class,'_no','id')->with(['_unit','_asset_ledger','_items'])->where('_status',1);
    }


    public function _cost_account(){
        return $this->hasMany(ImportCostAccount::class,'_no','id')->with(['_ledger'])->where('_status',1);
    }

    public function _created_by(){
        return $this->hasOne(\App\Models\User::class,'id','created_by')->select('id', 'name', 'user_name', 'email',  'user_type');
    }
    public function _updated_by(){
        return $this->hasOne(\App\Models\User::class,'id','updated_by')->select('id', 'name', 'user_name', 'email',  'user_type');
    }
}


