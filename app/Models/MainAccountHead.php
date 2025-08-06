<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class MainAccountHead extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];

    protected $table="main_account_head";

    public function _account_type(){
        return $this->hasMany(AccountHead::class,'_account_id','id');
    }


    public function _list_account_heads(){
        return $this->hasMany(AccountHead::class,'_account_id','id')->with(['_list_account_group','_child_group']);
    }

    public function _list_account_sub_heads(){
        return $this->hasMany(AccountHead::class,'_parent_id','id')->with(['_list_account_group']);
    }
}
