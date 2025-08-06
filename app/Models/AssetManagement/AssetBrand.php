<?php

namespace App\Models\AssetManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetBrand extends Model
{
    use HasFactory;
    protected $table="item_brands";
     protected $fillable=['id', '_name', '_code', '_detail', '_status', 'created_at', 'updated_at'];
}


