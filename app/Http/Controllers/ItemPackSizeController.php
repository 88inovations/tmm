<?php

namespace App\Http\Controllers;

use App\Models\ItemPackSize;
use Illuminate\Http\Request;
use Session;
use Auth;
use DB;

class ItemPackSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct()
    {
         $this->middleware('permission:pack-size-list|pack-size-create|pack-size-edit|pack-size-delete', ['only' => ['index','store']]);
         $this->middleware('permission:pack-size-create', ['only' => ['create','store']]);
         $this->middleware('permission:pack-size-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:pack-size-delete', ['only' => ['destroy']]);
         $this->page_name = "Item Pack Size";
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

        $datas = ItemPackSize::where('_name','!=','');
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
                return view('backend.pack-size.master_print',compact('datas','page_name','request','limit'));
            }
         }

        
         

        return view('backend.pack-size.index',compact('datas','request','page_name','limit'));

    }



    public function reset(){
        Session::flash('_u_limit');
       return  \Redirect::to('pack-size?limit='.default_pagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
        return view('backend.pack-size.create',compact('page_name'));
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
            '_name' => 'required|unique:item_pack_sizes,_name',
        ]);

        $data = new ItemPackSize();
        $data->_name       = $request->_name ?? '';
        $data->_code       = $request->_code ?? '';
        $data->_status     = $request->_status ?? '';
        $data->save();

        return redirect()->back()->with('success','Information Save successfully');



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemPackSize  $ItemPackSize
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_name = $this->page_name;
         $data = ItemPackSize::find($id);
        return view('backend.pack-size.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemPackSize  $ItemPackSize
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
        $data = ItemPackSize::find($id);
        return view('backend.pack-size.edit',compact('data','page_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemPackSize  $ItemPackSize
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $this->validate($request, [
            '_name' => 'required|unique:item_pack_sizes,_name,'.$request->id,
        ]);
       
        $data = ItemPackSize::find($request->id);
        $data->_name       = $request->_name ?? '';
        $data->_code       = $request->_code ?? '';
        $data->_status     = $request->_status ?? '';
        $data->save();

        return redirect('pack-size')->with('success','Information Save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemPackSize  $ItemPackSize
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemPackSize $ItemPackSize)
    {
        ItemPackSize::find($id)->delete();
        return redirect()->route('pack-size.index')
                        ->with('danger','Information deleted successfully');
    }
}
