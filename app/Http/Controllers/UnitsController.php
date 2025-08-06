<?php

namespace App\Http\Controllers;

use App\Models\Units;
use Illuminate\Http\Request;
use Session;

class UnitsController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct()
    {
         $this->middleware('permission:unit-list|unit-create|unit-edit|unit-delete', ['only' => ['index','store']]);
         $this->middleware('permission:unit-create', ['only' => ['create','store']]);
         $this->middleware('permission:unit-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:unit-delete', ['only' => ['destroy']]);
         $this->page_name = "Unit";
    }
    

    public function index(Request $request)
    {
       if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_u_limit', $request->limit);
        }else{
             $limit= Session::get('_u_limit') ??  default_pagination();
            
        }
       
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $datas = Units::where('_name','!=','');
        if($request->has('_code') && $request->_code !=''){
            $datas = $datas->where('_code','like',"%$request->_code%");
        }
        if($request->has('id') && $request->id !=""){
            $ids =  array_map('intval', explode(',', $request->id ));
            $datas = $datas->whereIn('id', $ids); 
        }
        if($request->has('_name') && $request->_name !=''){
            $datas = $datas->where('_name','like',"%$request->_name%");
        }
       

         $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);
         $page_name = $this->page_name;
        if($request->has('print')){
            if($request->print =="single"){
                return view('backend.unit.master_print',compact('datas','page_name','request','limit'));
            }
         }

        
         

        return view('backend.unit.index',compact('datas','request','page_name','limit'));

    }



    public function reset(){
        Session::flash('_u_limit');
       return  \Redirect::to('unit?limit='.default_pagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
        return view('backend.unit.create',compact('page_name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            '_name' => 'required|unique:units,_name',
        ]);

        $data = new Units();
        $data->_name       = $request->_name ?? '';
        $data->_code       = $request->_code ?? '';
        $data->_status     = $request->_status ?? '';
        $data->save();

        return redirect()->back()->with('success','Information Save successfully');



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Units  $Units
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_name = $this->page_name;
         $data = Units::find($id);
        return view('backend.unit.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Units  $Units
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
        $data = Units::find($id);
        return view('backend.unit.edit',compact('data','page_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Units  $Units
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $this->validate($request, [
            '_name' => 'required|unique:units,_name,'.$request->id,
        ]);
       
        $data = Units::find($request->id);
        $data->_name       = $request->_name ?? '';
        $data->_code       = $request->_code ?? '';
        $data->_status     = $request->_status ?? '';
        $data->save();

        return redirect('unit')->with('success','Information Save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Units  $Units
     * @return \Illuminate\Http\Response
     */
    public function destroy(Units $Units)
    {
        Units::find($id)->delete();
        return redirect()->route('unit.index')
                        ->with('danger','Information deleted successfully');
    }
}
