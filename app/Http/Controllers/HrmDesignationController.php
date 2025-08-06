<?php

namespace App\Http\Controllers;

use App\Models\HRM\Designation;
use Illuminate\Http\Request;
use Auth;
use Session;

class HrmDesignationController extends Controller
{
    function __construct()
    {
        
         $this->middleware('permission:hrm-designation-create', ['only' => ['create','store']]);
         $this->middleware('permission:hrm-designation-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:hrm-designation-list', ['only' => ['index']]);
         $this->middleware('permission:hrm-designation-delete', ['only' => ['destroy']]);
         $this->page_name = "Employee Designation";
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
          $datas = Designation::where('_name','!=',"");
          if($request->has('_name') && $request->_name !=''){
            $datas = $datas->where('_name','like',"%$request->_name%");
        }
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);

        return view('hrm.hrm-designation.index',compact('datas','page_name','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
       
        return view('hrm.hrm-designation.create',compact('page_name'));
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
            '_name' => 'required',
            
        ]);

        try {
            $_user = Auth::user();
            $data = new Designation();
            $data->_name =$request->_name ?? '';
            $data->_status =$request->_status ?? 0;
            $data->_user = $_user->id;
            $data->save();
            return redirect('hrm-designation')->with('success','Information Save successfully');
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
        $data = Designation::find($id);

        return view('hrm.hrm-designation.show',compact('data','page_name'));
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
         $data = Designation::find($id);
        

        return view('hrm.hrm-designation.edit',compact('data','page_name'));
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
        $this->validate($request, [
            '_name' => 'required',
           
        ]);

        try {
            $_user = Auth::user();
            $data =  Designation::find($id);
             $data->_name =$request->_name ?? '';
            $data->_status =$request->_status ?? 0;
            $data->_user = $_user->id;
            $data->save();
            return redirect('hrm-designation')->with('success','Information Save successfully');
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
        Designation::find($id)->delete();
        return redirect('hrm-designation')->with('success','Information deleted successfully');
    }
}
