<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDuty extends Model
{
    use HasFactory;
    protected $table="employee_duties";
    protected $fillable=[ 'id', 'entry_type', '_branch_id', '_employee_id', '_date', '_time', 'state', 'road', 'postcode', 'borough', 'country', 'full_address', 'created_at', 'updated_at','_user_id','latitude','longitude'];


    public function _employee(){
        return $this->hasOne(\App\Models\HRM\HrmEmployees::class,'id','_employee_id');
    }

    public function _branch(){
        return $this->hasOne(\App\Models\Branch::class,'id','_branch_id');
    }

    public function _user(){
        return $this->hasOne(\App\Models\User::class,'id','_user_id');
    }


}
