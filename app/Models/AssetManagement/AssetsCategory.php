<?php

namespace App\Models\AssetManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetsCategory extends Model
{
    use HasFactory;
     protected $table="item_categories";
     
    // protected $fillable=['id', 'name', 'ledger_id', 'code', 'parent_id', 'description', 'status', 'is_delete', 'order', 'image', 'is_featured', 'created_at', 'updated_at'];
    protected $fillable=[
    'id', '_parent_id', '_name', '_image', '_description', '_status', 'created_at', 'updated_at', '_code', 'asset_ledger_id', 'asset_dep_ledger_id', 'asset_dep_exp_ledger_id', 'dep_rate'];


    public function children()
    {
        return $this->hasMany(AssetsCategory::class, 'parent_id')->where('is_delete',0);
    }


    public function category_ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','asset_ledger_id'); // Asset Category
    }

    public function dep_exp_category_ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','asset_dep_exp_ledger_id'); //Depreciation Expenses
    }


    public function acc_dep_category_ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','asset_dep_ledger_id'); //Accumulated Deprericiation Expenses
    }
    
}


