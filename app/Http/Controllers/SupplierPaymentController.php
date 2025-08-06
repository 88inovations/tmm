<?php

namespace App\Http\Controllers;

use App\Models\SupplierPayment;
use App\Models\SupplierPaymentDetail;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\AccountLedger;
use App\Models\AccountGroup;
use App\Models\AccountHead;
use App\Models\Accounts;
use App\Models\Branch;
use App\Models\VoucherType;
use App\Models\SalesFormSetting;
use App\Models\PurchaseFormSettings;
use Auth;
use DB;
use Session;

class SupplierPaymentController extends Controller
{

    function __construct()
    {
         
         $this->middleware('permission:supplier_payment_list', ['only' => ['index']]);
         $this->middleware('permission:supplier_payment_create', ['only' => ['create','store']]);
         $this->middleware('permission:supplier_payment_edit', ['only' => ['edit','update']]);
         $this->middleware('permission:supplier_payment_delete', ['only' => ['destroy']]);
         $this->middleware('permission:supplier_payment_receipt', ['only' => ['moneyPaymentReceiptPrint']]);
         $this->page_name = __('label.supplier_payment');
        




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
            session()->put('_vm_limit', $request->limit);
        }else{
             $limit= \Session::get('_vm_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $datas = SupplierPayment::with(['_sup_cus','_organization','_master_branch','_master_details','_voucher_emp_ref'])->where('_status',1);
        $datas = $datas->whereIn('_branch_id',explode(',',\Auth::user()->branch_ids));
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
        
        if($request->has('_order_number') && $request->_order_number !=''){
            $datas = $datas->where('_order_number','like',"%$request->_order_number%");
        }
        if($request->has('_lock') && $request->_lock !=''){
            $datas = $datas->where('_lock','=',$request->_lock);
        }
        if($request->has('_voucher_type') && $request->_voucher_type !=''){
            $datas = $datas->where('_voucher_type','=',$request->_voucher_type);
        }

        if($request->has('_transection_ref') && $request->_transection_ref !=''){
            $datas = $datas->where('_transection_ref','like',"%$request->_transection_ref%");
        }
        if($request->has('_ledger_id') && $request->_ledger_id !=''){
            $datas = $datas->where('_ledger_id',$request->_ledger_id);
        }
        if($request->has('_user_name') && $request->_user_name !=''){
            $datas = $datas->where('_user_name','like',"%$request->_user_name%");
        }
        
        if($request->has('_amount') && $request->_amount !=''){
            $datas = $datas->where('_amount','=',$request->_amount);
        }
        
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);
        
        $page_name = $this->page_name;
       // return $request->all();

        
         $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
         $account_groups = AccountGroup::select('id','_name')->orderBy('_name','asc')->get();
          $current_date = date('Y-m-d');
          $current_time = date('H:i:s');
         


        return view('backend.supplier_payment.index',compact('datas','page_name','account_types','request','account_groups','current_date','limit'));
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
        $account_groups = AccountGroup::select('id','_name')->orderBy('_name','asc')->get();
        $branchs = Branch::orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $voucher_types = VoucherType::select('id','_name','_code')->orderBy('_code','asc')->get();
        $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));

       return view('backend.supplier_payment.create',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','permited_budgets','permited_organizations'));
    }

    public function find_supplier_due_history(Request $request){
        $_ledger_id = $request->_id ?? '';
        $_form_name = $request->_form_name ?? '';
        $_master_id = $request->_master_id ?? '';
        $datas      = DB::table("purchases")->where('_ledger_id',$_ledger_id)
                                            ->where('_is_close','=',0)
                                            ->where('_status',1)->get();

         $sales_form_settings       = SalesFormSetting::first();
         $purchase_form_settings    = PurchaseFormSettings::first();

        $general_settings        = DB::table('general_settings')->first();
        $_customer_incentive_ledger  = $general_settings->_customer_incentive_ledger ?? 0;
        $_baddebt_ledgers            = $general_settings->_baddebt_ledgers ?? 0;
        $_default_discount           = $purchase_form_settings->_default_discount ?? 0;

        $other_ledgers_ids              =[$_ledger_id,$_customer_incentive_ledger,$_baddebt_ledgers,$_default_discount];

        $account_group_configs        = DB::table('account_group_configs')->first();
        $_cash_group                  = $account_group_configs->_cash_group ?? '';
        $_bank_group                  = $account_group_configs->_bank_group ?? '';

        $cash_bank_group_array        = [];
        $cash_bank_group_1            = explode(",", $_cash_group);
        $cash_bank_group_2            = explode(",", $_bank_group);



        $cash_bank_group_array = array_merge($cash_bank_group_1,$cash_bank_group_2);
        $cash_and_bank_ledgers_ids = \DB::table("account_ledgers")
                                    ->whereIn('_account_group_id',$cash_bank_group_array)
                                    ->pluck('id')->toArray();

        $fetchable_ledgers = array_merge($cash_and_bank_ledgers_ids,$other_ledgers_ids);

        $collection_ledgers = \DB::table("account_ledgers")
                                    ->whereIn('id',$fetchable_ledgers)
                                    ->get();


        return view('backend.supplier_payment.due_history',compact('datas','collection_ledgers'));
        return $datas;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        $this->validate($request, [
             'organization_id' => 'required',
            '_branch_id' => 'required',
            '_cost_center_id' => 'required',
            '_voucher_type' => 'required',
            '_main_ledger_id' => 'required',
            '_date' => 'required'
        ]);

          //return $request->all();

        $organization_id = $request->organization_id;
        $_branch_id      = $request->_branch_id;
        $_main_branch_id = $request->_branch_id;
        $_cost_center_id = $request->_cost_center_id;
        $_sales_man_id = $request->_sales_man_id ?? 0;
        $_grand_collection_amount = $request->_grand_collection_amount ?? 0;
        $__table         = $request->_form_name ?? 'supplier_payments';
        $_date           = change_date_format($request->_date);
        $_order_number   = make_order_number($__table,$organization_id,$_branch_id,$_date);
         
        //SupplierPayment
        //SupplierPaymentDetail


        $_print_value = $request->_print ?? 0;
         $users = Auth::user();
        $SupplierPayment                = new SupplierPayment();
        $SupplierPayment->_date         = change_date_format($request->_date);
        $SupplierPayment->_time         = date('H:i:s');

        $SupplierPayment->_order_number     = $_order_number;
        $SupplierPayment->_transection_ref  = $request->_referance ?? '';
        $SupplierPayment->_ledger_id        = $request->_main_ledger_id;
        
        $SupplierPayment->_created_by       = $users->id."-".$users->name;
        $SupplierPayment->_user_id          = $users->id;
        $SupplierPayment->_user_name        = $users->name;
        $SupplierPayment->_note             = $request->_note;
        $SupplierPayment->_sales_man_id        = $_sales_man_id;

        $SupplierPayment->_amount           = $_grand_collection_amount;
        // $SupplierPayment->_total_discount   = $__total_discount;
        // $SupplierPayment->_total_vat        = $__total_vat;
        // $SupplierPayment->_total            =  $__total;

        $SupplierPayment->_voucher_type        = $request->_voucher_type ?? 'JV';
        $SupplierPayment->_branch_id        = $request->_branch_id;
        $SupplierPayment->organization_id   = $organization_id;
        $SupplierPayment->_cost_center_id   = $request->_cost_center_id;
        $SupplierPayment->_address          = $request->_address;
        $SupplierPayment->_phone            = $request->_phone;
        $SupplierPayment->_status           = 1;
        $SupplierPayment->_lock             = $request->_lock ?? 0;
        $SupplierPayment->save();
        $purchase_id = $SupplierPayment->id;
        $master_id = $SupplierPayment->id;

        $_pfix               = $SupplierPayment->_order_number ?? '';
        $_code               = $SupplierPayment->_order_number ?? '';


       $sales_ids               = $request->sales_id ?? [];
       $_order_numbers          = $request->_order_number ?? [];
       $_totals                 = $request->_total ?? [];
       $_receive_amounts        = $request->_receive_amount ?? [];
       $_due_amounts            = $request->_due_amount ?? [];
       $_collection_ledger_ids  = $request->_collection_ledger_id ?? [];
       $_collection_amounts     = $request->_collection_amount ?? [];
       $_due_balances           = $request->_due_balance ?? [];
       $_is_closes              = $request->_is_close ?? [];
       $_is_effects             = $request->_is_effect ?? [];


    $collection_ledgers_groups  = [];
    $_transection_ref           = [];
   

    for ($i=0; $i <sizeof($sales_ids) ; $i++) { 

        $_invoice_id        = $sales_ids[$i] ?? 0;
        $_invoice_number    = $_order_numbers[$i] ?? '';
        $_total             = $_totals[$i] ?? 0;
        $_receive_amount    = $_receive_amounts[$i] ?? 0;
        $_due_amount        = $_due_amounts[$i] ?? 0;
        $_collection_amount = $_collection_amounts[$i] ?? 0;
        $_due_balance       = $_due_balances[$i] ?? 0;
        $_short_narr        = $_short_narrs[$i] ?? '';
        $_collection_ledger_id= $_collection_ledger_ids[$i] ?? 0;
        $_is_close            = $_is_closes[$i] ?? 0;
        $_is_effect            = $_is_effects[$i] ?? 0;

        if($_collection_amount > 0){
            $SupplierPaymentDetail                       = new SupplierPaymentDetail();
           $SupplierPaymentDetail->_no                  = $purchase_id;
           $SupplierPaymentDetail->_voucher_code        = $_pfix;
           $SupplierPaymentDetail->_invoice_id          = $_invoice_id;
           $SupplierPaymentDetail->_invoice_number      = $_invoice_number;
           $SupplierPaymentDetail->_total               = $_total;
           $SupplierPaymentDetail->_receive_amount      = $_receive_amount;
           $SupplierPaymentDetail->_due_amount          = $_due_amount;
           $SupplierPaymentDetail->_collection_amount   = $_collection_amount;
           $SupplierPaymentDetail->_due_balance         = $_due_balance;
           $SupplierPaymentDetail->_type                = $_type ?? 'payment';
           $SupplierPaymentDetail->_sales_man_id        = $_sales_man_id;
           $SupplierPaymentDetail->_collection_ledger_id= $_collection_ledger_id;
           $SupplierPaymentDetail->_short_narr          = $_short_narr ?? '';
           $SupplierPaymentDetail->_status              = $_status ?? 1;
           $SupplierPaymentDetail->_is_close            = $_is_close ?? 1;
           $SupplierPaymentDetail->_is_effect            = $_is_effect ?? 1;
           $SupplierPaymentDetail->_created_by          = $_created_by ?? 1;
           $SupplierPaymentDetail->created_at           = date('d-m-Y H:i:s');
           $SupplierPaymentDetail->save();
           $master_detail_id = $SupplierPaymentDetail->id;
           if($_collection_amount > 0  && $_is_effect==1){
            $collection_ledgers_groups[$_collection_ledger_id][]=$_collection_amount ?? 0;
           }

           
           $_transection_ref[]                              = $_invoice_number ?? '';


           
        }

        //Update Purchase Invoice Number
       $Purchase            = Purchase::find($_invoice_id);
       $old_receive_amount  = $Purchase->_receive_amount ?? 0;
       $old_due_amount      = $Purchase->_due_amount ?? 0;


       $new_receive_amount  = ($old_receive_amount + $_collection_amount);
       $new_due_amount      = ($_total -($old_receive_amount));

       $Purchase->_receive_amount= $new_receive_amount;
       $Purchase->_due_amount= $new_due_amount;
       $Purchase->_is_close= $_is_close ?? 0;
       
       $Purchase->save();







    }
       
//return $collection_ledgers_groups;

$array_of_dr_amount = 0;

$_transection_ref_string = implode(',',$_transection_ref);
if(sizeof($collection_ledgers_groups) > 0){
    foreach($collection_ledgers_groups as $l_key=>$l_val){
       //Reporting Account Table Data Insert
        $_account_ledger     = $l_key;
        $_cr_amount          = array_sum($l_val);
        $array_of_dr_amount  += $_cr_amount;
        $_account_type_id       =  ledger_to_group_type($_account_ledger)->_account_head_id;
        $_account_group_id      =  ledger_to_group_type($_account_ledger)->_account_group_id;
            $Accounts                       = new Accounts();
            $Accounts->_ref_master_id       = $master_id;
            $Accounts->_ref_detail_id       = $master_detail_id;
            $Accounts->_short_narration     = $_short_narr[$i] ?? 'N/A';
            $Accounts->_narration           = $request->_note ?? '';
            $Accounts->_reference           = $_transection_ref_string;
            $Accounts->_voucher_type        = $request->_voucher_type ?? 'JV';
            $Accounts->_voucher_code        = $_code ?? '';
            $Accounts->_transaction         = 'Account';
            $Accounts->_date                = change_date_format($request->_date);
            $Accounts->_table_name          = $request->_form_name;
            $Accounts->_account_head        = $_account_type_id;
            $Accounts->_account_group       = $_account_group_id;
            $Accounts->_account_ledger      = $_account_ledger;
            $Accounts->_dr_amount           = 0;
            $Accounts->_cr_amount           =  $_cr_amount ?? 0;
            $Accounts->_foreign_amount      = $_foreign_amounts[$i] ?? 0;
            $Accounts->organization_id      = $organization_id;
            $Accounts->_branch_id           = $_branch_id;
            $Accounts->_cost_center         = $_cost_center_id ?? 0;
            $Accounts->_budget_id           = $_budget_id ?? 0;
            $Accounts->_name                =  $users->name;
            $Accounts->_sales_man_id        = $request->_sales_man_id ?? 0;
            $Accounts->save();

            ledger_balance_update($_account_ledger);
    }
}


//Supplier Journal Voucher Entry

if($array_of_dr_amount > 0){

     //Reporting Account Table Data Insert
        $_main_ledger_id     = $request->_main_ledger_id;
       
        $_account_type_id       =  ledger_to_group_type($_main_ledger_id)->_account_head_id;
        $_account_group_id      =  ledger_to_group_type($_main_ledger_id)->_account_group_id;
        
            $Accounts                       = new Accounts();
            $Accounts->_ref_master_id       = $master_id;
            $Accounts->_ref_detail_id       = $master_detail_id;
            $Accounts->_short_narration     = $_short_narr[$i] ?? 'N/A';
            $Accounts->_narration           = $request->_note ?? '';
            $Accounts->_reference           = $_transection_ref_string;
            $Accounts->_voucher_type        = $request->_voucher_type ?? 'JV';
            $Accounts->_voucher_code        = $_code ?? '';
            $Accounts->_transaction         = 'Account';
            $Accounts->_date                = change_date_format($request->_date);
            $Accounts->_table_name          = $request->_form_name;
            $Accounts->_account_head        = $_account_type_id;
            $Accounts->_account_group       = $_account_group_id;
            $Accounts->_account_ledger      = $_main_ledger_id;
            $Accounts->_dr_amount           = $array_of_dr_amount ?? 0;
            $Accounts->_cr_amount           =   0;
            $Accounts->_foreign_amount      = $_foreign_amounts[$i] ?? 0;

            $Accounts->organization_id      = $organization_id;
            $Accounts->_branch_id           = $_branch_id;
            $Accounts->_cost_center         = $_cost_center_id ?? 0;
            $Accounts->_budget_id           = $_budget_id ?? 0;

            $Accounts->_name                =  $users->name;
            $Accounts->_sales_man_id        = $request->_sales_man_id ?? 0;
           
            $Accounts->save();

            ledger_balance_update($_main_ledger_id);

}

            

$success_message ="Information Save successfully.";

return redirect()->back()
            ->with('success',$success_message);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SupplierPayment  $supplierPayment
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        //
        $users = Auth::user();
        $page_name = $this->page_name;
        $data = SupplierPayment::with(['_sup_cus','_organization','_master_branch','_master_details','_voucher_emp_ref'])->where('_status',1)->find($id);


         return view('backend.supplier_payment.show',compact('page_name','data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SupplierPayment  $supplierPayment
     * @return \Illuminate\Http\Response
     */
    public function supplier_payment_print( $id)
    {
        //
        $users = Auth::user();
        $page_name = $this->page_name;
        $data = SupplierPayment::with(['_sup_cus','_organization','_master_branch','_master_details','_voucher_emp_ref'])->where('_status',1)->find($id);
         return view('backend.supplier_payment.payment_receipt',compact('page_name','data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SupplierPayment  $supplierPayment
     * @return \Illuminate\Http\Response
     */
    public function customer_payment_receipt( $id)
    {
        //
        $users = Auth::user();
        $page_name = $this->page_name;
        $data = SupplierPayment::with(['_sup_cus','_organization','_master_branch','_master_details','_voucher_emp_ref'])->where('_status',1)->find($id);
         return view('backend.supplier_payment.customer_payment_receipt',compact('page_name','data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SupplierPayment  $supplierPayment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = SupplierPayment::with(['_sup_cus','_organization','_master_branch','_master_details','_voucher_emp_ref'])->where('_status',1)->find($id);
        $_master_details = $data->_master_details ?? [];

        $users = Auth::user();
        $page_name = $this->page_name;
        $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
        $account_groups = AccountGroup::select('id','_name')->orderBy('_name','asc')->get();
        $branchs = Branch::orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $voucher_types = VoucherType::select('id','_name','_code')->orderBy('_code','asc')->get();
        $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));



        $_ledger_id = $datas->_ledger_id ?? '';
        $_form_name = $datas->_form_name ?? '';
        $_master_id = $datas->id ?? '';
        //$datas      = DB::table("purchases")->where('_is_close','=',0)->get();

         $sales_form_settings       = SalesFormSetting::first();
         $purchase_form_settings    = PurchaseFormSettings::first();

        $general_settings        = DB::table('general_settings')->first();
        $_customer_incentive_ledger  = $general_settings->_customer_incentive_ledger ?? 0;
        $_baddebt_ledgers            = $general_settings->_baddebt_ledgers ?? 0;
        $_default_discount           = $purchase_form_settings->_default_discount ?? 0;

        $other_ledgers_ids              =[$_ledger_id,$_customer_incentive_ledger,$_baddebt_ledgers,$_default_discount];

        $account_group_configs        = DB::table('account_group_configs')->first();
        $_cash_group                  = $account_group_configs->_cash_group ?? '';
        $_bank_group                  = $account_group_configs->_bank_group ?? '';

        $cash_bank_group_array        = [];
        $cash_bank_group_1            = explode(",", $_cash_group);
        $cash_bank_group_2            = explode(",", $_bank_group);



        $cash_bank_group_array = array_merge($cash_bank_group_1,$cash_bank_group_2);
        $cash_and_bank_ledgers_ids = \DB::table("account_ledgers")
                                    ->whereIn('_account_group_id',$cash_bank_group_array)
                                    ->pluck('id')->toArray();

        $fetchable_ledgers = array_merge($cash_and_bank_ledgers_ids,$other_ledgers_ids);

        $collection_ledgers = \DB::table("account_ledgers")
                                    ->whereIn('id',$fetchable_ledgers)
                                    ->get();



       return view('backend.supplier_payment.edit',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','permited_budgets','permited_organizations','data','_master_details','collection_ledgers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SupplierPayment  $supplierPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        //return $request->all();

$this->validate($request, [
     '_master_id' => 'required',
     'organization_id' => 'required',
    '_branch_id' => 'required',
    '_cost_center_id' => 'required',
    '_voucher_type' => 'required',
    '_main_ledger_id' => 'required',
    '_date' => 'required',
    '_order_number' => 'required'
]);

          //return $request->all();

        $organization_id = $request->organization_id;
        $_branch_id      = $request->_branch_id;
        $_main_branch_id = $request->_branch_id;
        $_cost_center_id = $request->_cost_center_id;
        $_sales_man_id   = $request->_sales_man_id ?? 0;
        $_grand_collection_amount = $request->_grand_collection_amount ?? 0;
        $__table         = $request->_form_name ?? 'supplier_payments';
        $_date           = change_date_format($request->_date);
        $_order_number   = $request->_transection_number ?? '';
        $_master_id      = $request->_master_id ?? 0;


    $details = SupplierPaymentDetail::where('_no',$_master_id)->where('_status',1)->get();
    foreach($details as $detail){
        $_invoice_id  =  $detail->_invoice_id;
        //Update Purchase Invoice Number
           $Purchase            = Purchase::find($_invoice_id);
           $old_receive_amount  = $Purchase->_receive_amount ?? 0;
           $old_due_amount      = $Purchase->_due_amount ?? 0;

           $_total               = $detail->_total ?? 0;
           $_collection_amount   = $detail->_collection_amount ?? 0;

           $new_receive_amount  = ($old_receive_amount - $_collection_amount);
           $new_due_amount      = ($_total +($old_receive_amount));

           $Purchase->_receive_amount= $new_receive_amount;
           $Purchase->_due_amount= $new_due_amount;
           if($new_due_amount ==0){
            $Purchase->_is_close= 1;
           }else{
            $Purchase->_is_close= 0;
           }
           $Purchase->save();
    }

    SupplierPaymentDetail::where('_no',$_master_id)->update(['_status'=>0]);
    Accounts::where('_ref_master_id',$_master_id)->where('_table_name','supplier_payments')->update(['_status'=>0]);


        //SupplierPayment
        //SupplierPaymentDetail


        $_print_value = $request->_print ?? 0;
         $users = Auth::user();
        $SupplierPayment                = SupplierPayment::find($_master_id);
        $SupplierPayment->_date         = change_date_format($request->_date);
        $SupplierPayment->_time         = date('H:i:s');

        $SupplierPayment->_order_number     = $_order_number;
        $SupplierPayment->_transection_ref  = $request->_referance ?? '';
        $SupplierPayment->_ledger_id        = $request->_main_ledger_id;
        
        $SupplierPayment->_created_by       = $users->id."-".$users->name;
        $SupplierPayment->_user_id          = $users->id;
        $SupplierPayment->_user_name        = $users->name;
        $SupplierPayment->_note             = $request->_note;
        $SupplierPayment->_sales_man_id     = $_sales_man_id;

        $SupplierPayment->_amount           = $_grand_collection_amount;
        // $SupplierPayment->_total_discount   = $__total_discount;
        // $SupplierPayment->_total_vat        = $__total_vat;
        // $SupplierPayment->_total            =  $__total;

        $SupplierPayment->_voucher_type        = $request->_voucher_type ?? 'JV';
        $SupplierPayment->_branch_id        = $request->_branch_id;
        $SupplierPayment->organization_id   = $organization_id;
        $SupplierPayment->_cost_center_id   = $request->_cost_center_id;
        $SupplierPayment->_address          = $request->_address;
        $SupplierPayment->_phone            = $request->_phone;
        $SupplierPayment->_status           = 1;
        $SupplierPayment->_lock             = $request->_lock ?? 0;
        $SupplierPayment->save();
        $purchase_id = $SupplierPayment->id;
        $master_id = $SupplierPayment->id;

        $_pfix               = $SupplierPayment->_order_number ?? '';
        $_code               = $SupplierPayment->_order_number ?? '';


       $sales_ids               = $request->sales_id ?? [];
       $_order_numbers          = $request->_order_number ?? [];
       $_totals                 = $request->_total ?? [];
       $_receive_amounts        = $request->_receive_amount ?? [];
       $_due_amounts            = $request->_due_amount ?? [];
       $_collection_ledger_ids  = $request->_collection_ledger_id ?? [];
       $_collection_amounts     = $request->_collection_amount ?? [];
       $_due_balances           = $request->_due_balance ?? [];
       $_is_closes              = $request->_is_close ?? [];
       $_is_effects             = $request->_is_effect ?? [];


    $collection_ledgers_groups  = [];
    $_transection_ref           = [];








   

    for ($i=0; $i <sizeof($sales_ids) ; $i++) { 

        $_invoice_id        = $sales_ids[$i] ?? 0;
        $_invoice_number    = $_order_numbers[$i] ?? '';
        $_total             = $_totals[$i] ?? 0;
        $_receive_amount    = $_receive_amounts[$i] ?? 0;
        $_due_amount        = $_due_amounts[$i] ?? 0;
        $_collection_amount = $_collection_amounts[$i] ?? 0;
        $_due_balance       = $_due_balances[$i] ?? 0;
        $_short_narr        = $_short_narrs[$i] ?? '';
        $_collection_ledger_id= $_collection_ledger_ids[$i] ?? 0;
        $_is_close            = $_is_closes[$i] ?? 0;
        $_is_effect            = $_is_effects[$i] ?? 0;

        if($_collection_amount > 0){
            $SupplierPaymentDetail                       = new SupplierPaymentDetail();
           $SupplierPaymentDetail->_no                  = $purchase_id;
           $SupplierPaymentDetail->_voucher_code        = $_pfix;
           $SupplierPaymentDetail->_invoice_id          = $_invoice_id;
           $SupplierPaymentDetail->_invoice_number      = $_invoice_number;
           $SupplierPaymentDetail->_total               = $_total;
           $SupplierPaymentDetail->_receive_amount      = $_receive_amount;
           $SupplierPaymentDetail->_due_amount          = $_due_amount;
           $SupplierPaymentDetail->_collection_amount   = $_collection_amount;
           $SupplierPaymentDetail->_due_balance         = $_due_balance;
           $SupplierPaymentDetail->_type                = $_type ?? 'payment';
           $SupplierPaymentDetail->_sales_man_id        = $_sales_man_id;
           $SupplierPaymentDetail->_collection_ledger_id= $_collection_ledger_id;
           $SupplierPaymentDetail->_short_narr          = $_short_narr ?? '';
           $SupplierPaymentDetail->_status              = $_status ?? 1;
           $SupplierPaymentDetail->_is_close            = $_is_close ?? 1;
           $SupplierPaymentDetail->_is_effect            = $_is_effect ?? 1;
           $SupplierPaymentDetail->_created_by          = $_created_by ?? 1;
           $SupplierPaymentDetail->created_at           = date('d-m-Y H:i:s');
           $SupplierPaymentDetail->save();
           $master_detail_id = $SupplierPaymentDetail->id;
           if($_collection_amount > 0){
            $collection_ledgers_groups[$_collection_ledger_id][]=$_collection_amount ?? 0;
           }

           
           $_transection_ref[]                              = $_invoice_number ?? '';


           
        }

        //Update Purchase Invoice Number
       $Purchase            = Purchase::find($_invoice_id);
       $old_receive_amount  = $Purchase->_receive_amount ?? 0;
       $old_due_amount      = $Purchase->_due_amount ?? 0;


       $new_receive_amount  = ($old_receive_amount + $_collection_amount);
       $new_due_amount      = ($_total -($old_receive_amount));

       $Purchase->_receive_amount= $new_receive_amount;
       $Purchase->_due_amount= $new_due_amount;
       $Purchase->_is_close= $_is_close ?? 0;
       
       $Purchase->save();







    }
       
//return $collection_ledgers_groups;

$array_of_dr_amount = 0;

$_transection_ref_string = implode(',',$_transection_ref);
if(sizeof($collection_ledgers_groups) > 0){
    foreach($collection_ledgers_groups as $l_key=>$l_val){
       //Reporting Account Table Data Insert
        $_account_ledger     = $l_key;
        $_cr_amount          = array_sum($l_val);
        $array_of_dr_amount  += $_cr_amount;
        $_account_type_id       =  ledger_to_group_type($_account_ledger)->_account_head_id;
        $_account_group_id      =  ledger_to_group_type($_account_ledger)->_account_group_id;
        
            $Accounts                       = new Accounts();
            $Accounts->_ref_master_id       = $master_id;
            $Accounts->_ref_detail_id       = $master_detail_id;
            $Accounts->_short_narration     = $_short_narr[$i] ?? 'N/A';
            $Accounts->_narration           = $request->_note ?? '';
            $Accounts->_reference           = $_transection_ref_string;
            $Accounts->_voucher_type        = $request->_voucher_type ?? 'JV';
            $Accounts->_voucher_code        = $_code ?? '';
            $Accounts->_transaction         = 'Account';
            $Accounts->_date                = change_date_format($request->_date);
            $Accounts->_table_name          = $request->_form_name;
            $Accounts->_account_head        = $_account_type_id;
            $Accounts->_account_group       = $_account_group_id;
            $Accounts->_account_ledger      = $_account_ledger;
            $Accounts->_dr_amount           = 0;
            $Accounts->_cr_amount           =  $_cr_amount ?? 0;
            $Accounts->_foreign_amount      = $_foreign_amounts[$i] ?? 0;

            $Accounts->organization_id      = $organization_id;
            $Accounts->_branch_id           = $_branch_id;
            $Accounts->_cost_center         = $_cost_center_id ?? 0;
            $Accounts->_budget_id           = $_budget_id ?? 0;

            $Accounts->_name                =  $users->name;
            $Accounts->_sales_man_id        = $request->_sales_man_id ?? 0;
           
            $Accounts->save();

            ledger_balance_update($_account_ledger);
    }
}


//Supplier Journal Voucher Entry

if($array_of_dr_amount > 0){

     //Reporting Account Table Data Insert
        $_main_ledger_id     = $request->_main_ledger_id;
       
        $_account_type_id       =  ledger_to_group_type($_main_ledger_id)->_account_head_id;
        $_account_group_id      =  ledger_to_group_type($_main_ledger_id)->_account_group_id;
        
            $Accounts                       = new Accounts();
            $Accounts->_ref_master_id       = $master_id;
            $Accounts->_ref_detail_id       = $master_detail_id;
            $Accounts->_short_narration     = $_short_narr[$i] ?? 'N/A';
            $Accounts->_narration           = $request->_note ?? '';
            $Accounts->_reference           = $_transection_ref_string;
            $Accounts->_voucher_type        = $request->_voucher_type ?? 'JV';
            $Accounts->_voucher_code        = $_code ?? '';
            $Accounts->_transaction         = 'Account';
            $Accounts->_date                = change_date_format($request->_date);
            $Accounts->_table_name          = $request->_form_name;
            $Accounts->_account_head        = $_account_type_id;
            $Accounts->_account_group       = $_account_group_id;
            $Accounts->_account_ledger      = $_main_ledger_id;
            $Accounts->_dr_amount           = $array_of_dr_amount ?? 0;
            $Accounts->_cr_amount           =   0;
            $Accounts->_foreign_amount      = $_foreign_amounts[$i] ?? 0;

            $Accounts->organization_id      = $organization_id;
            $Accounts->_branch_id           = $_branch_id;
            $Accounts->_cost_center         = $_cost_center_id ?? 0;
            $Accounts->_budget_id           = $_budget_id ?? 0;

            $Accounts->_name                =  $users->name;
            $Accounts->_sales_man_id        = $request->_sales_man_id ?? 0;
           
            $Accounts->save();

            ledger_balance_update($_main_ledger_id);

}

            

$success_message ="Information Save successfully.";

return redirect()->back()
            ->with('success',$success_message);



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupplierPayment  $supplierPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
            $users = Auth::user();
            SupplierPayment::where('id',$id)->update(['_status'=>0,'_is_delete'=>1,'_updated_by'=>$users->id."-".$users->name]);
            $details = SupplierPaymentDetail::where('_no',$id)->where('_status',1)->get();
          

                foreach($details as $detail){
                    $_invoice_id  =  $detail->_invoice_id;
                    //Update Purchase Invoice Number
                       $Purchase            = Purchase::find($_invoice_id);
                       $old_receive_amount  = $Purchase->_receive_amount ?? 0;
                       $old_due_amount      = $Purchase->_due_amount ?? 0;

                       $_total               = $detail->_total ?? 0;
                       $_collection_amount   = $detail->_collection_amount ?? 0;

                       $new_receive_amount  = ($old_receive_amount - $_collection_amount);
                       $new_due_amount      = ($_total +($old_receive_amount));

                       $Purchase->_receive_amount= $new_receive_amount;
                       $Purchase->_due_amount= $new_due_amount;
                       $Purchase->save();
                }

            SupplierPaymentDetail::where('_no',$id)->update(['_status'=>0]);
            Accounts::where('_ref_master_id',$id)->where('_table_name','supplier_payments')->update(['_status'=>0]);

        $success_message ="Information Deleted successfully.";
        return redirect()->back()
                    ->with('success',$success_message);

 
    }
}
