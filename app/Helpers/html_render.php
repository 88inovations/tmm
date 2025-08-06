<?php
use Carbon\Carbon;
use App\Models\Branch;
use App\Models\CostCenter;
use App\Models\AccountGroup;
use App\Models\AccountHead;
use App\Models\AccountLedger;
use App\Models\Accounts;
use App\Models\VoucherType;
use App\Models\Inventory;
use App\Models\StoreHouse;
use App\Models\ItemCategory;
use App\Models\Units;
use App\Models\UnitConversion;
use App\Models\InvoicePrefix;
use App\Models\Budgets;
use App\Models\VoucherMaster;



function nested_category($_childs_category,$level=0,$selected_cat=''){
    $data="";
    if(sizeof($_childs_category) > 0){
    foreach($_childs_category as $c_key=>$c_val){
         $next_childs = $c_val->_childs ?? [];
         $has_child = sizeof($next_childs);
         $disabled = "";
         if($has_child > 0){ $disabled = "disabled"; }
         $selected = '';
         if($c_val->id==$selected_cat){ $selected = 'selected';  }
         
        $data .= "<tr>
                            <td> <div style='width:200px;display: flex;''>
                              <a  type='button'
                                  href=''
                                  class='btn btn-sm btn-default  mr-1'><i class='fa fa-eye'></i></a>
                                 
                                  <a  type='button' 
                                  href=''
                                  class='btn btn-sm btn-default  mr-1'><i class='fa fa-pen '></i></a>
                                  ".$c_val->_name ?? ''."".$c_val->_cat_wise_item_count_count ?? ''."</div></td>
                            
                             
                           
                        </tr>";
        $level++;
          $data .=display_child_category($next_childs,$level);
    }
}
    return $data;

}