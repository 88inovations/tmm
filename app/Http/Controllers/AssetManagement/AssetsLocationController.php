<?php

namespace App\Http\Controllers\AssetManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetManagement\AssetsLocation;

class AssetsLocationController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:asset-location-list|asset-location-create|asset-location-edit|asset-location-delete', ['only' => ['index','store']]);
         $this->middleware('permission:asset-location-create', ['only' => ['create','store']]);
         $this->middleware('permission:asset-location-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:asset-location-delete', ['only' => ['destroy']]);
        $this->page_name = __('label.asset-location');
        $this->new_page_name = __('label.new_asset-location');
        $this->edit_page_name = __('label.edit_asset-location');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AssetsLocation::where('is_delete',0)->get();
        $page_name = $this->page_name;
        return view('apps.asset-management.asset-location.index',compact('data','page_name'));
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
        return view('apps.asset-management.asset-location.create',compact('page_name','new_page_name'));
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
            'name'=>'required|unique:assets_locations,name',
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

        $id = AssetsLocation::insertGetId($input);
            return redirect()->route('asset-location.index')
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
            $data = AssetsLocation::where('is_delete',0)->find($id);
            $page_name = $this->page_name;
            $edit_page_name = $this->edit_page_name;
            return view('apps.asset-management.asset-location.edit',compact('page_name','edit_page_name','data'));
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
            'name'=>'required|unique:assets_locations,name,'.$id,
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

            AssetsLocation::where('id',$id)->update($input);
            return redirect()->route('asset-location.index')
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
            AssetsLocation::where('id',$id)->update(['is_delete'=>1]);
            return redirect()->route('asset-location.index')
            ->with('success', __('label.info_deleted_successfully'));
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
