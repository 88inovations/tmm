<?php

namespace App\Http\Controllers\LC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LC\LcMaster;
use App\Models\LC\LcItem;
use App\Models\LC\LcAmendment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LcMasterController extends Controller
{


       function __construct()
    {
         $this->middleware('permission:lc_manage-list|lc_manage-create|lc_manage-edit|lc_manage-delete', ['only' => ['index','store']]);
         $this->middleware('permission:lc_manage-create', ['only' => ['create','store']]);
         $this->middleware('permission:lc_manage-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:lc_manage-delete', ['only' => ['destroy']]);
         $this->page_name =__('label.lc_manage');
    }

     public function create()
    {
         
          $tranport_types = \DB::table('tranport_types')->get();
          $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        return view('lc.lc_open.form',
            compact('tranport_types','permited_branch','permited_costcenters','permited_branch','permited_costcenters'));
    }

    public function index(Request $request){
   
        //return $request->all();
        $auth_user = \Auth::user();
       if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_pur_limit', $request->limit);
        }else{
             $limit= \Session::get('_pur_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $datas = LcMaster::with(['items','_bank','_supplier','_cnf','_cost_center','_organization','_branch']);
       // $datas = $datas->whereIn('_branch_id',explode(',',\Auth::user()->branch_ids));

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
        
        if($request->has('_order_ref_id') && $request->_order_ref_id !=''){
            $datas = $datas->where('_order_ref_id','like',"%$request->_order_ref_id%");
        }

        if($request->has('_note') && $request->_note !=''){
            $datas = $datas->where('_note','like',"%$request->_note%");
        }
        if($request->has('_user_name') && $request->_user_name !=''){
            $datas = $datas->where('_user_name','like',"%$request->_user_name%");
        }
         if($request->has('_lock') && $request->_lock !=''){
            $datas = $datas->where('_lock','=',$request->_lock);
        }
        
        
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);

        
        $page_name  = __('label.lc_manage');
        
        $permited_branch = permited_branch(explode(',',$auth_user->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$auth_user->cost_center_ids));


        return view('lc.lc_open.index',compact('datas','permited_branch','permited_costcenters','page_name','limit','request'));
    }

    public function show($lcId){
        // Fetch LC master data
        $lcMaster = DB::table('lc_masters')
            ->where('id', $lcId)
            ->first();

        // Fetch LC item data
        $lcItems = DB::table('lc_items')
            ->where('lc_master_id', $lcId)
            ->where('_status',1)
            ->get();
            $page_name =__('label.lc_manage'); 

        // Pass data to the view
        return view('lc.lc_open.print', compact('lcMaster', 'lcItems','page_name'));
    }

    public function edit($id){

    $lc= \DB::table('lc_masters')->where('id',$id)->first();
    $items = \App\Models\LC\LcItem::with(['unit_conversion'])->where('lc_master_id',$id)->where('_status',1)->get();
    $page_name = __('label.lc_manage');
    $tranport_types = \DB::table('tranport_types')->get();

        $users = Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $lc_amendment_types = \DB::table("lc_amendment_types")->get();

    return view('lc.lc_open.form',compact('lc','items','page_name','tranport_types','permited_branch','permited_costcenters','lc_amendment_types'));

    }

    public function lc_wise_item(Request $request){
        $id = $request->_lc_id ?? '';
        $_lc_stage_id = $request->_lc_stage_id ?? '';
        $lc_stages=[3,4,5];
        $items=[];
        if(in_array($_lc_stage_id, $lc_stages)){
             $items = \App\Models\LC\LcItem::with(['unit_conversion'])->where('lc_master_id',$id)->where('_status',1)->get();
        }
        

           return view('lc.lc_open.item_detail',compact('items'));
    }

  public function store(Request $request)
    {
        // Validate LC data

      //  return $request->all();

        $validatedData = $request->validate([
            'po_no' => 'nullable|string|max:255',
            'lc_ip_no' => 'required|string|max:255|unique:lc_masters,lc_ip_no',
            'lc_ip_date' => 'required|date',
            'bill_no' => 'nullable|string|max:255',
            'pi_no' => 'required|string|max:255|unique:lc_masters,pi_no',
            'pi_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'bill_of_enty_no' => 'nullable|string|max:255',
            'bill_of_enty_date' => 'nullable|date',
            'date_of_arrival' => 'nullable|date',
            'amendment_date' => 'nullable|date',
            'lc_type' => 'nullable|string|max:255',
            'lca_no' => 'nullable|string|max:255',
            'transport_type' => 'required|string|max:255',
            'bank' => 'nullable|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'cnf' => 'nullable|string|max:255',
            'bank_branch' => 'nullable|string|max:255',
            'insurance_company' => 'nullable|string|max:255',
            'insurance_cover_note' => 'nullable|string|max:255',
            'insurance_cover_date' => 'nullable|date',
            'lc_tt' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:255',
            '_cif_value_foreign' => 'nullable|numeric',
            '_cif_value_local' => 'nullable|numeric',
            'partial_shipment' => 'nullable',
            '_rate_to_bdt' => 'nullable|numeric',
            '_local_amount' => 'nullable|numeric',
            
            
        ]);

$organization_id = $request->organization_id ?? 1;
$_branch_id = $request->_branch_id ?? 1;
$_cost_center_id = $request->_cost_center_id ?? 1;
$_date = change_date_format($request->_date ?? date('Y-m-d'));

$_local_amount = $request->_local_amount ?? 0;
$_note = $request->_note ?? '';

        // Store the LC data
        $lc = LcMaster::create([
            'organization_id' => $organization_id,
             '_date' => $_date,
            '_branch_id' => $_branch_id,
            '_cost_center_id' => $_cost_center_id,
            'po_no' => $validatedData['po_no'],
            'expiry_date' => $request->expiry_date ?? '',
            'lc_ip_no' => $validatedData['lc_ip_no'],
            'lc_ip_date' => $validatedData['lc_ip_date'],
            'bill_no' => $validatedData['bill_no'],
            'pi_no' => $validatedData['pi_no'],
            'pi_date' => $validatedData['pi_date'],
            'amendment_date' => $request->amendment_date ?? '',
            'bill_of_enty_no' => $validatedData['bill_of_enty_no'],
            'bill_of_enty_date' => $validatedData['bill_of_enty_date'],
            'date_of_arrival' => $validatedData['date_of_arrival'],
            'lc_type' => $validatedData['lc_type'],
            'lca_no' => $validatedData['lca_no'],
            'transport_type' => $validatedData['transport_type'],
            'partial_shipment' => $request->partial_shipment ?? '',
            'bank' => $validatedData['bank'],
            'supplier' => $validatedData['supplier'],
            'cnf' => $validatedData['cnf'],
            'bank_branch' => $validatedData['bank_branch'],
            'insurance_company' => $validatedData['insurance_company'],
            'insurance_cover_note' => $validatedData['insurance_cover_note'],
            'insurance_cover_date' => $validatedData['insurance_cover_date'],
            'lc_tt' => $validatedData['lc_tt'],
            'currency' => $validatedData['currency'],
            '_cif_value_foreign' => $validatedData['_cif_value_foreign'],
            '_cif_value_local' => $validatedData['_cif_value_local'],
            '_rate_to_bdt' => $validatedData['_rate_to_bdt'],
            '_local_amount' => $validatedData['_local_amount'],
            'remark' => $request->_note ?? '',
            '_note' => $request->_note ?? '',
            '_is_close' => $validatedData['_is_close'] ?? 0,
            '_status' => $validatedData['_status'] ?? 1,
            '_lock' => $validatedData['_lock'] ?? 0,
            '_created_by' => auth()->user()->name,
            '_updated_by' => auth()->user()->name,
        ]);
$_lc_id = $lc->id;
        $purchase_detail_ids = $request->purchase_detail_id ?? []; 
        $_search_item_codes = $request->_search_item_code ?? []; 
        $_search_item_ids = $request->_search_item_id ?? []; 
        $_item_ids = $request->_item_id ?? []; 
        $_base_unit_ids = $request->_base_unit_id ?? []; 
        $_main_unit_vals = $request->_main_unit_val ?? []; 
        $_unit_conversions = $request->conversion_qty ?? []; 
        $_transection_units = $request->_transection_unit ?? []; 
        $pack_sizes = $request->pack_size ?? []; 
        $_barcodes = $request->_barcode ?? []; 
        $_hs_codes = $request->_hs_code ?? []; 
        $_hs_code_2s = $request->_hs_code_2 ?? []; 
        $_short_notes = $request->_short_note ?? []; 
        $_qtys = $request->_qty ?? []; 
        $_rates = $request->_rate ?? []; 
        $_base_rates = $request->_base_rate ?? []; 
        $_values = $request->_value ?? []; 
        $_weight_avgs = $request->_weight_avg ?? []; 
        $_foreign_rates = $request->_foreign_rate ?? []; 
        $_foreign_amounts = $request->_foreign_amount ?? []; 

        // Store the LC Item details
        if(sizeof($purchase_detail_ids) > 0){
            for ($i = 0; $i <sizeof($purchase_detail_ids) ; $i++) {
                 LcItem::create([
                'lc_master_id' => $lc->id,
                '_item_id' => $_item_ids[$i],
                '_item_code' => $_search_item_codes[$i],
                '_item_name' => $_search_item_ids[$i],
                '_unit_conversion' => $_unit_conversions[$i],
                '_transection_unit' => $_transection_units[$i],
                '_base_unit' => $_base_unit_ids[$i] ?? 0,
                '_base_rate' => $_base_rates[$i] ?? 0,
                '_qty' => $_qtys[$i] ?? 0,
                '_category_id' => _item_category($_item_ids[$i]),
                '_short_note' => $_short_notes[$i] ?? '',
                '_rate' => $_rates[$i] ?? '',
                '_foreign_rate' => $_foreign_rates[$i] ?? 0,
                '_foreign_amount' => $_foreign_amounts[$i] ?? 0,
                '_value' => $_values[$i] ?? 0,
                '_barcode' => $_barcodes[$i] ?? '',
                '_hs_code' => $_hs_codes[$i] ?? '',
                '_hs_code_2' => $_hs_code_2s[$i] ?? '',
                'weight_avg' => $weight_avgs[$i] ?? '',
                'organization_id' => $organization_id,
                '_cost_center_id' => $_cost_center_id,
                '_branch_id' => $_branch_id,
                '_status' => 1,
            ]);

            }
        }

//Post To VoucherMaster, Voucher Master detail and Accounts Table
        $_is_posting = $request->_is_posting ?? 0;
        if($_is_posting==1){
            $_voucher_type = $request->_voucher_type ?? 'JV';
            $organization_id = $request->organization_id ?? 1;
            $_branch_id = $request->_branch_id ?? 1;
            $_cost_center_id = $request->_cost_center_id ?? 1;
            $type_wise_number = type_wise_voucher_number($request->_voucher_type,$request->_date);
            $_code = voucher_prefix().$request->_voucher_type."-".$type_wise_number;

          
            $users = Auth::user();
            // Voucher Master Data Insert
            $VoucherMaster = new \App\Models\VoucherMaster();
            $VoucherMaster->_date = change_date_format($request->_date);
            $VoucherMaster->_voucher_type = $_voucher_type;
            $VoucherMaster->organization_id = $organization_id;
            $VoucherMaster->_branch_id = $_branch_id;
            $VoucherMaster->_code = $_code;


            /**/

            $VoucherMaster->_lc_id = $_lc_id ?? '';
            $VoucherMaster->_lc_no = id_to_cloumn($_lc_id ?? '','lc_ip_no','lc_masters');
            $VoucherMaster->_lc_stage_id = $request->_lc_stage_id ?? 1;

            $VoucherMaster->_budget_id = $request->_budget_id ?? 0;
            $VoucherMaster->_sales_man_id = $request->_sales_man_id ?? 0;
            $VoucherMaster->_check_no = $request->_check_no ?? '';
            $VoucherMaster->_issue_date = $request->_issue_date ?? '';
            $VoucherMaster->_cash_date = $request->_cash_date ?? '';
            

            $VoucherMaster->_transection_ref = $_lc_id."-lc_masters";
            $VoucherMaster->_amount = $_local_amount ?? 0;
            $VoucherMaster->_note = $request->_note ?? '';
            $VoucherMaster->_form_name = $request->_form_name ?? 'voucher_masters';
            $VoucherMaster->_ref_table = $request->_ref_table ?? 'lc_masters';
            $VoucherMaster->_lock = $request->_lock ?? 0;
            $VoucherMaster->_cost_center_id = $_cost_center_id ?? 1;
            $VoucherMaster->_status =1;
            $VoucherMaster->_created_by = $users->id."-".$users->name;
            $VoucherMaster->_user_id = $users->id;
            $VoucherMaster->_user_name = $users->name;
            $VoucherMaster->_time = date('H:i:s');
            $VoucherMaster->save();
            $master_id = $VoucherMaster->id;
            $_voucher_id = $VoucherMaster->id;


            LcMaster::where('id',$_lc_id)->update(['_voucher_id'=>$master_id,'_voucher_code'=>$_code]);
            //Bank Check Information save 
            $_check_no = $request->_check_no ?? '';
           // if($_check_no !=''){
                $VoucharCheckInfo = new \App\Models\VoucharCheckInfo();
                $VoucharCheckInfo->_voucher_no=$master_id;
                $VoucharCheckInfo->_check_no=$request->_check_no ?? '';
                $VoucharCheckInfo->_bank_name=$request->_search_bank ?? '';
                $VoucharCheckInfo->_branch_name=$request->bank_branch ?? '';
                $VoucharCheckInfo->_bank_account=$request->_bank_account ?? '';
                $VoucharCheckInfo->_issue_date=$request->_issue_date ?? '';
                $VoucharCheckInfo->_cash_date=$request->_cash_date ?? '';
                $VoucharCheckInfo->_status=1;
                $VoucharCheckInfo->save();
          //  }
            

            //Inser Voucher Details Table
            $supplier=$request->supplier ?? 0; //DR Account
            $bank=$request->bank ?? 0;          //Cr Account
             $_foreign_amounts = $request->_foreign_amount ?? [];

             $_ledger_id=[$supplier,$bank];
             $_dr_amount=[$_local_amount,0];
             $_cr_amount=[0,$_local_amount];


            if(sizeof($_ledger_id) > 0){
                for ($i = 0; $i <sizeof($_ledger_id) ; $i++) {
                    $_p_balance = _l_balance_update($_ledger_id[$i]);
                    $_account_type_id =  ledger_to_group_type($_ledger_id[$i])->_account_head_id;
                    $_account_group_id =  ledger_to_group_type($_ledger_id[$i])->_account_group_id;

                    $VoucherMasterDetail = new \App\Models\VoucherMasterDetail();
                    $VoucherMasterDetail->_no = $master_id;
                    $VoucherMasterDetail->_account_type_id = $_account_type_id;
                    $VoucherMasterDetail->_account_group_id = $_account_group_id;
                    $VoucherMasterDetail->_ledger_id = $_ledger_id[$i];
                    $VoucherMasterDetail->organization_id = $organization_id;
                    $VoucherMasterDetail->_branch_id = $_branch_id ?? 0;
                    $VoucherMasterDetail->_cost_center = $_cost_center_id ?? 0;
                    $VoucherMasterDetail->_budget_id = $_budget_id ?? 0;
                    $VoucherMasterDetail->_short_narr = $_short_narr[$i] ?? 'N/A';
                    $VoucherMasterDetail->_dr_amount = $_dr_amount[$i] ?? 0;
                    $VoucherMasterDetail->_cr_amount = $_cr_amount[$i] ?? 0;
                    $VoucherMasterDetail->_foreign_amount = $_foreign_amounts[$i] ?? 0;
                    $VoucherMasterDetail->_status = 1;
                    $VoucherMasterDetail->_created_by = $users->id."-".$users->name;
                    $VoucherMasterDetail->save();
                    $master_detail_id = $VoucherMasterDetail->id;



                    //Reporting Account Table Data Insert

                    $Accounts = new \App\Models\Accounts();
                    $Accounts->_ref_master_id = $master_id;
                    $Accounts->_ref_detail_id = $master_detail_id;
                  
                    $Accounts->_short_narration = $_note ?? 'N/A';
                    $Accounts->_narration = $_note ?? '' ;
                    $Accounts->_reference = $request->_transection_ref;
                    $Accounts->_voucher_type = $request->_voucher_type ?? 'JV';
                    $Accounts->_voucher_code = $_code ?? '';
                     $Accounts->_lc_id = $request->_lc_id ?? '';
                    $Accounts->_lc_no = id_to_cloumn($request->_lc_id ?? '','lc_ip_no','lc_masters');
                    $Accounts->_lc_stage_id = $_lc_stage_id ?? 1;

                    $Accounts->_transaction = 'lc_masters';
                    $Accounts->_date = change_date_format($request->_date);
                    $Accounts->_table_name = $request->_form_name ?? 'voucher_masters';
                    $Accounts->_account_head = $_account_type_id;
                    $Accounts->_account_group = $_account_group_id;
                    $Accounts->_account_ledger = $_ledger_id[$i];
                    $Accounts->_dr_amount = $_dr_amount[$i] ?? 0;
                    $Accounts->_cr_amount = $_cr_amount[$i] ?? 0;
                    $Accounts->_foreign_amount = $_foreign_amounts[$i] ?? 0;

                    $Accounts->organization_id = $organization_id;
                    $Accounts->_branch_id = $_branch_id ?? 0;
                    $Accounts->_cost_center = $_cost_center_id ?? 0;
                    $Accounts->_budget_id = $_budget_id ?? 0;

                    $Accounts->_name =$users->name;
                    $Accounts->_sales_man_id = $request->_sales_man_id ?? 0;
                    $Accounts->_check_no = $request->_check_no ?? '';
                    $Accounts->_issue_date = $request->_issue_date ?? '';
                    $Accounts->_cash_date = $request->_cash_date ?? '';
                    $Accounts->save();

                   $_l_balance = ledger_balance_update($_ledger_id[$i]);
                  $_l_balance = _l_balance_update($_ledger_id[$i]);
                }
            }
           
         
           

        

        } //End of check posting yes or no
       

        return redirect()->back()->with('success', 'LC created successfully!');
    }


    public function lc_cost_calculation(Request $request){

        $lcId = $request->id ?? 2;

       $lcMaster = DB::table('lc_masters')
        ->leftJoin('account_ledgers as bank_ledger', 'lc_masters.bank', '=', 'bank_ledger.id')
        ->leftJoin('account_ledgers as supplier_ledger', 'lc_masters.supplier', '=', 'supplier_ledger.id')
        ->leftJoin('account_ledgers as cnf_ledger', 'lc_masters.cnf', '=', 'cnf_ledger.id')
        ->leftJoin('account_ledgers as bank_branch_ledger', 'lc_masters.bank_branch', '=', 'bank_branch_ledger.id')
        ->leftJoin('account_ledgers as insurance_company_ledger', 'lc_masters.insurance_company', '=', 'insurance_company_ledger.id')
        ->select(
            'lc_masters.*',
            'bank_ledger._name as bank_name',
            'supplier_ledger._name as supplier_name',
            'cnf_ledger._name as cnf_name',
            'bank_branch_ledger._name as bank_branch_name',
            'insurance_company_ledger._name as insurance_company_name'
        )
        ->where('lc_masters.id', $lcId)
        ->first();

       // Step 1: Get all unique ledger IDs with names
    $ledgerData = DB::table('lc_item_costs as t2')
        ->leftjoin('account_ledgers as al', 't2._cost_deduct_ledger_id', '=', 'al.id')
        ->select('t2._cost_deduct_ledger_id', 'al._name')
        ->where('t2.lc_master_id', $lcId)
        ->where('t2._status', 1)
        ->distinct()
        ->get();

    // Create an array of ledger IDs and names
    $ledgerIds = $ledgerData->pluck('_cost_deduct_ledger_id');
    $ledgerNames = $ledgerData->pluck('_name', '_cost_deduct_ledger_id');

    // Step 2: Create dynamic select columns for each ledger
    $selectColumns = [
        't1._item_id',
        't1._item_code',
        't1._item_name',
        't1._qty',
        't1._rate',
        't1._foreign_rate',
        't1._foreign_amount',
        't1._value',
        't1._barcode',
        't1._hs_code',
        't1._hs_code_2'
    ];

    foreach ($ledgerIds as $ledgerId) {
        $selectColumns[] = DB::raw("
            SUM(CASE WHEN t2._cost_deduct_ledger_id = $ledgerId THEN 
                CASE 
                    WHEN t2._adjust_type = 1 THEN t2._value 
                    WHEN t2._adjust_type = 2 THEN -t2._value 
                    ELSE 0 
                END 
            ELSE 0 END) AS `Ledger_$ledgerId`
        ");
    }

    $selectColumns[] = DB::raw("
        t1._value + SUM(
            CASE 
                WHEN t2._adjust_type = 1 THEN t2._value 
                WHEN t2._adjust_type = 2 THEN -t2._value 
                ELSE 0 
            END
        ) AS Total_Cost
    ");

    // Step 3: Fetch product and cost information from `lc_items` and `lc_item_costs`
    $results = DB::table('lc_items as t1')
        ->leftJoin('lc_item_costs as t2', 't1.id', '=', 't2._lc_item_id')
        ->select($selectColumns)
        ->where('t2.lc_master_id', $lcId)
        ->where('t2._status', 1)
        ->groupBy(
            't1._item_id', 
            't1._item_code', 
            't1._item_name', 
            't1._qty', 
            't1._rate', 
            't1._foreign_rate', 
            't1._foreign_amount', 
            't1._value', 
            't1._barcode', 
            't1._hs_code', 
            't1._hs_code_2'
        )
        ->get();
$page_name = __('label.lc_product_costs');
    return view('lc.lc_open.lc_product_costs', compact('results', 'ledgerNames', 'ledgerIds','page_name','lcMaster'));

    }

    /*Lc Wise Item Detail*/




    // public function edit(Lc $lc)
    // {
    //     return view('lc.lc_open.form', compact('lc'));
    // }

   public function update(Request $request, $id)
    {
        
       // return $request->all();


         $validatedData = $request->validate([
            'po_no' => 'nullable|string|max:255',
            'lc_ip_no' => 'required|string|max:255',
            'amendment_no' => 'required|string|max:255',
            'lc_ip_date' => 'required|date',
            'bill_no' => 'nullable|string|max:255',
            'pi_no' => 'required|string|max:255',
            'pi_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'bill_of_enty_no' => 'nullable|string|max:255',
            'bill_of_enty_date' => 'nullable|date',
            'date_of_arrival' => 'nullable|date',
            'amendment_date' => 'required|date',
            'lc_type' => 'nullable|string|max:255',
            'lca_no' => 'nullable|string|max:255',
            'transport_type' => 'required|string|max:255',
            'bank' => 'nullable|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'cnf' => 'nullable|string|max:255',
            'bank_branch' => 'nullable|string|max:255',
            'insurance_company' => 'nullable|string|max:255',
            'insurance_cover_note' => 'nullable|string|max:255',
            'insurance_cover_date' => 'nullable|date',
            'lc_tt' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:255',
            '_cif_value_foreign' => 'nullable|numeric',
            '_cif_value_local' => 'nullable|numeric',
            'partial_shipment' => 'nullable',
            '_rate_to_bdt' => 'nullable|numeric',
            '_local_amount' => 'nullable|numeric',
            
            
        ]);

        $organization_id = $request->organization_id ?? 1;
        $_branch_id = $request->_branch_id ?? 1;
        $_cost_center_id = $request->_cost_center_id ?? 1;
        $_date = change_date_format($request->_date ?? date('Y-m-d'));
        $_local_amount = $request->_local_amount ?? 0;
$_note = $request->_note ?? '';

$lc = LcMaster::find($id);
$_lc_id = $id;
        // Store the LC data
      LcMaster::where('id',$id)->update([
            'organization_id' => $organization_id,
            '_branch_id' => $_branch_id,
            '_date' => $_date,
            '_cost_center_id' => $_cost_center_id,
            'po_no' => $validatedData['po_no'],
            'lc_ip_no' => $validatedData['lc_ip_no'],
            'lc_ip_date' => $validatedData['lc_ip_date'],
            'bill_no' => $validatedData['bill_no'],
            'pi_no' => $validatedData['pi_no'],
            'pi_date' => $validatedData['pi_date'],
            'pi_date' => $validatedData['expiry_date'],
            'amendment_date' => $validatedData['amendment_date'],
            'amendment_no' => $request->amendment_no ?? '',
            'bill_of_enty_no' => $validatedData['bill_of_enty_no'],
            'bill_of_enty_date' => $validatedData['bill_of_enty_date'],
            'date_of_arrival' => $validatedData['date_of_arrival'],
            'lc_type' => $validatedData['lc_type'],
            'lca_no' => $validatedData['lca_no'],
            'transport_type' => $validatedData['transport_type'],
            'partial_shipment' => $request->partial_shipment ?? '',
            'bank' => $validatedData['bank'],
            'supplier' => $validatedData['supplier'],
            'cnf' => $validatedData['cnf'],
            'bank_branch' => $validatedData['bank_branch'],
            'insurance_company' => $validatedData['insurance_company'],
            'insurance_cover_note' => $validatedData['insurance_cover_note'],
            'insurance_cover_date' => $validatedData['insurance_cover_date'],
            'lc_tt' => $validatedData['lc_tt'],
            'currency' => $validatedData['currency'],
            '_cif_value_foreign' => $validatedData['_cif_value_foreign'],
            '_cif_value_local' => $validatedData['_cif_value_local'],
            '_rate_to_bdt' => $validatedData['_rate_to_bdt'],
            '_local_amount' => $request->_total_value_amount ?? 0,
            'remark' => $request->reason_for_amendment ?? '',
            '_note' => $request->_note ?? '',
            '_is_close' => $validatedData['_is_close'] ?? 0,
            '_status' => $validatedData['_status'] ?? 1,
            '_lock' => $validatedData['_lock'] ?? 0,
            '_created_by' => auth()->user()->name,
            '_updated_by' => auth()->user()->name,
        ]);


if($request->amendment_no != $lc->amendment_no){
     $amendment = LcAmendment::create([
                'lc_master_id' => $id,
                'amendment_no' => $request->amendment_no ?? '',
                'amendment_date' => $request->amendment_date,
                'amendment_type' => $request->amendment_type,
                'old_cif_value_foreign' => $lc->_cif_value_foreign,
                'new_cif_value_foreign' => $request->_cif_value_foreign,
                'old_expiry_date' => $lc->expiry_date,
                'new_expiry_date' => $request->expiry_date ?? '',
                'reason_for_amendment' => $request->reason_for_amendment,
                'created_by' => auth()->user()->name,
            ]);
}

        



        $purchase_detail_ids = $request->purchase_detail_id ?? []; 
        $_search_item_codes = $request->_search_item_code ?? []; 
        $_search_item_ids = $request->_search_item_id ?? []; 
        $_item_ids = $request->_item_id ?? []; 
        $_base_unit_ids = $request->_base_unit_id ?? []; 
        $_main_unit_vals = $request->_main_unit_val ?? []; 
        $_unit_conversions = $request->conversion_qty ?? []; 
        $_transection_units = $request->_transection_unit ?? []; 
        $pack_sizes = $request->pack_size ?? []; 
        $_barcodes = $request->_barcode ?? []; 
        $_hs_codes = $request->_hs_code ?? []; 
        $_hs_code_2s = $request->_hs_code_2 ?? []; 
        $_short_notes = $request->_short_note ?? []; 
        $_qtys = $request->_qty ?? []; 
        $_rates = $request->_rate ?? []; 
        $_base_rates = $request->_base_rate ?? []; 
        $_values = $request->_value ?? []; 
        $_weight_avgs = $request->_weight_avg ?? []; 
        $_foreign_rates = $request->_foreign_rate ?? []; 
        $_foreign_amounts = $request->_foreign_amount ?? []; 

        LcItem::where('lc_master_id', $id)->update(['_status'=>0]);

        // Store the LC Item details
        if(sizeof($purchase_detail_ids) > 0){
            for ($i = 0; $i <sizeof($purchase_detail_ids) ; $i++) {
                if($purchase_detail_ids[$i] ==0){
                     LcItem::create([
                        'lc_master_id' => $id,
                        '_item_id' => $_item_ids[$i],
                        '_item_code' => $_search_item_codes[$i],
                        '_item_name' => $_search_item_ids[$i],
                        '_unit_conversion' => $_unit_conversions[$i],
                        '_transection_unit' => $_transection_units[$i],
                        '_base_unit' => $_base_unit_ids[$i] ?? 0,
                        '_base_rate' => $_base_rates[$i] ?? 0,
                        '_qty' => $_qtys[$i] ?? 0,
                        '_category_id' => _item_category($_item_ids[$i]),
                        '_short_note' => $_short_notes[$i] ?? '',
                        '_rate' => $_rates[$i] ?? '',
                        '_foreign_rate' => $_foreign_rates[$i] ?? 0,
                        '_foreign_amount' => $_foreign_amounts[$i] ?? 0,
                        '_value' => $_values[$i] ?? 0,
                        '_barcode' => $_barcodes[$i] ?? '',
                        '_hs_code' => $_hs_codes[$i] ?? '',
                        '_hs_code_2' => $_hs_code_2s[$i] ?? '',
                        'weight_avg' => $weight_avgs[$i] ?? '',
                        'organization_id' => $organization_id,
                        '_cost_center_id' => $_cost_center_id,
                        '_branch_id' => $_branch_id,
                        '_status' => 1,
                    ]);

                }else{
                     LcItem::where('id',$purchase_detail_ids[$i])->update([
                            
                            'lc_master_id' => $lc->id,
                            '_item_id' => $_item_ids[$i],
                            '_item_code' => $_search_item_codes[$i],
                            '_item_name' => $_search_item_ids[$i],
                            '_unit_conversion' => $_unit_conversions[$i],
                            '_transection_unit' => $_transection_units[$i],
                            '_base_unit' => $_base_unit_ids[$i] ?? 0,
                            '_base_rate' => $_base_rates[$i] ?? 0,
                            '_qty' => $_qtys[$i] ?? 0,
                            '_category_id' => _item_category($_item_ids[$i]),
                            '_short_note' => $_short_notes[$i] ?? '',
                            '_rate' => $_rates[$i] ?? '',
                            '_foreign_rate' => $_foreign_rates[$i] ?? 0,
                            '_foreign_amount' => $_foreign_amounts[$i] ?? 0,
                            '_value' => $_values[$i] ?? 0,
                            '_barcode' => $_barcodes[$i] ?? '',
                            '_hs_code' => $_hs_codes[$i] ?? '',
                            '_hs_code_2' => $_hs_code_2s[$i] ?? '',
                            'weight_avg' => $weight_avgs[$i] ?? '',
                            'organization_id' => $organization_id,
                            '_cost_center_id' => $_cost_center_id,
                            '_branch_id' => $_branch_id,
                            '_status' => 1,
                        ]);

                }


                

            }
        }
         LcItem::where('_status',0)->delete();


         //Post To VoucherMaster, Voucher Master detail and Accounts Table
        $_is_posting = $request->_is_posting ?? 0;
        if($_is_posting==1){
            $_voucher_type = $request->_voucher_type ?? 'JV';
            $organization_id = $request->organization_id ?? 1;
            $_branch_id = $request->_branch_id ?? 1;
            $_cost_center_id = $request->_cost_center_id ?? 1;
            $_voucher_id = $request->_voucher_id ?? '';
            $_voucher_type = $request->_voucher_type ?? 'JV';
            $old_voucher_id = $lc->_voucher_id ?? '';

            if($_voucher_id ==''){
                if($old_voucher_id !=""){
                    \App\Models\VoucherMaster::where('id',$old_voucher_id)->update(['_status'=>0]);
                    \App\Models\VoucharCheckInfo::where('_voucher_no',$old_voucher_id)->update(['_status'=>0]);
                    \App\Models\VoucherMasterDetail::where('_no',$old_voucher_id)->update(['_status'=>0]);
                    \App\Models\Accounts::where('_ref_master_id',$old_voucher_id)->where('_table_name','voucher_masters')
                    ->update(['_status'=>0]);


                }
                 $type_wise_number = type_wise_voucher_number($_voucher_type,$request->_date);
                 $_code = voucher_prefix().$_voucher_type."-".$type_wise_number;
            }else{
                $_code = $request->_voucher_code ?? '';
            }
           

          
            $users = Auth::user();
            // Voucher Master Data Insert
            $VoucherMaster =  \App\Models\VoucherMaster::find($_voucher_id);
            if(empty($VoucherMaster)){
                $VoucherMaster = new \App\Models\VoucherMaster();

            }else{
                \App\Models\VoucharCheckInfo::where('_voucher_no',$_voucher_id)->update(['_status'=>0]);
               \App\Models\VoucherMasterDetail::where('_no',$_voucher_id)->update(['_status'=>0]);
               \App\Models\Accounts::where('_ref_master_id',$_voucher_id)->where('_table_name','voucher_masters')
                ->update(['_status'=>0]);
                    
            }
            $VoucherMaster->_date = change_date_format($request->_date);
            $VoucherMaster->_voucher_type = $_voucher_type;
            $VoucherMaster->organization_id = $organization_id;
            $VoucherMaster->_branch_id = $_branch_id;
            $VoucherMaster->_code = $_code;


            /**/

            $VoucherMaster->_lc_id = $_lc_id ?? '';
            $VoucherMaster->_lc_no = id_to_cloumn($_lc_id ?? '','lc_ip_no','lc_masters');
            $VoucherMaster->_lc_stage_id = $request->_lc_stage_id ?? 1;

            $VoucherMaster->_budget_id = $request->_budget_id ?? 0;
            $VoucherMaster->_sales_man_id = $request->_sales_man_id ?? 0;
            $VoucherMaster->_check_no = $request->_check_no ?? '';
            $VoucherMaster->_issue_date = $request->_issue_date ?? '';
            $VoucherMaster->_cash_date = $request->_cash_date ?? '';
            

            $VoucherMaster->_transection_ref = $_lc_id."-lc_masters";
            $VoucherMaster->_amount = $_local_amount ?? 0;
            $VoucherMaster->_note = $request->_note ?? '';
            $VoucherMaster->_form_name = $request->_form_name ?? 'voucher_masters';
            $VoucherMaster->_ref_table = $request->_ref_table ?? 'lc_masters';
            $VoucherMaster->_lock = $request->_lock ?? 0;
            $VoucherMaster->_cost_center_id = $_cost_center_id ?? 1;
            $VoucherMaster->_status =1;
            $VoucherMaster->_created_by = $users->id."-".$users->name;
            $VoucherMaster->_user_id = $users->id;
            $VoucherMaster->_user_name = $users->name;
            $VoucherMaster->_time = date('H:i:s');
            $VoucherMaster->save();
            $master_id = $VoucherMaster->id;
            $_voucher_id = $VoucherMaster->id;
            $_voucher_code = $VoucherMaster->_code ?? '';


            LcMaster::where('id',$_lc_id)->update(['_voucher_id'=>$master_id,'_voucher_code'=>$_code]);
            //Bank Check Information save 
            $_check_no = $request->_check_no ?? '';
           // if($_check_no !=''){
                $VoucharCheckInfo = new \App\Models\VoucharCheckInfo();
                $VoucharCheckInfo->_voucher_no=$master_id;
                $VoucharCheckInfo->_check_no=$request->_check_no ?? '';
                $VoucharCheckInfo->_bank_name=$request->_search_bank ?? '';
                $VoucharCheckInfo->_branch_name=$request->bank_branch ?? '';
                $VoucharCheckInfo->_bank_account=$request->_bank_account ?? '';
                $VoucharCheckInfo->_issue_date=$request->_issue_date ?? '';
                $VoucharCheckInfo->_cash_date=$request->_cash_date ?? '';
                $VoucharCheckInfo->_status=1;
                $VoucharCheckInfo->save();
          //  }
            

            //Inser Voucher Details Table
            $supplier=$request->supplier ?? 0; //DR Account
            $bank=$request->bank ?? 0;          //Cr Account
             $_foreign_amounts = $request->_foreign_amount ?? [];

             $_ledger_id=[$supplier,$bank];
             $_dr_amount=[$_local_amount,0];
             $_cr_amount=[0,$_local_amount];


            if(sizeof($_ledger_id) > 0){
                for ($i = 0; $i <sizeof($_ledger_id) ; $i++) {
                    $_p_balance = _l_balance_update($_ledger_id[$i]);
                    $_account_type_id =  ledger_to_group_type($_ledger_id[$i])->_account_head_id;
                    $_account_group_id =  ledger_to_group_type($_ledger_id[$i])->_account_group_id;

                    $VoucherMasterDetail = new \App\Models\VoucherMasterDetail();
                    $VoucherMasterDetail->_no = $master_id;
                    $VoucherMasterDetail->_account_type_id = $_account_type_id;
                    $VoucherMasterDetail->_account_group_id = $_account_group_id;
                    $VoucherMasterDetail->_ledger_id = $_ledger_id[$i];
                    $VoucherMasterDetail->organization_id = $organization_id;
                    $VoucherMasterDetail->_branch_id = $_branch_id ?? 0;
                    $VoucherMasterDetail->_cost_center = $_cost_center_id ?? 0;
                    $VoucherMasterDetail->_budget_id = $_budget_id ?? 0;
                    $VoucherMasterDetail->_short_narr = $_short_narr[$i] ?? 'N/A';
                    $VoucherMasterDetail->_dr_amount = $_dr_amount[$i] ?? 0;
                    $VoucherMasterDetail->_cr_amount = $_cr_amount[$i] ?? 0;
                    $VoucherMasterDetail->_foreign_amount = $_foreign_amounts[$i] ?? 0;
                    $VoucherMasterDetail->_status = 1;
                    $VoucherMasterDetail->_created_by = $users->id."-".$users->name;
                    $VoucherMasterDetail->save();
                    $master_detail_id = $VoucherMasterDetail->id;



                    //Reporting Account Table Data Insert

                    $Accounts = new \App\Models\Accounts();
                    $Accounts->_ref_master_id = $master_id;
                    $Accounts->_ref_detail_id = $master_detail_id;
                  
                    $Accounts->_short_narration = $_note ?? 'N/A';
                    $Accounts->_narration = $_note ?? '' ;
                    $Accounts->_reference = $request->_transection_ref;
                    $Accounts->_voucher_type = $request->_voucher_type ?? 'JV';
                    $Accounts->_voucher_code = $_code ?? '';
                     $Accounts->_lc_id = $request->_lc_id ?? '';
                    $Accounts->_lc_no = id_to_cloumn($request->_lc_id ?? '','lc_ip_no','lc_masters');
                    $Accounts->_lc_stage_id = $_lc_stage_id ?? 1;

                    $Accounts->_transaction = 'lc_masters';
                    $Accounts->_date = change_date_format($request->_date);
                    $Accounts->_table_name = $request->_form_name ?? 'voucher_masters';
                    $Accounts->_account_head = $_account_type_id;
                    $Accounts->_account_group = $_account_group_id;
                    $Accounts->_account_ledger = $_ledger_id[$i];
                    $Accounts->_dr_amount = $_dr_amount[$i] ?? 0;
                    $Accounts->_cr_amount = $_cr_amount[$i] ?? 0;
                    $Accounts->_foreign_amount = $_foreign_amounts[$i] ?? 0;

                    $Accounts->organization_id = $organization_id;
                    $Accounts->_branch_id = $_branch_id ?? 0;
                    $Accounts->_cost_center = $_cost_center_id ?? 0;
                    $Accounts->_budget_id = $_budget_id ?? 0;

                    $Accounts->_name =$users->name;
                    $Accounts->_sales_man_id = $request->_sales_man_id ?? 0;
                    $Accounts->_check_no = $request->_check_no ?? '';
                    $Accounts->_issue_date = $request->_issue_date ?? '';
                    $Accounts->_cash_date = $request->_cash_date ?? '';
                    $Accounts->save();

                   $_l_balance = ledger_balance_update($_ledger_id[$i]);
                  $_l_balance = _l_balance_update($_ledger_id[$i]);
                }
            }
           
         
           

        

        } //End of check posting yes or no





        return redirect()->route('lc_manage.index')->with('success', 'LC updated successfully!');
    }
}
