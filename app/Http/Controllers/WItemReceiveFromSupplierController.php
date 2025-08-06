<?php

namespace App\Http\Controllers;

use App\Models\IndividualReplaceMaster;
use App\Models\IndividualReplaceFormSetting;
use App\Models\IndividualReplaceInAccount;
use App\Models\IndividualReplaceInItem;
use App\Models\IndividualReplaceOldItem;
use App\Models\IndividualReplaceOutAccount;
use App\Models\IndividualReplaceOutItem;
use App\Models\AccountHead;
use App\Models\AccountGroup;
use App\Models\Branch;
use App\Models\StoreHouse;
use App\Models\AccountLedger;
use App\Models\ItemCategory;
use App\Models\Units;
use App\Models\Warranty;
use App\Models\GeneralSettings;
use App\Models\Accounts;
use App\Models\WarrantyMaster;
use App\Models\Inventory;
use App\Models\ProductPriceList;
use App\Models\ItemInventory;
use Illuminate\Http\Request;
use Auth;
use DB;



class WItemReceiveFromSupplierController extends Controller
{


        function __construct()
    {
         $this->middleware('permission:individual-replacement-list|individual-replacement-create', ['only' => ['index','store']]);
         $this->middleware('permission:individual-replacement-print', ['only' => ['Print']]);
         $this->middleware('permission:individual-replacement-create', ['only' => ['create','store']]);
         $this->middleware('permission:individual-replacement-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:individual-replacement-delete', ['only' => ['destroy']]);
         $this->page_name = "Warranty Item Receive From Supplier";
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
            session()->put('_thired_partey_service_limit', $request->limit);
        }else{
             $limit= \Session::get('_thired_partey_service_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $datas = IndividualReplaceMaster::with(['_master_branch','_customer_ledger','_supplier_ledger'])
        ->where('_sales_type',1);



        $datas = $datas->whereIn('_branch_id',explode(',',\Auth::user()->branch_ids));
        if($request->has('_branch_id') && $request->_branch_id !=""){
            $datas = $datas->where('_branch_id',$request->_branch_id);  
        }else{
           if($auth_user->user_type !='admin'){
                $datas = $datas->where('_user_id',$auth_user->id);   
            } 
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
        

        if($request->has('_referance') && $request->_referance !=''){
            $datas = $datas->where('_referance','like',"%$request->_referance%");
        }
        if($request->has('_order_number') && $request->_order_number !=''){
            $datas = $datas->where('_order_number','like',"%$request->_order_number%");
        }
        
        if($request->has('_user_name') && $request->_user_name !=''){
            $datas = $datas->where('_user_name','like',"%$request->_user_name%");
        }
         if($request->has('_lock') && $request->_lock !=''){
            $datas = $datas->where('_lock','=',$request->_lock);
        }
        
        if($request->has('_service_status') && $request->_service_status !=''){
            $datas = $datas->where('_service_status','=',trim($request->_service_status));
        }
        if($request->has('_customer_id') && $request->_customer_id !='' && $request->has('_search_main_customer_id') && $request->_search_main_customer_id ){
            $datas = $datas->where('_customer_id','=',trim($request->_customer_id));
        }
        if($request->has('_supplier_id') && $request->_supplier_id !='' && $request->has('_search_main_supplier_id') && $request->_search_main_supplier_id ){
            $datas = $datas->where('_supplier_id','=',trim($request->_supplier_id));
        }
        
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);

         $page_name = $this->page_name;
         $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
         $account_groups = AccountGroup::select('id','_name')->orderBy('_name','asc')->get();
          $current_date = date('Y-m-d');
          $current_time = date('H:i:s');
          $users = Auth::user();
        $form_settings = IndividualReplaceFormSetting::first();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = [];
        //return $datas;
         if($request->has('print')){
            if($request->print =="single"){
                return view('backend.w-item-receive-from-supp.master_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
            }

            if($request->print =="detail"){
                return view('backend.w-item-receive-from-supp.details_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
            }
         }

        return view('backend.w-item-receive-from-supp.index',compact('datas','page_name','account_types','request','account_groups','current_date','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
    }



    public function individualReplacementOutReport($id){
        $datas= \DB::select(" SELECT t1._date as w_date,
                     t1._order_number,t2._item_id,t3._item,t2._barcode,
                        t1._sales_date,t6._order_number AS _sales_no,t4._ledger_id ,
                        t5._name AS _supplier_name,t5._phone,t5._email,
                        t4._date AS _purchase_date,t4._order_number as purchase_invoice,t2._warranty_reason,t1._note,t1._user_name,t1._branch_id
FROM warranty_masters AS t1 
INNER JOIN warranty_details AS t2 ON (t1.id=t2._no AND t2._status=1)
INNER JOIN product_price_lists AS t3 ON t3.id=t2._p_p_l_id
INNER JOIN purchases AS t4 ON t4.id=t3._master_id
INNER JOIN account_ledgers AS t5 ON t5.id=t4._ledger_id
INNER JOIN sales as t6 ON t6.id=t2._sales_no

WHERE t1.id=$id ");

       $page_name = "Individual Replacement Out Report";

        return view('backend.w-item-receive-from-supp.out_report',compact('datas','page_name'));
    }


    public function individualReplacementCustomerDeliveryReport($id){
           $data=  $datas = IndividualReplaceMaster::with(['_master_branch','_customer_ledger','_supplier_ledger','_ind_repl_old_item','_ind_repl_in_item','_ind_repl_out_item','_ind_repl_in_account','_ind_repl_out_acount','_warranty_detail'])->find($id);
       $page_name = "Individual Customer Delivery Report";
        return view('backend.w-item-receive-from-supp.customer_delilvery_report',compact('data','page_name'));
    }
    
    public function individualReplacementPrint($id){
          $data=  $datas = IndividualReplaceMaster::with(['_master_branch','_customer_ledger','_supplier_ledger','_ind_repl_old_item','_ind_repl_in_item','_ind_repl_out_item','_ind_repl_in_account','_ind_repl_out_acount','_warranty_detail'])->find($id);
       $page_name = "Individual Customer Delivery Report";
        return view('backend.w-item-receive-from-supp.individual_replacement_print',compact('data','page_name'));
    }
    

    public function individualReplacementInReport($id){
          $data=  $datas = IndividualReplaceMaster::with(['_master_branch','_customer_ledger','_supplier_ledger','_ind_repl_old_item','_ind_repl_in_item','_ind_repl_out_item','_ind_repl_in_account','_ind_repl_out_acount','_warranty_detail'])->find($id);
       $page_name = "Individual Replace In Report";
        return view('backend.w-item-receive-from-supp.replace_in_report',compact('data','page_name'));
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
        
        $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        $form_settings = IndividualReplaceFormSetting::first();
        $inv_accounts = [];
      //  $p_accounts = AccountLedger::where('_account_head_id',8)->get();
        $dis_accounts = [];
        $capital_accounts = [];

        $p_accounts = AccountLedger::whereIn('_account_head_id',[8,10,5,11,15])->orderBy('_name','ASC')->get();
        $dis_accounts = $p_accounts;
       
        $categories = ItemCategory::orderBy('_name','asc')->get();
        $units = Units::orderBy('_name','asc')->get();
        $warranties = Warranty::where('_status',1)->orderBy('id','asc')->get();

          $_defalut_group_ledgers =\DB::select( " SELECT t1.id,t1._account_head_id,t1._account_group_id,t1._name 
FROM account_ledgers AS t1 
WHERE t1._account_group_id=(SELECT _cash_group FROM general_settings ) " );

       return view('backend.w-item-receive-from-supp.create',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','categories','units','capital_accounts','_defalut_group_ledgers','warranties'));
    }


     public function Settings (Request $request){
        $data = IndividualReplaceFormSetting::first();
        if(empty($data)){
            $data = new IndividualReplaceFormSetting();
        }
        $data->_default_rep_manage_account = $request->_default_rep_manage_account;
        $data->_default_sales_dicount = $request->_default_sales_dicount;
        $data->_default_vat_account = $request->_default_vat_account;
        $data->_default_discount = $request->_default_discount;
        $data->_show_short_note = $request->_show_short_note;
        $data->_show_barcode = $request->_show_barcode;
        $data->_show_vat = $request->_show_vat;
        $data->_default_vat_account = $request->_default_vat_account;
        $data->_inline_discount = $request->_inline_discount ?? 1;
        $data->_invoice_template = $request->_invoice_template ?? 1;
        $data->_show_p_balance = $request->_show_p_balance ?? 1;
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

        $request->validate([
                '_form_name' => 'required|max:255',
                '_date' => 'required',
                '_order_ref_id' => 'required',
                '_supplier_id' => 'required',
        ]);
       // dump($request->all());
        //return $request->all();

        $users = Auth::user();
          $settings = GeneralSettings::first();
            $_lock = $settings->_auto_lock ?? 0;
            DB::beginTransaction();
            try {
            $_date = change_date_format($request->_date);
            $IndividualReplaceMaster = new IndividualReplaceMaster();
            $IndividualReplaceMaster->_order_number = $request->_order_number ?? '';
            $IndividualReplaceMaster->_date = $_date;
            $IndividualReplaceMaster->_time = date('H:i:s'); 
            $IndividualReplaceMaster->_order_ref_id = $request->_order_ref_id ?? '';
            $IndividualReplaceMaster->_note = $request->_note ?? '';
            $IndividualReplaceMaster->_referance = $request->_referance ?? '';
            $IndividualReplaceMaster->_address = $request->_address ?? '';
            $IndividualReplaceMaster->_phone = $request->_phone ?? '';
           
            $IndividualReplaceMaster->_customer_id  = $request->_customer_id  ?? '';
            $IndividualReplaceMaster->_supplier_id  = $request->_supplier_id  ?? '';
            $IndividualReplaceMaster->_sales_man_id  = $request->_sales_man_id  ?? '';
            $IndividualReplaceMaster->_delivery_man_id  = $request->_delivery_man_id  ?? '';

            $IndividualReplaceMaster->_user_id  = $users->id  ?? '';
            $IndividualReplaceMaster->_created_by = $users->id."-".$users->name;
            $IndividualReplaceMaster->_user_name = $users->name;
            $IndividualReplaceMaster->_sales_type = 1;

            $IndividualReplaceMaster->_branch_id = $request->_branch_id ?? 1;
            $IndividualReplaceMaster->_store_id = $request->_store_id ?? 1;
            $IndividualReplaceMaster->_cost_center_id = $request->_cost_center_id ?? 1;
            $IndividualReplaceMaster->_apporoved_by = $request->_apporoved_by ?? $users->id;
            $IndividualReplaceMaster->_service_by = $request->_service_by ?? $users->id;

            $IndividualReplaceMaster->_status = $request->_status ?? 1;
            $IndividualReplaceMaster->_lock = $_lock ?? 0;
            $IndividualReplaceMaster->save();

             $_master_id = $IndividualReplaceMaster->id;
             $purchase_id = $IndividualReplaceMaster->id;
            $_order_number = ind_rep_prefix().$_master_id;
             IndividualReplaceMaster::where('id',$_master_id)->update(['_order_number'=>$_order_number]);

            $_purchase_detail_id = $_master_id;
          //  $purchase_id = $_master_id;
            $barcode_string = $request->_in_barcode ?? '';

                $item_info = Inventory::where('id',$request->_in_item_id)->first();

                $ProductPriceList = new ProductPriceList();
                $ProductPriceList->_item_id = $request->_in_item_id;
                $ProductPriceList->_item = $item_info->_item ?? '';
                $ProductPriceList->_barcode =$barcode_string;

                $ProductPriceList->_qty = $request->_in_qty ?? 1;
                $ProductPriceList->_sales_rate = $item_info->_sales_rate ?? 0;
                $ProductPriceList->_pur_rate = $item_info->_rate ?? 0;
                $ProductPriceList->_unit_id = $item_info->_unit_id ?? 1;
                $ProductPriceList->_unique_barcode = $item_info->_unique_barcode ?? 0;
                $ProductPriceList->_warranty = $item_info->_warranty ?? 0;
                $ProductPriceList->_input_type = "individual_replace";
                
                $ProductPriceList->_sales_discount = $item_info->_discount ?? 0;
                $ProductPriceList->_p_discount_input = $item_info->_discount ?? 0;
                $ProductPriceList->_p_discount_amount = $item_info->_discount_amount ?? 0;
                $ProductPriceList->_p_vat = $item_info->_vat ?? 0;
                $ProductPriceList->_p_vat_amount = $item_info->_vat_amount ?? 0;
                $ProductPriceList->_sales_vat = $item_info->_vat ?? 0;;
                $ProductPriceList->_value =$item_info->_value ?? 0;
                $ProductPriceList->_purchase_detail_id =$_purchase_detail_id;
                $ProductPriceList->_master_id = $purchase_id;
                $ProductPriceList->_branch_id = $item_info->_branch_id ?? 1;
                $ProductPriceList->_cost_center_id = $item_info->_cost_center_id ?? 1;
                $ProductPriceList->_store_salves_id = $item_info->_store_salves_id ?? '';
                $ProductPriceList->_store_id = $item_info->_store_id ?? 1;
                $ProductPriceList->_status =1;
                $ProductPriceList->_created_by = $users->id."-".$users->name;
                $ProductPriceList->save();
                $product_price_id =  $ProductPriceList->id;
                 $_in_p_p_l_id =  $ProductPriceList->id;

                $_unique_barcode =  $ProductPriceList->_unique_barcode;

                     if($_unique_barcode ==1){
                         if($barcode_string !=""){

                               $barcode_array=  explode(",",$barcode_string);
                               $_qty = 1;
                               $_stat = 1;
                               $_return=0;
                               $p=0;
                               foreach ($barcode_array as $_b_v) {
                                _barcode_insert_update('BarcodeDetail',$product_price_id,$request->_in_item_id,$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,$_return,$p);
                                _barcode_insert_update('RepInBarcode',$product_price_id,$request->_in_item_id,$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,$_return,$p);
                                 
                               }
                            }
                     }
                
              

                $ItemInventory = new ItemInventory();
                $ItemInventory->_item_id =  $item_info->id;
                $ItemInventory->_item_name =  $item_info->_item ?? '';
                $ItemInventory->_unit_id =  $item_info->_unit_id ?? '';
                $ItemInventory->_category_id = _item_category($item_info->id);
                $ItemInventory->_date = change_date_format($request->_date);
                $ItemInventory->_time = date('H:i:s');
                $ItemInventory->_transection = "Replacement In From Supplier";
                $ItemInventory->_transection_ref = $purchase_id;
                $ItemInventory->_transection_detail_ref_id = $_purchase_detail_id;
                $ItemInventory->_qty = $request->_in_qty;
                $ItemInventory->_rate = $item_info->_sales_rate ?? 0;
                $ItemInventory->_unit_id = $item_info->_unit_id ?? '';
                $ItemInventory->_cost_rate = $item_info->_rate ?? 0;
                $ItemInventory->_cost_value = ($request->_in_qty*$item_info->_rate);
                $ItemInventory->_value = ($request->_in_qty*$item_info->_sales_rate) ?? 0;
                $ItemInventory->_branch_id = $item_info->_branch_id ?? 1;
                $ItemInventory->_store_id = $item_info->_store_id ?? 1;
                $ItemInventory->_cost_center_id = $item_info->_cost_center_id ?? 1;
                $ItemInventory->_store_salves_id = $item_info->_store_salves_id ?? '';
                $ItemInventory->_status = 1;
                $ItemInventory->_created_by = $users->id."-".$users->name;
                $ItemInventory->save(); 
                inventory_stock_update($item_info->id);

            //Item IN
            $IndividualReplaceInItem = new IndividualReplaceInItem();
            $IndividualReplaceInItem->_item_id = $request->_in_item_id;
            $IndividualReplaceInItem->_p_p_l_id = $_in_p_p_l_id ?? 0;
            $IndividualReplaceInItem->_qty = $request->_in_qty ?? 0;
            $IndividualReplaceInItem->_rate = $request->_in_rate ?? 0;
            $IndividualReplaceInItem->_sales_rate = $request->_in_sales_rate ?? 0;
            $IndividualReplaceInItem->_discount = $request->_in_discount ?? 0;
            $IndividualReplaceInItem->_discount_amount = $request->_in_discount_amount ?? 0;
            $IndividualReplaceInItem->_vat = $request->_in_vat ?? 0;
            $IndividualReplaceInItem->_vat_amount = $request->_in_vat_amount ?? 0;
            $IndividualReplaceInItem->_value = $request->_in_value ?? 0;
            $IndividualReplaceInItem->_adjustment_amount = $request->_in_adjustment_amount ?? 0;
            $IndividualReplaceInItem->_net_total = $request->_in_net_total ?? 0;
            $IndividualReplaceInItem->_barcode = $request->_in_barcode ?? '';
            $IndividualReplaceInItem->_short_note = $request->_in_short_note ?? '';
            $IndividualReplaceInItem->_manufacture_date = $request->_in_manufacture_date ?? '';
            $IndividualReplaceInItem->_expire_date = $request->_in_expire_date ?? '';
            $IndividualReplaceInItem->_warranty = $request->_in_warranty ?? 0;
            $IndividualReplaceInItem->_no = $purchase_id;

            $IndividualReplaceInItem->_purchase_invoice_no = $_master_id ?? 0;
            $IndividualReplaceInItem->_purchase_detail_id = $_master_id ?? 0;

            $IndividualReplaceInItem->_branch_id = $request->_branch_id ?? 1;
            $IndividualReplaceInItem->_store_id = $request->_in_store_id ?? 1;
            $IndividualReplaceInItem->_cost_center_id = $request->_cost_center_id ?? 0;
            $IndividualReplaceInItem->_store_salves_id = $request->_store_salves_id ?? 0;

            $IndividualReplaceInItem->_status = 1;
            $IndividualReplaceInItem->_in_status = $request->_in_status ?? 0;
            $IndividualReplaceInItem->_in_ledger_id = $request->_in_ledger_id ?? 0;
            $IndividualReplaceInItem->_in_payment_amount = $request->_in_payment_amount ?? 0;
            $IndividualReplaceInItem->save();


            


            

            //Item OUT
            $IndividualReplaceOldItem = new IndividualReplaceOldItem();
            $IndividualReplaceOldItem->_item_id = $request->_old_item_id;
            $IndividualReplaceOldItem->_p_p_l_id = $request->_old_p_p_l_id ?? 0;
            $IndividualReplaceOldItem->_qty = $request->_old_qty ?? 0;
            $IndividualReplaceOldItem->_rate = $request->_old_rate ?? 0;
            $IndividualReplaceOldItem->_sales_rate = $request->_old_sales_rate ?? 0;
            $IndividualReplaceOldItem->_discount = $request->_old_discount ?? 0;
            $IndividualReplaceOldItem->_discount_amount = $request->_old_discount_amount ?? 0;
            $IndividualReplaceOldItem->_vat = $request->_old_vat ?? 0;
            $IndividualReplaceOldItem->_vat_amount = $request->_old_vat_amount ?? 0;
            $IndividualReplaceOldItem->_value = $request->_old_value ?? 0;
            $IndividualReplaceOldItem->_barcode = $request->_old_barcode ?? '';
            $IndividualReplaceOldItem->_short_note = $request->_old_short_note ?? '';
            $IndividualReplaceOldItem->_manufacture_date = $request->_old_manufacture_date ?? '';
            $IndividualReplaceOldItem->_expire_date = $request->_old_expire_date ?? '';
            $IndividualReplaceOldItem->_warranty_date = change_date_format($request->_old_warranty_date ?? '');
            $IndividualReplaceOldItem->_sales_date = change_date_format($request->_old_sales_date ?? '');
            $IndividualReplaceOldItem->_warranty_comment = $request->_old_warranty_comment ?? '';
            $IndividualReplaceOldItem->_warranty = $request->_old_warranty ?? 0;
            $IndividualReplaceOldItem->_no = $purchase_id;

            $IndividualReplaceOldItem->_purchase_invoice_no = $request->_old_purchase_invoice_no ?? 0;
            $IndividualReplaceOldItem->_purchase_detail_id = $request->_old_purchase_detail_id ?? 0;

            $IndividualReplaceOldItem->_branch_id = $request->_branch_id ?? 1;
            $IndividualReplaceOldItem->_store_id = $request->_store_id ?? 1;
            $IndividualReplaceOldItem->_cost_center_id = $request->_cost_center_id ?? 0;
            $IndividualReplaceOldItem->_store_salves_id = $request->_store_salves_id ?? 0;

            $IndividualReplaceOldItem->_status = 1;
            $IndividualReplaceOldItem->save();


            $settings = IndividualReplaceFormSetting::first();
            $_default_rep_manage_account = $settings->_default_rep_manage_account;
            $_default_sales_dicount = $settings->_default_sales_dicount;
            $_default_cost_of_solds = $settings->_default_cost_of_solds;
            $_default_discount = $settings->_default_discount;
            $_default_vat_account = $settings->_default_vat_account;

            $_table_name = $request->_form_name;
            $_cost_center = $request->_cost_center_id;
            $_name = Auth::user()->name ?? '';
            $_narration = $request->_note ?? '';
            $_reference = $request->_referance ?? '';
            $_branch_id = $request->_branch_id ?? '';
            $__sub_total = $request->_in_value ?? 0;
            $_transaction = 'individual_replace';

            $_ref_master_id = $_master_id;
            $_ref_detail_id = $_master_id;

            //Journal Entry For Supplier
            if($__sub_total > 0){
                // Replacement Manage Account Dr.
                //      Supplier Account Cr.

                //Insert into Direct Account Table
                // Replacement Manage Account Dr.
                account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_supplier_id),$_narration,$_reference,$_transaction,$_date,$_table_name, $_default_rep_manage_account,$__sub_total,0,$_branch_id,$_cost_center,$_name,1);
               //      Supplier Account Cr.
                account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_rep_manage_account),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_supplier_id,0,$__sub_total,$_branch_id,$_cost_center,$_name,2);

            }
            $__total_discount = $request->_in_discount_amount ?? 0;
            if($__total_discount > 0){
            //Default Supplier
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_discount),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_supplier_id,$__total_discount,0,$_branch_id,$_cost_center,$_name,3);
             //Default Discount
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_supplier_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_discount,0,$__total_discount,$_branch_id,$_cost_center,$_name,4);
        
        }
         $__total_vat = (float) $request->_in_vat_amount ?? 0;
        if($__total_vat > 0){
            //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_supplier_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_vat_account,$__total_vat,0,$_branch_id,$_cost_center,$_name,5);
        //Default Supplier
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_vat_account),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_supplier_id,0,$__total_vat,$_branch_id,$_cost_center,$_name,6);
        
        }

        
        // Supplier Account Dr.
        //      Cash/Bank Account cr.

            //Insert into individual_replace_in_accounts And accounts Table
        $_in_payment_amount = $request->_in_payment_amount ?? 0;
        if($_in_payment_amount > 0){
            $_account_type_id =  ledger_to_group_type($request->_supplier_id)->_account_head_id;
            $_account_group_id =  ledger_to_group_type($request->_supplier_id)->_account_group_id;
            $IndividualReplaceInAccount = new IndividualReplaceInAccount();
            $IndividualReplaceInAccount->_no = $_ref_master_id;
            $IndividualReplaceInAccount->_account_type_id = $_account_type_id;
            $IndividualReplaceInAccount->_account_group_id = $_account_group_id;
            $IndividualReplaceInAccount->_ledger_id = $request->_supplier_id;
            $IndividualReplaceInAccount->_cost_center = $request->_cost_center_id;
            $IndividualReplaceInAccount->_branch_id = $request->_branch_id;
            $IndividualReplaceInAccount->_short_narr = 'N/A';
            $IndividualReplaceInAccount->_dr_amount = $_in_payment_amount;
            $IndividualReplaceInAccount->_cr_amount = 0;
            $IndividualReplaceInAccount->_status = 1;
            $IndividualReplaceInAccount->_created_by = $users->id."-".$users->name;
            $IndividualReplaceInAccount->save();


            $indiv_account_id = $IndividualReplaceInAccount->id;

            //Reporting Account Table Data Insert
            
            $_ref_detail_id=$indiv_account_id;
            $_short_narration='N/A';
            $_narration = $request->_note;
            $_reference= $request->_referance;
            $_transaction= 'individual_replace';
            $_date = change_date_format($request->_date);
            $_table_name =$request->_form_name;
            $_account_ledger = $request->_supplier_id;
            $_dr_amount_a = $_in_payment_amount;
            $_cr_amount_a =  0;
            $_branch_id_a = $request->_branch_id;
            $_cost_center_a = $request->_cost_center_id;
            $_name =$users->name;
            account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(7));

            //Cash/Bank Cr
            $_account_type_id =  ledger_to_group_type($request->_in_ledger_id)->_account_head_id;
            $_account_group_id =  ledger_to_group_type($request->_in_ledger_id)->_account_group_id;
            $IndividualReplaceInAccount = new IndividualReplaceInAccount();
            $IndividualReplaceInAccount->_no = $_ref_master_id;
            $IndividualReplaceInAccount->_account_type_id = $_account_type_id;
            $IndividualReplaceInAccount->_account_group_id = $_account_group_id;
            $IndividualReplaceInAccount->_ledger_id = $request->_in_ledger_id;
            $IndividualReplaceInAccount->_cost_center = $request->_cost_center_id;
            $IndividualReplaceInAccount->_branch_id = $request->_branch_id;
            $IndividualReplaceInAccount->_short_narr = 'N/A';
            $IndividualReplaceInAccount->_dr_amount = 0;
            $IndividualReplaceInAccount->_cr_amount = $_in_payment_amount;
            $IndividualReplaceInAccount->_status = 1;
            $IndividualReplaceInAccount->_created_by = $users->id."-".$users->name;
            $IndividualReplaceInAccount->save();


            $indiv_account_id = $IndividualReplaceInAccount->id;

            //Reporting Account Table Data Insert
            
            $_ref_detail_id=$indiv_account_id;
            $_short_narration='N/A';
            $_narration = $request->_note;
            $_reference= $request->_referance;
            $_transaction= 'individual_replace';
            $_date = change_date_format($request->_date);
            $_table_name =$request->_form_name;
            $_account_ledger = $request->_in_ledger_id;
            $_dr_amount_a = 0;
            $_cr_amount_a =  $_in_payment_amount;
            $_branch_id_a = $request->_branch_id;
            $_cost_center_a = $request->_cost_center_id;
            $_name =$users->name;
            account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(8));

            
        }

     

        
        


           

            $_print_value=$request->_print ?? 0;
           DB::commit();
             return redirect()->back()
                    ->with('success','Information save successfully')
                        ->with('_master_id',$_master_id)
                        ->with('_print_value',$_print_value);
           } catch (\Exception $e) {
               DB::rollback();
              return redirect()->back()
                    ->with('success','Something Went Wrong');
            }
        
    }


    public function Detail(Request $request){
        $id = $request->invoice_id;
        $data = IndividualReplaceMaster::with(["_ind_repl_old_item","_ind_repl_in_item","_ind_repl_out_item","_ind_repl_in_account","_ind_repl_out_acount"])->find($id);






        return view('backend.w-item-receive-from-supp.detail',compact('data'));

        //return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IndividualReplaceMaster  $individualReplaceMaster
     * @return \Illuminate\Http\Response
     */
    public function show(IndividualReplaceMaster $individualReplaceMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IndividualReplaceMaster  $individualReplaceMaster
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
        
        $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        $form_settings = IndividualReplaceFormSetting::first();
        $inv_accounts = [];
      //  $p_accounts = AccountLedger::where('_account_head_id',8)->get();
        $dis_accounts = [];
        $capital_accounts = [];

        $p_accounts = AccountLedger::whereIn('_account_head_id',[8,10,5,11,15])->orderBy('_name','ASC')->get();
        $dis_accounts = $p_accounts;
       
        $categories = ItemCategory::orderBy('_name','asc')->get();
        $units = Units::orderBy('_name','asc')->get();
        $warranties = Warranty::where('_status',1)->orderBy('id','asc')->get();

          $_defalut_group_ledgers =\DB::select( " SELECT t1.id,t1._account_head_id,t1._account_group_id,t1._name 
FROM account_ledgers AS t1 
WHERE t1._account_group_id=(SELECT _cash_group FROM general_settings ) " );

          $data = IndividualReplaceMaster::with(["_ind_repl_old_item","_ind_repl_in_item","_ind_repl_out_item","_ind_repl_in_account","_ind_repl_out_acount"])->find($id);

       return view('backend.w-item-receive-from-supp.edit',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','categories','units','capital_accounts','_defalut_group_ledgers','warranties','data'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IndividualReplaceMaster  $individualReplaceMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
                '_form_name' => 'required|max:255',
                '_date' => 'required',
                '_order_ref_id' => 'required',
                '_supplier_id' => 'required',
                '_in_item_id' => 'required',
        ]);
      //  return $request->all();

        $id = $request->_master_id ?? 0;

        $users = Auth::user();
          $settings = GeneralSettings::first();
            $_lock = $settings->_auto_lock ?? 0;
             DB::beginTransaction();
            try {
            $_date = change_date_format($request->_date);
            $IndividualReplaceMaster = IndividualReplaceMaster::find($id);
            $IndividualReplaceMaster->_order_number = $request->_order_number ?? '';
            $IndividualReplaceMaster->_date = $_date;
            $IndividualReplaceMaster->_time = date('H:i:s'); 
            $IndividualReplaceMaster->_order_ref_id = $request->_order_ref_id ?? '';
            $IndividualReplaceMaster->_note = $request->_note ?? '';
            $IndividualReplaceMaster->_referance = $request->_referance ?? '';
            $IndividualReplaceMaster->_address = $request->_address ?? '';
            $IndividualReplaceMaster->_phone = $request->_phone ?? '';
           
            $IndividualReplaceMaster->_customer_id  = $request->_customer_id  ?? '';
            $IndividualReplaceMaster->_supplier_id  = $request->_supplier_id  ?? '';
            $IndividualReplaceMaster->_sales_man_id  = $request->_sales_man_id  ?? '';
            $IndividualReplaceMaster->_delivery_man_id  = $request->_delivery_man_id  ?? '';

            $IndividualReplaceMaster->_user_id  = $users->id  ?? '';
            $IndividualReplaceMaster->_created_by = $users->id."-".$users->name;
            $IndividualReplaceMaster->_user_name = $users->name;
            $IndividualReplaceMaster->_sales_type = 1;

            $IndividualReplaceMaster->_branch_id = $request->_branch_id ?? 1;
            $IndividualReplaceMaster->_store_id = $request->_store_id ?? 1;
            $IndividualReplaceMaster->_cost_center_id = $request->_cost_center_id ?? 1;
            $IndividualReplaceMaster->_apporoved_by = $request->_apporoved_by ?? $users->id;
            $IndividualReplaceMaster->_service_by = $request->_service_by ?? $users->id;

            $IndividualReplaceMaster->_status = $request->_status ?? 1;
            $IndividualReplaceMaster->_lock = $_lock ?? 0;
            $IndividualReplaceMaster->save();

            $_master_id = $IndividualReplaceMaster->id;
            $_purchase_detail_id = $_master_id;
            $purchase_id = $_master_id;

            $_order_number = ind_rep_prefix().$_master_id;
            IndividualReplaceMaster::where('id',$_master_id)->update(['_order_number'=>$_order_number]);


            $barcode_string = $request->_in_barcode ?? '';

                $item_info = Inventory::where('id',$request->_in_item_id)->first();
                $ProductPriceList = ProductPriceList::find($request->_in_p_p_l_id);
                $ProductPriceList->_item_id = $request->_in_item_id;
                $ProductPriceList->_item = $item_info->_item ?? '';
                $ProductPriceList->_barcode =$barcode_string;

                $ProductPriceList->_qty = $request->_in_qty ?? 1;
                $ProductPriceList->_sales_rate = $item_info->_sales_rate ?? 0;
                $ProductPriceList->_pur_rate = $item_info->_rate ?? 0;
                $ProductPriceList->_unit_id = $item_info->_unit_id ?? 1;
                $ProductPriceList->_unique_barcode = $item_info->_unique_barcode ?? 0;
                $ProductPriceList->_warranty = $item_info->_warranty ?? 0;
                $ProductPriceList->_input_type = "individual_replace";
                
                $ProductPriceList->_sales_discount = $item_info->_discount ?? 0;
                $ProductPriceList->_p_discount_input = $item_info->_discount ?? 0;
                $ProductPriceList->_p_discount_amount = $item_info->_discount_amount ?? 0;
                $ProductPriceList->_p_vat = $item_info->_vat ?? 0;
                $ProductPriceList->_p_vat_amount = $item_info->_vat_amount ?? 0;
                $ProductPriceList->_sales_vat = $item_info->_vat ?? 0;;
                $ProductPriceList->_value =$item_info->_value ?? 0;
                $ProductPriceList->_purchase_detail_id =$_purchase_detail_id;
                $ProductPriceList->_master_id = $purchase_id;
                $ProductPriceList->_branch_id = $item_info->_branch_id ?? 1;
                $ProductPriceList->_cost_center_id = $item_info->_cost_center_id ?? 1;
                $ProductPriceList->_store_salves_id = $item_info->_store_salves_id ?? '';
                $ProductPriceList->_store_id = $item_info->_store_id ?? 1;
                $ProductPriceList->_status =1;
                $ProductPriceList->_created_by = $users->id."-".$users->name;
                $ProductPriceList->save();
                $product_price_id =  $ProductPriceList->id;
                $_in_p_p_l_id =  $ProductPriceList->id;

                $_unique_barcode =  $ProductPriceList->_unique_barcode;

                     if($_unique_barcode ==1){
                         if($barcode_string !=""){

                               $barcode_array=  explode(",",$barcode_string);
                               $_qty = 1;
                               $_stat = 1;
                               $_return=0;
                               $p=0;
                               foreach ($barcode_array as $_b_v) {
                                _barcode_insert_update('BarcodeDetail',$product_price_id,$request->_in_item_id,$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,$_return,$p);
                                _barcode_insert_update('RepInBarcode',$product_price_id,$request->_in_item_id,$purchase_id,$_purchase_detail_id,$_qty,$_b_v,$_stat,$_return,$p);
                                 
                               }
                            }
                     }
                
                ItemInventory::where('_transection',"Replacement In From Supplier")
                                ->where('_transection_ref',$purchase_id)
                                ->where('_transection_detail_ref_id',$_purchase_detail_id)
                                ->update(['_status'=>0]);

                $ItemInventory = new ItemInventory();
                $ItemInventory->_item_id =  $item_info->id;
                $ItemInventory->_item_name =  $item_info->_item ?? '';
                $ItemInventory->_unit_id =  $item_info->_unit_id ?? '';
                $ItemInventory->_category_id = _item_category($item_info->id);
                $ItemInventory->_date = change_date_format($request->_date);
                $ItemInventory->_time = date('H:i:s');
                $ItemInventory->_transection = "Replacement In From Supplier";
                $ItemInventory->_transection_ref = $purchase_id;
                $ItemInventory->_transection_detail_ref_id = $_purchase_detail_id;
                $ItemInventory->_qty = $request->_in_qty;
                $ItemInventory->_rate = $item_info->_sales_rate ?? 0;
                $ItemInventory->_unit_id = $item_info->_unit_id ?? '';
                $ItemInventory->_cost_rate = $item_info->_rate ?? 0;
                $ItemInventory->_cost_value = ($request->_in_qty*$item_info->_rate);
                $ItemInventory->_value = ($request->_in_qty*$item_info->_sales_rate) ?? 0;
                $ItemInventory->_branch_id = $item_info->_branch_id ?? 1;
                $ItemInventory->_store_id = $item_info->_store_id ?? 1;
                $ItemInventory->_cost_center_id = $item_info->_cost_center_id ?? 1;
                $ItemInventory->_store_salves_id = $item_info->_store_salves_id ?? '';
                $ItemInventory->_status = 1;
                $ItemInventory->_created_by = $users->id."-".$users->name;
                $ItemInventory->save(); 
                inventory_stock_update($item_info->id);



            //Item IN
            $_in_item_master_id = $request->_in_item_master_id;
            $IndividualReplaceInItem = IndividualReplaceInItem::find($_in_item_master_id);
            $IndividualReplaceInItem->_item_id = $request->_in_item_id;
            $IndividualReplaceInItem->_p_p_l_id = $_in_p_p_l_id ?? 0;
            $IndividualReplaceInItem->_qty = $request->_in_qty ?? 0;
            $IndividualReplaceInItem->_rate = $request->_in_rate ?? 0;
            $IndividualReplaceInItem->_sales_rate = $request->_in_sales_rate ?? 0;
            $IndividualReplaceInItem->_discount = $request->_in_discount ?? 0;
            $IndividualReplaceInItem->_discount_amount = $request->_in_discount_amount ?? 0;
            $IndividualReplaceInItem->_vat = $request->_in_vat ?? 0;
            $IndividualReplaceInItem->_vat_amount = $request->_in_vat_amount ?? 0;
            $IndividualReplaceInItem->_value = $request->_in_value ?? 0;
             $IndividualReplaceInItem->_adjustment_amount = $request->_in_adjustment_amount ?? 0;
            $IndividualReplaceInItem->_net_total = $request->_in_net_total ?? 0;
            $IndividualReplaceInItem->_barcode = $request->_in_barcode ?? '';
            $IndividualReplaceInItem->_short_note = $request->_in_short_note ?? '';
            $IndividualReplaceInItem->_manufacture_date = $request->_in_manufacture_date ?? '';
            $IndividualReplaceInItem->_expire_date = $request->_in_expire_date ?? '';
            $IndividualReplaceInItem->_warranty = $request->_in_warranty;
            $IndividualReplaceInItem->_no = $_master_id;

            $IndividualReplaceInItem->_purchase_invoice_no = $request->_in_purchase_invoice_no ?? 0;
            $IndividualReplaceInItem->_purchase_detail_id = $request->_in_purchase_detail_id ?? 0;

            $IndividualReplaceInItem->_branch_id = $request->_branch_id ?? 1;
            $IndividualReplaceInItem->_store_id = $request->_in_store_id ?? 1;
            $IndividualReplaceInItem->_cost_center_id = $request->_cost_center_id ?? 0;
            $IndividualReplaceInItem->_store_salves_id = $request->_store_salves_id ?? 0;

            $IndividualReplaceInItem->_status = 1;
            $IndividualReplaceInItem->_in_status = $request->_in_status ?? 0;
            $IndividualReplaceInItem->_in_ledger_id = $request->_in_ledger_id ?? 0;
            $IndividualReplaceInItem->_in_payment_amount = $request->_in_payment_amount ?? 0;
            $IndividualReplaceInItem->save();


            

            //Item OLD
            $_old_item_master_id = $request->_old_item_master_id;

            $IndividualReplaceOldItem = IndividualReplaceOldItem::find($_old_item_master_id);
            $IndividualReplaceOldItem->_item_id = $request->_old_item_id;
            $IndividualReplaceOldItem->_p_p_l_id = $request->_old_p_p_l_id ?? 0;
            $IndividualReplaceOldItem->_qty = $request->_old_qty ?? 0;
            $IndividualReplaceOldItem->_rate = $request->_old_rate ?? 0;
            $IndividualReplaceOldItem->_sales_rate = $request->_old_sales_rate ?? 0;
            $IndividualReplaceOldItem->_discount = $request->_old_discount ?? 0;
            $IndividualReplaceOldItem->_discount_amount = $request->_old_discount_amount ?? 0;
            $IndividualReplaceOldItem->_vat = $request->_old_vat ?? 0;
            $IndividualReplaceOldItem->_vat_amount = $request->_old_vat_amount ?? 0;
            $IndividualReplaceOldItem->_value = $request->_old_value ?? 0;
            $IndividualReplaceOldItem->_barcode = $request->_old_barcode ?? '';
            $IndividualReplaceOldItem->_short_note = $request->_old_short_note ?? '';
            $IndividualReplaceOldItem->_manufacture_date = $request->_old_manufacture_date ?? '';
            $IndividualReplaceOldItem->_expire_date = $request->_old_expire_date ?? '';
            $IndividualReplaceOldItem->_warranty_date = $request->_warranty_date ?? '';
            $IndividualReplaceOldItem->_warranty_comment = $request->_old_warranty_comment ?? '';
            $IndividualReplaceOldItem->_warranty = $request->_old_warranty ?? 0;
            $IndividualReplaceOldItem->_no = $_master_id;

            $IndividualReplaceOldItem->_purchase_invoice_no = $request->_old_purchase_invoice_no ?? 0;
            $IndividualReplaceOldItem->_purchase_detail_id = $request->_old_purchase_detail_id ?? 0;

            $IndividualReplaceOldItem->_branch_id = $request->_branch_id ?? 1;
            $IndividualReplaceOldItem->_store_id = $request->_store_id ?? 1;
            $IndividualReplaceOldItem->_cost_center_id = $request->_cost_center_id ?? 0;
            $IndividualReplaceOldItem->_store_salves_id = $request->_store_salves_id ?? 0;

            $IndividualReplaceOldItem->_status = 1;
            $IndividualReplaceOldItem->save();


            IndividualReplaceInAccount::where('_no',$_master_id)                               
                ->update(['_status'=>0]);

            IndividualReplaceOutAccount::where('_no',$_master_id)                               
                ->update(['_status'=>0]);


            Accounts::where('_ref_master_id',$_master_id)
                    ->where('_table_name','individual_replace_masters')
                     ->update(['_status'=>0]);


            $settings = IndividualReplaceFormSetting::first();
            $_default_rep_manage_account = $settings->_default_rep_manage_account;
            $_default_sales_dicount = $settings->_default_sales_dicount;
            $_default_cost_of_solds = $settings->_default_cost_of_solds;
            $_default_discount = $settings->_default_discount;
            $_default_vat_account = $settings->_default_vat_account;

            $_table_name = $request->_form_name;
            $_cost_center = $request->_cost_center_id;
            $_name = Auth::user()->name ?? '';
            $_narration = $request->_note ?? '';
            $_reference = $request->_referance ?? '';
            $_branch_id = $request->_branch_id ?? '';
            $__sub_total = $request->_in_value ?? 0;
            $_transaction = 'individual_replace';

            $_ref_master_id = $_master_id;
            $_ref_detail_id = $_master_id;

            //Journal Entry For Supplier
            if($__sub_total > 0){
                // Replacement Manage Account Dr.
                //      Supplier Account Cr.

                //Insert into Direct Account Table
                // Replacement Manage Account Dr.
                account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_supplier_id),$_narration,$_reference,$_transaction,$_date,$_table_name, $_default_rep_manage_account,$__sub_total,0,$_branch_id,$_cost_center,$_name,1);
               //      Supplier Account Cr.
                account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_rep_manage_account),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_supplier_id,0,$__sub_total,$_branch_id,$_cost_center,$_name,2);

            }
            $__total_discount = $request->_in_discount_amount ?? 0;
            if($__total_discount > 0){
            //Default Supplier
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_discount),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_supplier_id,$__total_discount,0,$_branch_id,$_cost_center,$_name,3);
             //Default Discount
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_supplier_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_discount,0,$__total_discount,$_branch_id,$_cost_center,$_name,4);
        
        }
         $__total_vat = (float) $request->_in_vat_amount ?? 0;
        if($__total_vat > 0){
            //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_supplier_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_vat_account,$__total_vat,0,$_branch_id,$_cost_center,$_name,5);
        //Default Supplier
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_vat_account),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_supplier_id,0,$__total_vat,$_branch_id,$_cost_center,$_name,6);
        
        }

        
        // Supplier Account Dr.
        //      Cash/Bank Account cr.

            //Insert into individual_replace_in_accounts And accounts Table
        $_in_payment_amount = $request->_in_payment_amount ?? 0;
        if($_in_payment_amount > 0){
            $_account_type_id =  ledger_to_group_type($request->_supplier_id)->_account_head_id;
            $_account_group_id =  ledger_to_group_type($request->_supplier_id)->_account_group_id;
            $IndividualReplaceInAccount = new IndividualReplaceInAccount();
            $IndividualReplaceInAccount->_no = $_ref_master_id;
            $IndividualReplaceInAccount->_account_type_id = $_account_type_id;
            $IndividualReplaceInAccount->_account_group_id = $_account_group_id;
            $IndividualReplaceInAccount->_ledger_id = $request->_supplier_id;
            $IndividualReplaceInAccount->_cost_center = $request->_cost_center_id;
            $IndividualReplaceInAccount->_branch_id = $request->_branch_id;
            $IndividualReplaceInAccount->_short_narr = 'N/A';
            $IndividualReplaceInAccount->_dr_amount = $_in_payment_amount;
            $IndividualReplaceInAccount->_cr_amount = 0;
            $IndividualReplaceInAccount->_status = 1;
            $IndividualReplaceInAccount->_created_by = $users->id."-".$users->name;
            $IndividualReplaceInAccount->save();


            $indiv_account_id = $IndividualReplaceInAccount->id;

            //Reporting Account Table Data Insert
            
            $_ref_detail_id=$indiv_account_id;
            $_short_narration='N/A';
            $_narration = $request->_note;
            $_reference= $request->_referance;
            $_transaction= 'individual_replace';
            $_date = change_date_format($request->_date);
            $_table_name =$request->_form_name;
            $_account_ledger = $request->_supplier_id;
            $_dr_amount_a = $_in_payment_amount;
            $_cr_amount_a =  0;
            $_branch_id_a = $request->_branch_id;
            $_cost_center_a = $request->_cost_center_id;
            $_name =$users->name;
            account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(7));

            //Cash/Bank Cr
            $_account_type_id =  ledger_to_group_type($request->_in_ledger_id)->_account_head_id;
            $_account_group_id =  ledger_to_group_type($request->_in_ledger_id)->_account_group_id;
            $IndividualReplaceInAccount = new IndividualReplaceInAccount();
            $IndividualReplaceInAccount->_no = $_ref_master_id;
            $IndividualReplaceInAccount->_account_type_id = $_account_type_id;
            $IndividualReplaceInAccount->_account_group_id = $_account_group_id;
            $IndividualReplaceInAccount->_ledger_id = $request->_in_ledger_id;
            $IndividualReplaceInAccount->_cost_center = $request->_cost_center_id;
            $IndividualReplaceInAccount->_branch_id = $request->_branch_id;
            $IndividualReplaceInAccount->_short_narr = 'N/A';
            $IndividualReplaceInAccount->_dr_amount = 0;
            $IndividualReplaceInAccount->_cr_amount = $_in_payment_amount;
            $IndividualReplaceInAccount->_status = 1;
            $IndividualReplaceInAccount->_created_by = $users->id."-".$users->name;
            $IndividualReplaceInAccount->save();


            $indiv_account_id = $IndividualReplaceInAccount->id;

            //Reporting Account Table Data Insert
            
            $_ref_detail_id=$indiv_account_id;
            $_short_narration='N/A';
            $_narration = $request->_note;
            $_reference= $request->_referance;
            $_transaction= 'individual_replace';
            $_date = change_date_format($request->_date);
            $_table_name =$request->_form_name;
            $_account_ledger = $request->_in_ledger_id;
            $_dr_amount_a = 0;
            $_cr_amount_a =  $_in_payment_amount;
            $_branch_id_a = $request->_branch_id;
            $_cost_center_a = $request->_cost_center_id;
            $_name =$users->name;
            account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(8));

            
        }

       


           

            $_print_value=$request->_print ?? 0;
            DB::commit();
             return redirect()->back()
                    ->with('success','Information save successfully')
                        ->with('_master_id',$_master_id)
                        ->with('_print_value',$_print_value);
           } catch (\Exception $e) {
               DB::rollback();
              return redirect()->back()
                    ->with('success','Something Went Wrong');
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IndividualReplaceMaster  $individualReplaceMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(IndividualReplaceMaster $individualReplaceMaster)
    {
        //
    }
}
