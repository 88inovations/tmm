<?php

namespace App\Http\Controllers\AssetManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetManagement\AssetsUser;
use App\Models\AssetManagement\AssetsCategory;
use App\Models\Basic\Organization;
use App\Models\Basic\Branch;
use App\Models\Basic\CostCenter;
use App\Models\Basic\Department;
use App\Models\Basic\Designation;
use App\Models\Basic\OrganizationBranch;
use App\Models\Basic\OrganizationStore;
use App\Models\Basic\OrganizationCostCenter;
use App\Models\Basic\OrganizationDepartment;
use App\Models\Basic\OrganizationDesignation;
use App\Models\AssetManagement\AssetBrand;
use App\Models\AssetManagement\AssestDepreciation;
use App\Models\AssetManagement\AssetDepreciation;
use App\Models\AssetManagement\AssetDepreciationDetail;
use App\Models\AssetManagement\AssestDispoal;
use App\Models\AssetManagement\AssestRepair;
use App\Models\AssetManagement\AssetAssign;
use App\Models\AssetManagement\AssetInspection;
use App\Models\AssetManagement\AssetItem;
use App\Models\AssetManagement\AssetsCondition;
use App\Models\AssetManagement\AssetsDeviceLocation;
use App\Models\AssetManagement\AssetsLocation;
use App\Models\AssetManagement\AssetsVendor;
use App\Models\AssetManagement\InspectionCheckCategory;
use App\Models\AssetManagement\AssignStatus;
use App\Models\AssetManagement\AssetSales;

use App\Models\VoucherMaster;
use App\Models\AccountLedger;
use App\Models\AccountGroup;
use App\Models\AccountHead;
use App\Models\Accounts;
use App\Models\VoucherType;
use App\Models\VoucherMasterDetail;
use App\Models\VoucharCheckInfo;


use Auth;
use DB;
use Session;


class AssestDepreciationController extends Controller
{

      function __construct()
    {
         $this->middleware('permission:asset_depreciation-list|asset_depreciation-create|asset_depreciation-edit|asset_depreciation-delete', ['only' => ['index','store']]);
         $this->middleware('permission:asset_depreciation-create', ['only' => ['create','store']]);
         $this->middleware('permission:asset_depreciation-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:asset_depreciation-delete', ['only' => ['destroy']]);
        $this->page_name = __('label.asset_depreciation');
    }




    public function asset_sales_create(Request $request){

        $data='';
        $page_name = __('label.asset_sales');
        $assign_org_ids = assign_org_ids();
        $assign_branch_ids = assign_branch_ids();
        $assign_costcenter_ids = assign_costcenter_ids();
        // $assign_department_ids = assign_department_ids();
        // $assign_building_ids = assign_building_ids();
        // $assign_actual_location_ids = assign_actual_location_ids();

        $organizations = Organization::whereIn('id',$assign_org_ids)
                            ->where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $branchs = Branch::whereIn('id',$assign_branch_ids)
                            ->get();
        $departments = Department::get();
        $cost_centers = CostCenter::whereIn('id',$assign_costcenter_ids)
                            ->where('status',1)
                            ->get();
        $buildings = AssetsDeviceLocation::where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $actual_locations = AssetsLocation::where('status',1)
                            ->where('is_delete',0)
                            ->get();


        $budgets = \DB::table('budgets')->where('_status',1)->get();


        return view('apps.asset-management.asset_sales.create',compact('data','page_name','request','organizations','branchs','departments','cost_centers','buildings','actual_locations','budgets'));
    }


    public function asset_sales_list(Request $request){
   
        $page_name = __('label.asset_sales');
        $assign_org_ids = assign_org_ids();
        $assign_branch_ids = assign_branch_ids();
        $assign_costcenter_ids = assign_costcenter_ids();
        $assign_department_ids = assign_department_ids();
        $assign_building_ids = assign_building_ids();
        $assign_actual_location_ids = assign_actual_location_ids();

        $organizations = Organization::whereIn('id',$assign_org_ids)
                            ->where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $branchs = Branch::whereIn('id',$assign_branch_ids)
                            ->where('status',1)
                            ->get();
        $departments = Department::get();
        $cost_centers = CostCenter::whereIn('id',$assign_costcenter_ids)
                            ->where('status',1)
                            ->get();
        $buildings = AssetsDeviceLocation::where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $actual_locations = AssetsLocation::where('status',1)
                            ->where('is_delete',0)
                            ->get();

        $data = AssetSales::with(['_asset','_asset_customer','asset_ledger','asset_acc_dep_ledger','asset_dep_exp_ledger','gain_or_loss_ledger','_payment_receive','_master_cost_center','_organization','_master_branch'])
                ->where('_status',1)
                ->where('_is_delete',0)
                ->get();





        return view('apps.asset-management.asset_sales.index',compact('data','page_name','request','organizations','branchs','departments','cost_centers','buildings','actual_locations'));
}


public function asset_sales_print($id){
     $page_name = __('label.asset_sales');
         $assign_org_ids = assign_org_ids();
        $assign_branch_ids = assign_branch_ids();
        $assign_costcenter_ids = assign_costcenter_ids();
        $assign_department_ids = assign_department_ids();
        $assign_building_ids = assign_building_ids();
        $assign_actual_location_ids = assign_actual_location_ids();

        $organizations = Organization::whereIn('id',$assign_org_ids)
                            ->where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $branchs = Branch::whereIn('id',$assign_branch_ids)
                            ->get();
        $departments = Department::get();
        $cost_centers = CostCenter::whereIn('id',$assign_costcenter_ids)
                            ->where('status',1)
                            ->get();
        $buildings = AssetsDeviceLocation::where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $actual_locations = AssetsLocation::where('status',1)
                            ->where('is_delete',0)
                            ->get();
$budgets = \DB::table('budgets')->where('_status',1)->get();
        

          $data = AssetSales::with(['_asset','_asset_customer','asset_ledger','asset_acc_dep_ledger','asset_dep_exp_ledger','gain_or_loss_ledger','_payment_receive','_master_cost_center','_organization','_master_branch'])
                  ->where('_status',1)
                  ->where('_is_delete',0)
                  ->find($id);





        return view('apps.asset-management.asset_sales.print',compact('data','page_name','organizations','branchs','departments','cost_centers','buildings','actual_locations','budgets'));
}



