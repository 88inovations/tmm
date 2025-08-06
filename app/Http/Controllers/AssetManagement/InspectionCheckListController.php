<?php

namespace App\Http\Controllers\AssetManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetManagement\InspectionCheckList;
use App\Models\AssetManagement\InspectionCheckCategory;

class InspectionCheckListController extends Controller
{
    
function __construct()
    {
         $this->middleware('permission:inspection-check-list|inspection-check-create|inspection-check-edit|inspection-check-delete', ['only' => ['index','store']]);
         $this->middleware('permission:inspection-check-create', ['only' => ['create','store']]);
         $this->middleware('permission:inspection-check-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:inspection-check-delete', ['only' => ['destroy']]);
        $this->page_name = __('label.inspection-check');
        $this->new_page_name = __('label.new_inspection-check');
        $this->edit_page_name = __('label.edit_inspection-check');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = InspectionCheckList::with(['ins_category'])->where('is_delete',0)->get();
        $page_name = $this->page_name;
        return view('apps.asset-management.inspection-check.index',compact('data','page_name'));
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
        $categories = InspectionCheckCategory::where('is_delete',0)->get();
        return view('apps.asset-management.inspection-check.create',compact('page_name','new_page_name','categories'));
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
            'ins_category_id' => 'required',
        ]);

        try {
           

            $input=['name'=>$request->name,
                    'code'=>$request->code ??  takeFirstLetter($request->name),
                    'description'=>$request->description,
                    'ins_category_id'=>$request->ins_category_id,
                    'status'=>$request->status,
                    'is_delete'=>0,
                    'order'=>$request->order ?? 0,
                    'created_at'=>date('Y-m-d H:i:s'),
                ];

        $id = InspectionCheckList::insertGetId($input);
            return redirect()->route('inspection-check.index')
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
            $data = InspectionCheckList::where('is_delete',0)->find($id);
            $page_name = $this->page_name;
            $edit_page_name = $this->edit_page_name;
            $categories = InspectionCheckCategory::where('is_delete',0)->get();
            return view('apps.asset-management.inspection-check.edit',compact('page_name','edit_page_name','data','categories'));
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
            'ins_category_id' => 'required',
        ]);

        try {
           

            $input=['name'=>$request->name,
                    'code'=>$request->code ??  takeFirstLetter($request->name),
                    'description'=>$request->description,
                    'ins_category_id'=>$request->ins_category_id,
                    'status'=>$request->status,
                    'is_delete'=>0,
                    'order'=>$request->order ?? 0,
                    'created_at'=>date('Y-m-d H:i:s'),
                ];

            InspectionCheckList::where('id',$id)->update($input);
            return redirect()->route('inspection-check.index')
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
            InspectionCheckList::where('id',$id)->update(['is_delete'=>1]);
            return redirect()->route('inspection-check.index')
            ->with('success', __('label.info_deleted_successfully'));
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
