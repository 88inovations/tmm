<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $table="divisions";

    protected $fillable = ['id', 'name', 'bn_name', 'lat', 'long', 'created_at', 'updated_at'];


    public function _division_to_district(){
        return $this->hasMany(\App\Models\District::class,'division_id','id');
    }
}


