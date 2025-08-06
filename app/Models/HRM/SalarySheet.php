<?php

namespace App\Models\HRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalarySheet extends Model
{
    use HasFactory;
     protected $table = 'salary_sheets';
     protected $fillable=['id', '_month', '_year', 'organization_id', '_branch_id', '_cost_center_id', 'voucher_id', 'voucher_code', '_date', 'salary_amount', 'allowance_amount', 'deduction_amount', 'net_payable_amount', '_note', 'approve_by_1', 'approve_by_2', 'approve_by_3', 'approve_by_4', '_user_id', '_user_name', '_created_by', '_updated_by', '_status', '_lock', '_is_posting', 'is_delete', 'created_at', 'updated_at'];


    public function _master_cost_center(){
        return $this->hasOne(\App\Models\CostCenter::class,'id','_cost_center_id')->select('id','_name');
    }
    public function _organization(){
        return $this->hasOne(\App\Models\HRM\Company::class,'id','organization_id')->select('id','_name');
    }

    public function _master_branch(){
        return $this->hasOne(\App\Models\Branch::class,'id','_branch_id')->select('id','_name');
    }









}
