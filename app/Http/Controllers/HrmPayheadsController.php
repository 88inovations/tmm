<?php

namespace App\Http\Controllers;

use App\Models\HRM\HrmPayheads;
use App\Models\HRM\HrmPayHeadType;
use Illuminate\Http\Request;
use Session;
use Auth;

class HrmPayheadsController extends Controller
{


 function __construct()
    {
        
         $this->middleware('permission:pay-heads-create', ['only' => ['create','store']]);
         $this->middleware('permission:pay-heads-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:pay-heads-list', ['only' => ['index']]);
         $this->middleware('permission:pay-heads-delete', ['only' => ['destroy']]);
         $this->page_name = "Pay Heads";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
    {
        $page_name = $this->page_name;
         $datas = HrmPayheads::with(['_payhead_type','_ledger_info'])->orderBy('id','ASC')->get();

        if($request->has('print')){
            if($request->print =="detail"){
                return view('hrm.pay-heads.print',compact('datas','page_name','request'));
            }
         }

        return view('hrm.pay-heads.index',compact('datas','page_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
        $payhead_typs = HrmPayHeadType::where('_status',1)->get();
        return view('hrm.pay-heads.create',compact('page_name','payhead_typs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dump($request->all());
        // die();
         $this->validate($request, [
            '_ledger' => 'required|unique:hrm_payheads,_ledger',
            '_type' => 'required',
        ]);

        try {
            $_user = Auth::user();
            $data = new HrmPayheads();
            $data->_type =$request->_type;
            $data->_ledger =$request->_ledger ?? 0;
            $data->_ledger_id =$request->_ledger_id ?? 0;
            $data->_calculation =$request->_calculation ?? '';
            $data->_onhead =$request->_onhead ?? '';
            $data->_status =$request->_status ?? 1;
          
            $data->_user = $_user->id;
            $data->save();
            return redirect('pay-heads')->with('success','Information Save successfully');
        }

        //catch exception
        catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HRM\HrmPayheads  $hrmPayheads
     * @return \Illuminate\Http\Response
     */
   public function show($id)
    {
        $page_name = $this->page_name;
        $data = HrmPayheads::find($id);

        return view('hrm.pay-heads.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HRM\HrmPayheads  $hrmPayheads
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
         $data = HrmPayheads::find($id);
         $payhead_typs = HrmPayHeadType::where('_status',1)->get();

        return view('hrm.pay-heads.edit',compact('data','page_name','payhead_typs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HRM\HrmPayheads  $hrmPayheads
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            '_ledger' => 'required|unique:hrm_payheads,_ledger,'.$id,
            '_type' => 'required',
        ]);

        try {
            $_user = Auth::user();
            $data =  HrmPayheads::find($id);
            $data->_type =$request->_type;
            $data->_ledger =$request->_ledger ?? '';
            $data->_ledger_id =$request->_ledger_id ?? 0;
            $data->_calculation =$request->_calculation ?? '';
            $data->_onhead =$request->_onhead ?? '';
            $data->_status =$request->_status ?? 1;
          
            $data->_user = $_user->id;
            $data->save();
            return redirect('pay-heads')->with('success','Information Save successfully');
        }

        //catch exception
        catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HRM\HrmPayheads  $hrmPayheads
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        HrmPayheads::find($id)->update(['_status'=>0]);
        return redirect('pay-heads')->with('success','Information deleted successfully');
    }
}
