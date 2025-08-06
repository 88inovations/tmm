<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class BudgetItemDetail extends Model implements Auditable{

    use HasFactory;
    use AuditableTrait;

    protected $guarded = [];

    protected $table="budget_item_details";
    protected $fillable=['id', '_budget_id', '_item_id', '_item_unit_id', '_item_type', '_item_qty', '_item_unit_price', '_item_budget_amount', '_status', 'created_at', 'updated_at'];

    public function _item(){
        return $this->hasOne(Inventory::class,'id','_item_id')->with(['_units','unit_conversion']);
    }

    
}


