<?php

namespace App\Http\Controllers;


use App\Models\ReceivePayment;
use App\Models\ReceivePaymentDetail;
use App\Models\Sales;
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

class ReceivePaymentController extends Controller
{

        function __construct()
    {
         
         $this->middleware('permission:customer_payment_list', ['only' => ['index']]);
         $this->middleware('permission:customer_payment_create', ['only' => ['create','store']]);
         $this->middleware('permission:customer_payment_edit', ['only' => ['edit','update']]);
         $this->middleware('permission:customer_payment_delete', ['only' => ['destroy']]);
         $this->middleware('permission:customer_payment_receipt', ['only' => ['moneyPaymentReceiptPrint']]);
         $this->page_name = __('label.customer_payment');

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

        $datas = ReceivePayment::with(['_sup_cus','_organization','_master_branch','_master_details','_voucher_emp_ref'])->where('_status',1);
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
        if($request->has('_is_confirm') && $request->_is_confirm !=''){
            $datas = $datas->where('_is_confirm','=',$request->_is_confirm);
        }
        
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);
        
        $page_name = $this->page_name;
       // return $request->all();

        
         $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
         $account_groups = AccountGroup::select('id','_name')->orderBy('_name','asc')->get();
          $current_date = date('Y-m-d');
          $current_time = date('H:i:s');
         

         

        return view('backend.customer_payment.index',compact('datas','auth_user','page_name','account_types','request','account_groups','current_date','limit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
       public function create()
    {
        $users = Auth::user();
        $auth_user  = $users;
        $page_name = $this->page_name;
        $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
        $account_groups = AccountGroup::select('id','_name')->orderBy('_name','asc')->get();
        $branchs = Branch::orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $voucher_types = VoucherType::select('id','_name','_code')->orderBy('_code','asc')->get();
        $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));

       return view('backend.customer_payment.create',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','permited_budgets','permited_organizations','auth_user'));
    }

    public function find_customer_due_history(Request $request){



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



        $_ledger_id = $request->_id ?? '';
        $_form_name = $request->_form_name ?? '';
        $_master_id = $request->_master_id ?? '';
        $datas      = DB::table("sales")->where('_ledger_id',$_ledger_id)
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


        return view('backend.customer_payment.due_history',compact('datas','collection_ledgers','account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','permited_budgets','permited_organizations'));
        
    }

    public function customer_wise_due_collection(Request $request){



        $users = Auth::user();
        $page_name = $this->page_name;
        $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
        $account_groups = AccountGroup::select('id','_name')->orderBy('_name','asc')->get();
        $branchs = Branch::orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $voucher_types = VoucherType::select('id','_name','_code')->whereIn('id',[1,3,6])->orderBy('_code','asc')->get();
        $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));



        $_ledger_id = $request->_id ?? '';
        $_form_name = $request->_form_name ?? '';
        $_master_id = $request->_master_id ?? '';
         $datas      = DB::table("sales")->where('_ledger_id',$_ledger_id)
                                            ->where('_is_close','=',0)
                                            ->where('_status',1)->get();

        $_branch_id      = $datas[0]->_brand_id ?? 0;
        $_sales_man_id   = $datas[0]->_sales_man_id ?? 0;

        $data   = DB::table('account_ledgers')->where('id',$_ledger_id)->first();
        $sales_man   = DB::table('account_ledgers')->where('id',$_sales_man_id)->first();

         $sales_form_settings       = SalesFormSetting::first();
         $purchase_form_settings    = PurchaseFormSettings::first();

        $general_settings            = DB::table('general_settings')->first();
        $_customer_incentive_ledger  = $general_settings->_customer_incentive_ledger ?? 0;
        $_baddebt_ledgers            = $general_settings->_baddebt_ledgers ?? 0;
        $_default_discount           = $purchase_form_settings->_default_discount ?? 0;
        $_sales_discount           = $sales_form_settings->_default_discount ?? 0;

        $other_ledgers_ids           = [$_ledger_id,$_customer_incentive_ledger,$_baddebt_ledgers,$_default_discount,$_sales_discount];

        $account_group_configs        = DB::table('account_group_configs')->first();
        $_cash_group                  = $account_group_configs->_cash_group ?? '';
        $_bank_group                  = $account_group_configs->_bank_group ?? '';

        $cash_bank_group_array        = [];
        $cash_bank_group_1            = explode(",", $_cash_group);
        $cash_bank_group_2            = explode(",", $_bank_group);



