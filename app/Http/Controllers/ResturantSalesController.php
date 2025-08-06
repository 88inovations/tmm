<?php

namespace App\Http\Controllers;

use App\Models\ResturantSales;
use App\Models\TableInfo;
use App\Models\Sales;
use App\Models\ResturantSalesAccount;
use App\Models\ResturantDetails;
use App\Models\VoucherMaster;
use App\Models\AccountLedger;
use App\Models\AccountGroup;
use App\Models\AccountHead;
use App\Models\Accounts;
use App\Models\Branch;
use App\Models\VoucherType;
use App\Models\VoucherMasterDetail;
use App\Models\StoreHouse;
use App\Models\PurchaseReturnFormSetting;
use App\Models\PurchaseDetail;
use App\Models\PurchaseReturnAccount;
use App\Models\PurchaseReturnDetail;
use App\Models\ProductPriceList;
use App\Models\ItemInventory;
use App\Models\Inventory;
use App\Models\ItemCategory;
use App\Models\Units;
use App\Models\ResturantFormSetting;
use App\Models\SalesReturn;
use App\Models\SalesReturnDetail;
use App\Models\SalesReturnAccount;
use App\Models\SalesReturnFormSetting;
use App\Models\GeneralSettings;
use App\Models\BarcodeDetail;
use App\Models\SalesBarcode;
use App\Models\Warranty;
use App\Models\Kitchen;
use App\Models\KitchenFinishGoods;
use App\Models\KitchenRowGoods;
use App\Models\MusakFourPointThreeInput;
use App\Models\MusakFourPointThreeAddition;
use App\Models\MusakFourPointThree;
use Auth;
use DB;
use Illuminate\Http\Request;
use Session;

class ResturantSalesController extends Controller
{

         function __construct()
    {
         $this->middleware('permission:restaurant-sales-list|restaurant-sales-create|restaurant-sales-edit|restaurant-sales-delete|restaurant-sales-print', ['only' => ['index','store']]);
         $this->middleware('permission:restaurant-sales-print', ['only' => ['salesPrint']]);
         $this->middleware('permission:restaurant-sales-create', ['only' => ['create','store']]);
         $this->middleware('permission:restaurant-sales-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:restaurant-sales-delete', ['only' => ['destroy']]);
         $this->page_name = "Sales Invoice";
    }
    


    public function restaurantEdit(Request $request){
        $id = $request->order_id;
        $data =  ResturantSales::with(['_master_branch','_master_details','s_account','_ledger'])->where('_lock',0)->find($id);
        

        return $data;
    }
    public function recentRestaurntSalesList(Request $request){
        $_store_id= $request->_store_id ?? 1;
        $_cost_center_id= $request->_cost_center_id ?? 1;
        $_branch_id= $request->_branch_id ?? 1;
        $data = ResturantSales::with(["_ledger"])
                    ->select('id','_date','_time','_ledger_id','_total','_order_number','_table_id','_served_by_ids','_sales_spot')
                    ->where('_kitchen_status',0)
                    ->where('_sales_spot',2)
                    ->where('_store_id',$_store_id)
                    ->where('_cost_center_id',$_cost_center_id)
                    ->where('_branch_id',$_branch_id)
                    ->orderBy('id','DESC')
                    ->get();
        $tables_ids = [];
        foreach ($data as $key => $value) {
            
        }

        return json_encode($data);
    }


    public function book_table_list_ajax(Request $request){
        $datas = ResturantSales::select("id",'_table_id')->where('_lock',0)->get();
        return json_encode($datas);
    }

