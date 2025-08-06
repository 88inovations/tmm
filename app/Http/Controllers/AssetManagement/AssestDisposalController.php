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

class AssestDisposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data='';
        $page_name = __('label.asset_sales');
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
                            ->where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $departments = Department::whereIn('id',$assign_department_ids)
                            ->where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $cost_centers = CostCenter::whereIn('id',$assign_costcenter_ids)
                            ->where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $buildings = AssetsDeviceLocation::whereIn('id',$assign_building_ids)
                            ->where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $actual_locations = AssetsLocation::whereIn('id',$assign_actual_location_ids)
                            ->where('status',1)
                            ->where('is_delete',0)
                            ->get();


        return view('apps.asset-management.asset_disposal.create',compact('data','page_name','request','organizations','branchs','departments','cost_centers','buildings','actual_locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
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

            $organization_id        = $asset_info->organization_id ?? 1;
            $_cost_center_id        = $asset_info->_cost_center_id ?? 1;
            $_branch_id             = $asset_info->_branch_id ?? 1;
            $_budget_id             = $asset_info->_budget_id ?? 1;
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
    $AssetSales = new AssetSales();
    $AssetSales->created_by = $auth_user->id ?? 0;
}else{
    $AssetSales = AssetSales::find($id);
    $AssetSales->updated_by = $auth_user->id  ?? 0;
}            
$AssetSales->organization_id = $asset_info->organization_id ?? 1;
$AssetSales->_cost_center_id = $asset_info->_cost_center_id ?? 1;
$AssetSales->_branch_id = $asset_info->_branch_id ?? 1;
$AssetSales->_budget_id = $asset_info->_budget_id ?? 1;
$AssetSales->_date = $_date;
$AssetSales->_order_number = $request->_order_number ?? '';
$AssetSales->voucher_id = $request->voucher_id ?? '';
$AssetSales->voucher_code = $request->voucher_code ?? '';
$AssetSales->payment_method = $request->payment_method ?? '';
$AssetSales->_asset_customer_id = $_asset_customer_id ?? 0;
$AssetSales->_asset_id = $request->_asset_id ?? 0;
$AssetSales->asset_ledger_id = $request->asset_ledger_id ?? 0;
$AssetSales->asset_dep_ledger_id = $request->asset_dep_ledger_id ?? 0;
$AssetSales->asset_dep_exp_ledger_id = $request->asset_dep_exp_ledger_id ?? 0;
$AssetSales->gain_or_loss_ledger_id = $request->gain_or_loss_ledger_id ?? 0;
$AssetSales->_payment_receive_id = $request->_payment_receive_id ?? 0;
$AssetSales->original_cost = $request->evaluated_price ?? 0;
$AssetSales->accumulated_depreciation = $request->accumulated_dep_val ?? 0;
$AssetSales->sale_price = $request->sale_price ?? 0;
$AssetSales->book_value = $request->book_value ?? 0;
$AssetSales->gain_loss = $request->gain_loss ?? 0;
$AssetSales->_lock = $request->_lock ?? 0;
$AssetSales->_is_delete = $request->_is_delete ?? 0;
$AssetSales->_status = $request->_status ?? 1;
$AssetSales->_note = $_note ?? '';
$AssetSales->save();

            $asset_sales_id = $AssetSales->id;
            $_defalut_ledger_id = $asset_sales_id;

            /* Update Orginal Item Asset Table */
           $AssetItem =  AssetItem::find($_asset_id);
           $AssetItem->_is_sold=1;
           $AssetItem->_selling_value=$request->sale_price ?? 0;
           $AssetItem->_pl_amount=$request->gain_loss ?? 0;
           $AssetItem->_sale_date=$request->_date ?? date('Y-m-d');
           $AssetItem->save();



       
        

        $voucher_id = $request->voucher_id ?? '';
if($voucher_id ==''){
    $type_wise_number = type_wise_voucher_number('JV');
    $_code = voucher_prefix()."JV"."-".$type_wise_number;
     $voucher_info = new VoucherMaster();
        $voucher_info->_code = $_code;

}else{
     $voucher_info = VoucherMaster::find($voucher_id);
     VoucherMasterDetail::where('_no',$voucher_id)->update(['_status'=>0]);
     Accounts::where('_ref_master_id',$voucher_id)->where('_transaction','Asset_Sales')->update(['_status'=>0]);

}
       
    
        $voucher_info->_defalut_ledger_id = $_defalut_ledger_id;
        $voucher_info->_transection_ref = $_defalut_ledger_id;
        $voucher_info->_transection_type = 'asset_sales';
        
        $voucher_info->_date = change_date_format($request->_date);
       
        $voucher_info->_time = date('H:i:s');
        $voucher_info->_form_name = 'voucher_masters';
       
        $voucher_info->_created_by = $auth_user->id."-".$auth_user->name;
        $voucher_info->_user_id = $auth_user->id;
        $voucher_info->_user_name = $auth_user->name;
        $voucher_info->_note = $_note;
        $voucher_info->_voucher_type = 'JV';
        
        $voucher_info->_amount = $request->sale_price ?? 0;
        

        $voucher_info->organization_id = $asset_info->organization_id ?? 1;
        $voucher_info->_cost_center_id = $asset_info->_cost_center_id ?? 1;
        $voucher_info->_branch_id = $asset_info->_branch_id ?? 1;
        $voucher_info->_budget_id = $asset_info->_budget_id ?? 1;

        $voucher_info->_sales_man_id = 0;
        $voucher_info->_lock = 0;
        $voucher_info->_status =1;
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

    $_account_type_id =  ledger_to_group_type($ledger_id);
    $_account_group_id =  ledger_to_group_type($ledger_id);

    $VoucherMasterDetail = new VoucherMasterDetail();
    $VoucherMasterDetail->_no = $master_id;
    $VoucherMasterDetail->_account_type_id = $_account_type_id;
    $VoucherMasterDetail->_account_group_id = $_account_group_id;
    $VoucherMasterDetail->_ledger_id = $ledger_id;

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
    



/*
Summary of Payment Date Journal Entry
Cash (Debit) $10,000
Accounts Receivable (Credit) $10,000

 */
$cash_receive_ledgers =[$request->_payment_receive_id,$_asset_customer_id];
$ledger_amounts =[$sale_price,$sale_price];


foreach($cash_receive_ledgers as $key=>$cash_ledger){

    $ledger_amount = $ledger_amounts[$key] ?? 0;

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
            
            return redirect()->route('asset_disposal.index')
            ->with('success', __('label.info_created'));
        } catch (Throwable $e) {
            report($e);
     
            return false;
        }   

}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit ($id){
   
        $page_name = __('label.asset_disposal');
        $assign_org_ids = assign_org_ids();
        $assign_branch_ids = assign_branch_ids();
        $assign_department_ids = assign_department_ids();
        $assign_costcenter_ids = assign_costcenter_ids();
        $assign_building_ids = assign_building_ids();
        $assign_actual_location_ids = assign_actual_location_ids();

        

          $data = AssetSales::with(['_asset','_asset_customer','asset_ledger','asset_acc_dep_ledger','asset_dep_exp_ledger','gain_or_loss_ledger','_payment_receive','_master_cost_center','_organization','_master_branch'])
                  ->where('_status',1)
                  ->where('_is_delete',0)
                  ->find($id);





        return view('apps.asset-management.asset_disposal.edit',compact('data','page_name'));
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
        $info = AssetSales::find($id);
    $data = AssetSales::where('id',$id)->update(['_status'=>0,'_is_delete'=>1]);
    AssetItem::where('id',$info->_asset_id)->update(['_is_sold'=>0]);

    $voucher_id = $info->voucher_id;

     $voucher_info = VoucherMaster::where('id',$voucher_id)->update(['_status'=>0]);
     VoucherMasterDetail::where('_no',$voucher_id)->update(['_status'=>0]);
     Accounts::where('_ref_master_id',$voucher_id)->where('_transaction','Asset_Sales')->update(['_status'=>0]);
     return redirect()->route('asset_disposal.index')
            ->with('success', __('label.info_deleted'));
    }
}
