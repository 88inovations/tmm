<?php

namespace App\Http\Controllers;

use App\Models\CatWiseTaBill;
use App\Models\HRM\Designation;
use Illuminate\Http\Request;
use Auth;
use Session;

class CatWiseTaBillController extends Controller
{

     function __construct()
    {
        
         $this->middleware('permission:cat_wise_ta_bills-create', ['only' => ['create','store']]);
         $this->middleware('permission:cat_wise_ta_bills-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:cat_wise_ta_bills-list', ['only' => ['index']]);
         $this->middleware('permission:cat_wise_ta_bills-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.cat_wise_ta_bills');
    }

 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
    {

        
      if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('limit', $request->limit);
        }else{
             $limit= Session::get('limit') ??  default_pagination();
            
        }
       
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';
        
        $page_name = $this->page_name;
          $datas = CatWiseTaBill::with(['_emp_designation']);
          if($request->has('_fescal_year') && $request->_fescal_year !=''){
            $datas = $datas->where('_fescal_year','=',$request->_fescal_year);
        }
          if($request->has('_designation_id') && $request->_designation_id !=''){
            $datas = $datas->where('_designation_id','=',$request->_designation_id);
        }
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);

        return view('backend.cat_wise_ta_bills.index',compact('datas','page_name','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
        $designations   = Designation::get();
       
        return view('backend.cat_wise_ta_bills.create',compact('page_name','designations'));
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
            '_fescal_year' => 'required',
            
        ]);

        try {
            $_user = Auth::user();
            $data                   = new CatWiseTaBill();
            $data->_fescal_year     =$request->_fescal_year ?? '';
            $data->_designation_id  =$request->_designation_id ?? 0;
            $data->_da_bill         =$request->_da_bill ?? 0;
            $data->_moto_bill       =$request->_moto_bill ?? 0;
            $data->_status          =$request->_status ?? 0;
            $data->_created_by            = $_user->id;
            $data->save();
            return redirect('cat_wise_ta_bills')->with('success','Information Save successfully');
        }

        //catch exception
        catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HRM\Designation  $Designation
     * @return \Illuminate\Http\Response
     */
   public function show($id)
    {
        $page_name = $this->page_name;
        $data = CatWiseTaBill::with(['_emp_designation'])->find($id);

        return view('backend.cat_wise_ta_bills.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HRM\Designation  $Designation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
        $designations   = Designation::get();
         $data = CatWiseTaBill::with(['_emp_designation'])->find($id);
        

        return view('backend.cat_wise_ta_bills.edit',compact('data','page_name','designations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HRM\Designation  $Designation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

       // return $request->all();

        $this->validate($request, [
            '_fescal_year' => 'required',
           
        ]);

        try {
            $_user = Auth::user();
            $data =  CatWiseTaBill::find($id);
              $data->_fescal_year     =$request->_fescal_year ?? '';
            $data->_designation_id  =$request->_designation_id ?? 0;
            $data->_da_bill         =$request->_da_bill ?? 0;
            $data->_moto_bill       =$request->_moto_bill ?? 0;
            $data->_status          =$request->_status ?? 0;
            $data->_updated_by            = $_user->id;
            $data->save();
            return redirect('cat_wise_ta_bills')->with('success','Information Save successfully');
        }

        //catch exception
        catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HRM\Designation  $Designation
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        CatWiseTaBill::find($id)->delete();
        return redirect('cat_wise_ta_bills')->with('success','Information deleted successfully');
    }
}
