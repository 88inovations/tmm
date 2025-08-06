<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{

      function __construct()
    {
         $this->middleware('permission:item-category-list|item-category-create|item-category-edit|item-category-delete', ['only' => ['index','store']]);
         $this->middleware('permission:item-category-create', ['only' => ['create','store']]);
         $this->middleware('permission:item-category-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:item-category-delete', ['only' => ['destroy']]);
         $this->page_name = "Item Category";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
    {
        
        $datas = ItemCategory::with(['_childs'])->withCount(['_cat_wise_item_count']);
        if($request->has('_name') && $request->_name !=''){
            $datas = $datas->where('_name','like',"%$request->_name%");
        }else{
            $datas = $datas->where('_parent_id',0);
        }
        if($request->has('_parent_id') && $request->_parent_id !=''){
            $datas = $datas->where('_parent_id','=',$request->_parent_id);
        }
         $limit = $datas->count();
         $datas = $datas->orderBy('id','ASC')->get();

        $page_name = $this->page_name;
         
        return view('backend.item-category.index',compact('datas','request','page_name','limit'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
         $parents_categories = ItemCategory::with(['_parents','_childs'])->where('_parent_id',0)->orderBy('_name','asc')->get();
        return view('backend.item-category.create',compact('page_name','parents_categories'));
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
                '_name' => 'required|max:255|unique:item_categories,_name',
                '_parent_id' => 'required',
        ]);

        $this->validate($request, [
            '_name' => 'required|unique:item_categories,_name,'.$request->id,
        ]);

         $data = new ItemCategory();
        $data->_name       = $request->_name ?? '';
        $data->_code       = $request->code ?? '';
        $data->dep_rate       = $request->dep_rate ?? '';
        $data->_description       = $request->_description ?? '';
        $data->asset_ledger_id       = $request->asset_ledger_id ?? 0;
        $data->asset_dep_ledger_id       = $request->asset_dep_ledger_id ?? 0;
        $data->asset_dep_exp_ledger_id       = $request->asset_dep_exp_ledger_id ?? 0;
        $data->_parent_id = $request->_parent_id ?? '';
        $data->_status = $request->_status ?? 1;


        if($request->hasFile('_image')){ 
                $_image = UserImageUpload($request->_image); 
                $data->_image = $_image;
        }
        $data->save();

        return redirect()->back()->with('success','Information Save successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemCategory  $itemCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_name = $this->page_name;
        $data = ItemCategory::with(['_parents','category_ledger','dep_exp_category_ledger','acc_dep_category_ledger'])->find($id);

           
        return view('backend.item-category.show',compact('data','page_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemCategory  $itemCategory
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
    {
        $page_name = $this->page_name;
       $data = ItemCategory::with(['_parents','category_ledger','dep_exp_category_ledger','acc_dep_category_ledger'])->find($id);
       if(empty($data)){
        return redirect()->route('item-category.index')->with('message','No Data Found');
       }
        $parents_categories = ItemCategory::with(['_parents','_childs'])->where('_parent_id',0)->orderBy('_name','asc')->get();
        return view('backend.item-category.edit',compact('data','page_name','parents_categories'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemCategory  $itemCategory
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request)
    {
        //return $request->all();
        $request->validate([
                '_name' => 'required|max:255|unique:item_categories,_name,'.$request->id,
                '_parent_id' => 'required',
            ]);

        
        $data = ItemCategory::find($request->id);
        $data->_name       = $request->_name ?? '';
        $data->_code       = $request->code ?? '';
        $data->dep_rate       = $request->dep_rate ?? '';
        $data->_description       = $request->_description ?? '';
        $data->asset_ledger_id       = $request->asset_ledger_id ?? 0;
        $data->asset_dep_ledger_id       = $request->asset_dep_ledger_id ?? 0;
        $data->asset_dep_exp_ledger_id       = $request->asset_dep_exp_ledger_id ?? 0;
        $data->_parent_id = $request->_parent_id ?? '';
        $data->_status = $request->_status ?? 1;
        if($request->hasFile('_image')){ 
                $_image = UserImageUpload($request->_image); 
                $data->_image = $_image;
        }
        $data->save();

        return redirect('item-category')->with('success','Information Save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemCategory  $itemCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item_inventories = \DB::table("inventories")->where('_category_id',$id)->first();
        if(empty($item_inventories)){
            ItemCategory::find($id)->delete();
            return redirect()->route('item-category.index')
                        ->with('danger','Information deleted successfully');
        }else{
             return "You Can not delete this Information Because of Refrence Data";
        }
       
    }
}
