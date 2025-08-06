<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationDesignation extends Model
{
    use HasFactory;
      protected $table="organization_designations";
      public function _designation(){
        return $this->hasOne(\App\Models\Basic\Designation::class,'id','designation_id');
    }
}
