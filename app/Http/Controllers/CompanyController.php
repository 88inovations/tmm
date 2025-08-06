<?php

namespace App\Http\Controllers;

use App\Models\HRM\Company;
use Illuminate\Http\Request;
use Auth;
use Session;

class CompanyController extends Controller
{
    
 function __construct()
    {
        
         $this->middleware('permission:companies-create', ['only' => ['create','store']]);
         $this->middleware('permission:companies-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:companies-list', ['only' => ['index']]);
         $this->middleware('permission:companies-delete', ['only' => ['destroy']]);
         $this->page_name = "Company";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
    {
        $page_name = $this->page_name;
         $datas = Company::orderBy('id','ASC')->get();

        if($request->has('print')){
            if($request->print =="detail"){
                return view('hrm.companies.print',compact('datas','page_name','request'));
            }
         }

        return view('hrm.companies.index',compact('datas','page_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
       
        return view('hrm.companies.create',compact('page_name'));
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
            '_code' => 'required',
            '_name' => 'required',
        ]);

        try {
            $_user = Auth::user();
            $data = new Company();
            $data->_code =$request->_code ?? '';
            $data->_name =$request->_name ?? 0;
            $data->_details =$request->_details ?? '';
            $data->_status =$request->_status ?? 0;
            $data->_user = $_user->id;
            $data->save();
            return redirect('companies')->with('success','Information Save successfully');
        }

        //catch exception
        catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\HRM\Company  $Company
     * @return \Illuminate\Http\Response
     */
   public function show($id)
    {
        $page_name = $this->page_name;
        $data = Company::find($id);

        return view('hrm.companies.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\HRM\Company  $Company
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
         $data = Company::find($id);
        

        return view('hrm.companies.edit',compact('data','page_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\HRM\Company  $Company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $this->validate($request, [
            '_code' => 'required',
            '_name' => 'required',
        ]);

        try {
            $_user = Auth::user();
            $data =  Company::find($id);
             $data->_code =$request->_code ?? '';
            $data->_name =$request->_name ?? 0;
            $data->_details =$request->_details ?? '';
            $data->_status =$request->_status ?? 0;
            $data->_user = $_user->id;
            $data->save();
            return redirect('companies')->with('success','Information Save successfully');
        }

        //catch exception
        catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\HRM\Company  $Company
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        Company::find($id)->delete();
        return redirect('companies')->with('success','Information deleted successfully');
    }
}
