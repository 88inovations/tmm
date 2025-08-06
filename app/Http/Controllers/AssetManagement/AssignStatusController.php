<?php

namespace App\Http\Controllers\AssetManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetManagement\AssignStatus;

class AssignStatusController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:assign-status-list|assign-status-create|assign-status-edit|assign-status-delete', ['only' => ['index','store']]);
         $this->middleware('permission:assign-status-create', ['only' => ['create','store']]);
         $this->middleware('permission:assign-status-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:assign-status-delete', ['only' => ['destroy']]);
        $this->page_name = __('label.assign-status');
        $this->new_page_name = __('label.new_assign-status');
        $this->edit_page_name = __('label.edit_assign-status');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AssignStatus::where('is_delete',0)->get();
        $page_name = $this->page_name;
        return view('apps.asset-management.assign-status.index',compact('data','page_name'));
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
        return view('apps.asset-management.assign-status.create',compact('page_name','new_page_name'));
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
            'name'=>'required|unique:assign_statuses,name',
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

                $id = AssignStatus::insertGetId($input);
            return redirect()->route('assign-status.index')
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
            $data = AssignStatus::where('is_delete',0)->find($id);
            $page_name = $this->page_name;
            $edit_page_name = $this->edit_page_name;
            return view('apps.asset-management.assign-status.edit',compact('page_name','edit_page_name','data'));
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
            'name'=>'required|unique:assign_statuses,name,'.$id,
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

            AssignStatus::where('id',$id)->update($input);
            return redirect()->route('assign-status.index')
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
            AssignStatus::where('id',$id)->update(['is_delete'=>1]);
            return redirect()->route('assign-status.index')
            ->with('success', __('label.info_deleted_successfully'));
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
