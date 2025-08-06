<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralSettings;
use App\Models\InvoicePrefix;
use Session;
use Auth;
use DB;

class GeneralSettingsController extends Controller
{
    /*
    * General Settings Update
    *
    *
    */
    function __construct()
    {
         $this->middleware('permission:admin-settings|admin-settings-store', ['only' => ['settings','settingsSave']]);
         $this->middleware('permission:lock-permission', ['only' => ['lockAction','allLockSystem','allLock']]);
         $this->middleware('permission:database-backup', ['only' => ['databaseBackup']]);
         $this->middleware('permission:invoice-prefix', ['only' => ['invoicePrefix']]);
         
    }

   

    public function databaseBackup(){
    	return database_backup_info();
    }



    public function invoicePrefix(){

         $data = InvoicePrefix::get();
        
        return view('backend.settings.invoice-prefix',compact('data'));
    }

    public function invoicePrefixStore(Request $request){
       // return $request->all();
        $ids = $request->id ??[];
        $_table_names = $request->_table_name ??[];
        $_prefixs = $request->_prefix ??[];
        if(sizeof($ids) > 0){
            foreach ($ids as $key => $value) {
               $InvoicePrefix =  InvoicePrefix::find($value);
               $InvoicePrefix->_prefix = $_prefixs[$key] ?? '' ;
               $InvoicePrefix->save();
            }
        }

         return redirect()->back()
                        ->with('success','Information Save successfully');
        
    }


    
    public function settings(Request $request){
        $settings = GeneralSettings::first();
       // $_accounts_group = \DB::table('account_groups')->select('id','_name')->where('_account_head_id',1)->get();

        $all_groups = \DB::select(" SELECT t1.id,t1._name,t1._code FROM account_groups AS t1  ");
        return view('backend.settings.index',compact('settings','all_groups'));
    }