    public function asset_sales_edit ($id){
   
        $page_name = __('label.asset_sales');
         $assign_org_ids = assign_org_ids();
        $assign_branch_ids = assign_branch_ids();
        $assign_costcenter_ids = assign_costcenter_ids();
        $assign_department_ids = assign_department_ids();
        $assign_building_ids = assign_building_ids();
        $assign_actual_location_ids = assign_actual_location_ids();

        $organizations = Organization::whereIn('id',$assign_org_ids)
                            ->where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $branchs = Branch::whereIn('id',$assign_branch_ids)
                            ->get();
        $departments = Department::get();
        $cost_centers = CostCenter::whereIn('id',$assign_costcenter_ids)
                            ->where('status',1)
                            ->get();
        $buildings = AssetsDeviceLocation::where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $actual_locations = AssetsLocation::where('status',1)
                            ->where('is_delete',0)
                            ->get();
$budgets = \DB::table('budgets')->where('_status',1)->get();
        

          $data = AssetSales::with(['_asset','_asset_customer','asset_ledger','asset_acc_dep_ledger','asset_dep_exp_ledger','gain_or_loss_ledger','_payment_receive','_master_cost_center','_organization','_master_branch'])
                  ->where('_status',1)
                  ->where('_is_delete',0)
                  ->find($id);





        return view('apps.asset-management.asset_sales.edit',compact('data','page_name','organizations','branchs','departments','cost_centers','buildings','actual_locations','budgets'));
}



