<?php

namespace App\Http\Controllers;

use App\Models\Cylindar;
use App\Models\CylindarLocationHistory;
use Illuminate\Http\Request;
use Auth;
use Session;
use DB;
use App\Models\ProductPriceList;



class CylindarController extends Controller
{

     function __construct()
    {
         $this->middleware('permission:cylindar_location-list|cylindar_location-create|cylindar_location-edit|cylindar_location-delete', ['only' => ['index','store']]);
         $this->middleware('permission:cylindar_location-create', ['only' => ['create','store']]);
         $this->middleware('permission:cylindar_location-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:cylindar_location-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.cylindar_location');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_i_limit', $request->limit);
        }else{
             $limit= \Session::get('_i_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';
        $datas = Cylindar::with(['_items']);
        if($request->has('_item') && $request->_item !=''){
            $datas = $datas->where('_item','like',"%$request->_item%");
        }
        if($request->has('_code') && $request->_code !=''){
            $datas = $datas->where('_code','like',"%$request->_code%");
        }
        if($request->has('id') && $request->id !=''){
            $datas = $datas->where('id','=',$request->id);
        }
        if($request->has('_barcode') && $request->_barcode !=''){
            $datas = $datas->where('_barcode','like',"%$request->_barcode%");
        }
        


        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);
        $page_name = $this->page_name;

       
        
        return view('backend.cylindar_location.index',compact('datas','request','page_name','limit'));


        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function cylindar_location_transfer(Request $request){

        $item_info  = ProductPriceList::with(['_items'])->find($request->id);


        return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cylindar  $cylindar
     * @return \Illuminate\Http\Response
     */
    public function show(Cylindar $cylindar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cylindar  $cylindar
     * @return \Illuminate\Http\Response
     */
    public function edit(Cylindar $cylindar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cylindar  $cylindar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cylindar $cylindar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cylindar  $cylindar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cylindar $cylindar)
    {
        //
    }
}
