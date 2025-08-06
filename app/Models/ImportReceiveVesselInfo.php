<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportReceiveVesselInfo extends Model
{
    use HasFactory;

     public function _lighter_info(){
        return $this->hasOne(VesselInfo::class,'id','_vessel_no');
    }
}
