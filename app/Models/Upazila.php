<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upazila extends Model
{
    use HasFactory;
    protected $table="upazilas";

    protected $fillable = ['id', 'division_id', 'district_id', 'name', 'bn_name', 'lat', 'long', 'created_at', 'updated_at'];


    public function _upazila_to_postcode(){
        return $this->hasMany(\App\Models\Postcode::class,'upazila','name');
    }
}


  