<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ProductPriceList extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];

    public function _items(){
    	return $this->hasOne(Inventory::class,'id','_item_id')->with(['_units','unit_conversion','_pack_size']);
    }
    public function _sales_items(){
        return $this->hasOne(Inventory::class,'id','_item_id');
    }


     public function _detail_branch(){
    	return $this->hasOne(Branch::class,'id','_branch_id')->select('id','_name');
    }

    public function _detail_cost_center(){
    	return $this->hasOne(CostCenter::class,'id','_cost_center_id')->select('id','_name');
    }

    public function _store(){
    	return $this->hasOne(StoreHouse::class,'id','_store_id')->select('id','_name');
    }

    

    public function _units(){
        return $this->hasOne(Units::class,'id','_unit_id')->select('id','_name','_code');
    }
    public function _trans_unit(){
        return $this->hasOne(Units::class,'id','_transection_unit')->select('id','_name','_code');
    }
    public function _warranty_name(){
        return $this->hasOne(Warranty::class,'id','_warranty')->select('id','_name');
    }

    public function unit_conversion(){
       return $this->hasMany(UnitConversion::class,'_item_id','_item_id')->where('_status',1);
    }

 public function _organization(){
            return $this->hasOne(\App\Models\HRM\Company::class,'id','organization_id')->select('id','_name');
    }
    public function _master_branch(){
        return $this->hasOne(Branch::class,'id','_branch_id')->select('id','_name');
    }
    public function _master_cost_center(){
            return $this->hasOne(CostCenter::class,'id','_cost_center_id')->select('id','_name');
    }
   

    public function _master_store(){
            return $this->hasOne(StoreHouse::class,'id','_store_id')->select('id','_name');
    }


    public function _import_item_detail(){
        return $this->hasOne(\App\Models\AssetManagement\AssetImportCostDetail::class,'id','_purchase_detail_id')->where('_status',1);
    }
}
