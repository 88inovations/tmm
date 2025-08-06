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
use App\Models\Basic\Store;
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
use DB;

class AssetReportController extends Controller
{
    //Cateogry Wise Asset Report

     public function categoryWiseAsset($id)
    {
          
$assign_org_ids = assign_org_ids();
$assign_branch_ids = assign_branch_ids();
$assign_department_ids = assign_department_ids();
$assign_costcenter_ids = assign_costcenter_ids();
$assign_building_ids = assign_building_ids();
$assign_actual_location_ids = assign_actual_location_ids();

        $data = AssetItem::with(['category','brand','condition','vendor','current_user','assign_status'])
        ->select('id', 'name', 'category_id', 'brand_id', 'vendor_id', 'asset_condition_id', 'assign_status_id', 'asset_code', 'model_no', 'serial_no',  'domain_intune', 'warranty_status', 'os_type', 'asset_tag', 'description', 'remarks')
        ->where('is_delete',0)
        ->whereIn('organization_id',$assign_org_ids)
         ->whereIn('branch_id',$assign_branch_ids)
         ->whereIn('project_id',$assign_costcenter_ids)
         ->whereIn('asset_location_id',$assign_building_ids)
         ->whereIn('asset_room_id',$assign_actual_location_ids)
         ->where('category_id',$id)->get();
         $category = AssetsCategory::find($id);

         $page_name = "Category Wise Asset List";
        return view('apps.asset-management.asset-report.category_wise_asset_list',compact('data','page_name','category'));
    }

    //Brand Wise Asset Report

     public function brandWiseAsset($id)
    {

        $assign_org_ids = assign_org_ids();
$assign_branch_ids = assign_branch_ids();
$assign_department_ids = assign_department_ids();
$assign_costcenter_ids = assign_costcenter_ids();
$assign_building_ids = assign_building_ids();
$assign_actual_location_ids = assign_actual_location_ids();

        $data = AssetItem::with(['category','brand','condition','vendor','current_user','assign_status'])
        ->select('id', 'name', 'category_id', 'brand_id', 'vendor_id', 'asset_condition_id', 'assign_status_id', 'asset_code', 'model_no', 'serial_no',  'domain_intune', 'warranty_status', 'os_type', 'asset_tag', 'description', 'remarks')
        ->where('is_delete',0)
        ->whereIn('organization_id',$assign_org_ids)
         ->whereIn('branch_id',$assign_branch_ids)
         ->whereIn('project_id',$assign_costcenter_ids)
         ->whereIn('asset_location_id',$assign_building_ids)
         ->whereIn('asset_room_id',$assign_actual_location_ids)
        ->where('brand_id',$id)
        ->get();
        $brand = AssetBrand::find($id);
        $page_name = "Brand Wise Asset List";
        return view('apps.asset-management.asset-report.brand_wise_asset_list',compact('data','page_name','brand'));
    }

    //conditionWiseAsset Wise Asset Report

     public function conditionWiseAsset($id)
    {

        $assign_org_ids = assign_org_ids();
$assign_branch_ids = assign_branch_ids();
$assign_department_ids = assign_department_ids();
$assign_costcenter_ids = assign_costcenter_ids();
$assign_building_ids = assign_building_ids();
$assign_actual_location_ids = assign_actual_location_ids();

        $data = AssetItem::with(['category','brand','condition','vendor','current_user','assign_status'])
        ->select('id', 'name', 'category_id', 'brand_id', 'vendor_id', 'asset_condition_id', 'assign_status_id', 'asset_code', 'model_no', 'serial_no',  'domain_intune', 'warranty_status', 'os_type', 'asset_tag', 'description', 'remarks')
        ->where('is_delete',0)
        ->whereIn('organization_id',$assign_org_ids)
         ->whereIn('branch_id',$assign_branch_ids)
         ->whereIn('project_id',$assign_costcenter_ids)
         ->whereIn('asset_location_id',$assign_building_ids)
         ->whereIn('asset_room_id',$assign_actual_location_ids)
        ->where('asset_condition_id',$id)
        ->get();

        $condition = AssetsCondition::find($id);

         $page_name = "Condition Wise Asset List";
        return view('apps.asset-management.asset-report.condition_wise_asset_list',compact('data','page_name','condition'));
    }


