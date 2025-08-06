<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postcode extends Model
{
    use HasFactory;

     protected $table="postcodes";

    protected $fillable = ['id', 'division_id', 'district_id', 'upazila', 'postOffice', 'postCode',  'created_at', 'updated_at'];
}


