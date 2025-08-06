<?php

namespace App\Http\Controllers;

use App\Models\Production;
use Illuminate\Http\Request;
use Auth;
use DB;
use Session;
use App\Models\Sales;
use App\Models\SalesAccount;
use App\Models\SalesDetail;
use App\Models\VoucherMaster;
use App\Models\AccountLedger;
use App\Models\AccountGroup;
use App\Models\AccountHead;
use App\Models\Accounts;
use App\Models\Branch;
use App\Models\VoucherType;
use App\Models\VoucherMasterDetail;
use App\Models\StoreHouse;
use App\Models\SalesFormSetting;
use App\Models\ItemCategory;
use App\Models\Units;
use App\Models\Warranty;
use App\Models\ProductionFromSetting;
use App\Models\StockOut;
use App\Models\StockIn;
use App\Models\ItemInventory;
use App\Models\Inventory;
use App\Models\ProductPriceList;
use App\Models\GeneralSettings;
use App\Models\DirectProduction;
use App\Models\DirectProductionBarcode;
use App\Models\DirectProductionFinisGoods;
use App\Models\DirectProductionRowGoods;
use App\Models\MusakFourPointThree;
use App\Models\ProductionPartialReceive;

class DirectProductionController extends Controller
{

     function __construct()
    {
         $this->middleware('permission:production-list|production-create|production-edit|production-delete|production-print', ['only' => ['index','store']]);
         $this->middleware('permission:production-print', ['only' => ['Print']]);
         $this->middleware('permission:production-create', ['only' => ['create','store']]);
         $this->middleware('permission:production-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:production-delete', ['only' => ['destroy']]);
         $this->middleware('permission:partical-production-receive', ['only' => ['partialProductionReceive']]);
         $this->middleware('permission:finished_goods_receive_to_stock', ['only' => ['finished_goods_receive_to_stock']]);
         $this->page_name = __('label.direct_productions');
    }



