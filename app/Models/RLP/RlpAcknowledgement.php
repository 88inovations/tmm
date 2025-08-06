<?php

namespace App\Models\RLP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RlpAcknowledgement extends Model
{
    use HasFactory;

    protected $fillable=['id','rlp_info_id', 'user_id', 'user_office_id', 'ack_order', 'ack_status', 'ack_request_date', 'ack_updated_date', 'is_visible', '_is_approve', '_status', 'created_at', 'updated_at'];

     


    public function _employee(){
        return $this->hasOne(\App\Models\HRM\HrmEmployees::class,'id','user_id')->with(['_emp_department','_emp_designation']);
    }


    public function _check_group(){
        return $this->hasOne(\App\Models\RLP\RlpUserGroup::class,'id','ack_order');
    }
}
