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
use App\Models\AssetManagement\AssetEngConsumption;
use App\Models\VoucherMaster;
use App\Models\VoucherMasterDetail;
use App\Models\Accounts;


class AssetEngConsumptionController extends Controller
{

        function __construct()
    {
         $this->middleware('permission:asset_eng_consumptions_list|asset_eng_consumptions_create|asset_eng_consumptions_edit|asset_eng_consumptions_delete', ['only' => ['index','store']]);
         $this->middleware('permission:asset_eng_consumptions_create', ['only' => ['create','store']]);
         $this->middleware('permission:asset_eng_consumptions_edit', ['only' => ['edit','update']]);
         $this->middleware('permission:asset_eng_consumptions_delete', ['only' => ['destroy']]);
        $this->page_name = __('label.asset_eng_consumptions');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
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

        $page_name = $this->page_name;
        $data = AssetEngConsumption::with(['_asset_item'])->where('is_delete',0)->where('_status',1)->orderBy('id','DESC')->get();
         return view('apps.asset-management.asset_eng_consumptions.index',compact('data','page_name','request','organizations','branchs','departments','cost_centers','buildings','actual_locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data='';
        $page_name =$this->page_name;
        $assign_org_ids = assign_org_ids();
        $assign_branch_ids = assign_branch_ids();
        $assign_costcenter_ids = assign_costcenter_ids();

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
        $budgets = \DB::table('budgets')->where('_status',1)->get();


        return view('apps.asset-management.asset_eng_consumptions.create',compact('data','page_name','request','organizations','branchs','departments','cost_centers','buildings','actual_locations','budgets'));
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

         $request->validate([
            '_asset_id'=>'required',
            '_date' => 'required',
        ]);

        $auth_user = \Auth::user();
        $_date = change_date_format($request->main_date ?? date('Y-m-d'));

        $id = $request->asset_eng_consumtion_id ?? '';
        $_asset_id = $request->_asset_id ?? '';


      

        $asset_info = AssetItem::find($request->asset_id);

        try {
            if($id ==''){
                $AssetEngConsumption                    = new AssetEngConsumption();
                $AssetEngConsumption->created_by        = $auth_user->id ?? 0;
                $AssetEngConsumption->created_at        = date("Y-m-d H:i:s");
            }else{
                $AssetEngConsumption                    = AssetEngConsumption::find($id);
                $AssetEngConsumption->updated_by        = $auth_user->id ?? 0;
                $AssetEngConsumption->updated_at        = date("Y-m-d H:i:s");
            }
             $AssetEngConsumption->_date                = $_date ?? date('Y-m-d');
             $AssetEngConsumption->asset_id             = $_asset_id ?? '';
             //$AssetEngConsumption->_voucher_number    = $request->_voucher_number ?? '';
             $AssetEngConsumption->_expense_ledger_id   = $request->_expense_ledger_id ?? '';
             $AssetEngConsumption->_payable_ledger_id   = $request->_payable_ledger_id ?? '';



             $AssetEngConsumption->energy_used          = $request->energy_used ?? 0;
             $AssetEngConsumption->cost                 = $request->cost ?? 0;
             $AssetEngConsumption->operating_hours      = $request->operating_hours ?? 0;
             $AssetEngConsumption->fuel_used_liters     = $request->fuel_used_liters ?? 0;
             $AssetEngConsumption->electricity_used_kwh = $request->electricity_used_kwh ?? 0;

             $AssetEngConsumption->_note                = $request->_note ?? '';
             $AssetEngConsumption->organization_id      = $request->organization_id ?? 1;
             $AssetEngConsumption->_cost_center_id      = $request->_cost_center_id ?? 1;
             $AssetEngConsumption->_branch_id           = $request->_branch_id ?? 1;
             $AssetEngConsumption->_budget_id           = $request->_budget_id ?? 1;
             $AssetEngConsumption->_lock                = $asset_info->_lock ?? 0;
             $AssetEngConsumption->_status              = $asset_info->_status ?? 1;
             $AssetEngConsumption->save();

             $_no = $AssetEngConsumption->id;





//If Edit then change voucherMasterStatus

    VoucherMaster::where('_defalut_ledger_id',$_no)
            ->where('_transection_type','consumptions')
            ->update(['_status'=>0]);

    /*Voucher or Journal or assetDepVoucher Entry*/

    /*Main Voucher Master Entry*/
    $_defalut_ledger_id = $_no;
    $_note =  $request->_note ?? 'consumptions Expense';

    $voucher_info = VoucherMaster::where('_defalut_ledger_id',$_no)->where('_transection_type','consumptions')->first();

    $voucher_info_id = $voucher_info->id ?? 0;
   
    VoucherMasterDetail::where('_no', $voucher_info_id)
                    ->update(['_status'=>0]);
    


      

    if(empty($voucher_info)){
        $type_wise_number = type_wise_voucher_number('JV',$_date);
       $_code = voucher_prefix()."JV"."-".$type_wise_number;
        $voucher_info = new VoucherMaster();
        $voucher_info->_code = $_code;
    }
        $voucher_info->_defalut_ledger_id   = $_defalut_ledger_id;
        $voucher_info->_transection_ref     = $_defalut_ledger_id;
        $voucher_info->_transection_type    = 'consumptions';
        
        $voucher_info->_date                = change_date_format($request->main_date);
       
        $voucher_info->_time                = date('H:i:s');
        $voucher_info->_form_name           = 'voucher_masters';
        $voucher_info->_ref_table           = 'asset_eng_consumptions';
       
        $voucher_info->_created_by          = $auth_user->id."-".$auth_user->name;
        $voucher_info->_user_id             = $auth_user->id;
        $voucher_info->_user_name           = $auth_user->name;
        $voucher_info->_note                = $_note;
        $voucher_info->_voucher_type        = 'JV';
        
        $voucher_info->_amount              = $request->cost ?? 0;
        $voucher_info->organization_id      = $request->organization_id ?? 1;
        $voucher_info->_branch_id           = $request->_branch_id ?? 1;
        $voucher_info->_cost_center_id      = $request->_cost_center_id ?? 1;
        $voucher_info->_budget_id           =$request->_budget_id ??  1;
        $voucher_info->_sales_man_id        = 0;
        $voucher_info->_lock                = 0;
        $voucher_info->_status              =1;
        $voucher_info->save();


    $organization_id            = $request->organization_id ?? 1;
    $_branch_id                 = $request->_branch_id ?? 1;
    $_cost_center_id            = $request->_cost_center_id ?? 0;
    $_budget_id                 =  $request->_budget_id ?? 1;
    $_asset_dep_amount          = $request->cost ??  0;

       // return $voucher_info;

        $master_id = $voucher_info->id;
        $voucher_code = $voucher_info->_code;

AssetEngConsumption::where('id',$_no)
            ->update(['_voucher_id'=>$master_id,'_voucher_code'=>$voucher_code]);



        Accounts::where('_ref_master_id',$voucher_info->id)
                    ->where('_voucher_code',$voucher_code)
                    ->where('_reference',$_defalut_ledger_id)
                    ->update(['_status'=>0]);





 $ledgers=[$request->_expense_ledger_id,$request->_payable_ledger_id];



foreach ($ledgers as $key => $ledger) {

    //Asset Depreciation Expenses Ledger
    //return $value;
   
    
    
    $_account_type_id                   =  ledger_to_group_type($ledger)->_account_head_id ?? 0;
    $_account_group_id                  =  ledger_to_group_type($ledger)->_account_group_id ?? 0;

    $VoucherMasterDetail                = new VoucherMasterDetail();
    $VoucherMasterDetail->_no           = $master_id;
    $VoucherMasterDetail->_account_type_id = $_account_type_id;
    $VoucherMasterDetail->_account_group_id = $_account_group_id;
    $VoucherMasterDetail->_ledger_id        = $ledger ?? 0;

    $VoucherMasterDetail->organization_id   = $organization_id;
    $VoucherMasterDetail->_branch_id        = $_branch_id ?? 0;
    $VoucherMasterDetail->_cost_center      = $_cost_center_id ?? 0;
    $VoucherMasterDetail->_budget_id        = $_budget_id ?? 0;

    $VoucherMasterDetail->_short_narr       = $_note;
    if($key==0){
        $VoucherMasterDetail->_dr_amount    = $_asset_dep_amount ?? 0;
        $VoucherMasterDetail->_cr_amount    =  0;
    }else{
        $VoucherMasterDetail->_dr_amount    = 0;
        $VoucherMasterDetail->_cr_amount    =  $_asset_dep_amount ?? 0;
    }
    
    $VoucherMasterDetail->_status           = 1;
    $VoucherMasterDetail->_created_by       = $auth_user->id."-".$auth_user->name;
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
    $Accounts->_account_ledger          = $ledger;
     if($key==0){
        $Accounts->_dr_amount           = $_asset_dep_amount ?? 0;
        $Accounts->_cr_amount           =  0;
    }else{
        $Accounts->_dr_amount           =  0;
        $Accounts->_cr_amount           = $_asset_dep_amount ?? 0;
    }
    $Accounts->organization_id          = $organization_id ?? 1;
    $Accounts->_branch_id               = $_branch_id ?? 0;
    $Accounts->_cost_center             = $_cost_center_id ?? 0;
    $Accounts->_budget_id               = $_budget_id ?? 0;
    $Accounts->_serial                  = $key ?? 0;
    $Accounts->_name                    =  $auth_user->name;
    $Accounts->_sales_man_id            = $_sales_man_id ?? 0;
    $Accounts->save();


    


}






            
            return redirect()->route('asset_eng_consumptions.index')
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
        $data=AssetEngConsumption::with(['_asset_item','organization','branch','cost_center'])->where('is_delete',0)->where('_status',1)->find($id);
        if(empty($data)){
            return redirect()->route('asset_eng_consumptions.index')->with('danger', __('label.no_data_found'));
        }
        


        $page_name =$this->page_name;
        


        return view('apps.asset-management.asset_eng_consumptions.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=AssetEngConsumption::with(['_asset_item'])->where('is_delete',0)->where('_status',1)->find($id);
        if(empty($data)){
            return redirect()->route('asset_eng_consumptions.index')->with('danger', __('label.no_data_found'));
        }
        if($data->_lock ==1){
            return redirect()->route('asset_eng_consumptions.index')->with('danger', __('label.data_has_been_locked'));
        }
        $page_name =$this->page_name;
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
        $cost_centers = CostCenter::whereIn('id',$assign_costcenter_ids)->get();

          $budgets = \DB::table('budgets')->where('_status',1)->get();
        $departments = Department::get();
                           
        $buildings = AssetsDeviceLocation::where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $actual_locations = AssetsLocation::where('status',1)
                            ->where('is_delete',0)
                            ->get();


        return view('apps.asset-management.asset_eng_consumptions.create',compact('data','page_name','organizations','branchs','departments','cost_centers','buildings','actual_locations','budgets'));
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
         try {
            AssetEngConsumption::where('id',$id)->update(['is_delete'=>1,'_status'=>0]);
            return redirect()->route('asset_eng_consumptions.index')
            ->with('danger', __('label.info_deleted_successfully'));
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
