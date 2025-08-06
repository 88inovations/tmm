<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class RestaurantCategorySetting extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];
    
    protected $table="restaurant_category_settings";

     public function _branch()
    {
    	return $this->hasOne(Branch::class,'id','_branch_ids')->select('id','_name');
    }
}
