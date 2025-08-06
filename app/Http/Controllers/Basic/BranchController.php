<?php

namespace App\Http\Controllers\Basic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Basic\Branch;
use App\Models\Basic\Organization;

class BranchController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:branches-list|branches-create|branches-edit|branches-delete', ['only' => ['index','store']]);
         $this->middleware('permission:branches-create', ['only' => ['create','store']]);
         $this->middleware('permission:branches-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:branches-delete', ['only' => ['destroy']]);
        $this->page_name = __('label.branches');
        $this->new_page_name = __('label.new_branches');
        $this->edit_page_name = __('label.edit_branches');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Branch::where('is_delete',0)->get();
        $page_name = $this->page_name;
        return view('master.branches.index',compact('data','page_name'));
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
        $organizations = Organization::where('is_delete',0)->orderBy('order','ASC')->get();
        return view('master.branches.create',compact('page_name','organizations'));
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
            '_name'=>'required|unique:branches,_name',
            'status' => 'required|max:20',
        ]);

        try {
           

            $input=['_name'=>$request->_name,
                    '_phone'=>$request->_phone,
                    '_code'=>$request->_code ??  takeFirstLetter($request->_name),
                    '_address'=>$request->_address,
                    '_email'=>$request->_email,
                    'status'=>$request->status,
                    'is_delete'=>0,
                    'order'=>$request->order,
                    'created_at'=>date('Y-m-d H:i:s'),
                ];

        $id = Branch::insertGetId($input);
            return redirect()->route('branches.index')
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
            $data = Branch::where('is_delete',0)->find($id);
            $page_name = $this->page_name;
            $edit_page_name = $this->edit_page_name;
            $organizations = Organization::where('is_delete',0)->orderBy('order','ASC')->get();
            return view('master.branches.edit',compact('page_name','edit_page_name','data','organizations'));
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
      //  return $request->all();
        $request->validate([
            '_name'=>'required|unique:branches,_name,'.$id,
            'status' => 'required|max:20',
        ]);

        try {
           

            $input=['_name'=>$request->_name,
                    '_phone'=>$request->_phone,
                    '_code'=>$request->_code ??  takeFirstLetter($request->_name),
                    '_address'=>$request->_address,
                    '_email'=>$request->_email,
                    'status'=>$request->status,
                    'is_delete'=>0,
                    'order'=>$request->order,
                    'created_at'=>date('Y-m-d H:i:s'),
                ];

            Branch::where('id',$id)->update($input);
            return redirect()->route('branches.index')
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
            Branch::where('id',$id)->update(['is_delete'=>1]);
            return redirect()->route('branches.index')
            ->with('success', __('label.info_deleted_successfully'));
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
