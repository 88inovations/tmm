<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ItemInventory extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];


    public function _category(){
    	return $this->hasOne(ItemCategory::class,'id','_category_id')->select('id','_name');
    }
}