        $cash_bank_group_array     = array_merge($cash_bank_group_1,$cash_bank_group_2);
        $cash_and_bank_ledgers_ids = \DB::table("account_ledgers")
                                    ->whereIn('_account_group_id',$cash_bank_group_array)
                                    ->pluck('id')->toArray();

        $fetchable_ledgers = array_merge($cash_and_bank_ledgers_ids,$other_ledgers_ids);

        $collection_ledgers = \DB::table("account_ledgers")
                                    ->whereIn('id',$fetchable_ledgers)
                                    ->get();


        return view('backend.customer_payment.customer_wise_due_collection',compact('datas','collection_ledgers','account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','permited_budgets','permited_organizations','data','sales_man'));
        
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
        $_sales_man_id   = $request->_sales_man_id ?? 0;
        $_grand_collection_amount = $request->_grand_collection_amount ?? 0;
        $__table         = $request->_form_name ?? 'receive_payments';
        $_date           = change_date_format($request->_date);
        $_order_number   = make_order_number($__table,$organization_id,$_branch_id,$_date);

        $_is_confirm     = $request->_is_confirm ?? 0;
         
        //ReceivePayment
        //ReceivePaymentDetail

 DB::beginTransaction();
       try {
        $_print_value = $request->_print ?? 0;
         $users = Auth::user();
        $ReceivePayment                = new ReceivePayment();
        $ReceivePayment->_date         = change_date_format($request->_date);
        $ReceivePayment->_time         = date('H:i:s');

        $ReceivePayment->_order_number     = $_order_number;
        $ReceivePayment->_transection_ref  = $request->_referance ?? '';
        $ReceivePayment->_ledger_id        = $request->_main_ledger_id;
        
        $ReceivePayment->_created_by       = $users->id."-".$users->name;
        $ReceivePayment->_user_id          = $users->id;
        $ReceivePayment->_user_name        = $users->name;
        $ReceivePayment->_note             = $request->_note;
        $ReceivePayment->_sales_man_id        = $_sales_man_id;

        $ReceivePayment->_amount           = $_grand_collection_amount;
        // $ReceivePayment->_total_discount   = $__total_discount;
        // $ReceivePayment->_total_vat        = $__total_vat;
        // $ReceivePayment->_total            =  $__total;

        $ReceivePayment->_voucher_type        = $request->_voucher_type ?? 'JV';
        $ReceivePayment->_branch_id        = $request->_branch_id;
        $ReceivePayment->organization_id   = $organization_id;
        $ReceivePayment->_cost_center_id   = $request->_cost_center_id;
        $ReceivePayment->_address          = $request->_address;
        $ReceivePayment->_phone            = $request->_phone;
        $ReceivePayment->_status           = 1;
        $ReceivePayment->_lock             = $request->_lock ?? 0;
        $ReceivePayment->_is_confirm             = $request->_is_confirm ?? 0;
        $ReceivePayment->save();
        $purchase_id = $ReceivePayment->id;
        $master_id = $ReceivePayment->id;

        $_pfix               = $ReceivePayment->_order_number ?? '';
        $_code               = $ReceivePayment->_order_number ?? '';


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

       // if($_collection_amount > 0){
            $ReceivePaymentDetail                      = new ReceivePaymentDetail();
           $ReceivePaymentDetail->_no                  = $purchase_id;
           $ReceivePaymentDetail->_voucher_code        = $_pfix;
           $ReceivePaymentDetail->_invoice_id          = $_invoice_id;
           $ReceivePaymentDetail->_invoice_number      = $_invoice_number;
           $ReceivePaymentDetail->_total               = $_total;
           $ReceivePaymentDetail->_receive_amount      = $_receive_amount;
           $ReceivePaymentDetail->_due_amount          = $_due_amount;
           $ReceivePaymentDetail->_collection_amount   = $_collection_amount;
           $ReceivePaymentDetail->_due_balance         = $_due_balance;
           $ReceivePaymentDetail->_type                = $_type ?? 'receive';
           $ReceivePaymentDetail->_sales_man_id        = $_sales_man_id;
           $ReceivePaymentDetail->_collection_ledger_id= $_collection_ledger_id;
           $ReceivePaymentDetail->_short_narr          = $_short_narr ?? '';
           $ReceivePaymentDetail->_status              = $_status ?? 1;
           $ReceivePaymentDetail->_is_close            = $_is_close ?? 1;
           $ReceivePaymentDetail->_is_effect            = $_is_effect ?? 1;
           $ReceivePaymentDetail->_created_by          = $_created_by ?? 1;
           $ReceivePaymentDetail->created_at           = date('d-m-Y H:i:s');
           $ReceivePaymentDetail->save();
           $master_detail_id = $ReceivePaymentDetail->id;
           if($_collection_amount > 0  && $_is_effect==1){
            $collection_ledgers_groups[$_collection_ledger_id][]=$_collection_amount ?? 0;
           }
           $_transection_ref[]                              = $_invoice_number ?? '';
   // }

   // if($_is_confirm ==1){
     // Update Sales Invoice Number
       $Sales                   = Sales::find($_invoice_id);
       $old_receive_amount      = $Sales->_receive_amount ?? 0;
       $old_due_amount          = $Sales->_due_amount ?? 0;
       $new_receive_amount      = ($old_receive_amount + $_collection_amount);
       $new_due_amount          = ($_total -($new_receive_amount));
       $Sales->_receive_amount  = $new_receive_amount;
       $Sales->_due_amount      = $new_due_amount;
       $Sales->_is_close        = $_is_close ?? 0;
       $Sales->save();
 //   }

      

    }
       
//return $collection_ledgers_groups;

$array_of_dr_amount = 0;

if($_is_confirm ==1){

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
            $Accounts->_dr_amount           = $_cr_amount ?? 0;
            $Accounts->_cr_amount           =  0;
            $Accounts->_foreign_amount      = $_foreign_amounts[$i] ?? 0;
            $Accounts->organization_id      = $organization_id;
            $Accounts->_branch_id           = $_branch_id;
            $Accounts->_cost_center         = $_cost_center_id ?? 0;
            $Accounts->_budget_id           = $_budget_id ?? 0;
            $Accounts->_name                = $users->name;
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
            $Accounts->_dr_amount           =  0;
            $Accounts->_cr_amount           =  $array_of_dr_amount ?? 0;
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

} // End of Is Confirm

