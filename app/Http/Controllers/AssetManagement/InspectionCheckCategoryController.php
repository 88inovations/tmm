<?php

namespace App\Http\Controllers\AssetManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetManagement\InspectionCheckCategory;

class InspectionCheckCategoryController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:inspection-check-category-list|inspection-check-category-create|inspection-check-category-edit|inspection-check-category-delete', ['only' => ['index','store']]);
         $this->middleware('permission:inspection-check-category-create', ['only' => ['create','store']]);
         $this->middleware('permission:inspection-check-category-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:inspection-check-category-delete', ['only' => ['destroy']]);
        $this->page_name = __('label.inspection-check-category');
        $this->new_page_name = __('label.new_inspection-check-category');
        $this->edit_page_name = __('label.edit_inspection-check-category');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = InspectionCheckCategory::where('is_delete',0)->get();
        $page_name = $this->page_name;
        return view('apps.asset-management.inspection-check-category.index',compact('data','page_name'));
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
        return view('apps.asset-management.inspection-check-category.create',compact('page_name','new_page_name'));
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
            'name'=>'required|unique:inspection_check_categories,name',
            'status' => 'required|max:20',
        ]);

        try {
           

            $input=['name'=>$request->name,
                    'code'=>$request->code ??  takeFirstLetter($request->name),
                    'description'=>$request->description,
                    'status'=>$request->status,
                    'is_delete'=>0,
                    'order'=>$request->order ?? 0,
                    'created_at'=>date('Y-m-d H:i:s'),
                ];

        $id = InspectionCheckCategory::insertGetId($input);
            return redirect()->route('inspection-check-category.index')
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
            $data = InspectionCheckCategory::where('is_delete',0)->find($id);
            $page_name = $this->page_name;
            $edit_page_name = $this->edit_page_name;
            return view('apps.asset-management.inspection-check-category.edit',compact('page_name','edit_page_name','data'));
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
            'name'=>'required|unique:inspection_check_categories,name,'.$id,
            'status' => 'required|max:20',
        ]);

        try {
           

            $input=['name'=>$request->name,
                    'code'=>$request->code ??  takeFirstLetter($request->name),
                    'description'=>$request->description,
                    'status'=>$request->status,
                    'is_delete'=>0,
                    'order'=>$request->order ?? 0,
                    'created_at'=>date('Y-m-d H:i:s'),
                ];

            InspectionCheckCategory::where('id',$id)->update($input);
            return redirect()->route('inspection-check-category.index')
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
            InspectionCheckCategory::where('id',$id)->update(['is_delete'=>1]);
            return redirect()->route('inspection-check-category.index')
            ->with('success', __('label.info_deleted_successfully'));
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
