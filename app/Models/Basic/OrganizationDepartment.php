<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationDepartment extends Model
{
    use HasFactory;
     protected $table="organization_departments";
     public function _department(){
        return $this->hasOne(\App\Models\Basic\Department::class,'id','department_id');
    }
}
