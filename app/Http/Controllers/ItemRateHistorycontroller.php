<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\ItemRateHistory;
use App\Models\ItemRateHistoryLog;
use App\Models\ItemCategory;

class ItemRateHistorycontroller extends Controller
{
     function __construct()
    {
         $this->middleware('permission:item_rate_history', ['only' => ['index','store']]);
         $this->page_name = "Item Rate Change";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


  //       $sqlConn = sqlConn();

  //         $query = "SELECT  [RateID]
  //     ,[MainHead]
  //     ,[ItemCode]
  //     ,[EffectDate]
  //     ,[Rate]
  //     ,[AddUser]
  //     ,[EditUser]
  //     ,[Active]
  // FROM [Inv_Meghna].[dbo].[tblItemRateHistory] ";
  //       $stmt = sqlsrv_query($sqlConn, $query);
  //       if ($stmt === false) {
  //           die(print_r(sqlsrv_errors(), true));
  //       }
  //       // Fetch data into an array
  //       $data = array();
  //       while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  //          // return $row;
  //           $_item_code = $row["ItemCode"];
  //           $item_id = \DB::table('inventories')->where('_code',$_item_code)->first()->id ?? 0;
  //           $Rate = $row["Rate"];
  //           $_effective_date =  $row["EffectDate"]->format('Y-m-d');

  //           $ItemRateHistory            = new ItemRateHistory();
  //           $ItemRateHistory->_item_id   = $item_id;
  //           $ItemRateHistory->_item_code   = $_item_code;
  //           $ItemRateHistory->_effective_date   = $_effective_date;
  //           $ItemRateHistory->_sales_rate   = $Rate;
  //           $ItemRateHistory->_comment   = '';
  //           $ItemRateHistory->_status   = 1;
  //           $ItemRateHistory->_is_update   = 1;
  //           $ItemRateHistory->_user_id   = 1;
  //           $ItemRateHistory->_created_by   = 1;
  //           $ItemRateHistory->save();
           

           
  //       }


        $page_name= $this->page_name;
        $items = Inventory::with(['_rate_change'])
                ->orderBy('_category_id','ASC')
                ->orderBy('_item','ASC')
                ->orderBy('id','DESC')->get();
        $datas = array();
        foreach($items as $item){
            $datas[$item->_category_id][]=$item;
        }
//return $datas ;
        $categories = ItemCategory::get();

        return view('backend.item_rate_history.index',compact('page_name','datas','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name="Item Rate";
        $items = Inventory::with(['_units'])->orderBy('_item','ASC')->get();
        return view('backend.item_rate_history.create',compact('page_name','items'));
    }

    public function itemWiseRateDetails(Request $request){
        $_item_id = $request->_item_id ?? '';
        $_rate_details = \DB::table('item_rate_histories')
                        ->where('_item_id',$_item_id)
                        ->orderBy('_effective_date','desc')
                        ->get();
        return view('backend.item_rate_history.item_wise_rate_details',compact('_rate_details'));
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

        $ids = $request->id ?? [];
        $effectice_dates = $request->_effective_date ?? [];
        $_sales_rates = $request->_sales_rate ?? [];
        $_pur_rates = $request->_pur_rate ?? [];
        $_comments = $request->_comment ?? [];
        $auth_user = \Auth::user();
        $today = date('Y-m-d');

        if(sizeof($ids) > 0){
            for ($i=0; $i <sizeof($ids) ; $i++) { 
               $item_info=  \App\Models\Inventory::where('id',$ids[$i])->first();

                $_effective_date = change_date_format($effectice_dates[$i] ?? date('Y-m-d'));

                $data = ItemRateHistory::where('_item_id',$ids[$i])
                                        ->whereDate('_effective_date',$effectice_dates[$i])
                                        ->where('_sales_rate',$_sales_rates[$i])
                                        ->first();
                if(empty($data)){
                    $data = new ItemRateHistory();
                    $data->_user_id = $auth_user->id;
                    $data->_created_by = $auth_user->id;
                }
                $data->_item_id =$ids[$i];
                $data->_item_code =$item_info->_code ?? '';
                $data->_effective_date =change_date_format($effectice_dates[$i] ?? date('Y-m-d'));
                $data->_sales_rate =$_sales_rates[$i] ?? 0;
                $data->_pur_rate =$_pur_rates[$i] ?? 0;
                $data->_comment =$_comments[$i] ?? '';
                $data->_status =1;

                if ($today >= $_effective_date) {
                   \App\Models\Inventory::where('id',$ids[$i])
                            ->update(['_sale_rate'=>$_sales_rates[$i] ?? 0,'_pur_rate'=>$_pur_rates[$i]]);
                        $data->_is_update =1;

                    $ItemRateHistoryLog = ItemRateHistoryLog::where('_item_id',$ids[$i])
                                                              ->where('_effective_date',$_effective_date)  
                                                              ->where('_sales_rate',$_sales_rates[$i] ?? 0)  
                                                              ->where('_comment',$_comments[$i] ?? 0)  
                                                              ->first();  
                    if(empty($ItemRateHistoryLog)){
                        $ItemRateHistoryLog              = new ItemRateHistoryLog();
                    }

                       
                       $ItemRateHistoryLog->_item_id    = $ids[$i];
                       $ItemRateHistoryLog->_effective_date    = $_effective_date;
                       $ItemRateHistoryLog->_sales_rate    = $_sales_rates[$i] ?? 0;
                       $ItemRateHistoryLog->_comment    = $_comments[$i] ?? '';
                       $ItemRateHistoryLog->_status    =1;
                       $ItemRateHistoryLog->_user_id    =$auth_user->id;
                       $ItemRateHistoryLog->_created_by    =$auth_user->id;
                       $ItemRateHistoryLog->save();

                }else{
                    $data->_is_update =0;
                }

                
                $data->_updated_by =$auth_user->id;
                $data->save();




            }
        }

        return redirect()->back()->with('success','Sales Price Will Update as Per Effective Data');

        


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    }
}
