<?php

namespace App\Models\AssetManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetSales extends Model
{
    use HasFactory;


    public function  _asset(){
        return $this->hasOne(AssetItem::class,'id','_asset_id')->select('id', 'name',  'asset_code', 'model_no', 'serial_no', 'group_serial_no','asset_tag','purchase_price','evaluated_price','extra_cost','accumulated_dep_val','book_value','_selling_value','_pl_amount');
    }

    public function  _asset_customer(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','_asset_customer_id')->select('id','_account_group_id','_account_head_id','_name','_balance','_alious');
    }

    public function  asset_ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','asset_ledger_id')->select('id','_account_group_id','_account_head_id','_name','_balance','_alious');
    }
    public function  asset_acc_dep_ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','asset_dep_ledger_id')->select('id','_account_group_id','_account_head_id','_name','_balance','_alious');
    }
    public function  asset_dep_exp_ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','asset_dep_exp_ledger_id')->select('id','_account_group_id','_account_head_id','_name','_balance','_alious');
    }
    public function  gain_or_loss_ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','gain_or_loss_ledger_id')->select('id','_account_group_id','_account_head_id','_name','_balance','_alious');
    }

  

    public function  _payment_receive(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','_payment_receive_id')->select('id','_account_group_id','_account_head_id','_name','_balance','_alious');
    }

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
