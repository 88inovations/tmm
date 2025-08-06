<?php

namespace App\Http\Controllers;

use App\Models\StoreHouse;
use App\Models\Branch;
use Illuminate\Http\Request;
use Auth;


class StoreHouseController extends Controller
{
     function __construct()
    {
         $this->middleware('permission:store-house-list|store-house-create|store-house-edit|store-house-delete', ['only' => ['index','store']]);
         $this->middleware('permission:store-house-create', ['only' => ['create','store']]);
         $this->middleware('permission:store-house-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:store-house-delete', ['only' => ['destroy']]);
         $this->page_name = "Store";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $datas = StoreHouse::with(['_branch']);
        if($request->has('_name') && $request->_name !=''){
            $datas = $datas->where('_name','like',"%$request->_name%");
        }
        if($request->has('_code') && $request->_code !=''){
            $datas = $datas->where('_code','like',"%$request->_code%");
        }
        if($request->has('_branch_id') && $request->_branch_id !=''){
            $datas = $datas->where('_branch_id','like',"%$request->_branch_id%");
        }

         $datas = $datas->orderBy('id','desc')->paginate($limit);
         $page_name = $this->page_name;
         $branchs = Branch::orderBy('_name','asc')->get();
        return view('backend.store-house.index',compact('datas','request','page_name','branchs'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $page_name = $this->page_name;
       $branchs = Branch::orderBy('_name','asc')->get();
        return view('backend.store-house.create',compact('page_name','branchs'));
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
               '_name' => 'required|max:255|unique:store_houses,_name',
               
        ]);

        

         $data = new StoreHouse();
        $data->_name       = $request->_name ?? '';
        $data->_code       = $request->_code ?? '';
        $data->_branch_id       = $request->_branch_id ?? 1;
        //$data->_created_by     = Auth::user()->id."-".Auth::user()->name;
        $data->save();

        return redirect()->back()->with('success','Information Save successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StoreHouse  $StoreHouse
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_name = $this->page_name;
        $data = StoreHouse::with(['_branch'])->find($id);
        return view('backend.store-house.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StoreHouse  $StoreHouse
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
        $data = StoreHouse::find($id);
         $branchs = Branch::orderBy('_name','asc')->get();
        return view('backend.store-house.edit',compact('data','page_name','branchs'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StoreHouse  $StoreHouse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
                '_name' => 'required|max:255|unique:store_houses,_name,'.$request->id,
                '_branch_id' => 'required',
            ]);

      
        $data = StoreHouse::find($request->id);
        $data->_name       = $request->_name ?? '';
        $data->_code       = $request->_code ?? '';
        $data->_branch_id       = $request->_branch_id ?? 1;
        //$data->_updated_by     = Auth::user()->id."-".Auth::user()->name;
        $data->save();

        return redirect('store-house')->with('success','Information Save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StoreHouse  $StoreHouse
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        StoreHouse::where('id',$id)->update(['_status'=>0]);
        return redirect('store-house')->with('success','Information Deleted successfully');
    }
}