         DB::commit();
         $success_message ="Information Save successfully.";
        return redirect()->back()
                    ->with('success',$success_message);
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back()->with('danger','There is Something Wrong !');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReceivePayment  $ReceivePayment
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        //
        $users = Auth::user();
        $page_name = $this->page_name;
        $data = ReceivePayment::with(['_sup_cus','_organization','_master_branch','_master_details','_voucher_emp_ref'])->where('_status',1)->find($id);


         return view('backend.customer_payment.show',compact('page_name','data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReceivePayment  $ReceivePayment
     * @return \Illuminate\Http\Response
     */
    public function customer_payment_receipt( $id)
    {
        //
        $users = Auth::user();
        $page_name = $this->page_name;
        $data = ReceivePayment::with(['_sup_cus','_organization','_master_branch','_master_details','_voucher_emp_ref'])->where('_status',1)->find($id);

        $datas = [];
        $_master_details = $data->_master_details ?? [];
        foreach($_master_details as $_mas){
            $datas[$_mas->_receive_ledger->_name][]=$_mas->_collection_amount ?? 0;
        }
        //return $datas;

         return view('backend.customer_payment.customer_payment_receipt',compact('page_name','data','datas'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReceivePayment  $ReceivePayment
     * @return \Illuminate\Http\Response
     */
    public function customer_payment_print( $id)
    {
        //
        $users = Auth::user();
        $page_name = $this->page_name;
        $data = ReceivePayment::with(['_sup_cus','_organization','_master_branch','_master_details','_voucher_emp_ref'])->where('_status',1)->find($id);


         return view('backend.customer_payment.payment_receipt',compact('page_name','data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReceivePayment  $ReceivePayment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = ReceivePayment::with(['_sup_cus','_organization','_master_branch','_master_details','_voucher_emp_ref'])->where('_status',1)->find($id);
        $_master_details = $data->_master_details ?? [];

        $auth_user = Auth::user();
        $page_name = $this->page_name;
        $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
        $account_groups = AccountGroup::select('id','_name')->orderBy('_name','asc')->get();
        $branchs = Branch::orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$auth_user->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$auth_user->cost_center_ids));
        $voucher_types = VoucherType::select('id','_name','_code')->orderBy('_code','asc')->get();
        $permited_budgets = permited_budgets(explode(',',$auth_user->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$auth_user->organization_ids));



        $_ledger_id = $data->_ledger_id ?? '';
        $_form_name = $data->_form_name ?? '';
        $_master_id = $data->id ?? '';
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



       return view('backend.customer_payment.edit',compact('account_types','page_name','account_groups','branchs','permited_branch','permited_costcenters','voucher_types','permited_budgets','permited_organizations','data','_master_details','collection_ledgers','auth_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReceivePayment  $ReceivePayment
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
        $__table         = $request->_form_name ?? 'receive_payments';
        $_date           = change_date_format($request->_date);
        $_order_number   = $request->_transection_number ?? '';
        $_master_id      = $request->_master_id ?? 0;
        $_is_confirm     = $request->_is_confirm ?? 0;

        $details = ReceivePaymentDetail::where('_no',$_master_id)->where('_status',1)->get();
        foreach($details as $detail){
        $_invoice_id  =  $detail->_invoice_id;
        //Update Sales Invoice Number
           $Sales                    = Sales::find($_invoice_id);
           $old_receive_amount          = $Sales->_receive_amount ?? 0;
           $old_due_amount              = $Sales->_due_amount ?? 0;
           
           $_total                      = $detail->_total ?? 0;
           $_collection_amount          = $detail->_collection_amount ?? 0;

           $new_receive_amount          = ($old_receive_amount - $_collection_amount);
           $new_due_amount              = ($old_due_amount +($_collection_amount));

           $Sales->_receive_amount      =  (($Sales->_receive_amount ?? 0)-($detail->_collection_amount ?? 0));
           $Sales->_due_amount          = ($Sales->_total ?? 0)- (($Sales->_receive_amount ?? 0)-($detail->_collection_amount ?? 0));
           if($new_due_amount ==0){
            $Sales->_is_close        = 1;
           }else{
            $Sales->_is_close        = 0;
           }
           $Sales->save();

           //return $Sales;
    }

    ReceivePaymentDetail::where('_no',$_master_id)->update(['_status'=>0]);
    Accounts::where('_ref_master_id',$_master_id)
                        ->where('_table_name','receive_payments')
                        ->update(['_status'=>0]);


        DB::beginTransaction();
       try {




        //ReceivePayment
        //ReceivePaymentDetail


        $_print_value = $request->_print ?? 0;
         $users = Auth::user();
        $ReceivePayment                = ReceivePayment::find($_master_id);
        $ReceivePayment->_date         = change_date_format($request->_date);
        $ReceivePayment->_time         = date('H:i:s');

        $ReceivePayment->_order_number     = $_order_number;
        $ReceivePayment->_transection_ref  = $request->_referance ?? '';
        $ReceivePayment->_ledger_id        = $request->_main_ledger_id;
        
        $ReceivePayment->_created_by       = $users->id."-".$users->name;
       // $ReceivePayment->_user_id          = $users->id;
       // $ReceivePayment->_user_name        = $users->name;
        $ReceivePayment->_note             = $request->_note;
        $ReceivePayment->_sales_man_id     = $_sales_man_id;

        $ReceivePayment->_amount           = $_grand_collection_amount;
        // $ReceivePayment->_total_discount   = $__total_discount;
        // $ReceivePayment->_total_vat        = $__total_vat;
        // $ReceivePayment->_total            =  $__total;

        $ReceivePayment->_voucher_type        = $request->_voucher_type ?? 'JV';
        $ReceivePayment->_branch_id        = $request->_branch_id;
        $ReceivePayment->organization_id   = $organization_id;
        $ReceivePayment->_cost_center_id   = $request->_cost_center_id;
        $ReceivePayment->_address          = $request->_address;
        $ReceivePayment->_phone            = $request->_phone;
        $ReceivePayment->_status           = 1;
        $ReceivePayment->_lock             = $request->_lock ?? 0;
        $ReceivePayment->_is_confirm             = $request->_is_confirm ?? 0;
        $ReceivePayment->save();
        $purchase_id                       = $ReceivePayment->id;
        $master_id                         = $ReceivePayment->id;

        $_pfix               = $ReceivePayment->_order_number ?? '';
        $_code               = $ReceivePayment->_order_number ?? '';


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

    //    if($_collection_amount > 0){
            $ReceivePaymentDetail                      = new ReceivePaymentDetail();
           $ReceivePaymentDetail->_no                  = $purchase_id;
           $ReceivePaymentDetail->_voucher_code        = $_pfix;
           $ReceivePaymentDetail->_invoice_id          = $_invoice_id;
           $ReceivePaymentDetail->_invoice_number      = $_invoice_number;
           $ReceivePaymentDetail->_total               = $_total;
           $ReceivePaymentDetail->_receive_amount      = $_receive_amount;
           $ReceivePaymentDetail->_due_amount          = $_due_amount;
           $ReceivePaymentDetail->_collection_amount   = $_collection_amount;
           $ReceivePaymentDetail->_due_balance         = $_due_balance;
           $ReceivePaymentDetail->_type                = $_type ?? 'receive';
           $ReceivePaymentDetail->_sales_man_id        = $_sales_man_id;
           $ReceivePaymentDetail->_collection_ledger_id= $_collection_ledger_id;
           $ReceivePaymentDetail->_short_narr          = $_short_narr ?? '';
           $ReceivePaymentDetail->_status              = $_status ?? 1;
           $ReceivePaymentDetail->_is_close            = $_is_close ?? 1;
           $ReceivePaymentDetail->_is_effect            = $_is_effect ?? 1;
           $ReceivePaymentDetail->_created_by          = $_created_by ?? 1;
           $ReceivePaymentDetail->created_at           = date('d-m-Y H:i:s');
           $ReceivePaymentDetail->save();
           $master_detail_id = $ReceivePaymentDetail->id;
           if($_collection_amount > 0 && $_is_effect=1){
            $collection_ledgers_groups[$_collection_ledger_id][]=$_collection_amount ?? 0;
           }

           
           $_transection_ref[]                              = $_invoice_number ?? '';


           
     //   }

        //Update Sales Invoice Number
       $Sales                   = Sales::find($_invoice_id);
       $old_receive_amount      = $Sales->_receive_amount ?? 0;
       $old_due_amount          = $Sales->_due_amount ?? 0;
       $new_receive_amount      = ($old_receive_amount + $_collection_amount);
       $new_due_amount          = ($_total -($new_receive_amount));
       $Sales->_receive_amount  = $new_receive_amount;
       $Sales->_due_amount      = $new_due_amount;
       $Sales->_is_close        = $_is_close ?? 0;
       $Sales->save();







    }
       
//return $collection_ledgers_groups;

$array_of_dr_amount = 0;


if($_is_confirm ==1){

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
            $Accounts->_dr_amount           = $_cr_amount ?? 0;
            $Accounts->_cr_amount           =   0;
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
            $Accounts->_dr_amount           =  0;
            $Accounts->_cr_amount           = $array_of_dr_amount ??  0;
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

} // End of Is Confirm            
         DB::commit();
         $success_message ="Information Save successfully.";
        return redirect()->back()
                    ->with('success',$success_message);
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back()->with('danger','There is Something Wrong !');
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReceivePayment  $ReceivePayment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
            $users = Auth::user();
            ReceivePayment::where('id',$id)
                    ->update(['_status'=>0,'_is_delete'=>1,'_updated_by'=>$users->id."-".$users->name]);
            $details = ReceivePaymentDetail::where('_no',$id)->where('_status',1)->get();

                foreach($details as $detail){
                    $_invoice_id  =  $detail->_invoice_id;
                    //Update Sales Invoice Number
                       $Sales                   = Sales::find($_invoice_id);
                       $old_receive_amount      = $Sales->_receive_amount ?? 0;
                       $old_due_amount          = $Sales->_due_amount ?? 0;
                       $_total                  = $detail->_total ?? 0;
                       $_collection_amount      = $detail->_collection_amount ?? 0;

                       $new_receive_amount      = ($old_receive_amount - $_collection_amount);
                       $new_due_amount          = ($_total -($new_receive_amount));
                       $Sales->_receive_amount  = $new_receive_amount;
                       $Sales->_due_amount      = $new_due_amount;
                       $Sales->_is_close        = 0;
                       $Sales->save();
                }

            ReceivePaymentDetail::where('_no',$id)->update(['_status'=>0]);
            Accounts::where('_ref_master_id',$id)->where('_table_name','receive_payments')->update(['_status'=>0]);

        $success_message ="Information Deleted successfully.";
        return redirect()->back()
                    ->with('success',$success_message);

 
    }
}
