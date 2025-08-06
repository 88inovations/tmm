<?php

namespace App\Http\Controllers;

use App\Models\TransectionTerms;
use Session;
use Illuminate\Http\Request;

class TransectionTermsController extends Controller
{
        function __construct()
    {
         $this->middleware('permission:transection_terms-list|transection_terms-create|transection_terms-edit|transection_terms-delete|transection_terms-print', ['only' => ['index','store']]);
         $this->middleware('permission:transection_terms-print', ['only' => ['transection_termsPrint']]);
         $this->middleware('permission:transection_terms-create', ['only' => ['create','store']]);
         $this->middleware('permission:transection_terms-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:transection_terms-delete', ['only' => ['destroy']]);
         $this->page_name = "Transection Terms";
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

        $datas = TransectionTerms::where('id','!=','');
        if($request->has('_detail') && $request->_detail !=''){
            $datas = $datas->where('_detail','=',trim($request->_detail));
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
                return view('backend.transection_terms.master_print',compact('datas','page_name','request','limit'));
            }
         }

        
         

        return view('backend.transection_terms.index',compact('datas','request','page_name','limit'));

    }



    public function reset(){
        Session::flash('_u_limit');
       return  \Redirect::to('transection_terms?limit='.default_pagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
        return view('backend.transection_terms.create',compact('page_name'));
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
                '_name' => 'required|max:255|unique:transection_terms,_name',
               
        ]);
       
        $data = new TransectionTerms();
        $data->_name       = $request->_name ?? '';
        $data->_font_color  = $request->_font_color ?? '';
        $data->_detail       = $request->_detail ?? '';
        $data->_days       = $request->_days ?? 0;
        $data->_status     = $request->_status ?? 1;
        $data->save();

        return redirect()->back()->with('success','Information Save successfully');



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransectionTerms  $TransectionTerms
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_name = $this->page_name;
         $data = TransectionTerms::find($id);
        return view('backend.transection_terms.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransectionTerms  $TransectionTerms
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
        $data = TransectionTerms::find($id);
        return view('backend.transection_terms.edit',compact('data','page_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransectionTerms  $TransectionTerms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
           $request->validate([
                '_name' => 'required|max:255|unique:transection_terms,_name,'.$request->id,
               
        ]);
        $data = TransectionTerms::find($request->id);
        $data->_name       = $request->_name ?? '';
        $data->_font_color       = $request->_font_color ?? '';
        $data->_detail       = $request->_detail ?? '';
        $data->_days       = $request->_days ?? 0;
        $data->_status     = $request->_status ?? '';
        $data->save();

        return redirect('transection_terms')->with('success','Information Save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransectionTerms  $TransectionTerms
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TransectionTerms::find($id)->delete();
        return redirect()->route('transection_terms.index')
                        ->with('danger','Information deleted successfully');
    }
}
