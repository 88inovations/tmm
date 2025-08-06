<?php

namespace App\Models\LC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class LcMaster extends Model
{
    use HasFactory;

    protected $fillable = [

      'id', 'organization_id','expiry_date', '_branch_id', '_cost_center_id', '_date', 'po_no', 'lc_ip_no', 'lc_ip_date', 'amendment_date', 'bill_no', 'pi_no', 'pi_date', 'bill_of_enty_no', 'bill_of_enty_date', 'date_of_arrival', 'lc_type', 'lca_no', 'transport_type', 'partial_shipment', 'bank', 'supplier', 'cnf', 'bank_branch', 'insurance_company', 'insurance_cover_note', 'insurance_cover_date', 'lc_tt', 'currency', '_cif_value_foreign', '_cif_value_local', '_rate_to_bdt', '_local_amount', 'remark', '_note', '_is_close', '_user_id', '_user_name', '_status', 'is_delete', '_lock', '_created_by', '_updated_by', 'created_at', 'updated_at' 
    ];

    public function items()
    {
        return $this->hasMany(LcItem::class,'lc_master_id','id');
    }


    public function _bank(){

        return $this->hasOne(\App\Models\AccountLedger::class,'id','bank')
                ->select('id','_name','_account_group_id','_account_head_id')
                ->with(['account_type','account_group']);
    }
    public function _supplier(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','supplier')
                ->select('id','_name','_account_group_id','_account_head_id')
                ->with(['account_type','account_group']);
    }

    public function _cnf(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','cnf_agent')
                ->select('id','_name','_account_group_id','_account_head_id')
                ->with(['account_type','account_group']);
    }

    public function _cost_center(){
        return $this->hasOne(\App\Models\CostCenter::class,'id','_cost_center_id')->select('id','_name');
    }

    public function _organization(){
        return $this->hasOne(\App\Models\HRM\Company::class,'id','organization_id')->select('id','_name');
    }
  public function _branch(){
        return $this->hasOne(\App\Models\Branch::class,'id','_branch_id')->select('id','_name');
    }

    public function lc_amendments(){
        return $this->hasMany(\App\Models\LC\LcAmendment::class,'id','lc_master_id');
    }
    



}


