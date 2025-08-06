<?php

namespace App\Models\LC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LcAmendment extends Model
{
    use HasFactory;
    protected $table="lc_amendments";
    protected $fillable=['id', 'lc_master_id', 'amendment_no', 'amendment_date', 'amendment_type', 'old_cif_value_foreign', 'new_cif_value_foreign', 'old_expiry_date', 'new_expiry_date', 'reason_for_amendment', 'created_by', 'created_at', 'updated_at'];
}



