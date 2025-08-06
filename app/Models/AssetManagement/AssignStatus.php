<?php

namespace App\Models\AssetManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignStatus extends Model
{
    use HasFactory;  
    protected $table="assign_statuses";
     protected $fillable=['id', 'code', 'name', 'description', 'status', 'is_delete', 'order', 'created_at', 'updated_at'];

}
