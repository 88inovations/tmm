<?php

namespace App\Http\Controllers;

use App\Models\MusakFourPointThree;
use App\Models\Units;
use App\Models\ItemCategory;
use App\Models\account_types;
use App\Models\AccountHead;
use App\Models\StoreHouse;
use App\Models\MusakFourPointThreeInput;
use App\Models\MusakFourPointThreeAddition;
use Auth;
use DB;
use Illuminate\Http\Request;

class MusakFourPointThreeController extends Controller
{
     function __construct()
    {
         $this->middleware('permission:musak-four-point-three-list|musak-four-point-three-create|musak-four-point-three-edit|musak-four-point-three-delete|musak-four-point-three-print', ['only' => ['index','store']]);
         $this->middleware('permission:musak-four-point-three-print', ['only' => ['musak-four-point-threePrint']]);
         $this->middleware('permission:musak-four-point-three-create', ['only' => ['create','store']]);
         $this->middleware('permission:musak-four-point-three-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:musak-four-point-three-delete', ['only' => ['destroy']]);
         $this->page_name = "Item Wise Ingredients";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       // return $request->all();
        $auth_user = Auth::user();
       if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_pur_limit', $request->limit);
        }else{
             $limit= \Session::get('_pur_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $datas = MusakFourPointThree::with(['_items']);
        if($request->has('_user_date') && $request->_user_date=="yes" && $request->_datex !="" && $request->_datex !=""){
            $_datex =  change_date_format($request->_datex);
            $_datey=  change_date_format($request->_datey);

             $datas = $datas->whereDate('_date','>=', $_datex);
            $datas = $datas->whereDate('_date','<=', $_datey);
        }

        if($request->has('id') && $request->id !=""){
            $ids =  array_map('intval', explode(',', $request->id ));
            $datas = $datas->whereIn('id', $ids); 
        }
        
        if($request->has('_responsible_person') && $request->_responsible_person !=''){
            $datas = $datas->where('_responsible_person','like',"%trim($request->_responsible_person)%");
        }
        if($request->has('_main_item_id')){
            $datas = $datas->where('_item_id',trim($request->_main_item_id));
        }

       
       
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);

         $page_name = $this->page_name;
         $account_types = [];
         $account_groups = [];
        $current_date = date('Y-m-d');
          $current_time = date('H:i:s');
          $users = Auth::user();
       
        
        

        return view('backend.musak-four-point-three.index',compact('datas','page_name','account_types','request','account_groups','current_date','limit'));
    }


