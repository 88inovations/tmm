<?php

namespace App\Http\Controllers;

use App\Models\HRM\HrmWeekworkday;
use Illuminate\Http\Request;
use Session;
use Auth;

class HrmWeekworkdayController extends Controller
{

   function __construct()
    {
        
         $this->middleware('permission:week-work-day', ['only' => ['index']]);
         $this->page_name = "Week Work Day";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $page_name = $this->page_name;
        $data = HrmWeekworkday::first();

        return view('hrm.week-work-day.index',compact('page_name','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return "Ok";
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
     * @param  \App\Models\HRM\HrmWeekworkday  $hrmWeekworkday
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $page_name = $this->page_name;
        $data = HrmWeekworkday::find($id);
        return view('hrm.week-work-day.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HRM\HrmWeekworkday  $hrmWeekworkday
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
        $data = HrmWeekworkday::find($id);
        return view('hrm.week-work-day.edit',compact('data','page_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HRM\HrmWeekworkday  $hrmWeekworkday
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $data = HrmWeekworkday::find($id);
       $data->_saturday = $request->_saturday;
       $data->_sunday = $request->_sunday;
       $data->_monday = $request->_monday;
       $data->_tuesday = $request->_tuesday;
       $data->_wednesday = $request->_wednesday;
       $data->_thursday = $request->_thursday;
       $data->_friday = $request->_thursday;
       $data->save();
       return redirect('weekworkday')->with('success','Information Save successfully');
    }









    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HRM\HrmWeekworkday  $hrmWeekworkday
     * @return \Illuminate\Http\Response
     */
    public function destroy(HrmWeekworkday $hrmWeekworkday)
    {
        //
    }
}
