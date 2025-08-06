<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    use HasFactory;
    protected $table="tenders";
    protected $fillable=[
        'tender_owner',
        'tender_address',
        'publish_date',
        'schedule_close_date',
        'submit_date',
        'schedule_price',
    ];
}

