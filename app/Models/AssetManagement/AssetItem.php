<?php

namespace App\Models\AssetManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetItem extends Model
{
    use HasFactory;
    protected $table="asset_items";

     protected $fillable = [
        'id', '_item_id', 'name', 'category_id', 'asset_ledger_id', 'asset_dep_ledger_id', 'asset_dep_exp_ledger_id', 'brand_id', 'vendor_id', 'asset_condition_id', 'assign_status_id', 'organization_id', 'branch_id', 'project_id', 'asset_location_id', 'asset_room_id', 'asset_code', 'model_no', 'serial_no', 'group_serial_no', 'domain_intune', 'asset_image_1', 'asset_image_2', 'warranty_start_date', 'warranty_end_date', 'warranty_status', 'os_type', 'import_cost_detail_id', '_p_p_id', '_from_table', 'purchase_date', '_date', 'year_manufacture', 'origin', 'purchase_voucher_no', 'voucher_id', 'dep_date', 'purchase_price', 'extra_cost', 'entry_price', 'evaluated_price', 'dep_type', 'dep_rate', 'dep_value', 'insured_amount', 'annual_benefit', 'utilization_rate', 'risk_level', 'service_agreement_expiry', 'compliance_status', 'accumulated_dep_val', 'book_value', '_selling_value', '_pl_amount', '_sale_date', 'estimated_life', 'asset_tag', 'description', 'remarks', 'status', '_is_sold', 'is_delete', 'order', 'created_at', 'updated_at'
    ];

    



     protected static function boot()
    {
        parent::boot();

        // Before creating a new asset, generate the asset code
        static::creating(function ($asset) {
            $asset->asset_code = $asset->generateAssetCode();
        });
    }


    public function generateAssetCode()
    {
        // Get category code
        $categoryCode = \DB::table('item_categories')
            ->where('id', $this->category_id)
            ->value('_code') ?? 'CAT';

        // Get company code
        $companyCode = \DB::table('companies')
            ->where('id', $this->organization_id)
            ->value('_code') ?? 'COMP';

        // Get branch code
        $branchCode = \DB::table('branches')
            ->where('id', $this->branch_id)
            ->value('_code') ?? 'BR';

        // Get the current year
        $year = date('y');

        // Get the next ID (since this record hasn't been inserted yet)
        $nextId = self::max('id') + 1; 
        $paddedId = str_pad($nextId, 4, '0', STR_PAD_LEFT);

        // Generate the asset code
        return "{$categoryCode}-{$paddedId}";
    }
    

    

    public function category(){
        return $this->hasOne(\App\Models\ItemCategory::class,'id','category_id');
    }


    public function category_ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','asset_ledger_id'); // Asset Category
    }

    public function dep_exp_category_ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','asset_dep_exp_ledger_id'); //Depreciation Expenses
    }


    public function acc_dep_category_ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','asset_dep_ledger_id'); //Accumulated Deprericiation Expenses
    }

    

    public function organization(){
        return $this->hasOne(\App\Models\Basic\Organization::class,'id','organization_id');
    }

    public function branch(){
        return $this->hasOne(\App\Models\Basic\Branch::class,'id','branch_id');
    }

    public function cost_center(){
        return $this->hasOne(\App\Models\Basic\CostCenter::class,'id','project_id');
    }

   
    public function building(){
        return $this->hasOne(\App\Models\AssetManagement\AssetsLocation::class,'id','asset_location_id');
    }


    public function asset_room(){
        return $this->hasOne(\App\Models\AssetManagement\AssetsDeviceLocation::class,'id','asset_room_id');
    }


    public function brand(){
        return $this->hasOne(\App\Models\ItemBrand::class,'id','brand_id');
    }


    public function condition(){
        return $this->hasOne(AssetsCondition::class,'id','asset_condition_id')->select('id','name');
    }
    

    public function vendor(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','vendor_id')
                        ->select( 'id', '_main_account_id', '_acc_head_pl3_id', '_acc_head_pl2_id', '_account_group_id', '_account_head_id', '_name', '_name as name','_alious', '_code',  '_nid', '_other_document', '_email', '_phone', '_address', '_credit_limit', '_balance');


    }
    public function current_user(){
        return $this->hasOne(AssetAssign::class,'asset_item_id','id')->with(['organization','branch','department','cost_center','building','room','_user'])->where('is_delete',0);

    }
   
    public function assign_status(){
        return $this->hasOne(AssignStatus::class,'id','assign_status_id')->where('status',1)->where('is_delete',0);
    }

    public function _inspections(){
        return $this->hasMany(AssetInspection::class,'asset_id','id')->where('status',1)->where('is_delete',0);
    }


     public function _asset_ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','asset_ledger_id')->select('id','_account_group_id','_account_head_id','_name','_balance','_alious','_phone', '_address', '_credit_limit', '_balance');
    }


    public function _asset_dep_ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','asset_dep_ledger_id')->select('id','_account_group_id','_account_head_id','_name','_balance','_alious','_phone', '_address', '_credit_limit', '_balance');
    }

    public function _asset_dep_exp_ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','asset_dep_exp_ledger_id')->select('id','_account_group_id','_account_head_id','_name','_balance','_alious','_phone', '_address', '_credit_limit', '_balance');
    }


   
}
