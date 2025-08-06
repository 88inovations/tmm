<?php

namespace App\Http\Controllers\AssetManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetManagement\AssetsDeviceLocation;

class AssetsDeviceLocationController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:asset-actual-location-list|asset-actual-location-create|asset-actual-location-edit|asset-actual-location-delete', ['only' => ['index','store']]);
         $this->middleware('permission:asset-actual-location-create', ['only' => ['create','store']]);
         $this->middleware('permission:asset-actual-location-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:asset-actual-location-delete', ['only' => ['destroy']]);
        $this->page_name = __('label.asset-actual-location');
        $this->new_page_name = __('label.new_asset-actual-location');
        $this->edit_page_name = __('label.edit_asset-actual-location');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AssetsDeviceLocation::where('is_delete',0)->get();
        $page_name = $this->page_name;
        return view('apps.asset-management.asset-actual-location.index',compact('data','page_name'));
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
        return view('apps.asset-management.asset-actual-location.create',compact('page_name','new_page_name'));
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
            'name'=>'required|unique:assets_device_locations,name',
            'status' => 'required|max:20',
        ]);

        try {
           

            $input=['name'=>$request->name,
                    'code'=>$request->code ??  takeFirstLetter($request->name),
                    'description'=>$request->description,
                    'status'=>$request->status,
                    'is_delete'=>0,
                    'order'=>$request->order,
                    'created_at'=>date('Y-m-d H:i:s'),
                ];

        $id = AssetsDeviceLocation::insertGetId($input);
            return redirect()->route('asset-actual-location.index')
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
            $data = AssetsDeviceLocation::where('is_delete',0)->find($id);
            $page_name = $this->page_name;
            $edit_page_name = $this->edit_page_name;
            return view('apps.asset-management.asset-actual-location.edit',compact('page_name','edit_page_name','data'));
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
            'name'=>'required|unique:assets_device_locations,name,'.$id,
            'status' => 'required|max:20',
        ]);

        try {
           

            $input=['name'=>$request->name,
                    'code'=>$request->code ??  takeFirstLetter($request->name),
                    'description'=>$request->description,
                    'status'=>$request->status,
                    'is_delete'=>0,
                    'order'=>$request->order,
                    'created_at'=>date('Y-m-d H:i:s'),
                ];

            AssetsDeviceLocation::where('id',$id)->update($input);
            return redirect()->route('asset-actual-location.index')
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
            AssetsDeviceLocation::where('id',$id)->update(['is_delete'=>1]);
            return redirect()->route('asset-actual-location.index')
            ->with('success', __('label.info_deleted_successfully'));
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
