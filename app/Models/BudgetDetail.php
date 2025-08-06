<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;


class BudgetDetail extends Model implements Auditable{
   use HasFactory;
    use AuditableTrait;
    protected $guarded = [];


    protected $table="budget_details";
    protected $fillable=['id', '_budget_id', '_ledger_id', '_ledger_type', '_budget_amount', '_status', 'created_at', 'updated_at'];

    public function _ledger(){
        return $this->hasOne(AccountLedger::class,'id','_ledger_id');
    }
}


