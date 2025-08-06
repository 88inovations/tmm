<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysCustomForm extends Model
{
    protected $table = 'sys_customform';
    protected $primaryKey = '_id';

    protected $fillable = [
        '_table', '_name', '_serial', '_groupmenu', '_underfrom', '_option', '_event', '_tabletype'
    ];

    public function fields()
    {
        return $this->hasMany(SysCustomFormField::class, '_tableid', '_id');
    }
}
