<?php

namespace App\Http\Controllers\Basic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
use App\Models\Basic\OrganizationBranchStore;
use App\Models\Basic\OrganizationDepartmentDesignation;

class OrganizationController extends Controller
{

   function __construct()
    {
         $this->middleware('permission:organizations-list|organizations-create|organizations-edit|organizations-delete', ['only' => ['index','store']]);
         $this->middleware('permission:organizations-create', ['only' => ['create','store']]);
         $this->middleware('permission:organizations-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:organizations-delete', ['only' => ['destroy']]);
        $this->page_name = __('label.organizations');
        $this->new_page_name = __('label.new_organizations');
        $this->edit_page_name = __('label.edit_organizations');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Organization::where('is_delete',0)->get();
        $page_name = $this->page_name;
        return view('master.organizations.index',compact('data','page_name'));
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
        return view('master.organizations.create',compact('page_name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //UserImageUpload


        $request->validate([
            '_name'=>'required|unique:companies,_name',
            'status' => 'required|max:20',
        ]);

        try {
            $logo ='';
            if($request->has('logo')){
               $logo= _imageUploader($request->logo); 
            }

            $input=['_name'=>$request->_name,
                    'logo'=>$logo,
                    'phone'=>$request->phone,
                    '_code'=>$request->_code ?? takeFirstLetter($request->name),
                    'address'=>$request->address,
                    'description'=>$request->description,
                    'status'=>$request->status,
                    'is_delete'=>0,
                    'order'=>$request->order,
                    'created_at'=>date('Y-m-d H:i:s'),
                ];

        $id = Organization::insertGetId($input);
            return redirect()->route('organizations.index')
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
         $data=Organization::with(['_org_branches','_org_cost_centers','_org_departments','_org_designations','_org_stores'])->find($id);
        $branchs = Branch::where('is_delete',0)
                    ->orderBy('order','ASC')
                    ->orderBy('_name','asc')->get();
        $costcenters = CostCenter::where('is_delete',0)
                    ->orderBy('order','ASC')
                    ->orderBy('_name','asc')->get();
        $storeHouses = Store::where('is_delete',0)
                    ->orderBy('order','ASC')
                    ->orderBy('_name','asc')->get();
        $departments = Department::where('is_delete',0)
                    ->orderBy('order','ASC')
                    ->orderBy('name','asc')->get();
        $designations = Designation::where('is_delete',0)
                    ->orderBy('order','ASC')
                    ->orderBy('_name','asc')->get();

        $page_name = $this->page_name;
    return view('master.organizations.show',compact('data','branchs','costcenters','storeHouses','departments','designations','page_name'));
    }
    /**
     * organization chain data show
     *
     * @param  int  $organization_id
     * @return \Illuminate\Http\Response
     */
    public function organizationWisechain(Request $request)
    {
        $id= $request->organization_id;
        $user_id = $request->user_id ?? 0;
        $userInfo= \DB::table('assets_users')->find($user_id);
        $data=Organization::with(['_org_branches','_org_cost_centers','_org_departments','_org_designations','_org_stores'])->find($id);

        return view('master.organizations.chain',compact('data','userInfo'));
    }
    /**
     * organization chain data show
     *
     * @param  int  $organization_id
     * @return \Illuminate\Http\Response
     */
    public function user_base_org_chain(Request $request)
    {
        
        $user_id = $request->user_id ?? 0;
        $userInfo= \DB::table('assets_users')->find($user_id);
        $id = $userInfo->organization_id ?? 0;
        $data=Organization::with(['_org_branches','_org_cost_centers','_org_departments','_org_designations','_org_stores'])->find($id);

        return view('master.organizations.user_chain',compact('data','userInfo'));
    }

    public function organizationRelation(Request $request){
        
        $request->validate([
            'id'=>'required',
        ]);

        try {
         $id = $request->id;
         OrganizationBranch::where('organization_id',$id)->delete();
         OrganizationStore::where('organization_id',$id)->delete();
         OrganizationCostCenter::where('organization_id',$id)->delete();
         OrganizationDepartment::where('organization_id',$id)->delete();
         OrganizationDesignation::where('organization_id',$id)->delete();
         $org_branches = $request->org_branches ?? [];
         foreach($org_branches as $key=>$val){
            $OrganizationBranch = new OrganizationBranch();
            $OrganizationBranch->organization_id=$id;
            $OrganizationBranch->branch_id = $val;
            $OrganizationBranch->save();

         }
         $org_cost_centers = $request->org_cost_centers ?? [];
         foreach($org_cost_centers as $key=>$val){
            $OrganizationCostCenter = new OrganizationCostCenter();
            $OrganizationCostCenter->organization_id=$id;
            $OrganizationCostCenter->cost_center_id = $val;
            $OrganizationCostCenter->save();

         }
         
         $org_store_houses = $request->org_store_houses ?? [];
           foreach($org_store_houses as $key=>$val){
            $OrganizationStore = new OrganizationStore();
            $OrganizationStore->organization_id=$id;
            $OrganizationStore->store_id = $val;
            $OrganizationStore->save();

         }
         $org_departments = $request->org_departments ?? [];
           foreach($org_departments as $key=>$val){
            $OrganizationDepartment = new OrganizationDepartment();
            $OrganizationDepartment->organization_id=$id;
            $OrganizationDepartment->department_id = $val;
            $OrganizationDepartment->save();

         }
         $org_designations = $request->org_designations ?? [];
          foreach($org_designations as $key=>$val){
            $OrganizationDesignation = new OrganizationDesignation();
            $OrganizationDesignation->organization_id=$id;
            $OrganizationDesignation->designation_id = $val;
            $OrganizationDesignation->save();

         }

        return redirect()->back()
            ->with('success', __('label.info_updated'));
        } catch (Throwable $e) {
            report($e);
     
            return false;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $_lang_ref =  $request->_lang_ref ?? 'en_US';
            $data = Organization::where('is_delete',0)->find($id);
            $page_name = $this->page_name;
            $edit_page_name = $this->edit_page_name;
            return view('master.organizations.edit',compact('page_name','edit_page_name','data'));
        } catch (Throwable $e) {
            report($e);
     
            return false;
        }

        
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

       // return $request->all();

        $request->validate([
            '_name'=>'required|unique:companies,_name,'.$id,
            'status' => 'required|max:20',
        ]);

        try {
            $input1 =[];
            if($request->has('logo')){
               $logo= _imageUploader($request->logo); 
               $input1=['logo'=>$logo];
            }

            $input2=['_name'=>$request->_name,
                    'phone'=>$request->phone,
                    '_code'=>$request->_code ?? takeFirstLetter($request->_name),
                    'address'=>$request->address,
                    'description'=>$request->description,
                    'status'=>$request->status,
                    'is_delete'=>0,
                    'order'=>$request->order,
                    'created_at'=>date('Y-m-d H:i:s'),
                ];
        $input = array_merge($input2,$input1);
                

            Organization::where('id',$id)->update($input);
            return redirect()->route('organizations.index')
            ->with('success', __('label.info_created'));
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
        try {
            Organization::where('id',$id)->update(['is_delete'=>1]);
            return redirect()->route('organizations.index')
            ->with('success', __('label.info_deleted_successfully'));
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