    //inspectionReport 
     public function inspectionReport($id)
    {
        $assign_org_ids = assign_org_ids();
$assign_branch_ids = assign_branch_ids();
$assign_department_ids = assign_department_ids();
$assign_costcenter_ids = assign_costcenter_ids();
$assign_building_ids = assign_building_ids();
$assign_actual_location_ids = assign_actual_location_ids();

         $data = AssetItem::with(['category','brand','condition','vendor','current_user','assign_status','_inspections'])
        ->select('id', 'name', 'category_id', 'brand_id', 'vendor_id', 'asset_condition_id', 'assign_status_id', 'asset_code', 'model_no', 'serial_no',  'domain_intune', 'warranty_status', 'os_type', 'asset_tag', 'description', 'remarks')
        ->where('is_delete',0)
        // ->whereIn('organization_id',$assign_org_ids)
        //  ->whereIn('branch_id',$assign_branch_ids)
        //  ->whereIn('project_id',$assign_costcenter_ids)
        //  ->whereIn('asset_location_id',$assign_building_ids)
        //  ->whereIn('asset_room_id',$assign_actual_location_ids)
        ->find($id);
        $inspection_cats = InspectionCheckCategory::with(['check_list'])->where('is_delete',0)->get();
        $_inspections = $data->_inspections ?? [];

         $page_name = __('label.EQUIPMENT_CONDITION_CHECKLIST');
        return view('apps.asset-management.asset-report.inspection_report',compact('data','page_name','inspection_cats','_inspections'));
    }





public function single_asset_depriciation(Request $request){

   //return $request->all();
    $page_name = __('label.single_asset_depriciation');
    $datas = [];
    $asset_item = '';

    if($request->has('_asset_id') && $request->_asset_id !=''){
        $_asset_id = $request->_asset_id ?? '';

        $datas = DB::select(" SELECT  t1._date,t1._dep_month,t1._dep_year,t2._asset_id,t2._asset_dep_rate,
            t2.book_value,t2._asset_dep_amount,t2.accumulated_dep_val,t3.name,t3.category_id,t3.purchase_date,
            t3.purchase_price,t3.evaluated_price
            FROM `asset_depreciations` AS t1
            INNER JOIN asset_depreciation_details as t2 ON (t1.id=t2._no AND t1._status=1)
            INNER JOIN asset_items AS t3 ON t3.id=t2._asset_id
            WHERE t1._status=1 AND t2._asset_id=$_asset_id
            ORDER BY CONCAT(LPAD(t1._dep_year, 4, '0'), LPAD(t1._dep_month, 2, '0'))  ASC ");

        $asset_item = AssetItem::where('id',$_asset_id)->first();
    }

  

    return view('apps.asset-management.asset-report.single_asset_depriciation',compact('datas','request','asset_item','page_name'));
}
public function single_asset_sales_report(Request $request){
    return view('apps.asset-management.asset-report.single_asset_sales_report',compact('datas'));
}
public function asset_sales_report(Request $request){
    $page_name = __('label.asset_sales_report');
    $asset_ledgers = \DB::select(" SELECT t1.id,t1._name FROM account_ledgers AS t1 WHERE t1.id IN( SELECT DISTINCT asset_ledger_id FROM asset_items) ORDER BY  t1._name  ASC ");
    $assets_categories = \DB::table("item_categories")->orderBy('_name','ASC')->get();

    $datas = [];
 //   return $request->all();
    $_ledger_id = $request->_ledger_id ?? '';
    $category_id = $request->category_id ?? '';
    $_asset_id = $request->_asset_id ?? '';
    $_start_date = $request->_start_date ?? '';
    $_end_date = $request->_end_date ?? date('Y-m-d');

    $sql_query = " SELECT t1.id,t1.name,t1.category_id,t1.asset_ledger_id,t1._is_sold,
t1.asset_code,t1.model_no,t1.serial_no,t1.evaluated_price,t1.accumulated_dep_val,t1.asset_tag,
t1.book_value,t1._selling_value,t1._pl_amount,t1._sale_date,t2._date,t2._order_number,
t2.voucher_id,t2.voucher_code,t2.payment_method,t2._asset_customer_id,t2._asset_id,t2._payment_receive_id,
t2.original_cost,t2.accumulated_depreciation,t2.sale_price,t2.book_value,t2.gain_loss,t3._name as _asset_ledger_name,
t4._name as _category_name,t5._name as customer_name
FROM `asset_items` AS t1
INNER JOIN asset_sales as t2 ON (t1.id=t2._asset_id AND t2._status=1)
INNER JOIN account_ledgers as t3 ON t3.id=t1.asset_ledger_id
INNER JOIN item_categories AS t4 ON t4.id=t1.category_id
INNER JOIN account_ledgers as t5 ON t5.id=t2._asset_customer_id
WHERE t1._is_sold=1  ";
if($_ledger_id  !=''){
    $sql_query .= " AND t1.asset_ledger_id= $_ledger_id ";
}
if($category_id  !=''){
    $sql_query .= " AND t1.category_id= $category_id ";
}

if($_asset_id  !=''){
    $sql_query .= " AND t2._asset_id= $_asset_id ";
}

if($_start_date !=""){
    $sql_query .= "  AND t1._sale_date  >= '".$_start_date."'  AND t1._sale_date <= '".$_end_date."' ";
}

 $datas = \DB::select($sql_query);
    

    return view('apps.asset-management.asset-report.asset_sales_report',compact('datas','page_name','asset_ledgers','assets_categories','request','_start_date','_end_date'));
}
public function asset_import_report(Request $request){
   $page_name = __('label.asset_sales_report');
    $asset_ledgers = [];
    $assets_categories = [];

    $datas = [];
 //   return $request->all();
    // $_ledger_id = $request->_ledger_id ?? '';
    // $category_id = $request->category_id ?? '';
    // $_asset_id = $request->_asset_id ?? '';
    $_start_date = $request->_start_date ?? '';
    $_end_date = $request->_end_date ?? date('Y-m-d');

    if($request->has('_start_date') && $request->_start_date !=''){
         $sql_query = " SELECT t1._date,t1._supplier_name,t1._voucher_number,t1._note,
t2._asset_name,t2._unit_id,t2._qty,t2._rate_usd,t2._cfr_value_usd,t2._cfr_value_bdt,t2._currency_rate_usd_to_bdt,
t2._insurance_bdt,t2._lc_commision_bdt,t2._custom_duty_bdt,t2._other_cost_bdt,t2._asset_value_bdt
FROM `asset_import_costs` as t1
INNER JOIN asset_import_cost_details as t2 ON (t1.id=t2._no AND t2._status=1)
WHERE t1._status=1    ";


if($_start_date !=""){
    $sql_query .= "  AND t1._date  >= '".$_start_date."'  AND t1._date <= '".$_end_date."' ";
}

 $datas = \DB::select($sql_query);
    }

   
    
    return view('apps.asset-management.asset-report.asset_import_report',compact('datas','page_name','asset_ledgers','assets_categories','request','_start_date','_end_date'));
}
public function all_asset_import_report(Request $request){
   

    return view('apps.asset-management.asset-report.all_asset_import_report',compact('datas'));
}
public function depriciation_report_all(Request $request){
     $page_name = __('label.depriciation_report_all');
    $asset_ledgers = \DB::select(" SELECT t1.id,t1._name FROM account_ledgers AS t1 WHERE t1.id IN( SELECT DISTINCT asset_ledger_id FROM asset_items) ORDER BY  t1._name  ASC ");
    $assets_categories = \DB::table("item_categories")->orderBy('_name','ASC')->get();

    $datas = [];
 //   return $request->all();
    $_ledger_id = $request->_ledger_id ?? '';
    $category_id = $request->category_id ?? '';
    $_asset_id = $request->_asset_id ?? '';
    $_start_date = $request->_start_date ?? '';
    $_end_date = $request->_end_date ?? date('Y-m-d');

    if($request->has('_start_date') && $request->_start_date !=''){
          $sql_query = " SELECT t2._asset_id,t3.name as _asset_name,t3.asset_code as _asset_tag,t3.model_no,t3.serial_no,
t5._name as cat_name,t4._name as ledger_name,t2.asset_ledger_id,
t3.purchase_price,t3.extra_cost,t3.evaluated_price,SUM(t2._asset_dep_amount) as _asset_dep_amount,t3.accumulated_dep_val
FROM `asset_depreciations` AS t1
INNER JOIN asset_depreciation_details AS t2 ON (t1.id=t2._no AND t2._status=1)
INNER JOIN asset_items AS t3 ON t3.id=t2._asset_id
INNER JOIN account_ledgers AS t4 ON t4.id=t2.asset_ledger_id
LEFT JOIN item_categories AS t5 ON t5.id=t3.category_id
WHERE t1._status=1  ";
        if($_ledger_id  !=''){
            $sql_query .= " AND t2.asset_ledger_id= $_ledger_id ";
        }
        if($category_id  !=''){
            $sql_query .= " AND t3.category_id= $category_id ";
        }

        if($_asset_id  !=''){
            $sql_query .= " AND t2._asset_id= $_asset_id ";
        }

        if($_start_date !=""){
            $sql_query .= "  AND t1._date  >= '".$_start_date."'  AND t1._date <= '".$_end_date."' ";
        }

        $sql_query .= " GROUP BY t2.asset_ledger_id,t2._asset_id ORDER BY t5._name ASC, t3.name ASC  ";

         $datas = \DB::select($sql_query);
    }

  
    

    return view('apps.asset-management.asset-report.depriciation_report_all',compact('datas','page_name','asset_ledgers','assets_categories','request','_start_date','_end_date'));

}
public function asset_valuation_report(Request $request){
    return view('apps.asset-management.asset-report.asset_valuation_report',compact('datas'));
}
public function asset_utilization_report(Request $request){
    return view('apps.asset-management.asset-report.asset_utilization_report',compact('datas'));
}


public function maintenance_and_repair_costs_report(Request $request){
    $page_name = __('label.maintenance_and_repair_costs_report');
    $asset_ledgers = \DB::select(" SELECT t1.id,t1._name FROM account_ledgers AS t1 WHERE t1.id IN( SELECT DISTINCT asset_ledger_id FROM asset_items) ORDER BY  t1._name  ASC ");
    $assets_categories = \DB::table("item_categories")->orderBy('_name','ASC')->get();

    $datas = [];
 //   return $request->all();
    $_ledger_id = $request->_ledger_id ?? '';
    $category_id = $request->category_id ?? '';
    $_asset_id = $request->_asset_id ?? '';
    $_start_date = $request->_start_date ?? '';
    $_end_date = $request->_end_date ?? date('Y-m-d');

    if($request->has('_start_date') && $request->_start_date !=''){
          $sql_query = " SELECT t2.asset_id,t3.name as _asset_name,t3.asset_code as _asset_tag,t3.model_no,t3.serial_no,
t5._name as cat_name,t4._name as ledger_name,t3.asset_ledger_id,t2._date,t2.cost,t2.technician_name,t2._note,t2._voucher_number

FROM asset_maintainces AS t2 
INNER JOIN asset_items AS t3 ON t3.id=t2.asset_id
INNER JOIN account_ledgers AS t4 ON t4.id=t3.asset_ledger_id
LEFT JOIN item_categories AS t5 ON t5.id=t3.category_id
WHERE t2._status=1  ";
        if($_ledger_id  !=''){
            $sql_query .= " AND t2.asset_ledger_id= $_ledger_id ";
        }
        if($category_id  !=''){
            $sql_query .= " AND t3.category_id= $category_id ";
        }

        if($_asset_id  !=''){
            $sql_query .= " AND t2.asset_id= $_asset_id ";
        }

        if($_start_date !=""){
            $sql_query .= "  AND t2._date  >= '".$_start_date."'  AND t2._date <= '".$_end_date."' ";
        }

        $sql_query .= "  ORDER BY t2._date ASC,t5._name ASC, t3.name ASC  ";

         $datas = \DB::select($sql_query);
    }

  
    

    return view('apps.asset-management.asset-report.maintenance_and_repair_costs_report',compact('datas','page_name','asset_ledgers','assets_categories','request','_start_date','_end_date'));
}







public function asset_eng_consumptions_report(Request $request){
    $page_name = __('label.asset_eng_consumptions_report');
    $asset_ledgers = \DB::select(" SELECT t1.id,t1._name FROM account_ledgers AS t1 WHERE t1.id IN( SELECT DISTINCT asset_ledger_id FROM asset_items) ORDER BY  t1._name  ASC ");
    $assets_categories = \DB::table("item_categories")->orderBy('_name','ASC')->get();

    $datas = [];
 //   return $request->all();
    $_ledger_id = $request->_ledger_id ?? '';
    $category_id = $request->category_id ?? '';
    $_asset_id = $request->_asset_id ?? '';
    $_start_date = $request->_start_date ?? '';
    $_end_date = $request->_end_date ?? date('Y-m-d');

    if($request->has('_start_date') && $request->_start_date !=''){
          $sql_query = " SELECT t2.asset_id,t3.name as _asset_name,t3.asset_code as _asset_tag,t3.model_no,t3.serial_no,
t5._name as cat_name,t4._name as ledger_name,t3.asset_ledger_id,t2._date,t2.cost,t2._voucher_number

FROM asset_eng_consumptions AS t2 
INNER JOIN asset_items AS t3 ON t3.id=t2.asset_id
INNER JOIN account_ledgers AS t4 ON t4.id=t3.asset_ledger_id
LEFT JOIN item_categories AS t5 ON t5.id=t3.category_id
WHERE t2._status=1  ";
        if($_ledger_id  !=''){
            $sql_query .= " AND t2.asset_ledger_id= $_ledger_id ";
        }
        if($category_id  !=''){
            $sql_query .= " AND t3.category_id= $category_id ";
        }

        if($_asset_id  !=''){
            $sql_query .= " AND t2.asset_id= $_asset_id ";
        }

        if($_start_date !=""){
            $sql_query .= "  AND t2._date  >= '".$_start_date."'  AND t2._date <= '".$_end_date."' ";
        }

        $sql_query .= "  ORDER BY t2._date ASC,t5._name ASC, t3.name ASC  ";

         $datas = \DB::select($sql_query);
    }

  
    

    return view('apps.asset-management.asset-report.asset_eng_consumptions_report',compact('datas','page_name','asset_ledgers','assets_categories','request','_start_date','_end_date'));
}







public function total_asset_value_report(Request $request){
    return view('apps.asset-management.asset-report.total_asset_value_report',compact('datas'));
}
public function asset_status_report(Request $request){
    return view('apps.asset-management.asset-report.asset_status_report',compact('datas'));
}
public function asset_location_report(Request $request){
    return view('apps.asset-management.asset-report.asset_location_report',compact('datas'));
}
public function insurance_coverage_report(Request $request){
    return view('apps.asset-management.asset-report.insurance_coverage_report',compact('datas'));
}


    /*
    *
    *
    * Display Asset Management all Report List
    */
    public function AssetReportPage(){
        $page_name = __('label.asset-management-report');
        return view('apps.asset-management.asset-report.report_page',compact('page_name'));
    }

    /*
    *
    *
    * Display Asset  List Filter Page
    */
    public function listFilter(Request $request){

   // return $request->all();
       
        $page_name      = __('label.Asset List');
        $limit          =$request->limit ?? default_pagination();
        $order_column   =$request->order_column ?? 'id';
        $order_by       =$request->order_by ?? 'DESC';

        $organizations  = Organization::whereIn('id',assign_org_ids())->get();
        $branchs        = Branch::whereIn('id',assign_branch_ids())->get();
        $cost_centers   = CostCenter::whereIn('id',assign_costcenter_ids())->get();
        $stores         = Store::whereIn('id',assign_store_ids())->get();


        $asset_brands   = \DB::table('item_brands')
                            ->orderBy('_name','ASC')
                            ->get();
        $conditions     = AssetsCondition::where('status',1)
                            ->where('is_delete',0)
                            ->orderBy('order','asc')
                            ->orderBy('name','ASC')
                            ->get();
        $assign_org_ids = assign_org_ids();
$assign_branch_ids = assign_branch_ids();
$assign_department_ids = assign_department_ids();
$assign_costcenter_ids = assign_costcenter_ids();
$assign_building_ids = assign_building_ids();
$assign_actual_location_ids = assign_actual_location_ids();

if($request->has('asset_list_filter') && $request->asset_list_filter=="list_filter"){
    $data = AssetItem::with(['category','brand','condition','vendor','current_user','assign_status'])
    ->select('id','name','category_id','brand_id','vendor_id','asset_condition_id','assign_status_id','asset_code','model_no','serial_no','group_serial_no','domain_intune','asset_image_1','asset_image_2','warranty_start_date','warranty_end_date','warranty_status','os_type','purchase_date','_date','year_manufacture','origin','purchase_voucher_no','purchase_price','entry_price','evaluated_price','dep_type','dep_rate','dep_value','accumulated_dep_val','estimated_life','asset_tag','description','remarks','status','is_delete','order','created_at','updated_at','branch_id')
    ->where('is_delete',0);
    if($request->has('assign_status_id') && $request->assign_status_id !=""){
        $data =$data->where('assign_status_id',$request->assign_status_id);
    }
    if($request->has('asset_condition_id') && $request->asset_condition_id !=""){
        $data =$data->where('asset_condition_id',$request->asset_condition_id);
    }
    if($request->has('organization_id') && $request->organization_id !=""){
        $data =$data->where('organization_id',$request->organization_id);
    }
    if($request->has('branch_id') && $request->branch_id !=""){
        $data =$data->where('branch_id',$request->branch_id);
    }
    if($request->has('cost_center_id') && $request->cost_center_id !=""){
         $data =$data->where('project_id',$request->cost_center_id);
    }
    if($request->has('category_id') && $request->category_id !=""){
         $data =$data->where('category_id',$request->category_id);
        
    }

     $data =$data->get();
}else{
    $data = [];
}


        

        return view('apps.asset-management.asset-report.filter_list',compact('page_name','request','conditions','organizations','branchs','cost_centers','stores','data'));
    }
}


