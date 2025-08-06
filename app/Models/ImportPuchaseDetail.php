<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportPuchaseDetail extends Model
{
    use HasFactory;
    public function _items(){
        return $this->hasOne(Inventory::class,'id','_item_id')->select('id','_item as _name','_unit_id','_unique_barcode','_pur_rate')->with(['_units']);
    }

     public function _trans_unit(){
        return $this->hasOne(Units::class,'id','_transection_unit')->select('id','_name');
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
    public function _lot_product(){
      return $this->hasOne(ProductPriceList::class,'_purchase_detail_id','id')->where('_input_type','purchase')
      ->select('id','_item_id','_purchase_detail_id');
    }

    public function _lot_product_history(){
      return $this->hasOne(ProductPriceList::class,'_purchase_detail_id','id')->with(['_lot_wise_sales_details','_lot_wise_sales_return_details']);
    }

    public function _purchase_barcode(){
        return $this->hasMany(PurchaseBarcode::class,'_no_detail_id','id');
    }

    public function _purchase_master(){
        return $this->hasOne(Purchase::class,'id','_no')->with(['_ledger']);
    }

    public function _purchase_return_details(){
        return $this->hasMany(PurchaseReturnDetail::class,'_purchase_detal_ref','id')->with(['_purchase_return_barcodes','_purchase_return_master']);
    }
}
