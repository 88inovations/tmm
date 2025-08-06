<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
     protected $table="districts";

    protected $fillable = ['id', 'division_id', 'name', 'bn_name', 'lat', 'long', 'created_at', 'updated_at'];


    public function _district_to_upazila(){
        return $this->hasMany(\App\Models\Upazilla::class,'district_id','id');
    }
}


