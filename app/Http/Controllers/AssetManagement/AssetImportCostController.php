<?php

namespace App\Http\Controllers\AssetManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetManagement\AssetImportCost;
use App\Models\AssetManagement\AssetImportCostDetail;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ProductPriceList;
use App\Models\Inventory;
use App\Models\ItemInventory;
use App\Models\GeneralSettings;
use PDO;
use DB;
use Auth;

class AssetImportCostController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:asset_import_cost_list|asset_import_cost_create|asset_import_cost_edit|asset_import_cost_delete', ['only' => ['index','store']]);
         $this->middleware('permission:asset_import_cost_create', ['only' => ['create','store']]);
         $this->middleware('permission:asset_import_cost_edit', ['only' => ['edit','update']]);
         $this->middleware('permission:asset_import_cost_delete', ['only' => ['destroy']]);
        $this->page_name = __('label.asset_import_cost');
    }


    public function import_cost_detail_ref(Request $request){
        $text_val = $request->text_val ?? '';

        $data = \App\Models\ProductPriceList::with(['_import_item_detail'])->where('id',$text_val)->get();
        
        return $data;

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $page_name = __('label.asset_import_cost');


        $data =AssetImportCost::with(['_created_by','_updated_by'])
      //  ->where('_purchase_type','Import')
        ->where('_status',1)
        ->orderBy('id','DESC')->get();
        return view('apps.asset-management.asset_import_cost.index',compact('page_name','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = __('label.asset_import_cost');
        $data =[];
        $units = \DB::table("units")->orderBy('_name','ASC')->get();
        $_asset_groups = \DB::table("account_group_configs")->first()->_asset_group ?? 0;
        $_asset_ledgers = \DB::select(" SELECT * FROM account_ledgers  where _account_group_id IN($_asset_groups) AND _status=1 ");

        $users = Auth::user();
       
      
        $branchs = \App\Models\Branch::orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
      
        $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));

        return view('apps.asset-management.asset_import_cost.create',compact('page_name','data','units','_asset_ledgers','permited_branch','permited_costcenters','permited_budgets','permited_organizations'));
    }

    public function import_asset_file_upload(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
 // DB::beginTransaction();
 //        try {
         $renew_type= $request->renew_type ?? 1;
         $_date= $request->_date ?? date('Y-m-d');

        // try {
            // Load the Excel file
            $file = $request->file('file');
            $data = Excel::toArray([], $file)[0]; // Fetch data as an array

//return dump($request->all());

            $datas = [];

            foreach ($data as $key => $row) {
                if ($key === 0) {
                    // Skip the header row
                    continue;
                }

                dump($row);

           
            }

            die('ok');

        // DB::commit();
            return back()->with('success', 'Members imported successfully.');
       // } catch (\Exception $e) {
       //     DB::rollback();
       //     return redirect()->back()
       //     ->with('request',$request->all())
       //     ->with('danger','There is Something Wrong !');
       //  }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

     // return $request->all();

         $request->validate([
            '_date'=>'required',
            '_supplier_name'=>'required',
            '_purchase_type'=>'required',
        ]);

       // try {
        $auth_user =\Auth::user();
        $users = $auth_user;

        $id                         = $request->id ?? '';
        $table                      = $request->_form_name ?? '';
        $organization_id            = $request->organization_id ?? 1;
        $_branch_id                 = $request->_branch_id ?? 1;
        $branch_id                  = $request->_branch_id ?? 1;
        $_cost_center_id            = $request->_cost_center_id ?? 1;
        $_budget_id                 = $request->_budget_id ?? 1;
        $_store_id                  = $request->_store_id ?? 1;


        if($id !=''){
            $purchase_all_details = AssetImportCostDetail::where('_no', $id)->where('_status',1)->get(); 

                foreach($purchase_all_details as $pd_item){

                    $_p_detail_id = $pd_item->id;
                    $_p_item_id = $pd_item->_item_id;
                    $_p_unit_conversion= $pd_item->_unit_conversion ?? 1;
                    $_p__qty= $pd_item->_qty ?? 0;
                    $_p_price_table_qty = ($_p_unit_conversion*$_p__qty);

                    $p_price_list_table = ProductPriceList::where('_input_type','import_purchase')
                                ->where('_purchase_detail_id',$_p_detail_id)
                                ->where('_item_id',$_p_item_id)
                                ->first();
                        $_p_old_qty =  $p_price_list_table->_qty ?? 0;
                        $p_new_qty = ($_p_old_qty -$_p_price_table_qty);

                    $p_price_list_table->_qty = ($_p_old_qty -$_p_price_table_qty);
                    $p_price_list_table->save();

                   // return $p_price_list_table;

                    
                }
        }
       
            $AssetImportCost                    = AssetImportCost::find($id);
        if(!empty($AssetImportCost)){

            $AssetImportCost->updated_by        = $auth_user->id;
            $AssetImportCost->updated_at        = date('Y-m-d H:i:s');
            $AssetImportCost->_order_number     = $request->_order_number ?? '';
        }else{
            $_order_number                      = make_order_number($table,$organization_id,$branch_id);
            $AssetImportCost                    = new AssetImportCost();
            $AssetImportCost->created_by        = $auth_user->id;
            $AssetImportCost->created_at        = date('Y-m-d H:i:s');
            $AssetImportCost->_order_number     = $_order_number;
        }
        
            $AssetImportCost->_date             = $request->_date ?? date('Y-m-d');
            $AssetImportCost->_purchase_type    = $request->_purchase_type ?? '';
            $AssetImportCost->_voucher_number   = $request->_voucher_number ?? '';
            $AssetImportCost->_supplier_name    = $request->_supplier_name ?? '';
            $AssetImportCost->_bank_name        = $request->_bank_name ?? '';
            $AssetImportCost->_branch_name      = $request->_branch_name ?? '';
            $AssetImportCost->_lc_no            = $request->_lc_no ?? '';
            $AssetImportCost->_lc_date          = $request->_lc_date ?? '';
            $AssetImportCost->_pi_no            = $request->_pi_no ?? '';
            $AssetImportCost->_pi_date          = $request->_pi_date ?? '';
            $AssetImportCost->_invoice_no       = $request->_invoice_no ?? '';
            $AssetImportCost->_invoice_date     = $request->_invoice_date ?? '';
            $AssetImportCost->_boe_no           = $request->_boe_no ?? '';
            $AssetImportCost->_boe_date         = $request->_boe_date ?? '';
            $AssetImportCost->_bl_no            = $request->_bl_no ?? '';
            $AssetImportCost->_bl_date          = $request->_bl_date ?? '';
            $AssetImportCost->_incoterms        = $request->_incoterms ?? '';
            $AssetImportCost->_import_currency  = $request->_import_currency ?? '';
            $AssetImportCost->_currency_rate    = $request->_currency_rate ?? '';
            $AssetImportCost->_date_of_arrival  = $request->_date_of_arrival ?? '';
            $AssetImportCost->_procurement_officer = $request->_procurement_officer ?? '';
            $AssetImportCost->_cnf_agent        = $request->_cnf_agent ?? '';
            $AssetImportCost->_cnf_agent_id     = $request->_cnf_agent_id ?? '';
            $AssetImportCost->_ammendment_date  = $request->_ammendment_date ?? '';
            $AssetImportCost->_ammendment_reason = $request->_ammendment_reason ?? '';


            $AssetImportCost->_bill_of_entry_no     = $request->_bill_of_entry_no ?? '';
            $AssetImportCost->_bill_of_entry_date   = $request->_bill_of_entry_date ?? '';
            $AssetImportCost->_import_cost_foreign  = $request->_import_cost_foreign ?? 0;
            $AssetImportCost->_import_cost_local    = $request->_import_cost_local ?? 0;
            $AssetImportCost->_note                 = $request->_note ?? '';
            $AssetImportCost->_status               = $request->_status ?? 1;
            $AssetImportCost->_lock                 = $request->_lock ?? 0;
            $AssetImportCost->organization_id       = $organization_id ?? 0;
            $AssetImportCost->_branch_id       = $_branch_id ?? 0;
            $AssetImportCost->_cost_center_id       = $_cost_center_id ?? 0;
            $AssetImportCost->_budget_id       = $_budget_id ?? 0;
            $AssetImportCost->_store_id       = $_store_id ?? 0;
            $AssetImportCost->save();
            $asset_cost_id                              = $AssetImportCost->id;
                $_order_number = $AssetImportCost->_order_number ?? '';




            $asset_import_cost_details_ids              = $request->asset_import_cost_details_id ?? [];
            $_asset_names                               = $request->_asset_name ?? [];
            $_asset_category_ids                        = $request->_asset_category_id ?? [];
            $_unit_ids                                  = $request->_unit_id ?? [];
            $_qtys                                      = $request->_qty ?? [];
            $_rate_usds                                 = $request->_rate_usd ?? [];
            $_cfr_value_usds                            = $request->_cfr_value_usd ?? [];
            $_currency_rate_usd_to_bdts                 = $request->_currency_rate_usd_to_bdt ?? [];
            $_cfr_value_bdts                            = $request->_cfr_value_bdt ?? [];
            $_insurance_bdts                            = $request->_insurance_bdt ?? [];
            $_lc_commision_bdts                         = $request->_lc_commision_bdt ?? [];
            $_custom_duty_bdts                          = $request->_custom_duty_bdt ?? [];
            $_other_cost_bdts                           = $request->_other_cost_bdt ?? [];
            $_asset_value_bdts                          = $request->_asset_value_bdt ?? [];

            $_item_ids                                  = $request->_item_id ?? [];
            $_asset_names                               = $request->_asset_name ?? [];
            $_unit_ids                                  = $request->_unit_id ?? [];
            $_qtys                                      = $request->_qty ?? [];
            $_rate_usds                                 = $request->_rate_usd ?? [];
            $_cfr_value_usds                            = $request->_cfr_value_usd ?? [];
            $_currency_rate_usd_to_bdts                 = $request->_currency_rate_usd_to_bdt ?? [];
            $_cfr_value_bdts            = $request->_cfr_value_bdt ?? [];
            $_insurance_bdts            = $request->_insurance_bdt ?? [];
            $_lc_commision_bdts         = $request->_lc_commision_bdt ?? [];
            $_custom_duty_bdts          = $request->_custom_duty_bdt ?? [];
            $_custom_duty_tax_aits      = $request->_custom_duty_tax_ait ?? [];
            $_custom_duty_tax_ait_2nds  = $request->_custom_duty_tax_ait_2nd ?? [];
            $_customer_other_charge_others = $request->_customer_other_charge_other ?? [];
            $_port_charges              = $request->_port_charge ?? [];
            $_port_charge_aits          = $request->_port_charge_ait ?? [];
            $_shiping_agent_charges     = $request->_shiping_agent_charge ?? [];
            $_shiping_agent_deduction_charge_2nds = $request->_shiping_agent_deduction_charge_2nd ?? [];
            $_deport_charges            = $request->_deport_charge ?? [];
            $_container_damage_charges  = $request->_container_damage_charge ?? [];
            $_cnf_agen_commisions       = $request->_cnf_agen_commision ?? [];
            $_installation_costs        = $request->_installation_cost ?? [];
            $_total_initial_costs        = $request->_total_initial_cost ?? [];
            $_other_costs               = $request->_other_cost ?? [];
            $_salvage_values            = $request->_salvage_value ?? [];
            $_depreciable_asset_values  = $request->_depreciable_asset_value ?? [];
            $_other_cost_bdts           = $request->_other_cost_bdt ?? [];
            $_asset_value_bdts          = $request->_asset_value_bdt ?? [];
            $_remarkss                  = $request->_remarks ?? [];

            $total_qty                  = $request->total_qty ?? 0;
            $total_cfr_value_usd        = $request->total_cfr_value_usd ?? 0;
            $total_cfr_value_bdt        = $request->total_cfr_value_bdt ?? 0;
            $total_insurance_bdt        = $request->total_insurance_bdt ?? 0;
            $total_lc_commision_bdt     = $request->total_lc_commision_bdt ?? 0;
            $total_custom_duty_bdt      = $request->total_custom_duty_bdt ?? 0;
            $total_custom_duty_tax_ait  = $request->total_custom_duty_tax_ait ?? 0;
            $total_custom_duty_tax_ait_2nd = $request->total_custom_duty_tax_ait_2nd ?? 0;
            $total_customer_other_charge_other = $request->total_customer_other_charge_other ?? 0;
            $total_port_charge          = $request->total_port_charge ?? 0;
            $total_port_charge_ait      = $request->total_port_charge_ait ?? 0;
            $total_shiping_agent_charge = $request->total_shiping_agent_charge ?? 0;
            $total_shiping_agent_deduction_charge_2nd = $request->total_shiping_agent_deduction_charge_2nd ?? 0;
            $total_deport_charge        = $request->total_deport_charge ?? 0;
            $total_container_damage_charge = $request->total_container_damage_charge ?? 0;
            $total_cnf_agen_commision   = $request->total_cnf_agen_commision ?? 0;
            $total_installation_cost    = $request->total_installation_cost ?? 0;
            $total_other_cost           = $request->total_other_cost ?? 0;
            $total_salvage_value        = $request->total_salvage_value ?? 0;
            $total_depreciable_asset_value = $request->total_depreciable_asset_value ?? 0;
            $total_other_cost_bdt       = $request->total_other_cost_bdt ?? 0;
            $total_asset_value_bdt      = $request->total_asset_value_bdt ?? 0;
            $_currency_rate             = $request->_currency_rate ?? 1;
            $total_total_initial_cost             = $request->total_total_initial_cost ?? 0;
            if($_currency_rate ==''){
                $_currency_rate = 1;
            }




            AssetImportCostDetail::where('_no',$asset_cost_id)->update(['_status'=>0]);

            $asset_ledger_amount=[];

            if(sizeof($asset_import_cost_details_ids) > 0){
                foreach ($asset_import_cost_details_ids as $key => $value) {
                    $row_id = $asset_import_cost_details_ids[$key] ?? '';
                    
                        $AssetImportCostDetail = AssetImportCostDetail::find($row_id);
                    if(!empty($AssetImportCostDetail)){
                        $AssetImportCostDetail->updated_by          = $auth_user->id;
                        $AssetImportCostDetail->updated_at          = date('Y-m-d H:i:s');
                    }else{
                        $AssetImportCostDetail                      = new AssetImportCostDetail();
                        $AssetImportCostDetail->created_by          = $auth_user->id;
                        $AssetImportCostDetail->created_at          = date('Y-m-d H:i:s');
                    }

                    $item_info= \DB::table("inventories as t1")
                                    ->join('item_categories as t2','t1._category_id','t2.id')
                                    ->select('t1.id','t1._item as _name','t1._category_id','t1._unit_id','t1._code','t2.asset_ledger_id','t2._name as cat_name')
                                     ->where('t1.id',$_item_ids[$key])->first();
                    $item_category_id = $item_info->_category_id ?? 0;
                    $asset_ledger_id = $item_info->asset_ledger_id ?? 0;
                    $_unit_id = $item_info->_unit_id ?? 0;

                    $asset_ledger_amount[$asset_ledger_id][]=$_total_initial_costs[$key] ?? 0;


                    $AssetImportCostDetail->_no                     = $asset_cost_id ?? '';
                    $AssetImportCostDetail->_item_id                = $_item_ids[$key] ?? 0;
                    $AssetImportCostDetail->_asset_category_id      = $item_category_id ?? 0;
                    $AssetImportCostDetail->_asset_name             = $_asset_names[$key] ?? 0;
                    $AssetImportCostDetail->_unit_id                = $_unit_id ?? 0;
                    $AssetImportCostDetail->_qty                    = $_qtys[$key] ?? 0;
                    $AssetImportCostDetail->_rate_usd               = $_rate_usds[$key] ?? 0;
                    $AssetImportCostDetail->_cfr_value_usd          = $_cfr_value_usds[$key] ?? 0;
                    $AssetImportCostDetail->_cfr_value_bdt          = $_cfr_value_bdts[$key] ?? 0;
                    $AssetImportCostDetail->_currency_rate_usd_to_bdt = $_currency_rate_usd_to_bdts[$key] ?? 0;
                    $AssetImportCostDetail->_insurance_bdt          = $_insurance_bdts[$key] ?? 0;
                    $AssetImportCostDetail->_lc_commision_bdt       = $_lc_commision_bdts[$key] ?? 0;
                    $AssetImportCostDetail->_custom_duty_bdt        = $_custom_duty_bdts[$key] ?? 0;
                    $AssetImportCostDetail->_rd                     = $_rds[$key] ?? 0;
                    $AssetImportCostDetail->_sd                     = $_sds[$key] ?? 0;
                    $AssetImportCostDetail->_vat                    = $_vats[$key] ?? 0;
                    $AssetImportCostDetail->_at                     = $_ats[$key] ?? 0;
                    $AssetImportCostDetail->_atv                    = $_atvs[$key] ?? 0;
                    $AssetImportCostDetail->_custom_duty_tax_ait    = $_custom_duty_tax_aits[$key] ?? 0;
                    $AssetImportCostDetail->_custom_duty_tax_ait_2nd= $_custom_duty_tax_ait_2nds[$key] ?? 0;
                    $AssetImportCostDetail->_customer_other_charge_other = $_customer_other_charge_others[$key] ?? 0;
                    $AssetImportCostDetail->_port_charge            = $_port_charges[$key] ?? 0;
                    $AssetImportCostDetail->_port_charge_ait        = $_port_charge_aits[$key] ?? 0;
                    $AssetImportCostDetail->_shiping_agent_charge   = $_shiping_agent_charges[$key] ?? 0;
                    $AssetImportCostDetail->_shiping_agent_deduction_charge_2nd = $_shiping_agent_deduction_charge_2nds[$key] ?? 0;
                    $AssetImportCostDetail->_deport_charge          = $_deport_charges[$key] ?? 0;
                    $AssetImportCostDetail->_container_damage_charge = $_container_damage_charges[$key] ?? 0;
                    $AssetImportCostDetail->_cnf_agen_commision     = $_cnf_agen_commisions[$key] ?? 0;
                    $AssetImportCostDetail->_installation_cost      = $_installation_costs[$key] ?? 0;
                    $AssetImportCostDetail->_other_cost             = $_other_costs[$key] ?? 0;
                    $AssetImportCostDetail->_total_initial_cost     = $_total_initial_costs[$key] ?? 0;
                    $AssetImportCostDetail->_salvage_value          = $_salvage_values[$key] ?? 0;
                    $AssetImportCostDetail->_depreciable_asset_value= $_depreciable_asset_values[$key] ?? 0;
                    $AssetImportCostDetail->_cv                     = $_cvs[$key] ?? 0;
                    $AssetImportCostDetail->_scv                    = $_scvs[$key] ?? 0;
                    $AssetImportCostDetail->_df                     = $_dfs[$key] ?? 0;
                    $AssetImportCostDetail->_itc                    = $_itcs[$key] ?? 0;
                    $AssetImportCostDetail->_dfv                    = $_dfvs[$key] ?? 0;
                    $AssetImportCostDetail->_pf                     = $_pfs[$key] ?? 0;
                    $AssetImportCostDetail->_other_cost_bdt         = $_other_cost_bdts[$key] ?? 0;
                    $AssetImportCostDetail->_asset_value_bdt        = $_asset_value_bdts[$key] ?? 0;
                    $AssetImportCostDetail->_remarks                = $_remarkss[$key] ?? '';
                    $AssetImportCostDetail->_status                 = $_statuss[$key] ?? 1;
                    $AssetImportCostDetail->save();

                    $purchase_id                                    = $asset_cost_id;
                    $_purchase_detail_id                            = $AssetImportCostDetail->id;

                    //Item Insert Into product_price_list 


                $ProductPriceList = ProductPriceList::where('_master_id',$purchase_id)
                                    ->where('_purchase_detail_id',$_purchase_detail_id)
                                    ->where('_input_type','import_purchase')
                                    ->first();
                if(empty($ProductPriceList)){
                    $ProductPriceList = new ProductPriceList();
                    $ProductPriceList->_created_by = $users->id."-".$users->name;
                }
                
               // $ProductPriceList->_barcode =$barcode_string ?? '';

                $general_settings =GeneralSettings::select('_pur_base_model_barcode')->first();
                $item_info        = \App\Models\Inventory::where('id',$_item_ids[$key])->first();

                $ProductPriceList->_item_id         = $_item_ids[$key] ?? 0;
                $ProductPriceList->_item            = $item_info->_item ?? '';
                $ProductPriceList->_unique_barcode  = $item_info->_unique_barcode ?? 0;
                $ProductPriceList->_warranty        = $item_info->_warranty ?? 0;
                $ProductPriceList->_unit_id         =  $item_info->_unit_id ?? 1;
                $ProductPriceList->_manufacture_date = null;
                $ProductPriceList->_expire_date     =  null;
                $ProductPriceList->_input_type     =  'import_purchase';
                $ProductPriceList->_table_name     =  'asset_import_costs';

                $_p_old_qty                         =  $ProductPriceList->_qty ?? 0;
                $p_update_new_qty                   = ($_p_old_qty + $_qtys[$key] ?? 0);
                //$ProductPriceList->_qty = ($_qtys[$i] * $conversion_qtys[$i] ?? 1);
                $ProductPriceList->_qty             = $p_update_new_qty ?? 0;

                $ProductPriceList->_sales_rate          = $item_info->_sale_rate ?? 0;
                if($p_update_new_qty > 0){
                $ProductPriceList->_pur_rate            = ($_total_initial_costs[$key] / $p_update_new_qty ?? 1);
                    }
                 //Unit Conversion section
                $ProductPriceList->_transection_unit    = $item_info->_unit_id;
                $ProductPriceList->_unit_conversion     = 1;
                $ProductPriceList->_base_unit           = $item_info->_unit_id;
                $ProductPriceList->_unit_id             = $item_info->_unit_id;

                
                $ProductPriceList->_sales_discount      = $item_info->_discount ?? 0;
                $ProductPriceList->_sales_vat           = $item_info->_vat ?? 0;;
                $ProductPriceList->_value               =$_total_initial_costs[$key] ?? 0;
                $ProductPriceList->_purchase_detail_id  =$_purchase_detail_id;
                $ProductPriceList->_master_id           = $purchase_id;
                $ProductPriceList->_p_discount_input    = $_discounts[$key] ?? 0;
                $ProductPriceList->_p_discount_amount   = $_discount_amounts[$key] ?? 0;
                $ProductPriceList->_p_vat               = $_vats[$key] ?? 0;
                $ProductPriceList->_p_vat_amount        = $_vat_amounts[$key] ?? 0;
                $ProductPriceList->organization_id      = $organization_id ?? 1;
                $ProductPriceList->_branch_id           = $_branch_id ?? 1;
                $ProductPriceList->_store_id            = $_store_id ?? 1;
                $ProductPriceList->_cost_center_id      = $_cost_center_id ?? 1;
                $ProductPriceList->_budget_id           = $_budget_id ?? 1;
                $ProductPriceList->_store_salves_id     = $_store_salves_ids[$key] ?? '';
                $ProductPriceList->_status              = 1;
                $ProductPriceList->_updated_by          = $users->id."-".$users->name;
                $ProductPriceList->save();



                $product_price_id =  $ProductPriceList->id;
                $_unique_barcode =  $ProductPriceList->_unique_barcode;



                $ItemInventory = ItemInventory::where('_transection',"Purchase")
                                    ->where('_transection_ref',$purchase_id)
                                    ->where('_transection_detail_ref_id',$_purchase_detail_id)
                                    ->first();
                if(empty($ItemInventory)){
                    $ItemInventory              = new ItemInventory();
                    $ItemInventory->_created_by = $users->id."-".$users->name;
                }    


                
                $ItemInventory->_item_id        =  $_item_ids[$key] ?? 0;
                $ItemInventory->_item_name      =  $item_info->_item ?? '';
                $ItemInventory->_unit_id        =  $item_info->_unit_id ?? '';
                $ItemInventory->_category_id    = _item_category($_item_ids[$key] ?? 0);
                $ItemInventory->_date           = change_date_format($request->_date);
                $ItemInventory->_time           = date('H:i:s');
                $ItemInventory->_transection    = "import_purchase";
                $ItemInventory->_transection_ref = $purchase_id;
                $ItemInventory->_transection_detail_ref_id = $_purchase_detail_id;

                $ItemInventory->_qty            = $_qtys[$key] ?? 0;
                $ItemInventory->_rate           = $item_info->_sale_rate ?? 0;
                   if($p_update_new_qty > 0){
                $ItemInventory->_cost_rate      = ($_total_initial_costs[$key] / $p_update_new_qty ?? 1);
            }
                  //Unit Conversion section

                  //Unit Conversion section
                $ItemInventory->_transection_unit    = $item_info->_unit_id;
                $ItemInventory->_unit_conversion     = 1;
                $ItemInventory->_base_unit           = $item_info->_unit_id;
                $ItemInventory->_unit_id             = $item_info->_unit_id;

               

                
                $ItemInventory->_cost_value         = $_total_initial_costs[$key] ?? 0;
                $ItemInventory->_value              = $_total_initial_costs[$key] ?? 0;
                $ItemInventory->_branch_id          = $_branch_id ?? 1;
                $ItemInventory->organization_id          = $organization_id ?? 1;
                $ItemInventory->_store_id           = $_store_id ?? 1;
                $ItemInventory->_cost_center_id     = $_cost_center_id ?? 1;
                $ItemInventory->_store_salves_id    = $_store_salves_ids[$key] ?? '';
                $ItemInventory->_status             = 1;
                $ItemInventory->_updated_by         = $users->id."-".$users->name;
                $ItemInventory->save(); 
                inventory_stock_update($_item_ids[$key] ?? 0);

                }
            }


            // Voucher Entry

            $_note                  = $request->_note ?? '';
            $_voucher_number        = $request->_voucher_number ?? '';
            $_voucher_type          = $request->_voucher_type ?? 'JV';
            $organization_id        = $request->organization_id ?? 1;
            $_code                  = $request->_voucher_number ?? '';
          

            $_print_value                   = $request->_print ?? 0;
            $users                          = Auth::user();
            // Voucher Master Data Insert
            $VoucherMaster                  =  \App\Models\VoucherMaster::where('_code',$_voucher_number)->first();
            if(empty($VoucherMaster)){
               $VoucherMaster               = new \App\Models\VoucherMaster(); 
                 $type_wise_number       = type_wise_voucher_number($_voucher_type,$request->_date);
                 $_code                  = voucher_prefix().$_voucher_type."-".$type_wise_number;
           }else{
             $VoucherMaster->_updated_by    = $users->id."-".$users->name;
           }

            

            $VoucherMaster->_date           = change_date_format($request->_date);
            $VoucherMaster->_voucher_type   = $_voucher_type ?? 'JV';
            $VoucherMaster->organization_id = $organization_id;
            $VoucherMaster->_branch_id      = $_branch_id;
            $VoucherMaster->_cost_center_id = $_cost_center_id;
         
            $VoucherMaster->_lc_no              = $request->_lc_no ?? '';
            $VoucherMaster->_transection_ref    = $_order_number ?? 'Import Asset Cost Calculation';
            $VoucherMaster->_amount             = $total_total_initial_cost ?? 0;
            $VoucherMaster->_note               = $request->_note ?? '';
            $VoucherMaster->_form_name          = $request->_form_name ?? '';
            $VoucherMaster->_lock               = $request->_lock ?? 0;
            $VoucherMaster->_sales_man_id       = $request->_sales_man_id ?? 0;
            $VoucherMaster->_status             = 1;
            $VoucherMaster->_created_by         = $users->id."-".$users->name;
            $VoucherMaster->_user_id            = $users->id;
            $VoucherMaster->_user_name          = $users->name;
            $VoucherMaster->_time               = date('H:i:s');
            $VoucherMaster->save();
            $master_id                          = $VoucherMaster->id;
            $_voucher_id                        = $VoucherMaster->id;


            AssetImportCost::where('id',$id)->update(['_voucher_number'=>$_code]);
            
            \App\Models\VoucherMaster::where('id',$_voucher_id )->update(['_code'=>$_code]);
            \App\Models\VoucherMasterDetail::where('_no',$_voucher_id)->update(['_status'=>0]);
            \App\Models\Accounts::where('_ref_master_id',$_voucher_id)->where('_table_name',$request->_form_name)->update(['_status'=>0]);
            \App\Models\AssetManagement\ImportCostAccount::where('_no',$asset_cost_id)->update(['_status'=>0]);




            


            //Inser Voucher Details Table
            $_ledger_id                     = $request->_ledger_id ?? [];
            $organization_details_ids       = $request->organization_details_id ?? [];
            $_branch_id_detail              = $request->_branch_id_detail;
            $_cost_center                   = $request->_cost_center;
            $_budget_details_ids            = $request->_budget_details_id ?? [];
            $_short_narr                    = $request->_short_narr ?? [];
            $_dr_amount                     = $request->_dr_amount ?? [];
            $_cr_amount                     = $request->_cr_amount ?? [];
            $_foreign_amounts               = $request->_foreign_amount ?? [];

            //return $asset_ledger_amount;

            // if(sizeof($asset_ledger_amount) > 0 ){
            //     foreach($asset_ledger_amount as $led_key=>$l_amounts){
            //        // return array_sum($l_amounts);

            //        //  $_p_balance                                = _l_balance_update($led_key);
            //         $_account_type_id                           =  ledger_to_group_type($led_key)->_account_head_id ?? 1;
            //         $_account_group_id                          =  ledger_to_group_type($led_key)->_account_group_id ?? 1;

            //         $VoucherMasterDetail                        = new \App\Models\VoucherMasterDetail();
            //         $VoucherMasterDetail->_no                   = $_voucher_id;
            //         $VoucherMasterDetail->_account_type_id      = $_account_type_id;
            //         $VoucherMasterDetail->_account_group_id     = $_account_group_id;
            //         $VoucherMasterDetail->_ledger_id            = $led_key;
            //         $VoucherMasterDetail->organization_id       = $organization_id;
            //         $VoucherMasterDetail->_branch_id            = $_branch_id ?? 0;
            //         $VoucherMasterDetail->_cost_center          = $_cost_center_id ?? 0;
            //         $VoucherMasterDetail->_budget_id            = $_budget_id ?? 0;
            //         $VoucherMasterDetail->_short_narr           = $_note ?? 'N/A';
            //         $VoucherMasterDetail->_dr_amount            = array_sum($l_amounts);
            //         $VoucherMasterDetail->_cr_amount            =  0;
            //         $VoucherMasterDetail->_foreign_amount       = (array_sum($l_amounts)/$_currency_rate);
            //         $VoucherMasterDetail->_status               = 1;
            //         $VoucherMasterDetail->_created_by           = $users->id."-".$users->name;
            //         $VoucherMasterDetail->save();
            //         $master_detail_id                           = $VoucherMasterDetail->id;



            //         //Reporting Account Table Data Insert

            //         $Accounts                           = new \App\Models\Accounts();
            //         $Accounts->_ref_master_id           = $_voucher_id;
            //         $Accounts->_ref_detail_id           = $master_detail_id;
            //         $Accounts->_short_narration         = $_note ?? 'N/A';
            //         $Accounts->_narration               = $_note ?? 'N/A';
            //         $Accounts->_reference               = $request->_transection_ref ?? '';
            //         $Accounts->_voucher_type            = 'JV';
            //         $Accounts->_voucher_code            = $_code ?? '';
            //         $Accounts->_lc_no                   = $request->_lc_id ?? '';
            //         $Accounts->_transaction             = 'Account';
            //         $Accounts->_date                    = change_date_format($request->_date);
            //         $Accounts->_table_name              = $request->_form_name ?? '';
            //         $Accounts->_account_head            = $_account_type_id;
            //         $Accounts->_account_group           = $_account_group_id;
            //         $Accounts->_account_ledger          = $led_key;
            //         $Accounts->_dr_amount               = array_sum($l_amounts) ?? 0;
            //         $Accounts->_cr_amount               =  0;
            //         $Accounts->_foreign_amount          = (array_sum($l_amounts)/$_currency_rate) ?? 0;
            //         $Accounts->organization_id          = $organization_id;
            //         $Accounts->_branch_id               = $_branch_id ?? 1;
            //         $Accounts->_cost_center             = $_cost_center_id ?? 1;
            //         $Accounts->_budget_id               = $_budget_id ?? 1;
            //         $Accounts->_status                  = $_status ?? 1;
            //         $Accounts->_name                    = $users->name;
            //         $Accounts->_sales_man_id            = $request->_sales_man_id ?? 0;
            //         $Accounts->_check_no                = $request->_check_no ?? '';
            //         $Accounts->_issue_date              = $request->_issue_date ?? '';
            //         $Accounts->_cash_date               = $request->_cash_date ?? '';
            //         $Accounts->save();
            //     }
            // }





            //return $_ledger_id;

            if(sizeof($_ledger_id) > 0){
                for ($i = 0; $i <sizeof($_ledger_id) ; $i++) {
                  //  $_p_balance                 = _l_balance_update($_ledger_id[$i]);
                    $_account_type_id           =  ledger_to_group_type($_ledger_id[$i])->_account_head_id;
                    $_account_group_id          =  ledger_to_group_type($_ledger_id[$i])->_account_group_id;


//ImportCostAccount Data Insert

                    $ImportCostAccount                        = new \App\Models\AssetManagement\ImportCostAccount();
                    $ImportCostAccount->_no                   = $asset_cost_id;
                    $ImportCostAccount->_account_type_id      = $_account_type_id;
                    $ImportCostAccount->_account_group_id     = $_account_group_id;
                    $ImportCostAccount->_ledger_id            = $_ledger_id[$i];
                    $ImportCostAccount->_dr_amount            = $_dr_amount[$i] ?? 0;
                    $ImportCostAccount->_cr_amount            = $_cr_amount[$i] ?? 0;
                    $ImportCostAccount->_type                 = "JV";
                    $ImportCostAccount->organization_id       = $organization_id;
                    $ImportCostAccount->_branch_id            = $_branch_id;
                    $ImportCostAccount->_cost_center          = $_cost_center_id ?? 1;
                    $ImportCostAccount->_short_narr           = $_short_narr[$i] ?? 'N/A';
                    $ImportCostAccount->_status               = 1;
                    $ImportCostAccount->save();


                    





                    $VoucherMasterDetail                        = new \App\Models\VoucherMasterDetail();
                    $VoucherMasterDetail->_no                   = $_voucher_id;
                    $VoucherMasterDetail->_account_type_id      = $_account_type_id;
                    $VoucherMasterDetail->_account_group_id     = $_account_group_id;
                    $VoucherMasterDetail->_ledger_id            = $_ledger_id[$i];
                    $VoucherMasterDetail->organization_id       = $organization_details_ids[$i];
                    $VoucherMasterDetail->_branch_id            = $_branch_id_detail[$i] ?? 0;
                    $VoucherMasterDetail->_cost_center          = $_cost_center[$i] ?? 0;
                    $VoucherMasterDetail->_budget_id            = $_budget_details_ids[$i] ?? 0;
                    $VoucherMasterDetail->_short_narr           = $_short_narr[$i] ?? 'N/A';
                    $VoucherMasterDetail->_dr_amount            = $_dr_amount[$i] ?? 0;
                    $VoucherMasterDetail->_cr_amount            = $_cr_amount[$i] ?? 0;
                    $VoucherMasterDetail->_foreign_amount       = $_foreign_amounts[$i] ?? 0;
                    $VoucherMasterDetail->_status               = 1;
                    $VoucherMasterDetail->_created_by           = $users->id."-".$users->name;
                    $VoucherMasterDetail->save();
                    $master_detail_id                           = $VoucherMasterDetail->id;



                    //Reporting Account Table Data Insert

                    $Accounts                           = new \App\Models\Accounts();
                    $Accounts->_ref_master_id           = $_voucher_id;
                    $Accounts->_ref_detail_id           = $master_detail_id;
                    $Accounts->_short_narration         = $_short_narr[$i] ?? 'N/A';
                    $Accounts->_narration               = $request->_note ?? '';
                    $Accounts->_reference               = $request->_transection_ref ?? '';
                    $Accounts->_voucher_type            = $_voucher_type ?? 'JV';
                    $Accounts->_voucher_code            = $_code ?? '';
                    $Accounts->_lc_no                   = $request->_lc_id ?? '';
                    $Accounts->_transaction             = 'Account';
                    $Accounts->_date                    = change_date_format($request->_date);
                    $Accounts->_table_name              = $request->_form_name ?? '';
                    $Accounts->_account_head            = $_account_type_id;
                    $Accounts->_account_group           = $_account_group_id;
                    $Accounts->_account_ledger          = $_ledger_id[$i];
                    $Accounts->_dr_amount               = $_dr_amount[$i] ?? 0;
                    $Accounts->_cr_amount               = $_cr_amount[$i] ?? 0;
                    $Accounts->_foreign_amount          = $_foreign_amounts[$i] ?? 0;
                    $Accounts->organization_id          = $organization_details_ids[$i];
                    $Accounts->_branch_id               = $_branch_id_detail[$i] ?? 1;
                    $Accounts->_cost_center             = $_cost_center[$i] ?? 1;
                    $Accounts->_budget_id               = $_budget_details_ids[$i] ?? 1;
                    $Accounts->_name                    = $users->name;
                    $Accounts->_sales_man_id            = $request->_sales_man_id ?? 0;
                    $Accounts->_check_no                = $request->_check_no ?? '';
                    $Accounts->_issue_date              = $request->_issue_date ?? '';
                    $Accounts->_cash_date               = $request->_cash_date ?? '';
                    $Accounts->_status                  = $request->_status ?? 1;
                    $Accounts->save();

                     //End Sms Send to customer and Supplier
                }
            }


            // \App\Models\VoucherMasterDetail::where('_no',$master_id)->delete();
            // \App\Models\AssetManagement\ImportCostAccount::where('_no',$master_id)->delete();
            // \App\Models\Accounts::where('_ref_master_id',$master_id)->where('_table_name',$request->_form_name)->delete();

            //return $request->all();
                return redirect()->route('asset_import_cost.index')
            ->with('success', __('label.info_created'));
        // } catch (Throwable $e) {
        //     report($e);
     
        //     return false;
        // }


    }

     public function import_cost_setting_modal(){
        $account_group_configs  = \DB::table("account_group_configs")->select('_customer_group','_supplier_group','_employee_group')->first();
        $_customer_group_string = $account_group_configs->_customer_group ?? '';
        $_supplier_group_string = $account_group_configs->_supplier_group ?? '';
        $_employee_group_string = $account_group_configs->_employee_group ?? '';
        $_customer_group_array  = explode(",", $_customer_group_string);
        $_supplier_group_array  = explode(",", $_supplier_group_string);
        $_employee_group_array  = explode(",", $_employee_group_string);
        $group_array_merge      = array_merge($_customer_group_array,$_supplier_group_array,$_employee_group_array);

        $form_settings              = \App\Models\AssetManagement\ImportCostLedger::first();
        $inv_accounts           = \App\Models\AccountLedger::where('_status',1)->whereNotIn('_account_group_id',$group_array_merge)->get();
        $p_accounts             = $inv_accounts;
        $dis_accounts           = $inv_accounts;
        $cost_of_solds          = $inv_accounts;
        $_cash_customers        = $inv_accounts;
        return view('apps.asset-management.asset_import_cost.form_setting_modal',compact('form_settings','inv_accounts','p_accounts','dis_accounts','cost_of_solds','_cash_customers'));
    }

    public function import_modal_settings(Request $request){
        $data = \App\Models\AssetManagement\ImportCostLedger::first();
        if(empty($data)){
            $data = new \App\Models\AssetManagement\ImportCostLedger();
        }

        $data->_insurance_bdt_ledger_id                 = $request->_insurance_bdt_ledger_id ?? 0;
        $data->_lc_commision_bdt_ledger_id              = $request->_lc_commision_bdt_ledger_id ?? 0;
        $data->_custom_duty_bdt_ledger_id               = $request->_custom_duty_bdt_ledger_id ?? 0;
        $data->_custom_duty_tax_ait_ledger_id           = $request->_custom_duty_tax_ait_ledger_id ?? 0;
        $data->_custom_duty_tax_ait_2nd_ledger_id       = $request->_custom_duty_tax_ait_2nd_ledger_id ?? 0;
        $data->_customer_other_charge_other_ledger_id   = $request->_customer_other_charge_other_ledger_id ?? 0;
        $data->_port_charge_ledger_id                   = $request->_port_charge_ledger_id ?? 0;
        $data->_port_charge_ait_ledger_id               = $request->_port_charge_ait_ledger_id ?? 0;
        $data->_shiping_agent_charge_ledger_id          = $request->_shiping_agent_charge_ledger_id ?? 0;
        $data->_shiping_agent_deduction_charge_2nd_ledger_id = $request->_shiping_agent_deduction_charge_2nd_ledger_id ?? 0;
        $data->_deport_charge_ledger_id                 = $request->_deport_charge_ledger_id ?? 0;
        $data->_container_damage_charge_ledger_id       = $request->_container_damage_charge_ledger_id ?? 0;
        $data->_cnf_agen_commision_ledger_id            = $request->_cnf_agen_commision_ledger_id ?? 0;
        $data->_installation_cost_ledger_id             = $request->_installation_cost_ledger_id ?? 0;
        $data->save();

        return redirect()->back()->with('success','Information Save successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_name = __('label.asset_import_cost');
          $data =AssetImportCost::with(['_details'])->find($id);
        $units = \DB::table("units")->orderBy('_name','ASC')->get();
        return view('apps.asset-management.asset_import_cost.show',compact('page_name','data','units'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = __('label.asset_import_cost');
         $data =AssetImportCost::with(['_cost_account','_details'])->find($id);
        if($data->_lock==1){
            return redirect()->route('asset_import_cost.index')
            ->with('warning', __('label.info_locked'));
        }
        $units = \DB::table("units")->orderBy('_name','ASC')->get();
         $_asset_groups = \DB::table("account_group_configs")->first()->_asset_group ?? 0;
        $_asset_ledgers = \DB::select(" SELECT * FROM account_ledgers  where _account_group_id IN($_asset_groups)  ");

        $users = Auth::user();
       
      
        $branchs = \App\Models\Branch::orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));

        return view('apps.asset-management.asset_import_cost.create',compact('page_name','data','units','_asset_ledgers','branchs','permited_branch','permited_costcenters','permited_budgets','permited_organizations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            AssetImportCost::where('id',$id)->update(['_status'=>0]);
            AssetImportCostDetail::where('_no',$id)->update(['_status'=>0]);
             return redirect()->route('asset_import_cost.index')
            ->with('success', __('label.info_deleted'));
            
        } catch (Exception $e) {
             report($e);
            return false;
            
        }

        
    }
}
