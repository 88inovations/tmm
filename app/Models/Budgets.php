<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Budgets extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    protected $guarded = [];
    protected $table="budgets";
    protected $fillable=['id', 'organization_id', '_cost_center_id', '_branch_id', '_start_date', '_end_date', 'budget_amount', '_remarks', '_status', '_is_delete', '_created_by', '_user_name', 'created_at', 'updated_at','_material_amount','_income_amount','_expense_amount'];

    public function _budget_details(){
        return $this->hasMany(BudgetDetail::class,'_budget_id','id')->with(['_ledger'])->where('_status',1);
    }

    public function _customer_ledger(){
        return $this->hasOne(AccountLedger::class,'id','_customer_id')->select('id','_account_group_id','_account_head_id','_name','_balance','_alious');
    }

    public function _budget_details_income(){
        return $this->hasMany(BudgetDetail::class,'_budget_id','id')->with(['_ledger'])->where('_status',1)->where('_ledger_type','income');
    }

    public function _budget_details_expense(){
        return $this->hasMany(BudgetDetail::class,'_budget_id','id')->with(['_ledger'])->where('_status',1)->where('_ledger_type','expense');
    }
    public function _budget_details_deduction(){
        return $this->hasMany(BudgetDetail::class,'_budget_id','id')->with(['_ledger'])->where('_status',1)->where('_ledger_type','deduction');
    }
    public function _budget_details_expense_deduction(){
        return $this->hasMany(BudgetDetail::class,'_budget_id','id')->with(['_ledger'])->where('_status',1)->whereIn('_ledger_type',['expense','deduction']);
    }


    public function _budget_item_details(){
        return $this->hasMany(BudgetItemDetail::class,'_budget_id','id')->with(['_item'])->where('_status',1);
    }

    public function _master_branch(){
        return $this->hasOne(Branch::class,'id','_branch_id')->select('id','_name');
    }
   public function _master_cost_center(){
        return $this->hasOne(CostCenter::class,'id','_cost_center_id')->select('id','_name');
    }
   public function _organization(){
        return $this->hasOne(\App\Models\HRM\Company::class,'id','organization_id')->select('id','_name');
    }

    public function budget_authorised_order(){
        return $this->hasMany(CostCenterAuthorisedChain::class,'_cost_center_id','_cost_center_id')->with(['erp_user_detail'])->where('_status',1);
    }

    
}


