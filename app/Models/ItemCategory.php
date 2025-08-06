<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ItemCategory extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];

    public function _parents(){
    	return $this->hasOne(ItemCategory::class,'id','_parent_id')->with(['_parents']);
    }
    public function _prvious_par_cat(){
        return $this->hasOne(ItemCategory::class,'id','_parent_id')->with(['_parents']);
    }
    public function _childs(){
        return $this->hasMany(ItemCategory::class,'_parent_id','id')->with(['_parents','_childs']);
    }

    public function _cat_wise_item_count(){
        return $this->hasMany(Inventory::class,'_category_id','id')->select('id');
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
