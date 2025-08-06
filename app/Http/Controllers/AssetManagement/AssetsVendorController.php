<?php

namespace App\Http\Controllers\AssetManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetManagement\AssetsVendor;

class AssetsVendorController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:asset-vendor-list|asset-vendor-create|asset-vendor-edit|asset-vendor-delete', ['only' => ['index','store']]);
         $this->middleware('permission:asset-vendor-create', ['only' => ['create','store']]);
         $this->middleware('permission:asset-vendor-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:asset-vendor-delete', ['only' => ['destroy']]);
        $this->page_name = __('label.asset-vendor');
        $this->new_page_name = __('label.new_asset-vendor');
        $this->edit_page_name = __('label.edit_asset-vendor');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $data = AssetsVendor::where('is_delete',0)->get();
        $account_group_configs = \DB::table("account_group_configs")->select('_supplier_group')->first();

        $supplier_groups_string = $account_group_configs->_supplier_group ?? 0;
        $supplier_groups_array = explode(",", $supplier_groups_string);

        $data = \App\Models\AccountLedger::with(['account_type','account_group'])->whereIn('_account_group_id',$supplier_groups_array)->get();


        $page_name = $this->page_name;
        return view('apps.asset-management.asset-vendor.index',compact('data','page_name'));
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
        return view('apps.asset-management.asset-vendor.create',compact('page_name','new_page_name'));
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
            'name'=>'required',
            'status' => 'required|max:20',
        ]);

        try {
            $logo ='';
            if($request->has('logo')){
               $logo= _imageUploader($request->logo); 
            }

            $input=['name'=>$request->name,
                    'logo'=>$logo,
                    'phone'=>$request->phone,
                    'code'=>$request->code ?? takeFirstLetter($request->name),
                    'address'=>$request->address,
                    'description'=>$request->description,
                    'status'=>$request->status,
                    'is_delete'=>0,
                    'order'=>$request->order,
                    'created_at'=>date('Y-m-d H:i:s'),
                ];

        $id = AssetsVendor::insertGetId($input);
            return redirect()->route('asset-vendor.index')
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
            $data = AssetsVendor::where('is_delete',0)->find($id);
            $page_name = $this->page_name;
            $edit_page_name = $this->edit_page_name;
            return view('apps.asset-management.asset-vendor.edit',compact('page_name','edit_page_name','data'));
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
            'status' => 'required|max:20',
        ]);

        try {
            $input =[];
            if($request->has('logo')){
               $logo= _imageUploader($request->logo); 
               $input=['logo'=>$logo];
            }

            $input=['name'=>$request->name,
                    'phone'=>$request->phone,
                    'code'=>$request->code ?? takeFirstLetter($request->name),
                    'address'=>$request->address,
                    'description'=>$request->description,
                    'status'=>$request->status,
                    'is_delete'=>0,
                    'order'=>$request->order,
                    'created_at'=>date('Y-m-d H:i:s'),
                ];

            AssetsVendor::where('id',$id)->update($input);
            return redirect()->route('asset-vendor.index')
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
            AssetsVendor::where('id',$id)->update(['is_delete'=>1]);
            return redirect()->route('asset-vendor.index')
            ->with('success', __('label.info_deleted_successfully'));
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
