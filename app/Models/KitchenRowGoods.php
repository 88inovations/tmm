<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class KitchenRowGoods extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];

     public function _items(){
        return $this->hasOne(Inventory::class,'id','_item_id')->select('id','_item as _name','_unique_barcode');
    }
}
