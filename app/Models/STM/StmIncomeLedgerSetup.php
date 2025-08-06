<?php

namespace App\Models\STM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StmIncomeLedgerSetup extends Model
{
    use HasFactory;
    protected $table="stm_income_ledger_setups";
    protected $fillable =['id', '_admission_fee_ledger', '_tution_fee_ledger', '_anual_fee_ledger', '_exam_fee_ledger', '_monthly_food_fee_ledger', '_residential_fee_ledger', '_other_fee_ledger', '_other_2_fee_ledger', '_other_3_fee_ledger','_discount_ledger', '_status', '_created_by', '_updated_by', 'created_at', 'updated_at'];


     
}
