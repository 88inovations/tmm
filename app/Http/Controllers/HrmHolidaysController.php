<?php

namespace App\Http\Controllers;

use App\Models\HRM\HrmHolidays;
use App\Models\HRM\HrmHolidayDetail;
use Illuminate\Http\Request;
use Session;
use Auth;

class HrmHolidaysController extends Controller
{

    function __construct()
    {
        
         $this->middleware('permission:holidays-create', ['only' => ['create','store']]);
         $this->middleware('permission:holidays-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:holidays-list', ['only' => ['index']]);
         $this->page_name = "Holidays";
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page_name = $this->page_name;
         $datas = HrmHolidays::with(['holiday_details','_entry_by'])->orderBy('id','ASC')->get();

        if($request->has('print')){
            if($request->print =="detail"){
                return view('hrm.holidays.print',compact('datas','page_name','request'));
            }
         }

        return view('hrm.holidays.index',compact('datas','page_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
        return view('hrm.holidays.create',compact('page_name'));
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
            '_datex' => 'required',
            '_datey' => 'required',
            '_name' => 'required',
            '_date' => 'required',
            '_type' => 'required',
        ]);

        try {
           $_user = Auth::user();
             $data = new HrmHolidays();
             $data->_dfrom = change_date_format($request->_datex ?? '');
             $data->_dto = change_date_format($request->_datey ?? '');
             $data->_user = $_user->id;
             $data->save();

             $holiday_id = $data->id;

             $_names = $request->_name ?? [];
             $_dates = $request->_date ?? [];
             $_types = $request->_type ?? [];

             for ($i=0; $i <sizeof($_names) ; $i++) { 
                $HrmHolidayDetail = new HrmHolidayDetail();
                $HrmHolidayDetail->_holidaysid = $holiday_id;
                $HrmHolidayDetail->_name = $_names[$i] ?? '';
                $HrmHolidayDetail->_type = $_types[$i] ?? '';
                $HrmHolidayDetail->_date = change_date_format($_dates[$i] ?? '');
                $HrmHolidayDetail->_user = $_user->id;
                $HrmHolidayDetail->save();

             }

             return redirect('holidays')->with('success','Information Save successfully');
        }

        //catch exception
        catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }

        


         

        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HRM\HrmHolidays  $hrmHolidays
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {

       $page_name = $this->page_name;
        $data = HrmHolidays::with(['holiday_details','_entry_by'])->find($id);

        return view('hrm.holidays.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HRM\HrmHolidays  $hrmHolidays
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
         $data = HrmHolidays::with(['holiday_details','_entry_by'])->find($id);

        return view('hrm.holidays.edit',compact('data','page_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HRM\HrmHolidays  $hrmHolidays
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            '_datex' => 'required',
            '_datey' => 'required',
            '_name' => 'required',
            '_date' => 'required',
            '_type' => 'required',
        ]);
       
// dump($request->all());
// die();
        $data = HrmHolidays::with(['holiday_details','_entry_by'])->find($id);

        $old_ids =[];
        $holiday_details = $data->holiday_details ?? [];
        foreach ($holiday_details as $key => $value) {
            array_push($old_ids, $value->id);
        }


        try {
           $_user = Auth::user();

        //     dump($_user->id);
        // die();
             $data =  HrmHolidays::find($id);
             $data->_dfrom = change_date_format($request->_datex ?? '');
             $data->_dto = change_date_format($request->_datey ?? '');
             $data->_user = $_user->id;
             $data->save();

             $holiday_id = $data->id;

             $_names = $request->_name ?? [];
             $_dates = $request->_date ?? [];
             $_types = $request->_type ?? [];
             $_detail_ids = $request->_detail_id ?? [];
             

             for ($i=0; $i <sizeof($_detail_ids); $i++) { 

                if($_detail_ids[$i]==0){
                      $HrmHolidayDetail = new HrmHolidayDetail();
                 }else{
                    $HrmHolidayDetail = HrmHolidayDetail::find($_detail_ids[$id]);
                 }

               
                $HrmHolidayDetail->_holidaysid = $holiday_id;
                $HrmHolidayDetail->_name = $_names[$i] ?? '';
                $HrmHolidayDetail->_type = $_types[$i] ?? '';
                $HrmHolidayDetail->_date = change_date_format($_dates[$i] ?? '');
                $HrmHolidayDetail->_user = $_user->id;
                $HrmHolidayDetail->save();

             }

             $deleteable_ids = array_diff($old_ids, $_detail_ids);
             if(sizeof($deleteable_ids) > 0 ){
                 HrmHolidayDetail::destroy($deleteable_ids);
             }

            





             return redirect('holidays')->with('success','Information Save successfully');
        }

        //catch exception
        catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HRM\HrmHolidays  $hrmHolidays
     * @return \Illuminate\Http\Response
     */
    public function destroy(HrmHolidays $hrmHolidays)
    {
        //
    }
}
