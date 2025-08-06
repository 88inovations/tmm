<?php

namespace App\Http\Controllers;

use App\Models\VatRule;
use Session;
use Illuminate\Http\Request;

class VatRuleController extends Controller
{

          function __construct()
    {
         $this->middleware('permission:vat-rules-list|vat-rules-create|vat-rules-edit|vat-rules-delete|vat-rules-print', ['only' => ['index','store']]);
         $this->middleware('permission:vat-rules-print', ['only' => ['vat-rulesPrint']]);
         $this->middleware('permission:vat-rules-create', ['only' => ['create','store']]);
         $this->middleware('permission:vat-rules-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:vat-rules-delete', ['only' => ['destroy']]);
         $this->page_name = "Vat Rules";
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

        $datas = VatRule::where('id','!=','');
        if($request->has('_rate') && $request->_rate !=''){
            $datas = $datas->where('_rate','=',trim($request->_rate));
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
                return view('backend.vat-rules.master_print',compact('datas','page_name','request','limit'));
            }
         }

        
         

        return view('backend.vat-rules.index',compact('datas','request','page_name','limit'));

    }



    public function reset(){
        Session::flash('_u_limit');
       return  \Redirect::to('vat-rules?limit='.default_pagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
        return view('backend.vat-rules.create',compact('page_name'));
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
            '_name' => 'required|unique:vat_rules,_name',
        ]);
        $data = new VatRule();
        $data->_name       = $request->_name ?? '';
        $data->_rate       = $request->_rate ?? 0;
        $data->_status     = $request->_status ?? 1;
        $data->save();

        return redirect()->back()->with('success','Information Save successfully');



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VatRule  $VatRule
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_name = $this->page_name;
         $data = VatRule::find($id);
        return view('backend.vat-rules.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VatRule  $VatRule
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
        $data = VatRule::find($id);
        return view('backend.vat-rules.edit',compact('data','page_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VatRule  $VatRule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $this->validate($request, [
            '_name' => 'required|unique:vat_rules,_name,'.$request->id,
        ]);
       
        $data = VatRule::find($request->id);
        $data->_name       = $request->_name ?? '';
        $data->_rate       = $request->_rate ?? '';
        $data->_status     = $request->_status ?? '';
        $data->save();

        return redirect('vat-rules')->with('success','Information Save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VatRule  $VatRule
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        VatRule::find($id)->delete();
        return redirect()->route('vat-rules.index')
                        ->with('danger','Information deleted successfully');
    }
}
