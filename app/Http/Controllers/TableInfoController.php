<?php

namespace App\Http\Controllers;

use App\Models\TableInfo;
use App\Models\Branch;
use Illuminate\Http\Request;
use Auth;

class TableInfoController extends Controller
{
     function __construct()
    {
         $this->middleware('permission:table-info-list|table-info-create|table-info-edit|table-info-delete', ['only' => ['index','store']]);
         $this->middleware('permission:table-info-create', ['only' => ['create','store']]);
         $this->middleware('permission:table-info-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:table-info-delete', ['only' => ['destroy']]);
         $this->page_name = "Table Information";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $datas = TableInfo::with(['_branch']);
        if($request->has('_name') && $request->_name !=''){
            $datas = $datas->where('_name','like',"%$request->_name%");
        }
        if($request->has('_number_of_chair') && $request->_number_of_chair !=''){
            $datas = $datas->where('_number_of_chair','like',"%$request->_number_of_chair%");
        }
        if($request->has('_branch_id') && $request->_branch_id !=''){
            $datas = $datas->where('_branch_id','like',"%$request->_branch_id%");
        }

         $datas = $datas->orderBy('id','desc')->paginate($limit);
         $page_name = $this->page_name;
         $branchs = Branch::orderBy('_name','asc')->get();
        return view('backend.table-info.index',compact('datas','request','page_name','branchs'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $page_name = $this->page_name;
      // $branchs = Branch::orderBy('_name','asc')->get();
       $users = Auth::user();
      $branchs = permited_branch(explode(',',$users->branch_ids));
        return view('backend.table-info.create',compact('page_name','branchs'));
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
                '_name' => 'required|max:255',
                '_branch_id' => 'required',
        ]);

         $data = new TableInfo();
        $data->_name       = $request->_name ?? '';
        $data->_branch_id = $request->_branch_id ?? '';
        $data->_number_of_chair       = $request->_number_of_chair ?? '';
        $data->_status = $request->_status ?? 0;
        $data->_created_by     = Auth::user()->id."-".Auth::user()->name;
        $data->save();

        return redirect()->back()->with('success','Information Save successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TableInfo  $TableInfo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_name = $this->page_name;
        $data = TableInfo::with(['_branch'])->find($id);
        return view('backend.table-info.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TableInfo  $TableInfo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
        $data = TableInfo::find($id);
         $users = Auth::user();
      $branchs = permited_branch(explode(',',$users->branch_ids));
        return view('backend.table-info.edit',compact('data','page_name','branchs'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TableInfo  $TableInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
                '_name' => 'required|max:255',
                '_branch_id' => 'required',
            ]);
        $data = TableInfo::find($request->id);
        $data->_name       = $request->_name ?? '';
        $data->_branch_id = $request->_branch_id ?? '';
        $data->_number_of_chair       = $request->_number_of_chair ?? '';
        $data->_status = $request->_status ?? 0;
        $data->_updated_by     = Auth::user()->id."-".Auth::user()->name;
        $data->save();

        return redirect('table-info')->with('success','Information Save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TableInfo  $TableInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       TableInfo::find($id)->delete();
        return redirect()->route('table-info.index')
                        ->with('success','Information deleted successfully');
    }
}
