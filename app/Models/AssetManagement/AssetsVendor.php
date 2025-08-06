<?php

namespace App\Models\AssetManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetsVendor extends Model
{
    use HasFactory;
    protected $table="assets_vendors";
     protected $fillable=['id', 'code','logo', 'group_id', 'ledger_id', 'name', 'phone', 'address', 'description', 'status', 'is_delete', 'order', 'created_at', 'updated_at'];
}
