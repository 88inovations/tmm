<?php

namespace App\Models\RLP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RlpMaster extends Model
{
    use HasFactory;

    public function _item_detail(){
        return $this->hasMany(RlpDetail::class,'rlp_info_id','id')->with(['_items','_supplier'])->where('_status',1);
    }

    public function _account_detail(){
        return $this->hasMany(RlpAccountDetail::class,'rlp_info_id','id')->with(['_ledger'])->where('_status',1);
    }

    public function _rlp_remarks(){
        return $this->hasMany(RlpRemarks::class,'rlp_info_id','id')->with(['_employee'])->where('_status',1);
    }

    public function _rlp_ack(){
        return $this->hasMany(RlpAcknowledgement::class,'rlp_info_id','id')->with(['_employee','_check_group'])->where('_status',1);
    }
    public function _rlp_ack_app(){
        return $this->hasMany(RlpAcknowledgement::class,'rlp_info_id','id')->with(['_employee','_check_group'])->where('_status',1)->where('ack_status',1);
    }

    public function _rlp_req_user(){
        return $this->hasOne(\App\Models\HRM\HrmEmployees::class,'id','rlp_user_id');
    }

    public function _emp_department(){
    return $this->hasOne(\App\Models\HRM\HrmDepartment::class,'id','request_department')->select('id','_department as _name');
    }
    public function _emp_designation(){
        return $this->hasOne(\App\Models\HRM\Designation::class,'id','designation')->select('id','_name');
    }
     public function _branch(){
            return $this->hasOne(\App\Models\Branch::class,'id','_branch_id')->select('id','_name');
    }
     public function _cost_center(){
            return $this->hasOne(\App\Models\CostCenter::class,'id','_cost_center_id')->select('id','_name');
    }
    public function _organization(){
            return $this->hasOne(\App\Models\HRM\Company::class,'id','organization_id')->select('id','_name');
    }

    public function _entry_by(){
        return $this->hasOne(\App\Models\User::class,'id','created_by')->select('id','name', 'user_name', 'email', 'image', 'user_type', 'organization_ids', 'branch_ids', 'cost_center_ids', 'store_ids', 'ref_id',  'status', '_ac_type');
    }
}