    public function PrintOne(Request $request){

        $page_name = __('label.production_receive_challan');
         $production_partial_receives_id = $request->production_partial_receives_id ?? '';
        if($production_partial_receives_id ==''){
            return redirect()->back()->with('error','There is Issue');
        }

        $data = ProductionPartialReceive::where('id',$request->production_partial_receives_id)
                                                ->first();




        $detail_data = DirectProductionFinisGoods::with(['_items','_units','_trans_unit'])
                                                ->where('_no',$request->production_id)
                                                ->where('production_partial_receives_id',$production_partial_receives_id)
                                                ->get();


       return view('backend.direct_productions.print',compact('page_name','data','detail_data'));
    }
    public function PrintTwo(Request $request){
        $page_name = __('label.production_receive_challan');
         $production_partial_receives_id = $request->production_partial_receives_id ?? '';
        if($production_partial_receives_id ==''){
            return redirect()->back()->with('error','There is Issue');
        }

        $data = ProductionPartialReceive::where('id',$request->production_partial_receives_id)
                                                ->first();




        $detail_data = DirectProductionFinisGoods::with(['_items','_units','_trans_unit'])
                                                ->where('_no',$request->production_id)
                                                ->where('production_partial_receives_id',$production_partial_receives_id)
                                                ->get();


       return view('backend.direct_productions.print_2',compact('page_name','data','detail_data'));
    }
    public function Show($id){
        return $request->all();
    }
  
    
    public function edit($id)
    {
         $data = ProductionPartialReceive::find($id);
        $production_id = $data->_production_id;
        $production_partial_receives_id = $data->id;
        $data_production =  Production::where('_lock',0)->where('id',$production_id)->first();
         
         if(!$data_production){
            return redirect()->back()->with('danger','You have no permission to edit or update !');
         }

        $page_name  = __('label.partialProductionReceive');
        $users = Auth::user();
       
        $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
        $account_groups = [];
        $branchs = Branch::select('id','_name')->orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $voucher_types = VoucherType::select('id','_name','_code')->orderBy('_code','asc')->get();
        $store_houses = permited_stores(explode(',',$users->store_ids));
        $_all_store_houses = StoreHouse::select('id','_name','_branch_id')->with(['_branch'])->get();
        $form_settings = ProductionFromSetting::first();
        $inv_accounts = [];
        $p_accounts = [];
        $dis_accounts = [];
        $vat_accounts =[];
        $categories = ItemCategory::with(['_parents'])->select('id','_name','_parent_id')->orderBy('_name','asc')->get();
        $units = Units::select('id','_name','_code')->orderBy('_name','asc')->get();
         $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->where('_status',1)->get();
          $detail_data = DirectProductionFinisGoods::with(['_items','_units','_trans_unit'])
                                                ->where('_no',$production_id)
                                                ->where('production_partial_receives_id',$production_partial_receives_id)
                                                ->get();

       return view('backend.direct_productions.receive_edit',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','vat_accounts','categories','units','_warranties','_all_store_houses','data','detail_data'));
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
    {
        //return $request->all();
        $auth_user = Auth::user();
       if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_pur_limit', $request->limit);
        }else{
             $limit= \Session::get('_pur_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';


        $datas = Production::with(['_stock_in','_stock_out']);
        
        if($auth_user->user_type !='admin'){
                $datas = $datas->where('_user_id',$auth_user->id);   
        } 

        if($request->has('_user_date') && $request->_user_date=="yes" && $request->_datex !="" && $request->_datex !=""){
            $_datex =  change_date_format($request->_datex);
            $_datey=  change_date_format($request->_datey);

             $datas = $datas->whereDate('_date','>=', $_datex);
            $datas = $datas->whereDate('_date','<=', $_datey);
        }

        if($request->has('_from_cost_center') && $request->_from_cost_center !=""){
            $datas = $datas->where('_from_cost_center', $request->_from_cost_center); 
        }

        if($request->has('_from_branch') && $request->_from_branch !=""){
            $datas = $datas->where('_from_branch', $request->_from_branch); 
        }

        if($request->has('_to_cost_center') && $request->_to_cost_center !=""){
            $datas = $datas->where('_to_cost_center', $request->_to_cost_center); 
        }
        if($request->has('_to_branch') && $request->_to_branch !=""){
            $datas = $datas->where('_to_branch', $request->_to_branch); 
        }
        

        if($request->has('_referance') && $request->_referance !=''){
            $datas = $datas->where('_referance','like',"%trim($request->_referance)%");
        }
        if($request->has('_note') && $request->_note !=''){
            $datas = $datas->where('_note','like',"%trim($request->_note)%");
        }
       
         if($request->has('_lock') && $request->_lock !=''){
            $datas = $datas->where('_lock','=',$request->_lock);
        }
        
        if($request->has('_total') && $request->_total !=''){
            $datas = $datas->where('_total','=',trim($request->_total));
        }
        
        $datas = $datas->where('_type','production')->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);

         $page_name = $this->page_name;
         $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
         $account_groups = AccountGroup::select('id','_name')->orderBy('_name','asc')->get();
          $current_date = date('Y-m-d');
          $current_time = date('H:i:s');
          $users = Auth::user();
        $form_settings = ProductionFromSetting::first();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
         

        return view('backend.production.index',compact('datas','page_name','account_types','request','account_groups','current_date','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
    }

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function partical_production_receive_list(Request $request)
    {
        //return $request->all();
        $auth_user = Auth::user();
       if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_p_r_limit', $request->limit);
        }else{
             $limit= \Session::get('_p_r_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';





        $datas = ProductionPartialReceive::with(['_organization','_master_branch','_master_cost_center','_master_store'])->where('_status',1);
        
        if($auth_user->user_type !='admin'){
                $datas = $datas->where('_user_id',$auth_user->id);   
        } 

        if($request->has('_user_date') && $request->_user_date=="yes" && $request->_datex !="" && $request->_datex !=""){
            $_datex =  change_date_format($request->_datex);
            $_datey=  change_date_format($request->_datey);

             $datas = $datas->whereDate('_date','>=', $_datex);
            $datas = $datas->whereDate('_date','<=', $_datey);
        }

        if($request->has('organization_id') && $request->organization_id !=""){
            $datas = $datas->where('organization_id', $request->organization_id); 
        }

        if($request->has('_branch_id') && $request->_branch_id !=""){
            $datas = $datas->where('_branch_id', $request->_branch_id); 
        }

        if($request->has('_cost_center_id') && $request->_cost_center_id !=""){
            $datas = $datas->where('_cost_center_id', $request->_cost_center_id); 
        }
        if($request->has('_store_id') && $request->_store_id !=""){
            $datas = $datas->where('_store_id', $request->_store_id); 
        }
        

        if($request->has('_p_status') && $request->_p_status !=''){
            $datas = $datas->where('_p_status','=',"$request->_p_status");
        }
        if($request->has('_note') && $request->_note !=''){
            $datas = $datas->where('_note','like',"%trim($request->_note)%");
        }
       
         if($request->has('_lock') && $request->_lock !=''){
            $datas = $datas->where('_lock','=',$request->_lock);
        }
        
        
        
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);

         $page_name =__('label.partical_production_receive_list');
         $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
         $account_groups = AccountGroup::select('id','_name')->orderBy('_name','asc')->get();
          $current_date = date('Y-m-d');
          $current_time = date('H:i:s');
          $users = Auth::user();
        $form_settings = ProductionFromSetting::first();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
         

        return view('backend.direct_productions.index',compact('datas','page_name','account_types','request','account_groups','current_date','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name  = $this->page_name;
        $users = Auth::user();
       
        $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
        $account_groups = [];
        $branchs = Branch::select('id','_name')->orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $voucher_types = VoucherType::select('id','_name','_code')->orderBy('_code','asc')->get();
        $store_houses = permited_stores(explode(',',$users->store_ids));
       
        $_all_store_houses = StoreHouse::select('id','_name','_branch_id')->with(['_branch'])->get();
        $form_settings = ProductionFromSetting::first();
        $inv_accounts = [];
        $p_accounts = [];
        $dis_accounts = [];
        $vat_accounts =[];
        $categories = ItemCategory::with(['_parents'])->select('id','_name','_parent_id')->orderBy('_name','asc')->get();
        $types = ['production'];
        $units = Units::select('id','_name','_code')->orderBy('_name','asc')->get();
         $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->where('_status',1)->get();

       return view('backend.direct_productions.create',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','vat_accounts','categories','units','_warranties','_all_store_houses','types'));
        
    }

    


    public function check_available_row_materials(Request $request){
     //  return $request->all();
        $_stock_in__item_ids = $request->_stock_in__item_id ?? [];
        $_stock_in_transection_units = $request->_stock_in_transection_unit ?? [];
        $_stock_inconversion_qty = $request->_stock_inconversion_qty ?? [];
        $_stock_in_main_unit_vals = $request->_stock_in_main_unit_val ?? [];
        $_stock_in__item_names = $request->_stock_in__search_item_id ?? [];
        $_stock_in__item_ids = $request->_stock_in__item_id ?? [];
        $_stock_in__qtys = $request->_stock_in__qty ?? [];
        $_store_id = $request->_store_id ?? 1;
        $organization_id = $request->organization_id ?? 1;
        $_branch_id = $request->_branch_id ?? 1;
        $_cost_center_id = $request->_cost_center_id ?? 1;



        

        $item_array_to_string=  implode(',', $_stock_in__item_ids);
        $all_raw_item_datas =[];

if(sizeof($_stock_in__item_ids) > 0){
    foreach ($_stock_in__item_ids as $key => $_f_item_id) {
        $production_qty = $_stock_in__qtys[$key] ?? 0;

        $required_item_qtys =DB::select(" SELECT t1._item_id as _main_item_id,t2._item,t3._item_id as _raw_item_id,SUM(t3._qty) as _qty,t6._name as _transection_unit_name,(SUM(t3.conversion_qty*t3._qty)*".$production_qty.") as _required_qty,t5._name as _base_unit_name,".$production_qty." as _finish_goods_qty,t3._status
            FROM musak_four_point_threes as t1 
            INNER JOIN musak_four_point_three_inputs AS t3 ON (t1.id=t3._no AND t3._status=1 AND t3._last_edition=1)
            INNER JOIN inventories as t2 ON t3._item_id=t2.id
            INNER JOIN units as t5 ON t5.id=t3._unit_id
            INNER JOIN units as t6 ON t6.id=t3._transection_unit
            WHERE t1._item_id IN(".$_f_item_id.")  GROUP BY t3._item_id ");

        $all_raw_item_datas[]=$required_item_qtys;
    }
}

$single_item_array=[];
$single_item_array_qty=[];
$only_abailable_items=[];
$abaiable_only_qtys=[];
//return $all_raw_item_datas;
foreach($all_raw_item_datas as $second_array){
    foreach($second_array as $key=>$value){
        $single_item_array[$value->_raw_item_id][]=$value;
        $single_item_array_qty[$value->_raw_item_id][]=$value->_required_qty;
        $only_abailable_items[]=$value->_raw_item_id;
    }
}

 $abailable_raw_materials = DB::table('product_price_lists')
                            ->select(DB::raw("SUM(_qty) as ab_qty,_item_id"))
                            ->where('_status',1)
                            ->whereIn('_item_id', $only_abailable_items)
                            ->where('organization_id',$organization_id)
                            ->where('_branch_id',$_branch_id)
                            ->where('_cost_center_id',$_cost_center_id)
                            ->where('_store_id',$_store_id)
                            ->groupBy(DB::raw("_item_id"))->get();




//return $abailable_raw_materials;
        


// SELECT t1._item_id as _main_item_id,t2._item,t3._item_id as _raw_item_id,t3._unit_conversion,t3._base_unit,t3._transection_unit,t3.conversion_qty,SUM(t3._qty) as _qty,t6._name as _transection_unit_name,SUM((t3.conversion_qty*t3._qty)*t7._qty) as _required_qty,t5._name as _base_unit_name,SUM(IFNULL(t8._qty,0)) as available_qty,t9._name as _p_unit,SUM(t7._qty) as _finish_goods_qty
// FROM musak_four_point_threes as t1 
// INNER JOIN musak_four_point_three_inputs AS t3 ON (t1.id=t3._no AND t3._status=1)
// INNER JOIN inventories as t2 ON t3._item_id=t2.id
// INNER JOIN units as t5 ON t5.id=t3._unit_id
// INNER JOIN units as t6 ON t6.id=t3._transection_unit
// INNER JOIN stock_ins AS t7 ON (t7._item_id=t1._item_id AND t7._status=1)
// LEFT JOIN product_price_lists as t8 ON (t8._item_id=t3._item_id AND t8._status=1)
// LEFT JOIN units as t9 ON t9.id=t8._transection_unit
// WHERE t1._item_id IN(430,428) AND t7._no=18 GROUP BY t3._item_id







return view('backend.direct_productions.check_available_row_materials',compact('request','_stock_in__item_ids','_stock_in_main_unit_vals','_stock_in__item_names','_stock_in__qtys','single_item_array','abailable_raw_materials','single_item_array_qty'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

     
       // return  dump($request->all());
         $all_req= $request->all();
         $this->validate($request, [
            '_date' => 'required',
            'organization_id' => 'required',
            '_branch_id' => 'required',
            '_store_id' => 'required',
            '_p_status' => 'required',
        ]);





          DB::beginTransaction();
         try {


            $__total = (float) $request->_total;
            $__total = (float) $request->_stock_in__total;
            $_stock_in__total = (float) $request->_stock_in__total;
            $_print_value = $request->_print ?? 0;
            $_p_status = $request->_p_status ?? 0;

            $organization_id  = $request->organization_id ?? 0;
           
            $_branch_id  = $request->_branch_id ?? 0;
            $_cost_center_id  = $request->_cost_center_id ?? 0;
            $_store_id  = $request->_store_id ?? 0;
            $_stock_inconversion_qtys = $request->_stock_inconversion_qty ?? [];
            $_ref_counters = $request->_stock_in__ref_counter ?? [];


        $_stock_in__ref_counters = $request->_stock_in__ref_counter ?? [];
        $_stock_in__item_ids= $request->_stock_in__item_id ?? [];
        $_stock_in__p_p_l_ids= $request->_stock_in__p_p_l_id ?? [];
        $_stock_in__purchase_invoice_nos= $request->_stock_in__purchase_invoice_no ?? [];
        $_stock_in__purchase_detail_ids= $request->_stock_in__purchase_detail_id ?? [];
        $_stock_in__qtys= $request->_stock_in__qty ?? [];
        $_stock_in__rates= $request->_stock_in__rate ?? [];
        $_stock_in__sales_rates= $request->_stock_in__sales_rate ?? [];
        $_stock_in__values= $request->_stock_in__value ?? [];
        $_stock_in__main_branch_id_details= $request->_stock_in__main_branch_id_detail ?? [];
        $_stock_in__main_cost_centers= $request->_stock_in__main_cost_center ?? [];
        $_stock_in__main_store_ids= $request->_stock_in__main_store_id ?? [];
        $_stock_in__manufacture_dates= $request->_stock_in__manufacture_date ?? [];
        $_stock_in__expire_dates= $request->_stock_in__expire_date ?? [];
        $_stock_in__store_salves_ids= $request->_stock_in__store_salves_id ?? [];

        $table="productions";

        $_order_number = make_order_number($table,$organization_id,$_branch_id);


           $users = Auth::user();
            $Production = new Production();
            $Production->_date = change_date_format($request->_date);
            $Production->_to_organization_id = $organization_id;
            $Production->_to_branch = $_branch_id;
            $Production->_to_cost_center = $_cost_center_id;
            $Production->_invoice_number = $_order_number;
            $Production->_order_number = $_order_number;

            $Production->_from_organization_id = $organization_id;
            $Production->_from_branch = $_branch_id;
            $Production->_from_cost_center = $_cost_center_id;
            $Production->_reference = $request->_referance;

            $Production->_type = $request->_type ?? 'production';
            $Production->_created_by = $users->id."-".$users->name;
            $Production->_note = $request->_note;
            $Production->_total = $__total;
            $Production->_stock_in__total =  $_stock_in__total;
            $Production->_p_status = $request->_p_status;
            $Production->_status = 1;
            $Production->_lock = $request->_lock ?? 0;
            $Production->save();
            $production_id = $Production->id;




            //Stock In
        if(sizeof($_stock_in__item_ids) > 0){
            for ($i = 0; $i <sizeof($_stock_in__item_ids) ; $i++) {

                $StockIn = new StockIn();
                $StockIn->_item_id = $_stock_in__item_ids[$i];
                $StockIn->_qty = $_stock_in__qtys[$i];
                //Barcode 
                $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_stock_in__item_ids[$i]] ?? '';
                $_stock_in_barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_stock_in__item_ids[$i]] ?? '';
                $StockIn->_barcode = $_stock_in_barcode_string;
                $StockIn->_manufacture_date =$_stock_in__manufacture_dates[$i] ?? null;
                $StockIn->_expire_date = $_stock_in__expire_dates[$i] ?? null;
                $StockIn->_rate = $_stock_in__rates[$i] ?? 0;

                $StockIn->_unit_conversion = $_stock_inconversion_qtys[$i] ?? 1;
                $StockIn->_transection_unit = $_stock_in_transection_units[$i] ?? 1;
                $StockIn->_base_unit = $_stock_in_base_unit_ids[$i] ?? 1;
                $StockIn->_base_rate = $_stock_in_base_rates[$i] ?? 1;


                $StockIn->_sales_rate = $_stock_in__sales_rates[$i] ?? 0;
                $StockIn->_discount = $_discounts[$i] ?? 0; //fake data
                $StockIn->_discount_amount = $_discount_amounts[$i] ?? 0; //fake data
                $StockIn->_vat = $_vats[$i] ?? 0; //fake data
                $StockIn->_vat_amount = $_vat_amounts[$i] ?? 0; //fake data
                $StockIn->_value = $_stock_in__values[$i] ?? 0;
                $StockIn->_store_id = $_store_id ?? 1;
                $StockIn->_cost_center_id = $_cost_center_id ?? 1;
                $StockIn->_store_salves_id = $_stock_in__store_salves_ids[$i] ?? '';
                $StockIn->organization_id = $organization_id;
                $StockIn->_branch_id = $_branch_id ?? 1;
                $StockIn->_no = $production_id;
                $StockIn->_status = 1;
                $StockIn->_created_by = $users->id."-".$users->name;
                $StockIn->save();
                $_stock_In_detail_id = $StockIn->id;


                if($_p_status ==3){
                    $DirProductReceive = new DirectProductionFinisGoods();
                    $DirProductReceive->_item_id = $_stock_in__item_ids[$i];
                    $DirProductReceive->_p_p_l_id = $_stock_in__p_p_l_ids[$i];
                    $DirProductReceive->_qty = $_stock_in__qtys[$i];
                    //Barcode 
                    $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_stock_in__item_ids[$i]] ?? '';
                    $_stock_in_barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_stock_in__item_ids[$i]] ?? '';
                    $DirProductReceive->_barcode = $_stock_in_barcode_string;
                    $DirProductReceive->_manufacture_date =$_stock_in__manufacture_dates[$i] ?? null;
                    $DirProductReceive->_expire_date = $_stock_in__expire_dates[$i] ?? null;
                    $DirProductReceive->_rate = $_stock_in__rates[$i] ?? 0;

                    $DirProductReceive->_unit_conversion = $_stock_inconversion_qtys[$i] ?? 1;
                    $DirProductReceive->_transection_unit = $_stock_in_transection_units[$i] ?? 1;
                    $DirProductReceive->_base_unit = $_stock_in_base_unit_ids[$i] ?? 1;
                    $DirProductReceive->_base_rate = $_stock_in_base_rates[$i] ?? 1;


                    $DirProductReceive->_sales_rate = $_stock_in__sales_rates[$i] ?? 0;
                    $DirProductReceive->_discount = $_discounts[$i] ?? 0; //fake data
                    $DirProductReceive->_discount_amount = $_discount_amounts[$i] ?? 0; //fake data
                    $DirProductReceive->_vat = $_vats[$i] ?? 0; //fake data
                    $DirProductReceive->_vat_amount = $_vat_amounts[$i] ?? 0; //fake data
                    $DirProductReceive->_value = $_stock_in__values[$i] ?? 0;
                    $DirProductReceive->_store_id = $_store_id ?? 1;
                    $DirProductReceive->_cost_center_id = $_cost_center_id ?? 1;
                    $DirProductReceive->_store_salves_id = $_stock_in__store_salves_ids[$i] ?? '';
                    $DirProductReceive->organization_id = $organization_id;
                    $DirProductReceive->_branch_id = $_branch_id ?? 1;
                    $DirProductReceive->_no = $production_id;
                    $DirProductReceive->_status = 1;
                    $DirProductReceive->_created_by = $users->id."-".$users->name;
                    $DirProductReceive->save();
                   
                }


                $item_info = Inventory::where('id',$_stock_in__item_ids[$i])->first();
                $ProductPriceList = new ProductPriceList();
                $ProductPriceList->_item_id = $_stock_in__item_ids[$i];
                $ProductPriceList->_item = $item_info->_item ?? '';

            $general_settings =GeneralSettings::select('_pur_base_model_barcode')->first();
            if($general_settings->_pur_base_model_barcode==1){
                 if($item_info->_unique_barcode ==1){
                    $ProductPriceList->_barcode =$barcode_string ?? '';
                    }else{
                        if($barcode_string !=''){
                            $ProductPriceList->_barcode = $barcode_string.$production_id;
                            $PurchaseD = StockIn::find($_stock_In_detail_id);
                            $PurchaseD->_barcode = $barcode_string.$production_id;
                            $PurchaseD->save();
                        }
                    }
            }else{
                $ProductPriceList->_barcode =$barcode_string ?? '';
            }
               
                
                $ProductPriceList->_manufacture_date =$_stock_in__manufacture_dates[$i] ?? null;
                $ProductPriceList->_expire_date = $_stock_in__expire_dates[$i] ?? null;

                // $ProductPriceList->_qty = $_stock_in__qtys[$i];
                // $ProductPriceList->_sales_rate = $_stock_in__sales_rates[$i];
                // $ProductPriceList->_pur_rate = $_stock_in__rates[$i];

                 //Unit Conversion section
                $ProductPriceList->_transection_unit = $_stock_in_transection_units[$i] ?? 1;
                $ProductPriceList->_unit_conversion = $_stock_inconversion_qtys[$i] ?? 1;
                $ProductPriceList->_base_unit = $_stock_in_base_unit_ids[$i] ?? 1;
                $ProductPriceList->_unit_id = $item_info->_unit_id ?? 1;


                if($_p_status ==3){
                    $ProductPriceList->_qty = ($_stock_in__qtys[$i] * $_stock_inconversion_qtys[$i] ?? 1);
                    $ProductPriceList->_status =1;
                }else{
                    $ProductPriceList->_status =0;
                    $ProductPriceList->_qty = 0; 
                }
                
                $ProductPriceList->_pur_rate = ($_stock_in__rates[$i] / $_stock_inconversion_qtys[$i] ?? 1);
                $ProductPriceList->_sales_rate = ($_stock_in__sales_rates[$i] / $_stock_inconversion_qtys[$i] ?? 1);

                $ProductPriceList->_unique_barcode = $item_info->_unique_barcode ?? 0;
                $ProductPriceList->_warranty = $item_info->_warranty ?? 0;
                $ProductPriceList->_input_type = $request->_type ?? 'production';
                $ProductPriceList->_sales_discount = $item_info->_discount ?? 0;
                $ProductPriceList->_p_discount_input = $_stock_in__discounts[$i] ?? 0;
                $ProductPriceList->_p_discount_amount = $_stock_in__discount_amounts[$i] ?? 0;
                $ProductPriceList->_p_vat = $_stock_in__vats[$i] ?? 0;
                $ProductPriceList->_p_vat_amount = $_stock_in__vat_amounts[$i] ?? 0;
                $ProductPriceList->_sales_vat = $item_info->_vat ?? 0;;
                $ProductPriceList->_value =$_stock_in__values[$i] ?? 0;
                $ProductPriceList->_purchase_detail_id =$_stock_In_detail_id;
                $ProductPriceList->_master_id = $production_id;
                $ProductPriceList->_store_id = $_store_id ?? 1;
                $ProductPriceList->organization_id = $organization_id;
                $ProductPriceList->_branch_id = $_branch_id ?? 1;
                $ProductPriceList->_cost_center_id = $_cost_center_id ?? 1;
                $ProductPriceList->_store_salves_id = $_stock_in__store_salves_ids[$i] ?? '';

                $ProductPriceList->_created_by = $users->id."-".$users->name;
                $ProductPriceList->save();
                $product_price_id =  $ProductPriceList->id;
                $_unique_barcode =  $ProductPriceList->_unique_barcode;


                StockIn::where('id',$_stock_In_detail_id)
                     ->update(['_p_p_l_id'=>$product_price_id]);



                 if($_unique_barcode ==1){
                     if($barcode_string !=""){
                           $barcode_array=  explode(",",$barcode_string);
                           $_qty = 1;
                           $_stat = 1;
                           $_return=0;
                           $p=0;
                           foreach ($barcode_array as $_b_v) {
                            _barcode_insert_update('BarcodeDetail',$product_price_id,$_stock_in__item_ids[$i],$production_id,$_stock_In_detail_id,$_qty,$_b_v,$_stat,$_return,$p);
                             
                           }
                        }
                 }else{
                     $_qty = $ProductPriceList->_qty ?? 0;
                       $_stat = 1;
                       $_return=0;
                       $p=0;
                       $_b_v=$ProductPriceList->_barcode ?? '';

                        _barcode_insert_update('BarcodeDetail',$product_price_id,$_stock_in__item_ids[$i],$production_id,$_stock_In_detail_id,$_qty,$_b_v,$_stat,$_return,$p);
                        
                 }

                 if($_p_status ==3){
                 
                $ItemInventory = new ItemInventory();
                $ItemInventory->_item_id =  $_stock_in__item_ids[$i];
                $ItemInventory->_item_name =  $item_info->_item ?? '';
                $ItemInventory->_unit_id =  $item_info->_unit_id ?? '';
                $ItemInventory->_category_id = _item_category($_stock_in__item_ids[$i]);
                $ItemInventory->_date = change_date_format($request->_date);
                $ItemInventory->_time = date('H:i:s');
                $ItemInventory->_transection = 'production in';
                $ItemInventory->_transection_ref = $production_id;
                $ItemInventory->_transection_detail_ref_id = $_stock_In_detail_id;


                // $ItemInventory->_qty = $_stock_in__qtys[$i];
                // $ItemInventory->_rate = $_stock_in__sales_rates[$i];
                // $ItemInventory->_unit_id = $item_info->_unit_id ?? '';
                // $ItemInventory->_cost_rate = $_stock_in__rates[$i];

                $ItemInventory->_qty = ($_stock_in__qtys[$i] * $_stock_inconversion_qtys[$i] ?? 1);
                $ItemInventory->_rate =( $_stock_in__sales_rates[$i]);
                $ItemInventory->_cost_rate = ( $_stock_in__rates[$i]/$_stock_inconversion_qtys[$i] ?? 1);
                $ItemInventory->_cost_value = ($_stock_in__qtys[$i]*$_stock_in__sales_rates[$i]);
                 //Unit Conversion section
                $ItemInventory->_transection_unit = $_stock_in_transection_units[$i] ?? 1;
                $ItemInventory->_unit_conversion = $_stock_inconversion_qtys[$i] ?? 1;
                $ItemInventory->_base_unit = $_stock_in_base_unit_ids[$i] ?? 1;
                $ItemInventory->_unit_id = $item_info->_unit_id ?? 1;


                $ItemInventory->_value = $_stock_in__values[$i] ?? 0;
                $ItemInventory->organization_id = $organization_id;
                $ItemInventory->_branch_id = $_branch_id ?? 1;
                $ItemInventory->_store_id = $_store_id ?? 1;
                $ItemInventory->_cost_center_id = $_cost_center_id ?? 1;
                $ItemInventory->_store_salves_id = $_stock_in__store_salves_ids[$i] ?? '';
                $ItemInventory->_status = 1;
                $ItemInventory->_created_by = $users->id."-".$users->name;
                $ItemInventory->save(); 
                // _inventory_last_price($_stock_in__item_ids[$i],$_stock_in__rates[$i],$_stock_in__sales_rates[$i]);

                $last_price_rate = ($_stock_in__rates[$i]/$_stock_inconversion_qtys[$i]);
                $last__sales_rates = ($_stock_in__sales_rates[$i]/$_stock_inconversion_qtys[$i]);
                _inventory_last_price($_stock_in__item_ids[$i],$last_price_rate,$last__sales_rates);

                inventory_stock_update($_stock_in__item_ids[$i]);

            }


                //Item Detail Data send to kitchen_row_goods
                 $item_ingredians = MusakFourPointThree::with(['input_detail'])->where('_item_id',$_stock_in__item_ids[$i])->first();
                    if($item_ingredians){
                        $input_detail = $item_ingredians->input_detail ?? [];
                        if(sizeof($input_detail) > 0){
                            foreach ($input_detail as $input_d) {
                                $conversion_qty = $input_d->conversion_qty ?? 1;
                                $conversion_unit_id = $input_d->_unit_id ?? 1;
                                $_transection_unit = $input_d->_transection_unit ?? 1;
                                $_base_unit = $input_d->_base_unit ?? 1;
                                $_base_rate = $input_d->_base_rate ?? 1;
                                


                                $_require_qty = (($_stock_in__qtys[$i] ?? 0)* ($input_d->_qty ?? 0));
                                $_require_value = (($_require_qty ?? 0)* ($input_d->_rate ?? 0));
                                $DirectProductionRowGoods = new DirectProductionRowGoods();
                                $DirectProductionRowGoods->_item_id  = $input_d->_item_id;
                                $DirectProductionRowGoods->_p_p_l_id  = 0;
                                $DirectProductionRowGoods->_conversion_qty  = $conversion_qty;
                                $DirectProductionRowGoods->_unit_id  = $conversion_unit_id;
                                $DirectProductionRowGoods->_base_unit  = $_base_unit;
                                $DirectProductionRowGoods->_transection_unit  = $_transection_unit;



                                $DirectProductionRowGoods->_purchase_invoice_no  = 0;
                                $DirectProductionRowGoods->_purchase_detail_id  = 0;
                                $DirectProductionRowGoods->_qty  = $_require_qty ?? 0;
                                $DirectProductionRowGoods->_base_rate  = $_base_rate ?? 0;
                                $DirectProductionRowGoods->_rate  = $input_d->_rate ?? 0;
                                $DirectProductionRowGoods->_value  = $_require_value ?? 0;
                                $DirectProductionRowGoods->_no  = $production_id;
                                $DirectProductionRowGoods->organization_id  = $organization_id ?? 1;
                                $DirectProductionRowGoods->_branch_id  = $_branch_id ?? 1;
                                $DirectProductionRowGoods->_store_id  = $_store_id ?? 1;
                                $DirectProductionRowGoods->_cost_center_id  = $_cost_center_id;
                                $DirectProductionRowGoods->_store_salves_id  = $_store_salves_ids[$i] ?? '';
                                $DirectProductionRowGoods->_status  = 1;
                                $DirectProductionRowGoods->_kitchen_item  = $item_info->_kitchen_item ?? 0;
                                $DirectProductionRowGoods->_created_by  = $users->id."-".$users->name;
                                $DirectProductionRowGoods->save();

                                
                            }// End of input Details
                        } // End of Check size of
                    } //End of ingredaints Check



            }
        }

$_kitchen_id = $production_id;

        $kitchen_row_goods = \DB::select( " SELECT t1.id,t1._item_id,t3._item,t3._unit_id,t1._p_p_l_id,t1._conversion_qty,t1._qty as t_qty,((t1._conversion_qty)*(t1._qty)) as _qty,t1._rate,t1._sales_rate,t1._discount,t1._discount_amount,t1._vat,t1._vat_amount,t1._value,t1._warranty,t1._barcode,t1._no,t1._branch_id,t1._store_id,t1._cost_center_id,t1._store_salves_id,t1._status ,t1._conversion_qty,  t1._transection_unit,  t1._base_unit,  t1._base_rate
                FROM direct_manufature_row_goods as t1
                INNER JOIN inventories AS t3 ON t3.id=t1._item_id
                WHERE t1._no=$production_id AND t1._status=1 order by t1.id ASC " );

        
  // return $kitchen_row_goods;

        foreach ($kitchen_row_goods  as $key=> $value) {
           // return $value->_item_id;
                 $_required_qty =$value->_qty ?? 0;
                 //Check Total qty for Required Item
                 $avail_total_qtys = ProductPriceList::where('_item_id',$value->_item_id)
                                                        ->where('_qty','>',0)
                                                        ->where('_store_id',$value->_store_id ?? 1)
                                                        ->where('_branch_id',$value->_branch_id ?? 1)
                                                        ->where('_cost_center_id',$value->_cost_center_id ?? 1)
                                                        ->where('_status',1)
                                                        ->sum('_qty');

                

               
                if($avail_total_qtys >= $_required_qty ){
                 //if qty is available then search product price list table
                    
                       //First Row Available Row Material Check
                       $avail_item_qtys = ProductPriceList::where('_item_id',$value->_item_id)->where('_qty','>',0)
                                                            ->where('_store_id',$value->_store_id ?? 1)
                                                            ->where('_branch_id',$value->_branch_id ?? 1)
                                                            ->where('_cost_center_id',$value->_cost_center_id ?? 1)
                                                            ->where('_status',1)
                                                            ->first();

                    //First row if meet all required qty then go this section

                    if($_required_qty <= $avail_item_qtys->_qty){
                        //First Row Found All Qty then we can go for deduct from ProductPriceList and Data Send To ItemInventory
                      //return  "required qty ".$avail_item_qtys->_qty;

                        $avail_item_qtys__qty = filter_var($avail_item_qtys->_qty, FILTER_VALIDATE_FLOAT);
                        $avail_item_qtys__qty = (float)$avail_item_qtys__qty;
                        $_required_qty = filter_var($_required_qty, FILTER_VALIDATE_FLOAT);
                        $_required_qty = (float)$_required_qty;

                         $new_qty = (($avail_item_qtys__qty)-($_required_qty ?? 0 ));
                        $_status = ($new_qty > 0) ? 1 : 0;

                        $barcode_string = $avail_item_qtys->_barcode ?? '';


                        $avail_item_qtys->_qty = $new_qty;
                        $avail_item_qtys->_status =$_status;
                        $avail_item_qtys->save();

                        $DirectProductionRowGoods = DirectProductionRowGoods::find($value->id);
                        $DirectProductionRowGoods->_p_p_l_id = $avail_item_qtys->id;
                        $DirectProductionRowGoods->save();

                        $_conversion_qty = $DirectProductionRowGoods->_conversion_qty ?? 0;
                        $_transection_unit = $DirectProductionRowGoods->_transection_unit ?? 0;
                        $_base_unit = $DirectProductionRowGoods->_base_unit ?? 0;

                        $ItemInventory = new ItemInventory();


                        $ItemInventory->_unit_conversion =  1;
                        $ItemInventory->_transection_unit =  $_base_unit  ?? 0;
                        $ItemInventory->_base_unit =  $_base_unit  ?? 0;

                        $ItemInventory->_item_id =  $value->_item_id ?? 0;
                        $ItemInventory->_item_name = $value->_item ?? 0;
                        $ItemInventory->_unit_id =  $value->_unit_id ?? 0;
                        $ItemInventory->_category_id = _item_category($value->_item_id ?? 0);
                        $ItemInventory->_date = change_date_format($request->_date ?? date('d-m-Y'));
                        $ItemInventory->_time = date('H:i:s');
                        $ItemInventory->_transection = "Production out";
                        $ItemInventory->_transection_ref = $_kitchen_id;
                        $ItemInventory->_transection_detail_ref_id = $value->id ?? 0;
                        $ItemInventory->_qty = -($_required_qty ?? 0); //Converted Qty
                        $ItemInventory->_rate =$value->_sales_rate ?? 0;
                        $ItemInventory->_cost_rate = ($value->_conversion_qty*$value->_rate ?? 0);
                        $ItemInventory->_manufacture_date = $value->_manufacture_date ?? date('d-m-Y');
                        $ItemInventory->_expire_date = $value->_expire_date ?? date('d-m-Y');
                        $ItemInventory->_cost_value = (($value->_qty ?? 0)*($value->_rate ?? 0));
                        $ItemInventory->_value = $value->_value ?? 0;
                        $ItemInventory->_branch_id = $value->_branch_id ?? 1;
                        $ItemInventory->_store_id = $value->_store_id ?? 1;
                        $ItemInventory->_cost_center_id = $value->_cost_center_id ?? 1;
                        $ItemInventory->_store_salves_id = $_store_salves_ids[$i] ?? '';
                        $ItemInventory->_status = 1;
                        $ItemInventory->_created_by = $users->id."-".$users->name;
                        $ItemInventory->save(); 
                        inventory_stock_update($value->_item_id ?? 0);






                        $StockOut = new StockOut();
                        $StockOut->_item_id = $value->_item_id ?? 0;
                        $StockOut->_qty = $_required_qty ?? 0;
                        //Barcode 
                        
                        $StockOut->_barcode = $barcode_string;
                        $StockOut->_manufacture_date =$value->_manufacture_date ?? date('d-m-Y');
                        $StockOut->_expire_date = $value->_expire_date ?? date('d-m-Y');
                        $StockOut->_rate = ($value->_conversion_qty*$value->_rate ?? 0);

                         $StockOut->_unit_conversion = 1 ;
                        $StockOut->_transection_unit = $value->_base_unit ?? 0;
                        $StockOut->_base_unit = $value->_base_unit ?? 0;
                        $StockOut->_base_rate = $value->_base_rate ?? 0 ?? 0;


                        $StockOut->_sales_rate = $avail_item_qtys->_sales_rate ?? 0;
                        $StockOut->_discount =   0;
                        $StockOut->_warranty = $avail_item_qtys->_warranty ?? 0;
                        $StockOut->_discount_amount = 0;
                        $StockOut->_vat = 0;
                        $StockOut->_vat_amount =  0;
                        $StockOut->_value = $value->_value ?? 0;
                        $StockOut->_store_id = $value->_store_id ?? 1;
                        $StockOut->_cost_center_id = $value->_cost_center_id ?? 1;
                        $StockOut->_store_salves_id = $_store_salves_ids[$i] ?? '';
                        $StockOut->organization_id = $organization_id;
                        $StockOut->_branch_id = $_branch_id ?? 1;
                        $StockOut->_no = $production_id;
                        $StockOut->_p_p_l_id = $avail_item_qtys->id;
                        $StockOut->_status = 1;
                        $StockOut->_created_by = $users->id."-".$users->name;
                        $StockOut->save();
                        $_stock_out_detail_id = $StockOut->id;

                    }else{

                    //return "Need Deduction for Multiple Row";

                     //   return "else condition ".$_required_qty;
                        $_avoid_price_list_ids =[];
                        $available_quantity =  0;
                        $_qty_less = $_required_qty;
                        do {
                           
                            if ($available_quantity < $_required_qty) {
                                 $price_info_two = ProductPriceList::where('_item_id', $value->_item_id)->where('_qty','>',0)
                                                            ->where('_store_id',$value->_store_id ?? 1)
                                                            ->where('_branch_id',$value->_branch_id ?? 1)
                                                            ->where('_cost_center_id',$value->_cost_center_id ?? 1)
                                                            ->where('_status',1)
                                                            ->whereNotIn('id', $_avoid_price_list_ids)
                                                            ->orderBy('id','asc')
                                                            ->first();
                                if($price_info_two){
                                      array_push($_avoid_price_list_ids, $price_info_two->id);

                                      $available_quantity +=$price_info_two->_qty ?? 0;


 
                                    $duduction_qty = 0;

                                      if($available_quantity  >= $_required_qty  ){
                                        $_less_qty = ($price_info_two->_qty -( $available_quantity-$_required_qty )); //Last Need this qty
                                         $new_qty = ($price_info_two->_qty-$_less_qty );
                                         $duduction_qty= $_less_qty;

                                        }else{
                                            $new_qty = 0;
                                            $duduction_qty= $price_info_two->_qty ?? 0;
                                        }

                                        //Deduction qty for Less from Product Price List

                                        

                                       
                                        $_status = ($new_qty > 0) ? 1 : 0;
                                        $price_info_two->_qty = $new_qty;
                                        $price_info_two->_status =$_status;
                                        $price_info_two->save();

                                        $DirectProductionRowGoods = DirectProductionRowGoods::find($value->id);
                                        $DirectProductionRowGoods->_p_p_l_id = $price_info_two->id;
                                        $DirectProductionRowGoods->save();

                                       $ItemInventory = new ItemInventory();
                                        $ItemInventory->_item_id =  $value->_item_id ?? 0;
                                        $ItemInventory->_item_name = $value->_item ?? 0;
                                        $ItemInventory->_unit_id =  $value->_unit_id ?? 0;
                                        $ItemInventory->_unit_conversion =  1 ;
                                        $ItemInventory->_transection_unit = $value->_base_unit ?? 0;
                                        $ItemInventory->_base_unit =  $value->_base_unit ?? 0 ;

                                        $ItemInventory->_category_id = _item_category($value->_item_id ?? 0);
                                        $ItemInventory->_date = change_date_format($request->_date ?? date('d-m-Y'));
                                        $ItemInventory->_time = date('H:i:s');
                                        $ItemInventory->_transection = "Production out";
                                        $ItemInventory->_transection_ref = $_kitchen_id;
                                        $ItemInventory->_transection_detail_ref_id = $value->id ?? 0;
                                        $ItemInventory->_qty = -($duduction_qty ?? 0);
                                        $ItemInventory->_rate =$value->_sales_rate ?? 0;
                                        $ItemInventory->_cost_rate = ($value->_conversion_qty*$value->_rate ?? 0);;
                                        $ItemInventory->_manufacture_date = $value->_manufacture_date ?? date('d-m-Y');
                                        $ItemInventory->_expire_date = $value->_expire_date ?? date('d-m-Y');
                                        $ItemInventory->_cost_value = (($value->_qty ?? 0)*($value->_rate ?? 0));
                                        $ItemInventory->_value = $value->_value ?? 0;
                                        $ItemInventory->_branch_id = $value->_branch_id ?? 1;
                                        $ItemInventory->_store_id = $value->_store_id ?? 1;
                                        $ItemInventory->_cost_center_id = $value->_cost_center_id ?? 1;
                                        $ItemInventory->_store_salves_id = $_store_salves_ids[$i] ?? '';
                                        $ItemInventory->_status = 1;
                                        $ItemInventory->_created_by = $users->id."-".$users->name;
                                        $ItemInventory->save(); 
                                        inventory_stock_update($value->_item_id ?? 0);


                                          $StockOut = new StockOut();
                                            $StockOut->_item_id = $value->_item_id ?? 0;
                                            $StockOut->_qty = $duduction_qty ?? 0; //converted Qty
                                            //Barcode 
                                            
                                            $StockOut->_barcode = $barcode_string;
                                            $StockOut->_manufacture_date =$value->_manufacture_date ?? date('d-m-Y');
                                            $StockOut->_expire_date = $value->_expire_date ?? date('d-m-Y');
                                            $StockOut->_rate = ($value->_conversion_qty*$value->_rate ?? 0);

                                             $StockOut->_unit_conversion = 1;
                                            $StockOut->_transection_unit = $value->_base_unit ?? 0;
                                            $StockOut->_base_unit = $value->_base_unit ?? 0;
                                            $StockOut->_base_rate = $value->_base_rate ?? 0 ?? 0;


                                            $StockOut->_sales_rate = $avail_item_qtys->_sales_rate ?? 0;
                                            $StockOut->_discount =   0;
                                            $StockOut->_warranty = $avail_item_qtys->_warranty ?? 0;
                                            $StockOut->_discount_amount = 0;
                                            $StockOut->_vat = 0;
                                            $StockOut->_vat_amount =  0;
                                            $StockOut->_value = $value->_value ?? 0;
                                            $StockOut->_store_id = $value->_store_id ?? 1;
                                            $StockOut->_cost_center_id = $value->_cost_center_id ?? 1;
                                            $StockOut->_store_salves_id = $_store_salves_ids[$i] ?? '';
                                            $StockOut->organization_id = $organization_id;
                                            $StockOut->_branch_id = $_branch_id ?? 1;
                                            $StockOut->_no = $production_id;
                                            $StockOut->_p_p_l_id = $avail_item_qtys->id;
                                            $StockOut->_status = 1;
                                            $StockOut->_created_by = $users->id."-".$users->name;
                                            $StockOut->save();



                                }
                                                            
                            }
                        } while ($available_quantity < $_required_qty);

                    }
                }
                
            } //Row goods deduct from Stock means Product Price List Table

            $_to_organization_id = $request->_to_organization_id ?? 1;
$_from_organization_id = $request->_from_organization_id ?? 1;

$ProductionFromSetting=ProductionFromSetting::first();
$_default_inventory = $ProductionFromSetting->_default_inventory;
$_production_account = $ProductionFromSetting->_production_account;
$_transit_account = $ProductionFromSetting->_transit_account;

$_ref_master_id=$production_id;
$_ref_detail_id=$production_id;
$_short_narration=$request->_type ?? 'N/A';
$_narration = $request->_note;
$_reference= $request->_referance;
$_transaction= $request->_type;
$_date = change_date_format($request->_date);
$_table_name = $request->_form_name;
$_from_branch = $request->_branch_id;
$_from_cost_center =  $request->_cost_center_id;

$_to_branch = $request->_branch_id;
$_to_cost_center =  $request->_cost_center_id;
$_name =$users->name;

if($_p_status ==1){
//Default Transit Account
account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_transit_account,$__total,0,$_to_branch,$_to_cost_center,$_name,1,$_to_organization_id);
//Default Inventory Account
account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_transit_account),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,0,$__total,$_from_branch,$_from_cost_center,$_name,2,$_from_organization_id);
        
}
if($_p_status ==2){
//Default Transit Account
account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_production_account,$__total,0,$_to_branch,$_to_cost_center,$_name,1,$_to_organization_id);
//Default Inventory Account
account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_production_account),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,0,$__total,$_from_branch,$_from_cost_center,$_name,2,$_from_organization_id);
        
}
if($_p_status ==3){
//Default Transit Account
account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,$__total,0,$_to_branch,$_to_cost_center,$_name,1,$_to_organization_id);
//Default Inventory Account
account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_production_account,0,$__total,$_from_branch,$_from_cost_center,$_name,2,$_from_organization_id);
        
}


       


         DB::commit();
            return redirect()->back()
            ->with('success','Information save successfully')
            ->with('_master_id',$production_id)
            ->with('_print_value',$_print_value);
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back()
           ->with('danger','There is Something Wrong !')
           ->with('request',$request->all());
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function finished_goods_receive_to_stock(Request $request)
    {
        //Check previous Receive Qty

        $id = $request->production_id ?? '';
        try {

        $production_info =  Production::where('id',$id)->where('_lock',0)->first();
         
         if(!$production_info){
            return redirect()->back()->with('danger','You have no permission to edit or update !');
         }

         $users = Auth::user();
        $request_branchs = $request->_branch_id ?? [];
        $request_cost_centers = $request->_cost_center ?? [];
        $request_organizations = $request->organization_id ?? [];
        $request_store_ids = $request->_store_id ?? [];

        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_stores = permited_stores(explode(',',$users->store_ids));
        $store_houses  = $permited_stores;
        

        $_organization_ids = filterableOrganization($request_organizations,$permited_organizations);
        $_branch_ids = filterableBranch($request_branchs,$permited_branch);
        $_cost_center_ids = filterableCostCenter($request_cost_centers,$permited_costcenters);
        $_store_ids = filterableStores($request_store_ids,$permited_stores);
        
        $_organization_id_rows = implode(',', $_organization_ids);
        $_branch_ids_rows = implode(',', $_branch_ids);
        $_cost_center_id_rows = implode(',', $_cost_center_ids);
        $_store_id_rows = implode(',', $_store_ids);

        $page_name = __('label.finished_goods_receive_to_stock');
         $form_settings = ProductionFromSetting::first();
         $units = Units::select('id','_name','_code')->orderBy('_name','asc')->get();
         $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->where('_status',1)->get();
  
      
      

         $datas = DB::select(" SELECT inv._unique_barcode, s1._item_id,s1._unit_conversion,s1._transection_unit,s1._base_unit,s1._base_rate,s1._p_p_l_id,SUM(s1._qty) as main_qty,s1._rate,s1._sales_rate,s1._value,s1._warranty,s1._barcode,s1._manufacture_date,s1._expire_date,s1.organization_id,s1._branch_id,s1._store_id,s1._cost_center_id,SUM(s1.previous_receive_qty) as previous_receive_qty

                FROM(
                SELECT t1._item_id,t1._unit_conversion,t1._transection_unit,t1._base_unit,t1._base_rate,t1._p_p_l_id,t1._qty,t1._rate,t1._sales_rate,t1._value,t1._warranty,t1._barcode,t1._manufacture_date,t1._expire_date,t1.organization_id,t1._branch_id,t1._store_id,t1._cost_center_id,0 as previous_receive_qty
                FROM  stock_ins as t1 
                WHERE 1=1 AND t1._no=".$id." AND t1._status=1 AND  t1.organization_id IN(".$_organization_id_rows.")   AND  t1._branch_id IN(".$_branch_ids_rows.") AND  t1._cost_center_id IN(".$_cost_center_id_rows.") 
                UNION ALL
                SELECT t1._item_id,t1._unit_conversion,t1._transection_unit,t1._base_unit,t1._base_rate,t1._p_p_l_id,0 as _qty,t1._rate,t1._sales_rate,t1._value,t1._warranty,t1._barcode,t1._manufacture_date,t1._expire_date,t1.organization_id,t1._branch_id,t1._store_id,t1._cost_center_id,t1._qty as previous_receive_qty 
                FROM direct_production_finis_goods as t1
    WHERE t1._no=".$id."
    ) as s1
    INNER JOIN inventories as inv ON inv.id=s1._item_id

     GROUP BY s1._item_id ");

        return view('backend.direct_productions.finished_goods_receive_to_stock',compact('page_name','datas','permited_organizations','permited_branch','permited_costcenters','permited_stores','store_houses','form_settings','_warranties','units','id','production_info'));
       } catch (\Exception $e) {
        
           return redirect()->back()
           ->with('danger','There is Something Wrong !')
           ->with('request',$request->all());
     }

        //Available Receive Qty

        
    }

   public function update(Request $request, $id)
    {
    
       // return $request->all();


        //DirectProductionFinisGoods
        //return  dump($request->all());
         $all_req= $request->all();
         $this->validate($request, [
            '_date' => 'required',
            'organization_id' => 'required',
            '_branch_id' => 'required',
            '_store_id' => 'required',
            '_p_status' => 'required',
        ]);





        DB::beginTransaction();
        try {

            $auth_user= Auth::user();

            $__total = (float) $request->_total;
            $_stock_in__total = (float) $request->_stock_in__total;
            $__total = (float) $request->_stock_in__total;
            $_print_value = $request->_print ?? 0;
            $_p_status = $request->_p_status ?? 0;

            $organization_id  = $request->organization_id ?? 0;
           
            $_branch_id  = $request->_branch_id ?? 0;
            $_cost_center_id  = $request->_cost_center_id ?? 0;
            $_store_id  = $request->_store_id ?? 0;
            $_stock_inconversion_qtys = $request->_stock_inconversion_qty ?? [];
            $_ref_counters = $request->_stock_in__ref_counter ?? [];


        $_stock_in__ref_counters = $request->_stock_in__ref_counter ?? [];
        $_stock_in__item_ids= $request->_stock_in__item_id ?? [];
        $_stock_in__p_p_l_ids= $request->_stock_in__p_p_l_id ?? [];
        $_stock_in__purchase_invoice_nos= $request->_stock_in__purchase_invoice_no ?? [];
        $_stock_in__purchase_detail_ids= $request->_stock_in__purchase_detail_id ?? [];
        $_stock_in__qtys= $request->_stock_in__qty ?? [];
        $_stock_in__rates= $request->_stock_in__rate ?? [];
        $_stock_in__sales_rates= $request->_stock_in__sales_rate ?? [];
        $_stock_in__values= $request->_stock_in__value ?? [];
        $_stock_in__main_branch_id_details= $request->_stock_in__main_branch_id_detail ?? [];
        $_stock_in__main_cost_centers= $request->_stock_in__main_cost_center ?? [];
        $_stock_in__main_store_ids= $request->_stock_in__main_store_id ?? [];
        $_stock_in__manufacture_dates= $request->_stock_in__manufacture_date ?? [];
        $_stock_in__expire_dates= $request->_stock_in__expire_date ?? [];
        $_stock_in__store_salves_ids= $request->_stock_in__store_salves_id ?? [];
        $_stock_in_old__qtys= $request->_stock_in_old__qty ?? [];

        $production_id = $request->id;

        $production_receive_id = $request->production_receive_id ?? '';

        if($production_receive_id ==''){
            $__table="production_partial_receives" ;
           $_order_number = make_order_number($__table,$organization_id,$_branch_id);
           $ProductionPartialReceive = new ProductionPartialReceive();
           $ProductionPartialReceive->_order_number =  $_order_number;
           $ProductionPartialReceive->_production_order_number =  $request->production_no;
        }else{
             $ProductionPartialReceive = ProductionPartialReceive::find($production_receive_id);
        }
        

        
        $ProductionPartialReceive->_date =  change_date_format($request->_date);
        $ProductionPartialReceive->_production_id =  $production_id;
       
        $ProductionPartialReceive->_start_date =  change_date_format($request->production_start_date);
        $ProductionPartialReceive->_end_date =  change_date_format($request->_date);
        $ProductionPartialReceive->organization_id =  $organization_id;
        $ProductionPartialReceive->_branch_id =  $_branch_id;
        $ProductionPartialReceive->_cost_center_id =  $_cost_center_id;
        $ProductionPartialReceive->_budget_id =  $_budget_id ?? 0;
        $ProductionPartialReceive->_store_id =  $_store_id ?? 0;
        $ProductionPartialReceive->_note =  $request->_note ?? '';
        $ProductionPartialReceive->_type =  $request->_type ?? '';
        $ProductionPartialReceive->_stock_in__total =  $_stock_in__total ?? 0;
        $ProductionPartialReceive->_p_status =  $_p_status ?? 0;
        $ProductionPartialReceive->_status =  $_status ?? 1;
        $ProductionPartialReceive->_lock =  $request->_lock ?? 0;
        $ProductionPartialReceive->_user_id =  $auth_user->id;
        $ProductionPartialReceive->save();

        $production_partial_receives_id = $ProductionPartialReceive->id;

        $table="productions";
        $users = Auth::user();


            
           


        $finished_goods_ids = $request->finished_goods_id ?? [];

            //Stock In
        if(sizeof($_stock_in__item_ids) > 0){
            for ($i = 0; $i <sizeof($_stock_in__item_ids) ; $i++) {
                $finished_goods_id = $finished_goods_ids[$i] ?? 0;

                if($finished_goods_id ==0){
                    $StockIn = new DirectProductionFinisGoods();
                }else{
                    $StockIn = DirectProductionFinisGoods::find($finished_goods_id);
                }

                
                $StockIn->production_partial_receives_id = $production_partial_receives_id;
                $StockIn->_item_id = $_stock_in__item_ids[$i];
                $StockIn->_p_p_l_id = $_stock_in__p_p_l_ids[$i];
                $StockIn->_qty = $_stock_in__qtys[$i];
                //Barcode 
                $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_stock_in__item_ids[$i]] ?? '';
                $_stock_in_barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_stock_in__item_ids[$i]] ?? '';
                $StockIn->_barcode = $_stock_in_barcode_string;
                $StockIn->_manufacture_date =$_stock_in__manufacture_dates[$i] ?? null;
                $StockIn->_expire_date = $_stock_in__expire_dates[$i] ?? null;
                $StockIn->_rate = $_stock_in__rates[$i] ?? 0;

                $StockIn->_unit_conversion = $_stock_inconversion_qtys[$i] ?? 1;
                $StockIn->_transection_unit = $_stock_in_transection_units[$i] ?? 1;
                $StockIn->_base_unit = $_stock_in_base_unit_ids[$i] ?? 1;
                $StockIn->_base_rate = $_stock_in_base_rates[$i] ?? 1;


                $StockIn->_sales_rate = $_stock_in__sales_rates[$i] ?? 0;
                $StockIn->_discount = $_discounts[$i] ?? 0; //fake data
                $StockIn->_discount_amount = $_discount_amounts[$i] ?? 0; //fake data
                $StockIn->_vat = $_vats[$i] ?? 0; //fake data
                $StockIn->_vat_amount = $_vat_amounts[$i] ?? 0; //fake data
                $StockIn->_value = $_stock_in__values[$i] ?? 0;
                $StockIn->_store_id = $_store_id ?? 1;
                $StockIn->_cost_center_id = $_cost_center_id ?? 1;
                $StockIn->_store_salves_id = $_stock_in__store_salves_ids[$i] ?? '';
                $StockIn->organization_id = $organization_id;
                $StockIn->_branch_id = $_branch_id ?? 1;
                $StockIn->_no = $production_id;
                $StockIn->_status = 1;
                $StockIn->_created_by = $users->id."-".$users->name;
                $StockIn->save();
                $_stock_In_detail_id = $StockIn->id;


                $item_info = Inventory::where('id',$_stock_in__item_ids[$i])->first();
                $ProductPriceList = ProductPriceList::find($_stock_in__p_p_l_ids[$i]);
                $ProductPriceList->_item_id = $_stock_in__item_ids[$i];
                $ProductPriceList->_item = $item_info->_item ?? '';

            $general_settings =GeneralSettings::select('_pur_base_model_barcode')->first();
            if($general_settings->_pur_base_model_barcode==1){
                 if($item_info->_unique_barcode ==1){
                    $ProductPriceList->_barcode =$barcode_string ?? '';
                    }else{
                        if($barcode_string !=''){
                            $ProductPriceList->_barcode = $barcode_string.$production_id;
                            $PurchaseD = DirectProductionFinisGoods::find($_stock_In_detail_id);
                            $PurchaseD->_barcode = $barcode_string.$production_id;
                            $PurchaseD->save();
                        }
                    }
            }else{
                $ProductPriceList->_barcode =$barcode_string ?? '';
            }
               
                
                $ProductPriceList->_manufacture_date =$_stock_in__manufacture_dates[$i] ?? null;
                $ProductPriceList->_expire_date = $_stock_in__expire_dates[$i] ?? null;

                // $ProductPriceList->_qty = $_stock_in__qtys[$i];
                // $ProductPriceList->_sales_rate = $_stock_in__sales_rates[$i];
                // $ProductPriceList->_pur_rate = $_stock_in__rates[$i];

                 //Unit Conversion section
                $ProductPriceList->_transection_unit = $_stock_in_transection_units[$i] ?? 1;
                $ProductPriceList->_unit_conversion = $_stock_inconversion_qtys[$i] ?? 1;
                $ProductPriceList->_base_unit = $_stock_in_base_unit_ids[$i] ?? 1;
                $ProductPriceList->_unit_id = $item_info->_unit_id ?? 1;


                if($_p_status ==3){
                    $previous_qty = $ProductPriceList->_qty ?? 0;
                    $_update_old_qty = $_stock_in_old__qtys[$i] ?? 0;

                    $new_available_qty = (($_stock_in__qtys[$i] * $_stock_inconversion_qtys[$i] ?? 1)+$previous_qty)-$_update_old_qty;



                    $ProductPriceList->_qty = $new_available_qty;
                    $ProductPriceList->_status =1;
                }else{
                    $ProductPriceList->_status =0;
                    $ProductPriceList->_qty = 0; 
                }
                
                $ProductPriceList->_pur_rate = ($_stock_in__rates[$i] / $_stock_inconversion_qtys[$i] ?? 1);
                $ProductPriceList->_sales_rate = ($_stock_in__sales_rates[$i] / $_stock_inconversion_qtys[$i] ?? 1);

                $ProductPriceList->_unique_barcode = $item_info->_unique_barcode ?? 0;
                $ProductPriceList->_warranty = $item_info->_warranty ?? 0;
                $ProductPriceList->_input_type = $request->_type ?? 'production';
                $ProductPriceList->_sales_discount = $item_info->_discount ?? 0;
                $ProductPriceList->_p_discount_input = $_stock_in__discounts[$i] ?? 0;
                $ProductPriceList->_p_discount_amount = $_stock_in__discount_amounts[$i] ?? 0;
                $ProductPriceList->_p_vat = $_stock_in__vats[$i] ?? 0;
                $ProductPriceList->_p_vat_amount = $_stock_in__vat_amounts[$i] ?? 0;
                $ProductPriceList->_sales_vat = $item_info->_vat ?? 0;;
                $ProductPriceList->_value =$_stock_in__values[$i] ?? 0;
                $ProductPriceList->_purchase_detail_id =$_stock_In_detail_id;
                $ProductPriceList->_master_id = $production_id;
                $ProductPriceList->_store_id = $_store_id ?? 1;
                $ProductPriceList->organization_id = $organization_id;
                $ProductPriceList->_branch_id = $_branch_id ?? 1;
                $ProductPriceList->_cost_center_id = $_cost_center_id ?? 1;
                $ProductPriceList->_store_salves_id = $_stock_in__store_salves_ids[$i] ?? '';

                $ProductPriceList->_created_by = $users->id."-".$users->name;
                $ProductPriceList->save();
                $product_price_id =  $ProductPriceList->id;
                $_unique_barcode =  $ProductPriceList->_unique_barcode;





                 if($_unique_barcode ==1){
                     if($barcode_string !=""){
                           $barcode_array=  explode(",",$barcode_string);
                           $_qty = 1;
                           $_stat = 1;
                           $_return=0;
                           $p=0;
                           foreach ($barcode_array as $_b_v) {
                            _barcode_insert_update('BarcodeDetail',$product_price_id,$_stock_in__item_ids[$i],$production_id,$_stock_In_detail_id,$_qty,$_b_v,$_stat,$_return,$p);
                             
                           }
                        }
                 }else{
                     $_qty = $ProductPriceList->_qty ?? 0;
                       $_stat = 1;
                       $_return=0;
                       $p=0;
                       $_b_v=$ProductPriceList->_barcode ?? '';

                        _barcode_insert_update('BarcodeDetail',$product_price_id,$_stock_in__item_ids[$i],$production_id,$_stock_In_detail_id,$_qty,$_b_v,$_stat,$_return,$p);
                        
                 }

            if($_p_status ==3){

                 $ItemInventory = ItemInventory::where('_transection',"production in")
                                    ->where('_transection_ref',$production_id)
                                    ->where('_transection_detail_ref_id',$_stock_In_detail_id)
                                    ->first();
                if(empty($ItemInventory)){
                    $ItemInventory = new ItemInventory();
                    $ItemInventory->_created_by = $auth_user->id."-".$auth_user->name;
                }    


                 
               
                $ItemInventory->_item_id =  $_stock_in__item_ids[$i];
                $ItemInventory->_item_name =  $item_info->_item ?? '';
                $ItemInventory->_unit_id =  $item_info->_unit_id ?? '';
                $ItemInventory->_category_id = _item_category($_stock_in__item_ids[$i]);
                $ItemInventory->_date = change_date_format($request->_date);
                $ItemInventory->_time = date('H:i:s');
                $ItemInventory->_transection = 'production in';
                $ItemInventory->_transection_ref = $production_id;
                $ItemInventory->_transection_detail_ref_id = $_stock_In_detail_id;


                // $ItemInventory->_qty = $_stock_in__qtys[$i];
                // $ItemInventory->_rate = $_stock_in__sales_rates[$i];
                // $ItemInventory->_unit_id = $item_info->_unit_id ?? '';
                // $ItemInventory->_cost_rate = $_stock_in__rates[$i];

                $ItemInventory->_qty = ($_stock_in__qtys[$i] * $_stock_inconversion_qtys[$i] ?? 1);
                $ItemInventory->_rate =( $_stock_in__sales_rates[$i]);
                $ItemInventory->_cost_rate = ( $_stock_in__rates[$i]/$_stock_inconversion_qtys[$i] ?? 1);
                $ItemInventory->_cost_value = ($_stock_in__qtys[$i]*$_stock_in__sales_rates[$i]);
                 //Unit Conversion section
                $ItemInventory->_transection_unit = $_stock_in_transection_units[$i] ?? 1;
                $ItemInventory->_unit_conversion = $_stock_inconversion_qtys[$i] ?? 1;
                $ItemInventory->_base_unit = $_stock_in_base_unit_ids[$i] ?? 1;
                $ItemInventory->_unit_id = $item_info->_unit_id ?? 1;


                $ItemInventory->_value = $_stock_in__values[$i] ?? 0;
                $ItemInventory->organization_id = $organization_id;
                $ItemInventory->_branch_id = $_branch_id ?? 1;
                $ItemInventory->_store_id = $_store_id ?? 1;
                $ItemInventory->_cost_center_id = $_cost_center_id ?? 1;
                $ItemInventory->_store_salves_id = $_stock_in__store_salves_ids[$i] ?? '';
                $ItemInventory->_status = 1;
                $ItemInventory->_created_by = $users->id."-".$users->name;
                $ItemInventory->save(); 
                // _inventory_last_price($_stock_in__item_ids[$i],$_stock_in__rates[$i],$_stock_in__sales_rates[$i]);

                $last_price_rate = ($_stock_in__rates[$i]/$_stock_inconversion_qtys[$i]);
                $last__sales_rates = ($_stock_in__sales_rates[$i]/$_stock_inconversion_qtys[$i]);
                _inventory_last_price($_stock_in__item_ids[$i],$last_price_rate,$last__sales_rates);

                inventory_stock_update($_stock_in__item_ids[$i]);

            }


                



            }
        }


        if($request->finished_goods_receive_status ==2){
            Production::where('id',$id)->update(['_lock'=>1,'_p_status'=>$_p_status]);
        }

$_kitchen_id = $production_id;

       

$_to_organization_id = $request->_to_organization_id ?? 1;
$_from_organization_id = $request->_from_organization_id ?? 1;

$ProductionFromSetting=ProductionFromSetting::first();
$_default_inventory = $ProductionFromSetting->_default_inventory;
$_production_account = $ProductionFromSetting->_production_account;
$_transit_account = $ProductionFromSetting->_transit_account;

$_ref_master_id=$production_id;
$_ref_detail_id=$production_id;
$_short_narration=$request->_type ?? 'N/A';
$_narration = $request->_note;
$_reference= $request->_referance;
$_transaction= $request->_type;
$_date = change_date_format($request->_date);
$_table_name = $request->_form_name;
$_from_branch = $request->_branch_id;
$_from_cost_center =  $request->_cost_center_id;

$_to_branch = $request->_branch_id;
$_to_cost_center =  $request->_cost_center_id;
$_name =$users->name;

if($_p_status ==3){
//Default Transit Account
account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,$_stock_in__total,0,$_to_branch,$_to_cost_center,$_name,8,$_to_organization_id);
//Default Inventory Account
account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_production_account,0,$__total,$_from_branch,$_from_cost_center,$_name,12,$_from_organization_id);
        
}


       


          DB::commit();
            return redirect('production')
            ->with('success','Information save successfully')
            ->with('_master_id',$production_id)
            ->with('_print_value',$_print_value);
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back()
           ->with('danger','There is Something Wrong !')
           ->with('request',$request->all());
        }

    }



    public function partialProductionReceive(Request $request){

        $page_name = __('label.partialProductionReceive');
        $unlock_productions = Production::whereNotIn('_p_status',[3])->where('_lock',0)->get();

        return view('backend.direct_productions.partial_receive_form',compact('page_name','unlock_productions'));
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function destroy(Production $production)
    {
        //
    }
}
