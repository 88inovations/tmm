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
use App\Models\DirectProductionFinisGoods;

class ProductionController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:production-list|production-create|production-edit|production-delete|production-print', ['only' => ['index','store']]);
         $this->middleware('permission:production-print', ['only' => ['purchasePrint']]);
         $this->middleware('permission:production-create', ['only' => ['create','store']]);
         $this->middleware('permission:production-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:production-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.finished_goods_fabrication');
    }
    
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

     public function reset(){
        Session::flash('_pur_limit');
       return  \Redirect::to('production?limit='.default_pagination());
    }



    public function Print($id){
         $page_name = $this->page_name;
         $data =  Production::with(['_stock_in','_stock_out'])->find($id);
        return view('backend.production.print',compact('page_name','data'));
    }

    public function PrintStockIn($id){
         $page_name = $this->page_name;
         $data =  Production::with(['_stock_in'])->find($id);
        return view('backend.production.stock_in_print',compact('page_name','data'));
    }

    public function PrintStockOut($id){
         $page_name = $this->page_name;
         $data =  Production::with(['_stock_out'])->find($id);
        return view('backend.production.stock_out_print',compact('page_name','data'));
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

       return view('backend.production.create',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','vat_accounts','categories','units','_warranties','_all_store_houses','types'));
        
    }

       public function formSettingAjax(){
        $form_settings = ProductionFromSetting::first();
        $inv_accounts = AccountLedger::where('_status',1)->get();
        
        return view('backend.production.form_setting_modal',compact('form_settings','inv_accounts'));
    }

    public function Settings (Request $request){
        $data = ProductionFromSetting::first();
        if(empty($data)){
            $data = new ProductionFromSetting();
        }

        $data->_default_inventory = $request->_default_inventory;
        $data->_production_account = $request->_production_account;
        $data->_transit_account = $request->_transit_account;
        $data->_show_barcode = $request->_show_barcode;
        $data->_show_store = $request->_show_store;
        $data->_show_self = $request->_show_self;
        $data->_show_cost_rate = $request->_show_cost_rate ?? 1;
        $data->_show_unit = $request->_show_unit ?? 1;
        $data->_show_manufacture_date = $request->_show_manufacture_date ?? 1;
        $data->_show_expire_date = $request->_show_expire_date ?? 1;
        $data->_invoice_template = $request->_invoice_template ?? 1;
        $data->_show_warranty =$request->_show_warranty ?? 0;
        $data->save();


        return redirect()->back();
                       

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

     
        //return  dump($request->all());
         $all_req= $request->all();
         $this->validate($request, [
            '_date' => 'required',
            '_from_branch' => 'required',
            '_to_branch' => 'required',
            '_form_name' => 'required',
            '_p_status' => 'required',
        ]);

          DB::beginTransaction();
         try {

            $__total = (float) $request->_total;
            $_stock_in__total = (float) $request->_stock_in__total;
            $_print_value = $request->_print ?? 0;
            $_p_status = $request->_p_status ?? 0;

            $_item_ids = $request->_item_id ?? [];
            $_p_p_l_ids = $request->_p_p_l_id ?? [];
            $_purchase_invoice_nos = $request->_purchase_invoice_no ?? [];
            $_purchase_detail_ids = $request->_purchase_detail_id ?? [];
            $_warrantys = $request->_warranty ?? [];
            $_qtys = $request->_qty ?? [];
            $_rates = $request->_rate ?? [];
            $_sales_rates = $request->_sales_rate ?? [];
            $_values = $request->_value ?? [];
            $_manufacture_dates = $request->_manufacture_date ?? [];
            $_expire_dates = $request->_expire_date ?? [];
            $_main_branch_id_details = $request->_main_branch_id_detail ?? [];
            $_main_cost_centers = $request->_main_cost_center ?? [];
            $_main_store_ids = $request->_main_store_id ?? [];
            $_store_salves_ids = $request->_store_salves_id ?? [];
            $_ref_counters = $request->_ref_counter;

            $_base_unit_ids =$request->_base_unit_id ?? [];
            $_main_unit_vals =$request->_main_unit_val ?? [];
            $conversion_qtys =$request->conversion_qty ?? [];
            $_base_rates =$request->_base_rate ?? [];
            $_transection_units =$request->_transection_unit ?? [];

            $_stock_in_base_unit_ids =$request->_stock_in_base_unit_id ?? [];
            $_stock_in_main_unit_vals =$request->_stock_in_main_unit_val ?? [];
            $_stock_inconversion_qtys =$request->_stock_inconversion_qty ?? [];
            $_stock_in_base_rates =$request->_stock_in_base_rate ?? [];
            $_stock_in_transection_units =$request->_stock_in_transection_unit ?? [];

            $_from_organization_id = $request->_from_organization_id;
            $_from_branch = $request->_from_branch;


            $table="productions";

           $_order_number = make_order_number($table,$_from_organization_id,$_from_branch);


            $users = Auth::user();
            $Production = new Production();
            $Production->_date = change_date_format($request->_date);
            $Production->_from_cost_center = $request->_from_cost_center;
            $Production->_to_organization_id = $request->_to_organization_id;
            $Production->_from_organization_id = $request->_from_organization_id;
            $Production->_invoice_number = $_order_number;
            $Production->_order_number = $_order_number;
            $Production->_from_branch = $request->_from_branch;
            $Production->_to_branch = $request->_to_branch;
            $Production->_to_cost_center = $request->_to_cost_center;
            $Production->_reference = $request->_referance;
            $Production->_type = $request->_type;
            $Production->_created_by = $users->id."-".$users->name;
            $Production->_note = $request->_note;
            $Production->_total = $__total;
            $Production->_stock_in__total =  $_stock_in__total;
            $Production->_p_status = $request->_p_status;
            $Production->_status = 1;
            $Production->_lock = $request->_lock ?? 0;
            $Production->save();
            $production_id = $Production->id;

            //Stock out Start

            if(sizeof($_item_ids) > 0){
            for ($i = 0; $i <sizeof($_item_ids) ; $i++) {
                $StockOut = new StockOut();
                $StockOut->_item_id = $_item_ids[$i];
                $StockOut->_qty = $_qtys[$i];
                //Barcode 
                $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_item_ids[$i]] ?? '';
                $StockOut->_barcode = $barcode_string;
                $StockOut->_manufacture_date =$_manufacture_dates[$i] ?? null;
                $StockOut->_expire_date = $_expire_dates[$i] ?? null;
                $StockOut->_rate = $_rates[$i] ?? 0;

                 $StockOut->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $StockOut->_transection_unit = $_transection_units[$i] ?? 1;
                $StockOut->_base_unit = $_base_unit_ids[$i] ?? 1;
                $StockOut->_base_rate = $_base_rates[$i] ?? 0;


                $StockOut->_sales_rate = $_sales_rates[$i] ?? 0;
                $StockOut->_discount = $_discounts[$i] ?? 0;
                $StockOut->_warranty = $_warrantys[$i] ?? 0;
                $StockOut->_discount_amount = $_discount_amounts[$i] ?? 0;
                $StockOut->_vat = $_vats[$i] ?? 0;
                $StockOut->_vat_amount = $_vat_amounts[$i] ?? 0;
                $StockOut->_value = $_values[$i] ?? 0;
                $StockOut->_store_id = $_main_store_ids[$i] ?? 1;
                $StockOut->_cost_center_id = $_main_cost_centers[$i] ?? 1;
                $StockOut->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $StockOut->organization_id = $request->_from_organization_id;
                $StockOut->_branch_id = $_main_branch_id_details[$i] ?? 1;
                $StockOut->_no = $production_id;
                $StockOut->_p_p_l_id = $_p_p_l_ids[$i];
                $StockOut->_status = 1;
                $StockOut->_created_by = $users->id."-".$users->name;
                $StockOut->save();
                $_stock_out_detail_id = $StockOut->id;

                 $item_info = Inventory::where('id',$_item_ids[$i])->first();
                $ProductPriceList = ProductPriceList::find($_p_p_l_ids[$i]);
                $_p_qty = $ProductPriceList->_qty;
                $_unique_barcode = $ProductPriceList->_unique_barcode;
                //Barcode  deduction from old string data
                if($_unique_barcode ==1){
                     $_old_barcode_strings =  $ProductPriceList->_barcode;
                        $_new_barcode_array = array();
                        if($_old_barcode_strings !=""){
                            $_old_barcode_array = explode(",",$_old_barcode_strings);
                        }
                        if($barcode_string !=""){
                            $_new_barcode_array = explode(",",$barcode_string);
                        }
                        if(sizeof($_new_barcode_array) > 0 && sizeof($_old_barcode_array) > 0){
                          $_last_barcode_array =  array_diff($_old_barcode_array,$_new_barcode_array);
                          if(sizeof($_last_barcode_array ) > 0){
                            $_last_barcode_string = implode(",",$_last_barcode_array);
                          }else{
                            $_last_barcode_string = $barcode_string;
                          }
                          
                          $ProductPriceList->_barcode = $_last_barcode_string;
                        }
                }else{
                  $ProductPriceList->_barcode = $barcode_string;
                }
                //Barcode  deduction from old string data
                // $_status = (($_p_qty - $_qtys[$i]) > 0) ? 1 : 0;
                // $ProductPriceList->_qty = ($_p_qty - $_qtys[$i]);
                // $ProductPriceList->_status = $_status;
                // $ProductPriceList->save();

                $_status = (($_p_qty - ($_qtys[$i]* $conversion_qtys[$i] ?? 1)) > 0) ? 1 : 0;
                $ProductPriceList->_qty = ($_p_qty - ($_qtys[$i]* $conversion_qtys[$i] ?? 1));
                $ProductPriceList->_status = $_status;
                $ProductPriceList->save();

            $product_price_id =  $ProductPriceList->id;
             if($_unique_barcode ==1){
                  if($barcode_string !=""){
                       $barcode_array=  explode(",",$barcode_string);
                       $_qty = 1;
                       $_stat = 1;
                       $_return=1;
                       foreach ($barcode_array as $_b_v) {
                        _barcode_insert_update('BarcodeDetail', $product_price_id,$_item_ids[$i],$production_id,$_stock_out_detail_id,$_qty,$_b_v,$_stat,1,1);
                         
                       }
                    }
             }


               $ItemInventory = new ItemInventory();
                $ItemInventory->_item_id =  $_item_ids[$i];
                $ItemInventory->_item_name =  $item_info->_item ?? '';
                 $ItemInventory->_unit_id =  $item_info->_unit_id ?? '';
                $ItemInventory->_category_id = _item_category($_item_ids[$i]);
                $ItemInventory->_date = change_date_format($request->_date);
                $ItemInventory->_time = date('H:i:s');
                $ItemInventory->_transection = 'Production out';
                $ItemInventory->_transection_ref = $production_id;
                $ItemInventory->_transection_detail_ref_id = $_stock_out_detail_id;
                  //Unit Conversion section
                $ItemInventory->_transection_unit = $_transection_units[$i] ?? 1;
                $ItemInventory->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $ItemInventory->_base_unit = $item_info->_unit_id ?? 1;
                $ItemInventory->_unit_id = $item_info->_unit_id ?? 1;

                // $ItemInventory->_qty = -($_qtys[$i]);
                // $ItemInventory->_rate = $_sales_rates[$i] ?? 0;
                // $ItemInventory->_cost_rate = $_rates[$i] ?? 0;
                // $ItemInventory->_cost_value = ($_qtys[$i]*$_rates[$i]);

                $ItemInventory->_qty = -($_qtys[$i] * $conversion_qtys[$i] ?? 1);
                $ItemInventory->_rate =( $_sales_rates[$i]/$conversion_qtys[$i] ?? 1);
                $ItemInventory->_cost_rate = ( $_rates[$i]/$conversion_qtys[$i] ?? 1);
                $ItemInventory->_cost_value = (($_qtys[$i]*$conversion_qtys[$i] ?? 1)*$_rates[$i]);





                $ItemInventory->_manufacture_date = $_manufacture_dates[$i] ?? null;
                $ItemInventory->_expire_date = $_expire_dates[$i] ?? null;
                $ItemInventory->_value = $_values[$i] ?? 0;
                $ItemInventory->organization_id = $request->_from_organization_id;
                $ItemInventory->_branch_id = $_main_branch_id_details[$i] ?? 1;
                $ItemInventory->_store_id = $_main_store_ids[$i] ?? 1;
                $ItemInventory->_cost_center_id = $_main_cost_centers[$i] ?? 1;
                $ItemInventory->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $ItemInventory->_status = 1;
                $ItemInventory->_created_by = $users->id."-".$users->name;
                $ItemInventory->save(); 
                inventory_stock_update($_item_ids[$i]);


            }
        }
        //Stock Out End
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


        //Stock In
        if(sizeof($_stock_in__item_ids) > 0){
            for ($i = 0; $i <sizeof($_stock_in__item_ids) ; $i++) {

                $StockIn = new StockIn();
                $StockIn->_item_id = $_stock_in__item_ids[$i];
                $StockIn->_qty = $_stock_in__qtys[$i];
                //Barcode 
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
                $StockIn->_store_id = $_stock_in__main_store_ids[$i] ?? 1;
                $StockIn->_cost_center_id = $_stock_in__main_cost_centers[$i] ?? 1;
                $StockIn->_store_salves_id = $_stock_in__store_salves_ids[$i] ?? '';
                $StockIn->organization_id = $request->_to_organization_id;
                $StockIn->_branch_id = $_stock_in__main_branch_id_details[$i] ?? 1;
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
                $ProductPriceList->_table_name       =  'productions';

                $ProductPriceList->_qty = ($_stock_in__qtys[$i] * $_stock_inconversion_qtys[$i] ?? 1);
                $ProductPriceList->_pur_rate = ($_stock_in__rates[$i] / $_stock_inconversion_qtys[$i] ?? 1);
                $ProductPriceList->_sales_rate = ($_stock_in__sales_rates[$i] / $_stock_inconversion_qtys[$i] ?? 1);

                $ProductPriceList->_unique_barcode = $item_info->_unique_barcode ?? 0;
                $ProductPriceList->_warranty = $item_info->_warranty ?? 0;
                $ProductPriceList->_input_type = $request->_type ?? 'purchase';
                $ProductPriceList->_sales_discount = $item_info->_discount ?? 0;
                $ProductPriceList->_p_discount_input = $_stock_in__discounts[$i] ?? 0;
                $ProductPriceList->_p_discount_amount = $_stock_in__discount_amounts[$i] ?? 0;
                $ProductPriceList->_p_vat = $_stock_in__vats[$i] ?? 0;
                $ProductPriceList->_p_vat_amount = $_stock_in__vat_amounts[$i] ?? 0;
                $ProductPriceList->_sales_vat = $item_info->_vat ?? 0;;
                $ProductPriceList->_value =$_stock_in__values[$i] ?? 0;
                $ProductPriceList->_purchase_detail_id =$_stock_In_detail_id;
                $ProductPriceList->_master_id = $production_id;
                $ProductPriceList->_store_id = $_stock_in__main_store_ids[$i] ?? 1;
                $ProductPriceList->organization_id = $request->_to_organization_id;
                $ProductPriceList->_branch_id = $_stock_in__main_branch_id_details[$i] ?? 1;
                $ProductPriceList->_cost_center_id = $_stock_in__main_cost_centers[$i] ?? 1;
                $ProductPriceList->_store_salves_id = $_stock_in__store_salves_ids[$i] ?? '';
                 if($_p_status ==3){
                    $ProductPriceList->_status =1;
                }else{
                    $ProductPriceList->_status =0; 
                }
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
                 }


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
                $ItemInventory->organization_id = $request->_to_organization_id;
                $ItemInventory->_branch_id = $_stock_in__main_branch_id_details[$i] ?? 1;
                $ItemInventory->_store_id = $_stock_in__main_store_ids[$i] ?? 1;
                $ItemInventory->_cost_center_id = $_stock_in__main_cost_centers[$i] ?? 1;
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
$_from_branch = $request->_from_branch;
$_from_cost_center =  $request->_from_cost_center;

$_to_branch = $request->_to_branch;
$_to_cost_center =  $request->_to_cost_center;
$_name =$users->name;

if($_p_status ==1){
//Default Transit Account
account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_transit_account,$_stock_in__total,0,$_to_branch,$_to_cost_center,$_name,1,$_to_organization_id,1);
//Default Inventory Account
account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_transit_account),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,0,$__total,$_from_branch,$_from_cost_center,$_name,2,$_from_organization_id,1);
        
}
if($_p_status ==2){
//Default Transit Account
account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_production_account,$_stock_in__total,0,$_to_branch,$_to_cost_center,$_name,1,$_to_organization_id,2);
//Default Inventory Account
account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_production_account),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,0,$__total,$_from_branch,$_from_cost_center,$_name,2,$_from_organization_id,2);
        
}
if($_p_status ==3){
//Default Transit Account
account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,$_stock_in__total,0,$_to_branch,$_to_cost_center,$_name,1,$_to_organization_id,3);
//Default Inventory Account
account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,0,$__total,$_from_branch,$_from_cost_center,$_name,2,$_from_organization_id,3);
        
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
           ->whit('request',$request->all());
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function show(Production $production)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
    {

        $data =  Production::where('_lock',0)->find($id);
         
         if(!$data){
            return redirect()->back()->with('danger','You have no permission to edit or update !');
         }

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
        $units = Units::select('id','_name','_code')->orderBy('_name','asc')->get();
         $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->where('_status',1)->get();
         $data =  Production::with(['_stock_in','_stock_out'])->find($id);

       return view('backend.production.edit',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','vat_accounts','categories','units','_warranties','_all_store_houses','data'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //return $request->all();
         $all_req= $request->all();
         $this->validate($request, [
            '_date' => 'required',
            '_from_branch' => 'required',
            '_to_branch' => 'required',
            '_form_name' => 'required',
            '_p_status' => 'required',
            'id' => 'required',
        ]);




            $__total = (float) $request->_total;
            $_stock_in__total = (float) $request->_stock_in__total;
            $_print_value = $request->_print ?? 0;
            $_p_status = $request->_p_status ?? 0;

            $_item_ids = $request->_item_id ?? [];
            $_p_p_l_ids = $request->_p_p_l_id ?? [];
            $_purchase_invoice_nos = $request->_purchase_invoice_no ?? [];
            $_purchase_detail_ids = $request->_purchase_detail_id ?? []; //Stock out table row id
            $_warrantys = $request->_warranty ?? [];
            $_qtys = $request->_qty ?? [];
            $_rates = $request->_rate ?? [];
            $_sales_rates = $request->_sales_rate ?? [];
            $_values = $request->_value ?? [];
            $_manufacture_dates = $request->_manufacture_date ?? [];
            $_expire_dates = $request->_expire_date ?? [];
            $_main_branch_id_details = $request->_main_branch_id_detail ?? [];
            $_main_cost_centers = $request->_main_cost_center ?? [];
            $_main_store_ids = $request->_main_store_id ?? [];
            $_store_salves_ids = $request->_store_salves_id ?? [];
            $_ref_counters = $request->_ref_counter;



            $_main_id = $request->id;


            //If Partial Production Receive Start then you can not change this information 
             $production_partial_receives = DB::table("production_partial_receives")
                                                    ->where('_production_id',$_main_id)
                                                    ->first();

        if($production_partial_receives){
            return redirect()->back()->with('error','Can not change this Information');
        }





            $_base_unit_ids =$request->_base_unit_id ?? [];
            $_main_unit_vals =$request->_main_unit_val ?? [];
            $conversion_qtys =$request->conversion_qty ?? [];
            $_base_rates =$request->_base_rate ?? [];
            $_transection_units =$request->_transection_unit ?? [];

            $_stock_in_base_unit_ids =$request->_stock_in_base_unit_id ?? [];
            $_stock_in_main_unit_vals =$request->_stock_in_main_unit_val ?? [];
            $_stock_inconversion_qtys =$request->_stock_inconversion_qty ?? [];
            $_stock_in_base_rates =$request->_stock_in_base_rate ?? [];
            $_stock_in_transection_units =$request->_stock_in_transection_unit ?? [];


            $_to_organization_id = $request->_to_organization_id ?? 1;
            $organization_id = $request->_to_organization_id ?? 1;
            $_from_organization_id = $request->_from_organization_id ?? 1;
            $_branch_id = $request->_from_branch ?? 1;




        $previous_sales_details = StockOut::where('_no',$_main_id)->where('_status',1)->get();    
        foreach ($previous_sales_details as $value) {

            $product_prices =ProductPriceList::where('id',$value->_p_p_l_id)->first();
             $new_qty = (($value->_qty*$value->_unit_conversion)+$product_prices->_qty);
             $_unique_barcode = $product_prices->_unique_barcode;
             $_up_status = (($new_qty) > 0) ? 1 : 0;
             if($_unique_barcode ==1){
                $_old_new_barcode = $value->_barcode.",".$product_prices->_barcode;
                if($_old_new_barcode !=""){
                    $_unique_old_newbarcode_array =   explode(",",$_old_new_barcode);
                    foreach ($_unique_old_newbarcode_array as $_arraY_val) {
                      $_unique_old_newbarcode_array[]=trim($_arraY_val);
                    }
                    $_unique_old_newbarcode_array = array_unique($_unique_old_newbarcode_array);
                     $_last_barcode_string = implode(",",$_unique_old_newbarcode_array);
                     $product_prices->_barcode =$_last_barcode_string;
                    if(sizeof($_unique_old_newbarcode_array) > 0){
                        foreach ($_unique_old_newbarcode_array as $_bar_value) {
                                BarcodeDetail::where('_p_p_id',$product_prices->id)
                                            ->where('_item_id',$product_prices->_item_id)
                                            ->where('_barcode',$_bar_value)
                                            ->update(['_qty'=>1,'_status'=>1]);
                            }
                    }
                }
                
             }
             $product_prices->_qty = $new_qty;
             
             $product_prices->save();

        }


        



//Stock In items qty readjustment before update

    //if($no_finished_goods_receive ==0){

        $previous_sales_details = StockIn::where('_no',$_main_id)->where('_status',1)->get();    
        foreach ($previous_sales_details as $value) {

            $product_prices =ProductPriceList::where('id',$value->_p_p_l_id)->first();
             $new_qty = (($value->_qty*$value->_unit_conversion)-$product_prices->_qty);
             $_unique_barcode = $product_prices->_unique_barcode;
             $_up_status = (($new_qty) > 0) ? 1 : 0;
             if($_unique_barcode ==1){
                $_old_new_barcode = $value->_barcode.",".$product_prices->_barcode;
                if($_old_new_barcode !=""){
                    $_unique_old_newbarcode_array =   explode(",",$_old_new_barcode);
                    foreach ($_unique_old_newbarcode_array as $_arraY_val) {
                      $_unique_old_newbarcode_array[]=trim($_arraY_val);
                    }
                    $_unique_old_newbarcode_array = array_unique($_unique_old_newbarcode_array);
                     $_last_barcode_string = implode(",",$_unique_old_newbarcode_array);
                     $product_prices->_barcode =$_last_barcode_string;
                    if(sizeof($_unique_old_newbarcode_array) > 0){
                        foreach ($_unique_old_newbarcode_array as $_bar_value) {
                                BarcodeDetail::where('_p_p_id',$product_prices->id)
                                            ->where('_item_id',$product_prices->_item_id)
                                            ->where('_barcode',$_bar_value)
                                            ->update(['_qty'=>0,'_status'=>0]);
                            }
                    }
                }
                
             }
             $product_prices->_qty = $new_qty;
             
             $product_prices->save();

        }
    //}//End of check partial finish goods receive


        
        

        
          StockOut::where('_no', $_main_id)
            ->update(['_status'=>0]);



          StockIn::where('_no', $_main_id)
            ->update(['_status'=>0]);

          DirectProductionFinisGoods::where('_no', $_main_id)
            ->update(['_status'=>0]);

            Accounts::where('_ref_master_id',$_main_id)
                    ->where('_table_name',$request->_form_name)
                     ->update(['_status'=>0]);  

         DB::beginTransaction();
        try {



            $users = Auth::user();
            $Production = Production::find($_main_id);
            $Production->_date = change_date_format($request->_date);
            $Production->_from_cost_center = $request->_from_cost_center;
            $Production->_from_branch = $request->_from_branch;
            $Production->_to_organization_id = $_to_organization_id;
            $Production->_from_organization_id = $_from_organization_id;
            $Production->_to_branch = $request->_to_branch;
            $Production->_to_cost_center = $request->_to_cost_center;
            $Production->_reference = $request->_referance;
            $Production->_type = $request->_type;
            $Production->_created_by = $users->id."-".$users->name;
            $Production->_note = $request->_note;
            $Production->_total = $__total;
            $Production->_stock_in__total =  $_stock_in__total;
            $Production->_p_status = $request->_p_status;
            $Production->_status = 1;
            $Production->_lock = $request->_lock ?? 0;
            $Production->save();
            $production_id = $Production->id;


            

            //Stock out Start

            if(sizeof($_item_ids) > 0){
            for ($i = 0; $i <sizeof($_item_ids) ; $i++) {
              if($_purchase_detail_ids[$i]  !==""){
                  $StockOut = StockOut::find($_purchase_detail_ids[$i]);
              }else{
                $StockOut = new StockOut();
              }
                
                $StockOut->_item_id = $_item_ids[$i];
                $StockOut->_qty = $_qtys[$i];

                 $StockOut->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $StockOut->_transection_unit = $_transection_units[$i] ?? 1;
                $StockOut->_base_unit = $_base_unit_ids[$i] ?? 1;
                $StockOut->_base_rate = $_base_rates[$i] ?? 0;


                //Barcode 
                $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_item_ids[$i]] ?? '';
                $StockOut->_barcode = $barcode_string;
                $StockOut->_manufacture_date =$_manufacture_dates[$i] ?? null;
                $StockOut->_expire_date = $_expire_dates[$i] ?? null;
                $StockOut->_rate = $_rates[$i] ?? 0;
                $StockOut->_sales_rate = $_sales_rates[$i] ?? 0;
                $StockOut->_discount = $_discounts[$i] ?? 0;
                $StockOut->_warranty = $_warrantys[$i] ?? 0;
                $StockOut->_discount_amount = $_discount_amounts[$i] ?? 0;
                $StockOut->_vat = $_vats[$i] ?? 0;
                $StockOut->_vat_amount = $_vat_amounts[$i] ?? 0;
                $StockOut->_value = $_values[$i] ?? 0;
                $StockOut->_store_id = $_main_store_ids[$i] ?? 1;
                $StockOut->_cost_center_id = $_main_cost_centers[$i] ?? 1;
                $StockOut->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $StockOut->organization_id = $_from_organization_id;
                $StockOut->_branch_id = $_main_branch_id_details[$i] ?? 1;
                $StockOut->_no = $production_id;
                $StockOut->_p_p_l_id = $_p_p_l_ids[$i];
                $StockOut->_status = 1;
                $StockOut->_created_by = $users->id."-".$users->name;
                $StockOut->save();
                $_stock_out_detail_id = $StockOut->id;

                 $item_info = Inventory::where('id',$_item_ids[$i])->first();
                $ProductPriceList = ProductPriceList::find($_p_p_l_ids[$i]);
                $_p_qty = $ProductPriceList->_qty;
                $_unique_barcode = $ProductPriceList->_unique_barcode;
                //Barcode  deduction from old string data
                if($_unique_barcode ==1){
                     $_old_barcode_strings =  $ProductPriceList->_barcode;
                        $_new_barcode_array = array();
                        if($_old_barcode_strings !=""){
                            $_old_barcode_array = explode(",",$_old_barcode_strings);
                        }
                        if($barcode_string !=""){
                            $_new_barcode_array = explode(",",$barcode_string);
                        }
                        if(sizeof($_new_barcode_array) > 0 && sizeof($_old_barcode_array) > 0){
                          $_last_barcode_array =  array_diff($_old_barcode_array,$_new_barcode_array);
                          if(sizeof($_last_barcode_array ) > 0){
                            $_last_barcode_string = implode(",",$_last_barcode_array);
                          }else{
                            $_last_barcode_string = $barcode_string;
                          }
                          
                          $ProductPriceList->_barcode = $_last_barcode_string;
                        }
                }else{
                  $ProductPriceList->_barcode = $barcode_string;
                }
                //Barcode  deduction from old string data
                // $_status = (($_p_qty - $_qtys[$i]) > 0) ? 1 : 0;
                // $ProductPriceList->_qty = ($_p_qty - $_qtys[$i]);
                // $ProductPriceList->_status = $_status;
                // $ProductPriceList->save();

                $_status = (($_p_qty - ($_qtys[$i]* $conversion_qtys[$i] ?? 1)) > 0) ? 1 : 0;
                $ProductPriceList->_qty = ($_p_qty - ($_qtys[$i]* $conversion_qtys[$i] ?? 1));
                $ProductPriceList->_status = $_status;
                $ProductPriceList->save();


            $product_price_id =  $ProductPriceList->id;
             if($_unique_barcode ==1){
                  if($barcode_string !=""){
                       $barcode_array=  explode(",",$barcode_string);
                       $_qty = 1;
                       $_stat = 1;
                       $_return=1;
                       foreach ($barcode_array as $_b_v) {
                        _barcode_insert_update('BarcodeDetail', $product_price_id,$_item_ids[$i],$production_id,$_stock_out_detail_id,$_qty,$_b_v,$_stat,1,1);
                         
                       }
                    }
             }


                 $ItemInventory = ItemInventory::where('_transection','Production out')
                                    ->where('_transection_ref',$_main_id)
                                    ->where('_transection_detail_ref_id',$_stock_out_detail_id)
                                    ->first();
                if(empty($ItemInventory)){
                    $ItemInventory = new ItemInventory();
                    $ItemInventory->_created_by = $users->id."-".$users->name;
                }
                $ItemInventory->_item_id =  $_item_ids[$i];
                $ItemInventory->_item_name =  $item_info->_item ?? '';
                 $ItemInventory->_unit_id =  $item_info->_unit_id ?? '';
                $ItemInventory->_category_id = _item_category($_item_ids[$i]);
                $ItemInventory->_date = change_date_format($request->_date);
                $ItemInventory->_time = date('H:i:s');
                $ItemInventory->_transection = 'Production out';
                $ItemInventory->_transection_ref = $production_id;
                $ItemInventory->_transection_detail_ref_id = $_stock_out_detail_id;

                // $ItemInventory->_qty = -($_qtys[$i]);
                // $ItemInventory->_rate = $_sales_rates[$i] ?? 0;
                // $ItemInventory->_cost_rate = $_rates[$i] ?? 0;

               $ItemInventory->_qty = -($_qtys[$i] * $conversion_qtys[$i] ?? 1);
                $ItemInventory->_rate =( $_sales_rates[$i]/$conversion_qtys[$i] ?? 1);
                $ItemInventory->_cost_rate = ( $_rates[$i]/$conversion_qtys[$i] ?? 1);
                $ItemInventory->_cost_value = (($_qtys[$i]*$conversion_qtys[$i] ?? 1)*$_rates[$i]);

                   //Unit Conversion section
                $ItemInventory->_transection_unit = $_transection_units[$i] ?? 1;
                $ItemInventory->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $ItemInventory->_base_unit = $item_info->_unit_id ?? 1;
                $ItemInventory->_unit_id = $item_info->_unit_id ?? 1;


                $ItemInventory->_manufacture_date = $_manufacture_dates[$i] ?? null;
                $ItemInventory->_expire_date = $_expire_dates[$i] ?? null;
                $ItemInventory->_value = $_values[$i] ?? 0;
                $ItemInventory->organization_id = $_from_organization_id;
                $ItemInventory->_branch_id = $_main_branch_id_details[$i] ?? 1;
                $ItemInventory->_store_id = $_main_store_ids[$i] ?? 1;
                $ItemInventory->_cost_center_id = $_main_cost_centers[$i] ?? 1;
                $ItemInventory->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $ItemInventory->_status = 1;
                $ItemInventory->_created_by = $users->id."-".$users->name;
                $ItemInventory->save(); 
                inventory_stock_update($_item_ids[$i]);


            }
        }
        //Stock Out End
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


        //Stock In
        if(sizeof($_stock_in__item_ids) > 0){
            for ($i = 0; $i <sizeof($_stock_in__item_ids) ; $i++) {
                if($_stock_in__purchase_detail_ids[$i] !=""){
                  $StockIn =  StockIn::find($_stock_in__purchase_detail_ids[$i]);
                }else{
                  $StockIn = new StockIn();
                }
                
                $StockIn->_item_id = $_stock_in__item_ids[$i];
                $StockIn->_qty = $_stock_in__qtys[$i];

                 $StockIn->_unit_conversion = $_stock_inconversion_qtys[$i] ?? 1;
                $StockIn->_transection_unit = $_stock_in_transection_units[$i] ?? 1;
                $StockIn->_base_unit = $_stock_in_base_unit_ids[$i] ?? 1;
                $StockIn->_base_rate = $_stock_in_base_rates[$i] ?? 1;
                //Barcode 
                $_stock_in_barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_stock_in__item_ids[$i]] ?? '';
                $StockIn->_barcode = $_stock_in_barcode_string;
                $StockIn->_manufacture_date =$_stock_in__manufacture_dates[$i] ?? null;
                $StockIn->_expire_date = $_stock_in__expire_dates[$i] ?? null;
                $StockIn->_rate = $_stock_in__rates[$i] ?? 0;
                $StockIn->_sales_rate = $_stock_in__sales_rates[$i] ?? 0;
                $StockIn->_discount = $_discounts[$i] ?? 0; //fake data
                $StockIn->_discount_amount = $_discount_amounts[$i] ?? 0; //fake data
                $StockIn->_vat = $_vats[$i] ?? 0; //fake data
                $StockIn->_vat_amount = $_vat_amounts[$i] ?? 0; //fake data
                $StockIn->_value = $_stock_in__values[$i] ?? 0;
                $StockIn->_store_id = $_stock_in__main_store_ids[$i] ?? 1;
                $StockIn->_cost_center_id = $_stock_in__main_cost_centers[$i] ?? 1;
                $StockIn->_store_salves_id = $_stock_in__store_salves_ids[$i] ?? '';
                $StockIn->organization_id = $_to_organization_id;
                $StockIn->_branch_id = $_stock_in__main_branch_id_details[$i] ?? 1;
                $StockIn->_no = $production_id;
                $StockIn->_p_p_l_id = $_stock_in__p_p_l_ids[$i] ?? 0;
                $StockIn->_status = 1;
                $StockIn->_created_by = $users->id."-".$users->name;
                $StockIn->save();


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

                //return $StockIn;
                $_stock_In_detail_id = $StockIn->id;

                $item_info = Inventory::where('id',$_stock_in__item_ids[$i])->first();

                $ProductPriceList = ProductPriceList::where('_master_id',$_main_id)
                                    ->where('_purchase_detail_id',$_stock_in__purchase_detail_ids[$i])
                                    ->where('_input_type',$request->_type)
                                    ->first();
                if(empty($ProductPriceList)){
                    $ProductPriceList = new ProductPriceList();
                    $ProductPriceList->_created_by = $users->id."-".$users->name;
                }

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
                // $ProductPriceList->_unit_id = $item_info->_unit_id ?? 1;

                  $ProductPriceList->_transection_unit = $_stock_in_transection_units[$i] ?? 1;
                $ProductPriceList->_unit_conversion = $_stock_inconversion_qtys[$i] ?? 1;
                $ProductPriceList->_base_unit = $_stock_in_base_unit_ids[$i] ?? 1;
                $ProductPriceList->_unit_id = $item_info->_unit_id ?? 1;

                $ProductPriceList->_qty = ($_stock_in__qtys[$i] * $_stock_inconversion_qtys[$i] ?? 1);
                $ProductPriceList->_pur_rate = ($_stock_in__rates[$i] / $_stock_inconversion_qtys[$i] ?? 1);
                $ProductPriceList->_sales_rate = ($_stock_in__sales_rates[$i] / $_stock_inconversion_qtys[$i] ?? 1);


                $ProductPriceList->_unique_barcode = $item_info->_unique_barcode ?? 0;
                $ProductPriceList->_warranty = $item_info->_warranty ?? 0;
                $ProductPriceList->_input_type = $request->_type;
                
                $ProductPriceList->_sales_discount = $item_info->_discount ?? 0;
                $ProductPriceList->_p_discount_input = $_stock_in__discounts[$i] ?? 0;
                $ProductPriceList->_p_discount_amount = $_stock_in__discount_amounts[$i] ?? 0;
                $ProductPriceList->_p_vat = $_stock_in__vats[$i] ?? 0;
                $ProductPriceList->_p_vat_amount = $_stock_in__vat_amounts[$i] ?? 0;
                $ProductPriceList->_sales_vat = $item_info->_vat ?? 0;;
                $ProductPriceList->_value =$_stock_in__values[$i] ?? 0;
                $ProductPriceList->_purchase_detail_id =$_stock_In_detail_id;
                $ProductPriceList->_master_id = $production_id;
                $ProductPriceList->_store_id = $_stock_in__main_store_ids[$i] ?? 1;
                $ProductPriceList->organization_id = $_to_organization_id;
                $ProductPriceList->_branch_id = $_stock_in__main_branch_id_details[$i] ?? 1;
                $ProductPriceList->_cost_center_id = $_stock_in__main_cost_centers[$i] ?? 1;
                $ProductPriceList->_store_salves_id = $_stock_in__store_salves_ids[$i] ?? '';
                 if($_p_status ==3){
                    $ProductPriceList->_status =1;
                }else{
                    $ProductPriceList->_status =0; 
                }
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
                 }


                 $ItemInventory = ItemInventory::where('_transection','production in')
                                    ->where('_transection_ref',$_main_id)
                                    ->where('_transection_detail_ref_id',$_stock_In_detail_id)
                                    ->first();
                if(empty($ItemInventory)){
                    $ItemInventory = new ItemInventory();
                    $ItemInventory->_created_by = $users->id."-".$users->name;
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

               $ItemInventory->_qty = ($_stock_in__qtys[$i] * $_stock_inconversion_qtys[$i] ?? 1);
                $ItemInventory->_rate =( $_stock_in__sales_rates[$i]);
                $ItemInventory->_cost_rate = ( $_stock_in__rates[$i]/$_stock_inconversion_qtys[$i] ?? 1);
                $ItemInventory->_cost_value = ($_stock_in__qtys[$i]*$_rates[$i]);

                  //Unit Conversion section
                $ItemInventory->_transection_unit = $_stock_in_transection_units[$i] ?? 1;
                $ItemInventory->_unit_conversion = $_stock_inconversion_qtys[$i] ?? 1;
                $ItemInventory->_base_unit = $_stock_in_base_unit_ids[$i] ?? 1;
                $ItemInventory->_unit_id = $item_info->_unit_id ?? 1;

                $ItemInventory->_unit_id = $item_info->_unit_id ?? '';
                $ItemInventory->_value = $_stock_in__values[$i] ?? 0;
                $ItemInventory->organization_id = $_to_organization_id;
                $ItemInventory->_branch_id = $_stock_in__main_branch_id_details[$i] ?? 1;
                $ItemInventory->_store_id = $_stock_in__main_store_ids[$i] ?? 1;
                $ItemInventory->_cost_center_id = $_stock_in__main_cost_centers[$i] ?? 1;
                $ItemInventory->_store_salves_id = $_stock_in__store_salves_ids[$i] ?? '';
                $ItemInventory->_status = 1;
                $ItemInventory->_created_by = $users->id."-".$users->name;
                $ItemInventory->save(); 
               // _inventory_last_price($_stock_in__item_ids[$i],$_stock_in__rates[$i],$_stock_in__sales_rates[$i]);

                $last_price_rate = ($_stock_in__rates[$i]/$_stock_inconversion_qtys[$i]);
                $last__sales_rates = ($_stock_in__sales_rates[$i]/$_stock_inconversion_qtys[$i]);
                _inventory_last_price($_item_ids[$i],$last_price_rate,$last__sales_rates);

                inventory_stock_update($_stock_in__item_ids[$i]);



            }
        }

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
$_from_branch = $request->_from_branch;
$_from_cost_center =  $request->_from_cost_center;

$_to_branch = $request->_to_branch;
$_to_cost_center =  $request->_to_cost_center;
$_name =$users->name;

if($_p_status ==1){
//Default Transit Account
account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_transit_account,$_stock_in__total,0,$_to_branch,$_to_cost_center,$_name,1,$_to_organization_id,1);
//Default Inventory Account
account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_transit_account),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,0,$__total,$_from_branch,$_from_cost_center,$_name,2,$_from_organization_id,1);
        
}
if($_p_status ==2){
//Default Transit Account
account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_production_account,$_stock_in__total,0,$_to_branch,$_to_cost_center,$_name,1,$_to_organization_id,2);
//Default Inventory Account
account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_production_account),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,0,$__total,$_from_branch,$_from_cost_center,$_name,2,$_from_organization_id,2);
        
}
if($_p_status ==3){
//Default Transit Account
account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,$_stock_in__total,0,$_to_branch,$_to_cost_center,$_name,1,$_to_organization_id,3);
//Default Inventory Account
account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,0,$__total,$_from_branch,$_from_cost_center,$_name,2,$_from_organization_id,3);
        
}






           DB::commit();
            return redirect()->back()->with('success','Information save successfully')
                                    ->with('_master_id',$production_id)
                                    ->with('_print_value',$_print_value);
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back()
           ->with('danger','There is Something Wrong !')
           ->whit('request',$request->all());
        }


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
