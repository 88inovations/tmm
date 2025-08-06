<?php

namespace App\Models\AssetManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetAssign extends Model
{
    use HasFactory;

    public function organization(){
        return $this->hasOne(\App\Models\Basic\Organization::class,'id','organization_id');
    }
    public function branch(){
        return $this->hasOne(\App\Models\Basic\Branch::class,'id','branch_id');
    }
    public function department(){
        return $this->hasOne(\App\Models\Basic\Department::class,'id','dept_id');
    }
    public function cost_center(){
        return $this->hasOne(\App\Models\Basic\CostCenter::class,'id','project_id');
    }
    public function building(){
        return $this->hasOne(\App\Models\AssetManagement\AssetsLocation::class,'id','asset_location_id');
    }
    public function room(){
        return $this->hasOne(\App\Models\AssetManagement\AssetsDeviceLocation::class,'id','asset_room_id');
    }

    public function _user(){
        return $this->hasOne(\App\Models\AssetManagement\AssetsUser::class,'id','asset_user_id');
    }
}
