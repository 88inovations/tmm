<?php

namespace App\Models\AssetManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetEngConsumption extends Model
{
    use HasFactory;


    public function _asset_item(){
        return $this->hasOne(AssetItem::class,'id','asset_id')
                    ->with(['category','organization','branch','cost_center','brand','vendor']);
    }

     public function _created_by(){
        return $this->hasOne(\App\Models\User::class,'id','created_by')->select('id', 'name', 'user_name', 'email',  'user_type');
    }
    public function _updated_by(){
        return $this->hasOne(\App\Models\User::class,'id','updated_by')->select('id', 'name', 'user_name', 'email',  'user_type');
    }

    // public function _voucher(){
    //     return $this->hasOne(\App\Models\VoucherMaster::class,'_code','_voucher_number')->select(`id`, `_code`, `_date`,  `_voucher_type`);
    // }

     public function organization(){
        return $this->hasOne(\App\Models\Basic\Organization::class,'id','organization_id');
    }

    public function branch(){
        return $this->hasOne(\App\Models\Basic\Branch::class,'id','_cost_center_id');
    }

    public function cost_center(){
        return $this->hasOne(\App\Models\Basic\CostCenter::class,'id','_branch_id');
    }
}







