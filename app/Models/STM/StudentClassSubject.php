<?php

namespace App\Models\STM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClassSubject extends Model
{
    use HasFactory;
    protected $table="stm_division_class_students";

    protected $fillable=['id', '_student_id', '_division_id', '_class_id', '_role_no', '_session', '_promoted', '_admission_fee', '_tution_fee', '_anual_fee', '_exam_fee', '_other_fee', '_other_2_fee', '_other_3_fee', '_status', '_lock', '_created_by', '_updated_by', 'created_at', 'updated_at'];

    
}
