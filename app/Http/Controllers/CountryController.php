<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Auth;
use Session;

class CountryController extends Controller
{

 function __construct()
    {
         $this->middleware('permission:countries_list|countries_create|countries_edit|countries_delete', ['only' => ['index','store']]);
         $this->middleware('permission:countries_create', ['only' => ['create','store']]);
         $this->middleware('permission:countries_edit', ['only' => ['edit','update']]);
         $this->middleware('permission:countries_delete', ['only' => ['destroy']]);
         $this->page_name = __('label.countries');
    }
    
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $datas = Country::where('countryname','!=',"");
        if($request->has('countrycode') && $request->countrycode !=''){
            $datas = $datas->where('countrycode','like',"%$request->countrycode%");
        }
        if($request->has('countryname') && $request->countryname !=''){
            $datas = $datas->where('countryname','like',"%$request->countryname%");
        }
        if($request->has('code') && $request->code !=''){
            $datas = $datas->where('code','like',"%$request->code%");
        }
        if($request->has('language_code') && $request->language_code !=''){
            $datas = $datas->where('language_code','like',"%$request->language_code%");
        }
        if($request->has('language_name') && $request->language_name !=''){
            $datas = $datas->where('language_name','like',"%$request->language_name%");
        }

         $datas = $datas->orderBy('id','desc')->paginate($limit);
         $page_name = $this->page_name;
          if($request->has('print')){
            if($request->print =="detail"){
                return view('stm.countries.print',compact('datas','page_name','request'));
            }
         }


        return view('stm.countries.index',compact('datas','request','page_name'));

    }



    public function district_wise_upazilla(Request $request){
        $district_id    = $request->_cur_district_id ?? '';

        $_district_wise_upazillas = _district_wise_upazillas($district_id);

        return view('stm.countries.upazilla_select',compact('_district_wise_upazillas'));

    }

    public function division_wise_districts(Request $request){
        $division_id    = $request->division_id ?? '';

        $division_wise_districts = _division_wise_districts($division_id);

        return view('stm.countries.districts_select',compact('division_wise_districts'));
        
    }
    public function upazilla_wise_union(Request $request){
        $district_id        = $request->_cur_district_id ?? '';
        $upazila            = $request->_cur_thana_id ?? '';




        $_upazilla_wise_postcodes = _upazilla_wise_postcodes($district_id,$upazila);

        return view('stm.countries.postcode_select',compact('_upazilla_wise_postcodes'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $page_name = $this->page_name;
        return view('stm.countries.create',compact('request','page_name'));
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
                'countryname' => 'required|max:255|unique:countries,countryname',
            ]);

    $auth_user = Auth::user();
        

        $data = new Country();
        $data->countryname       = $request->countryname ?? '';
        $data->countrycode       = $request->countrycode ?? '';
        $data->code    = $request->code ?? '';
        $data->language_code     = $request->language_code ?? '';
        $data->language_name     = $request->language_name ?? '';
        $data->save();



        return redirect()->back()->with('success','Information Save successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $Country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $Country)
    {
        $page_name = $this->page_name;
        $data = $Country;
        return view('stm.countries.show',compact('page_name','data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $Country
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
        $data = Country::find($id);
        
        return view('stm.countries.edit',compact('page_name','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $Country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $auth_user = Auth::user();

        $request->validate([
                '_name' => 'required|max:255|unique:countries,_name,'.$request->id,
            ]);
        $data = Country::find($request->id);
         $data->countryname       = $request->countryname ?? '';
        $data->countrycode       = $request->countrycode ?? '';
        $data->code               = $request->code ?? '';
        $data->language_code     = $request->language_code ?? '';
        $data->language_name     = $request->language_name ?? '';
        $data->save();
         return redirect()->route('countries.index')->with('success','Information Save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $Country
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
            Country::find($id)->delete();
            return redirect()->route('countries.index')->with('success','Information deleted successfully');
       
    }
}
