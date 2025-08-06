<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDuty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Auth;
use Carbon\Carbon;


class EmployeeDutyController extends Controller
{

     function __construct()
    {
         $this->middleware('permission:employee_duty-list|employee_duty-create|employee_duty-edit|employee_duty-delete', ['only' => ['index','store']]);
         $this->middleware('permission:employee_duty-create', ['only' => ['create','store']]);
         $this->middleware('permission:employee_duty-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:employee_duty-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.employee_duty');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $auth_user = Auth::user();
       if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_duity_limit', $request->limit);
        }else{
             $limit= \Session::get('_duity_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';


        $datas = EmployeeDuty::with(['_employee','_branch','_user']);

      

        if($auth_user->user_type !='admin'){
            $datas = $datas->where('_user_id',$auth_user->id);   
        }
          $all_employees_ids = $datas->distinct()->pluck('_employee_id');

         if($request->has('_user_date') && $request->_user_date=="yes" && $request->_datex !="" && $request->_datex !=""){
            $_datex =  change_date_format($request->_datex);
            $_datey=  change_date_format($request->_datey);

             $datas = $datas->whereDate('_date','>=', $_datex);
            $datas = $datas->whereDate('_date','<=', $_datey);
        }

        if($request->has('_branch_id') && $request->_branch_id !=''){
            $datas= $datas->where('_branch_id',$request->_branch_id);
        }
        if($request->has('_employee_id') && $request->_employee_id !=''){
            $datas= $datas->where('_employee_id',$request->_employee_id);
        }
        if($request->has('entry_type') && $request->entry_type !=''){
            $datas= $datas->where('entry_type',$request->entry_type);
        }
         $datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);

        $page_name = $this->page_name ?? '';


        $permited_branch = permited_branch(explode(',',$auth_user->branch_ids));


        $emmployees =\DB::table('account_ledgers')
                    ->select('id','_name','_code','_alious')
                    ->whereIn('_branch_id',explode(',',$auth_user->branch_ids))
                    ->whereIn('id',$all_employees_ids)
                    ->get();


        return view('hrm.employee_duty.index',compact('page_name','datas','limit','permited_branch','emmployees','request'));

    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function start_duty(Request $request){

    $latitude = $request->latitude;
    $longitude = $request->longitude;

    $url = "https://api.opencagedata.com/geocode/v1/json?q=$latitude%2C+$longitude&key=d604951a00a048cab8888db46551bb56";
   // $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat=22.8103&lon=90.4125";

    $response = Http::get($url)->json();
    $formatted = $response["results"][0]['formatted'] ?? '';
    $addressParts = $response["results"][0]["components"] ?? '';
    $date = date('Y-m-d');
    $time = date('H:s a');
    $auth_user = Auth::user();
    $_user_id  = $auth_user->id;
    $ref_id  = $auth_user->ref_id;
    $currentTime = Carbon::now()->format('H:i');

    // Determine Entry Type Based on Time
        if ($currentTime >= '06:00' && $currentTime <= '12:00') {
            $entry_type = 'Start';
        } elseif ($currentTime >= '12:01' && $currentTime <= '16:00') {
            $entry_type = 'Launch';
        } else {
            $entry_type = 'Close';
        }

        // Fetch existing record for the employee on the same date
        $duty = EmployeeDuty::where('_user_id', $_user_id)
            ->where('entry_type', $entry_type)
            ->where('_date', Carbon::today()->format('Y-m-d'))
            ->first();

        $ledger = \DB::table("account_ledgers")
                ->where('id',$ref_id)->first();

         $employee_info = \DB::table('hrm_employees')->where('_ledger_id',$ref_id)->first();
        $_employee_id  = $ledger->id ?? 0;


        $_branch_id  = $ledger->_branch_id ?? 1;
        $_emp_id     = $ledger->_code ?? '';
        $organization_id     = $ledger->organization_id ?? 1;
        $_cost_center_id     = $ledger->_cost_center_id ?? 1;

              // If exists, update; otherwise, create a new entry
        if ($duty) {
            $duty->update([
                'date'  => $date,
                'entry_type'  => $entry_type,
                '_branch_id'  => $_branch_id,
                'latitude'  => $latitude,
                'longitude'  => $longitude,
                '_time'       => Carbon::now()->format('H:i:s'),
                'state'       => $addressParts['state'] ?? '',
                'road'        => $addressParts['road'] ?? '',
                'postcode'    => $addressParts['postcode'] ?? '',
                'borough'     => $addressParts['borough'] ?? '',
                'country'     => $addressParts['country'] ?? '',
                'full_address'=> $formatted ?? ''
            ]);
            \DB::table("hrm_attendances")->updateOrInsert(
                    [
                        '_employee_id' => $_employee_id,
                        '_datetime' => Carbon::today()->format('Y-m-d')
                    ],
                    [
                        
                        'organization_id' => $organization_id,
                        '_branch_id' => $_branch_id,
                        '_emp_id' => $_emp_id,
                         '_employee_id'=>$_employee_id,
                        '_employee'=>$_employee_id,
                        '_user_id'=>$_user_id,
                        '_updated_by'=>$_user_id,
                        '_type' => 1,
                        '_cost_center_id' => $_cost_center_id,
                        'out_time' => Carbon::now()->format('H:i:s'),
                        'updated_at' => Carbon::now(),
                    ]
                );


        } else {
            EmployeeDuty::create([
                
                '_employee_id' => $_employee_id,
                '_branch_id' => $_branch_id,
                '_user_id'     => $_user_id,
                 'latitude'  => $latitude,
                'longitude'  => $longitude,
                '_date'        => Carbon::today()->format('Y-m-d'),
                '_time'        => Carbon::now()->format('H:i:s'),
                'entry_type'   => $entry_type,
                'state'        => $addressParts['state'] ?? '',
                'road'         => $addressParts['road'] ?? '',
                'postcode'     => $addressParts['postcode'] ?? '',
                'borough'      => $addressParts['borough'] ?? '',
                'country'      => $addressParts['country'] ?? '',
                'full_address' => $formatted ?? ''
            ]);

            \DB::table("hrm_attendances")->insert([
                'organization_id'=>$organization_id,
                '_branch_id'=>$_branch_id,
                '_branch_id'=>$_branch_id,
                '_employee_id'=>$_employee_id,
                '_employee'=>$_employee_id,
                '_emp_id'=>$_emp_id,
                '_type' => 1,
                '_cost_center_id'=>$_cost_center_id,
                '_user_id'=>$_user_id,
                '_updated_by'=>$_user_id,
                'in_time'=> Carbon::now()->format('H:i:s'),
                '_datetime'=> Carbon::today()->format('Y-m-d'),

            ]);


        }





 return response()->json(['message' => "Your Duty $entry_type", 'entry_type' => $entry_type]);

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
     * @param  \App\Models\EmployeeDuty  $employeeDuty
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeDuty $employeeDuty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmployeeDuty  $employeeDuty
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeDuty $employeeDuty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmployeeDuty  $employeeDuty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeDuty $employeeDuty)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmployeeDuty  $employeeDuty
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeDuty $employeeDuty)
    {
        //
    }
}