    public function asset_search(Request $request){
        $_text_val = $request->_text_val ?? '';
        $_cloumn_name = $request->_cloumn_name ?? 'name';

         $limit = $request->limit ?? default_pagination();
        $_asc_desc = $request->_asc_desc ?? 'ASC';
        $asc_cloumn =  $request->asc_cloumn ?? 'name';
        $text_val = trim($request->_text_val);
        if($text_val =='%'){ $text_val=''; }
        $_head_no = $request->_head_no ?? 0;

        $_is_sold = $request->_is_sold ?? '';

        



        $datas = AssetItem::with(['_asset_ledger','_asset_dep_ledger','_asset_dep_exp_ledger']);
        if($_is_sold !=''){
            $datas = $datas->where('_is_sold',$_is_sold);
        }
        
         if($request->has('_text_val') && $text_val !=''){
            $datas = $datas->where($_cloumn_name,'like',"%$text_val%");
        }
       
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);
        return json_encode( $datas);
    }


    public function asset_sales_store(Request $request){
      // return $request->all();

         $request->validate([
            '_asset_id'=>'required',
            'asset_ledger_id'=>'required',
            'asset_dep_ledger_id'=>'required',
            'asset_dep_exp_ledger_id'=>'required',
            'gain_or_loss_ledger_id'=>'required',
            '_payment_receive_id'=>'required',
            '_date' => 'required',
        ]);







        try {

            $organization_id        = $request->organization_id ?? 1;
            $_cost_center_id        = $request->_cost_center_id ?? 1;
            $_branch_id             = $request->_branch_id ?? 1;
            $_budget_id             = $request->_budget_id ?? 1;
            if($organization_id ==0){$organization_id=1;}
            if($_cost_center_id ==0){$_cost_center_id=1;}
            if($_branch_id ==0){$_branch_id=1;}
            if($_budget_id ==0){$_budget_id=1;}


            $_date                  = $request->_date ?? date('Y-m-d');

            $_asset_customer_id = $request->customer_ledger_id ?? '';
$asset_ledger_id = $request->asset_ledger_id ?? '';
$asset_dep_acc_ledger_id = $request->asset_dep_ledger_id ?? '';
$gain_or_loss_ledger_id = $request->gain_or_loss_ledger_id ?? '';
$_payment_receive_id = $request->_payment_receive_id ?? '';

 $_note = $request->_note ?? 'Asset Sales';

           
             $_asset_id = $request->_asset_id;
            $auth_user = \Auth::user();
            $asset_info = AssetItem::find($_asset_id);

            $id = $request->id ?? '';


if($id ==''){
    $AssetSales                     = new AssetSales();
    $AssetSales->created_by         = $auth_user->id ?? 0;
}else{
    $AssetSales                     = AssetSales::find($id);
    $AssetSales->updated_by         = $auth_user->id  ?? 0;
}            
$AssetSales->organization_id        = $request->organization_id ?? 1;
$AssetSales->_cost_center_id        = $request->_cost_center_id ?? 1;
$AssetSales->_branch_id             = $request->_branch_id ?? 1;
$AssetSales->_budget_id             = $request->_budget_id ?? 1;
$AssetSales->_date                  = $_date;
$AssetSales->_order_number          = $request->_order_number ?? '';
$AssetSales->voucher_id             = $request->voucher_id ?? '';
$AssetSales->voucher_code           = $request->voucher_code ?? '';
$AssetSales->payment_method         = $request->payment_method ?? '';
$AssetSales->_asset_customer_id     = $_asset_customer_id ?? 0;
$AssetSales->_asset_id              = $request->_asset_id ?? 0;
$AssetSales->asset_ledger_id        = $request->asset_ledger_id ?? 0;
$AssetSales->asset_dep_ledger_id    = $request->asset_dep_ledger_id ?? 0;
$AssetSales->asset_dep_exp_ledger_id = $request->asset_dep_exp_ledger_id ?? 0;
$AssetSales->gain_or_loss_ledger_id     = $request->gain_or_loss_ledger_id ?? 0;
$AssetSales->_payment_receive_id        = $request->_payment_receive_id ?? 0;
$AssetSales->original_cost              = $request->evaluated_price ?? 0;
$AssetSales->accumulated_depreciation   = $request->accumulated_dep_val ?? 0;
$AssetSales->sale_price                 = $request->sale_price ?? 0;
$AssetSales->book_value                 = $request->book_value ?? 0;
$AssetSales->gain_loss                  = $request->gain_loss ?? 0;
$AssetSales->_lock                      = $request->_lock ?? 0;
$AssetSales->_is_delete                 = $request->_is_delete ?? 0;
$AssetSales->_status                    = $request->_status ?? 1;
$AssetSales->_note                      = $_note ?? '';
$AssetSales->save();

            $asset_sales_id                 = $AssetSales->id;
            $_defalut_ledger_id             = $asset_sales_id;

            /* Update Orginal Item Asset Table */
           $AssetItem                       =  AssetItem::find($_asset_id);
           $AssetItem->_is_sold             =1;
           $AssetItem->_selling_value       =$request->sale_price ?? 0;
           $AssetItem->_pl_amount           =$request->gain_loss ?? 0;
           $AssetItem->_sale_date           =$request->_date ?? date('Y-m-d');
           $AssetItem->save();



       
        

        $voucher_id = $request->voucher_id ?? '';
         $voucher_info = VoucherMaster::find($voucher_id);
         if(!empty($voucher_info )){
            VoucherMasterDetail::where('_no',$voucher_id)->update(['_status'=>0]);
            Accounts::where('_ref_master_id',$voucher_id)->where('_transaction','Asset_Sales')->update(['_status'=>0]);

         }else{
             $type_wise_number = type_wise_voucher_number('JV');
            $_code = voucher_prefix()."JV"."-".$type_wise_number;
             $voucher_info                  = new VoucherMaster();
            $voucher_info->_code            = $_code;
         }

   
    
        $voucher_info->_defalut_ledger_id   = $_defalut_ledger_id;
        $voucher_info->_transection_ref     = $_defalut_ledger_id;
        $voucher_info->_transection_type    = 'asset_sales';
        $voucher_info->_date                = change_date_format($request->_date);
        $voucher_info->_time                = date('H:i:s');
        $voucher_info->_form_name           = 'voucher_masters';
        $voucher_info->_ref_table           = 'asset_sales';
        $voucher_info->_created_by          = $auth_user->id."-".$auth_user->name;
        $voucher_info->_user_id             = $auth_user->id;
        $voucher_info->_user_name           = $auth_user->name;
        $voucher_info->_note                = $_note;
        $voucher_info->_voucher_type        = 'JV';
        $voucher_info->_amount              = $request->sale_price ?? 0;
        $voucher_info->organization_id      = $asset_info->organization_id ?? 1;
        $voucher_info->_cost_center_id      = $asset_info->_cost_center_id ?? 1;
        $voucher_info->_branch_id           = $asset_info->_branch_id ?? 1;
        $voucher_info->_budget_id           = $asset_info->_budget_id ?? 1;
        $voucher_info->_sales_man_id        = 0;
        $voucher_info->_lock                = 0;
        $voucher_info->_status              =1;
        $voucher_info->save();

       // return $voucher_info;

        $master_id = $voucher_info->id;
        $voucher_code = $voucher_info->_code;



        AssetSales::where('id',$_defalut_ledger_id)
                    ->update(['voucher_id'=>$master_id,'voucher_code'=>$voucher_code]);



/*Asset Sales Journal Voucher

Summary of Sale Date Journal Entry

Accounts Receivable (Debit) $10,000
Accumulated Depreciation (Debit) $8,000
Loss on Sale of Asset (Debit) $2,000
Equipment (Credit) $20,000

*/




 $original_cost = $request->evaluated_price ?? 0;
$accumulated_depreciation = $request->accumulated_dep_val ?? 0;
$sale_price = $request->sale_price ?? 0;
$book_value = $request->book_value ?? 0;
$gain_loss = $request->gain_loss ?? 0;

 $ledger_ids =[$_asset_customer_id,$asset_dep_acc_ledger_id,$gain_or_loss_ledger_id,$asset_ledger_id];
$ledger_amounts =[$sale_price,$accumulated_depreciation,$gain_loss,$original_cost];

/*
07492 110805
WhatsApp

*/
$total_amount_for_voucher=0;
foreach($ledger_ids as $key=>$ledger_id){

    $ledger_amount = $ledger_amounts[$key] ?? 0;

    if($ledger_amount > 0){

             $_account_type_id =  ledger_to_group_type($ledger_id);
            $_account_group_id =  ledger_to_group_type($ledger_id);

            $VoucherMasterDetail = new VoucherMasterDetail();
            $VoucherMasterDetail->_no = $master_id;
            $VoucherMasterDetail->_account_type_id = $_account_type_id;
            $VoucherMasterDetail->_account_group_id = $_account_group_id;
            $VoucherMasterDetail->_ledger_id = $ledger_id;

            $VoucherMasterDetail->organization_id = $organization_id ?? 1;
            $VoucherMasterDetail->_branch_id = $_branch_id ?? 1;
            $VoucherMasterDetail->_cost_center = $_cost_center_id ?? 1;
            $VoucherMasterDetail->_budget_id = $_budget_id ?? 1;

            $VoucherMasterDetail->_short_narr = $_note;
            if($key ==0){
                $total_amount_for_voucher +=$ledger_amount ?? 0;
                 $VoucherMasterDetail->_dr_amount = $ledger_amount ?? 0;
                 $VoucherMasterDetail->_cr_amount =  0;
            }
            if($key ==1){
                 $total_amount_for_voucher +=$ledger_amount ?? 0;
                 $VoucherMasterDetail->_dr_amount = $ledger_amount ?? 0;
                 $VoucherMasterDetail->_cr_amount =  0;
            }
            if($key ==2){
                if($ledger_amount > 0){
                     $total_amount_for_voucher +=$ledger_amount ?? 0;
                    $VoucherMasterDetail->_dr_amount = abs($ledger_amount ?? 0);
                    $VoucherMasterDetail->_cr_amount =  0;
                }else{
                    $VoucherMasterDetail->_dr_amount =  0;
                    $VoucherMasterDetail->_cr_amount = abs($ledger_amount ?? 0);
                }
                 
            }
            if($key ==3){
                 $VoucherMasterDetail->_dr_amount =  0;
                 $VoucherMasterDetail->_cr_amount = $ledger_amount ?? 0;
            }
           
            $VoucherMasterDetail->_status = 1;
            $VoucherMasterDetail->_created_by = $auth_user->id."-".$auth_user->name;
            $VoucherMasterDetail->save();
            $master_detail_id = $VoucherMasterDetail->id;

            //Reporting Account Table Data Insert
            $Accounts = new Accounts();
            $Accounts->_ref_master_id = $master_id;
            $Accounts->_voucher_code = $voucher_code ?? '';
            $Accounts->_ref_detail_id = $master_detail_id;
            $Accounts->_short_narration = $_note ?? 'N/A';
            $Accounts->_narration = $_note ?? '';
            $Accounts->_reference = $_defalut_ledger_id;
            $Accounts->_voucher_type = 'JV';
            $Accounts->_transaction = 'Asset_Sales';
            $Accounts->_date = change_date_format($_date);
            $Accounts->_table_name = 'asset_sales';
            $Accounts->_account_head = $_account_type_id;
            $Accounts->_account_group = $_account_group_id;
            $Accounts->_account_ledger = $ledger_id;

           if($key ==0){
                 $Accounts->_dr_amount = $ledger_amount ?? 0;
                 $Accounts->_cr_amount =  0;
            }
            if($key ==1){
                 $Accounts->_dr_amount = $ledger_amount ?? 0;
                 $Accounts->_cr_amount =  0;
            }
            if($key ==2){
                if($ledger_amount > 0){
                    $Accounts->_dr_amount = abs($ledger_amount ?? 0);
                    $Accounts->_cr_amount =  0;
                }else{
                    $Accounts->_dr_amount =  0;
                    $Accounts->_cr_amount = $ledger_amount ?? 0;
                }
                 
            }
            if($key ==3){
                 $Accounts->_dr_amount =  0;
                 $Accounts->_cr_amount = $ledger_amount ?? 0;
            }

            $Accounts->organization_id = $organization_id ?? 1;
            $Accounts->_branch_id = $_branch_id ?? 0;
            $Accounts->_cost_center = $_cost_center_id ?? 0;
            $Accounts->_budget_id = $_budget_id ?? 0;
            $Accounts->_serial = 1;

            $Accounts->_name =$auth_user->name;
            $Accounts->_sales_man_id = $_sales_man_id ?? 0;
            $Accounts->_check_no = $request->_check_no ?? '';
            $Accounts->_issue_date = $request->_issue_date ?? '';
            $Accounts->_cash_date = $request->_cash_date ?? '';
            $Accounts->save();

    }

    
        
}
    



/*
Summary of Payment Date Journal Entry
Cash (Debit) $10,000
Accounts Receivable (Credit) $10,000

 */
$cash_receive_ledgers =[$request->_payment_receive_id,$_asset_customer_id];
$ledger_amounts =[$sale_price,$sale_price];


foreach($cash_receive_ledgers as $key=>$cash_ledger){

    $ledger_amount = $ledger_amounts[$key] ?? 0;

    if($ledger_amount > 0){
        $_account_type_id =  ledger_to_group_type($cash_ledger);
            $_account_group_id =  ledger_to_group_type($cash_ledger);

            $VoucherMasterDetail = new VoucherMasterDetail();
            $VoucherMasterDetail->_no = $master_id;
            $VoucherMasterDetail->_account_type_id = $_account_type_id;
            $VoucherMasterDetail->_account_group_id = $_account_group_id;
            $VoucherMasterDetail->_ledger_id = $cash_ledger;

            $VoucherMasterDetail->organization_id = $organization_id;
            $VoucherMasterDetail->_branch_id = $_branch_id ?? 0;
            $VoucherMasterDetail->_cost_center = $_cost_center_id ?? 0;
            $VoucherMasterDetail->_budget_id = $_budget_id ?? 0;

            $VoucherMasterDetail->_short_narr = $_note;
            if($key ==0){
                 $total_amount_for_voucher +=$ledger_amount ?? 0;
                 $VoucherMasterDetail->_dr_amount = $ledger_amount ?? 0;
                 $VoucherMasterDetail->_cr_amount =  0;
            }
            if($key ==1){
                 $VoucherMasterDetail->_dr_amount =  0;
                 $VoucherMasterDetail->_cr_amount = $ledger_amount ?? 0;
            }
           
           
            $VoucherMasterDetail->_status = 1;
            $VoucherMasterDetail->_created_by = $auth_user->id."-".$auth_user->name;
            $VoucherMasterDetail->save();
            $master_detail_id = $VoucherMasterDetail->id;

            VoucherMaster::where('id',$master_id)->update(['_amount'=>$total_amount_for_voucher]);

            //Reporting Account Table Data Insert
            $Accounts = new Accounts();
            $Accounts->_ref_master_id = $master_id;
            $Accounts->_voucher_code = $voucher_code ?? '';
            $Accounts->_ref_detail_id = $master_detail_id;
            $Accounts->_short_narration = $_note ?? 'N/A';
            $Accounts->_narration = $_note ?? '';
            $Accounts->_reference = $_defalut_ledger_id;
            $Accounts->_voucher_type = 'JV';
            $Accounts->_transaction = 'Asset_Sales';
            $Accounts->_date = change_date_format($_date);
            $Accounts->_table_name = 'asset_sales';
            $Accounts->_account_head = $_account_type_id;
            $Accounts->_account_group = $_account_group_id;
            $Accounts->_account_ledger = $cash_ledger;

           if($key ==0){
                 $Accounts->_dr_amount = $ledger_amount ?? 0;
                 $Accounts->_cr_amount =  0;
            }
            if($key ==1){
                 $Accounts->_dr_amount =  0;
                 $Accounts->_cr_amount = $ledger_amount ?? 0;
            }
            

            $Accounts->organization_id = $organization_id ?? 1;
            $Accounts->_branch_id = $_branch_id ?? 0;
            $Accounts->_cost_center = $_cost_center_id ?? 0;
            $Accounts->_budget_id = $_budget_id ?? 0;
            $Accounts->_serial = 2;

            $Accounts->_name =$auth_user->name;
            $Accounts->_sales_man_id = $_sales_man_id ?? 0;
            $Accounts->_check_no = $request->_check_no ?? '';
            $Accounts->_issue_date = $request->_issue_date ?? '';
            $Accounts->_cash_date = $request->_cash_date ?? '';
            $Accounts->save();
    }

    
        
}
            
            return redirect()->route('asset_sales_list')
            ->with('success', __('label.info_created'));
        } catch (Throwable $e) {
            report($e);
     
            return false;
        }   

}


