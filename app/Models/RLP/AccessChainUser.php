<?php

namespace App\Models\RLP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessChainUser extends Model
{
    use HasFactory;

    protected $table="rlp_access_chain_users";
    protected $fillable=['id', 'chain_id','user_group','user_row_id', 'user_id', '_order', '_status', 'created_at', 'updated_at'];

    
     public function _user_group(){
                return $this->hasOne(\App\Models\RLP\RlpUserGroup::class,'id','user_group');
    }

    public function _user_info(){
        return $this->hasOne(\App\Models\HRM\HrmEmployees::class,'id','user_row_id')->select('id','_code','_name');
    }

}
