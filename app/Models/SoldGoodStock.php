<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoldGoodStock extends Model
{
    use HasFactory;

    protected $table="sold_item_stock";
    protected $fillable=['id', '_item_id', '_category_id', '_brand_id', '_pack_size_id', '_base_unit', '_transection_unit', '_unit_conversion', '_item', '_input_type', '_barcode', '_manufacture_date', '_expire_date', '_qty', '_sales_rate', '_pur_rate', '_sales_discount', '_sales_vat', '_value', '_unit_id', '_p_discount_input', '_p_discount_amount', '_p_vat', '_p_vat_amount', '_purchase_detail_id', 'organization_id', '_branch_id', '_store_id', '_cost_center_id', '_warranty', '_master_id', '_store_salves_id', '_status', 'is_lebel_print', '_receive_type', '_unique_barcode', '_created_by', '_updated_by', 'created_at', 'updated_at', '_order_number', '_table_name', '_budget_id', '_item_category', '_transfer_to_asset', '_short_note'];


    



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


   
}