public function asset_sales_delete ($id){
    $info = AssetSales::find($id);
    $data = AssetSales::where('id',$id)->update(['_status'=>0,'_is_delete'=>1]);
    AssetItem::where('id',$info->_asset_id)->update(['_is_sold'=>0]);

    $voucher_id = $info->voucher_id;

     $voucher_info = VoucherMaster::where('id',$voucher_id)->update(['_status'=>0]);
     VoucherMasterDetail::where('_no',$voucher_id)->update(['_status'=>0]);
     Accounts::where('_ref_master_id',$voucher_id)->where('_transaction','Asset_Sales')->update(['_status'=>0]);
     return redirect()->route('asset_sales_list')
            ->with('success', __('label.info_deleted'));
}




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

$limit=$request->limit ?? default_pagination();
$order_column=$request->order_column ?? 'id';
$order_by=$request->order_by ?? 'DESC';

// $assign_org_ids = assign_org_ids();
// $assign_branch_ids = assign_branch_ids();
// $assign_department_ids = assign_department_ids();
// $assign_costcenter_ids = assign_costcenter_ids();
// $assign_building_ids = assign_building_ids();
// $assign_actual_location_ids = assign_actual_location_ids();

        $organizations = Organization::get();
        $branchs = Branch::get();
        $departments = Department::get();
        $cost_centers = CostCenter::get();
        $buildings = AssetsDeviceLocation::where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $actual_locations = AssetsLocation::where('status',1)
                            ->where('is_delete',0)
                            ->get();


         $data = AssetDepreciation::where('is_delete',0);
         $data_count=$data->count();
        if($limit !='all'){
         $data =   $data->orderBy($order_column,$order_by)->paginate($data_count);
        }else{
        //$data_count = $data->count();
            $data =   $data->orderBy($order_column,$order_by)->paginate($data_count);
        }
       


        $page_name = $this->page_name;

        return view('apps.asset-management.asset-depreciation.index',compact('data','page_name','request','organizations','branchs','departments','cost_centers','buildings','actual_locations','data_count'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
$page_name = $this->page_name;
$assign_org_ids = assign_org_ids();
$assign_branch_ids = assign_branch_ids();
$assign_department_ids = assign_department_ids();
$assign_costcenter_ids = assign_costcenter_ids();
$assign_building_ids = assign_building_ids();
$assign_actual_location_ids = assign_actual_location_ids();

        $organizations = Organization::whereIn('id',$assign_org_ids)
                            ->where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $branchs = Branch::whereIn('id',$assign_branch_ids)
                            ->get();
        $departments = Department::get();
        $cost_centers = CostCenter::whereIn('id',$assign_costcenter_ids)
                            ->get();
        $buildings = AssetsDeviceLocation::whereIn('id',$assign_building_ids)
                            ->where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $actual_locations = AssetsLocation::whereIn('id',$assign_actual_location_ids)
                            ->where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $datas =[];
        $message_duplicate ='';
        if($request->has('filter')){
            $_dep_month = $request->_dep_month;
            $_dep_year = $request->_dep_year;

             $duplicate_month_year = AssetDepreciation::where('_dep_month',$_dep_month)->where('_dep_year',$_dep_year)->first();
             if(!empty($duplicate_month_year)){
                $message_duplicate="This Month Depreciation Already Generated";
             }

            $datas = AssetItem::with(['category','brand','condition','vendor','category_ledger','assign_status','dep_exp_category_ledger','acc_dep_category_ledger'])->where('is_delete',0)->orderBy('asset_ledger_id','ASC')->orderBy('name','ASC')->get();
        }



        return view('apps.asset-management.asset-depreciation.create',compact('datas','page_name','request','organizations','branchs','departments','cost_centers','buildings','actual_locations','message_duplicate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // return $request->all();

   // DB::beginTransaction();
   //  try {

        $_date              = $request->main_date ?? date('Y-m-d');
        $org_id             = 1;

        $auth_user = \Auth::user();
        $id = $request->id ?? '';
        $AssestDepreciation = AssetDepreciation::find($id);
        if(empty($AssestDepreciation)){
            $AssestDepreciation = new AssetDepreciation();
            $AssestDepreciation->created_by = $auth_user->id;
        }else{
            $AssestDepreciation->updated_by = $auth_user->id;
        }
        
        $AssestDepreciation->_date = $request->main_date ?? '';
        $AssestDepreciation->_dep_month = $request->_dep_month ?? '';
        $AssestDepreciation->_dep_year = $request->_dep_year ?? '';
        $AssestDepreciation->_total_amount = $request->total_dep_value ?? 0;
        $AssestDepreciation->_note = $request->_note ?? '';
        $AssestDepreciation->_status = $request->_status ?? 1;
        $AssestDepreciation->is_delete = $request->_is_delete ?? 0;
        $AssestDepreciation->save();

        $_no = $AssestDepreciation->id;

    if($id !=''){
        AssetDepreciationDetail::where('_no',$_no)->update(['_status'=>0]);
    }

$row_ids = $request->row_id ?? [];
$asset_ledger_ids = $request->asset_ledger_id ?? [];
$asset_dep_ledger_ids = $request->asset_dep_ledger_id ?? [];
$asset_dep_exp_ledger_ids = $request->asset_dep_exp_ledger_id ?? [];
$_asset_ids = $request->_asset_id ?? [];
$purchase_dates = $request->purchase_date ?? [];
$dep_dates = $request->dep_date ?? [];
$evaluated_prices = $request->evaluated_price ?? [];
$dep_types = $request->dep_type ?? [];
$dep_date_numbers = $request->dep_date_number ?? [];
$dep_rates = $request->dep_rate ?? [];
$dep_values = $request->dep_value ?? [];
$accumulated_dep_vals = $request->accumulated_dep_val ?? [];
$old_accumulated_dep_vals = $request->old_accumulated_dep_val ?? [];
$book_values = $request->book_value ?? [];


$organization_ids = $request->organization_id ?? [];
$_branch_ids = $request->branch_id ?? [];
$_cost_center_ids = $request->project_id ?? [];
$_budget_ids = $request->_budget_id ?? [];






if(sizeof($row_ids ) > 0){
    for ($i=0; $i <sizeof($row_ids )  ; $i++) { 
        $AssetDepreciationDetail = AssetDepreciationDetail::find($row_ids[$i]);
        if(empty($AssetDepreciationDetail)){
            $AssetDepreciationDetail = new AssetDepreciationDetail();
        }
        $AssetDepreciationDetail->_no =  $_no;
        $AssetDepreciationDetail->_asset_id =  $_asset_ids[$i];
        $AssetDepreciationDetail->asset_ledger_id =  $asset_ledger_ids[$i];
        $AssetDepreciationDetail->asset_dep_ledger_id =  $asset_dep_ledger_ids[$i];
        $AssetDepreciationDetail->asset_dep_exp_ledger_id =  $asset_dep_exp_ledger_ids[$i];
        $AssetDepreciationDetail->_asset_dep_rate =  $dep_rates[$i];
        $AssetDepreciationDetail->_asset_dep_type =  $dep_types[$i];
        $AssetDepreciationDetail->_asset_dep_amount =  $dep_values[$i];
        $AssetDepreciationDetail->book_value =  $book_values[$i] ?? 0;
        $AssetDepreciationDetail->accumulated_dep_val =  $accumulated_dep_vals[$i] ?? 0;
        $AssetDepreciationDetail->organization_id =  $organization_ids[$i] ?? 1;
        $AssetDepreciationDetail->_cost_center_id =  $_cost_center_ids[$i] ?? 1;
        $AssetDepreciationDetail->_branch_id =  $_branch_ids[$i] ?? 1;
        $AssetDepreciationDetail->_budget_id =  $_budget_ids[$i] ?? 1;
        $AssetDepreciationDetail->_status = 1;
        $AssetDepreciationDetail->_is_delete = 0;
        $AssetDepreciationDetail->_lock = 0;
        $AssetDepreciationDetail->save();

      //  $id = $_asset_ids[$i] ?? '';

        if($id !=''){
            $edit_asset_item                = AssetItem::find($_asset_ids[$i]);
            $pre_accumulated_dep_val        = $edit_asset_item->accumulated_dep_val ?? 0;
            $pre_book_value                 = $edit_asset_item->book_value ?? 0;
            $evaluated_price                = $edit_asset_item->evaluated_price ?? 0;
            $new_accumulated_dep_val        = ($pre_accumulated_dep_val-$dep_values[$i] ?? 0);
            $new_book_value                 = ($evaluated_price+$new_accumulated_dep_val);
            $edit_asset_item->accumulated_dep_val = $new_accumulated_dep_val;
            $edit_asset_item->book_value    = $new_book_value;
            $edit_asset_item->save();
        }








        //Update Asset Book Value and Accumulated Depriciation 
        // Find asset_item data 

        $asset_item                     = AssetItem::find($_asset_ids[$i]);
        $pre_accumulated_dep_val        = $asset_item->accumulated_dep_val ?? 0;
        $pre_book_value                 = $asset_item->book_value ?? 0;
        $evaluated_price                = $asset_item->evaluated_price ?? 0;

        $new_accumulated_dep_val        = ($pre_accumulated_dep_val+$dep_values[$i] ?? 0);
        $new_book_value                 = ($evaluated_price-$new_accumulated_dep_val);
        $asset_item->accumulated_dep_val = $new_accumulated_dep_val;
        $asset_item->book_value         = $new_book_value;
        $asset_item->save();

    }

 VoucherMaster::where('_defalut_ledger_id',$_no)
            ->where('_transection_type','depreciation')
            ->update(['_status'=>0]);

    /*Voucher or Journal or assetDepVoucher Entry*/

    /*Main Voucher Master Entry*/
    $_defalut_ledger_id = $_no;
    $_note =  "Depreciation for "._number_to_month($request->_dep_month ?? '')." ".$request->_dep_year;

    $voucher_info = VoucherMaster::where('_defalut_ledger_id',$_no)->where('_transection_type','depreciation')->first();

    $voucher_info_id = $voucher_info->id ?? 0;
   
    VoucherMasterDetail::where('_no', $voucher_info_id)
                    ->update(['_status'=>0]);
    


      

    if(empty($voucher_info)){
        $type_wise_number = type_wise_voucher_number('JV',$_date);
       $_code = voucher_prefix()."JV"."-".$type_wise_number;
        $voucher_info = new VoucherMaster();
        $voucher_info->_code = $_code;
    }
        $voucher_info->_defalut_ledger_id = $_defalut_ledger_id;
        $voucher_info->_transection_ref = $_defalut_ledger_id;
        $voucher_info->_transection_type = 'depreciation';
        
        $voucher_info->_date = change_date_format($request->main_date);
       
        $voucher_info->_time = date('H:i:s');
        $voucher_info->_form_name = 'voucher_masters';
        $voucher_info->_ref_table = 'asset_depreciations';
       
        $voucher_info->_created_by = $auth_user->id."-".$auth_user->name;
        $voucher_info->_user_id = $auth_user->id;
        $voucher_info->_user_name = $auth_user->name;
        $voucher_info->_note = $_note;
        $voucher_info->_voucher_type = 'JV';
        
        $voucher_info->_amount = $request->total_dep_value;
        $voucher_info->organization_id = 1;
        $voucher_info->_branch_id = 1;
        $voucher_info->_cost_center_id = 1;
        $voucher_info->_budget_id = 1;
        $voucher_info->_sales_man_id = 0;
        $voucher_info->_lock = 0;
        $voucher_info->_status =1;
        $voucher_info->save();

       // return $voucher_info;

        $master_id = $voucher_info->id;
        $voucher_code = $voucher_info->_code;

AssetDepreciation::where('id',$_no)
            ->update(['_voucher_id'=>$master_id,'_voucher_code'=>$voucher_code]);



        Accounts::where('_ref_master_id',$voucher_info->id)
                    ->where('_voucher_code',$voucher_code)
                    ->where('_reference',$_defalut_ledger_id)
                    ->update(['_status'=>0]);





       $voucher_row_details = \DB::select(" SELECT t2.id,t2._dep_month,t2._dep_year, t1.asset_dep_ledger_id,
t1.asset_dep_exp_ledger_id,t1.organization_id,
t1._cost_center_id,t1._branch_id,t1._budget_id,SUM(t1._asset_dep_amount) as _asset_dep_amount
FROM `asset_depreciation_details` as t1
INNER JOIN asset_depreciations as t2 ON (t1._no=t2.id AND t2._status=1)
WHERE t1._status=1 AND t2._dep_month=$request->_dep_month AND t2._dep_year=$request->_dep_year
GROUP BY t1.asset_dep_ledger_id,t1.asset_dep_exp_ledger_id,
t1.organization_id,t1._cost_center_id,t1._branch_id,t1._budget_id ");



foreach ($voucher_row_details as $key => $value) {

        $org_id             = $value->organization_id ?? 1;
        $branchId           = $value->_branch_id ?? 1;
        $costCenterId       = $value->_cost_center_id ?? 1;
        $budgetId           = $value->_budget_id ?? 1;
        $_asset_dep_amount  = $value->_asset_dep_amount ?? 0;

     //Asset  Depreciation Expenses Ledger
if($_asset_dep_amount > 0){


    $asset_dep_exp_ledger_id    = $value->asset_dep_exp_ledger_id;

    $_account_type_id           =  ledger_to_group_type($asset_dep_exp_ledger_id);
    $_account_group_id          =  ledger_to_group_type($asset_dep_exp_ledger_id);

    $VoucherMasterDetail        = new VoucherMasterDetail();
    $VoucherMasterDetail->_no               = $master_id;
    $VoucherMasterDetail->_account_type_id  = $_account_type_id;
    $VoucherMasterDetail->_account_group_id = $_account_group_id;
    $VoucherMasterDetail->_ledger_id        = $asset_dep_exp_ledger_id;

    $VoucherMasterDetail->organization_id   = $org_id;
    $VoucherMasterDetail->_branch_id        = $branchId ?? 0;
    $VoucherMasterDetail->_cost_center      = $costCenterId ?? 0;
    $VoucherMasterDetail->_budget_id        = $budgetId ?? 0;

    $VoucherMasterDetail->_short_narr       = $_note;
    $VoucherMasterDetail->_dr_amount        =  $_asset_dep_amount ?? 0;
    $VoucherMasterDetail->_cr_amount        =  0;
    $VoucherMasterDetail->_status           = 1;
    $VoucherMasterDetail->_created_by       = $auth_user->id."-".$auth_user->name;
    $VoucherMasterDetail->save();
    $master_detail_id                       = $VoucherMasterDetail->id;

    //Reporting Account Table Data Insert
    $Accounts                               = new Accounts();
    $Accounts->_ref_master_id               = $master_id;
    $Accounts->_voucher_code                = $voucher_code ?? '';
    $Accounts->_ref_detail_id               = $master_detail_id;
    $Accounts->_short_narration             = $_note ?? 'N/A';
    $Accounts->_narration                   = $_note ?? '';
    $Accounts->_reference                   = $_defalut_ledger_id;
    $Accounts->_voucher_type                = 'JV';
    $Accounts->_transaction                 = 'Account';
    $Accounts->_date                        = change_date_format($_date);
    $Accounts->_table_name                  = 'voucher_masters';
    $Accounts->_account_head                = $_account_type_id;
    $Accounts->_account_group               = $_account_group_id;
    $Accounts->_account_ledger              = $asset_dep_exp_ledger_id;
    $Accounts->_dr_amount                   = $_asset_dep_amount ??  0;
    $Accounts->_cr_amount                   = 0;

    $Accounts->organization_id              = $org_id ?? 1;
    $Accounts->_branch_id                   = $branchId ?? 0;
    $Accounts->_cost_center                 = $costCenterId ?? 0;
    $Accounts->_budget_id                   = $budgetId ?? 0;

    $Accounts->_serial                      = $key ?? 0;
    $Accounts->_name                        = $auth_user->name;
    $Accounts->_sales_man_id                = $_sales_man_id ?? 0;
    $Accounts->_check_no                    = $request->_check_no ?? '';
    $Accounts->_issue_date                  = $request->_issue_date ?? '';
    $Accounts->_cash_date                   = $request->_cash_date ?? '';
    $Accounts->save();



    //Asset Accumulated Depreciation ledger
    //return $value;
    $asset_dep_ledger_id                = $value->asset_dep_ledger_id;
    $org_id             = $value->organization_id ?? 1;
    $branchId           = $value->_branch_id ?? 1;
    $costCenterId       = $value->_cost_center_id ?? 1;
    $budgetId           = $value->_budget_id ?? 1;

    $_asset_dep_amount = $value->_asset_dep_amount ?? 0;
    
    $_account_type_id           =  ledger_to_group_type($asset_dep_ledger_id)->_account_head_id ?? 1;
    $_account_group_id          =  ledger_to_group_type($asset_dep_ledger_id)->_account_group_id ?? 1;

    $VoucherMasterDetail                        = new VoucherMasterDetail();
    $VoucherMasterDetail->_no                   = $master_id;
    $VoucherMasterDetail->_account_type_id      = $_account_type_id;
    $VoucherMasterDetail->_account_group_id     = $_account_group_id;
    $VoucherMasterDetail->_ledger_id            = $asset_dep_ledger_id ?? 1;

    $VoucherMasterDetail->organization_id       = $org_id;
    $VoucherMasterDetail->_branch_id            = $branchId ?? 0;
    $VoucherMasterDetail->_cost_center          = $costCenterId ?? 0;
    $VoucherMasterDetail->_budget_id            = $budgetId ?? 0;

    $VoucherMasterDetail->_short_narr           = $_note;
    $VoucherMasterDetail->_dr_amount            =  0;
    $VoucherMasterDetail->_cr_amount            =  $_asset_dep_amount ?? 0;
    $VoucherMasterDetail->_status               = 1;
    $VoucherMasterDetail->_created_by           = $auth_user->id."-".$auth_user->name;
    $VoucherMasterDetail->save();
    $master_detail_id = $VoucherMasterDetail->id;

    //Reporting Account Table Data Insert
    $Accounts                           = new Accounts();
    $Accounts->_ref_master_id           = $master_id;
    $Accounts->_voucher_code            = $voucher_code ?? '';
    $Accounts->_ref_detail_id           = $master_detail_id;
    $Accounts->_short_narration         = $_note ?? 'N/A';
    $Accounts->_narration               = $_note ?? '';
    $Accounts->_reference               = $_defalut_ledger_id;
    $Accounts->_voucher_type            = 'JV';
    $Accounts->_transaction             = 'Account';
    $Accounts->_date                    = change_date_format($_date);
    $Accounts->_table_name              = 'voucher_masters';
    $Accounts->_account_head            = $_account_type_id;
    $Accounts->_account_group           = $_account_group_id;
    $Accounts->_account_ledger          = $asset_dep_ledger_id;
    $Accounts->_dr_amount               =  0;
    $Accounts->_cr_amount               = $_asset_dep_amount ?? 0;



    $Accounts->organization_id              = $org_id ?? 1;
    $Accounts->_branch_id                   = $branchId ?? 0;
    $Accounts->_cost_center                 = $costCenterId ?? 0;
    $Accounts->_budget_id                   = $budgetId ?? 0;


    $Accounts->_serial              = $key ?? 0;
    $Accounts->_name                = $auth_user->name;
    $Accounts->_sales_man_id        = $_sales_man_id ?? 0;
    $Accounts->_check_no            = $request->_check_no ?? '';
    $Accounts->_issue_date          = $request->_issue_date ?? '';
    $Accounts->_cash_date           = $request->_cash_date ?? '';
    $Accounts->save();


    } // End of Depreciation Amount is Grater then Zero


}

}

// DB::commit();

return redirect()->route('asset_depreciation.index')
            ->with('success', __('label.info_created'));

  
    
// } catch (\Exception $e) {
//    DB::rollback();
//    return redirect()->back()->with('danger',"Something Wrong");
// }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

         $main_data = AssetDepreciation::where('is_delete',0)->find($id);

         $_dep_month = $main_data->_dep_month;
         $_dep_year = $main_data->_dep_year;


 $asset_summary_reports = \DB::select(" SELECT t1.id, t4._name as asset_ledger_name, t1._dep_month,t1._dep_year,SUM(t2._asset_dep_amount) as _asset_dep_amount,
SUM(t3.purchase_price) as purchase_price,SUM(t3.extra_cost) as extra_cost,SUM(t3._selling_value) as _selling_value,SUM(t2.book_value) as book_value,
SUM(t3.evaluated_price) as evaluated_price,t3.dep_rate,SUM(t2._asset_dep_amount) as _asset_dep_amount,
SUM(t2.accumulated_dep_val) as accumulated_dep_val
FROM `asset_depreciations` AS t1
INNER JOIN asset_depreciation_details AS t2 ON (t1.id=t2._no AND t2._status=1)
INNER JOIN asset_items as t3 ON t3.id=t2._asset_id
INNER JOIN account_ledgers as t4 ON t4.id=t3.asset_ledger_id
WHERE t1._status=1 AND t1._dep_month=$_dep_month AND t1._dep_year=$_dep_year AND t1.id=$id
GROUP BY t3.asset_ledger_id ORDER BY t3.asset_ledger_id ASC ");

//return $asset_summary_reports;

           $page_name = $this->page_name;
          $assign_org_ids = assign_org_ids();
$assign_branch_ids = assign_branch_ids();
$assign_costcenter_ids = assign_costcenter_ids();
// $assign_department_ids = assign_department_ids();
// $assign_building_ids = assign_building_ids();
// $assign_actual_location_ids = assign_actual_location_ids();

        $organizations = Organization::whereIn('id',$assign_org_ids)
                            ->where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $branchs = Branch::whereIn('id',$assign_branch_ids)
                            ->where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $departments = Department::get();
        $cost_centers = CostCenter::whereIn('id',$assign_costcenter_ids)
                            ->get();
        $buildings = AssetsDeviceLocation::where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $actual_locations = AssetsLocation::where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $datas =[];
        

        return view('apps.asset-management.asset-depreciation.show',compact('datas','page_name','organizations','branchs','departments','cost_centers','buildings','actual_locations','main_data','asset_summary_reports'));
    }




    public function depDetail($id){
        
         $main_data = AssetDepreciation::with(['asset_dep_detail'])->where('is_delete',0)->find($id);

         $asset_dep_detail = $main_data->asset_dep_detail ?? [];
         $asset_detail_data  = [];

         foreach($asset_dep_detail as $key=>$val){
            $asset_detail_data[$val->asset_ledger_id][]=$val;
         }
        //return $asset_detail_data ;
         $_dep_month = $main_data->_dep_month;
         $_dep_year = $main_data->_dep_year;


 



           $page_name = $this->page_name;
          $assign_org_ids = assign_org_ids();
$assign_branch_ids = assign_branch_ids();
$assign_costcenter_ids = assign_costcenter_ids();
// $assign_department_ids = assign_department_ids();
// $assign_building_ids = assign_building_ids();
// $assign_actual_location_ids = assign_actual_location_ids();

        $organizations = Organization::whereIn('id',$assign_org_ids)
                            ->where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $branchs = Branch::whereIn('id',$assign_branch_ids)
                            ->where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $departments = Department::get();
        $cost_centers = CostCenter::whereIn('id',$assign_costcenter_ids)
                            ->get();
        $buildings = AssetsDeviceLocation::where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $actual_locations = AssetsLocation::where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $datas =[];
        

        return view('apps.asset-management.asset-depreciation.detail',compact('datas','page_name','organizations','branchs','departments','cost_centers','buildings','actual_locations','main_data','asset_detail_data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $main_data = AssetDepreciation::with(['asset_dep_detail'])->where('is_delete',0)->find($id);
         $datas = AssetItem::with(['category','brand','condition','vendor','category_ledger','assign_status','dep_exp_category_ledger','acc_dep_category_ledger'])->where('is_delete',0)->orderBy('asset_ledger_id','ASC')->orderBy('name','ASC')->get();

           $page_name = $this->page_name;
          $assign_org_ids = assign_org_ids();
$assign_branch_ids = assign_branch_ids();
$assign_costcenter_ids = assign_costcenter_ids();
// $assign_department_ids = assign_department_ids();
// $assign_building_ids = assign_building_ids();
// $assign_actual_location_ids = assign_actual_location_ids();

        $organizations = Organization::whereIn('id',$assign_org_ids)
                            ->where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $branchs = Branch::whereIn('id',$assign_branch_ids)
                            ->where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $departments = Department::get();
        $cost_centers = CostCenter::whereIn('id',$assign_costcenter_ids)
                            ->get();
        $buildings = AssetsDeviceLocation::where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $actual_locations = AssetsLocation::where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $request =[];


     //   $datas =[];
       





    return view('apps.asset-management.asset-depreciation.edit',compact('datas','page_name','organizations','branchs','departments','cost_centers','buildings','actual_locations','main_data'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