    public function tableTruncate(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');  

        DB::table('accounts')->truncate();
        DB::table('barcode_details')->truncate();
        DB::table('damage_adjustments')->truncate();
        DB::table('damage_adjustment_details')->truncate();
        DB::table('damage_barcodes')->truncate();
        DB::table('inventories')->truncate();
        DB::table('item_categories')->truncate();
        DB::table('item_inventories')->truncate();
        DB::table('kitchens')->truncate();
        DB::table('kitchen_finish_goods')->truncate();
        DB::table('kitchen_row_goods')->truncate();
        DB::table('musak_four_point_threes')->truncate();
        DB::table('musak_four_point_three_additions')->truncate();
        DB::table('musak_four_point_three_inputs')->truncate();
        DB::table('productions')->truncate();
       // DB::table('product_price_lists')->truncate();
        DB::table('proforma_sales')->truncate();
        DB::table('proforma_sales_details')->truncate();
        DB::table('purchases')->truncate();
        DB::table('purchase_accounts')->truncate();
        DB::table('purchase_barcodes')->truncate();
        DB::table('purchase_details')->truncate();
        DB::table('purchase_orders')->truncate();
        DB::table('purchase_order_details')->truncate();
        DB::table('purchase_returns')->truncate();
        DB::table('purchase_return_accounts')->truncate();
        DB::table('purchase_return_barcodes')->truncate();
        DB::table('purchase_return_details')->truncate();
        DB::table('replacement_item_accounts')->truncate();
        DB::table('replacement_item_ins')->truncate();
        DB::table('replacement_item_outs')->truncate();
        DB::table('replacement_masters')->truncate();
        DB::table('rep_in_barcodes')->truncate();
        DB::table('rep_out_barcodes')->truncate();
        DB::table('restaurant_category_settings')->truncate();
        DB::table('resturant_details')->truncate();
        DB::table('resturant_sales')->truncate();
        DB::table('resturant_sales_accounts')->truncate();
        DB::table('sales')->truncate();
        DB::table('sales_accounts')->truncate();
        DB::table('sales_barcodes')->truncate();
        DB::table('sales_details')->truncate();
        DB::table('sales_orders')->truncate();
        DB::table('sales_order_details')->truncate();
        DB::table('sales_returns')->truncate();
        DB::table('sales_return_accounts')->truncate();
        DB::table('sales_return_barcodes')->truncate();
        DB::table('sales_return_details')->truncate();
        DB::table('steward_allocations')->truncate();
        DB::table('stock_ins')->truncate();
        DB::table('stock_outs')->truncate();
        DB::table('table_infos')->truncate();
        DB::table('units')->truncate();
        DB::table('unit_conversions')->truncate();
        DB::table('voucher_masters')->truncate();
        DB::table('voucher_master_details')->truncate();
        DB::table('warranty_accounts')->truncate();
        DB::table('warranty_details')->truncate();
        DB::table('warranty_masters')->truncate();
        DB::table('individual_replace_masters')->truncate();
        DB::table('individual_replace_in_accounts')->truncate();
        DB::table('individual_replace_out_accounts')->truncate();
       // DB::table('individual_replace_in_items')->truncate();
        DB::table('individual_replace_old_items')->truncate();
        DB::table('individual_replace_out_items')->truncate();

        DB::table('account_ledgers')->update(['_balance'=>0]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 

        return "Database Empty";
    }


    public function lockAction(Request $request){
        $_action = $request->_action;
        $_id = $request->_id;
        $_table_name = $request->_table_name;
        \DB::table($_table_name)->where('id',$_id)->update(['_lock'=>$_action]);
        return "ok";

    }

    public function allLock(){
        $users = \Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $page_name = "Transection Lock System";
        $previous_filter= Session::get('_filter_lock_system');

        

        $tables=['sales'=>'Sales','sales_returns'=>'Sales Return','purchases'=>'Purchase','purchase_returns'=>'Purchase Return','voucher_masters'=>'Voucher','damage_adjustments'=>'Damage'];
        return view('backend.settings.all-lock',compact('permited_branch','permited_costcenters','page_name','tables','previous_filter'));
    }


    public function allLockSystem(Request $request){

        $_action = $request->_action;
        $_table_name = $request->_table_name;
          $_datex =  change_date_format($request->_datex);
         $_datey=  change_date_format($request->_datey);
         $branches=$request->_branch_id ?? [];
        $cost_centers = $request->_cost_center ?? [];
        session()->put('_filter_lock_system', $request->all());
        $previous_filter= Session::get('_filter_lock_system');

       $lock_update=  DB::table($_table_name)
                ->whereIn('_branch_id',$branches);
                if($_table_name !='voucher_masters'){
                    $lock_update=$lock_update->whereIn('_cost_center_id',$cost_centers);
                }
                
                $lock_update=$lock_update->whereDate('_date','>=', $_datex)
                ->whereDate('_date','<=', $_datey)
                ->update(['_lock'=>$_action]);
         return redirect()->back()->with('success','Information Save successfully');

    }

    public function lockReset(){
         Session::flash('_filter_lock_system');
        return redirect()->back();
    }


    public function settingsSave(Request $request){

       // return $request->all();

        $_cash_groups = $request->_cash_group ?? [];
        $_cash_groups_string = implode(",",$_cash_groups);

        $_bank_groups = $request->_bank_group ?? [];
        $_bank_groups_string = implode(",",$_bank_groups);

        $_direct_inc_exp_headss = $request->_direct_inc_exp_heads ?? [];
        $_direct_inc_exp_headss_string = implode(",",$_direct_inc_exp_headss);

        $_indirect_inc_exp_headss = $request->_indirect_inc_exp_heads ?? [];
        $_indirect_inc_exp_headss_string = implode(",",$_indirect_inc_exp_headss);
       
    	if($request->id ==''){
    		$settings = new GeneralSettings();
    	}else{
    		$settings = GeneralSettings::find($request->id);
    	}
    	$settings->title = $request->title ?? '';
        $settings->_cash_group = $_cash_groups_string ?? '';
        $settings->_bank_group = $_bank_groups_string ?? '';
        $settings->_direct_inc_exp_heads = $_direct_inc_exp_headss_string ?? '';
        $settings->_indirect_inc_exp_heads = $_indirect_inc_exp_headss_string ?? '';

    	$settings->name = $request->name ?? '';
    	$settings->keywords = $request->keywords ?? '';
    	$settings->author = $request->author ?? '';
    	$settings->url = $request->url ?? '';
        $settings->_bin = $request->_bin ?? '';
        $settings->_tin = $request->_tin ?? '';
        $settings->_email = $request->_email ?? '';
        $settings->_phone = $request->_phone ?? '';
        $settings->_address = $request->_address ?? '';
        $settings->_sales_note = $request->_sales_note ?? '';
        $settings->_sales_return__note = $request->_sales_return__note ?? '';
        $settings->_purchse_note = $request->_purchse_note ?? '';
        $settings->_purchase_return_note = $request->_purchase_return_note ?? '';
        $settings->_top_title = $request->_top_title ?? '';
        $settings->_ac_type = $request->_ac_type ?? 0;
        $settings->_sms_service = $request->_sms_service ?? 0;
        $settings->_barcode_service = $request->_barcode_service ?? 0;
        // $settings->_bank_group = $request->_bank_group ?? 0;
        // $settings->_cash_group = $request->_cash_group ?? 0;
        $settings->_auto_lock = $request->_auto_lock ?? 0;
        $settings->_opening_ledger = $request->_opening_ledger ?? 0;
        $settings->_pur_base_model_barcode = $request->_pur_base_model_barcode ?? 0;
        $settings->_employee_group = $request->_employee_group ?? 0;
        $settings->_customer_incentive_ledger = $request->_customer_incentive_ledger ?? '';
        $settings->_baddebt_ledgers = $request->_baddebt_ledgers ?? '';
        $settings->_honorarium_ledger = $request->_honorarium_ledger ?? '';

        
        $settings->_sales_phones = $request->_sales_phones ?? '';
        $settings->_order_phones = $request->_order_phones ?? '';
        $settings->sms_url = $request->sms_url ?? '';
        $settings->sms_sender = $request->sms_sender ?? '';
        $settings->sms_secretkey = $request->sms_secretkey ?? '';
        $settings->sms_apikey = $request->sms_apikey ?? '';


        


    	if($request->hasFile('logo')){ 
                $logo = UserImageUpload($request->logo); 
                $settings->logo = $logo;
        }
        if($request->hasFile('small_logo')){ 
                $small_logo = UserImageUpload($request->small_logo); 
                $settings->small_logo = $small_logo;
        }
        if($request->hasFile('_water_mark_image')){ 
                $_water_mark_image = UserImageUpload($request->_water_mark_image); 
                $settings->_water_mark_image = $_water_mark_image;
        }
        if($request->hasFile('bg_image')){ 
                $bg_image = UserImageUpload($request->bg_image); 
                $settings->bg_image = $bg_image;
        }
        $settings->save();
        return redirect()->back()
                        ->with('success','Information Save successfully');
    }
}