    public function restaurantPos(){
        $users = Auth::user();
        $page_name = $this->page_name;

        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $store_houses = StoreHouse::select('id','_name')->whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
         $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
        $form_settings = ResturantFormSetting::first();
      //  $categories = ItemCategory::with(['_parents'])->select('id','_name','_parent_id')->orderBy('_name','asc')->get();
        $units = Units::select('id','_name','_code')->orderBy('_name','asc')->get();
        $account_groups = [];
        $tables = \DB::select(" SELECT id,_name,_number_of_chair,_status FROM `table_infos` WHERE _branch_id IN (".$users->branch_ids.") AND _status=1 ");
        $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->where('_status',1)->get();

         $_steward_group = \DB::table("default_ledgers")->select('_steward_group')->first();
        $_stewards= AccountLedger::select('id','_name','_phone','_alious')->where('_account_group_id',$_steward_group->_steward_group ?? 0)->get();
         $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));

         $_cateogry_ids =[];

        $permited_category = \DB::select(" SELECT `_category_ids` FROM `restaurant_category_settings` WHERE `_branch_ids` IN(".$users->branch_ids.") ");
        foreach ($permited_category as $key => $inside_array) {
            $array_category = explode(',', $inside_array->_category_ids);
            foreach ($array_category as $key => $value) {
                array_push($_cateogry_ids, intval($value));
            }
           
        }
      
                                        
       $categories = ItemCategory::with(['_parents'])->select('id','_name','_parent_id')
       ->whereIn('id',$_cateogry_ids ?? [])->orderBy('_name','ASC')->get();

        return view('backend.restaurant-pos.pos',compact('permited_branch','store_houses','account_types','form_settings','categories','units','_warranties','account_groups','tables','_stewards','permited_costcenters'));
    }
 public function posPaymentRow(Request $request){
        $row_count = $request->payment_row_count;
        $settings = GeneralSettings::first();
        $payment_accounts = \DB::select(" SELECT id,_name FROM account_ledgers WHERE _account_group_id IN($settings->_bank_group,$settings->_cash_group) order by id ASC ");

        return view('backend.pos.payment_row',compact('payment_accounts','row_count'));
    }


    public function posSalesSave(Request $request){

     //return $request->all();

        $_master_sales_id = $request->_master_sales_id ?? 0;
        
         $users = Auth::user();
        $settings = GeneralSettings::first();
        $__total = $request->tot_grand ?? 0;
        $_main_ledger_id = $request->_main_ledger_id;
        $ledger_info = AccountLedger::find($_main_ledger_id);
        $_main_branch = $request->_main_branch;
        $_sales_spot = $request->_sales_spot;
        $_main_store = $request->_main_store;
        $hidden_rowcount = $request->hidden_rowcount;
        $_line_total_discount = $request->_line_total_discount ?? 0;
        $_line_vat_total = $request->_line_vat_total ?? 0;
        $_reference = $request->_reference;
        $__discount_input = $request->tot_disc ?? 0;
        $__sub_total = $request->tot_amt ?? 0;
        $delivery_company_id = $request->delivery_company_id ?? 0;
        $_cost_center_id = $request->_main_cost_center_id ?? 1;
        $_delivery_man_id = 0;
        $_sales_man_id = 0;
        $_sales_type = $request->_status ?? 'sales';
        $_lock = $settings->_auto_lock ?? 0;
        $_date = date('Y-m-d');
        $_time = date('h:m:s');
        $_user = $users->name ?? '';
        $_address = $ledger_info->_address ?? '';
        $_phone = $ledger_info->_phone ?? '';
        $_created_by =$users->id."-".$users->_name ?? '';
        $_status = 1;
        $_note ='Restaurant Sales From Pos';



       // return $request->all();
     // DB::beginTransaction();
     //  try {

        $_p_balance = _l_balance_update($_main_ledger_id);

         $_sales_man_id = $_sales_man_id;
         $__total_discount = ((float) $__discount_input)  + ((float)$_line_total_discount);
         $_other_charge = $request->_other_charge ?? 0;
         $_service_charge = $request->_service_charge ?? 0;
         $_delivery_charge = $request->_delivery_charge ?? 0;
            $_table_id = $request->_table_id ?? [];
            $__table_id_ids=0;;
            if(sizeof($_table_id) > 0){
                $__table_id_ids  =  implode(",",$_table_id);
            }


            $_served_by_ids = $request->_served_by_ids ?? [];
            $_served_by_ids_ids=0;
            if(sizeof($_served_by_ids) > 0){
                $_served_by_ids_ids  =  implode(",",$_served_by_ids);
            }

            $_delivery_status = $request->_delivery_status ?? 1;


        
       
        if($_master_sales_id ==0){
            $Sales = new ResturantSales();
        }else{
            $Sales = ResturantSales::find($_master_sales_id);
        }
        $Sales->_date = change_date_format($_date);
        $Sales->_time = date('H:i:s');
        $Sales->_order_ref_id = $request->_order_ref_id ?? null;
        $Sales->_order_number = $request->_order_number ?? '';
        $Sales->_referance = $request->_referance ?? '';
        $Sales->_ledger_id = $_main_ledger_id;
        $Sales->_user_id = $users->id;
        $Sales->_created_by = $users->id."-".$users->name;
        $Sales->_user_id = $users->id;
        $Sales->_user_name = $users->name;
        $Sales->_note = $_note;
        $Sales->_sub_total = $__sub_total;
        $Sales->_discount_input = $__discount_input;
        $Sales->_total_discount = $__total_discount;
        $Sales->_other_charge = $_other_charge;
        $Sales->_service_charge = $_service_charge;
        $Sales->_delivery_charge = $_delivery_charge;
        $Sales->_delivery_status = $request->_delivery_status ?? 1;
        $Sales->_service_charge = $request->_service_charge ?? 0;
        $Sales->_other_charge = $request->_other_charge ?? 0;
        $Sales->_delivery_charge = $request->_delivery_charge ?? 0;
        $Sales->_table_id = $__table_id_ids ?? 0;
        $Sales->_served_by_ids = $_served_by_ids_ids ?? 0;
        $Sales->_sales_spot = $_sales_spot ?? 1;
        $Sales->delivery_company_id = $delivery_company_id ?? 0;

        $Sales->_total_vat = $_line_vat_total;
        $Sales->_total =  $__total;
        $Sales->_branch_id = $_main_branch;
        $Sales->_address = $users->_address;
        $Sales->_phone = $users->_phone;
        $Sales->_delivery_man_id = $_delivery_man_id ?? 0;
        $Sales->_sales_man_id = $_sales_man_id ?? 0;
        $Sales->_sales_type = $_sales_type ?? 'sales';
        $Sales->_status = 1;
        $Sales->_lock = $request->_final_satalement ?? 0;

         $Sales->_cost_center_id = $_cost_center_id ?? 1;
        $Sales->_store_id = $_main_store ?? 1;

        $Sales->save();
        $_master_id = $Sales->id; 


        //Order Send to Kitchen
        if($_master_sales_id ==0){
            $Kitchen = new Kitchen();
        }else{
            $Kitchen = Kitchen::where("_res_sales_id",$_master_sales_id)->first();
        }
        
        $Kitchen->_res_sales_id = $_master_id;
        $Kitchen->_status = 0;
        $Kitchen->_lock = 0;
        $Kitchen->_created_by = $users->id."-".$users->name;
        $Kitchen->save();

        $_kitchen_order_id = $Kitchen->id; 


        //here i need to start

        //Product price list table update if sales edit
        //Previous sales item detail for finished Goods
        if($_master_sales_id !=0){
            $_previous_finished_goods = ResturantDetails::where('_no',$_master_sales_id)
                                                        ->where('_kitchen_item',0)
                                                        ->where('_status',1)
                                                        ->get();
            foreach ($_previous_finished_goods as $key => $previous_item) {
                    $p_product_list = ProductPriceList::where('id',$previous_item->_p_p_l_id)->first();
                    $_p_new_qty = $p_product_list->_qty ?? 0;
                    $_p_new_status = (($_p_new_qty + $previous_item->_qty ?? 0) > 0) ? 1 : 0;
                    $p_product_list->_qty = ($_p_new_qty + $previous_item->_qty ?? 0);
                    $p_product_list->_status = $_p_new_status;
                    $p_product_list->save();
            }

        }

                  

        //###########################
        // Purchase Master information Save End
        //###########################

        //###########################
        // Purchase Details information Save Start
        //###########################
        
    ResturantDetails::where("_no",$_master_id)->update(['_status'=>0]);
    KitchenFinishGoods::where('_no',$_kitchen_order_id)->update(['_status'=>0]);
    KitchenRowGoods::where('_no',$_kitchen_order_id)->update(['_status'=>0]);
    ItemInventory::where('_transection',"Restaurant Sales")->where('_transection_ref',$_master_id)->update(['_status'=>0]);

    ResturantSalesAccount::where('_no',$_master_id)->update(['_status'=>0]);
    Accounts::where('_ref_master_id',$_master_id)->where('_table_name','resturant_sales')->update(['_status'=>0]);  
    Accounts::where('_ref_master_id',$_master_id)
                    ->whereIn('_table_name',['restaurant_sales_accounts','resturant_sales_accounts'])
                    ->update(['_status'=>0]);  


    SalesBarcode::where('_no_id',$_master_id)
                  ->update(['_status'=>0,'_qty'=>0]);



  
    $__total_vat =$_line_vat_total;
    $_total_cost_value=0;

    $row_count = intval($_POST["hidden_rowcount"]) ;
    for($i=0; $i<$row_count; $i++){
        $tr_row_id = $_POST["tr_item_id_".$i.""];
        $_item_ids = $_POST["tr_item_id_".$i.""];
        $_p_p_l_id = $_POST["_p_p_l_id_".$i.""] ?? 0;
        $_res_sales_detail_row_id =  $_POST["hold_row_".$i.""] ?? 0;
        
            $ProductPriceList = ProductPriceList::find($_p_p_l_id);
            $_purchase_invoice_nos =$ProductPriceList->_master_id ?? 0;
            $_purchase_detail_ids =$ProductPriceList->_purchase_detail_id ?? 0 ;
            $_manufacture_dates =$ProductPriceList->_manufacture_date ?? '' ;
            $_expire_dates =$ProductPriceList->_expire_date ?? '' ;
            $_warrantys =$ProductPriceList->_warranty ?? 0 ;
            
            
            $item_info = Inventory::where('id',$_item_ids)->first();

            $_qtys = (float) $_POST["item_qty_".$tr_row_id.""] ?? 0;
            $_sales_rates = (float) $_POST["sales_price_".$i.""] ?? 0;
            $item_discount = (float) $_POST["item_discount_".$i.""] ?? 0;
            $vat = (float) $_POST["td_data_".$i."_11"] ?? 0;
            $sub_total = (float) $_POST["td_data_".$i."_4"] ?? 0;
            $tr_tax_type = $_POST["tr_tax_type_".$i.""] ?? 0;
            $tr_tax_id = (float) $_POST["tr_tax_id_".$i.""] ?? 0;
            $tax_rate= (float) $_POST["tr_tax_value_".$i.""] ?? 0;
           
            if($tax_rate > 0){
                $_vat_amount= (($_sales_rates*$_qtys)*$tax_rate)/100;
            }else{
                $_vat_amount= 0;
            }

            $__sub_total +=$sub_total;
            
            $line_description = $_POST["description_".$i.""] ?? '';
            $item_discount_type = $_POST["item_discount_type_".$i.""] ?? '';
            $_rates = $_POST["tr_item_cost_".$i.""] ?? '';
            $item_discount_ = $_POST["item_discount_".$i.""] ?? 0;
            
            $item_discount_input = $_POST["item_discount_input_".$i.""] ?? 0;
            if($item_discount_type=="Fixed"){
            $item_discount_input =0;    
            }
            $_barcode = $_POST["_barcode_".$i.""] ?? '';

                    $_total_cost_value += ($_rates*$_qtys);
                    $_values = ($_sales_rates*$_qtys) ?? 0;
                    if($_res_sales_detail_row_id ==0){
                        $ResturantDetails = new ResturantDetails();
                    }else{
                        $ResturantDetails = ResturantDetails::find($_res_sales_detail_row_id);
                    }
                    $ResturantDetails->_item_id = $_item_ids;
                    $ResturantDetails->_p_p_l_id = $_p_p_l_id;
                    $ResturantDetails->_purchase_invoice_no = $_purchase_invoice_nos;
                    $ResturantDetails->_purchase_detail_id = $_purchase_detail_ids;
                    $ResturantDetails->_qty = $_qtys;
                    $barcode_string=$_barcode ?? '';
                    $ResturantDetails->_barcode = $barcode_string;

                    $ResturantDetails->_unit_conversion = 1;
                    $ResturantDetails->_transection_unit = $item_info->_unit_id;
                    $ResturantDetails->_base_unit = $item_info->_unit_id;
                    $ResturantDetails->_base_rate = $_sales_rates ?? 0;



                    $ResturantDetails->_manufacture_date = $_manufacture_dates;
                    $ResturantDetails->_expire_date = $_expire_dates;
                    $ResturantDetails->_rate = $_rates ?? 0;
                    $ResturantDetails->_warranty = $_warrantys ?? 0;
                    $ResturantDetails->_sales_rate = $_sales_rates ?? 0;
                    $ResturantDetails->_discount = $item_discount_input ?? 0;
                    $ResturantDetails->_discount_amount = $item_discount_ ?? 0;
                    $ResturantDetails->_vat = $tax_rate ?? 0;
                    $ResturantDetails->_vat_amount = $_vat_amount ?? 0;
                    $ResturantDetails->_value =$_values ?? 0;
                    $ResturantDetails->_store_id = $_main_store ?? 1;
                    $ResturantDetails->_cost_center_id = $_main_cost_center ?? 1;
                    $ResturantDetails->_store_salves_id = $_store_salves_ids ?? '';
                    $ResturantDetails->_branch_id = $_main_branch_id_detail ?? 1;
                    $ResturantDetails->_no = $_master_id;
                    $ResturantDetails->_status = 1;
                    $ResturantDetails->_kitchen_item = $item_info->_kitchen_item ?? 0;
                    $ResturantDetails->_created_by = $users->id."-".$users->name;
                    $ResturantDetails->save();
                    $_sales_details_id = $ResturantDetails->id;

                   

                    //Item Detail Data send to kitchen_finish_goods
                if($item_info->_kitchen_item ==1){
                    $KitchenFinishGoods = new KitchenFinishGoods();
                    $KitchenFinishGoods->_item_id  = $_item_ids;
                    $KitchenFinishGoods->_p_p_l_id  = $_p_p_l_id ?? 0;
                    $KitchenFinishGoods->_qty  = $_qtys ?? 0;
                    $KitchenFinishGoods->_rate  = $_rates ?? 0;
                    $KitchenFinishGoods->_sales_rate  = $_sales_rates ?? 0;
                    $KitchenFinishGoods->_discount  = $_discounts ?? 0;
                    $KitchenFinishGoods->_discount_amount  = $_discount_amounts ?? 0;
                    $KitchenFinishGoods->_vat  = $_vats ?? 0;
                    $KitchenFinishGoods->_vat_amount  = $_vat_amounts ?? 0;
                    $KitchenFinishGoods->_value  = $_values ?? 0;
                    $KitchenFinishGoods->_warranty  = $_warrantys ?? 0;
                    $KitchenFinishGoods->_barcode  = $_barcodes ?? '';
                    $KitchenFinishGoods->_purchase_invoice_no  = $_master_id;
                    $KitchenFinishGoods->_purchase_detail_id  = $_sales_details_id;
                    $KitchenFinishGoods->_manufacture_date  = $_manufacture_dates ?? '';
                    $KitchenFinishGoods->_expire_date  = $_expire_dates ?? '';
                    $KitchenFinishGoods->_no  = $_kitchen_order_id;
                    $KitchenFinishGoods->_branch_id  = $_main_branch_id_detail ?? 1;
                    $KitchenFinishGoods->_store_id  = $_main_store ?? 1;
                    $KitchenFinishGoods->_cost_center_id  = $_main_cost_center ?? 1;
                    $KitchenFinishGoods->_store_salves_id  = $_store_salves_ids ?? '';
                    $KitchenFinishGoods->_status  = 1;
                    $KitchenFinishGoods->_coking  = 0;
                    $KitchenFinishGoods->_kitchen_item  = $item_info->_kitchen_item ?? 0;
                    $KitchenFinishGoods->_created_by  = $users->id."-".$users->name;
                    $KitchenFinishGoods->save();

                    //Item Detail Data send to kitchen_row_goods
                    $item_ingredians = MusakFourPointThree::with(['input_detail'])->where('_item_id',$_item_ids)->first();
                    if($item_ingredians){
                        $input_detail = $item_ingredians->input_detail ?? [];
                        if(sizeof($input_detail) > 0){
                            foreach ($input_detail as $input_d) {
                                $conversion_qty = $input_d->conversion_qty ?? 1;
                                $conversion_unit_id = $input_d->_unit_id ?? 1;

                                $_require_qty = (($_qtys ?? 0)* ($input_d->_qty ?? 0));
                                $_require_value = (($_require_qty ?? 0)* ($input_d->_rate ?? 0));
                                $KitchenRowGoods = new KitchenRowGoods();
                                $KitchenRowGoods->_item_id  = $input_d->_item_id;
                                $KitchenRowGoods->_p_p_l_id  = 0;
                                $KitchenRowGoods->_purchase_invoice_no  = 0;

                                $KitchenRowGoods->_conversion_qty  = $conversion_qty;
                                $KitchenRowGoods->_unit_id  = $conversion_unit_id;

                                $KitchenRowGoods->_purchase_detail_id  = 0;
                                $KitchenRowGoods->_qty  = $_require_qty ?? 0;

                                $KitchenRowGoods->_rate  = $input_d->_rate ?? 0;
                                $KitchenRowGoods->_value  = $_require_value ?? 0;
                                $KitchenRowGoods->_no  = $_kitchen_order_id;
                                $KitchenRowGoods->_branch_id  = $_main_branch_id_detail ?? 1;
                                $KitchenRowGoods->_store_id  = $_main_store ?? 1;
                                $KitchenRowGoods->_cost_center_id  = $_main_cost_center ?? 1;
                                $KitchenRowGoods->_store_salves_id  = $_store_salves_ids ?? '';
                                $KitchenRowGoods->_status  = 1;
                                $KitchenRowGoods->_kitchen_item  = $item_info->_kitchen_item ?? 0;
                                $KitchenRowGoods->_created_by  = $users->id."-".$users->name;
                                $KitchenRowGoods->save();

                                
                            }// End of input Details
                        } // End of Check size of
                    } //End of ingredaints Check
                } //End of check Kitchen item yes or no








                if($ProductPriceList){
                        $_p_qty = $ProductPriceList->_qty ?? 0;
                        $_unique_barcode = $ProductPriceList->_unique_barcode ?? 0;
                        //Barcode  deduction from old string data
                        if($_unique_barcode ==1){
                             $_old_barcode_strings =  $ProductPriceList->_barcode ?? "";
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
                        $_status = (($_p_qty - $_qtys) > 0) ? 1 : 0;
                        $ProductPriceList->_qty = ($_p_qty - $_qtys);
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
                                _barcode_insert_update('BarcodeDetail', $product_price_id,$_item_ids,$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,1,1);
                                _barcode_insert_update('SalesBarcode', $product_price_id,$_item_ids,$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,0,0);
                                 
                               }
                            }
                     }


                    $ItemInventory = new ItemInventory();
                    $ItemInventory->_item_id =  $_item_ids;
                    $ItemInventory->_item_name =  $item_info->_item ?? '';
                    $ItemInventory->_unit_id =  $item_info->_unit_id ?? '';
                    $ItemInventory->_category_id = _item_category($_item_ids);
                    $ItemInventory->_date = change_date_format($request->_date);
                    $ItemInventory->_time = date('H:i:s');
                    $ItemInventory->_transection = "Restaurant Sales";
                    $ItemInventory->_transection_ref = $_master_id;
                    $ItemInventory->_transection_detail_ref_id = $_sales_details_id;
                    $ItemInventory->_qty = -($_qtys);
                    $ItemInventory->_rate = $_sales_rates;

                    $ItemInventory->_transection_unit = $item_info->_unit_id ?? '';
                    $ItemInventory->_unit_conversion = 1;
                    $ItemInventory->_base_unit = $item_info->_unit_id ?? '';

                    $ItemInventory->_cost_rate = $_rates;
                    $ItemInventory->_manufacture_date = $_manufacture_dates;
                    $ItemInventory->_expire_date = $_expire_dates;
                    $ItemInventory->_cost_value = ($_qtys*$_rates);
                    $ItemInventory->_value = $_values ?? 0;
                    $ItemInventory->_branch_id = $_main_branch_id_detail ?? 1;
                    $ItemInventory->_store_id = $_store_ids ?? 1;
                    $ItemInventory->_cost_center_id = $_main_cost_center ?? 1;
                    $ItemInventory->_store_salves_id = $_store_salves_ids ?? '';
                    $ItemInventory->_status = 1;
                    $ItemInventory->_created_by = $users->id."-".$users->name;
                    $ItemInventory->save(); 
                    inventory_stock_update($_item_ids);

                } //End of ProductPriceList Check
        } //End of Item For Loop
        
        

   


      /// return json_encode($_master_id); 
        //###########################
        // Purchase Details information Save End
        //###########################

        //###########################
        // Purchase Account information Save End
        //###########################
        $_total_dr_amount = 0;
        $_total_cr_amount = 0;
        $_date = $request->_date ?? date('Y-m-d');
       $ResturantFormSetting =  ResturantFormSetting::first();
        $_default_inventory = $ResturantFormSetting->_default_inventory;
        $_default_sales = $ResturantFormSetting->_default_sales;
        $_default_discount = $ResturantFormSetting->_default_discount;
        $_default_vat_account = $ResturantFormSetting->_default_vat_account;
        $_default_cost_of_solds = $ResturantFormSetting->_default_cost_of_solds;
        $_default_service_charge = $ResturantFormSetting->_default_service_charge;
        $_default_other_charge = $ResturantFormSetting->_default_other_charge;
        $_default_delivery_charge = $ResturantFormSetting->_default_delivery_charge;

        $_ref_master_id=$_master_id;
        $_ref_detail_id=$_master_id;
        $_short_narration='N/A';
        $_narration = $request->_note;
        $_reference= $request->_referance;
        $_transaction= 'Restaurant Sales';
        $_date = change_date_format($_date ?? date('Y-m-d'));
        $_table_name = $request->_form_name ?? 'resturant_sales';
        $_branch_id = $_main_branch;
        $_cost_center =$request->_cost_center ??  1;
        $_name =$users->name;
       // return $__sub_total;
        if($__sub_total > 0){

            //#################
            // Account Receiveable Dr.
            //      Sales Cr
            //#################

            //Default Sales DR.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_sales),$_narration,$_reference,$_transaction,$_date,$_table_name,$_main_ledger_id,$__sub_total,0,$_branch_id,$_cost_center,$_name,1);
           //Default Account Receivable  Cr.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_sales,0,$__sub_total,$_branch_id,$_cost_center,$_name,2);

            //#################
            // Cost of Goods Sold Dr.
            //      Inventory  Cr
            //#################

            //Cost of Goods Sold Dr.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_cost_of_solds,$_total_cost_value,0,$_branch_id,$_cost_center,$_name,3);
            //Inventory  Cr
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_cost_of_solds),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,0,$_total_cost_value,$_branch_id,$_cost_center,$_name,4);
        }

        if($__total_discount > 0){
            //return $__total_discount;
             //#################
            // Sales Discount Dr.
            //      Account Receivable  Cr
            //#################
            //Default Discount
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_discount,$__total_discount,0,$_branch_id,$_cost_center,$_name,5);
            //  Account Receivable  Cr
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_discount),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,0,$__total_discount,$_branch_id,$_cost_center,$_name,6);
             
        
        }
        $__total_vat = (float) $request->_total_vat ?? 0;
        if($__total_vat > 0){
             //#################
            // Account Receivable Dr.
            //      Vat  Cr
            //#################
            //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_vat_account),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$request->_total_vat,0,$_branch_id,$_cost_center,$_name,7);
            //Account Receivable
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_vat_account,0,$request->_total_vat,$_branch_id,$_cost_center,$_name,8);
        
        }

 if($_service_charge > 0){
             //#################
            // Account Receivable Dr.
            //      _service_charge  Cr
            //#################
            //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_service_charge),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$_service_charge,0,$_branch_id,$_cost_center,$_name,9);
            //Account Receivable
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_service_charge,0,$_service_charge,$_branch_id,$_cost_center,$_name,10);
        
        }
        if($_other_charge > 0){
             //#################
            // Account Receivable Dr.
            //      _other_charge  Cr
            //#################
            //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_other_charge),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$_other_charge,0,$_branch_id,$_cost_center,$_name,11);
            //Account Receivable
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_other_charge,0,$_other_charge,$_branch_id,$_cost_center,$_name,12);
        
        }
        if($_delivery_charge > 0){
             //#################
            // Account Receivable Dr.
            //      _delivery_charge  Cr
            //#################
            //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_delivery_charge),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$_delivery_charge,0,$_branch_id,$_cost_center,$_name,13);
            //Account Receivable
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_delivery_charge,0,$_delivery_charge,$_branch_id,$_cost_center,$_name,14);
        
        }

       

      
        //return $_POST["pay_all"];
         $payment_row_count = intval($_POST["payment_row_count"] ?? 0);
        //Start Full Payment with first Account/Cash in Hand
        if($_POST["pay_all"] ==="true"){
            $ledger = 1;
            $_dr_amount = $__total;
            $_cr_amount = 0;
            $_short_narr = "Payment by Cash";

                        $_account_type_id =  ledger_to_group_type($ledger)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($ledger)->_account_group_id;

                        $ResturantSalesAccount = new ResturantSalesAccount();
                        $ResturantSalesAccount->_no = $_master_id;
                        $ResturantSalesAccount->_account_type_id = $_account_type_id;
                        $ResturantSalesAccount->_account_group_id = $_account_group_id;
                        $ResturantSalesAccount->_ledger_id = $ledger;
                        $ResturantSalesAccount->_cost_center = $_cost_center ?? 1;
                        $ResturantSalesAccount->_branch_id = $_branch_id_detail ?? 1;
                        $ResturantSalesAccount->_short_narr = $_short_narr ?? 'N/A';
                        $ResturantSalesAccount->_dr_amount = $_dr_amount ?? 0;
                        $ResturantSalesAccount->_cr_amount = $_cr_amount ?? 0;
                        $ResturantSalesAccount->_status = 1;
                        $ResturantSalesAccount->_created_by = $users->id."-".$users->name;
                        $ResturantSalesAccount->save();

                        $_sales_account_id = $ResturantSalesAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$_master_id;
                        $_ref_detail_id=$_sales_account_id;
                        $_short_narration=$_short_narr ?? 'N/A';
                        $_narration = $request->_note;
                        $_reference= $request->_referance ?? 'N/A';
                        $_transaction= 'Restaurant Sales';
                        $_date = change_date_format($_date);
                        $_table_name ='resturant_sales_accounts';
                        $_account_ledger = $ledger;
                        $_dr_amount_a = $_dr_amount ?? 0;
                        $_cr_amount_a = $_cr_amount ?? 0;
                        $_branch_id_a = $_branch_id_detail ?? 1;
                        $_cost_center_a = $_cost_center ?? 1;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(9));



                        $_account_type_id =  ledger_to_group_type($_main_ledger_id)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($_main_ledger_id)->_account_group_id;

                        $ResturantSalesAccount = new ResturantSalesAccount();
                        $ResturantSalesAccount->_no = $_master_id;
                        $ResturantSalesAccount->_account_type_id = $_account_type_id;
                        $ResturantSalesAccount->_account_group_id = $_account_group_id;
                        $ResturantSalesAccount->_ledger_id = $_main_ledger_id;
                        $ResturantSalesAccount->_cost_center = $_cost_center ?? 1;
                        $ResturantSalesAccount->_branch_id = $_branch_id_detail ?? 1;
                        $ResturantSalesAccount->_short_narr = $_short_narr ?? 'N/A';
                        $ResturantSalesAccount->_dr_amount =  0;
                        $ResturantSalesAccount->_cr_amount = $_dr_amount ?? 0;
                        $ResturantSalesAccount->_status = 1;
                        $ResturantSalesAccount->_created_by = $users->id."-".$users->name;
                        $ResturantSalesAccount->save();

                        $_sales_account_id = $ResturantSalesAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$_master_id;
                        $_ref_detail_id=$_sales_account_id;
                        $_short_narration=$_short_narr ?? 'N/A';
                        $_narration = $request->_note;
                        $_reference= $request->_referance ?? 'N/A';
                        $_transaction= 'Restaurant Sales';
                        $_date = change_date_format($_date);
                        $_table_name ='resturant_sales_accounts';
                        $_account_ledger = $_main_ledger_id;
                        $_dr_amount_a =  0;
                        $_cr_amount_a = $_dr_amount ?? 0;
                        $_branch_id_a = $_branch_id_detail ?? 1;
                        $_cost_center_a = $_cost_center ?? 1;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(10));
        }else{
            $_total_cr = 0;
            $___amounts = $request->amount ?? [];
            //$_POST["amount"];
            $___payment_group = $request->payment_type ?? [];
            //$_POST["payment_type"];
            $___payment_note = $request->payment_note ?? [];
            //$_POST["payment_note"];
    for($j=0; $j<$payment_row_count; $j++){
      $ledger = intval($___payment_group[$j]);
      $_dr_amount =(float) $___amounts[$j] ?? 0;
      $_cr_amount =0;
      $_total_cr += (float) $_dr_amount;
      $_short_narr=$___payment_note[$j] ?? 'N/A';

        $_account_type_id =  ledger_to_group_type($ledger)->_account_head_id;
        $_account_group_id =  ledger_to_group_type($ledger)->_account_group_id;

        $ResturantSalesAccount = new ResturantSalesAccount();
        $ResturantSalesAccount->_no = $_master_id;
        $ResturantSalesAccount->_account_type_id = $_account_type_id;
        $ResturantSalesAccount->_account_group_id = $_account_group_id;
        $ResturantSalesAccount->_ledger_id = $ledger;
        $ResturantSalesAccount->_cost_center = $_cost_center ?? 1;
        $ResturantSalesAccount->_branch_id = $_branch_id_detail ?? 1;
        $ResturantSalesAccount->_short_narr = $_short_narr ?? 'N/A';
        $ResturantSalesAccount->_dr_amount = $_dr_amount ?? 0;
        $ResturantSalesAccount->_cr_amount = $_cr_amount ?? 0;
        $ResturantSalesAccount->_status = 1;
        $ResturantSalesAccount->_created_by = $users->id."-".$users->name;
        $ResturantSalesAccount->save();

        $_sales_account_id = $ResturantSalesAccount->id;

        //Reporting Account Table Data Insert
        $_ref_master_id=$_master_id;
        $_ref_detail_id=$_sales_account_id;
        $_short_narration=$_short_narr ?? 'N/A';
        $_narration = $request->_note;
        $_reference= $request->_referance ?? 'N/A';
        $_transaction= 'Restaurant Sales';
        $_date = change_date_format($_date);
        $_table_name ='resturant_sales_accounts';
        $_account_ledger = $ledger;
        $_dr_amount_a = $_dr_amount ?? 0;
        $_cr_amount_a = $_cr_amount ?? 0;
        $_branch_id_a = $_branch_id_detail ?? 1;
        $_cost_center_a = $_cost_center ?? 1;
        $_name =$users->name;
        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(9+$j));
            

    }

                        $_account_type_id =  ledger_to_group_type($_main_ledger_id)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($_main_ledger_id)->_account_group_id;
                        $_short_narr = 'Bill Paid';
                        $ResturantSalesAccount = new ResturantSalesAccount();
                        $ResturantSalesAccount->_no = $_master_id;
                        $ResturantSalesAccount->_account_type_id = $_account_type_id;
                        $ResturantSalesAccount->_account_group_id = $_account_group_id;
                        $ResturantSalesAccount->_ledger_id = $_main_ledger_id;
                        $ResturantSalesAccount->_cost_center = $_cost_center ?? 1;
                        $ResturantSalesAccount->_branch_id = $_branch_id_detail ?? 1;
                        $ResturantSalesAccount->_short_narr = $_short_narr ?? 'N/A';
                        $ResturantSalesAccount->_dr_amount =  0;
                        $ResturantSalesAccount->_cr_amount = $_total_cr ?? 0;
                        $ResturantSalesAccount->_status = 1;
                        $ResturantSalesAccount->_created_by = $users->id."-".$users->name;
                        $ResturantSalesAccount->save();

                        $_sales_account_id = $ResturantSalesAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$_master_id;
                        $_ref_detail_id=$_sales_account_id;
                        $_short_narration=$_short_narr ?? 'N/A';
                        $_narration = $request->_note;
                        $_reference= $request->_referance ?? 'N/A';
                        $_transaction= 'Restaurant Sales';
                        $_date = change_date_format($_date);
                        $_table_name ='resturant_sales_accounts';
                        $_account_ledger = $_main_ledger_id;
                        $_dr_amount_a =  0;
                        $_cr_amount_a = $_total_cr ?? 0;
                        $_branch_id_a = $_branch_id_detail ?? 1;
                        $_cost_center_a = $_cost_center ?? 1;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(10));
}
       
       

          $_l_balance = _l_balance_update($request->_main_ledger_id);
          $_pfix = _sales_pfix().$_master_id;
             \DB::table('resturant_sales')
             ->where('id',$_master_id)
             ->update(['_p_balance'=>$_p_balance,'_l_balance'=>$_l_balance,'_order_number'=>$_pfix]);

               //SMS SEND to Customer and Supplier
             $_send_sms = $request->_send_sms ?? '';
             if($_send_sms=='yes'){
                $_ledger_info = AccountLedger::where($request->_main_ledger_id)->first();
                $_name = _ledger_name($request->_main_ledger_id);
                $_phones = $request->_phone ?? $_ledger_info->phone;
                $messages = "Dear ".$_name.", Date: ".$_date." Invoice N0.".$_pfix." Invoice Amount: ".prefix_taka()."."._report_amount($request->_total ?? $_total_cr).". Payment Amount. ".prefix_taka()."."._report_amount($_total_dr_amount);
                  sms_send($messages, $_phones);
             }


        //$page_name = $this->page_name;
       // $permited_branch = permited_branch(explode(',',$users->branch_ids));
       // $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
       
       //  $data =  Sales::with(['_master_branch','_master_details','s_account','_ledger'])->find($_master_id);
       // $form_settings = ResturantFormSetting::first();
       // $permited_branch = permited_branch(explode(',',$users->branch_ids));
       // $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
       //  $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
         
      // return   $invoice_print =   view('backend.pos.pos_template',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         

             $_mess['message']='success';
             $_mess['_master_id'] =$_master_id;
             


             
             //End Sms Send to customer and Supplier

          // DB::commit();
            return json_encode( $_mess);
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     $_mess['message']='error';
        //       $_mess['_master_id'] =$_master_id;
        //  }


    }

    public function holdInvoiceList(){
        $invoice_list = [];
        $data["invoice_list"]=$invoice_list;
        return json_encode($data);
    }

    public function categoryWiseItem(request $request){
       // return $request->all();
        $users = Auth::user();
        $category_id = $request->_item_category;
        $brach_id = intval($request->brach_id ?? 1);
        $store_id = intval($request->store_id ?? 1);
        $_cost_center_id = intval($request->_cost_center_id ?? 1);
        $_asc_desc = $request->_asc_desc ?? 'ASC';
        $asc_cloumn =  $request->asc_cloumn ?? 'available_qty';
        $limit=100;

        $setting_cat_ids = 0;
        $defalutl_categories = DB::table("restaurant_category_settings")->select('_category_ids')->where('_branch_ids',$brach_id)->first();
        $setting_cat_ids = $defalutl_categories->_category_ids;
       
        $sub_category = ItemCategory::where('_parent_id',$category_id)
        ->select('id','_name','_parent_id','_image')
        ->get();
        if(sizeof($sub_category) > 0){
            $data['category']=[];

            $data['items']=DB::select("
SELECT t5.* from (

         SELECT 0 as _row_id, id as _id,id as _item_id, _item,_image,_category_id as _category , _unit_id AS _unit, _barcode  AS _itemcode,_warranty,null as _manufacture_date,null as _expire_date, _balance  as available_qty, _discount as _sales_discount, _vat , _pur_rate AS _purprice, _sale_rate as _saleprice,1 as _p_vat,  ".$brach_id." as _branch_id, ".$_cost_center_id." as _cost_center_id, ".$store_id." as _store_id,1 as _store_salves_id,0 as _master_id, 0 as _purchase_detail_id ,_status, _unique_barcode, _kitchen_item 
            FROM inventories 
            WHERE    _status = 1  AND _unique_barcode !=1 AND _kitchen_item=1 AND _balance = 0  AND _category_id IN (".$setting_cat_ids.")
            
            UNION ALL

            SELECT t1.id as _row_id,t1._item_id as _id,t1._item_id as _item_id, t1._item,t2._image,t2._category_id as _category, t1._unit_id AS _unit, t1._barcode  AS _itemcode,t1._warranty, t1._manufacture_date,t1._expire_date, t1._qty  as available_qty,t1._sales_discount,t1._sales_vat as _vat, t1._pur_rate AS _purprice,t1._sales_rate  AS _saleprice,1 as _p_vat, t1._branch_id,t1._cost_center_id,t1._store_id,t1._store_salves_id, t1._master_id,t1._purchase_detail_id,t1._status,t1._unique_barcode, 0 as _kitchen_item   
            FROM product_price_lists AS t1
            INNER JOIN inventories AS t2 ON t2.id=t1._item_id
            WHERE  t1._status = 1 
                    AND t1._branch_id in ($users->branch_ids) AND t1._cost_center_id in ($users->cost_center_ids) 
                    AND t1._unique_barcode !=1  AND  t1._qty > 0 
              
                    ) as t5 order by $asc_cloumn $_asc_desc LIMIT 20

            ");;

        }else{
 
            if($category_id =='All'){
                $sub_category = ItemCategory::where('_parent_id',$category_id)->get();
                $items = [];
                $data['category']=[];
                $data['category_section']=1;
                $data['items']= $items;
            }else{
                $datas = DB::select("
SELECT t5.* from (

         SELECT 0 as _row_id, id as _id,id as _item_id, _item,_image,_category_id as _category , _unit_id AS _unit, _barcode  AS _itemcode,_warranty,null as _manufacture_date,null as _expire_date, _balance  as available_qty, _discount as _sales_discount, _vat , _pur_rate AS _purprice, _sale_rate as _saleprice,1 as _p_vat,  ".$brach_id." as _branch_id, ".$_cost_center_id." as _cost_center_id, ".$store_id." as _store_id,1 as _store_salves_id,0 as _master_id, 0 as _purchase_detail_id ,_status, _unique_barcode, _kitchen_item 
            FROM inventories 
            WHERE    _status = 1 AND _category_id=".$category_id." AND _unique_barcode !=1 AND _kitchen_item=1 AND _balance = 0  
            
            UNION ALL

            SELECT t1.id as _row_id,t1._item_id as _id,t1._item_id as _item_id, t1._item,t2._image,t2._category_id as _category, t1._unit_id AS _unit, t1._barcode  AS _itemcode,t1._warranty, t1._manufacture_date,t1._expire_date, t1._qty  as available_qty,t1._sales_discount,t1._sales_vat as _vat, t1._pur_rate AS _purprice,t1._sales_rate  AS _saleprice,1 as _p_vat, t1._branch_id,t1._cost_center_id,t1._store_id,t1._store_salves_id, t1._master_id,t1._purchase_detail_id,t1._status,t1._unique_barcode, 0 as _kitchen_item   
            FROM product_price_lists AS t1
            INNER JOIN inventories AS t2 ON t2.id=t1._item_id
            WHERE  t1._status = 1 AND  t2._category_id=".$category_id."
                    AND t1._branch_id in ($users->branch_ids) AND t1._cost_center_id in ($users->cost_center_ids) 
                    AND t1._unique_barcode !=1  AND  t1._qty > 0 
              
                    ) as t5 order by $asc_cloumn $_asc_desc LIMIT $limit

            ");

                // $items = DB::select(" SELECT t1._unique_barcode, t1._image, t1._category_id as _category,t2.id as _row_id,t2._item_id AS _id,t2._item,t2._unit_id AS _unit,t2._sales_rate AS _saleprice,t2._pur_rate AS _purprice,1 as _sales_vat,1 as _p_vat,t2._barcode AS _itemcode,t2._qty as available_qty,t2._sales_vat as _vat,t2._sales_discount  FROM inventories as t1 
                //     INNER JOIN product_price_lists AS t2 ON t1.id=t2._item_id
                //     WHERE t1._category_id=".$category_id." AND t2._qty > 0 AND t2._branch_id=".$brach_id." AND t2._store_id=".$store_id."  ");


                $data['category']=[];
                $data['category_section']=0;
                $data['items']= $datas;
            }
            

        }
return json_encode( $data);

    }

    public function kitchenSlip($id){
        $users = Auth::user();
        $page_name = "Kitchen Slip";
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
       
         $data =  ResturantSales::with(['_master_branch','_master_details','s_account','_ledger'])->find($id);
        $form_settings = ResturantFormSetting::first();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();

        $_table_id = $data->_table_id ?? 0;
       


    $tables = \DB::select(" SELECT id,_name,_number_of_chair FROM `table_infos` WHERE id IN(".$_table_id.") AND _branch_id IN (".$users->branch_ids.") ");

   

        $_served_by_ids = $data->_served_by_ids ?? 0;
        
 $stewards = \DB::select(" SELECT id,_name FROM account_ledgers WHERE id IN(".$_served_by_ids.")  ");
         
    return view('backend.restaurant-sales.kitchen_slip',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses','stewards','tables'));
         
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
            session()->put('_sales_limit', $request->limit);
        }else{
             $limit= \Session::get('_sales_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        
       

      $datas = ResturantSales::with(['_master_branch','_ledger'])->where('_status',1);
        //$datas = $datas->whereIn('sales._branch_id',explode(',',\Auth::user()->branch_ids));
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
            $datas = $datas->where('id', $ids); 
        }
        
         if($request->has('_lock') && $request->_lock !=''){
            $datas = $datas->where('_lock','=',$request->_lock);
        }
        if($request->has('_order_ref_id') && $request->_order_ref_id !=''){
            $datas = $datas->where('_order_ref_id','like',"%trim($request->_order_ref_id)%");
        }
        if($request->has('_cost_center_id') && $request->_cost_center_id !=''){
            $datas = $datas->where('_cost_center_id','=',$request->_cost_center_id);
        }
        if($request->has('_store_salves_id') && $request->_store_salves_id !=''){
            $datas = $datas->where('_store_salves_id','=',$request->_store_salves_id);
        }
        if($request->has('_delivery_man_id') && $request->_delivery_man_id !=''){
            $datas = $datas->where('_delivery_man_id','=',$request->_delivery_man_id);
        }

        if($request->has('_sales_man_id') && $request->_sales_man_id !=''){
            $datas = $datas->where('_sales_man_id','=',$request->_sales_man_id);
        }

        if($request->has('_sales_type') && $request->_sales_type !=''){
            $datas = $datas->where('_sales_type','=',$request->_sales_type);
        }

        if($request->has('_referance') && $request->_referance !=''){
            $datas = $datas->where('_referance','like',"%trim($request->_referance)%");
        }
        if($request->has('_note') && $request->_note !=''){
            $datas = $datas->where('_note','like',"%trim($request->_note)%");
        }
        if($request->has('_user_name') && $request->_user_name !=''){

            $datas = $datas->where('_user_name','like',"%trim($request->_user_name)%");
        }
        
        if($request->has('_sub_total') && $request->_sub_total !=''){
            $datas = $datas->where('_sub_total','=',trim($request->_sub_total));
        }
        if($request->has('_total_discount') && $request->_total_discount !=''){
            $datas = $datas->where('_total_discount','=',trim($request->_total_discount));
        }
        if($request->has('_total_vat') && $request->_total_vat !=''){
            $datas = $datas->where('_total_vat','=',trim($request->_total_vat));
        }
        if($request->has('_total') && $request->_total !=''){
            $datas = $datas->where('_total','=',trim($request->_total));
        }
        if($request->has('_ledger_id') && $request->_ledger_id !='' && $request->has('_search_main_ledger_id') && $request->_search_main_ledger_id ){
            $datas = $datas->where('_ledger_id','=',trim($request->_ledger_id));
        }
        
       $datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);

         $page_name = $this->page_name;
         $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
         $account_groups = AccountGroup::select('id','_name')->orderBy('_name','asc')->get();
          $current_date = date('Y-m-d');
          $current_time = date('H:i:s');
          $users = Auth::user();
           $form_settings = ResturantFormSetting::first();
           $permited_branch = permited_branch(explode(',',$users->branch_ids));
         $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        //return $datas;
         if($request->has('print')){
            if($request->print =="single"){
                return view('backend.restaurant-sales.master_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
            }

            if($request->print =="detail"){
                return view('backend.restaurant-sales.details_print',compact('datas','page_name','account_types','request','account_groups','current_date','current_time','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
            }
         }

        return view('backend.restaurant-sales.index',compact('datas','page_name','account_types','request','account_groups','current_date','limit','form_settings','permited_branch','permited_costcenters','store_houses'));
    }

     public function reset(){
        Session::flash('_sales_limit');
       return  \Redirect::to('restaurant-sales?limit='.default_pagination());
    }


    public function invoiceWiseDetail(Request $request){
         $users = Auth::user();
        $invoice_id = $request->invoice_id;
        $key = $request->_attr_key;
        $data = ResturantSales::with(['_master_details','s_account'])->where('id',$invoice_id)->first();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
          $form_settings = ResturantFormSetting::first();

        return view('backend.restaurant-sales.sales_details',compact('data','permited_branch','permited_costcenters','store_houses','key','form_settings'));

    }

      public function moneyReceipt($id){
        $users = Auth::user();
        $page_name = 'Money Receipt';
        
        $branchs = Branch::orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $data = ResturantSales::with(['_master_branch','s_account','_ledger'])->find($id);

       return view('backend.restaurant-sales.money_receipt',compact('page_name','branchs','permited_branch','permited_costcenters','data'));
    }


    public function checkAvailableQty(Request $request){
        $unique_p_q = [];
         $_over_qty = array();

        $unique_p_ids = $request->unique_p_ids ?? [];
        $_p_ids = implode(",",$unique_p_ids); //Product Price list table ID

      //Unique Barcode Available Check 
         $_all_barcode= $request->_all_barcode ?? '';
        $_all_barcodes = array();
        if($_all_barcode !=''){
          $_all_barcodes = explode(",",$_all_barcode);
        }
        $_sales_return_id = $request->_sales_return_id ?? 0;
        $_sales_id = $request->_order_ref_id ?? 0;
        
        if(sizeof($_all_barcodes) > 0){
          $productPriceListTableData =DB::select(" SELECT  _barcode FROM product_price_lists AS s1 WHERE s1.id IN(".$_p_ids.")  ");
          $_available_barcode_numbers = [];
          foreach ($productPriceListTableData as $_p_barcodes) {
             $_ppl_barcodes= $_p_barcodes->_barcode;
              if($_ppl_barcodes !=""){
                 $_price_list_barcode_arrray = explode(",",$_ppl_barcodes);
                 if(sizeof($_price_list_barcode_arrray) > 0){
                      foreach ($_price_list_barcode_arrray as $value) {
                        array_push($_available_barcode_numbers, $value);
                      }
                 }
              }
          }
         
          
          

          foreach ($_all_barcodes as $c_value) {
         
            if(!in_array($c_value, $_available_barcode_numbers)){
               array_push($_over_qty, $c_value);

            }
          }

          if(sizeof($_over_qty) > 0){
            return json_encode($_over_qty); 
          }

        }

        foreach($request->_p_p_l_ids_qtys as $index=> $val){
         $unique_p_q[$val["_p_id"]][]=$val;
        }
        $_id_qty=array();
        foreach ($unique_p_q as $key=>$value) {
            $qty_sum =0;
            foreach ($value as $row) {
                 $qty_sum +=floatval($row["_p_qty"]);
             }
            array_push($_id_qty, ['_id'=>$key,'_qty'=>$qty_sum]);  
        }

        $_over_qty = array();
        if(sizeof($_id_qty) > 0){
            foreach ($_id_qty as $value) {
                $check_qty = ProductPriceList::where('id',$value["_id"])->where('_qty','<',floatval($value["_qty"]))->first();
                if($check_qty){
                    array_push($_over_qty, $value["_id"]);
                }
            }
        }
       

        return json_encode($_over_qty); 
    }
    public function checkAvailableQtyUpdate(Request $request){
       $_over_qty = array();

       $unique_p_ids = $request->unique_p_ids ?? [];
      $_p_ids = implode(",",$unique_p_ids); //Product Price list table ID
        $previous_sales_details = \DB::select(" SELECT t1._p_p_l_id,t1._item_id,SUM(t1._qty) as _total_qty
FROM (
SELECT s1._p_p_l_id,s1._item_id,s1._qty
    FROM sales_details as s1
WHERE s1._no=".$request->_sales_id." GROUP BY s1._p_p_l_id
UNION ALL
SELECT s1.id as _p_p_l_id,s1._item_id,s1._qty 
    FROM product_price_lists AS s1 WHERE s1.id IN(".$_p_ids.")
    ) as t1 GROUP BY t1._p_p_l_id ");

        $unique_p_q = [];
        foreach($request->_p_p_l_ids_qtys as $index=> $val){
         $unique_p_q[$val["_p_id"]][]=$val;
        }
        $_id_qty=array();
        foreach ($unique_p_q as $key=>$value) {
            $qty_sum =0;
            foreach ($value as $row) {
                 $qty_sum +=floatval($row["_p_qty"]);
             }
            array_push($_id_qty, ['_id'=>$key,'_qty'=>$qty_sum]);  
        }

       
       foreach ($previous_sales_details as $value) {
           foreach ($_id_qty as $c_val) {
            
               if($value->_p_p_l_id ==$c_val["_id"]   ){
                if(floatval($value->_total_qty) < floatval($c_val["_qty"])){
                    array_push($_over_qty, $c_val["_id"]);
                }
               }
           }
       }
       
        
        return json_encode($_over_qty); 
    }

    public function checkAvailableQtyUpdateDamage(Request $request){
      

       $unique_p_ids = $request->unique_p_ids ?? [];
      $_p_ids = implode(",",$unique_p_ids); //Product Price list table ID
      $unique_p_q = [];
         $_over_qty = array();

        $unique_p_ids = $request->unique_p_ids ?? [];
        $_p_ids = implode(",",$unique_p_ids); //Product Price list table ID

      //Unique Barcode Available Check 
         $_all_barcode= $request->_all_barcode ?? '';
        $_all_barcodes = array();
        if($_all_barcode !=''){
          $_all_barcodes = explode(",",$_all_barcode);
        }
       
        $_sales_id = $request->_sales_id ?? 0;
        
        if(sizeof($_all_barcodes) > 0){
          $productPriceListTableData =DB::select(" SELECT  _barcode FROM barcode_details AS s1 WHERE s1._p_p_id IN(".$_p_ids.")  AND s1._status=1
            UNION ALL
            SELECT _barcode FROM damage_barcodes WHERE _no_id=".$_sales_id." AND _status =1
           ");
          $_available_barcode_numbers = [];
          foreach ($productPriceListTableData as $_p_barcodes) {
             $_ppl_barcodes= $_p_barcodes->_barcode;
              if($_ppl_barcodes !=""){
                 $_price_list_barcode_arrray = explode(",",$_ppl_barcodes);
                 if(sizeof($_price_list_barcode_arrray) > 0){
                      foreach ($_price_list_barcode_arrray as $value) {
                        array_push($_available_barcode_numbers, $value);
                      }
                 }
              }
          }
         
          
          

          foreach ($_all_barcodes as $c_value) {
         
            if(!in_array($c_value, $_available_barcode_numbers)){
               array_push($_over_qty, $c_value);

            }
          }

          if(sizeof($_over_qty) > 0){
            return json_encode($_over_qty); 
          }

        }  //End of Wrong barcode check


        $previous_sales_details = \DB::select(" SELECT t1._p_p_l_id,t1._item_id,SUM(t1._qty) as _total_qty
FROM (
SELECT s1._p_p_l_id,s1._item_id,s1._qty
    FROM damage_adjustment_details as s1
WHERE s1._no=".$request->_sales_id." GROUP BY s1._p_p_l_id
UNION ALL
SELECT s1.id as _p_p_l_id,s1._item_id,s1._qty 
    FROM product_price_lists AS s1 WHERE s1.id IN(".$_p_ids.")
    ) as t1 GROUP BY t1._p_p_l_id ");

        $unique_p_q = [];
        foreach($request->_p_p_l_ids_qtys as $index=> $val){
         $unique_p_q[$val["_p_id"]][]=$val;
        }
        $_id_qty=array();
        foreach ($unique_p_q as $key=>$value) {
            $qty_sum =0;
            foreach ($value as $row) {
                 $qty_sum +=floatval($row["_p_qty"]);
             }
            array_push($_id_qty, ['_id'=>$key,'_qty'=>$qty_sum]);  
        }

       
       foreach ($previous_sales_details as $value) {
           foreach ($_id_qty as $c_val) {
            
               if($value->_p_p_l_id ==$c_val["_id"]   ){
                if(floatval($value->_total_qty) < floatval($c_val["_qty"])){
                    array_push($_over_qty, $c_val["_id"]);
                }
               }
           }
       }
       
        
        return json_encode($_over_qty); 
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
        $branchs = Branch::select('id','_name')->orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $voucher_types = VoucherType::select('id','_name','_code')->orderBy('_code','asc')->get();
        $store_houses = StoreHouse::select('id','_name')->whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        $form_settings = ResturantFormSetting::first();
        $inv_accounts = [];
        $p_accounts = [];
        $dis_accounts = [];
        $vat_accounts =[];

         $_steward_group = \DB::table("default_ledgers")->select('_steward_group')->first();
        $_stewards= AccountLedger::select('id','_name','_phone','_alious')->where('_account_group_id',$_steward_group->_steward_group ?? 0)->get();

        $categories = ItemCategory::with(['_parents'])->select('id','_name','_parent_id')->orderBy('_name','asc')->get();
        $units = Units::select('id','_name','_code')->orderBy('_name','asc')->get();
        $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->where('_status',1)->get();
        $tables = \DB::select(" SELECT id,_name,_number_of_chair,_status FROM `table_infos` WHERE _branch_id IN (".$users->branch_ids.") AND _status=1 ");

       return view('backend.restaurant-sales.create',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','vat_accounts','categories','units','_warranties','_stewards','tables'));
    }

    public function formSettingAjax(){
        $form_settings = ResturantFormSetting::first();
        $inv_accounts = AccountLedger::get();
        $p_accounts = $inv_accounts;
        $dis_accounts = $inv_accounts;
        $cost_of_solds = $inv_accounts;
        $_cash_customers = $inv_accounts;
        $_income_accounts = $inv_accounts;
        return view('backend.restaurant-sales.form_setting_modal',compact('form_settings','inv_accounts','p_accounts','dis_accounts','cost_of_solds','_cash_customers','_income_accounts'));
    }


    public function itemSalesSearch(Request $request){
        $users = Auth::user();
        $limit = $request->limit ?? default_pagination();
        $_asc_desc = $request->_asc_desc ?? 'ASC';
        $asc_cloumn =  $request->asc_cloumn ?? '_qty';
       $text_val = trim($request->_text_val);
        if($text_val =='%'){ $text_val=''; }


        
        $datas = DB::select("
SELECT t5.* from (

         SELECT 0 as id, id as _item_id, _item as _name,  _unit_id, _barcode,_warranty,null as _manufacture_date,null as _expire_date, _balance as _qty, _discount as _sales_discount, _vat as _sales_vat, _pur_rate, _sale_rate as _sales_rate,  1 as _branch_id, 1 as _cost_center_id, 1 as _store_id,1 as _store_salves_id,0 as _master_id, 0 as _purchase_detail_id ,_status, _unique_barcode, _kitchen_item 
            FROM inventories 
            WHERE    _status = 1 AND  (_barcode LIKE '%$text_val%' OR _item LIKE '%$text_val%' OR id LIKE '%$text_val%'  )  
                 AND _unique_barcode !=1 AND _kitchen_item=1 AND _balance = 0  
            
            UNION ALL

            SELECT id,_item_id, _item as _name, _unit_id, _barcode,_warranty, _manufacture_date,_expire_date, _qty,_sales_discount,_sales_vat, _pur_rate,_sales_rate,_branch_id,_cost_center_id,_store_id,_store_salves_id, _master_id,_purchase_detail_id,_status,_unique_barcode, 0 as _kitchen_item   
            FROM product_price_lists 
            WHERE  _status = 1 and  (_barcode like '%$text_val%' OR _item like '%$text_val%' OR id LIKE '%$text_val%'  ) 
                    and _branch_id in ($users->branch_ids) and _cost_center_id in ($users->cost_center_ids) 
                    AND _unique_barcode !=1  AND  _qty > 0 
              
                    ) as t5 order by $asc_cloumn $_asc_desc LIMIT $limit

            ");
        
        // $datas = DB::select(" select `id`, `_item` as `_name`, `_item_id`, `_unit_id`, `_barcode`,_warranty, `_manufacture_date`,_unique_barcode, `_expire_date`, `_qty`, `_sales_rate`, `_pur_rate`, `_sales_discount`, `_sales_vat`, `_purchase_detail_id`, `_master_id`, `_branch_id`, `_cost_center_id`, `_store_id`, `_store_salves_id` from `product_price_lists` where  `_status` = 1 and  (`_barcode` like '%$text_val%' OR `_item` like '%$text_val%' OR id LIKE '%$text_val%'  ) and `_branch_id` in ($users->branch_ids) and `_cost_center_id` in ($users->cost_center_ids) AND _unique_barcode !=1 AND  `_qty`> 0 order by $asc_cloumn $_asc_desc LIMIT $limit ");
        $datas["data"]=$datas;
        return json_encode( $datas);
    }


  public function itemDamageSearch(Request $request){
        $users = Auth::user();
        $limit = $request->limit ?? default_pagination();
        $_asc_desc = $request->_asc_desc ?? 'ASC';
        $asc_cloumn =  $request->asc_cloumn ?? '_qty';
       $text_val = trim($request->_text_val);
        if($text_val =='%'){ $text_val=''; }
        
        $datas = DB::select(" select `id`, `_item` as `_name`, `_item_id`, `_unit_id`, `_barcode`,_warranty, `_manufacture_date`,_unique_barcode, `_expire_date`, `_qty`, `_sales_rate`, `_pur_rate`, `_sales_discount`, `_sales_vat`, `_purchase_detail_id`, `_master_id`, `_branch_id`, `_cost_center_id`, `_store_id`, `_store_salves_id` from `product_price_lists` where  `_status` = 1 and  (`_barcode` like '%$text_val%' OR `_item` like '%$text_val%' OR id LIKE '%$text_val%'  ) and `_branch_id` in ($users->branch_ids) and `_cost_center_id` in ($users->cost_center_ids) AND   `_qty`> 0 order by $asc_cloumn $_asc_desc LIMIT $limit ");
        $datas["data"]=$datas;
        return json_encode( $datas);
    }

    public function itemSalesBarcodeSearch(Request $request){
     // return $request->all();
        $users = Auth::user();
        $category_id = $request->_item_category;
        $brach_id = intval($request->brach_id ?? 1);
        $store_id = intval($request->store_id ?? 1);
        $_cost_center_id = intval($request->_cost_center_id ?? 1);
        $_asc_desc = $request->_asc_desc ?? 'ASC';
        $asc_cloumn =  $request->asc_cloumn ?? 'available_qty';
         $text_val = trim($request->_text_val);
        if($text_val =='%'){ $text_val=''; }
        $limit=100;
        $_this_barcode='';

        $_pos_sales = $request->_pos_sales ?? 0;

        //First Check Unique Barcode or Model Barcode to compare barcode details table qty
        
if($_pos_sales ==1){
    $datas = DB::select("
                    SELECT t1.id as _row_id,t1._item_id as _id,t1._item_id as _item_id, t1._item,t2._image,t2._category_id as _category, t1._unit_id AS _unit, t1._barcode  AS _itemcode,t1._warranty, t1._manufacture_date,t1._expire_date, t1._qty  as available_qty,t1._sales_discount,t1._sales_vat as _vat, t1._pur_rate AS _purprice,t1._sales_rate  AS _saleprice,1 as _p_vat, t1._branch_id,t1._cost_center_id,t1._store_id,t1._store_salves_id, t1._master_id,t1._purchase_detail_id,t1._status,t1._unique_barcode, 0 as _kitchen_item   
                    FROM product_price_lists AS t1
                    INNER JOIN inventories AS t2 ON t2.id=t1._item_id
                    WHERE  t1._status = 1 AND  t1._barcode = ''+$text_val+'' 
                            AND t1._branch_id in ($users->branch_ids) AND t1._cost_center_id in ($users->cost_center_ids) 
                            AND t1._unique_barcode =1  AND  t1._qty > 0 ORDER BY t1._qty ASC LIMIT $limit  ");

}else{
    $datas = DB::select("
SELECT t5.* from (

         SELECT 0 as _row_id, id as _id,id as _item_id, _item,_image,_category_id as _category , _unit_id AS _unit, _barcode  AS _itemcode,_warranty,null as _manufacture_date,null as _expire_date, _balance  as available_qty, _discount as _sales_discount, _vat , _pur_rate AS _purprice, _sale_rate as _saleprice,1 as _p_vat,  ".$brach_id." as _branch_id, ".$_cost_center_id." as _cost_center_id, ".$store_id." as _store_id,1 as _store_salves_id,0 as _master_id, 0 as _purchase_detail_id ,_status, _unique_barcode, _kitchen_item 
            FROM inventories 
            WHERE    _status = 1 AND (_barcode like '%$text_val%' OR _item like '%$text_val%' OR id LIKE '%$text_val%'  ) AND _unique_barcode !=1 AND _kitchen_item=1 AND _balance = 0  
            
            UNION ALL

            SELECT t1.id as _row_id,t1._item_id as _id,t1._item_id as _item_id, t1._item,t2._image,t2._category_id as _category, t1._unit_id AS _unit, t1._barcode  AS _itemcode,t1._warranty, t1._manufacture_date,t1._expire_date, t1._qty  as available_qty,t1._sales_discount,t1._sales_vat as _vat, t1._pur_rate AS _purprice,t1._sales_rate  AS _saleprice,1 as _p_vat, t1._branch_id,t1._cost_center_id,t1._store_id,t1._store_salves_id, t1._master_id,t1._purchase_detail_id,t1._status,t1._unique_barcode, 0 as _kitchen_item   
            FROM product_price_lists AS t1
            INNER JOIN inventories AS t2 ON t2.id=t1._item_id
            WHERE  t1._status = 1 AND  (t1._barcode like '%$text_val%' OR t2._item like '%$text_val%' OR t2.id LIKE '%$text_val%'  )
                    AND t1._branch_id in ($users->branch_ids) AND t1._cost_center_id in ($users->cost_center_ids) 
                    AND t1._unique_barcode !=1  AND  t1._qty > 0 
              
                    ) as t5 order by $asc_cloumn $_asc_desc LIMIT $limit

            ");
}
         


        


        $_this_barcode=$text_val;
        $data["datas"]=$datas;
        $data["_this_barcode"]=$_this_barcode;
        $data["_search_type"]='unique_barcode';
        return json_encode( $data);
    }


    public function itemSalesEditBarcodeSearch(Request $request){
     // return $request->all();
        $users = Auth::user();
        $limit = $request->limit ?? default_pagination();
        $_asc_desc = $request->_asc_desc ?? 'ASC';
        $asc_cloumn =  $request->asc_cloumn ?? '_qty';
        $_master_id =  $request->_master_id;
       $text_val = trim($request->_text_val);
        if($text_val =='%'){ $text_val=''; }
        $_this_barcode='';

        //First Check Unique Barcode or Model Barcode to compare barcode details table qty
        // if qty =1 then we can deside that's it's an unique barcode then we fetch baroce base all information from product prince list table as we use without barcode version 

                            

     


         $datas = DB::select(" SELECT s1.id,s1._master_id, s1._name,s1._item_id,s1._unit_id, s1._barcode,s1._warranty,s1._unique_barcode, s1._manufacture_date, s1._expire_date,  s1._qty,s1._sales_rate, s1._pur_rate,  s1._sales_discount,s1._sales_vat, s1._purchase_detail_id, s1._branch_id, s1._cost_center_id,  s1._store_id,  s1._store_salves_id FROM (
SELECT id,_master_id, _item as _name, _item_id, _unit_id, _barcode,_warranty,_unique_barcode, _manufacture_date, _expire_date, _qty, _sales_rate, _pur_rate, _sales_discount, _sales_vat, _purchase_detail_id, _branch_id, _cost_center_id, _store_id, _store_salves_id 
from product_price_lists
where  _status = 1 and  (_barcode like '%$text_val%' OR _item like '%$text_val%' OR id LIKE '%$text_val%'  ) and _branch_id in ($users->branch_ids) and _cost_center_id in ($users->cost_center_ids) AND  _qty > 0
UNION ALL
SELECT t1._p_p_l_id as id,t1._purchase_invoice_no as _master_id,  t2._item as _name,t1._item_id,t2._unit_id as _unit_id, t1._barcode,t1._warranty,t2._unique_barcode, t1._manufacture_date, t1._expire_date,  t1._qty,t1._sales_rate, t1._rate AS _pur_rate,  t1._discount as _sales_discount, t1._vat AS _sales_vat, t1._purchase_detail_id,   t1._branch_id, t1._cost_center_id,  t1._store_id,  t1._store_salves_id
FROM sales_details AS t1
INNER JOIN inventories AS t2 ON t1._item_id=t2.id
where  t1._status = 1 and  (t1._barcode like '%$text_val%' OR t2._item like '%$text_val%' OR t2.id LIKE '%$text_val%'  ) and t1._branch_id in ($users->branch_ids) and t1._cost_center_id in ($users->cost_center_ids) AND  t1._qty> 0
   )  AS s1   ORDER BY s1._name ASC LIMIT $limit ");

        
          $_search_type='item_search';
         


        $_this_barcode=$text_val;
        $data["datas"]=$datas;
        $data["_search_type"]=$_search_type;
        $data["_this_barcode"]=$_this_barcode;
        return json_encode( $data);
    }


    public function Settings (Request $request){
        $data = ResturantFormSetting::first();
        if(empty($data)){
            $data = new ResturantFormSetting();
        }

        $_cash_ledger_ids = 0;
        $_cash_customer = $request->_cash_customer ?? [];
        if(sizeof($_cash_customer) > 0){
            $_cash_ledger_ids  =  implode(",",$_cash_customer);
        }
        
        $data->_default_inventory = $request->_default_inventory;
        $data->_default_sales = $request->_default_sales;
        $data->_default_discount = $request->_default_discount;
        $data->_default_cost_of_solds = $request->_default_cost_of_solds;
        $data->_default_service_charge = $request->_default_service_charge;
        $data->_default_other_charge = $request->_default_other_charge;
        $data->_default_delivery_charge = $request->_default_delivery_charge;
        $data->_show_barcode = $request->_show_barcode;
        $data->_show_vat = $request->_show_vat;
        $data->_show_store = $request->_show_store;
        $data->_show_self = $request->_show_self;
        $data->_default_vat_account = $request->_default_vat_account;
        $data->_inline_discount = $request->_inline_discount ?? 1;
        $data->_show_delivery_man = $request->_show_delivery_man ?? 1;
        $data->_show_sales_man = $request->_show_sales_man ?? 1;
        $data->_show_cost_rate = $request->_show_cost_rate ?? 1;
        $data->_show_manufacture_date = $request->_show_manufacture_date ?? 1;
        $data->_show_expire_date = $request->_show_expire_date ?? 1;
        $data->_show_p_balance = $request->_show_p_balance ?? 1;
        $data->_invoice_template = $request->_invoice_template ?? 1;
        $data->_cash_customer = $_cash_ledger_ids ?? 0;
        $data->_show_warranty =$request->_show_warranty ?? 0;
        $data->_defaut_customer =$request->_defaut_customer ?? 0;
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
        
         //return $request->all();
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
    $ResturantFormSetting = ResturantFormSetting::first();
    //_cash_customer_check($_cutomer_id,$_selected_customers,$_bill_amount,$_total)
  $check_cash_customers=  _cash_customer_check($request->_main_ledger_id,$ResturantFormSetting->_cash_customer,$request->_total,$request->_total_dr_amount);
  if($check_cash_customers=='no'){
     return redirect()->back()
     ->with('request',$request->all())
     ->with('error','Cash Customer Must Paid Full Amount!');
  }

        $_item_ids = $request->_item_id;
        $_barcodes = $request->_barcode ?? [];
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
        $_p_p_l_ids = $request->_p_p_l_id;
        $_purchase_invoice_nos = $request->_purchase_invoice_no;
        $_purchase_detail_ids = $request->_purchase_detail_id;
        $_discounts = $request->_discount;
        $_discount_amounts = $request->_discount_amount;
        $_manufacture_dates = $request->_manufacture_date;
        $_expire_dates = $request->_expire_date;
        $_ref_counters = $request->_ref_counter;
        $_warrantys = $request->_warranty;

        //for resturant 
        $_main_cost_center_id = $request->_main_cost_center_id ?? 1;
        $_sales_spot = $request->_sales_spot ?? 1;
        $_table_id = $request->_table_id ?? [];
        $__table_id_ids=0;;
        if(sizeof($_table_id) > 0){
            $__table_id_ids  =  implode(",",$_table_id);
        }


        $_served_by_ids = $request->_served_by_ids ?? [];
        $_served_by_ids_ids=0;
        if(sizeof($_served_by_ids) > 0){
            $_served_by_ids_ids  =  implode(",",$_served_by_ids);
        }

        $_delivery_status = $request->_delivery_status ?? 1;

        $_service_charge = $request->_service_charge ?? 0;
        $_other_charge = $request->_other_charge ?? 0;
        $_delivery_charge = $request->_delivery_charge ?? 0;

      DB::beginTransaction();
        try {

            $_p_balance = _l_balance_update($request->_main_ledger_id);

         $_sales_man_id = $request->_sales_man_id;
         $sales_man_name_leder = $request->sales_man_name_leder;
         $_delivery_man_id = $request->_delivery_man_id;
         $delivery_man_name_leder = $request->delivery_man_name_leder;
        
         $__sub_total = (float) $request->_sub_total;
         $__total = (float) $request->_total;
         $__discount_input = (float) $request->_discount_input;
         $__total_discount = (float) $request->_total_discount;

       $_print_value = $request->_print ?? 0;
         $users = Auth::user();
        $Sales = new ResturantSales();
        $Sales->_date = change_date_format($request->_date);
        $Sales->_time = date('H:i:s');
        $Sales->_order_ref_id = $request->_order_ref_id;
        $Sales->_order_number = $request->_order_number ?? '';
        $Sales->_referance = $request->_referance;
        $Sales->_ledger_id = $request->_main_ledger_id;
        $Sales->_user_id = $users->id;
        $Sales->_created_by = $users->id."-".$users->name;
        $Sales->_user_id = $users->id;
        $Sales->_user_name = $users->name;
        $Sales->_note = $request->_note;
        $Sales->_sub_total = $__sub_total;
        $Sales->_discount_input = $__discount_input;
        $Sales->_total_discount = $__total_discount;
        $Sales->_total_vat = $request->_total_vat;
        $Sales->_total =  $__total;
        $Sales->_branch_id = $request->_branch_id;
        $Sales->_address = $request->_address;
        $Sales->_phone = $request->_phone;
        $Sales->_delivery_man_id = $request->_delivery_man_id ?? 0;
        $Sales->_sales_man_id = $request->_sales_man_id ?? 0;
        $Sales->_sales_type = $request->_sales_type ?? 'sales';
        $Sales->_status = 1;
        $Sales->_lock = $request->_lock ?? 0;
        $Sales->_delivery_status = $request->_delivery_status ?? 0;
        $Sales->delivery_company_id = $request->delivery_company_id ?? 0;
        $Sales->_service_charge = $request->_service_charge ?? 0;
        $Sales->_other_charge = $request->_other_charge ?? 0;
        $Sales->_delivery_charge = $request->_delivery_charge ?? 0;
        $Sales->_table_id = $__table_id_ids ?? 0;
        $Sales->_served_by_ids = $_served_by_ids_ids ?? 0;
        $Sales->_sales_spot = $_sales_spot ?? 1;
        $Sales->_cost_center_id = $request->_main_cost_center_id ?? 1;
        $Sales->_store_id = $request->_master_store_id ?? 1;




        $Sales->save();
        $_master_id = $Sales->id; 
        //###########################
        // Purchase Master information Save End
        //###########################

        //Order Send to Kitchen
        $Kitchen = new Kitchen();
        $Kitchen->_res_sales_id = $_master_id;
        $Kitchen->_status = 0;
        $Kitchen->_lock = 0;
        $Kitchen->_created_by = $users->id."-".$users->name;
        $Kitchen->save();

        $_kitchen_order_id = $Kitchen->id;





        //###########################
        // Purchase Details information Save Start
        //###########################
        
       
        $_total_cost_value=0;

        if(sizeof($_item_ids) > 0){
            for ($i = 0; $i <sizeof($_item_ids) ; $i++) {
                 $item_info = Inventory::where('id',$_item_ids[$i])->first(); //Fetch Id wise Inventory Details

                $_total_cost_value += ($_rates[$i]*$_qtys[$i]);

                $ResturantDetails = new ResturantDetails();
                $ResturantDetails->_item_id = $_item_ids[$i];
                $ResturantDetails->_p_p_l_id = $_p_p_l_ids[$i] ?? 0;
                $ResturantDetails->_purchase_invoice_no = $_purchase_invoice_nos[$i] ?? 0;
                $ResturantDetails->_purchase_detail_id = $_purchase_detail_ids[$i] ?? 0;
                $ResturantDetails->_qty = $_qtys[$i];

                $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_p_p_l_ids[$i]] ?? '';
                $ResturantDetails->_barcode = $barcode_string;

                $ResturantDetails->_manufacture_date = $_manufacture_dates[$i] ?? '';
                $ResturantDetails->_expire_date = $_expire_dates[$i] ?? '';
                $ResturantDetails->_rate = $_rates[$i] ?? 0;
                $ResturantDetails->_warranty = $_warrantys[$i] ?? 0;
                $ResturantDetails->_sales_rate = $_sales_rates[$i];
                $ResturantDetails->_discount = $_discounts[$i] ?? 0;
                $ResturantDetails->_discount_amount = $_discount_amounts[$i] ?? 0;
                $ResturantDetails->_vat = $_vats[$i] ?? 0;
                $ResturantDetails->_vat_amount = $_vat_amounts[$i] ?? 0;
                $ResturantDetails->_value = $_values[$i] ?? 0;
                $ResturantDetails->_store_id = $_store_ids[$i] ?? 1;
                $ResturantDetails->_cost_center_id = $_main_cost_center[$i] ?? 1;
                $ResturantDetails->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $ResturantDetails->_branch_id = $_main_branch_id_detail[$i] ?? 1;
                $ResturantDetails->_no = $_master_id;
                $ResturantDetails->_kitchen_item = $item_info->_kitchen_item ?? 0;
                $ResturantDetails->_status = 1;
                $ResturantDetails->_created_by = $users->id."-".$users->name;
                $ResturantDetails->save();
                $_sales_details_id = $ResturantDetails->id;


                //Item Detail Data send to kitchen_finish_goods
                if($item_info->_kitchen_item ==1){
                    $KitchenFinishGoods = new KitchenFinishGoods();
                    $KitchenFinishGoods->_item_id  = $_item_ids[$i];
                    $KitchenFinishGoods->_p_p_l_id  = $_p_p_l_ids[$i] ?? 0;
                    $KitchenFinishGoods->_qty  = $_qtys[$i] ?? 0;
                    $KitchenFinishGoods->_rate  = $_rates[$i] ?? 0;
                    $KitchenFinishGoods->_sales_rate  = $_sales_rates[$i] ?? 0;
                    $KitchenFinishGoods->_discount  = $_discounts[$i] ?? 0;
                    $KitchenFinishGoods->_discount_amount  = $_discount_amounts[$i] ?? 0;
                    $KitchenFinishGoods->_vat  = $_vats[$i] ?? 0;
                    $KitchenFinishGoods->_vat_amount  = $_vat_amounts[$i] ?? 0;
                    $KitchenFinishGoods->_value  = $_values[$i] ?? 0;
                    $KitchenFinishGoods->_warranty  = $_warrantys[$i] ?? 0;
                    $KitchenFinishGoods->_barcode  = $_barcodes[$i] ?? '';
                    $KitchenFinishGoods->_purchase_invoice_no  = $_master_id;
                    $KitchenFinishGoods->_purchase_detail_id  = $_sales_details_id;
                    $KitchenFinishGoods->_manufacture_date  = $_manufacture_dates[$i] ?? '';
                    $KitchenFinishGoods->_expire_date  = $_expire_dates[$i] ?? '';
                    $KitchenFinishGoods->_no  = $_kitchen_order_id;
                    $KitchenFinishGoods->_branch_id  = $_main_branch_id_detail[$i] ?? 1;
                    $KitchenFinishGoods->_store_id  = $_store_ids[$i] ?? 1;
                    $KitchenFinishGoods->_cost_center_id  = $_main_cost_center[$i] ?? 1;
                    $KitchenFinishGoods->_store_salves_id  = $_store_salves_ids[$i] ?? '';
                    $KitchenFinishGoods->_status  = 1;
                    $KitchenFinishGoods->_coking  = 0;
                    $KitchenFinishGoods->_kitchen_item  = $item_info->_kitchen_item ?? 0;
                    $KitchenFinishGoods->_created_by  = $users->id."-".$users->name;
                    $KitchenFinishGoods->save();

                    //Item Detail Data send to kitchen_row_goods
                    $item_ingredians = MusakFourPointThree::with(['input_detail'])->where('_item_id',$_item_ids[$i])->first();
                    if($item_ingredians){
                        $input_detail = $item_ingredians->input_detail ?? [];
                        if(sizeof($input_detail) > 0){
                            foreach ($input_detail as $input_d) {
                                $conversion_qty = $input_d->conversion_qty ?? 1;
                                $conversion_unit_id = $input_d->_unit_id ?? 1;
                                


                                $_require_qty = (($_qtys[$i] ?? 0)* ($input_d->_qty ?? 0));
                                $_require_value = (($_require_qty ?? 0)* ($input_d->_rate ?? 0));
                                $KitchenRowGoods = new KitchenRowGoods();
                                $KitchenRowGoods->_item_id  = $input_d->_item_id;
                                $KitchenRowGoods->_p_p_l_id  = 0;
                                $KitchenRowGoods->_conversion_qty  = $conversion_qty;
                                $KitchenRowGoods->_unit_id  = $conversion_unit_id;

                                $KitchenRowGoods->_purchase_invoice_no  = 0;
                                $KitchenRowGoods->_purchase_detail_id  = 0;
                                $KitchenRowGoods->_qty  = $_require_qty ?? 0;
                                $KitchenRowGoods->_rate  = $input_d->_rate ?? 0;
                                $KitchenRowGoods->_value  = $_require_value ?? 0;
                                $KitchenRowGoods->_no  = $_kitchen_order_id;
                                $KitchenRowGoods->_branch_id  = $_main_branch_id_detail[$i] ?? 1;
                                $KitchenRowGoods->_store_id  = $_store_ids[$i] ?? 1;
                                $KitchenRowGoods->_cost_center_id  = $_main_cost_center[$i] ?? 1;
                                $KitchenRowGoods->_store_salves_id  = $_store_salves_ids[$i] ?? '';
                                $KitchenRowGoods->_status  = 1;
                                $KitchenRowGoods->_kitchen_item  = $item_info->_kitchen_item ?? 0;
                                $KitchenRowGoods->_created_by  = $users->id."-".$users->name;
                                $KitchenRowGoods->save();

                                
                            }// End of input Details
                        } // End of Check size of
                    } //End of ingredaints Check
                } //End of check Kitchen item yes or no

               
                $ProductPriceList = ProductPriceList::find($_p_p_l_ids[$i]);

                if($ProductPriceList){

                    $_p_qty = $ProductPriceList->_qty ?? 0;
                    $_unique_barcode = $ProductPriceList->_unique_barcode ?? 0;
                    //Barcode  deduction from old string data
                    if($_unique_barcode ==1){
                         $_old_barcode_strings =  $ProductPriceList->_barcode ?? "";
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
                    $_status = (($_p_qty - $_qtys[$i]) > 0) ? 1 : 0;
                    $ProductPriceList->_qty = ($_p_qty - $_qtys[$i]);
                    $ProductPriceList->_status = $_status;
                    $ProductPriceList->save();

                    /***************************************
                   Barcode insert into database section
                   _barcode_insert_update($modelName, $_p_p_id,$_item_id,$_no_id,$_no_detail_id,$_qty,$_barcode,$_status,$_return=0,$p=0)
                   IF RETURN ACTION THEN $_return = 1; and BarcodeDetail avoid 
                   [  $data->_no_id = $_no_id; $data->_no_detail_id = $_no_detail_id; ] use  $p=1;
                **************************************************/
                                 $product_price_id =  $ProductPriceList->id;
                             if($_unique_barcode ==1){
                                  if($barcode_string !=""){
                                       $barcode_array=  explode(",",$barcode_string);
                                       $_qty = 1;
                                       $_stat = 1;
                                       $_return=1;
                                       
                                       foreach ($barcode_array as $_b_v) {
                                        _barcode_insert_update('BarcodeDetail', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,1,1);
                                        _barcode_insert_update('SalesBarcode', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,0,0);
                                         
                                       }
                                    }
                             }else{
                                $_qty = $_qtys[$i] ?? 0;
                           $_stat = 1;
                           $_return=1;
                           $_b_v=$ProductPriceList->_barcode;

                            _barcode_insert_update('BarcodeDetail', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,1,1);
                                    _barcode_insert_update('SalesBarcode', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,0,0);
                        }

                             /*
                    Barcode insert into database section
                */

                                $ItemInventory = new ItemInventory();
                                $ItemInventory->_item_id =  $_item_ids[$i];
                                $ItemInventory->_item_name =  $item_info->_item ?? '';
                                 $ItemInventory->_unit_id =  $item_info->_unit_id ?? '';
                                $ItemInventory->_category_id = _item_category($_item_ids[$i]);
                                $ItemInventory->_date = change_date_format($request->_date);
                                $ItemInventory->_time = date('H:i:s');
                                $ItemInventory->_transection = "Restaurant Sales";
                                $ItemInventory->_transection_ref = $_master_id;
                                $ItemInventory->_transection_detail_ref_id = $_sales_details_id;
                                $ItemInventory->_qty = -($_qtys[$i]);
                                $ItemInventory->_rate = $_sales_rates[$i];
                                $ItemInventory->_cost_rate = $_rates[$i];
                                $ItemInventory->_manufacture_date = $_manufacture_dates[$i];
                                $ItemInventory->_expire_date = $_expire_dates[$i];
                                $ItemInventory->_cost_value = ($_qtys[$i]*$_rates[$i]);
                                $ItemInventory->_value = $_values[$i] ?? 0;
                                $ItemInventory->_branch_id = $_main_branch_id_detail[$i] ?? 1;
                                $ItemInventory->_store_id = $_store_ids[$i] ?? 1;
                                $ItemInventory->_cost_center_id = $_main_cost_center[$i] ?? 1;
                                $ItemInventory->_store_salves_id = $_store_salves_ids[$i] ?? '';
                                $ItemInventory->_status = 1;
                                $ItemInventory->_created_by = $users->id."-".$users->name;
                                $ItemInventory->save(); 
                                inventory_stock_update($_item_ids[$i]);

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

        
        $_default_inventory = $ResturantFormSetting->_default_inventory;
        $_default_sales = $ResturantFormSetting->_default_sales;
        $_default_discount = $ResturantFormSetting->_default_discount;
        $_default_vat_account = $ResturantFormSetting->_default_vat_account;
        $_default_cost_of_solds = $ResturantFormSetting->_default_cost_of_solds;
        $_default_service_charge = $ResturantFormSetting->_default_service_charge;
        $_default_other_charge = $ResturantFormSetting->_default_other_charge;
        $_default_delivery_charge = $ResturantFormSetting->_default_delivery_charge;

        $_ref_master_id=$_master_id;
        $_ref_detail_id=$_master_id;
        $_short_narration='N/A';
        $_narration = $request->_note;
        $_reference= $request->_referance;
        $_transaction= 'Restaurant Sales';
        $_date = change_date_format($request->_date);
        $_table_name = $request->_form_name;
        $_branch_id = $request->_branch_id;
        $_cost_center =  1;
        $_name =$users->name;
        
        if($__sub_total > 0){

            //#################
            // Account Receiveable Dr.
            //      Sales Cr
            //#################

            //Default Sales DR.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_sales),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$__sub_total,0,$_branch_id,$_cost_center,$_name,1);
           //Default Account Receivable  Cr.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_sales,0,$__sub_total,$_branch_id,$_cost_center,$_name,2);

            //#################
            // Cost of Goods Sold Dr.
            //      Inventory  Cr
            //#################

            //Cost of Goods Sold Dr.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_cost_of_solds,$_total_cost_value,0,$_branch_id,$_cost_center,$_name,3);
            //Inventory  Cr
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_cost_of_solds),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,0,$_total_cost_value,$_branch_id,$_cost_center,$_name,4);
        }

        if($__total_discount > 0){
             //#################
            // Sales Discount Dr.
            //      Account Receivable  Cr
            //#################
            //Default Discount
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_discount,$__total_discount,0,$_branch_id,$_cost_center,$_name,5);
            //  Account Receivable  Cr
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_discount),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,0,$__total_discount,$_branch_id,$_cost_center,$_name,6);
             
        
        }

         
         $__total_vat = (float) $request->_total_vat ?? 0;
        if($__total_vat > 0){
             //#################
            // Account Receivable Dr.
            //      Vat  Cr
            //#################
            //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_vat_account),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$request->_total_vat,0,$_branch_id,$_cost_center,$_name,7);
            //Account Receivable
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_vat_account,0,$request->_total_vat,$_branch_id,$_cost_center,$_name,8);
        
        }
        if($_service_charge > 0){
             //#################
            // Account Receivable Dr.
            //      _service_charge  Cr
            //#################
            //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_service_charge),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$_service_charge,0,$_branch_id,$_cost_center,$_name,9);
            //Account Receivable
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_service_charge,0,$_service_charge,$_branch_id,$_cost_center,$_name,10);
        
        }
        if($_other_charge > 0){
             //#################
            // Account Receivable Dr.
            //      _other_charge  Cr
            //#################
            //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_other_charge),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$_other_charge,0,$_branch_id,$_cost_center,$_name,11);
            //Account Receivable
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_other_charge,0,$_other_charge,$_branch_id,$_cost_center,$_name,12);
        
        }
        if($_delivery_charge > 0){
             //#################
            // Account Receivable Dr.
            //      _delivery_charge  Cr
            //#################
            //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_delivery_charge),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$_delivery_charge,0,$_branch_id,$_cost_center,$_name,13);
            //Account Receivable
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_delivery_charge,0,$_delivery_charge,$_branch_id,$_cost_center,$_name,14);
        
        }

       

        $_ledger_id = (array) $request->_ledger_id;
        $_short_narr = (array) $request->_short_narr;
        $_dr_amount = (array) $request->_dr_amount;
         $_cr_amount = (array) $request->_cr_amount;
        $_branch_id_detail = (array) $request->_branch_id_detail;
        $_cost_center = (array) $request->_cost_center;
       
        if(sizeof($_ledger_id) > 0){

                foreach($_ledger_id as $i=>$ledger) {
                    if($ledger !=""){
                       
                     // echo  $_cr_amount[$i];
                        $_account_type_id =  ledger_to_group_type($ledger)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($ledger)->_account_group_id;

                        $_total_dr_amount += $_dr_amount[$i] ?? 0;
                        $_total_cr_amount += $_cr_amount[$i] ?? 0;

                        $ResturantSalesAccount = new ResturantSalesAccount();
                        $ResturantSalesAccount->_no = $_master_id;
                        $ResturantSalesAccount->_account_type_id = $_account_type_id;
                        $ResturantSalesAccount->_account_group_id = $_account_group_id;
                        $ResturantSalesAccount->_ledger_id = $ledger;
                        $ResturantSalesAccount->_cost_center = $_cost_center[$i] ?? 0;
                        $ResturantSalesAccount->_branch_id = $_branch_id_detail[$i] ?? 0;
                        $ResturantSalesAccount->_short_narr = $_short_narr[$i] ?? 'N/A';
                        $ResturantSalesAccount->_dr_amount = $_dr_amount[$i];
                        $ResturantSalesAccount->_cr_amount = $_cr_amount[$i];
                        $ResturantSalesAccount->_status = 1;
                        $ResturantSalesAccount->_created_by = $users->id."-".$users->name;
                        $ResturantSalesAccount->save();

                        $_sales_account_id = $ResturantSalesAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$_master_id;
                        $_ref_detail_id=$_sales_account_id;
                        $_short_narration=$_short_narr[$i] ?? 'N/A';
                        $_narration = $request->_note;
                        $_reference= $request->_referance;
                        $_transaction= 'Restaurant Sales';
                        $_date = change_date_format($request->_date);
                        $_table_name ='resturant_sales_accounts';
                        $_account_ledger = $_ledger_id[$i];
                        $_dr_amount_a = $_dr_amount[$i] ?? 0;
                        $_cr_amount_a = $_cr_amount[$i] ?? 0;
                        $_branch_id_a = $_branch_id_detail[$i] ?? 0;
                        $_cost_center_a = $_cost_center[$i] ?? 0;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(9+$i));
                          
                    }


                }
            
                //Only Cash and Bank receive in account detail. This entry set automatically by program.
                if($_total_dr_amount > 0 && $users->_ac_type==1){
                         $_account_type_id =  ledger_to_group_type($request->_main_ledger_id)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($request->_main_ledger_id)->_account_group_id;
                        $ResturantSalesAccount = new ResturantSalesAccount();
                        $ResturantSalesAccount->_no = $_master_id;
                        $ResturantSalesAccount->_account_type_id = $_account_type_id;
                        $ResturantSalesAccount->_account_group_id = $_account_group_id;
                        $ResturantSalesAccount->_ledger_id = $request->_main_ledger_id;
                        $ResturantSalesAccount->_cost_center = $users->cost_center_ids;
                        $ResturantSalesAccount->_branch_id = $users->branch_ids;
                        $ResturantSalesAccount->_short_narr = 'Sales Payment';
                        $ResturantSalesAccount->_dr_amount = 0;
                        $ResturantSalesAccount->_cr_amount = $_total_dr_amount;
                        $ResturantSalesAccount->_status = 1;
                        $ResturantSalesAccount->_created_by = $users->id."-".$users->name;
                        $ResturantSalesAccount->save();

 
                        $_sales_account_id = $ResturantSalesAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$_master_id;
                        $_ref_detail_id=$_sales_account_id;
                        $_short_narration='Sales Payment';
                        $_narration = $request->_note;
                        $_reference= $request->_referance;
                        $_transaction= 'Restaurant Sales';
                        $_date = change_date_format($request->_date);
                        $_table_name ='resturant_sales_accounts';
                        $_account_ledger = $request->_main_ledger_id;
                        $_dr_amount_a = 0;
                        $_cr_amount_a = $_total_dr_amount ?? 0;
                        $_branch_id_a = $users->branch_ids;
                        $_cost_center_a = $users->cost_center_ids;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(20));
                }
            }

          $_l_balance = _l_balance_update($request->_main_ledger_id);
          $_pfix = _sales_pfix().$_master_id;
             \DB::table('resturant_sales')
             ->where('id',$_master_id)
             ->update(['_p_balance'=>$_p_balance,'_l_balance'=>$_l_balance,'_order_number'=>$_pfix]);

               //SMS SEND to Customer and Supplier
             $_send_sms = $request->_send_sms ?? '';
             if($_send_sms=='yes'){
                $_name = _ledger_name($request->_main_ledger_id);
                $_phones = $request->_phone;
                $messages = "Dear ".$_name.", Date: ".$request->_date." Invoice N0.".$_pfix." Invoice Amount: ".prefix_taka()."."._report_amount($request->_total).". Payment Amount. ".prefix_taka()."."._report_amount($_total_dr_amount).". Previous Balance ".prefix_taka()."."._report_amount($_p_balance).". Current Balance:".prefix_taka()."."._report_amount($_l_balance);
                  sms_send($messages, $_phones);
             }
             //End Sms Send to customer and Supplier

           DB::commit();
            return redirect()->back()
                ->with('success','Information save successfully')
                ->with('_master_id',$_master_id)
                ->with('_print_value',$_print_value)
                ->with('_sales_man_id',$_sales_man_id)
                ->with('sales_man_name_leder',$sales_man_name_leder)
                ->with('_delivery_man_id',$_delivery_man_id)
                ->with('delivery_man_name_leder',$delivery_man_name_leder);
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back()
           ->with('request',$request->all())
           ->with('danger','There is Something Wrong !');
        }

       
    }


  


    public function Print($id){
        $users = Auth::user();
        $page_name = $this->page_name;
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
       
         $data =  ResturantSales::with(['_master_branch','_master_details','s_account','_ledger'])->find($id);
         // dump($data );
         // die();
        $form_settings = ResturantFormSetting::first();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
         if($form_settings->_invoice_template==1){
            return view('backend.restaurant-sales.print',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }elseif($form_settings->_invoice_template==2){
            return view('backend.restaurant-sales.print_1',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }elseif($form_settings->_invoice_template==3){
            return view('backend.restaurant-sales.print_2',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }elseif($form_settings->_invoice_template==4){
            return view('backend.restaurant-sales.print_3',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }elseif($form_settings->_invoice_template==5){
            return view('backend.restaurant-sales.pos_template',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }else{
            return view('backend.restaurant-sales.print',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
         }
       
    }

    public function challanPrint($id){
        $users = Auth::user();
        $page_name = $this->page_name;
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
       
         $data =  ResturantSales::with(['_master_branch','_master_details','s_account','_ledger'])->find($id);
        $form_settings = ResturantFormSetting::first();
           $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
         $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        
            return view('backend.restaurant-sales.challan',compact('page_name','permited_branch','permited_costcenters','data','form_settings','permited_branch','permited_costcenters','store_houses'));
        
       
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
       
        $store_houses = StoreHouse::whereIn('_branch_id',explode(',',$users->cost_center_ids))->get();
        $form_settings = ResturantFormSetting::first();
        $inv_accounts = [];
        $p_accounts = [];
        $dis_accounts = [];
        $vat_accounts =[];
        $categories = ItemCategory::with(['_parents'])->select('id','_name','_parent_id')->orderBy('_name','asc')->get();
        $units = Units::orderBy('_name','asc')->get();
         $data =  ResturantSales::with(['_master_branch','_master_details','s_account','_ledger'])->where('_lock',0)->find($id);
         if(!$data){ return redirect()->back()->with('danger','You have no permission to edit or update !'); }
          $sales_number = ResturantDetails::where('_no',$id)->count();
           $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->where('_status',1)->get();

            $_steward_group = \DB::table("default_ledgers")->select('_steward_group')->first();
        $_stewards= AccountLedger::select('id','_name','_phone','_alious')->where('_account_group_id',$_steward_group->_steward_group ?? 0)->get();

        $tables = \DB::select(" SELECT id,_name,_number_of_chair,_status FROM `table_infos` WHERE _branch_id IN (".$users->branch_ids.") AND _status=1 ");


       return view('backend.restaurant-sales.edit',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','store_houses','form_settings','inv_accounts','p_accounts','dis_accounts','vat_accounts','categories','units','data','sales_number','_warranties','_stewards','tables'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
   
    public function update(Request $request)
    {
         
        $all_req= $request->all();
         $this->validate($request, [
            '_date' => 'required',
            '_branch_id' => 'required',
            '_main_ledger_id' => 'required',
            '_form_name' => 'required',
            '_sales_id' => 'required'
        ]);
    //###########################
    // Sales Master information Save Start
    //###########################

          $ResturantFormSetting = ResturantFormSetting::first();
    //_cash_customer_check($_cutomer_id,$_selected_customers,$_bill_amount,$_total)
            $check_cash_customers=  _cash_customer_check($request->_main_ledger_id,$ResturantFormSetting->_cash_customer,$request->_total,$request->_total_dr_amount);
            if($check_cash_customers=='no'){
                return redirect()->back()->with('error','Cash Customer Must Paid Full Amount!');
            }
            $_sales_id = $request->_sales_id;
            $_lock_check =  ResturantSales::where('_lock',0)->find($_sales_id); 
            if(!$_lock_check){ 
                return redirect()->back()->with('danger','You have no permission to edit or update !'); 
            }


        $_item_ids = $request->_item_id;
        //$_barcodes = $request->_barcode;
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
        $_p_p_l_ids = $request->_p_p_l_id;
        $_purchase_invoice_nos = $request->_purchase_invoice_no;
        $_purchase_detail_ids = $request->_purchase_detail_id;
        $_discounts = $request->_discount;
        $_discount_amounts = $request->_discount_amount;
        $_sales_detail_row_ids = $request->_sales_detail_row_id;
         $_manufacture_dates = $request->_manufacture_date;
        $_expire_dates = $request->_expire_date;
        $_ref_counters = $request->_ref_counter;
        $_warrantys = $request->_warranty;



        //for resturant 
        $_main_cost_center_id = $request->_main_cost_center_id ?? 1;
        $_sales_spot = $request->_sales_spot ?? 1;
        $_table_id = $request->_table_id ?? [];
        $__table_id_ids=0;
        if(sizeof($_table_id) > 0){
            $__table_id_ids  =  implode(",",$_table_id);
        }


        $_served_by_ids = $request->_served_by_ids ?? [];
        $_served_by_ids_ids=0;
        if(sizeof($_served_by_ids) > 0){
            $_served_by_ids_ids  =  implode(",",$_served_by_ids);
        }

        $_delivery_status = $request->_delivery_status ?? 1;

        $_service_charge = $request->_service_charge ?? 0;
        $_other_charge = $request->_other_charge ?? 0;
        $_delivery_charge = $request->_delivery_charge ?? 0;

            //====
        // Product Price list table update with previous sales details item
        // 
        //======
        $checkqty = array();
        $over_qtys = array();
      

//Prevoius Return information
     $previous_sales_details = ResturantDetails::where('_no',$_sales_id)->where('_status',1)->get();
    foreach ($previous_sales_details as $value) {
         $product_prices = ProductPriceList::where('_purchase_detail_id',$value->_purchase_detail_id)->first();
         if($product_prices){
            $new_qty = ($value->_qty+$product_prices->_qty);
             $_unique_barcode = $product_prices->_unique_barcode;
             $_old_new_barcode = $value->_barcode.",".$product_prices->_barcode;
             array_push($checkqty, ['id'=>$product_prices->_purchase_detail_id,'_qty'=>$new_qty,'_barcode'=>$_old_new_barcode,'_unique_barcode'=>$_unique_barcode]);
         }
         
    }



    foreach ($_purchase_detail_ids as $item_key=> $_item) {
        foreach ($checkqty as $check_item) {
              $barcode_string=$all_req[$_ref_counters[$item_key]."__barcode__".$_item_ids[$item_key]] ?? '';
          if($_unique_barcode ==1){
            if(strlen($barcode_string) > 0){ //Check Barcode Available
                if($_item==$check_item["id"]){ //Check Previous item id and Current Item id Same
                    $_req_barcode_array = explode(",",$barcode_string); // Barcode make array from string
                    foreach ($_req_barcode_array as $_bar_value) {
                        $_barcode_yes = str_contains($check_item["_barcode"], $_bar_value); //Check available barcode number with product price list table and previous purchase return details table
                        if(!$_barcode_yes){
                           // if Return false then its wrong barcode and send message
                            $msg = "You Input Wrong Barcode. Wrong Barcode Numer is- ". $_bar_value;
                            return redirect()->back()->with('danger',$msg);
                        }else{
                            //this section come after check available 
                          $check_model_or_unique =   explode(",",$check_item["_barcode"]); //Barcode string to array to check model barcode or unique barcode
                          if(sizeof(array_unique($check_model_or_unique)) ==1){ // if sizeof($check_model_or_unique)==1 then we desied that its used a model barcode 
                           
                              //Model Barcode and now check quantity
                                if($_item==$check_item["id"] && $_qtys[$item_key] > $check_item["_qty"] ){
                                    array_push($over_qtys, $_item); //if use model barcode and want to return more then purchase quantity then show a messge
                                 }
                          }
                           //Unique Barcode Olready Check as wrong Barcode number
                        }
                       
                    }
                }
            }


          }else{

                 //This section come when no barcode used for item purchase and purchase return
                //Here we need to check item id and item available qty
                if($_item==$check_item["id"] && $_qtys[$item_key] > $check_item["_qty"] ){
                    array_push($over_qtys, $_item); //If input Extra qty then shw a messge
                }
            }
            
        }
    }

    if(sizeof($over_qtys) > 0){
        return redirect()->back()
        ->with('request',$request->all())
        ->with('danger','You Can not Return More then available Qty !');
    }



           DB::beginTransaction();
           try {
        
       
        foreach ($previous_sales_details as $value) {

            $product_prices =ProductPriceList::where('id',$value->_p_p_l_id)->first();
            if($product_prices){
                    $new_qty = ($value->_qty+$product_prices->_qty);
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
                                    }//ENd of foreach
                            } //ENd of Siseof
                        } //End check old barcode empty
                        
                     }
                     $product_prices->_qty = $new_qty;
                     
                     $product_prices->save();
            } // End of product Price Check
             

        } //End of foreach loop

     

    ResturantDetails::where('_no', $_sales_id)
            ->update(['_status'=>0]);
    ItemInventory::where('_transection',"Restaurant Sales")
        ->where('_transection_ref',$_sales_id)
        ->update(['_status'=>0]);
    ResturantSalesAccount::where('_no',$_sales_id)                               
            ->update(['_status'=>0]);
    Accounts::where('_ref_master_id',$_sales_id)
                    ->where('_table_name',$request->_form_name)
                     ->update(['_status'=>0]);  
    Accounts::where('_ref_master_id',$_sales_id)
                    ->where('_table_name','restaurant_sales_accounts')
                     ->update(['_status'=>0]);  

    SalesBarcode::where('_no_id',$_sales_id)
                  ->update(['_status'=>0,'_qty'=>0]);

     $_p_balance = _l_balance_update($request->_main_ledger_id);
        
         $__sub_total = (float) $request->_sub_total;
         $__total = (float) $request->_total;
         $__discount_input = (float) $request->_discount_input;
         $__total_discount = (float) $request->_total_discount;

       $_print_value = $request->_print ?? 0;
         $users = Auth::user();
        $Sales = ResturantSales::find($_sales_id);
        $Sales->_date = change_date_format($request->_date);
        $Sales->_time = date('H:i:s');
        $Sales->_order_ref_id = $request->_order_ref_id;
        $Sales->_order_number = $request->_order_number ?? '';
        $Sales->_referance = $request->_referance;
        $Sales->_ledger_id = $request->_main_ledger_id;
        $Sales->_user_id = $request->_main_ledger_id;
        $Sales->_created_by = $users->id."-".$users->name;
        $Sales->_user_id = $users->id;
        $Sales->_user_name = $users->name;
        $Sales->_note = $request->_note;
        $Sales->_sub_total = $__sub_total;
        $Sales->_discount_input = $__discount_input;
        $Sales->_total_discount = $__total_discount;
        $Sales->_total_vat = $request->_total_vat;
        $Sales->_total =  $__total;
        $Sales->_branch_id = $request->_branch_id;
        $Sales->_address = $request->_address;
        $Sales->_phone = $request->_phone;
        $Sales->_delivery_man_id = $request->_delivery_man_id ?? 0;
        $Sales->_sales_man_id = $request->_sales_man_id ?? 0;
        $Sales->_sales_type = $request->_sales_type ?? 'sales';
        $Sales->_status = 1;
        $Sales->_lock = $request->_lock ?? 0;

        $Sales->_delivery_status = $request->_delivery_status ?? 0;
        $Sales->_service_charge = $request->_service_charge ?? 0;
        $Sales->_other_charge = $request->_other_charge ?? 0;
        $Sales->delivery_company_id = $request->delivery_company_id ?? 0;
        $Sales->_delivery_charge = $request->_delivery_charge ?? 0;
        $Sales->_table_id = $__table_id_ids ?? 0;
        $Sales->_served_by_ids = $_served_by_ids_ids ?? 0;
        $Sales->_sales_spot = $_sales_spot ?? 1;
         $Sales->_cost_center_id = $request->_main_cost_center_id ?? 1;
        $Sales->_store_id = $request->_master_store_id ?? 1;

        $Sales->save();
        $_master_id = $Sales->id;
                                           

        //###########################
        // Purchase Master information Save End
        //###########################

        //###########################
        // Purchase Details information Save Start
        //###########################

        //Order Send to Kitchen
        $Kitchen = Kitchen::where('_res_sales_id',$_master_id)->first();
        $Kitchen->_res_sales_id = $_master_id;
        $Kitchen->_status = 0;
        $Kitchen->_lock = 0;
        $Kitchen->_created_by = $users->id."-".$users->name;
        $Kitchen->save();
        $_kitchen_order_id = $Kitchen->id;
        KitchenFinishGoods::where('_no',$_kitchen_order_id)
                  ->update(['_status'=>0]);
        KitchenRowGoods::where('_no',$_kitchen_order_id)
                  ->update(['_status'=>0]);
      



        

       
        $_total_cost_value=0;

        if(sizeof($_item_ids) > 0){
            for ($i = 0; $i <sizeof($_item_ids) ; $i++) {
                $item_info = Inventory::where('id',$_item_ids[$i])->first();
                $_total_cost_value += ($_rates[$i]*$_qtys[$i]);
                if($_sales_detail_row_ids[$i] ==0){
                        $ResturantDetails = new ResturantDetails();
                }else{
                    $ResturantDetails = ResturantDetails::find($_sales_detail_row_ids[$i]);
                }

                $barcode_string=$all_req[$_ref_counters[$i]."__barcode__".$_item_ids[$i]] ?? '';
                $ResturantDetails->_barcode = $barcode_string;
                $ResturantDetails->_warranty = $_warrantys[$i] ?? 0;
                
                $ResturantDetails->_item_id = $_item_ids[$i];
                $ResturantDetails->_p_p_l_id = $_p_p_l_ids[$i];
                $ResturantDetails->_purchase_invoice_no = $_purchase_invoice_nos[$i];
                $ResturantDetails->_purchase_detail_id = $_purchase_detail_ids[$i];
                $ResturantDetails->_qty = $_qtys[$i];
                $ResturantDetails->_rate = $_rates[$i];
                $ResturantDetails->_sales_rate = $_sales_rates[$i];
                $ResturantDetails->_discount = $_discounts[$i] ?? 0;
                $ResturantDetails->_discount_amount = $_discount_amounts[$i] ?? 0;
                $ResturantDetails->_vat = $_vats[$i] ?? 0;
                $ResturantDetails->_vat_amount = $_vat_amounts[$i] ?? 0;
                $ResturantDetails->_value = $_values[$i] ?? 0;
                $ResturantDetails->_manufacture_date = $_manufacture_dates[$i];
                $ResturantDetails->_expire_date = $_expire_dates[$i];
                $ResturantDetails->_store_id = $_store_ids[$i] ?? 1;
                $ResturantDetails->_cost_center_id = $_main_cost_center[$i] ?? 1;
                $ResturantDetails->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $ResturantDetails->_branch_id = $_main_branch_id_detail[$i] ?? 1;
                $ResturantDetails->_no = $_master_id;
                $ResturantDetails->_kitchen_item = $item_info->_kitchen_item ?? 0;
                $ResturantDetails->_status = 1;
                $ResturantDetails->_created_by = $users->id."-".$users->name;
                $ResturantDetails->save();
                $_sales_details_id = $ResturantDetails->id;


                //Item Detail Data send to kitchen_finish_goods
                if($item_info->_kitchen_item ==1){
                    $KitchenFinishGoods = KitchenFinishGoods::where('_no',$_kitchen_order_id)->first();
                    if(!$KitchenFinishGoods){
                        $KitchenFinishGoods = new KitchenFinishGoods();
                    }
                    $KitchenFinishGoods->_item_id  = $_item_ids[$i];
                    $KitchenFinishGoods->_p_p_l_id  = $_p_p_l_ids[$i] ?? 0;
                    $KitchenFinishGoods->_qty  = $_qtys[$i] ?? 0;
                    $KitchenFinishGoods->_rate  = $_rates[$i] ?? 0;
                    $KitchenFinishGoods->_sales_rate  = $_sales_rates[$i] ?? 0;
                    $KitchenFinishGoods->_discount  = $_discounts[$i] ?? 0;
                    $KitchenFinishGoods->_discount_amount  = $_discount_amounts[$i] ?? 0;
                    $KitchenFinishGoods->_vat  = $_vats[$i] ?? 0;
                    $KitchenFinishGoods->_vat_amount  = $_vat_amounts[$i] ?? 0;
                    $KitchenFinishGoods->_value  = $_values[$i] ?? 0;
                    $KitchenFinishGoods->_warranty  = $_warrantys[$i] ?? 0;
                    $KitchenFinishGoods->_barcode  = $_barcodes[$i] ?? '';
                    $KitchenFinishGoods->_purchase_invoice_no  = $_master_id;
                    $KitchenFinishGoods->_purchase_detail_id  = $_sales_details_id;
                    $KitchenFinishGoods->_manufacture_date  = $_manufacture_dates[$i] ?? '';
                    $KitchenFinishGoods->_expire_date  = $_expire_dates[$i] ?? '';
                    $KitchenFinishGoods->_no  = $_kitchen_order_id;
                    $KitchenFinishGoods->_branch_id  = $_main_branch_id_detail[$i] ?? 1;
                    $KitchenFinishGoods->_store_id  = $_store_ids[$i] ?? 1;
                    $KitchenFinishGoods->_cost_center_id  = $_main_cost_center[$i] ?? 1;
                    $KitchenFinishGoods->_store_salves_id  = $_store_salves_ids[$i] ?? '';
                    $KitchenFinishGoods->_status  = 1;
                    $KitchenFinishGoods->_coking  = 0;
                    $KitchenFinishGoods->_kitchen_item  = $item_info->_kitchen_item ?? 0;
                    $KitchenFinishGoods->_created_by  = $users->id."-".$users->name;
                    $KitchenFinishGoods->save();

                    //Item Detail Data send to kitchen_row_goods
                    $item_ingredians = MusakFourPointThree::with(['input_detail'])->where('_item_id',$_item_ids[$i])->first();
                    if($item_ingredians){
                        $input_detail = $item_ingredians->input_detail ?? [];
                        if(sizeof($input_detail) > 0){
                            foreach ($input_detail as $input_d) {
                                $conversion_qty = $input_d->conversion_qty ?? 1;
                                $conversion_unit_id = $input_d->_unit_id ?? 1;
                                
                                $_require_qty = (($_qtys[$i] ?? 0)* ($input_d->_qty ?? 0));
                                $_require_value = (($_require_qty ?? 0)* ($input_d->_rate ?? 0));
                                $KitchenRowGoods = new KitchenRowGoods();

                                $KitchenRowGoods->_conversion_qty  = $conversion_qty;
                                $KitchenRowGoods->_unit_id  = $conversion_unit_id;
                                
                                $KitchenRowGoods->_item_id  = $input_d->_item_id;
                                $KitchenRowGoods->_p_p_l_id  = 0;
                                $KitchenRowGoods->_purchase_invoice_no  = 0;
                                $KitchenRowGoods->_purchase_detail_id  = 0;
                                $KitchenRowGoods->_qty  = $_require_qty ?? 0;
                                $KitchenRowGoods->_rate  = $input_d->_rate ?? 0;
                                $KitchenRowGoods->_value  = $_require_value ?? 0;
                                $KitchenRowGoods->_no  = $_kitchen_order_id;
                                $KitchenRowGoods->_branch_id  = $_main_branch_id_detail[$i] ?? 1;
                                $KitchenRowGoods->_store_id  = $_store_ids[$i] ?? 1;
                                $KitchenRowGoods->_cost_center_id  = $_main_cost_center[$i] ?? 1;
                                $KitchenRowGoods->_store_salves_id  = $_store_salves_ids[$i] ?? '';
                                $KitchenRowGoods->_status  = 1;
                                $KitchenRowGoods->_kitchen_item  = $item_info->_kitchen_item ?? 0;
                                $KitchenRowGoods->_created_by  = $users->id."-".$users->name;
                                $KitchenRowGoods->save();

                                
                            }// End of input Details
                        } // End of Check size of
                    } //End of ingredaints Check
                } //End of check Kitchen item yes or no

                

               $ProductPriceList = ProductPriceList::find($_p_p_l_ids[$i]);
                if($ProductPriceList){
                        $_p_qty = $ProductPriceList->_qty ?? 0;
                        $_unique_barcode = $ProductPriceList->_unique_barcode ?? 0;
                        if($_unique_barcode ==1){
                            //Barcode  deduction from old string data
                             $_old_barcode_strings =  $ProductPriceList->_barcode ?? "";
                             $_last_barcode_array = array();
                            $_new_barcode_array = array();
                            if($_old_barcode_strings !=""){
                                $_old_barcode_array = explode(",",$_old_barcode_strings);
                            }
                            if($barcode_string !=""){
                                $_new_barcode_array = explode(",",$barcode_string);
                            }

                            foreach ($_old_barcode_array as $_old_value) {
                              if(!in_array($_old_value, $_new_barcode_array)){
                               
                                array_push($_last_barcode_array, $_old_value);
                              }
                            }

                            if(sizeof($_last_barcode_array ) > 0){
                              $_new_last_barcode_string = implode(",",$_last_barcode_array);
                              
                            }else{
                              $_new_last_barcode_string = '';
                            }

                            $ProductPriceList->_barcode = $_new_last_barcode_string;

                        } //ENd Barcode  deduction from old string data
                        




                        $_status = (($_p_qty - $_qtys[$i]) > 0) ? 1 : 0;
                        $ProductPriceList->_qty = ($_p_qty - $_qtys[$i]);
                        $ProductPriceList->_status = $_status;
                        $ProductPriceList->save();


                        /***************************************
                        Barcode insert into database section
                        _barcode_insert_update($modelName, $_p_p_id,$_item_id,$_no_id,$_no_detail_id,$_qty,$_barcode,$_status,$_return=0,$p=0)
                        IF RETURN ACTION THEN $_return = 1; and BarcodeDetail avoid 
                        [  $data->_no_id = $_no_id; $data->_no_detail_id = $_no_detail_id; ] use  $p=1;
                        **************************************************/
                        $product_price_id =  $ProductPriceList->id ?? 0;
                        $_unique_barcode =  $ProductPriceList->_unique_barcode ?? 0;
                        if($_unique_barcode ==1){
                            if($barcode_string !=""){
                                $barcode_array=  explode(",",$barcode_string);
                                $_qty = 1;
                                $_stat = 1;
                                $_return=1;
                               foreach ($barcode_array as $_b_v) {
                                _barcode_insert_update('BarcodeDetail', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,1,1);
                                _barcode_insert_update('SalesBarcode', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,0,0);
                                 
                               }
                            }
                        }else{
                            $_qty = $_qtys[$i] ?? 0;
                                $_stat = 1;
                                $_return=1;
                            $_b_v = $ProductPriceList->_barcode;

                           _barcode_insert_update('BarcodeDetail', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,1,1);
                                _barcode_insert_update('SalesBarcode', $product_price_id,$_item_ids[$i],$_master_id,$_sales_details_id,$_qty,$_b_v,$_stat,0,0); 
                        }


                        // Barcode insert into database section

                        $ItemInventory = ItemInventory::where('_transection',"Restaurant Sales")
                                        ->where('_transection_ref',$_sales_id)
                                        ->where('_transection_detail_ref_id',$_sales_details_id)
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
                        $ItemInventory->_transection = "Restaurant Sales";
                        $ItemInventory->_transection_ref = $_master_id;
                        $ItemInventory->_transection_detail_ref_id = $_sales_details_id;
                        $ItemInventory->_qty = -($_qtys[$i]);
                        $ItemInventory->_rate = $_sales_rates[$i];
                        $ItemInventory->_cost_rate = $_rates[$i];
                        $ItemInventory->_cost_value = ($_qtys[$i]*$_rates[$i]);
                        $ItemInventory->_value = $_values[$i] ?? 0;

                        $ItemInventory->_manufacture_date = $_manufacture_dates[$i];
                        $ItemInventory->_expire_date = $_expire_dates[$i];
                        $ItemInventory->_branch_id = $_main_branch_id_detail[$i] ?? 1;
                        $ItemInventory->_store_id = $_store_ids[$i] ?? 1;
                        $ItemInventory->_cost_center_id = $_main_cost_center[$i] ?? 1;
                        $ItemInventory->_store_salves_id = $_store_salves_ids[$i] ?? '';
                        $ItemInventory->_status = 1;
                        $ItemInventory->_updated_by = $users->id."-".$users->name;
                        $ItemInventory->save(); 

                        inventory_stock_update($_item_ids[$i]);

                } //End of ProductPricelist check
                
            } // End of for loop
        } //End of size of check

        //###########################
        // Purchase Details information Save End
        //###########################

        //###########################
        // Purchase Account information Save End
        //###########################
        $_total_dr_amount = 0;
        $_total_cr_amount = 0;

        
        $_default_inventory = $ResturantFormSetting->_default_inventory;
        $_default_sales = $ResturantFormSetting->_default_sales;
        $_default_discount = $ResturantFormSetting->_default_discount;
        $_default_vat_account = $ResturantFormSetting->_default_vat_account;
        $_default_cost_of_solds = $ResturantFormSetting->_default_cost_of_solds;
        $_default_service_charge = $ResturantFormSetting->_default_service_charge;
        $_default_other_charge = $ResturantFormSetting->_default_other_charge;
        $_default_delivery_charge = $ResturantFormSetting->_default_delivery_charge;

        $_ref_master_id=$_master_id;
        $_ref_detail_id=$_master_id;
        $_short_narration='N/A';
        $_narration = $request->_note;
        $_reference= $request->_referance;
        $_transaction= 'Restaurant Sales';
        $_date = change_date_format($request->_date);
        $_table_name = $request->_form_name;
        $_branch_id = $request->_branch_id;
        $_cost_center =  1;
        $_name =$users->name;

      
        
         if($__sub_total > 0){

            //#################
            // Account Receiveable Dr.
            //      Sales Cr
            //#################

            //Default Sales DR.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_sales),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$__sub_total,0,$_branch_id,$_cost_center,$_name,1);
           //Default Account Receivable  Cr.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_sales,0,$__sub_total,$_branch_id,$_cost_center,$_name,2);

            //#################
            // Cost of Goods Sold Dr.
            //      Inventory  Cr
            //#################

            //Cost of Goods Sold Dr.
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_cost_of_solds,$_total_cost_value,0,$_branch_id,$_cost_center,$_name,3);
            //Inventory  Cr
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_cost_of_solds),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,0,$_total_cost_value,$_branch_id,$_cost_center,$_name,4);
        }

        if($__total_discount > 0){
             //#################
            // Sales Discount Dr.
            //      Account Receivable  Cr
            //#################
            //Default Discount
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_discount,$__total_discount,0,$_branch_id,$_cost_center,$_name,5);
            //  Account Receivable  Cr
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_discount),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,0,$__total_discount,$_branch_id,$_cost_center,$_name,6);
             
        
        }
         $__total_vat = (float) $request->_total_vat ?? 0;
        if($__total_vat > 0){
             //#################
            // Account Receivable Dr.
            //      Vat  Cr
            //#################
            //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_vat_account),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$request->_total_vat,0,$_branch_id,$_cost_center,$_name,7);
            //Account Receivable
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_vat_account,0,$request->_total_vat,$_branch_id,$_cost_center,$_name,8);
        
        }

        if($_service_charge > 0){
             //#################
            // Account Receivable Dr.
            //      _service_charge  Cr
            //#################
            //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_service_charge),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$_service_charge,0,$_branch_id,$_cost_center,$_name,9);
            //Account Receivable
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_service_charge,0,$_service_charge,$_branch_id,$_cost_center,$_name,10);
        
        }
        if($_other_charge > 0){
             //#################
            // Account Receivable Dr.
            //      _other_charge  Cr
            //#################
            //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_other_charge),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$_other_charge,0,$_branch_id,$_cost_center,$_name,11);
            //Account Receivable
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_other_charge,0,$_other_charge,$_branch_id,$_cost_center,$_name,12);
        
        }
        if($_delivery_charge > 0){
             //#################
            // Account Receivable Dr.
            //      _delivery_charge  Cr
            //#################
            //Default Vat Account
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_delivery_charge),$_narration,$_reference,$_transaction,$_date,$_table_name,$request->_main_ledger_id,$_delivery_charge,0,$_branch_id,$_cost_center,$_name,13);
            //Account Receivable
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($request->_main_ledger_id),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_delivery_charge,0,$_delivery_charge,$_branch_id,$_cost_center,$_name,14);
        
        }

       

        $_ledger_id = (array) $request->_ledger_id;
        $_short_narr = (array) $request->_short_narr;
        $_dr_amount = (array) $request->_dr_amount;
         $_cr_amount = (array) $request->_cr_amount;
        $_branch_id_detail = (array) $request->_branch_id_detail;
        $_cost_center = (array) $request->_cost_center;
        $purchase_account_ids =  $request->purchase_account_id;
       
        if(sizeof($_ledger_id) > 0){
                foreach($_ledger_id as $i=>$ledger) {
                    if($ledger !=""){
                       
                     // echo  $_cr_amount[$i];
                        $_account_type_id =  ledger_to_group_type($ledger)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($ledger)->_account_group_id;

                        $_total_dr_amount += $_dr_amount[$i] ?? 0;
                        $_total_cr_amount += $_cr_amount[$i] ?? 0;
                        $ResturantSalesAccount = ResturantSalesAccount::where('id',$purchase_account_ids[$i] ?? 0)
                                                            ->where('_ledger_id',$ledger)
                                                            ->first();
                        if(empty($PurchaseAccount)){
                             $ResturantSalesAccount = new ResturantSalesAccount();
                        }
                       
                        $ResturantSalesAccount->_no = $_master_id;
                        $ResturantSalesAccount->_account_type_id = $_account_type_id;
                        $ResturantSalesAccount->_account_group_id = $_account_group_id;
                        $ResturantSalesAccount->_ledger_id = $ledger;
                        $ResturantSalesAccount->_cost_center = $_cost_center[$i] ?? 0;
                        $ResturantSalesAccount->_branch_id = $_branch_id_detail[$i] ?? 0;
                        $ResturantSalesAccount->_short_narr = $_short_narr[$i] ?? 'N/A';
                        $ResturantSalesAccount->_dr_amount = $_dr_amount[$i];
                        $ResturantSalesAccount->_cr_amount = $_cr_amount[$i];
                        $ResturantSalesAccount->_status = 1;
                        $ResturantSalesAccount->_created_by = $users->id."-".$users->name;
                        $ResturantSalesAccount->save();

                        $_sales_account_id = $ResturantSalesAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$_master_id;
                        $_ref_detail_id=$_sales_account_id;
                        $_short_narration=$_short_narr[$i] ?? 'N/A';
                        $_narration = $request->_note;
                        $_reference= $request->_referance;
                        $_transaction= 'Restaurant Sales';
                        $_date = change_date_format($request->_date);
                        $_table_name ='restaurant_sales_accounts';
                        $_account_ledger = $_ledger_id[$i];
                        $_dr_amount_a = $_dr_amount[$i] ?? 0;
                        $_cr_amount_a = $_cr_amount[$i] ?? 0;
                        $_branch_id_a = $_branch_id_detail[$i] ?? 0;
                        $_cost_center_a = $_cost_center[$i] ?? 0;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(9+$i));
                          
                    }
                }

                 
                //Only Cash and Bank receive in account detail. This entry set automatically by program.
                if($_total_dr_amount > 0 && $users->_ac_type==1){
                         $_account_type_id =  ledger_to_group_type($request->_main_ledger_id)->_account_head_id;
                        $_account_group_id =  ledger_to_group_type($request->_main_ledger_id)->_account_group_id;
                        $ResturantSalesAccount = new ResturantSalesAccount();
                        $ResturantSalesAccount->_no = $_master_id;
                        $ResturantSalesAccount->_account_type_id = $_account_type_id;
                        $ResturantSalesAccount->_account_group_id = $_account_group_id;
                        $ResturantSalesAccount->_ledger_id = $request->_main_ledger_id;
                        $ResturantSalesAccount->_cost_center = $users->cost_center_ids;
                        $ResturantSalesAccount->_branch_id = $users->branch_ids;
                        $ResturantSalesAccount->_short_narr = 'N/A';
                        $ResturantSalesAccount->_dr_amount = 0;
                        $ResturantSalesAccount->_cr_amount = $_total_dr_amount;
                        $ResturantSalesAccount->_status = 1;
                        $ResturantSalesAccount->_created_by = $users->id."-".$users->name;
                        $ResturantSalesAccount->save();

                        $_sales_account_id = $ResturantSalesAccount->id;

                        //Reporting Account Table Data Insert
                        $_ref_master_id=$_master_id;
                        $_ref_detail_id=$_sales_account_id;
                        $_short_narration='N/A';
                        $_narration = $request->_note;
                        $_reference= $request->_referance;
                        $_transaction= 'Restaurant Sales';
                        $_date = change_date_format($request->_date);
                        $_table_name ='restaurant_sales_accounts';
                        $_account_ledger = $request->_main_ledger_id;
                        $_dr_amount_a = 0;
                        $_cr_amount_a = $_total_dr_amount ?? 0;
                        $_branch_id_a = $users->branch_ids;
                        $_cost_center_a = $users->cost_center_ids;
                        $_name =$users->name;
                        account_data_save($_ref_master_id,$_ref_detail_id,$_short_narration,$_narration,$_reference,$_transaction,$_date,$_table_name,$_account_ledger,$_dr_amount_a,$_cr_amount_a,$_branch_id_a,$_cost_center_a,$_name,(20));
                }
            }

 
             $_l_balance = _l_balance_update($request->_main_ledger_id);
              $_pfix = _sales_pfix().$_master_id;

            
             \DB::table('resturant_sales')
             ->where('id',$_master_id)
             ->update(['_p_balance'=>$_p_balance,'_l_balance'=>$_l_balance,'_order_number'=>$_pfix]);

              //SMS SEND to Customer and Supplier
              //SMS SEND to Customer and Supplier
             $_send_sms = $request->_send_sms ?? '';
             if($_send_sms=='yes'){
                $_name = _ledger_name($request->_main_ledger_id);
                $_phones = $request->_phone;
                $messages = "Dear ".$_name.", Date: ".$request->_date." Invoice N0.".$_pfix." Updated Invoice Amount: ".prefix_taka()."."._report_amount($request->_total).". Payment Amount. ".prefix_taka()."."._report_amount($_total_dr_amount).". Previous Balance ".prefix_taka()."."._report_amount($_p_balance).". Current Balance:".prefix_taka()."."._report_amount($_l_balance);
                  sms_send($messages, $_phones);
             }
             //End Sms Send to customer and Supplier
             //End Sms Send to customer and Supplier

          DB::commit();
          if(($request->_lock ?? 0) ==1){
                return redirect('restaurant-sales/print/'.$_master_id)
                ->with('success','Information save successfully');
          }else{
            return redirect()
                ->back()
                ->with('success','Information save successfully')
                ->with('_master_id',$_master_id)
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
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        return redirect()->back()->with('danger','You Can not delete this Information');

    }
}