    public function detail(Request $request){
        $_no = $request->invoice_id;
        $_input_details = DB::select( " SELECT t1.*,t2._item,t3._name AS _unit FROM musak_four_point_three_inputs AS t1 
                    INNER JOIN inventories AS t2 ON t1._item_id=t2.id
                    INNER JOIN units AS t3 ON t3.id=t1._transection_unit
                    WHERE t1._no=$_no AND t1._last_edition=1 ");
        $_addition_details = DB::select( "SELECT t1.*,t2._name 
                            FROM musak_four_point_three_additions AS t1
                            INNER JOIN account_ledgers AS t2 ON t1._ledger_id=t2.id
                            WHERE t1._no=$_no AND t1._last_edition=1");
        return view('backend.musak-four-point-three.detail',compact('_input_details','_addition_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = Auth::user();
        $page_name = $this->page_name;
        $account_groups = [];
        $units = Units::orderBy('_name','asc')->get();
         $categories = ItemCategory::orderBy('_name','asc')->get();
          $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
          $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        return view('backend.musak-four-point-three.create',compact('page_name','units','account_groups','categories','account_types','permited_branch','permited_costcenters','store_houses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //return $request->all();
         $this->validate($request, [
            '_date' => 'required',
            '_main_item_id' => 'required',
            '_responsible_person' => 'required'
        ]);
        DB::beginTransaction();
        try {
          $users = Auth::user();
         $MusakFourPointThree = new MusakFourPointThree();
         $MusakFourPointThree->_date = change_date_format($request->_date);
         $MusakFourPointThree->_item_id = $request->_main_item_id;
          $MusakFourPointThree->_first_delivery_date = change_date_format($request->_first_delivery_date ?? date('Y-m-d'));
          $MusakFourPointThree->_first_delivery_date = change_date_format($request->_first_delivery_date ?? date('Y-m-d'));
          $MusakFourPointThree->_additional_vat_rate = $request->_additional_vat_rate ?? 0;
         $MusakFourPointThree->_vat_amount = $request->_vat_amount ?? 0;
          $MusakFourPointThree->_cost_price = $request->_cost_price ?? 0;
          $MusakFourPointThree->_sales_price = $request->_sales_price ?? 0;
          $MusakFourPointThree->_responsible_person = $request->_responsible_person ?? 0;
         $MusakFourPointThree->_res_per_designation = $request->_res_per_designation ?? '';
         $MusakFourPointThree->_gp_amount = $request->_gp_amount ?? 0;
         $MusakFourPointThree->_gp_per = $request->_gp_per ?? 0;
          $MusakFourPointThree->_status = 1;
         $MusakFourPointThree->_created_by =$users->name ?? '';
         $MusakFourPointThree->save();

         DB::table('inventories')->where('id',$request->_main_item_id)->update(['_pur_rate'=>$request->_cost_price,'_sale_rate'=>$request->_sales_price]);

         $musak_id = $MusakFourPointThree->id;

         $inputs_ids = $request->inputs_id ?? [];
         $_item_ids = $request->_item_id ?? [];
         $_unit_ids = $request->_unit_id ?? [];

         $_transection_units = $request->_transection_unit ?? [];
         $_base_rates = $request->_base_rate ?? [];
         $conversion_qtys = $request->conversion_qty ?? [];
         $_base_unit_ids = $request->_base_unit_id ?? [];


         $_codes = $request->_code ?? [];
         $_qtys = $request->_qty ?? [];
         $conversion_qtys = $request->conversion_qty ?? [];
         $_rates = $request->_rate ?? [];
         $_values = $request->_value ?? [];
         $_wastage_amts = $request->_wastage_amt ?? [];
         $_wastage_rates = $request->_wastage_rate ?? [];
         $_statuss = $request->_status ?? [];

         if(sizeof($_item_ids) > 0){
            for ($i = 0; $i <sizeof($_item_ids) ; $i++) {
                $MusakFourPointThreeInput = new MusakFourPointThreeInput();
                $MusakFourPointThreeInput->_no = $musak_id;
                $MusakFourPointThreeInput->_item_id = $_item_ids[$i];

                $MusakFourPointThreeInput->_base_unit = $_base_unit_ids[$i];
                $MusakFourPointThreeInput->_unit_id = $_base_unit_ids[$i];
                $MusakFourPointThreeInput->_transection_unit = $_transection_units[$i];
                $MusakFourPointThreeInput->conversion_qty = $conversion_qtys[$i] ?? 0;
                $MusakFourPointThreeInput->_unit_conversion = $conversion_qtys[$i] ?? 0;
                $MusakFourPointThreeInput->_base_rate = $_base_rates[$i] ?? 0;


                $MusakFourPointThreeInput->_code = $_codes[$i] ?? '';
                $MusakFourPointThreeInput->_qty = $_qtys[$i] ?? 0;

                $MusakFourPointThreeInput->_rate = $_rates[$i] ?? 0;
                $MusakFourPointThreeInput->_value = $_values[$i] ?? 0;
                $MusakFourPointThreeInput->_wastage_amt = $_wastage_amts[$i] ?? 0;
                $MusakFourPointThreeInput->_wastage_rate = $_wastage_rates[$i] ?? 0;
                $MusakFourPointThreeInput->_status = $_statuss[$i] ?? 1;
                $MusakFourPointThreeInput->_last_edition = 1;
                $MusakFourPointThreeInput->save();

            }

         }


         $_ledger_ids= $request->_ledger_id ?? [];
         $_short_narrs= $request->_short_narr ?? [];
         $_amounts= $request->_amount ?? [];
         $addition__statuss= $request->addition__status ?? [];
          if(sizeof($_ledger_ids) > 0){
            for ($i = 0; $i <sizeof($_ledger_ids) ; $i++) {
                if($_ledger_ids[$i] !=""){
                    $MusakFourPointThreeAddition = new MusakFourPointThreeAddition();
                    $MusakFourPointThreeAddition->_no = $musak_id;
                    $MusakFourPointThreeAddition->_ledger_id = $_ledger_ids[$i];
                    $MusakFourPointThreeAddition->_short_narr = $_short_narrs[$i];
                    $MusakFourPointThreeAddition->_amount = $_amounts[$i] ?? '';
                    $MusakFourPointThreeAddition->_status = $addition__statuss[$i] ?? 1;
                    $MusakFourPointThreeAddition->_last_edition = 1;
                    $MusakFourPointThreeAddition->save();
                }
                

            }

         }

           DB::commit();
          return redirect()->back()->with('success','Information save successfully');
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back()->with('danger','There is Something Wrong !');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MusakFourPointThree  $musakFourPointThree
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = Auth::user();
        $page_name = $this->page_name;
        $account_groups = [];
        $units = Units::orderBy('_name','asc')->get();
         $categories = ItemCategory::orderBy('_name','asc')->get();
          $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
          $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
         $data = MusakFourPointThree::with(['input_detail','addition_detail','_items','_responsiable_per'])->find($id);
        return view('backend.musak-four-point-three.show',compact('page_name','units','account_groups','categories','account_types','permited_branch','permited_costcenters','store_houses','data'));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MusakFourPointThree  $musakFourPointThree
     * @return \Illuminate\Http\Response
     */
    public function musakFourPointThreeTem1($id)
    {
        $users = Auth::user();
        $page_name = $this->page_name;
        $account_groups = [];
        $units = Units::orderBy('_name','asc')->get();
         $categories = ItemCategory::orderBy('_name','asc')->get();
          $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
          $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
         $data = MusakFourPointThree::with(['input_detail','addition_detail','_items','_responsiable_per'])->find($id);
        return view('backend.musak-four-point-three.show_1',compact('page_name','units','account_groups','categories','account_types','permited_branch','permited_costcenters','store_houses','data'));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MusakFourPointThree  $musakFourPointThree
     * @return \Illuminate\Http\Response
     */
    public function musakFourPointThreeTem2($id)
    {
        $users = Auth::user();
        $page_name = $this->page_name;
        $account_groups = [];
        $units = Units::orderBy('_name','asc')->get();
         $categories = ItemCategory::orderBy('_name','asc')->get();
          $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
          $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
         $data = MusakFourPointThree::with(['input_detail','addition_detail','_items','_responsiable_per'])->find($id);
        return view('backend.musak-four-point-three.show_2',compact('page_name','units','account_groups','categories','account_types','permited_branch','permited_costcenters','store_houses','data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MusakFourPointThree  $musakFourPointThree
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = Auth::user();
        $page_name = $this->page_name;
        $account_groups = [];
        $units = Units::orderBy('_name','asc')->get();
         $categories = ItemCategory::orderBy('_name','asc')->get();
          $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
          $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
          $data = MusakFourPointThree::with(['input_detail','addition_detail','_items','_responsiable_per'])->find($id);
        return view('backend.musak-four-point-three.edit',compact('page_name','units','account_groups','categories','account_types','permited_branch','permited_costcenters','store_houses','data'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MusakFourPointThree  $musakFourPointThree
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //return $request->all();
 
         $this->validate($request, [
            '_date' => 'required',
            '_main_item_id' => 'required',
            '_responsible_person' => 'required'
        ]);
        DB::beginTransaction();
        try {
          $users = Auth::user();
         $MusakFourPointThree =  MusakFourPointThree::find($id);
         $MusakFourPointThree->_date = change_date_format($request->_date);
         $MusakFourPointThree->_item_id = $request->_main_item_id;
          $MusakFourPointThree->_first_delivery_date = change_date_format($request->_first_delivery_date ?? date('Y-m-d'));
          $MusakFourPointThree->_first_delivery_date = change_date_format($request->_first_delivery_date ?? date('Y-m-d'));
          $MusakFourPointThree->_additional_vat_rate = $request->_additional_vat_rate ?? 0;
         $MusakFourPointThree->_vat_amount = $request->_vat_amount ?? 0;
          $MusakFourPointThree->_cost_price = $request->_cost_price ?? 0;
          $MusakFourPointThree->_sales_price = $request->_sales_price ?? 0;
          $MusakFourPointThree->_responsible_person = $request->_responsible_person ?? 0;
          $MusakFourPointThree->_gp_amount = $request->_gp_amount ?? 0;
          $MusakFourPointThree->_gp_per = $request->_gp_per ?? 0;
         $MusakFourPointThree->_res_per_designation = $request->_res_per_designation ?? '';
          $MusakFourPointThree->_status = 1;
         $MusakFourPointThree->_created_by =$users->name ?? '';
         $MusakFourPointThree->save();
         $musak_id = $MusakFourPointThree->id;


         DB::table('inventories')->where('id',$request->_main_item_id)->update(['_pur_rate'=>$request->_cost_price,'_sale_rate'=>$request->_sales_price]);

         MusakFourPointThreeInput::where('_no', $musak_id)
            ->update(['_last_edition'=>0]);
        MusakFourPointThreeAddition::where('_no', $musak_id)
            ->update(['_last_edition'=>0]);

         $inputs_ids = $request->inputs_id ?? [];
         $_item_ids = $request->_item_id ?? [];
         $_unit_ids = $request->_unit_id ?? [];
         $_codes = $request->_code ?? [];
         $_qtys = $request->_qty ?? [];
         $conversion_qtys = $request->conversion_qty ?? [];
         $_rates = $request->_rate ?? [];
         $_values = $request->_value ?? [];
         $_wastage_amts = $request->_wastage_amt ?? [];
         $_wastage_rates = $request->_wastage_rate ?? [];
         $_statuss = $request->_status ?? [];


          $_transection_units = $request->_transection_unit ?? [];
         $_base_rates = $request->_base_rate ?? [];
         $conversion_qtys = $request->conversion_qty ?? [];
         $_base_unit_ids = $request->_base_unit_id ?? [];



         if(sizeof($_item_ids) > 0){
            for ($i = 0; $i <sizeof($_item_ids) ; $i++) {
                if(($inputs_ids[$i] ?? 0) ==0){
                    $MusakFourPointThreeInput = new MusakFourPointThreeInput();
                }else{
                    $MusakFourPointThreeInput = MusakFourPointThreeInput::find($inputs_ids[$i]);
                }
                
                $MusakFourPointThreeInput->_no = $musak_id;
                $MusakFourPointThreeInput->_item_id = $_item_ids[$i];
                $MusakFourPointThreeInput->_code = $_codes[$i] ?? '';
                $MusakFourPointThreeInput->_qty = $_qtys[$i] ?? 0;
                
                $MusakFourPointThreeInput->_base_unit = $_base_unit_ids[$i];
                $MusakFourPointThreeInput->_unit_id = $_base_unit_ids[$i];
                $MusakFourPointThreeInput->_transection_unit = $_transection_units[$i];
                $MusakFourPointThreeInput->conversion_qty = $conversion_qtys[$i] ?? 0;
                $MusakFourPointThreeInput->_unit_conversion = $conversion_qtys[$i] ?? 0;
                $MusakFourPointThreeInput->_base_rate = $_base_rates[$i] ?? 0;

                $MusakFourPointThreeInput->_rate = $_rates[$i] ?? 0;
                $MusakFourPointThreeInput->_value = $_values[$i] ?? 0;
                $MusakFourPointThreeInput->_wastage_amt = $_wastage_amts[$i] ?? 0;
                $MusakFourPointThreeInput->_wastage_rate = $_wastage_rates[$i] ?? 0;
                $MusakFourPointThreeInput->_status = $_statuss[$i] ?? 1;
                $MusakFourPointThreeInput->_last_edition = 1;
                $MusakFourPointThreeInput->save();

            }

         }


         $_ledger_ids= $request->_ledger_id ?? [];
         $_aditions_ids= $request->_aditions_id ?? [];
         $_short_narrs= $request->_short_narr ?? [];
         $_amounts= $request->_amount ?? [];
         $addition__statuss= $request->addition__status ?? [];
          if(sizeof($_ledger_ids) > 0){
            for ($i = 0; $i <sizeof($_ledger_ids) ; $i++) {
                if($_ledger_ids[$i] !=""){
                        if(($_aditions_ids[$i] ?? 0)==0){
                            $MusakFourPointThreeAddition = new MusakFourPointThreeAddition();
                        }else{
                            $MusakFourPointThreeAddition = MusakFourPointThreeAddition::find($_aditions_ids[$i]);
                        }
                    
                    $MusakFourPointThreeAddition->_no = $musak_id;
                    $MusakFourPointThreeAddition->_ledger_id = $_ledger_ids[$i];
                    $MusakFourPointThreeAddition->_short_narr = $_short_narrs[$i];
                    $MusakFourPointThreeAddition->_amount = $_amounts[$i] ?? 0;
                    $MusakFourPointThreeAddition->_status = $addition__statuss[$i] ?? 1;
                    $MusakFourPointThreeAddition->_last_edition = 1;
                    $MusakFourPointThreeAddition->save();
                }
                

            }

         }

           DB::commit();
         
           return redirect()->back()->with('success','Information save successfully');
       } catch (\Exception $e) {
          DB::rollback();
          return redirect()->back()->with('danger','There is Something Wrong !');
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MusakFourPointThree  $musakFourPointThree
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
