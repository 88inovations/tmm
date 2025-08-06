<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationStore extends Model
{
    use HasFactory;
    protected $table="organization_stores";
    public function _store(){
        return $this->hasOne(\App\Models\Basic\Store::class,'id','store_id');
    }
}
