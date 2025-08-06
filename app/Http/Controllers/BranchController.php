<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Auth;

class BranchController extends Controller
{
  
   
     function __construct()
    {
         $this->middleware('permission:branch-list|branch-create|branch-edit|branch-delete', ['only' => ['index','store']]);
         $this->middleware('permission:branch-create', ['only' => ['create','store']]);
         $this->middleware('permission:branch-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:branch-delete', ['only' => ['destroy']]);
         $this->page_name = "Branch";
    }
    
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $datas = Branch::where('_status','!=',"");
        if($request->has('_name') && $request->_name !=''){
            $datas = $datas->where('_name','like',"%$request->_name%");
        }
        if($request->has('_code') && $request->_code !=''){
            $datas = $datas->where('_code','like',"%$request->_code%");
        }
        if($request->has('_address') && $request->_address !=''){
            $datas = $datas->where('_address','like',"%$request->_address%");
        }
        if($request->has('_email') && $request->_email !=''){
            $datas = $datas->where('_email','like',"%$request->_email%");
        }
        if($request->has('_phone') && $request->_phone !=''){
            $datas = $datas->where('_phone','like',"%$request->_phone%");
        }

         $datas = $datas->orderBy('id','desc')->paginate($limit);
         $page_name = $this->page_name;
        return view('backend.branch.index',compact('datas','request','page_name'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $page_name = $this->page_name;
        return view('backend.branch.create',compact('request','page_name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
                '_name' => 'required|max:255|unique:branches,_name',
            ]);
        

        $data = new Branch();
        $data->_name       = $request->_name ?? '';
        $data->_code       = $request->_code ?? '';
        $data->_address = $request->_address ?? '';
        $data->_date       = $request->_date ?? '';
        $data->_email       = $request->_email ?? '';
        $data->_phone       = $request->_phone ?? '';
        $data->_status     = $request->_status ?? '';
        $data->_created_by     = Auth::user()->id."-".Auth::user()->name;
        $data->save();



        return redirect()->back()->with('success','Information Save successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        $page_name = $this->page_name;
        $data = $branch;
        return view('backend.branch.show',compact('page_name','data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
        $data = Branch::find($id);
        
        return view('backend.branch.edit',compact('page_name','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
                '_name' => 'required|max:255|unique:branches,_name,'.$request->id,
            ]);
        $data = Branch::find($request->id);
        $data->_name       = $request->_name ?? '';
        $data->_code       = $request->_code ?? '';
        $data->_address = $request->_address ?? '';
        $data->_date       = $request->_date ?? '';
        $data->_email       = $request->_email ?? '';
        $data->_phone       = $request->_phone ?? '';
        $data->_status     = $request->_status ?? '';
        $data->_updated_by     = Auth::user()->id."-".Auth::user()->name;
        $data->save();
         return redirect('branch')->with('success','Information Save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        return "You Can not delete this Information";
    }
}
