<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VesselInfo extends Model
{
    use HasFactory;
    protected $table='vessel_infos';
    protected $fillable=['id', '_name', '_code', '_license_no', '_country_name', '_type', '_route', '_owner_name', '_contact_one', '_contact_two', '_contact_three', '_capacity', '_status', 'created_at', 'updated_at'];
}


