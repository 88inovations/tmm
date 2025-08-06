<?php

namespace App\Traits;



trait CommonFunction
{
   

    public function _check_status($_status){
     return   ($_status==1) ? "Active" : "In Active";
    }
}