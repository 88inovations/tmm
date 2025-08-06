<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class AccountHead extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];
    
    protected $table="account_heads";

    public function parent()
    {
        return $this->belongsTo(AccountHead::class, '_parent_id');
    }

    public function children()
    {
        return $this->hasMany(AccountHead::class, '_parent_id');
    }


    public function _main_account_head(){
        return $this->hasOne(MainAccountHead::class,'id','_account_id');
    }



    
    public function _account_group(){
        return $this->hasMany(AccountGroup::class,'_account_head_id','id')->with(['_main_account_head']);
    }

    public function _list_account_group(){
        return $this->hasMany(AccountGroup::class,'_account_head_id','id')->with(['_group_wise_ledger']);
    }

    public function _parent_group(){
        return $this->hasOne(AccountHead::class,'id','_parent_id');
    }

    public function _child_group(){
        return $this->hasMany(AccountHead::class,'_parent_id','id')->with(['_list_account_group']);
    }

    public function _next_level(){
        return $this->hasMany(AccountHead::class,'_parent_id','id');
    }

    public function _third_levels(){
        return $this->hasMany(AccountHead::class,'_parent_id','id')
         ->select('id','_name','_account_id','_code','_parent_id','_parent_id_second','_has_parent','_has_child','_level','_status');
    }

    public function _third_level(){
        return $this->hasOne(AccountHead::class,'_parent_id_second','id');
    }


    public function _head_wise_ledger(){
        return $this->hasMany(AccountLedger::class,'_account_head_id','id');
       
    }



}
