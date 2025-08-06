<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\VoucherMaster;
use App\Models\AccountLedger;
use App\Models\AccountGroup;
use App\Models\AccountHead;
use App\Models\Accounts;
use App\Models\Branch;
use App\Models\VoucherType;
use App\Models\VoucherMasterDetail;
use App\Models\StoreHouse;
use App\Models\PurchaseFormSettings;
use App\Models\ImportPuchaseDetail;
use App\Models\PurchaseDetail;
use App\Models\PurchaseAccount;
use App\Models\ProductPriceList;
use App\Models\ItemInventory;
use App\Models\Inventory;
use App\Models\ItemCategory;
use App\Models\Units;
use App\Models\SalesDetail;
use App\Models\BarcodeDetail;
use App\Models\PurchaseBarcode;
use App\Models\GeneralSettings;
use App\Models\ImportPuchaseFormSetting;
use App\Models\ImportPuchase;
use Auth;
use DB;
use Illuminate\Http\Request;
use Session;

class ImportPuchaseController extends Controller
{

     function __construct()
    {
         $this->middleware('permission:import-purchase-list|import-purchase-create|import-purchase-edit|import-purchase-delete|import-purchase-print', ['only' => ['index','store']]);
         $this->middleware('permission:import-purchase-print', ['only' => ['importPurchasePrint']]);
         $this->middleware('permission:import-purchase-create', ['only' => ['create','store']]);
         $this->middleware('permission:import-purchase-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:import-purchase-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.import-purchase');
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
            session()->put('_pur_limit', $request->limit);
        }else{
             $limit= \Session::get('_pur_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $datas = ImportPuchase::with(['_organization','_master_branch','_ledger'])->where('_purchase_type',2);
        $datas = $datas->whereIn('_branch_id',explode(',',$auth_user->branch_ids));
        $datas = $datas->whereIn('_cost_center_id',explode(',',$auth_user->cost_center_ids));
        $datas = $datas->whereIn('organization_id',explode(',',$auth_user->organization_ids));
        if($auth_user->user_type !='admin'){
                $datas = $datas->where('_user_id',$auth_user->id);   
        }
        

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
        
        if($request->has('_order_ref_id') && $request->_order_ref_id !=''){
            $datas = $datas->where('_order_ref_id','like',"%($request->_order_ref_id)%");
        }

        if($request->has('_referance') && $request->_referance !=''){
            $datas = $datas->where('_referance','like',"%($request->_referance)%");
        }
        if($request->has('_note') && $request->_note !=''){
            $datas = $datas->where('_note','like',"%($request->_note)%");
        }
        if($request->has('_user_name') && $request->_user_name !=''){
            $datas = $datas->where('_user_name','like',"%($request->_user_name)%");
        }
         if($request->has('_lock') && $request->_lock !=''){
            $datas = $datas->where('_lock','=',$request->_lock);
        }
        if($request->has('_sub_total') && $request->_sub_total !=''){
            $datas = $datas->where('_sub_total','=',($request->_sub_total));
        }
        if($request->has('_order_number') && $request->_order_number !=''){
            $datas = $datas->where('_order_number','=',($request->_order_number));
        }
        if($request->has('_total_discount') && $request->_total_discount !=''){
            $datas = $datas->where('_total_discount','=',($request->_total_discount));
        }
        if($request->has('_total_vat') && $request->_total_vat !=''){
            $datas = $datas->where('_total_vat','=',($request->_total_vat));
        }
        if($request->has('_total') && $request->_total !=''){
            $datas = $datas->where('_total','=',($request->_total));
        }
        if($request->has('_ledger_id') && $request->_ledger_id !='' && $request->has('_search_main_ledger_id') && $request->_search_main_ledger_id ){
            $datas = $datas->where('_ledger_id','=',($request->_ledger_id));
        }
        
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);

         $page_name = $this->page_name;
         $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
         $account_groups = AccountGroup::select('id','_name')->orderBy('_name','asc')->get();
          $current_date = date('Y-m-d');
          $current_time = date('H:i:s');
          $users = Auth::user();
        $form_settings = PurchaseFormSettings::first();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $store_houses = permited_stores(explode(',',$users->store_ids));
        // $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        //return $datas;
         if($request->has('print')){
            if($request->print =="single"){
                return view('backend.import-purchase.master_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
            }

            if($request->print =="detail"){
                return view('backend.import-purchase.details_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
            }
         }

        return view('backend.import-purchase.index',compact('datas','page_name','account_types','request','account_groups','current_date','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
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
        $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
        $account_groups = [];
        $branchs = Branch::orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $store_houses = permited_stores(explode(',',$users->store_ids));
        //$store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        $form_settings = ImportPuchaseFormSetting::first();
        $inv_accounts = [];
        $p_accounts = $inv_accounts;
        $dis_accounts =$p_accounts;
        $capital_accounts = $inv_accounts;
        $organization_ids = explode(',',$users->organization_ids);
        $_branch_ids = explode(',',$users->branch_ids);
        $_cost_center_ids = explode(',',$users->cost_center_ids);

      
       $lc_masters =DB::table("lc_masters")
                            ->select('id','lc_ip_no','lc_ip_date')
                            ->whereIn('organization_id',$organization_ids)
                            ->whereIn('_branch_id',$_branch_ids)
                            ->whereIn('_cost_center_id',$_cost_center_ids)
                            ->where('_is_close',0)
                            ->get();

       
        $categories = ItemCategory::orderBy('_name','asc')->get();
        $units = Units::orderBy('_name','asc')->get();

       return view('backend.import-purchase.create',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','categories','units','capital_accounts','lc_masters'));
    }


   public function formSettingAjax(){
        $form_settings = ImportPuchaseFormSetting::first();
        $inv_accounts = AccountLedger::orderBy('_name','asc')->get();
        $p_accounts = $inv_accounts;
        $dis_accounts = $inv_accounts;
        $cost_of_solds = $inv_accounts;
        $_cash_customers = $inv_accounts;
        $capital_accounts = $inv_accounts;
        return view('backend.import-purchase.form_setting_modal',compact('form_settings','inv_accounts','p_accounts','dis_accounts','cost_of_solds','_cash_customers','capital_accounts'));
    }

    public function Settings(Request $request){
        $data = ImportPuchaseFormSetting::first();
        if(empty($data)){
            $data = new ImportPuchaseFormSetting();
        }

        $data->organization_id = $request->organization_id ?? 0;
        $data->_default_inventory = $request->_default_inventory ?? 0;
        $data->_default_purchase = $request->_default_purchase ?? 0;
        $data->_default_discount = $request->_default_discount ?? 0;
        $data->_default_vat_account = $request->_default_vat_account ?? 0;
        $data->_default_sd_account = $request->_default_sd_account ?? 0;
        $data->_default_cd_account = $request->_default_cd_account ?? 0;
        $data->_default_ait_account = $request->_default_ait_account ?? 0;
        $data->_default_rd_account = $request->_default_rd_account ?? 0;
        $data->_default_tti_account = $request->_default_tti_account ?? 0;
        $data->_opening_inventory = $request->_opening_inventory ?? 0;
        $data->_default_capital = $request->_default_capital ?? 0;
        $data->_show_barcode = $request->_show_barcode ?? 0;
        $data->_inline_discount = $request->_inline_discount ?? 0;
        $data->_show_vat = $request->_show_vat ?? 0;
        $data->_show_store = $request->_show_store ?? 0;
        $data->_show_self = $request->_show_self ?? 0;
        $data->_show_sd = $request->_show_sd ?? 0;
        $data->_show_cd = $request->_show_cd ?? 0;
        $data->_show_ait = $request->_show_ait ?? 0;
        $data->_show_expected_qty = $request->_show_expected_qty ?? 0;
        $data->_show_rd = $request->_show_rd ?? 0;
        $data->_show_at = $request->_show_at ?? 0;
        $data->_show_tti = $request->_show_tti ?? 0;
        $data->_show_manufacture_date = $request->_show_manufacture_date ?? 0;
        $data->_show_expire_date = $request->_show_expire_date ?? 0;
        $data->_show_sales_rate = $request->_show_sales_rate ?? 0;
        $data->_show_unit = $request->_show_unit ?? 0;
        $data->_show_p_balance = $request->_show_p_balance ?? 0;
        $data->_invoice_template = $request->_invoice_template ?? 0;
        $data->_show_po = $request->_show_po ?? 0;
        $data->_show_rlp = $request->_show_rlp ?? 0;
        $data->_show_note_sheet = $request->_show_note_sheet ?? 0;
        $data->_show_wo = $request->_show_wo ?? 0;
        $data->_show_lc = $request->_show_lc ?? 0;
        $data->_show_vn = $request->_show_vn ?? 0;
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
        // dump($request->all());
        // die();


        
       $all_req= $request->all();
         $this->validate($request, [
            '_date' => 'required',
            '_branch_id' => 'required',
            '_main_ledger_id' => 'required',
            '_form_name' => 'required'
        ]);
    //###########################
    // Purchase Master information Save Start
    //###########################
       DB::beginTransaction();
        try {
         $organization_id = $request->organization_id ?? 1;
         $_p_balance = _l_balance_update($request->_main_ledger_id);
         $__sub_total = (float) $request->_sub_total;
         $__total = (float) $request->_total;
         $__discount_input = (float) $request->_discount_input;
         $__total_discount = (float) $request->_total_discount;
         $__total_vat = (float) $request->_total_vat ?? 0;

         $_cost_center_id = $request->_cost_center_id;
         $_branch_id = $request->_branch_id;



    $_l_balance = _l_balance_update($request->_main_ledger_id);
            

            $_main_branch_id = $request->_branch_id;
            $__table="import_puchases";
            $_order_number = _purchase_pfix().make_order_number($__table,$organization_id,$_main_branch_id,$request->_date);
         

        $_print_value = $request->_print ?? 0;
         $users = Auth::user();
        $Purchase = new ImportPuchase();
        $Purchase->_date = change_date_format($request->_date);
        $Purchase->_time = date('H:i:s');
        $Purchase->_order_number = $_order_number;
        $Purchase->_order_ref_id = $request->_order_ref_id;
        $Purchase->_purchase_type = $request->_purchase_type ?? 2;
        $Purchase->_referance = $request->_referance ?? '';
        $Purchase->_ledger_id = $request->_main_ledger_id;
        $Purchase->_user_id = $request->_main_ledger_id;
        $Purchase->_created_by = $users->id."-".$users->name;
        $Purchase->_user_id = $users->id;
        $Purchase->_user_name = $users->name;
        $Purchase->_note = $request->_note;
        $Purchase->_sub_total = $__sub_total;
        $Purchase->_discount_input = $__discount_input;
        $Purchase->_total_discount = $__total_discount;
        $Purchase->_total_vat = $__total_vat;
        $Purchase->_total =  $__total;

        $Purchase->_total_expected_qty = $request->_total_expected_qty_amount ?? 0;
        $Purchase->_total_qty = $request->_total_qty_amount ?? 0;

        $Purchase->_branch_id = $request->_branch_id;
        $Purchase->organization_id = $organization_id;
        $Purchase->_cost_center_id = $request->_cost_center_id;

        $Purchase->_rlp_no = $request->_rlp_no;
        $Purchase->_note_sheet_no = $request->_note_sheet_no;
        $Purchase->_workorder_no = $request->_workorder_no;
        $Purchase->_lc_no = $request->_lc_no ?? '';
        $Purchase->_vessel_no = $request->_vessel_no;
        $Purchase->_arrival_date_time = $request->_arrival_date_time;
        $Purchase->_discharge_date_time = $request->_discharge_date_time;


        $Purchase->_address = $request->_address;
        $Purchase->_phone = $request->_phone;
        $Purchase->_status = 1;
        $Purchase->_lock = $request->_lock ?? 0;
        $Purchase->save();
        $purchase_id = $Purchase->id;

        //###########################
        // Purchase Master information Save End
        //###########################

        //###########################
        // Purchase Details information Save Start
        //###########################
        $_item_ids = $request->_item_id;
        $_barcodes = $request->_barcode;
        $_qtys = $request->_qty;
        $_rates = $request->_rate;
        $_sales_rates = $request->_sales_rate;
        $_vats = $request->_vat;
        $_vat_amounts = $request->_vat_amount;
        $_values = $request->_value;
        $_main_branch_id_detail = $request->_main_branch_id_detail;
        $_main_cost_center = $request->_main_cost_center;
        $_store_ids = $request->_main_store_id;
        $_store_salves_ids = $request->_store_salves_id;
        $_manufacture_dates = $request->_manufacture_date;
        $_expire_dates = $request->_expire_date;
        $_ref_counters = $request->_ref_counter;
        $_discounts = $request->_discount ?? [];
        $_discount_amounts =$request->_discount_amount ?? [];
        $_short_notes =$request->_short_note ?? [];

        $_base_unit_ids = $request->_base_unit_id ?? [];
        $conversion_qtys = $request->conversion_qty ?? [];
        $_transection_units = $request->_transection_unit ?? [];
        $_expected_qtys = $request->_expected_qty ?? [];





       


        if(sizeof($_item_ids) > 0){
            for ($i = 0; $i <sizeof($_item_ids) ; $i++) {
                $ImportPuchaseDetail = new ImportPuchaseDetail();
                $ImportPuchaseDetail->_item_id = $_item_ids[$i];
                $ImportPuchaseDetail->_qty = $_qtys[$i];

                $ImportPuchaseDetail->_expected_qty = $_expected_qtys[$i] ?? 0;

                $ImportPuchaseDetail->_transection_unit = $_transection_units[$i] ?? 1;
                $ImportPuchaseDetail->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $ImportPuchaseDetail->_base_unit = $_base_unit_ids[$i] ?? 1;

                //Barcode 
                $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_item_ids[$i]] ?? '';

                $ImportPuchaseDetail->_barcode = $barcode_string;
                $ImportPuchaseDetail->_manufacture_date =$_manufacture_dates[$i] ?? null;
                $ImportPuchaseDetail->_expire_date = $_expire_dates[$i] ?? null;

                


                $ImportPuchaseDetail->_rate = $_rates[$i];
                $ImportPuchaseDetail->_short_note = $_short_notes[$i] ?? '';
                $ImportPuchaseDetail->_sales_rate = $_sales_rates[$i];
                $ImportPuchaseDetail->_discount = $_discounts[$i] ?? 0;
                $ImportPuchaseDetail->_discount_amount = $_discount_amounts[$i] ?? 0;
                $ImportPuchaseDetail->_vat = $_vats[$i] ?? 0;
                $ImportPuchaseDetail->_vat_amount = $_vat_amounts[$i] ?? 0;
                $ImportPuchaseDetail->_value = $_values[$i] ?? 0;
                $ImportPuchaseDetail->_store_id = $_store_ids[$i] ?? 1;
                $ImportPuchaseDetail->_cost_center_id = $_cost_center_id ?? 1;
                $ImportPuchaseDetail->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $ImportPuchaseDetail->organization_id = $organization_id ?? 1;
                $ImportPuchaseDetail->_branch_id = $_branch_id ?? 1;
                $ImportPuchaseDetail->_no = $purchase_id;
                $ImportPuchaseDetail->_status = 1;
                $ImportPuchaseDetail->_created_by = $users->id."-".$users->name;
                $ImportPuchaseDetail->save();
                $_purchase_detail_id = $ImportPuchaseDetail->id;

               
                
}
        
}

             
             //End Sms Send to customer and Supplier

            DB::commit();
            return redirect()->back()->with('success','Information save successfully')
                                ->with('_master_id',$purchase_id)
                                ->with('_print_value',$_print_value);
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back()->with('danger','There is Something Wrong !');
        }

       
    }

    public function purchasePrint($id){
        $users = Auth::user();
        $page_name = $this->page_name;
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $voucher_types = VoucherType::select('id','_name','_code')->orderBy('_code','asc')->get();
         $data =  ImportPuchase::with(['_master_branch','_master_details','purchase_account','_ledger'])->find($id);
        $form_settings = PurchaseFormSettings::first();
           $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        // $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
$store_houses = permited_stores(explode(',',$users->store_ids));

         if($form_settings->_invoice_template==1){
            return view('backend.import-purchase.print',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }elseif($form_settings->_invoice_template==2){
            return view('backend.import-purchase.print_1',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }elseif($form_settings->_invoice_template==3){
            return view('backend.import-purchase.print_2',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }elseif($form_settings->_invoice_template==4){
           return view('backend.import-purchase.print_3',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }else{
            return view('backend.import-purchase.print',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }

       
    }
    public function moneyReceipt($id){
        $users = Auth::user();
        $page_name = 'Money Receipt';
        
        $branchs = Branch::orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $data = ImportPuchase::with(['_master_branch','purchase_account','_ledger'])->where('_purchase_type',2)->find($id);

       return view('backend.import-purchase.money_receipt',compact('page_name','branchs','permited_branch','permited_costcenters','data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
     

     public function edit($id)
    {

        $users = Auth::user();
        $page_name = $this->page_name;
        $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
        $account_groups = [];
        $branchs = Branch::orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $store_houses = permited_stores(explode(',',$users->store_ids));
        
       // $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        $form_settings = ImportPuchaseFormSetting::first();
        $inv_accounts = AccountLedger::get();
        $p_accounts = $inv_accounts;
        $dis_accounts = $inv_accounts;
        
        $categories = ItemCategory::orderBy('_name','asc')->get();
        $units = Units::orderBy('_name','asc')->get();
         $data =  ImportPuchase::with(['_master_branch','_master_details','purchase_account','_ledger'])->where('_purchase_type',2)->where('_lock',0)->find($id);
         
         if(!$data){
            return redirect()->back()->with('danger','You have no permission to edit or update !');
         }
        $sales_number = SalesDetail::where('_purchase_invoice_no',$id)->count();
       return view('backend.import-purchase.edit',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','categories','units','data','sales_number'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ImportPuchase  $importPuchase
     * @return \Illuminate\Http\Response
     */
 public function update(Request $request)
    {
         
      //return dump($request->all());
        $all_req= $request->all();
        $this->validate($request, [
            '_purchase_id' => 'required',
            '_form_name' => 'required',
            '_date' => 'required',
            '_main_ledger_id' => 'required',
        ]);



       //######################
       // Previous information need to make zero for every thing.
       //#####################
     $purchase_id = $request->_purchase_id;
     $data =  ImportPuchase::where('_lock',0)->find($purchase_id); 
     if(!$data){ return redirect()->back()->with('danger','You have no permission to edit or update !'); }


      $sales_number = SalesDetail::where('_purchase_invoice_no',$purchase_id)->count();
      $sales_number = 0;

      $organization_id = $request->organization_id ?? 1;   
    $_branch_id = $request->_branch_id;   
    $_cost_center_id = $request->_cost_center_id;
    $__table="import_puchases";



   //return  $_order_number = _purchase_pfix().make_order_number($__table,$organization_id,$_branch_id,$request->_date);

    //###########################
    // Purchase Master information Save Start
    //###########################
      DB::beginTransaction();
        try {

    if($sales_number == 0 ){
    ImportPuchaseDetail::where('_no', $purchase_id)
            ->update(['_status'=>0]);
    ProductPriceList::where('_master_id',$purchase_id)
                    ->update(['_status'=>0]);
    ItemInventory::where('_transection',"Purchase")
        ->where('_transection_ref',$purchase_id)
        ->update(['_status'=>0]);
    }
    PurchaseAccount::where('_no',$purchase_id)                               
            ->update(['_status'=>0]);
    Accounts::where('_ref_master_id',$purchase_id)
                    ->where('_table_name',$request->_form_name)
                     ->update(['_status'=>0]); 
    Accounts::where('_ref_master_id',$purchase_id)
                    ->where('_table_name','purchase_accounts')
                     ->update(['_status'=>0]); 

    $_p_balance = _l_balance_update($request->_main_ledger_id); 
    if($sales_number == 0 ){  
    _barcode_status("BarcodeDetail",$purchase_id);          
    _barcode_status("PurchaseBarcode",$purchase_id); 
    }  

    $organization_id = $request->organization_id ?? 1;   
    $_branch_id = $request->_branch_id;   
    $_cost_center_id = $request->_cost_center_id;

    //###########################
    // Purchase Master information Save Start
    //###########################
       $_print_value = $request->_print ?? 0;
       $users = Auth::user();
        $Purchase = ImportPuchase::where('id',$purchase_id)->first();
        if(empty($Purchase)){
            return redirect()->back()->with('danger','Something Went Wrong !');
        }
        $Purchase->_date = change_date_format($request->_date);
        $Purchase->_time = date('H:i:s');
        $Purchase->_order_ref_id = $request->_order_ref_id;
        $Purchase->_order_number = $request->_order_number ?? '';
        $Purchase->_lc_no = $request->_lc_no ?? '';
        $Purchase->_referance = $request->_referance;
        $Purchase->_ledger_id = $request->_main_ledger_id;
        $Purchase->_user_id = $users->id;
        $Purchase->_created_by = $users->id."-".$users->name;
        $Purchase->_updated_by = $users->id."-".$users->name;
        $Purchase->_user_id = $users->id;
        $Purchase->_user_name = $users->name;
        $Purchase->_note = $request->_note;
        $Purchase->_sub_total = $request->_sub_total;
        $Purchase->_discount_input = $request->_discount_input;
        $Purchase->_total_discount = $request->_total_discount;
        $Purchase->_total_vat = $request->_total_vat;
        $Purchase->_total = $request->_total;

        $Purchase->_total_expected_qty = $request->_total_expected_qty_amount ?? 0;
        $Purchase->_total_qty = $request->_total_qty_amount ?? 0;




        $Purchase->_branch_id = $request->_branch_id;
        $Purchase->organization_id = $organization_id;
        $Purchase->_cost_center_id = $request->_cost_center_id;

        $Purchase->_rlp_no = $request->_rlp_no;
        $Purchase->_note_sheet_no = $request->_note_sheet_no;
        $Purchase->_workorder_no = $request->_workorder_no;
        $Purchase->_lc_no = $request->_lc_no;
        $Purchase->_vessel_no = $request->_vessel_no;
        $Purchase->_arrival_date_time = $request->_arrival_date_time;
        $Purchase->_discharge_date_time = $request->_discharge_date_time;

        $Purchase->_address = $request->_address;
        $Purchase->_phone = $request->_phone;
        $Purchase->_status = 1;
        $Purchase->_lock = $request->_lock ?? 0;
        $Purchase->save();
        $purchase_id = $Purchase->id;

        //###########################
        // Purchase Master information Save End
        //###########################

        //###########################
        // Purchase Details information Save Start
        //###########################
        $_item_ids = $request->_item_id;
        $_barcodes = $request->_barcode;
        $_qtys = $request->_qty;
        $_expected_qtys = $request->_expected_qty ?? [];
        $_rates = $request->_rate;
        $_sales_rates = $request->_sales_rate;
        $_vats = $request->_vat;
        $_vat_amounts = $request->_vat_amount;
        $_values = $request->_value;
        $_main_branch_id_detail = $request->_main_branch_id_detail;
        $_main_cost_center = $request->_main_cost_center;
        $_store_ids = $request->_main_store_id;
        $_store_salves_ids = $request->_store_salves_id;
        $purchase_detail_ids = $request->purchase_detail_id;
        $_manufacture_dates = $request->_manufacture_date;
        $_expire_dates = $request->_expire_date;
        $_ref_counters = $request->_ref_counter;

        $_discounts = $request->_discount ?? [];
        $_discount_amounts =$request->_discount_amount ?? [];
        $_short_notes =$request->_short_note ?? [];


        $_base_unit_ids = $request->_base_unit_id ?? [];
        $conversion_qtys = $request->conversion_qty ?? [];
        $_transection_units = $request->_transection_unit ?? [];

        
if($sales_number == 0 ){
        if(sizeof($_item_ids) > 0){
            for ($i = 0; $i <sizeof($_item_ids) ; $i++) {
                if($purchase_detail_ids[$i] ==0){
                    $ImportPuchaseDetail = new ImportPuchaseDetail();
                    $ImportPuchaseDetail->_created_by = $users->id."-".$users->name;
                }else{
                    $ImportPuchaseDetail = ImportPuchaseDetail::where('id',$purchase_detail_ids[$i])->first();
                }
                $ImportPuchaseDetail->_manufacture_date =$_manufacture_dates[$i] ?? null;
                $ImportPuchaseDetail->_expire_date = $_expire_dates[$i] ?? null;

                //Barcode 
                $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_item_ids[$i]] ?? '';

                $ImportPuchaseDetail->_barcode = $barcode_string;
                $ImportPuchaseDetail->_item_id = $_item_ids[$i];
                $ImportPuchaseDetail->_qty = $_qtys[$i];
                $ImportPuchaseDetail->_expected_qty = $_expected_qty[$i] ?? 0;

                $ImportPuchaseDetail->_transection_unit = $_transection_units[$i] ?? 1;
                $ImportPuchaseDetail->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $ImportPuchaseDetail->_base_unit = $_base_unit_ids[$i] ?? 1;

                $ImportPuchaseDetail->_short_note = $_short_notes[$i] ?? '';
                $ImportPuchaseDetail->_rate = $_rates[$i];
                $ImportPuchaseDetail->_sales_rate = $_sales_rates[$i];
                $ImportPuchaseDetail->_discount = $_discounts[$i] ?? 0;
                $ImportPuchaseDetail->_discount_amount = $_discount_amounts[$i] ?? 0;
                $ImportPuchaseDetail->_vat = $_vats[$i] ?? 0;
                $ImportPuchaseDetail->_vat_amount = $_vat_amounts[$i] ?? 0;
                $ImportPuchaseDetail->_value = $_values[$i] ?? 0;
                $ImportPuchaseDetail->_store_id = $_store_ids[$i] ?? 1;
                $ImportPuchaseDetail->_cost_center_id = $_main_cost_center[$i] ?? 1;
                $ImportPuchaseDetail->_store_salves_id = $_store_salves_ids[$i] ?? 1;
                $ImportPuchaseDetail->organization_id = $organization_id ?? 1;
                $ImportPuchaseDetail->_branch_id = $_main_branch_id_detail[$i] ?? 1;
                $ImportPuchaseDetail->_no = $purchase_id;
                $ImportPuchaseDetail->_status = 1;
                $ImportPuchaseDetail->_updated_by = $users->id."-".$users->name;
                $ImportPuchaseDetail->save();
                $_purchase_detail_id = $ImportPuchaseDetail->id;

                $item_info = Inventory::where('id',$_item_ids[$i])->first();

                $ProductPriceList = ProductPriceList::where('_master_id',$purchase_id)
                                    ->where('_purchase_detail_id',$_purchase_detail_id)
                                    ->where('_input_type','purchase')
                                    ->first();
                if(empty($ProductPriceList)){
                    $ProductPriceList = new ProductPriceList();
                    $ProductPriceList->_created_by = $users->id."-".$users->name;
                }
                
               // $ProductPriceList->_barcode =$barcode_string ?? '';

                $general_settings =GeneralSettings::select('_pur_base_model_barcode')->first();
                if($general_settings->_pur_base_model_barcode==1){
                     if($item_info->_unique_barcode ==1){
                        $ProductPriceList->_barcode =$barcode_string ?? '';
                        }else{
                            if($barcode_string !=''){
                                if($purchase_detail_ids[$i] ==0){
                                    $ProductPriceList->_barcode = $barcode_string.$purchase_id;
                                    $PurchaseD = ImportPuchaseDetail::find($_purchase_detail_id);
                                    $PurchaseD->_barcode = $barcode_string.$purchase_id;
                                    $PurchaseD->save();
                                }
                            }
                        }
                }else{
                    $ProductPriceList->_barcode =$barcode_string ?? '';
                }
                
                $ProductPriceList->_item_id = $_item_ids[$i];
                $ProductPriceList->_item = $item_info->_item ?? '';
                $ProductPriceList->_unique_barcode = $item_info->_unique_barcode ?? 0;
                $ProductPriceList->_warranty = $item_info->_warranty ?? 0;
                $ProductPriceList->_unit_id =  $item_info->_unit_id ?? 1;
                $ProductPriceList->_manufacture_date =$_manufacture_dates[$i] ?? null;
                $ProductPriceList->_expire_date = $_expire_dates[$i] ?? null;
                $ProductPriceList->_qty = ($_qtys[$i] * $conversion_qtys[$i] ?? 1);
                $ProductPriceList->_sales_rate = ($_sales_rates[$i] / $conversion_qtys[$i] ?? 1);
                $ProductPriceList->_pur_rate = ($_rates[$i] / $conversion_qtys[$i] ?? 1);
                 //Unit Conversion section
                $ProductPriceList->_transection_unit = $_transection_units[$i] ?? 1;
                $ProductPriceList->_unit_conversion = $conversion_qtys[$i] ?? 1;
                $ProductPriceList->_base_unit = $_base_unit_ids[$i] ?? 1;
                $ProductPriceList->_unit_id = $item_info->_unit_id ?? 1;

                
                $ProductPriceList->_sales_discount = $item_info->_discount ?? 0;
                $ProductPriceList->_sales_vat = $item_info->_vat ?? 0;;
                $ProductPriceList->_value =$_values[$i] ?? 0;
                $ProductPriceList->_purchase_detail_id =$_purchase_detail_id;
                $ProductPriceList->_master_id = $purchase_id;
                $ProductPriceList->_p_discount_input = $_discounts[$i] ?? 0;
                $ProductPriceList->_p_discount_amount = $_discount_amounts[$i] ?? 0;
                $ProductPriceList->_p_vat = $_vats[$i] ?? 0;
                $ProductPriceList->_p_vat_amount = $_vat_amounts[$i] ?? 0;
                $ProductPriceList->organization_id = $organization_id ?? 1;
                $ProductPriceList->_branch_id = $_main_branch_id_detail[$i] ?? 1;
                $ProductPriceList->_store_id = $_store_ids[$i] ?? 1;
                $ProductPriceList->_cost_center_id = $_main_cost_center[$i] ?? 1;
                $ProductPriceList->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $ProductPriceList->_status =1;
                $ProductPriceList->_updated_by = $users->id."-".$users->name;
                $ProductPriceList->save();



                    $product_price_id =  $ProductPriceList->id;
                    $_unique_barcode =  $ProductPriceList->_unique_barcode;

/*
    Barcode insert into database section
   _barcode_insert_update($modelName, $_p_p_id,$_item_id,$_no_id,$_no_detail_id,$_qty,$_barcode,$_status,$_return=0,$p=0)
   IF RETURN ACTION THEN $_return = 1; and BarcodeDetail avoid 
                [  $data->_no_id = $_no_id;
                    $data->_no_detail_id = $_no_detail_id;
                    ] use  $p=1;
*/
if($_unique_barcode ==1){
      if($barcode_string !=""){
                   $barcode_array=  explode(",",$barcode_string);
                   $_qty = 1;
                   $_stat = 1;
                   $_return=0;
                   $p=0;
                   foreach ($barcode_array as $_b_v) {
                    _barcode_insert_update('BarcodeDetail', $product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,$_return,$p);
                    _barcode_insert_update('PurchaseBarcode', $product_price_id,$_item_ids[$i],$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,$_return,$p);
                     
                   }
                }
}
               

            }
        }

    }

        //###########################
        // Purchase Details information Save End
        //###########################

        //###########################
        // Purchase Account information Save End
        //###########################
        $_total_dr_amount = 0;
        $_total_cr_amount = 0;

        $PurchaseFormSettings = PurchaseFormSettings::first();
        $_default_inventory = $PurchaseFormSettings->_default_inventory;
        $_default_purchase = $PurchaseFormSettings->_default_purchase;
        $_default_discount = $PurchaseFormSettings->_default_discount;
        $_default_vat_account = $PurchaseFormSettings->_default_vat_account;

        $_ref_master_id=$purchase_id;
        $_ref_detail_id=$purchase_id;
        $_short_narration='N/A';
        $_narration = $request->_note;
        $_reference= $request->_referance;
        $_transaction= 'Purchase';
        $_date = change_date_format($request->_date);
        $_table_name = $request->_form_name;
        $_branch_id = $request->_branch_id;
        $_cost_center =  $request->_cost_center_id ?? 1;
        $_name =$users->name;

        

         

         

               DB::commit();
        if(($request->_lock ?? 0) ==1){
                return redirect('import-purchase/print/'.$purchase_id)
                ->with('success','Information save successfully');
          }else{
            return redirect()->back()
            ->with('success','Information save successfully')
            ->with('_master_id',$purchase_id)
            ->with('_print_value',$_print_value);
          }

        
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back()->with('danger','There is Something Wrong !');
        }

       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ImportPuchase  $importPuchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImportPuchase $importPuchase)
    {
        //
    }
}
