<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RestaurantCategorySetting;
use App\Models\User;
use App\Models\Branch;
use App\Models\ItemCategory;
use DB;
use Auth;


class RestaurantCategorySettingController extends Controller
{

           function __construct()
    {
         $this->middleware('permission:category-allocation-list|category-allocation-create|category-allocation-edit|category-allocation-delete|category-allocation-print', ['only' => ['index','store']]);
         $this->middleware('permission:category-allocation-print', ['only' => ['category-allocationPrint']]);
         $this->middleware('permission:category-allocation-create', ['only' => ['create','store']]);
         $this->middleware('permission:category-allocation-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:category-allocation-delete', ['only' => ['destroy']]);
         $this->page_name = "Restaurant Sales Cateogry";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 public function index(Request $request)
    {

       
        $users = Auth::user();
        $limit = $request->limit ?? 10;
        $datas = RestaurantCategorySetting::where('_branch_ids','!=','');
        if($request->has('_branch_ids') && $request->_branch_ids !=''){
            $datas = $datas->where('_branch_ids','like',"%$request->_branch_ids%");
        }

         $datas = $datas->orderBy('id','desc')->paginate($limit);
         $page_name = $this->page_name;
         $branchs = Branch::orderBy('_name','asc')->get();
         
        
        return view('backend.category-allocation.index',compact('datas','page_name','branchs','request'));
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
         $branchs = permited_branch(explode(',',$users->branch_ids));
          $categories = ItemCategory::with(['_parents'])->orderBy('_name','ASC')->get();

         return view('backend.category-allocation.create',compact('page_name','branchs','categories'));
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
         $request->validate([
                '_category_ids' => 'required',
                '_branch_ids' => 'required',
        ]);

        $data = new RestaurantCategorySetting();
        $__category_ids_ids = 0;
        $_category_ids = $request->_category_ids ?? [];
        if(sizeof($_category_ids) > 0 ){
            $__category_ids_ids  =  implode(",",$_category_ids);
        }

        $data->_category_ids  = $__category_ids_ids ?? 0;
        $data->_branch_ids = $request->_branch_ids ?? '';
        $data->save();
        //return $data;

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
        $page_name = $this->page_name;
        $data = RestaurantCategorySetting::with(['_branch'])->find($id);
        return view('backend.category-allocation.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = $this->page_name;
         $data = RestaurantCategorySetting::find($id);
         $users = Auth::user();
         $branchs = permited_branch(explode(',',$users->branch_ids));
         $categories = ItemCategory::with(['_parents'])->orderBy('_name','ASC')->get();
        

        return view('backend.category-allocation.edit',compact('data','page_name','branchs','categories'));
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
         $request->validate([
                '_category_ids' => 'required',
                '_branch_ids' => 'required',
        ]);

         $data = RestaurantCategorySetting::find($id);
         $_cash_ledger_ids = 0;
        $_category_ids = $request->_category_ids ?? [];
        if(sizeof($_category_ids) > 0){
            $__category_ids_ids  =  implode(",",$_category_ids);
        }

        $data->_category_ids       = $__category_ids_ids ?? 0;
        $data->_branch_ids = $request->_branch_ids ?? '';
        $data->save();

        return redirect()->back()->with('success','Information Save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RestaurantCategorySetting::find($id)->delete();
        return redirect()->route('category-allocation.index')
                        ->with('success','Information deleted successfully');
    }
}
