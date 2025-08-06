<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $table="branches";
    


    public function _organization(){
        return $this->hasOne(Organization::class,'id','organization_id');
    }
}


