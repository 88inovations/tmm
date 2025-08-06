<?php

namespace App\Models\AssetManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionCheckList extends Model
{
    use HasFactory;
    protected $table="inspection_check_lists";
    protected $fillable=['id','ins_category_id', 'name', 'code', 'description', 'status', 'is_delete', 'order', 'created_at', 'updated_at']; 

    public function ins_category(){
        return $this->hasOne(InspectionCheckCategory::class,'id','ins_category_id');
    }
}

