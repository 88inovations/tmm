<?php

namespace App\Http\Controllers;

use App\Models\ItemBonusSetup;
use App\Models\BonusItemDetail;
use App\Models\Units;
use App\Models\ItemCategory;
use App\Models\account_types;
use App\Models\AccountHead;
use App\Models\StoreHouse;
use Illuminate\Http\Request;
use Auth;
use DB;
use Session;

class ItemBonusSetupController extends Controller
{
     function __construct()
    {
         $this->middleware('permission:item_bonus_setups-list|item_bonus_setups-create|item_bonus_setups-edit|item_bonus_setups-delete|item_bonus_setups-print', ['only' => ['index','store']]);
         $this->middleware('permission:item_bonus_setups-print', ['only' => ['item_bonus_setupsPrint']]);
         $this->middleware('permission:item_bonus_setups-create', ['only' => ['create','store']]);
         $this->middleware('permission:item_bonus_setups-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:item_bonus_setups-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.item_bonus_setups');
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
        $users = $auth_user;
       if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_pur_limit', $request->limit);
        }else{
             $limit= \Session::get('_pur_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';

        $datas = ItemBonusSetup::with(['_items','_item_detail','_organization','_master_cost_center','_master_branch','_trans_unit']);
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
        
        if($request->has('organization_id') && $request->organization_id !=''){
            $datas = $datas->where('organization_id',$request->organization_id);
        }else{
            $datas = $datas->whereIn('organization_id',explode(',',$users->organization_ids));
        }

        if($request->has('_branch_id') && $request->_branch_id !=''){
            
            $datas = $datas->where('_branch_id',$request->_branch_id);
        }else{
            $datas = $datas->whereIn('_branch_id',explode(',',$users->branch_ids));
        }

        if($request->has('_cost_center_id') && $request->_cost_center_id !=''){
            $datas = $datas->where('_cost_center_id',$request->_cost_center_id);
        }else{
            $datas = $datas->whereIn('_cost_center_id',explode(',',$users->cost_center_ids));
        }

        
        if($request->has('_main_item_id') && $request->_main_item_id !=''){
            $datas = $datas->where('_item_id',$request->_main_item_id);
        }

       
       
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)
                        ->paginate($limit);

         $page_name = $this->page_name;
         $account_types = [];
         $account_groups = [];
        $current_date = date('Y-m-d');
          $current_time = date('H:i:s');
          
       
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));
        

        return view('backend.item_bonus_setups.index',compact('datas','page_name','account_types','request','account_groups','current_date','limit','permited_branch','permited_costcenters','permited_organizations','permited_budgets'));
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
        $account_groups = [];
        $units = Units::orderBy('_name','asc')->get();
         $categories = ItemCategory::orderBy('_name','asc')->get();
          $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));
        $store_houses = permited_stores(explode(',',$users->store_ids));

        return view('backend.item_bonus_setups.create',compact('page_name','units','account_groups','categories','account_types','permited_branch','permited_costcenters','store_houses','permited_organizations','permited_budgets'));
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
        $this->validate($request, [
            '_date' => 'required',
            'organization_id' => 'required',
            '_branch_id' => 'required',
            '_cost_center_id' => 'required',
            '_main_item_id' => 'required',
            '_main_transection_unit' => 'required',
            '_main_unit_conversion' => 'required',
            '_main_qty_slot_min' => 'required',
            '_main_qty_slot_max' => 'required',
            '_start_time' => 'required',
            '_end_time' => 'required',
            '_main_status' => 'required',
        ]);

        $organization_id = $request->organization_id;
        $_branch_id = $request->_branch_id;
        $_cost_center_id = $request->_cost_center_id;
        $_budget_id = $request->_budget_id;
        DB::beginTransaction();
        try {
          $users = Auth::user();
        $id = $request->id ?? '';
        $ItemBonusSetup = ItemBonusSetup::find($id);
        if(empty($ItemBonusSetup)){
            $ItemBonusSetup = new ItemBonusSetup();
        }else{
            BonusItemDetail::where('_no',$id)->update(['_status'=>0]);
        }
         

         $ItemBonusSetup->_date = change_date_format($request->_date);
         $ItemBonusSetup->_start_time = change_date_format($request->_start_time);
         $ItemBonusSetup->_end_time = change_date_format($request->_end_time);
         $ItemBonusSetup->_item_id = $request->_main_item_id;
         $ItemBonusSetup->organization_id = $organization_id;
         $ItemBonusSetup->_branch_id = $_branch_id;
         $ItemBonusSetup->_cost_center_id = $_cost_center_id;
         $ItemBonusSetup->_budget_id = $_budget_id;
         $ItemBonusSetup->_item_id = $request->_main_item_id;
         $ItemBonusSetup->_transection_unit = $request->_main_transection_unit;
         $ItemBonusSetup->_base_unit = $request->_main_base_unit;
         $ItemBonusSetup->_unit_conversion = $request->_main_unit_conversion;
         $ItemBonusSetup->_qty_slot_min = $request->_main_qty_slot_min;
         $ItemBonusSetup->_qty_slot_max = $request->_main_qty_slot_max;
         $ItemBonusSetup->_is_close = $request->_is_close ?? 0;
         $ItemBonusSetup->_allow_all_branch = $request->_allow_all_branch ?? 1;
        $ItemBonusSetup->_status = 1;
         $ItemBonusSetup->_created_by =$users->id ?? '';
         $ItemBonusSetup->save();


         $master_id = $ItemBonusSetup->id;

         $inputs_ids = $request->inputs_id ?? [];
         $_item_ids = $request->_item_id ?? [];
         $_transection_units = $request->_transection_unit ?? [];
         $conversion_qtys = $request->conversion_qty ?? [];
         $_base_unit_ids = $request->_base_unit_id ?? [];
         $_qtys = $request->_qty ?? [];
         $_statuss = $request->_status ?? [];

         if(sizeof($_item_ids) > 0){
            for ($i = 0; $i <sizeof($_item_ids) ; $i++) {
                $row_id = $inputs_ids[$i] ?? 0;

                $BonusItemDetail = BonusItemDetail::find($row_id);
                if(empty($BonusItemDetail)){
                    $BonusItemDetail = new BonusItemDetail();
                }
                $BonusItemDetail->organization_id = $organization_id;
                $BonusItemDetail->_branch_id = $_branch_id;
                $BonusItemDetail->_cost_center_id = $_cost_center_id;
                $BonusItemDetail->_budget_id = $_budget_id;
                $BonusItemDetail->_no = $master_id;
                $BonusItemDetail->_item_id = $_item_ids[$i];

                $BonusItemDetail->_base_unit = $_base_unit_ids[$i];
                $BonusItemDetail->_transection_unit = $_transection_units[$i];
                $BonusItemDetail->_unit_conversion = $conversion_qtys[$i] ?? 0;
                $BonusItemDetail->_qty = $_qtys[$i] ?? 0;
                $BonusItemDetail->_status = $_statuss[$i] ?? 1;
                $BonusItemDetail->save();

            }

         }

        BonusItemDetail::where('_no',$id)->where('_status',0)->delete();
         

           DB::commit();
          return redirect()->back()->with('success','Information save successfully');
       } catch (\Exception $e) {
           DB::rollback();
           return redirect()->back()->with('danger','There is Something Wrong !');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemBonusSetup  $itemBonusSetup
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ItemBonusSetup::with(['_items','_item_detail','_organization','_master_cost_center','_master_branch','_trans_unit'])->find($id);
        $users = Auth::user();
        $page_name = $this->page_name;
        $account_groups = [];
        $units = Units::orderBy('_name','asc')->get();
         $categories = ItemCategory::orderBy('_name','asc')->get();
          $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));
        $store_houses = permited_stores(explode(',',$users->store_ids));

        return view('backend.item_bonus_setups.show_1',compact('page_name','units','account_groups','categories','account_types','permited_branch','permited_costcenters','store_houses','permited_organizations','permited_budgets','data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemBonusSetup  $itemBonusSetup
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
       $data = ItemBonusSetup::with(['_items','_item_detail','_organization','_master_cost_center','_master_branch','_trans_unit'])->find($id);
        $users = Auth::user();
        $page_name = $this->page_name;
        $account_groups = [];
        $units = Units::orderBy('_name','asc')->get();
         $categories = ItemCategory::orderBy('_name','asc')->get();
          $account_types = AccountHead::select('id','_name')->orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));
        $store_houses = permited_stores(explode(',',$users->store_ids));

        return view('backend.item_bonus_setups.edit',compact('page_name','units','account_groups','categories','account_types','permited_branch','permited_costcenters','store_houses','permited_organizations','permited_budgets','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemBonusSetup  $itemBonusSetup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemBonusSetup $itemBonusSetup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemBonusSetup  $itemBonusSetup
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemBonusSetup $itemBonusSetup)
    {
        //
    }
}
