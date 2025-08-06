<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class MusakFourPointThree extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];

    public function _items(){
    	return $this->hasOne(Inventory::class,'id','_item_id')->select('id','_item as _name','_unit_id','_unique_barcode','_code')->with(['_units']);
    }

   

    public function _responsiable_per(){
        return $this->hasOne(AccountLedger::class,'id','_responsible_person')->select('id','_account_group_id','_account_head_id','_name','_balance');
    } 

public function input_detail(){
	return $this->hasMany(MusakFourPointThreeInput::class,'_no','id')->with(['_input_item'])->where('_last_edition',1);
}
public function addition_detail(){
	return $this->hasMany(MusakFourPointThreeAddition::class,'_no','id')->with(['_addition_ledger'])->where('_last_edition',1);
}



    
}
