<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cylindar extends Model
{
    use HasFactory;


    public function _items(){
        return $this->hasOne(Inventory::class,'id','_item_id');
    }
}
