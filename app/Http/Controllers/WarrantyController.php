<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warranty;
use App\Models\Branch;

class WarrantyController extends Controller
{

       function __construct()
    {
         $this->middleware('permission:warranty-list|warranty-create|warranty-edit|warranty-delete', ['only' => ['index','store']]);
         $this->middleware('permission:warranty-create', ['only' => ['create','store']]);
         $this->middleware('permission:warranty-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:warranty-delete', ['only' => ['destroy']]);
         $this->page_name = "Warranty";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $datas = Warranty::where('_name','!=','');
        if($request->has('_name') && $request->_name !=''){
            $datas = $datas->where('_name','like',"%$request->_name%");
        }
        if($request->has('_description') && $request->_description !=''){
            $datas = $datas->where('_description','like',"%$request->_description%");
        }
        if($request->has('_duration') && $request->_duration !=''){
            $datas = $datas->where('_duration','like',"%$request->_duration%");
        }
        if($request->has('_period') && $request->_period !=''){
            $datas = $datas->where('_period','like',"%$request->_period%");
        }

         $datas = $datas->orderBy('id','desc')->paginate($limit);
         $page_name = $this->page_name;
         $branchs = Branch::orderBy('_name','asc')->get();
        return view('backend.warranty.index',compact('datas','request','page_name','branchs'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $page_name = $this->page_name;
       
        return view('backend.warranty.create',compact('page_name'));
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
                '_name' => 'required|max:255|unique:warranties,_name',
                '_duration' => 'required',
                '_period' => 'required',
        ]);

        $data = new Warranty();
        $data->_name       = $request->_name ?? '';
        $data->_duration = $request->_duration ?? 1;
        $data->_period       = $request->_period ?? '';
        $data->_description       = $request->_description ?? '';
        $data->save();

        return redirect()->back()->with('success','Information Save successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_name = $this->page_name;
        $data = Warranty::find($id);
        return view('backend.warranty.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
        $data = Warranty::find($id);
        return view('backend.warranty.edit',compact('data','page_name')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
          $request->validate([
                '_name' => 'required|max:255|unique:warranties,_name,'.$request->id,
                '_duration' => 'required',
                '_period' => 'required',
        ]);
        $data = Warranty::find($request->id);
        $data->_name       = $request->_name ?? '';
        $data->_duration = $request->_duration ?? 1;
        $data->_period       = $request->_period ?? '';
        $data->_description       = $request->_description ?? '';
        $data->save();

        return redirect('warranty')->with('success','Information Save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $check_data =  \DB::table('sales_details')->where('_warranty',$id)->first();
       
       if($check_data ==0){
            Warranty::find($id)->delete();
            return redirect('warranty')->with('success','Information deleted successfully');
        }else{
            $__message ="You Can not delete this Information";
            
             return redirect('warranty')->with('danger','You Can not delete this Information for Reference data');
        }
    }
}
