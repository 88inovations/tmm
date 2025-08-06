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

class AssetItemController extends Controller
{

     function __construct()
    {
         $this->middleware('permission:asset-entry-assign-list|asset-entry-assign-create|asset-entry-assign-edit|asset-entry-assign-delete', ['only' => ['index','store']]);
         $this->middleware('permission:asset-entry-assign-create', ['only' => ['create','store']]);
         $this->middleware('permission:asset-entry-assign-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:asset-entry-assign-delete', ['only' => ['destroy']]);
        $this->page_name = __('label.asset-entry-assign');
        $this->new_page_name = __('label.new_asset-entry-assign');
        $this->edit_page_name = __('label.edit_asset-entry-assign');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
    {

  //  dump($request->all());
        $limit=$request->limit ?? default_pagination();
        $order_column=$request->order_column ?? 'id';
        $order_by=$request->order_by ?? 'DESC';
        $asset_brands = \DB::table('item_brands')->orderBy('_name','ASC')->get();
         $conditions = AssetsCondition::where('status',1)
                        ->where('is_delete',0)
                        ->orderBy('order','asc')
                        ->orderBy('name','ASC')
                        ->get();

        
// $assign_org_ids = assign_org_ids();
// $assign_branch_ids = assign_branch_ids();
// $assign_department_ids = assign_department_ids();
// $assign_costcenter_ids = assign_costcenter_ids();
// $assign_building_ids = assign_building_ids();
// $assign_actual_location_ids = assign_actual_location_ids();

        $organizations = Organization::where('_status',1)
                            ->where('is_delete',0)
                            ->get();
        $branchs = Branch::where('_status',1)
                            ->get();
        $departments = Department::where('_status',1)
                            ->get();
        $cost_centers = CostCenter::where('_status',1)
                            ->get();
        $buildings = AssetsDeviceLocation::where('status',1)
                            ->where('is_delete',0)
                            ->get();
        $actual_locations = AssetsLocation::where('status',1)
                            ->where('is_delete',0)
                            ->get();








        

        $data = AssetItem::with(['category','brand','condition','vendor','assign_status','current_user'])
        ->where('is_delete',0);

         $data_count = $data->count();

     if($request->has('organization_id') && !empty($request->organization_id) ){
        $data =   $data->where('organization_id',$request->organization_id);
     }

     if($request->has('branch_id') && !empty($request->branch_id) ){
        $data =   $data->where('branch_id',$request->branch_id);
     }

     if($request->has('project_id') && !empty($request->project_id) ){
        $data =   $data->where('project_id',$request->project_id);
     }

     if($request->has('asset_location_id') && !empty($request->asset_location_id) ){
        $data =   $data->where('asset_location_id',$request->asset_location_id);
     }

     if($request->has('asset_room_id') && !empty($request->asset_room_id) ){
        $data =   $data->where('asset_room_id',$request->asset_room_id);
     }


     if($request->has('id') && !empty($request->id) ){
        $data =   $data->where('id',$request->id);
     }
     if($request->has('assign_status_id') && !empty($request->assign_status_id) ){
        $data =   $data->where('assign_status_id',$request->assign_status_id);
     }
     if($request->has('category_id') && !empty($request->category_id) ){
        $data =   $data->where('category_id',$request->category_id);
     }
     if($request->has('asset_condition_id') && !empty($request->asset_condition_id) ){
        $data =   $data->where('asset_condition_id',$request->asset_condition_id);
     }
     if($request->has('asset_tag') && !empty($request->asset_tag) ){
        $data =   $data->where('asset_tag','like',"%$request->asset_tag%");
        $data =   $data->orWhere('serial_no','like',"%$request->asset_tag%");
        $data =   $data->orWhere('asset_code','like',"%$request->asset_tag%");
     }
     if($request->has('asset_code') && !empty($request->asset_code) ){
        $data =   $data->where('asset_code','like',"%$request->asset_code%");
     }
     if($request->has('name') && !empty($request->name) ){
        $data =   $data->where('name','like',"%$request->name%");
     }
     if($request->has('model_no') && !empty($request->model_no) ){
        $data =   $data->where('model_no','like',"%$request->model_no%");
     }
     if($request->has('description') && !empty($request->description) ){
        $data =   $data->where('description','like',"%$request->description%");
     }
     if($request->has('remarks') && !empty($request->remarks) ){
        $data =   $data->where('remarks','like',"%$request->remarks%");
     }
     if($request->has('year_manufacture') && !empty($request->year_manufacture) ){
        $data =   $data->where('year_manufacture','like',"%$request->year_manufacture%");
     }
     if($request->has('origin') && !empty($request->origin) ){
        $data =   $data->where('origin','like',"%$request->origin%");
     }
     if($request->has('serial_no') && !empty($request->serial_no) ){
        $data =   $data->where('serial_no','like',"%$request->serial_no%");
     }

    

        if($limit !='all'){
         $data =   $data->orderBy($order_column,$order_by)->paginate($data_count);
        }else{
        //$data_count = $data->count();
            $data =   $data->orderBy($order_column,$order_by)->paginate($data_count);
        }

        
  //return $data ;
        $page_name = $this->page_name;
        return view('apps.asset-management.asset_item_entry.index',compact('data','page_name','request','conditions','organizations','branchs','departments','cost_centers','buildings','actual_locations','data_count'));

        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
        $new_page_name = $this->new_page_name;
        $organizations =Organization::orderBy('order','ASC')->get();
          $_org_branches = \DB::table("branches")->where('_status',1)->get();
        $_org_cost_centers = \DB::table("cost_centers")->where('_status',1)->get();
        $_org_stores = \DB::table("store_houses")->where('_status',1)->get();
        $budgets = \DB::table("budgets")->where('_status',1)->get();

         $categories_data = \App\Models\ItemCategory::orderBy('_name','ASC')->get();
         $categories = [];
         foreach($categories_data as $value){
            $categories[] = $value;
         }
         $ass_brands = \App\Models\ItemBrand::orderBy('_name','ASC')->get();
        $ass_conditions = AssetsCondition::orderBy('name','ASC')->get();
        $ass_buildings = \DB::table('hrm_emp_locations')->orderBy('_name','ASC')->get();
        $ass_rooms = AssetsDeviceLocation::orderBy('name','ASC')->get();

        // $ass_users = AssetsUser::with(['organization','branch','department','designation'])->where('is_delete',0)
        //                 ->orderBy('order','ASC')
        //                 ->orderBy('name','ASC')->get();
        // $ass_vendors = AssetsVendor::where('is_delete',0)
        //                 ->orderBy('order','ASC')
        //                 ->orderBy('name','ASC')->get();

        $ass_users =[];


    $account_group_configs = \DB::table("account_group_configs")->select('_supplier_group')->first();

        $supplier_groups_string = $account_group_configs->_supplier_group ?? 0;
        $supplier_groups_array = explode(",", $supplier_groups_string);

        $ass_vendors = \App\Models\AccountLedger::with(['account_type','account_group'])->whereIn('_account_group_id',$supplier_groups_array)->get();

        
        $assign_status = AssignStatus::where('is_delete',0)
                        ->orderBy('order','ASC')
                        ->orderBy('name','ASC')->get();
        $cost_centers = CostCenter::orderBy('_name','ASC')->get();

        $inspection_cats = InspectionCheckCategory::with(['check_list'])->where('is_delete',0)->get();


        //AssestDepreciation
       // AssestDispoal
        //AssestRepair
        //AssetAssign
        //AssetInspection
       // AssetItem
        

        return view('apps.asset-management.asset_item_entry.create',compact('page_name','new_page_name','organizations','categories','ass_brands','ass_conditions','ass_rooms','ass_buildings','ass_users','ass_vendors','cost_centers','inspection_cats','assign_status','organizations','_org_branches','_org_cost_centers','_org_stores','budgets'));







    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        //return $request->all();

         $request->validate([
            'name'=>'required',
            'asset_dep_ledger_id'=>'required',
            'asset_dep_exp_ledger_id'=>'required',
            'asset_ledger_id'=>'required',
            'category_id'=>'required',
            
        ]);

        try {
           
// "organization_id": null,
// "branch_id": null,
// "project_id": null,
// "asset_location_id": null,
// "asset_room_id": null,
$category_id = $request->category_id;
$organization_id = $request->organization_id;
$branch_id = $request->branch_id;
$project_id = $request->project_id;

  $cat_code =  id_wise_name($category_id,'item_categories','_code');
  $organization_code =  id_wise_name($organization_id,'companies','_code');
  $branch_code =  id_wise_name($branch_id,'branches','_code');
  $project_code =  id_wise_name($project_id,'cost_centers','_code');



  $cat_wise_asset_count = \DB::table('asset_items')->where('category_id',$category_id)->count();
  $cat_wise_asset_count = ($cat_wise_asset_count+1);

   $cat_wise_asset_count =  str_pad($cat_wise_asset_count, 3, '0', STR_PAD_LEFT);
  $asset_code = $cat_code."-".$cat_wise_asset_count;




//   $group_wise_asset_count = \DB::table('asset_assigns')
//         ->where('organization_id',$organization_id)
//         ->where('asset_category_id',$category_id)
//         ->where('branch_id',$branch_id)
//         ->where('project_id',$project_id)
//         ->count();
//   $group_wise_asset_count = ($group_wise_asset_count+1);

//    $group_wise_asset_count =  str_pad($group_wise_asset_count, 3, '0', STR_PAD_LEFT);
//   $group_serial_no = $organization_code."/".$branch_code."/".$project_code."/".$cat_code."-".$group_wise_asset_count;

// $assign_unique_serial = $group_serial_no;

  $group_serial_no='';
  $category_id = $request->category_id ?? 0;

   $asset_code = category_wise_serial($category_id);
   $serial_no = category_wise_serial($category_id);

        $userInfo = \Auth::user();
        $AssetItem = new AssetItem();
        $AssetItem->name = $request->name ?? '';
        $AssetItem->_item_id = $request->_item_id ?? '';
        $AssetItem->category_id = $request->category_id ?? 0;

         $AssetItem->organization_id = $request->organization_id ?? 0;
        $AssetItem->branch_id = $request->branch_id ?? 0;
        $AssetItem->project_id = $request->project_id ?? 0;
        $AssetItem->_budget_id = $request->_budget_id ?? 0;


        $AssetItem->asset_location_id = $request->asset_location_id ?? 0;
        $AssetItem->asset_room_id = $request->asset_room_id ?? 0;

        $AssetItem->import_cost_detail_id = $request->import_cost_detail_id ?? 0;
        $AssetItem->insured_amount = $request->insured_amount ?? 0;
        $AssetItem->annual_benefit = $request->annual_benefit ?? 0;
        $AssetItem->compliance_status = $request->compliance_status ?? '';
        $AssetItem->risk_level = $request->risk_level ?? '';
        $AssetItem->utilization_rate = $request->utilization_rate ?? '';
        $AssetItem->service_agreement_expiry = $request->service_agreement_expiry ?? '';

        $AssetItem->dep_date = $request->dep_date ?? ''; 
        $AssetItem->asset_ledger_id = $request->asset_ledger_id ?? 0;
        $AssetItem->asset_dep_ledger_id = $request->asset_dep_ledger_id ?? 0;
        $AssetItem->asset_dep_exp_ledger_id = $request->asset_dep_exp_ledger_id ?? 0;
        $AssetItem->extra_cost = $request->extra_cost ?? 0;
        $AssetItem->accumulated_dep_val = $request->accumulated_dep_val ?? 0;
       
        $AssetItem->brand_id = $request->brand_id ?? 0;
        $AssetItem->vendor_id = $request->vendor_id ?? 0;
        $AssetItem->asset_condition_id = $request->condition_id ?? 0;
        $AssetItem->assign_status_id = $request->assign_status_id ?? 0;


        $AssetItem->asset_code = $asset_code ?? 1; //Organization Asset Number


        $AssetItem->model_no = $request->model_no ?? ''; 
        $AssetItem->serial_no = $erial_no ?? '';
        $AssetItem->group_serial_no = $group_serial_no ?? ''; //
        $AssetItem->domain_intune = $request->domain_intune ?? ''; 
        if($request->has('asset_image_1')){
            $AssetItem->asset_image_1 = _imageUploader($request->asset_image_1); 
        }
        if($request->has('asset_image_2')){
            $AssetItem->asset_image_2 = _imageUploader($request->asset_image_2); 
        }
        $AssetItem->warranty_start_date = $request->warranty_start_date ?? ''; 
        $AssetItem->warranty_end_date = $request->warranty_end_date ?? ''; 
        $AssetItem->warranty_status = $request->warranty_status ?? ''; 
        $AssetItem->os_type = $request->os_type ?? ''; 
        $AssetItem->purchase_date = $request->purchase_date ?? ''; 

        // $AssetItem->dep_date = $request->dep_date ?? ''; 
        // $AssetItem->asset_ledger_id = $request->asset_ledger_id ?? 0;
        // $AssetItem->extra_cost = $request->extra_cost ?? 0; 

        $AssetItem->_date = date('Y-m-d'); 
        $AssetItem->year_manufacture = $request->year_manufacture ?? ''; 
        $AssetItem->origin = $request->origin ?? ''; 
        $AssetItem->purchase_voucher_no = $request->purchase_voucher_no ?? ''; 
        $AssetItem->purchase_price = $request->purchase_price ?? ''; 
        $AssetItem->estimated_life = $request->estimated_life ?? ''; 
        $AssetItem->entry_price = $request->entry_price ?? 0; 
        $AssetItem->evaluated_price = $request->evaluated_price ?? 0; 
        $AssetItem->salvage_value = $request->salvage_value ?? 0; 
        $AssetItem->dep_type = $request->dep_type ?? 0; 
        $AssetItem->dep_rate = $request->dep_rate ?? 0; 
        $AssetItem->dep_value = $request->dep_value ?? 0; 
        $AssetItem->asset_tag = $request->asset_tag ?? ''; //if asset tag is empty then use an formula
        $AssetItem->description = $request->description ?? ''; 
        $AssetItem->remarks = $request->remarks ?? ''; 
        $AssetItem->status = $request->status ?? 1; 
        $AssetItem->is_delete = 0; 
        $AssetItem->order = 1; 
        $AssetItem->save(); 

       



            return redirect()->route('asset_item_entry.index')
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
     public function edit($id)
    {

        $page_name = $this->page_name;
         $edit_page_name = $this->edit_page_name;
        $data = AssetItem::with(['category_ledger','category','brand','condition','vendor','current_user','assign_status','_inspections'])->find($id);
        $current_user = $data->current_user ?? '';
                //return $data->category_ledger->_name ;
        $organizations =Organization::where('is_delete',0)->orderBy('order','ASC')->get();

        $_org_branches = \DB::table("branches")->where('_status',1)->get();
        $_org_cost_centers = \DB::table("cost_centers")->where('_status',1)->get();
        $_org_stores = \DB::table("store_houses")->where('_status',1)->get();
        $budgets = \DB::table("budgets")->where('_status',1)->get();

          $categories_data = AssetsCategory::orderBy('_name','ASC')->get();
         $categories = [];
         foreach($categories_data as $value){
            $categories[] = $value;
         }
         $ass_brands = AssetBrand::get();
        $ass_conditions = AssetsCondition::where('is_delete',0)
                        ->orderBy('order','ASC')
                        ->orderBy('name','ASC')->get();
        $ass_rooms = AssetsDeviceLocation::where('is_delete',0)
                        ->orderBy('order','ASC')
                        ->orderBy('name','ASC')->get();
        $ass_buildings = AssetsLocation::where('is_delete',0)
                        ->orderBy('order','ASC')
                        ->orderBy('name','ASC')->get();
        $assets_categories = \DB::table("item_categories")->get();

         $ass_users = [];
            $account_group_configs = \DB::table("account_group_configs")->select('_supplier_group')->first();

        $supplier_groups_string = $account_group_configs->_supplier_group ?? 0;
        $supplier_groups_array = explode(",", $supplier_groups_string);

        $ass_vendors = \App\Models\AccountLedger::with(['account_type','account_group'])->whereIn('_account_group_id',$supplier_groups_array)->get();

        // $ass_vendors = AssetsVendor::where('is_delete',0)
        //                 ->orderBy('order','ASC')
        //                 ->orderBy('name','ASC')->get();
        $assign_status = AssignStatus::where('is_delete',0)
                        ->orderBy('order','ASC')
                        ->orderBy('name','ASC')->get();
        $cost_centers = CostCenter::where('is_delete',0)->orderBy('order','ASC')->get();

        $inspection_cats = [];
        return view('apps.asset-management.asset_item_entry.edit',compact('page_name','data','categories','ass_brands','ass_conditions','ass_rooms','ass_buildings','ass_users','ass_vendors','assign_status','cost_centers','inspection_cats','organizations','current_user','assets_categories','organizations','_org_branches','_org_cost_centers','_org_stores','budgets'));






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
          //dump($request->all());
         // die();
        $request->validate([
            'name'=>'required',
            'asset_ledger_id'=>'required',
            'asset_dep_ledger_id'=>'required',
            'asset_dep_exp_ledger_id'=>'required',
            'status' => 'required|max:20',
        ]);

        try {
           

        $userInfo = \Auth::user();
        $AssetItem =AssetItem::find($id);

        $AssetItem->dep_date = $request->dep_date ?? ''; 
        $AssetItem->asset_ledger_id = $request->asset_ledger_id ?? 0;
        $AssetItem->asset_dep_ledger_id = $request->asset_dep_ledger_id ?? 0;
        $AssetItem->asset_dep_exp_ledger_id = $request->asset_dep_exp_ledger_id ?? 0;
        $AssetItem->extra_cost = $request->extra_cost ?? 0;
        $AssetItem->accumulated_dep_val = $request->accumulated_dep_val ?? 0;

        $AssetItem->organization_id = $request->organization_id ?? 0;
        $AssetItem->branch_id = $request->branch_id ?? 0;
        $AssetItem->project_id = $request->project_id ?? 0;
        $AssetItem->_budget_id = $request->_budget_id ?? 0;

        $AssetItem->asset_location_id = $request->asset_location_id ?? 0;
        $AssetItem->asset_room_id = $request->asset_room_id ?? 0;

        $AssetItem->import_cost_detail_id = $request->import_cost_detail_id ?? 0;
        $AssetItem->insured_amount = $request->insured_amount ?? 0;
        $AssetItem->annual_benefit = $request->annual_benefit ?? 0;
        $AssetItem->compliance_status = $request->compliance_status ?? '';
        $AssetItem->risk_level = $request->risk_level ?? '';
        $AssetItem->utilization_rate = $request->utilization_rate ?? '';
        $AssetItem->service_agreement_expiry = $request->service_agreement_expiry ?? '';



        $AssetItem->name = $request->name ?? '';
        $AssetItem->_item_id = $request->_item_id ?? '';
        $AssetItem->category_id = $request->category_id ?? 0;
        $AssetItem->brand_id = $request->brand_id ?? 0;
        $AssetItem->vendor_id = $request->vendor_id ?? 0;
        $AssetItem->asset_condition_id = $request->asset_condition_id ?? 0;
        $AssetItem->assign_status_id = $request->assign_status_id ?? 0;
        //$AssetItem->asset_code = $request->asset_code ?? 1; //Organization Asset Number
        $AssetItem->model_no = $request->model_no ?? ''; 
        $AssetItem->serial_no = $request->serial_no ?? '';
        $AssetItem->group_serial_no = $request->group_serial_no ?? ''; //
        $AssetItem->domain_intune = $request->domain_intune ?? ''; 
        if($request->has('asset_image_1')){
            $AssetItem->asset_image_1 = _imageUploader($request->asset_image_1); 
        }
        if($request->has('asset_image_2')){
            $AssetItem->asset_image_2 = _imageUploader($request->asset_image_2); 
        }
        $AssetItem->warranty_start_date = $request->warranty_start_date ?? ''; 
        $AssetItem->warranty_end_date = $request->warranty_end_date ?? ''; 
        $AssetItem->warranty_status = $request->warranty_status ?? ''; 
        $AssetItem->os_type = $request->os_type ?? ''; 
        $AssetItem->purchase_date = $request->purchase_date ?? ''; 
        $AssetItem->_date = date('Y-m-d'); 
        $AssetItem->year_manufacture = $request->year_manufacture ?? ''; 
        $AssetItem->origin = $request->origin ?? ''; 
        $AssetItem->purchase_voucher_no = $request->purchase_voucher_no ?? ''; 
        $AssetItem->purchase_price = $request->purchase_price ?? ''; 
        $AssetItem->estimated_life = $request->estimated_life ?? ''; 
        $AssetItem->entry_price = $request->entry_price ?? 0; 
        $AssetItem->evaluated_price = $request->evaluated_price ?? 0; 
        $AssetItem->salvage_value = $request->salvage_value ?? 0; 
        $AssetItem->dep_type = $request->dep_type ?? 0; 
        $AssetItem->dep_rate = $request->dep_rate ?? 0; 
        $AssetItem->dep_value = $request->dep_value ?? 0; 
        $AssetItem->asset_tag = $request->asset_tag ?? ''; //if asset tag is empty then use an formula
        $AssetItem->description = $request->description ?? ''; 
        $AssetItem->remarks = $request->remarks ?? ''; 
        $AssetItem->status = $request->status ?? 1; 
        $AssetItem->is_delete = 0; 
        $AssetItem->order = 1; 
        $AssetItem->save(); 

        
            return redirect()->route('asset_item_entry.index')
            ->with('success', __('label.info_updated'));
        } catch (Throwable $e) {
            report($e);
     
            return false;
        }
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
