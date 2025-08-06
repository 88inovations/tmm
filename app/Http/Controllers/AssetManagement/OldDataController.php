<?php

namespace App\Http\Controllers\AssetManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportOldData;
use App\Models\AssetManagement\AssetOldData;
use App\Models\Basic\Branch; //1
use App\Models\AssetManagement\AssetsCategory; //2
use App\Models\AssetManagement\AssetsCondition; //3
use App\Models\AssetManagement\AssetsLocation; //4
use App\Models\AssetManagement\AssetsDeviceLocation; //5
use App\Models\AssetManagement\AssetBrand; //6
use App\Models\AssetManagement\AssetsUser; //7
use App\Models\AssetManagement\AssetsVendor; //8
use App\Models\AssetManagement\AssetAssign; //10
use App\Models\AssetManagement\AssetItem; //11

class OldDataController extends Controller
{

      function __construct()
    {
         $this->middleware('permission:old-data-list|old-data-import-create|old-data-import-edit|old-data-import-delete', ['only' => ['index','store']]);
         $this->middleware('permission:old-data-import-create', ['only' => ['create','store']]);
         $this->middleware('permission:old-data-import-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:old-data-import-delete', ['only' => ['destroy']]);
        $this->page_name = __('label.old-data-import');
        $this->new_page_name = __('label.new_old-data-import');
        $this->edit_page_name = __('label.edit_old-data-import');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $page_name = $this->page_name;
        return view('apps.asset-management.old-data.index',compact('page_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
        return view('apps.asset-management.old-data.create',compact('page_name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('file')){
            Excel::import(new ImportOldData,
                      $request->file('file')->store('files'));
                return redirect()->back();
                dump($request->all());
                
        }
        
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function oldDataInsert(Request $request)
    {
        $excel_file_datas = \DB::table("asset_old_data")->get();

        $table_name=$request->table_name;

        if($table_name =="branch"){ //branch data insert ##1
            foreach($excel_file_datas as $key=>$val){
                $campus_location = $val->campus_location ?? '';
                if($campus_location !=''){
                    $Branch = Branch::where('name',$campus_location)->first();
                    if(empty($Branch)){
                        $Branch = new Branch();
                        $Branch->name = $campus_location;
                        $Branch->code = takeFirstLetter($campus_location);
                        $Branch->save();
                    }

                }
            }
        } //End of branch data
        if($table_name =="assets_categories"){ //assets_categories data insert ##2
            foreach($excel_file_datas as $key=>$val){
                $category = $val->category ?? '';
                if($category !=''){
                    $data = AssetsCategory::where('name',$category)->first();
                    if(empty($data)){
                        $data = new AssetsCategory();
                        $data->name = $category;
                        $data->code = takeFirstLetter($category);
                        $data->save();
                    }

                }
            }
        } //End of assets_categories data
        if($table_name =="assets_conditions"){ //assets_conditions data insert ##3
            foreach($excel_file_datas as $key=>$val){
                $condition = $val->condition ?? '';
                if($condition !=''){
                    $data = AssetsCondition::where('name',$condition)->first();
                    if(empty($data)){
                        $data = new AssetsCondition();
                        $data->name = $condition;
                        $data->code = takeFirstLetter($condition);
                        $data->save();
                    }

                }
            }
        } //End of assets_conditions data
        if($table_name =="assets_device_locations"){ //assets_device_locations data insert ##4
            foreach($excel_file_datas as $key=>$val){
                $campus_location = $val->campus_location ?? '';
                if($campus_location !=''){
                    $data = AssetsLocation::where('name',$campus_location)->first();
                    if(empty($data)){
                        $data = new AssetsLocation();
                        $data->name = $campus_location;
                        $data->code = takeFirstLetter($campus_location);
                        $data->save();
                    }

                }
            }
        } //End of assets_device_locations data
        if($table_name =="assets_locations"){ //assets_locations data insert ##5
            foreach($excel_file_datas as $key=>$val){
                $room_device_location = $val->room_device_location ?? '';
                if($room_device_location !=''){
                    $data = AssetsDeviceLocation::where('name',$room_device_location)->first();
                    if(empty($data)){
                        $data = new AssetsDeviceLocation();
                        $data->name = $room_device_location;
                        $data->code = takeFirstLetter($room_device_location);
                        $data->save();
                    }

                }
            }
        } //End of assets_locations data
        if($table_name =="asset_brands"){ //asset_brands data insert ##6
            foreach($excel_file_datas as $key=>$val){
                $supplier_vendor = $val->supplier_vendor ?? '';
                if($supplier_vendor !=''){
                    $data = AssetBrand::where('name',$supplier_vendor)->first();
                    if(empty($data)){
                        $data = new AssetBrand();
                        $data->name = $supplier_vendor;
                        $data->code = takeFirstLetter($supplier_vendor);
                        $data->save();
                    }

                }
            }
        } //End of asset_brands data
        if($table_name =="assets_vendors"){ //assets_vendors data insert ##7
            foreach($excel_file_datas as $key=>$val){
                $supplier_vendor = $val->supplier_vendor ?? '';
                if($supplier_vendor !=''){
                    $data = AssetsVendor::where('name',$supplier_vendor)->first();
                    if(empty($data)){
                        $data = new AssetsVendor();
                        $data->name = $supplier_vendor;
                        $data->code = takeFirstLetter($supplier_vendor);
                        $data->save();
                    }

                }
            }
        } //End of assets_vendors data
        if($table_name =="assets_users"){ //assets_users data insert ##8
            foreach($excel_file_datas as $key=>$val){
                $assets_users = $val->assigned_user ?? '';
                $organization_id =1;
                $branch_id = find_branch_id($val->campus_location ?? '');
                //$department_id = find_department_id($val->campus_location ?? '');
                //$designation_id = find_designation_id($val->campus_location ?? '');

                if($assets_users !=''){

                    $data = AssetsUser::where('name',$assets_users)->first();
                    if(empty($data)){
                        $data = new AssetsUser();
                        $data->name = $assets_users;
                        $data->organization_id = $organization_id;
                        $data->branch_id = $branch_id;
                        $data->save();
                    }

                }
            }
        } //End of assets_users data
        
        if($table_name =="asset_items"){ //asset_items data insert ##10
            foreach($excel_file_datas as $key=>$val){
                $name = $val->computer_name ?? '';
                $category = $val->category ?? '';
                $category_id = find_category_id($category);
                $brand_id = find_brand_id($val->supplier_vendor);
                $vendor_id = find_vendor_id($val->supplier_vendor);
                $asset_condition_id = find_asset_condition_id($val->condition);
                if($val->assigned_user ==""){
                    $assign_status_id =1 ;
                }else{
                     $assign_status_id =2 ;
                }
                $asset_code = get_asset_code();
                $model_no = $val->model_no ?? '';
                $serial_no = $val->serial_number ?? '';
                $group_serial_no = find_group_serial_no($category_id);
                $domain_intune = $val->domain_intune ?? '';
                if($val->warranty ==""){
                    $warranty_status =0;
                }else{
                    $warranty_status = 1;
                }
                $os_type = $val->os ?? '';
                $asset_tag = $val->asset_tag ?? '';
                $description = $val->description ?? '';
                $remarks = $val->remarks ?? '';
                $status = 1;
                $is_delete = 0;
                
                
                $data =new  AssetItem();
                $data->name = $name;
                $data->category_id = $category_id;
                $data->brand_id = $brand_id;
                $data->vendor_id = $vendor_id;
                $data->asset_condition_id = $asset_condition_id;
                $data->assign_status_id = $assign_status_id;
                $data->asset_code = $asset_code;
                $data->model_no = $model_no;
                $data->serial_no = $serial_no;
                $data->group_serial_no = $group_serial_no;
                $data->domain_intune = $domain_intune;
                $data->warranty_status = $warranty_status;
                $data->os_type = $os_type;
                $data->asset_tag = $asset_tag;
                $data->description = $description;
                $data->remarks = $remarks;
                $data->status = $status;
                $data->is_delete = $is_delete;
                $data->save();

                $asset_item_id = $data->id;

                //Asset Assign to user
                if($val->assigned_user !=""){
                $AssetAssign = new AssetAssign();
                $AssetAssign->asset_item_id = $asset_item_id;
                $AssetAssign->asset_category_id = $category_id;
                $AssetAssign->assign_unique_serial = '';
                $AssetAssign->organization_id = 1;
                $AssetAssign->branch_id = $brand_id;
                $AssetAssign->dept_id = 1;
                $AssetAssign->project_id = 1;
                $AssetAssign->asset_user_id =find_user_id($val->assigned_user);
                $AssetAssign->asset_location_id =find_asset_location_id($val->campus_location);
                $AssetAssign->asset_room_id =find_room_device_location($val->room_device_location);
                $AssetAssign->assign_date =$val->assigned_date ?? '';
                $AssetAssign->assign_status =1;
                $AssetAssign->save();
            }

            }
        } //End of assets_users data

        return redirect()->back();
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
        //
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
