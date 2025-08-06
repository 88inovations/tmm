<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $table="companies";
    protected $fillable=['_code','_name','_details','_status','_user','logo','phone','address','description','status','is_delete','order','created_at','updated_at'];


    public function _org_branches(){
        return $this->hasMany(OrganizationBranch::class,'organization_id','id')->with(['_branch']);
    }

    public function _org_cost_centers(){
        return $this->hasMany(OrganizationCostCenter::class,'organization_id','id')->with(['_cost_center']);
    }
    public function _org_departments(){
        return $this->hasMany(OrganizationDepartment::class,'organization_id','id')->with(['_department']);
    }
    public function _org_designations(){
        return $this->hasMany(OrganizationDesignation::class,'organization_id','id')->with(['_designation']);
    }
    public function _org_stores(){
        return $this->hasMany(OrganizationStore::class,'organization_id','id')->with(['_store']);
    }
}


