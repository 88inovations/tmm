<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysCustomFormField extends Model
{
    use HasFactory;
       protected $table = 'sys_customformfields';
    protected $primaryKey = '_id';

    protected $fillable = [
        '_tableid', '_field', '_name', '_datatype', '_size', '_childtable', '_unique', '_list', '_group',
        '_required', '_readonly', '_extsearch', '_default', '_tabs', '_add', '_edit', '_serial'
    ];

    public function form()
    {
        return $this->belongsTo(SysCustomForm::class, '_tableid', '_id');
    }


}
