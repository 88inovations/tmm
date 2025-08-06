<?php

namespace App\Models\AssetManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionCheckCategory extends Model
{
    use HasFactory;
    protected $table="inspection_check_categories";
    protected $fillable=['id', 'name', 'code', 'description', 'status', 'is_delete', 'order', 'created_at', 'updated_at']; 

    public function check_list(){
        return $this->hasMany(InspectionCheckList::class,'ins_category_id','id');
    }
}
