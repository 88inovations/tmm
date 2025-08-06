<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatWiseTaBill extends Model
{
    use HasFactory;


   

    public function _emp_designation(){
    return $this->hasOne(\App\Models\HRM\Designation::class,'id','_designation_id');
}
}
