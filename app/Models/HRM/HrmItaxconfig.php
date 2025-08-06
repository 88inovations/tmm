<?php

namespace App\Models\HRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class HrmItaxconfig extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];
}
