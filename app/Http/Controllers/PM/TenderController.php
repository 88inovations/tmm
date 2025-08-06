<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use App\Models\PM\Tender;
use Illuminate\Http\Request;
use Session;
use DB;

class TenderController extends Controller
{
    
    function __construct()
    {
         
        $this->middleware('permission:tender-create', ['only' => ['create','store']]);
        $this->middleware('permission:tender-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:tender-delete', ['only' => ['destroy']]);
        $this->page_name = __('label.tender-info');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $page_name="Tender Information";
        // $data =Tender::orderBy('id','desc')->paginate(10);
        // return view('pm.tender.index',compact('data','page_name'));
        
        if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_i_limit', $request->limit);
        }else{
            $limit= \Session::get('_i_limit') ??  default_pagination();
        }

        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';
        
        $data = Tender::with(['tender_owner','tender_address','publish_date']);
        
        if($request->has('tender_owner') && $request->tender_owner !=''){
            $datas = $datas->where('tender_owner','like',"%$request->tender_owner%");
        }
        if($request->has('tender_address') && $request->tender_address !=''){
            $datas = $datas->where('tender_address','like',"%$request->tender_address%");
        }
        

        $page_name="Tender Information";
        $data = Tender::latest()->paginate(10);
        return view('pm.tender.index',compact('data','page_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('tenders.create');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
