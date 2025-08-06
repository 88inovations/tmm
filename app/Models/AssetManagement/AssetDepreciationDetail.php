<?php

namespace App\Models\AssetManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetDepreciationDetail extends Model
{
    use HasFactory;

    public function _asset_item(){
        return $this->hasOne(AssetItem::class,'id','_asset_id'); 
    }


    public function _asset_ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','asset_ledger_id')->select('id','_account_group_id','_account_head_id','_name','_balance','_alious','_phone', '_address', '_credit_limit', '_balance');
    }


    public function _asset_dep_ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','asset_dep_ledger_id')->select('id','_account_group_id','_account_head_id','_name','_balance','_alious','_phone', '_address', '_credit_limit', '_balance');
    }

    public function _asset_dep_exp_ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','asset_dep_exp_ledger_id')->select('id','_account_group_id','_account_head_id','_name','_balance','_alious','_phone', '_address', '_credit_limit', '_balance');
    }





}
