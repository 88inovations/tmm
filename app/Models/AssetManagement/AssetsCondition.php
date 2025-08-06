<?php

namespace App\Models\AssetManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetsCondition extends Model
{
    use HasFactory;
    protected $table="assets_conditions";
    protected $fillable=['id', 'name', 'code', 'description', 'status', 'is_delete', 'order', 'created_at', 'updated_at'];
}

