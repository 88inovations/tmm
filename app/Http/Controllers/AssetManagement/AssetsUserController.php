<?php

namespace App\Http\Controllers\AssetManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetManagement\AssetsUser;
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


class AssetsUserController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:asset-users-list|asset-users-create|asset-users-edit|asset-users-delete', ['only' => ['index','store']]);
         $this->middleware('permission:asset-users-create', ['only' => ['create','store']]);
         $this->middleware('permission:asset-users-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:asset-users-delete', ['only' => ['destroy']]);
        $this->page_name = __('label.asset-users');
        $this->new_page_name = __('label.new_asset-users');
        $this->edit_page_name = __('label.edit_asset-users');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AssetsUser::where('is_delete',0)->get();
        $page_name = $this->page_name;
        return view('apps.asset-management.asset-users.index',compact('data','page_name'));
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
         $organizations =Organization::with(['_org_branches','_org_cost_centers','_org_departments','_org_designations','_org_stores'])->where('is_delete',0)->orderBy('order','ASC')->get();

        return view('apps.asset-management.asset-users.create',compact('page_name','new_page_name','organizations'));
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

        // dump($request->all());
        // die();

        $request->validate([
            'name'=>'required',
            'organization_id'=>'required',
            'status' => 'required|max:20',
        ]);

        try {
            $logo ='';
            if($request->has('logo')){
               $logo= _imageUploader($request->logo); 
            }
            $org_id =  $request->organization_id ?? 0;

            $input=['name'=>$request->name,
                    'logo'=>$logo,
                    'phone'=>$request->phone,
                    'code'=>$request->code ?? assetUserCode($org_id),
                    'address'=>$request->address,
                    'description'=>$request->description,
                    'status'=>$request->status,
                    'organization_id'=>$request->organization_id ?? 0,
                    'branch_id'=>$request->branch_id ?? 0,
                    'department_id'=>$request->department_id ?? 0,
                    'designation_id'=>$request->designation_id ?? 0,
                    'is_delete'=>0,
                    'order'=>$request->order,
                    'created_at'=>date('Y-m-d H:i:s'),
                ];

        $id = AssetsUser::insertGetId($input);
            return redirect()->route('asset-users.index')
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
        try {
            $_lang_ref =  $request->_lang_ref ?? 'en_US';
            $data = AssetsUser::where('is_delete',0)->find($id);
            $page_name = $this->page_name;
            $edit_page_name = $this->edit_page_name;
            $organizations =Organization::with(['_org_branches','_org_cost_centers','_org_departments','_org_designations','_org_stores'])->where('is_delete',0)->orderBy('order','ASC')->get();
            return view('apps.asset-management.asset-users.edit',compact('page_name','edit_page_name','data','organizations'));
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
       $request->validate([
            'name'=>'required',
            'organization_id'=>'required',
            'status' => 'required|max:20',
        ]);

        try {
            $logo ='';
            if($request->has('logo')){
               $logo= _imageUploader($request->logo); 
            }
            $org_id =  $request->organization_id ?? 0;

            $input=['name'=>$request->name,
                    'logo'=>$logo,
                    'phone'=>$request->phone,
                    'code'=>$request->code,
                    'address'=>$request->address,
                    'description'=>$request->description,
                    'status'=>$request->status,
                    'organization_id'=>$request->organization_id ?? 0,
                    'branch_id'=>$request->branch_id ?? 0,
                    'department_id'=>$request->department_id ?? 0,
                    'designation_id'=>$request->designation_id ?? 0,
                    'is_delete'=>0,
                    'order'=>$request->order,
                    'created_at'=>date('Y-m-d H:i:s'),
                ];

            AssetsUser::where('id',$id)->update($input);
            return redirect()->route('asset-users.index')
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
            AssetsUser::where('id',$id)->update(['is_delete'=>1]);
            return redirect()->route('asset-users.index')
            ->with('success', __('label.info_deleted_successfully'));
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
