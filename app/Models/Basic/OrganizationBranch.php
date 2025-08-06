<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationBranch extends Model
{
    use HasFactory;
    protected $table="organization_branches";

    public function _branch(){
        return $this->hasOne(\App\Models\Basic\Branch::class,'id','branch_id');
    }
}
