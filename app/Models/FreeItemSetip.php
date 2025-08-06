<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class FreeItemSetip extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];
    protected $table="free_item_setups";
}
