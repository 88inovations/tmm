<?php

namespace App\Models\AssetManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetsUser extends Model
{
    use HasFactory;
    protected $table="hrm_employees";
    protected $fillable=['id', '_code', '_photo', '_signature', '_name', '_father', '_mother', '_spouse', '_mobile1', '_mobile2', '_profitcenter_id', '_spousesmobile', '_nid', '_gender', '_bloodgroup', '_religion', '_dob', 'doj', '_education', '_email', '_jobtitle_id', '_department_id', '_category_id', '_grade_id', '_location', '_officedes', '_bank', '_bankac', '_tradeing_id', '_project_id', '_cost_center_id', '_branch_id', 'organization_id', '_zone_id', '_gross_salary', '_active', '_status', '_doj', '_tin', '_user', '_ledger_id', 'user_id', 'created_at', 'updated_at', '_created_by', '_updated_by'];
    public function organization(){
        return $this->hasOne(\App\Models\Basic\Organization::class,'id','organization_id');
    }
    
    public function branch(){
        return $this->hasOne(\App\Models\Basic\Branch::class,'id','_branch_id');
    }
    public function department(){
        return $this->hasOne(\App\Models\Basic\Department::class,'id','_department_id');
    }
    public function designation(){
        return $this->hasOne(\App\Models\Basic\Designation::class,'id','_jobtitle_id');
    }
}




