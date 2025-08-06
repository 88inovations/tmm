<?php

namespace App\Models\RLP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RlpRemarks extends Model
{
    use HasFactory;

    public function _employee(){
        return $this->hasOne(\App\Models\User::class,'id','user_id');
    }
}
