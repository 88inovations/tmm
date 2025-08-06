<?php

namespace App\Http\Controllers;

use App\Models\ItemBrand;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;

class ItemBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct()
    {
         $this->middleware('permission:item-brand-list|item-brand-create|item-brand-edit|item-brand-delete', ['only' => ['index','store']]);
         $this->middleware('permission:item-brand-create', ['only' => ['create','store']]);
         $this->middleware('permission:item-brand-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:item-brand-delete', ['only' => ['destroy']]);
         $this->page_name = "Item Brand";
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

        $datas = ItemBrand::where('_name','!=','');
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
                return view('backend.item-brand.master_print',compact('datas','page_name','request','limit'));
            }
         }

        
         

        return view('backend.item-brand.index',compact('datas','request','page_name','limit'));

    }



    public function reset(){
        Session::flash('_u_limit');
       return  \Redirect::to('item-brand?limit='.default_pagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
        return view('backend.item-brand.create',compact('page_name'));
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
            '_name' => 'required|unique:item_brands,_name',
        ]);

        $data = new ItemBrand();
        $data->_name       = $request->_name ?? '';
        $data->_code       = $request->_code ?? '';
        $data->_status     = $request->_status ?? '';
        $data->save();

        return redirect()->back()->with('success','Information Save successfully');



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemBrand  $ItemBrand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_name = $this->page_name;
         $data = ItemBrand::find($id);
        return view('backend.item-brand.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemBrand  $ItemBrand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
        $data = ItemBrand::find($id);
        return view('backend.item-brand.edit',compact('data','page_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemBrand  $ItemBrand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $this->validate($request, [
            '_name' => 'required|unique:item_brands,_name,'.$request->id,
        ]);
       
        $data = ItemBrand::find($request->id);
        $data->_name       = $request->_name ?? '';
        $data->_code       = $request->_code ?? '';
        $data->_status     = $request->_status ?? '';
        $data->save();

        return redirect('item-brand')->with('success','Information Save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemBrand  $ItemBrand
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemBrand $ItemBrand)
    {
        ItemBrand::find($id)->delete();
        return redirect()->route('item-brand.index')
                        ->with('danger','Information deleted successfully');
    }
}
