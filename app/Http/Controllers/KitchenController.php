<?php

namespace App\Http\Controllers;

use App\Models\Kitchen;
use App\Models\KitchenFinishGoods;
use App\Models\KitchenRowGoods;
use App\Models\ProductPriceList;
use App\Models\ResturantSalesAccount;
use App\Models\ResturantDetails;
use App\Models\ResturantSales;
use App\Models\ItemInventory;
use Illuminate\Http\Request;
use Auth;
use DB;
use Session;




class KitchenController extends Controller
{

        function __construct()
    {
         $this->middleware('permission:kitchen-list|kitchen-create|kitchen-edit|kitchen-delete|kitchen-print', ['only' => ['index','store']]);
         $this->middleware('permission:kitchen-print', ['only' => ['kitchenPrint']]);
         $this->middleware('permission:kitchen-create', ['only' => ['create','store']]);
         $this->middleware('permission:kitchen-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:kitchen-delete', ['only' => ['destroy']]);
         $this->page_name = "Kitchen Panel";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Kitchen::with(['_finish_goods','_row_goods','_sales_ref'])->where('_status',0)->orderBy('id','ASC')->get();
        $page_name = $this->page_name;

        return view('backend.kitchen.index',compact('datas','page_name'));
    }


    public function check_available_ingredients(Request $request){
        $_kitchen_id = $request->_kitchen_id ?? 0;
       // return $_kitchen_id;

        $datas = \DB::select( " SELECT t1._item_id,t3._item AS _item,SUM((1/t1._conversion_qty)*t1._qty) as _require_qty,SUM(IFNULL(t2._qty,0)) AS _available_qty ,AVG(t1._rate) AS _rate,SUM(t1._value) AS _value 
                FROM kitchen_row_goods as t1
                INNER JOIN inventories AS t3 ON t3.id=t1._item_id
                LEFT JOIN product_price_lists AS t2 ON t1._item_id=t2._item_id
                WHERE t1._no=$_kitchen_id AND t1._status=1
                GROUP BY t1._item_id " );

        return view("backend.kitchen.available_ingredients",compact('datas'));

    }

    public function coocked_confirm_check(Request $request){

        $_kitchen_id = $request->_kitchen_id ?? 0;
        $kitchen_finish_goods = \DB::select( " SELECT t1._item_id,t3._item AS _item,SUM(t1._qty) as _qty,AVG(t1._rate) AS _rate,SUM(t1._value) AS _value
                FROM kitchen_finish_goods as t1
                INNER JOIN inventories AS t3 ON t3.id=t1._item_id
                WHERE t1._no=$_kitchen_id AND t1._status=1
                GROUP BY t1._item_id " );

        $kitchen_row_goods =  \DB::select( " SELECT t1.id, t1._item_id,t3._item AS _item,(t1._qty*t1._conversion_qty) as _require_qty,0 AS _available_qty ,t1._rate,t1._value ,t4._name as _unit_name
                FROM kitchen_row_goods as t1
                INNER JOIN inventories AS t3 ON t3.id=t1._item_id
                INNER JOIN units as t4 ON t4.id=t3._unit_id
                WHERE t1._no=$_kitchen_id AND t1._status=1 " );

        $available_row_goods =  \DB::select( " SELECT t1._item_id,SUM(IFNULL(t2._qty,0)) AS _available_qty 
                FROM kitchen_row_goods as t1
                LEFT JOIN product_price_lists AS t2 ON t1._item_id=t2._item_id
                WHERE t1._no=$_kitchen_id AND t2._status=1
                GROUP BY t1._item_id " );
        foreach ($kitchen_row_goods as $key=> $value) {
                foreach ($available_row_goods as $row_good) {
                    if($value->_item_id ===$row_good->_item_id){
                        $value->_available_qty=$row_good->_available_qty ?? 0;
                    }
                }
        }



        return view("backend.kitchen.coocked_confirm_check",compact('kitchen_row_goods','kitchen_finish_goods'));
    }

    public function coockedServedConfirm(Request $request){

        DB::beginTransaction();
        try {


        $users = Auth::user();
        //return $request->all();
        $_kitchen_id = $request->_kitchen_id ?? 0;
        $_sales_id = $request->_sales_id ?? 0;

        $ids = $request->id ?? [];
        $_item_ids = $request->_item_id ?? [];
        $_search_item_ids = $request->_search_item_id ?? [];
        $_items = $request->_item ?? [];
        $_rates = $request->_rate ?? [];
        $_qtys = $request->_qty ?? [];
        $_available_qtys = $request->_available_qty ?? [];

        KitchenRowGoods::where('_no',$_kitchen_id)->update(['_status'=>0]);

        if(sizeof($ids) > 0){
            for ($i = 0; $i <sizeof($ids); $i++) {
                if($ids[$i] ==0){
                    $KitchenRowGoods = new KitchenRowGoods();
                    $KitchenRowGoods->_qty =$_qtys[$i] ?? 0;
                    $KitchenRowGoods->_rate =$_rates[$i] ?? 0;
                    $KitchenRowGoods->_value = (($_rates[$i] ?? 0)*($_qtys[$i] ?? 0));
                }else{
                     $KitchenRowGoods = KitchenRowGoods::find($ids[$i]);
                     $__conversion_qty = $KitchenRowGoods->_conversion_qty ?? 0;
                     $__qtys = (($_qtys[$i] ?? 0)* $__conversion_qty);

                    $KitchenRowGoods->_qty =$__qtys ?? 0;
                    $KitchenRowGoods->_rate =$_rates[$i] ?? 0;
                    $KitchenRowGoods->_value = (($_rates[$i] ?? 0)*($_qtys[$i] ?? 0));

                }

                $KitchenRowGoods->_item_id =$_item_ids[$i] ?? 0;
                
                $KitchenRowGoods->_status = 1;
                $KitchenRowGoods->save();
            }
        }



        $kitchen_row_goods = \DB::select( " SELECT t1.id,t1._item_id,t3._item,t3._unit_id,t1._p_p_l_id,((1/t1._conversion_qty)*(t1._qty)) as _qty,t1._rate,t1._sales_rate,t1._discount,t1._discount_amount,t1._vat,t1._vat_amount,t1._value,t1._warranty,t1._barcode,t1._no,t1._branch_id,t1._store_id,t1._cost_center_id,t1._store_salves_id,t1._status 
                FROM kitchen_row_goods as t1
                INNER JOIN inventories AS t3 ON t3.id=t1._item_id
                WHERE t1._no=$_kitchen_id AND t1._status=1 order by t1.id ASC " );
    //return $kitchen_row_goods;

        foreach ($kitchen_row_goods  as $key=> $value) {
            
                 $_required_qty =$value->_qty ?? 0;
                $avail_total_qtys = ProductPriceList::where('_item_id',$value->_item_id)->where('_qty','>',0)
                                                        ->where('_store_id',$value->_store_id ?? 1)
                                                        ->where('_branch_id',$value->_branch_id ?? 1)
                                                        ->where('_cost_center_id',$value->_cost_center_id ?? 1)
                                                        ->where('_status',1)
                                                        ->sum('_qty');

                

               
                if($avail_total_qtys >= $_required_qty ){
                 //if qty is available then search product price list table
                    
                       
                       $avail_item_qtys = ProductPriceList::where('_item_id',$value->_item_id)->where('_qty','>',0)
                                                            ->where('_store_id',$value->_store_id ?? 1)
                                                            ->where('_branch_id',$value->_branch_id ?? 1)
                                                            ->where('_cost_center_id',$value->_cost_center_id ?? 1)
                                                            ->where('_status',1)
                                                            ->first();

                    if($_required_qty <= $avail_item_qtys->_qty){
                        //First Row Found All Qty then we can go for deduct from ProductPriceList and Data Send To ItemInventory
                       // return "required qty ".$_required_qty;

                        $new_qty = ($avail_item_qtys->_qty-$_required_qty );
                        $_status = ($new_qty > 0) ? 1 : 0;

                        $avail_item_qtys->_qty = $new_qty;
                        $avail_item_qtys->_status =$_status;
                        $avail_item_qtys->save();

                        $KitchenRowGoods = KitchenRowGoods::find($value->id);
                        $KitchenRowGoods->_p_p_l_id = $avail_item_qtys->id;
                        $KitchenRowGoods->save();

                        $ItemInventory = new ItemInventory();
                        $ItemInventory->_item_id =  $value->_item_id ?? 0;
                        $ItemInventory->_item_name = $value->_item ?? 0;
                        $ItemInventory->_unit_id =  $value->_unit_id ?? 0;
                        $ItemInventory->_category_id = _item_category($value->_item_id ?? 0);
                        $ItemInventory->_date = change_date_format($request->_date ?? date('d-m-Y'));
                        $ItemInventory->_time = date('H:i:s');
                        $ItemInventory->_transection = "Kitchen";
                        $ItemInventory->_transection_ref = $_kitchen_id;
                        $ItemInventory->_transection_detail_ref_id = $value->id ?? 0;
                        $ItemInventory->_qty = -($value->_qty ?? 0);
                        $ItemInventory->_rate =$value->_sales_rate ?? 0;
                        $ItemInventory->_cost_rate = $value->_rate ?? 0;
                        $ItemInventory->_manufacture_date = $value->_manufacture_date ?? date('d-m-Y');
                        $ItemInventory->_expire_date = $value->_expire_date ?? date('d-m-Y');
                        $ItemInventory->_cost_value = (($value->_qty ?? 0)*($value->_rate ?? 0));
                        $ItemInventory->_value = $value->_value ?? 0;
                        $ItemInventory->_branch_id = $value->_branch_id ?? 1;
                        $ItemInventory->_store_id = $value->_store_id ?? 1;
                        $ItemInventory->_cost_center_id = $value->_cost_center_id ?? 1;
                        $ItemInventory->_store_salves_id = $_store_salves_ids[$i] ?? '';
                        $ItemInventory->_status = 1;
                        $ItemInventory->_created_by = $users->id."-".$users->name;
                        $ItemInventory->save(); 
                        inventory_stock_update($value->_item_id ?? 0);

                    }else{
                        //return "else condition ".$_required_qty;
                        $_avoid_price_list_ids =[];
                        $available_quantity =  0;
                        $_qty_less = $_required_qty;
                        do {
                           
                            if ($available_quantity < $_required_qty) {
                                 $price_info_two = ProductPriceList::where('_item_id', $value->_item_id)->where('_qty','>',0)
                                                            ->where('_store_id',$value->_store_id ?? 1)
                                                            ->where('_branch_id',$value->_branch_id ?? 1)
                                                            ->where('_cost_center_id',$value->_cost_center_id ?? 1)
                                                            ->where('_status',1)
                                                            ->whereNotIn('id', $_avoid_price_list_ids)
                                                            ->orderBy('id','asc')
                                                            ->first();
                                if($price_info_two){
                                      array_push($_avoid_price_list_ids, $price_info_two->id);

                                      $available_quantity +=$price_info_two->_qty ?? 0;

                                      if($available_quantity  >= $_required_qty  ){
                                        $_less_qty = ($price_info_two->_qty -( $available_quantity-$_required_qty )); //Last Need this qty
                                         $new_qty = ($price_info_two->_qty-$_less_qty );
                                        }else{
                                            $new_qty = 0;
                                        }

                                       
                                        $_status = ($new_qty > 0) ? 1 : 0;
                                        $price_info_two->_qty = $new_qty;
                                        $price_info_two->_status =$_status;
                                        $price_info_two->save();

                                        $KitchenRowGoods = KitchenRowGoods::find($value->id);
                                        $KitchenRowGoods->_p_p_l_id = $price_info_two->id;
                                        $KitchenRowGoods->save();

                                        $ItemInventory = new ItemInventory();
                                        $ItemInventory->_item_id =  $value->_item_id ?? 0;
                                        $ItemInventory->_item_name = $value->_item ?? 0;
                                        $ItemInventory->_unit_id =  $value->_unit_id ?? 0;
                                        $ItemInventory->_category_id = _item_category($value->_item_id ?? 0);
                                        $ItemInventory->_date = change_date_format($request->_date ?? date('d-m-Y'));
                                        $ItemInventory->_time = date('H:i:s');
                                        $ItemInventory->_transection = "Kitchen";
                                        $ItemInventory->_transection_ref = $_kitchen_id;
                                        $ItemInventory->_transection_detail_ref_id = $value->id ?? 0;
                                        $ItemInventory->_qty = -($value->_qty ?? 0);
                                        $ItemInventory->_rate =$value->_sales_rate ?? 0;
                                        $ItemInventory->_cost_rate = $value->_rate ?? 0;
                                        $ItemInventory->_manufacture_date = $value->_manufacture_date ?? date('d-m-Y');
                                        $ItemInventory->_expire_date = $value->_expire_date ?? date('d-m-Y');
                                        $ItemInventory->_cost_value = (($value->_qty ?? 0)*($value->_rate ?? 0));
                                        $ItemInventory->_value = $value->_value ?? 0;
                                        $ItemInventory->_branch_id = $value->_branch_id ?? 1;
                                        $ItemInventory->_store_id = $value->_store_id ?? 1;
                                        $ItemInventory->_cost_center_id = $value->_cost_center_id ?? 1;
                                        $ItemInventory->_store_salves_id = $_store_salves_ids[$i] ?? '';
                                        $ItemInventory->_status = 1;
                                        $ItemInventory->_created_by = $users->id."-".$users->name;
                                        $ItemInventory->save(); 
                                        inventory_stock_update($value->_item_id ?? 0);
                                }
                                                            
                            }
                        } while ($available_quantity < $_required_qty);

                    }
                }
                
            } //Row goods deduct from Stock means Product Price List Table 
        

        //return "no item found";

        //kitchen_finish_goods send to product price list table
        $kitchen_finish_goods = \DB::select( "SELECT t1.id,t1._item_id,t3._item,t3._unit_id,t1._p_p_l_id,t1._qty,t1._rate,t1._sales_rate,t1._discount,t1._discount_amount,t1._vat,t1._vat_amount,t1._value,t1._warranty,t1._barcode,t1._no,t1._branch_id,t1._store_id,t1._cost_center_id,t1._store_salves_id,t1._status,t1._coking,t1._kitchen_item
                FROM kitchen_finish_goods as t1
                INNER JOIN inventories AS t3 ON t3.id=t1._item_id
                WHERE t1._no=$_kitchen_id AND t1._status=1 order by t1.id ASC " );

        foreach ($kitchen_finish_goods as $value) {
            $ProductPriceList = new ProductPriceList();
            $ProductPriceList->_master_id = $_kitchen_id;
            $ProductPriceList->_purchase_detail_id = $value->id ?? 0;
            $ProductPriceList->_input_type = 'Kitchen';
            $ProductPriceList->_item_id  = $value->_item_id ?? 0;
            $ProductPriceList->_item  = $value->_item ?? 0;
            $ProductPriceList->_unit_id  = $value->_unit_id ?? 0;
            $ProductPriceList->_barcode  = $value->_barcode ?? '';
            $ProductPriceList->_manufacture_date  = $value->_manufacture_date ?? date('d-m-Y');
            $ProductPriceList->_expire_date  = $value->_expire_date ?? date('d-m-Y');
            $ProductPriceList->_qty  = 0; //QTY creation and sales that here qty will be ZERO
            $ProductPriceList->_sales_rate  = $value->_sales_rate ?? 0;
            $ProductPriceList->_pur_rate  = $value->_rate ?? 0;
            $ProductPriceList->_sales_discount  = $value->_discount ?? 0;
            $ProductPriceList->_sales_vat  = $value->_vat ?? 0;
            $ProductPriceList->_value  = $value->_value ?? 0;
            $ProductPriceList->_branch_id   = $value->_branch_id ?? 1;
            $ProductPriceList->_cost_center_id   = $value->_cost_center_id ?? 1;
            $ProductPriceList->_store_id   = $value->_store_id ?? 1;
            $ProductPriceList->_store_salves_id   = $value->_store_salves_id ?? 1;
            $ProductPriceList->_status   = 0; //QTY creation and sales that here Statu will be ZERO AND not for sale again
            $ProductPriceList->_created_by   = $users->name ?? '';
            $ProductPriceList->save();

            $_product_price_list_id = $ProductPriceList->id;
            KitchenFinishGoods::where('id',  $value->id)
                    ->update(['_p_p_l_id'=>$_product_price_list_id]);

           $ResturantDetails= ResturantDetails::where('_no', $_sales_id)
                        ->where('_item_id',$value->_item_id)
                        ->where('_store_id',$value->_store_id ?? 1)
                        ->where('_branch_id',$value->_branch_id ?? 1)->first();
            $ResturantDetails->_purchase_invoice_no= $_kitchen_id;
            $ResturantDetails->_purchase_detail_id= $value->id;
            $ResturantDetails->_p_p_l_id= $_product_price_list_id;
            $ResturantDetails->save();
            $resturant_details_id = $ResturantDetails->id;

                    


            for ($x = 0; $x < 2; $x++) {
                    //increase ItemInventory table with QTy
                 $ItemInventory = new ItemInventory();
                 $ItemInventory->_item_id =  $value->_item_id ?? 0;
                 $ItemInventory->_item_name = $value->_item ?? 0;
                $ItemInventory->_unit_id =  $value->_unit_id ?? 0;
                $ItemInventory->_category_id = _item_category($value->_item_id ?? 0);
                $ItemInventory->_date = change_date_format($request->_date ?? date('d-m-Y'));
                $ItemInventory->_time = date('H:i:s');
                if($x ==0){
                        $ItemInventory->_transection = "Kitchen";
                        $ItemInventory->_transection_ref = $_kitchen_id;
                        $ItemInventory->_transection_detail_ref_id = $value->id ?? 0;
                        $ItemInventory->_qty = $value->_qty ?? 0;
                }else{
                    $ItemInventory->_transection = "Restaurant Sales";
                    $ItemInventory->_transection_ref = $_sales_id;
                    $ItemInventory->_transection_detail_ref_id = $resturant_details_id ?? 0;
                    $ItemInventory->_qty = -($value->_qty ?? 0);
                }
               

                $ItemInventory->_rate =$value->_sales_rate ?? 0;
                $ItemInventory->_cost_rate = $value->_rate ?? 0;
                $ItemInventory->_manufacture_date = $value->_manufacture_date ?? date('d-m-Y');
                $ItemInventory->_expire_date = $value->_expire_date ?? date('d-m-Y');
                $ItemInventory->_cost_value = (($value->_qty ?? 0)*($value->_rate ?? 0));
                $ItemInventory->_value = $value->_value ?? 0;
                $ItemInventory->_branch_id = $value->_branch_id ?? 1;
                $ItemInventory->_store_id = $value->_store_id ?? 1;
                $ItemInventory->_cost_center_id = $value->_cost_center_id ?? 1;
                $ItemInventory->_store_salves_id = $_store_salves_ids[$i] ?? '';
                $ItemInventory->_status = 1;
                $ItemInventory->_created_by = $users->id."-".$users->name;
                $ItemInventory->save(); 
                inventory_stock_update($value->_item_id ?? 0);
            }

             
        }


        $ResturantSales = ResturantSales::find($_sales_id);
        $ResturantSales->_kitchen_status = 1;
        //$ResturantSales->_lock = 1;
        $ResturantSales->save();

        $Kitchen = Kitchen::find($_kitchen_id);
        $Kitchen->_status = 1;
        $Kitchen->save();

            DB::commit();
            return redirect('kitchen')
                ->with('success','Information save successfully');
       } catch (\Exception $e) {
           DB::rollback();
          return redirect('kitchen');
        }



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kitchen  $kitchen
     * @return \Illuminate\Http\Response
     */
    public function show(Kitchen $kitchen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kitchen  $kitchen
     * @return \Illuminate\Http\Response
     */
    public function edit(Kitchen $kitchen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kitchen  $kitchen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kitchen $kitchen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kitchen  $kitchen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kitchen $kitchen)
    {
        //
    }
}
