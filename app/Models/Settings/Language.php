<?php

namespace App\Models\settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    protected $table="languages";

    protected $fillable = ['lang_name','lang_locale','lang_code','lang_flag','lang_is_default','lang_order','lang_is_rtl']; 
}
